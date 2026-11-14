<?php

namespace App\Http\Controllers;

use App\Models\MedicalQueue;
use App\Models\Medicine;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PharmacyController extends Controller
{
    public function dashboard(): View
    {
        $today = Carbon::today();

        $totalMedicines = Medicine::active()->count();
        $lowStockMedicines = Medicine::active()->lowStock()->orderBy('stock_quantity')->get();
        $nearExpiryMedicines = Medicine::active()->nearExpiry(60)->orderBy('expiry_date')->get();

        $pendingPrescriptions = Prescription::with(['patient', 'doctor', 'items'])
            ->where('status', 'active')
            ->latest()
            ->get();

        $dispensedTodayCount = Prescription::where('status', 'dispensed')
            ->whereDate('dispensed_at', $today)
            ->count();

        return view('pharmacy.dashboard', compact(
            'totalMedicines',
            'lowStockMedicines',
            'nearExpiryMedicines',
            'pendingPrescriptions',
            'dispensedTodayCount'
        ));
    }

    public function inventory(Request $request): View
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('generic_name', 'like', "%{$s}%")
                    ->orWhere('batch_number', 'like', "%{$s}%")
                    ->orWhere('category', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $filter = $request->input('filter');
        if ($filter === 'low_stock') {
            $query->lowStock();
        } elseif ($filter === 'near_expiry') {
            $query->nearExpiry(45);
        } elseif ($filter === 'available') {
            $query->whereColumn('stock_quantity', '>', 'reorder_level')
                ->where('expiry_date', '>', now()->addDays(45));
        } elseif ($filter === 'out_expired' || $filter === 'expired') {
            $query->where(function ($q) {
                $q->where('stock_quantity', '<=', 0)
                    ->orWhere('expiry_date', '<', now());
            });
        }

        $medicines = $query->orderBy('name')->paginate(15)->withQueryString();
        $categories = Medicine::select('category')->distinct()->pluck('category');

        // Operational Overview Metrics matching Reference UI
        $todayPatientsCount = MedicalQueue::whereDate('created_at', Carbon::today())->count();
        $completedConsultationsCount = Prescription::whereDate('created_at', Carbon::today())->where('status', 'dispensed')->count();
        if ($completedConsultationsCount === 0) {
            $completedConsultationsCount = Prescription::whereDate('created_at', Carbon::today())->count();
        }
        $lowStockCount = Medicine::whereColumn('stock_quantity', '<=', 'reorder_level')->count();
        $nearExpiryCount = Medicine::where('expiry_date', '<=', Carbon::now()->addDays(45))->count();

        return view('pharmacy.inventory', compact(
            'medicines',
            'categories',
            'todayPatientsCount',
            'completedConsultationsCount',
            'lowStockCount',
            'nearExpiryCount'
        ));
    }

    public function storeMedicine(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'generic_name' => 'required|string|max:200',
            'category' => 'required|string|max:100',
            'dosage_form' => 'required|string|max:50',
            'strength' => 'required|string|max:50',
            'batch_number' => 'required|string|max:50|unique:medicines,batch_number',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit' => 'required|string|max:30',
            'expiry_date' => 'required|date',
            'manufacturer' => 'nullable|string|max:200',
            'instructions_default' => 'nullable|string|max:500',
        ]);

        Medicine::create($validated);

        return redirect()->route('pharmacy.inventory')->with('success', "Medicine {$validated['name']} (Batch {$validated['batch_number']}) added to inventory.");
    }

    public function updateStock(Request $request, Medicine $medicine): RedirectResponse
    {
        $validated = $request->validate([
            'adjustment' => 'required|integer',
            'action' => 'sometimes|in:add,set',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
        ]);

        $action = $request->input('action', 'add');

        DB::transaction(function () use ($medicine, $validated, $action) {
            $lockedMedicine = Medicine::where('id', $medicine->id)->lockForUpdate()->first();
            if ($lockedMedicine) {
                if ($action === 'add') {
                    $lockedMedicine->increment('stock_quantity', $validated['adjustment']);
                } else {
                    $lockedMedicine->update(['stock_quantity' => max(0, $validated['adjustment'])]);
                }

                $updates = [];
                if (! empty($validated['batch_number'])) {
                    $updates['batch_number'] = $validated['batch_number'];
                }
                if (! empty($validated['expiry_date'])) {
                    $updates['expiry_date'] = $validated['expiry_date'];
                }
                if (! empty($updates)) {
                    $lockedMedicine->update($updates);
                }
            }
        });

        return back()->with('success', "Stock for {$medicine->name} updated successfully to {$medicine->fresh()->stock_quantity} {$medicine->unit}.");
    }

    public function dispenseList(): View
    {
        $prescriptions = Prescription::with(['patient', 'doctor', 'items.medicine'])
            ->where('status', 'active')
            ->latest()
            ->paginate(15);

        return view('pharmacy.dispense-list', compact('prescriptions'));
    }

    public function dispense(Prescription $prescription): RedirectResponse
    {
        if ($prescription->status === 'dispensed') {
            return redirect()->route('pharmacy.dispense')->with('info', "Prescription {$prescription->prescription_number} has already been dispensed.");
        }

        DB::transaction(function () use ($prescription) {
            $lockedPrescription = Prescription::where('id', $prescription->id)->lockForUpdate()->first();
            if (! $lockedPrescription || $lockedPrescription->status === 'dispensed') {
                return;
            }

            foreach ($lockedPrescription->items as $item) {
                if ($item->medicine_id) {
                    $med = Medicine::where('id', $item->medicine_id)->lockForUpdate()->first();
                    if ($med) {
                        $deduct = min($med->stock_quantity, $item->quantity);
                        $med->decrement('stock_quantity', $deduct);
                    }
                }
                $item->update(['is_dispensed' => true]);
            }

            $lockedPrescription->update([
                'status' => 'dispensed',
                'dispensed_at' => Carbon::now(),
                'dispensed_by' => auth()->id(),
            ]);
        });

        return redirect()->route('pharmacy.dispense')->with('success', "Prescription {$prescription->prescription_number} dispensed successfully. Medicine inventory updated.");
    }
}
