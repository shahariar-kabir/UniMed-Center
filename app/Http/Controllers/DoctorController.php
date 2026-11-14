<?php

namespace App\Http\Controllers;

use App\Models\MedicalQueue;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function dashboard(): View
    {
        $doctor = Auth::user();

        $todayQueues = MedicalQueue::with('patient')
            ->today()
            ->forDoctor($doctor)
            ->ordered()
            ->get();

        $activePatientQueue = $todayQueues->where('status', 'in_consultation')->first();
        $waitingCount = $todayQueues->where('status', 'waiting')->count();
        $completedTodayCount = $todayQueues->where('status', 'completed')->count();

        $recentPrescriptions = Prescription::with(['patient', 'items'])
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->take(6)
            ->get();

        return view('doctor.dashboard', compact(
            'doctor',
            'todayQueues',
            'activePatientQueue',
            'waitingCount',
            'completedTodayCount',
            'recentPrescriptions'
        ));
    }

    public function queue(): View
    {
        $doctor = Auth::user();

        $todayQueues = MedicalQueue::with(['patient', 'appointment'])
            ->today()
            ->forDoctor($doctor)
            ->ordered()
            ->get();

        return view('doctor.queue', compact('doctor', 'todayQueues'));
    }

    public function callPatient(MedicalQueue $queue): RedirectResponse
    {
        $doctor = Auth::user();

        DB::transaction(function () use ($doctor, $queue) {
            MedicalQueue::where('doctor_id', $doctor->id)
                ->today()
                ->where('status', 'in_consultation')
                ->where('id', '!=', $queue->id)
                ->update(['status' => 'completed', 'completed_at' => Carbon::now()]);

            $queue->update([
                'doctor_id' => $doctor->id,
                'status' => 'in_consultation',
                'called_at' => Carbon::now(),
            ]);
        });

        return redirect()->route('doctor.prescriptions.create', ['queue_id' => $queue->id, 'patient_id' => $queue->patient_id])
            ->with('success', "Patient {$queue->patient->full_name} (Token {$queue->token_number}) is now in consultation.");
    }

    public function completeConsultation(MedicalQueue $queue): RedirectResponse
    {
        $queue->update([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ]);

        return redirect()->route('doctor.queue')->with('success', "Consultation for Token {$queue->token_number} marked as completed.");
    }

    public function skipPatient(MedicalQueue $queue): RedirectResponse
    {
        $queue->update(['status' => 'skipped']);

        return redirect()->route('doctor.queue')->with('info', "Token {$queue->token_number} was marked as skipped.");
    }

    public function patientHistory(Patient $patient): View
    {
        $patient->load([
            'prescriptions.doctor',
            'prescriptions.items.medicine',
            'appointments.doctor',
            'queues',
        ]);

        return view('doctor.patient-history', compact('patient'));
    }

    public function createPrescription(Request $request): View
    {
        $doctor = Auth::user();
        $selectedPatient = $request->filled('patient_id') ? Patient::find($request->input('patient_id')) : null;
        $queueId = $request->input('queue_id');
        $patients = Patient::orderBy('first_name')->get();
        $medicines = Medicine::active()->orderBy('name')->get();

        return view('doctor.prescription-create', compact('doctor', 'selectedPatient', 'queueId', 'patients', 'medicines'));
    }

    public function storePrescription(Request $request): RedirectResponse
    {
        $doctor = Auth::user();

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'queue_id' => 'nullable|exists:medical_queues,id',
            'diagnosis' => 'required|string|max:1000',
            'bp' => 'nullable|string|max:50',
            'pulse' => 'nullable|string|max:50',
            'temperature' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:50',
            'clinical_advice' => 'nullable|string|max:2000',
            'medicines' => 'required|array|min:1',
            'medicines.*.medicine_id' => 'nullable|exists:medicines,id',
            'medicines.*.medicine_name' => 'required|string|max:200',
            'medicines.*.dosage' => 'required|string|max:50',
            'medicines.*.duration' => 'required|string|max:50',
            'medicines.*.instructions' => 'nullable|string|max:200',
            'medicines.*.quantity' => 'nullable|integer|min:0',
        ]);

        $prescription = DB::transaction(function () use ($validated, $doctor) {
            $prescription = Prescription::create([
                'prescription_number' => Prescription::generateNumber(),
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $doctor->id,
                'diagnosis' => $validated['diagnosis'],
                'bp' => $validated['bp'] ?? null,
                'pulse' => $validated['pulse'] ?? null,
                'temperature' => $validated['temperature'] ?? null,
                'weight' => $validated['weight'] ?? null,
                'clinical_advice' => $validated['clinical_advice'] ?? null,
                'status' => 'active',
            ]);

            foreach ($validated['medicines'] as $medItem) {
                $quantity = (int) ($medItem['quantity'] ?? 0);
                if ($quantity < 1) {
                    // Fallback: calculate total quantity as daily doses * days
                    $dailyDoses = array_sum(array_map('floatval', explode('+', (string) $medItem['dosage'])));
                    preg_match('/(\d+)/', (string) $medItem['duration'], $matches);
                    $days = isset($matches[1]) ? (int) $matches[1] : 7;
                    $quantity = max(1, (int) ceil(($dailyDoses > 0 ? $dailyDoses : 1) * $days));
                }

                $prescription->items()->create([
                    'medicine_id' => $medItem['medicine_id'] ?? null,
                    'medicine_name' => $medItem['medicine_name'],
                    'dosage' => $medItem['dosage'],
                    'duration' => $medItem['duration'],
                    'instructions' => $medItem['instructions'] ?? null,
                    'quantity' => $quantity,
                    'is_dispensed' => false,
                ]);
            }

            if (! empty($validated['queue_id'])) {
                MedicalQueue::where('id', $validated['queue_id'])->update([
                    'status' => 'completed',
                    'completed_at' => Carbon::now(),
                ]);
            }

            return $prescription;
        });

        return redirect()->route('patient.prescriptions.show', $prescription->id)
            ->with('success', "Digital prescription {$prescription->prescription_number} generated successfully and routed to Central Pharmacy.");
    }
}
