@extends('layouts.app')
@section('title', 'Pharmacy & Inventory Desk')

@section('content')
{{-- Pharmacy Desk Header Ribbon --}}
<div class="bg-white border border-slate-200 rounded-lg p-6 mb-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="avatar-initials size-14 bg-gradient-to-br from-[#091e3a] to-[#0f2b48] text-white border border-[#0f766e] text-xl shadow-xs font-mono rounded">
            P
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-xl font-bold text-slate-900 font-heading">Central Pharmacy &amp; Inventory Hub</h1>
                <span class="badge badge-teal text-xs font-medium">
                    <span class="badge-dot bg-teal-500 animate-pulse"></span>
                    Dispensary Active &bull; Central Counter
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 flex items-center gap-2 flex-wrap">
                <span>Campus Dispensary</span>
                <span>&bull;</span>
                <span>Near-Expiry &amp; Stock Auto-Audited</span>
                <span>&bull;</span>
                <span>Subsidized Prescription Dispensation Desk</span>
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2.5">
        <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline btn-sm shadow-xs">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
            Full Inventory Catalog
        </a>
        <a href="{{ route('pharmacy.dispense') }}" class="btn btn-teal btn-sm shadow-sm font-bold">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Dispense Queue ({{ $pendingPrescriptions->count() }})
        </a>
    </div>
</div>

{{-- Pharmacy Stats Grid --}}
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Active Medicines</span>
            <div class="stat-icon-box stat-icon-teal">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m10.5 20.5 2-2a4.95 4.95 0 1 0-7-7l-2 2a4.95 4.95 0 0 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
            </div>
        </div>
        <div class="stat-val text-teal-700">{{ $totalMedicines }}</div>
        <div class="stat-sub">Formulations in catalog</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Low Stock Alerts</span>
            <div class="stat-icon-box stat-icon-red">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-rose-600">{{ $lowStockMedicines->count() }}</div>
        <div class="stat-sub">Below reorder threshold</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Near-Expiry Batches</span>
            <div class="stat-icon-box stat-icon-amber">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="stat-val text-amber-600">{{ $nearExpiryMedicines->count() }}</div>
        <div class="stat-sub">Expiring within 60 days</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Pending Prescriptions</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#0284c7]">{{ $pendingPrescriptions->count() }}</div>
        <div class="stat-sub">Awaiting counter fulfillment</div>
    </div>
</div>

{{-- Two Alert Tables --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Near Expiry Alerts --}}
    <div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
            <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                <svg class="size-4 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Near-Expiry Stock Alerts (&lt; 60 Days)
            </span>
            <span class="badge badge-cyan">{{ $nearExpiryMedicines->count() }} Batches</span>
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
                                <strong class="text-slate-900 text-xs">{{ $med->name }}</strong>
                                <div class="text-[11px] text-slate-500">{{ $med->dosage_form }} ({{ $med->strength }})</div>
                            </td>
                            <td class="font-mono text-xs font-semibold text-slate-700">{{ $med->batch_number }}</td>
                            <td><strong class="text-slate-900 font-mono">{{ $med->stock_quantity }}</strong> <span class="text-[11px] text-slate-500">{{ $med->unit }}</span></td>
                            <td class="text-xs text-slate-700 font-medium">{{ $med->expiry_date->format('d M Y') }}</td>
                            <td>
                                @if($med->isExpired())
                                    <span class="badge badge-red font-bold">EXPIRED</span>
                                @elseif($med->expiry_date->diffInDays(now()) <= 30)
                                    <span class="badge badge-red font-bold">{{ (int)$med->expiry_date->diffInDays(now()) }}d left</span>
                                @else
                                    <span class="badge badge-yellow font-bold">{{ (int)$med->expiry_date->diffInDays(now()) }}d left</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-slate-400 text-xs">No near-expiry batches detected.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Low Stock Alerts --}}
    <div class="bg-white border border-slate-200 border-t-4 border-t-rose-600 shadow-sm rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
            <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                <svg class="size-4 text-rose-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Low Stock Alerts (&le; Reorder Level)
            </span>
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
                                <strong class="text-slate-900 text-xs">{{ $med->name }}</strong>
                                <div class="text-[11px] text-slate-500">{{ $med->category }}</div>
                            </td>
                            <td>
                                <strong class="text-rose-600 font-mono text-sm font-bold">{{ $med->stock_quantity }}</strong> <span class="text-[11px] text-slate-500">{{ $med->unit }}</span>
                            </td>
                            <td class="text-xs text-slate-600 font-medium">{{ $med->reorder_level }} {{ $med->unit }}</td>
                            <td>
                                <form action="{{ route('pharmacy.inventory.stock', $med->id) }}" method="POST" class="flex items-center gap-1.5">
                                    @csrf
                                    <input type="hidden" name="action" value="add">
                                    <input type="number" name="adjustment" value="50" class="w-16 py-1 px-2 text-xs border border-slate-300 rounded-lg text-center font-bold">
                                    <button type="submit" class="btn btn-outline btn-xs font-bold shadow-xs">Restock</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-slate-400 text-xs">All medicine stocks are above minimum threshold.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pending Prescriptions Queue --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
        <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
            <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Prescriptions Ready for Dispensation ({{ $pendingPrescriptions->count() }})
        </span>
        <a href="{{ route('pharmacy.dispense') }}" class="text-xs text-teal-300 hover:text-white font-semibold transition-colors">Full Dispensing Counter &rarr;</a>
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
                        <td><strong class="text-teal-800 font-mono text-xs font-bold">{{ $rx->prescription_number }}</strong></td>
                        <td>
                            <strong class="text-slate-900 text-xs">{{ $rx->patient->full_name }}</strong>
                            <div class="text-[11px] text-slate-500 font-mono">ID: {{ $rx->patient->university_id }}</div>
                        </td>
                        <td class="text-xs text-slate-800 font-medium">Dr. {{ $rx->doctor->name }}</td>
                        <td>
                            <ul class="text-xs text-slate-700 list-disc list-inside space-y-0.5">
                                @foreach($rx->items as $item)
                                    <li>{{ $item->medicine_name }} &times; <strong>{{ $item->quantity }}</strong> ({{ $item->dosage }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-xs text-slate-500">{{ $rx->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('pharmacy.dispense.store', $rx->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-teal btn-sm shadow-xs font-bold">
                                    <svg class="size-3.5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                    Dispense &amp; Deduct
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-400 text-xs">All current prescriptions have been dispensed.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
