@extends('layouts.app')
@section('title', 'Pharmacy & Inventory Desk')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Central Pharmacy &amp; Inventory Desk</h1>
    <p class="page-subtitle">Monitor medicine inventory, track near-expiry batches, receive digital prescriptions, and fulfill patient dispensations.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">{{ $totalMedicines }}</div>
        <div class="stat-label">Active Medicines</div>
        <div class="stat-sub">Formulations in catalog</div>
    </div>
    <div class="stat-card red">
        <div class="stat-val">{{ $lowStockMedicines->count() }}</div>
        <div class="stat-label">Low Stock Alerts</div>
        <div class="stat-sub">At or below reorder level</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">{{ $nearExpiryMedicines->count() }}</div>
        <div class="stat-label">Near-Expiry Batches</div>
        <div class="stat-sub">Expiring within 60 days</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">{{ $pendingPrescriptions->count() }}</div>
        <div class="stat-label">Pending Prescriptions</div>
        <div class="stat-sub">Ready for dispensing</div>
    </div>
</div>

<div class="flex items-center gap-3 mb-6 flex-wrap">
    <a href="{{ route('pharmacy.inventory') }}" class="btn btn-green">Full Medicine Inventory</a>
    <a href="{{ route('pharmacy.dispense') }}" class="btn btn-gold">Dispense Pending Prescriptions ({{ $pendingPrescriptions->count() }})</a>
</div>

{{-- Two Alert Tables --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Near Expiry Alerts --}}
    <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Near-Expiry Stock Alerts (&lt; 60 Days)</span>
            <span class="badge badge-gold">{{ $nearExpiryMedicines->count() }} Batches</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Batch</th>
                        <th>Stock</th>
                        <th>Expiry Date</th>
                        <th>Urgency</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nearExpiryMedicines as $med)
                        <tr>
                            <td>
                                <strong class="text-slate-900">{{ $med->name }}</strong>
                                <div class="text-[11px] text-gray-500">{{ $med->dosage_form }} ({{ $med->strength }})</div>
                            </td>
                            <td class="font-mono text-xs">{{ $med->batch_number }}</td>
                            <td><strong class="text-slate-900">{{ $med->stock_quantity }}</strong> {{ $med->unit }}</td>
                            <td class="text-xs text-slate-700">{{ $med->expiry_date->format('d M Y') }}</td>
                            <td>
                                @if($med->isExpired())
                                    <span class="badge badge-red">EXPIRED</span>
                                @elseif($med->expiry_date->diffInDays(now()) <= 30)
                                    <span class="badge badge-red">{{ (int)$med->expiry_date->diffInDays(now()) }}d left</span>
                                @else
                                    <span class="badge badge-yellow">{{ (int)$med->expiry_date->diffInDays(now()) }}d left</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400 text-xs">No near-expiry batches detected.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Low Stock Alerts --}}
    <div class="bg-white border border-gray-200 border-t-4 border-t-red-600 shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Low Stock Alerts (&le; Reorder Level)</span>
            <span class="badge badge-red">{{ $lowStockMedicines->count() }} Items</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Current Stock</th>
                        <th>Reorder Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStockMedicines as $med)
                        <tr>
                            <td>
                                <strong class="text-slate-900">{{ $med->name }}</strong>
                                <div class="text-[11px] text-gray-500">{{ $med->category }}</div>
                            </td>
                            <td>
                                <strong class="text-red-700 text-sm">{{ $med->stock_quantity }}</strong> {{ $med->unit }}
                            </td>
                            <td class="text-xs text-gray-600">{{ $med->reorder_level }} {{ $med->unit }}</td>
                            <td>
                                <form action="{{ route('pharmacy.inventory.stock', $med->id) }}" method="POST" class="flex items-center gap-1.5">
                                    @csrf
                                    <input type="hidden" name="action" value="add">
                                    <input type="number" name="adjustment" value="50" class="w-16 py-1 px-2 text-xs border border-gray-300 rounded">
                                    <button type="submit" class="btn btn-outline btn-xs">Restock</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400 text-xs">All medicine stocks are above minimum threshold.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pending Prescriptions Queue --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Prescriptions Ready for Dispensation ({{ $pendingPrescriptions->count() }})</span>
        <a href="{{ route('pharmacy.dispense') }}" class="text-xs text-emerald-200 hover:underline">Full Dispensing Counter &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rx Number</th>
                    <th>Patient Name</th>
                    <th>Prescribing Doctor</th>
                    <th>Prescribed Items</th>
                    <th>Issued At</th>
                    <th>Fulfillment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingPrescriptions as $rx)
                    <tr>
                        <td><strong class="text-[#1a6b3a] font-mono">{{ $rx->prescription_number }}</strong></td>
                        <td>
                            <strong class="text-slate-900">{{ $rx->patient->full_name }}</strong>
                            <div class="text-[11px] text-gray-500">ID: {{ $rx->patient->university_id }}</div>
                        </td>
                        <td class="text-xs text-slate-800 font-medium">{{ $rx->doctor->name }}</td>
                        <td>
                            <ul class="text-xs text-gray-700 list-disc list-inside space-y-0.5">
                                @foreach($rx->items as $item)
                                    <li>{{ $item->medicine_name }} &times; <strong>{{ $item->quantity }}</strong> ({{ $item->dosage }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-xs text-gray-500">{{ $rx->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('pharmacy.dispense.store', $rx->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-gold btn-sm">Dispense &amp; Deduct</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 text-xs">All current prescriptions have been dispensed.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
