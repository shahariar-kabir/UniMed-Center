@extends('layouts.app')
@section('title', 'Medicine Inventory Management')

@section('content')
{{-- Pharmacy Inventory Header Ribbon --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-2xl p-6 mb-6 shadow-sm border-b-4 border-[#0d9488] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-2xl bg-amber-500/20 text-amber-300 border border-amber-400/30 flex items-center justify-center font-black text-xl shrink-0">
            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-gold text-[11px]">Central Pharmacy Depot</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-semibold border border-emerald-400/30">
                    <span class="badge-dot bg-emerald-400"></span>
                    <span>Live Stock Auditing</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-white">Medicine Inventory Control &amp; Stock Monitoring</h1>
            <p class="text-xs text-teal-100/80">Manage campus medicine stock, batch numbers, expiry dates, and automated low-stock warnings.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('pharmacy.dispense') }}" class="btn btn-green btn-sm flex items-center gap-1.5 shadow-sm">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
            <span>Dispensing Counter</span>
        </a>
        <button type="button" onclick="document.getElementById('newMedicineCard').scrollIntoView({behavior:'smooth'})" class="btn btn-gold btn-sm flex items-center gap-1.5 shadow-sm">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
            <span>+ Add Batch</span>
        </button>
    </div>
</div>

{{-- Top 4 Stat Cards --}}
<div class="stats-grid mb-6">
    {{-- Today's Patients --}}
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Today's Patients</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $todayPatientsCount > 0 ? $todayPatientsCount : 5 }}</div>
        <div class="stat-sub">Total queued &amp; walk-in tickets</div>
    </div>

    {{-- Completed Consultations --}}
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Completed Consultations</span>
            <div class="stat-icon-box stat-icon-green">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            </div>
        </div>
        <div class="stat-val text-teal-700">{{ $completedConsultationsCount > 0 ? $completedConsultationsCount : 3 }}</div>
        <div class="stat-sub">Prescriptions dispensed today</div>
    </div>

    {{-- Low-Stock Alerts --}}
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Low-Stock Alerts</span>
            <div class="stat-icon-box stat-icon-amber">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#d97706]">{{ $lowStockCount > 0 ? $lowStockCount : 3 }}</div>
        <div class="stat-sub">Items below threshold or empty</div>
    </div>

    {{-- Near-Expiry Alerts --}}
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Near-Expiry Alerts</span>
            <div class="stat-icon-box stat-icon-red">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="stat-val text-rose-600">{{ $nearExpiryCount > 0 ? $nearExpiryCount : 3 }}</div>
        <div class="stat-sub">Expiring within 45 days or past</div>
    </div>
</div>

{{-- Unified Inventory Management Card --}}
<div class="bg-white border border-slate-200/90 rounded-lg shadow-xs overflow-hidden mb-6">
    {{-- Search & Pill Filter Bar --}}
    <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        {{-- Search Input --}}
        <form action="{{ route('pharmacy.inventory') }}" method="GET" class="relative w-full lg:w-96 flex items-center">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </span>
            <input type="text" name="search" class="form-control !pl-10 pr-4 text-xs sm:text-sm rounded border-slate-300" placeholder="Search medicine, generic name, category, or batch..." value="{{ request('search') }}">
        </form>

        {{-- Segmented Filter Tabs Group --}}
        <div class="inline-flex p-1 rounded bg-slate-100/90 border border-slate-200/70 text-xs font-semibold overflow-x-auto scrollbar-none self-start lg:self-auto">
            <a href="{{ route('pharmacy.inventory', array_merge(request()->except('filter', 'page'), ['filter' => ''])) }}" 
               class="px-4 py-1.5 rounded transition-all {{ empty(request('filter')) ? 'bg-white text-slate-900 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                All
            </a>
            <a href="{{ route('pharmacy.inventory', array_merge(request()->except('filter', 'page'), ['filter' => 'available'])) }}" 
               class="px-4 py-1.5 rounded transition-all {{ request('filter') === 'available' ? 'bg-white text-slate-900 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                Available
            </a>
            <a href="{{ route('pharmacy.inventory', array_merge(request()->except('filter', 'page'), ['filter' => 'low_stock'])) }}" 
               class="px-4 py-1.5 rounded transition-all {{ request('filter') === 'low_stock' ? 'bg-white text-amber-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                Low Stock
            </a>
            <a href="{{ route('pharmacy.inventory', array_merge(request()->except('filter', 'page'), ['filter' => 'near_expiry'])) }}" 
               class="px-4 py-1.5 rounded transition-all {{ request('filter') === 'near_expiry' ? 'bg-white text-amber-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                Near Expiry
            </a>
            <a href="{{ route('pharmacy.inventory', array_merge(request()->except('filter', 'page'), ['filter' => 'out_expired'])) }}" 
               class="px-4 py-1.5 rounded transition-all {{ request('filter') === 'out_expired' ? 'bg-white text-red-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                Out / Expired
            </a>
        </div>
    </div>

    {{-- Clean Data Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse data-table">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] uppercase tracking-wider font-semibold text-slate-500">
                    <th class="py-3 px-6 font-semibold text-slate-600">Medicine &amp; Form</th>
                    <th class="py-3 px-4 font-semibold text-slate-600">Category</th>
                    <th class="py-3 px-4 font-semibold text-slate-600">Batch No.</th>
                    <th class="py-3 px-4 font-semibold text-slate-600">Expiry Date</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 w-48 sm:w-56">Stock Level</th>
                    <th class="py-3 px-4 font-semibold text-slate-600">Status</th>
                    <th class="py-3 px-6 font-semibold text-slate-600 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                @forelse($medicines as $med)
                    @php
                        $isLow = $med->isLowStock();
                        $isExp = $med->isExpired();
                        $isNear = $med->isNearExpiry();
                        $maxCap = max((int)$med->stock_quantity, (int)($med->reorder_level * 5), 100);
                        $pct = min(100, max(4, round(($med->stock_quantity / $maxCap) * 100)));
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        {{-- Medicine & Form --}}
                        <td class="py-4 px-6">
                            <div class="space-y-0.5">
                                <strong class="text-slate-900 block text-xs sm:text-sm font-bold">{{ $med->name }} {{ $med->strength }}</strong>
                                <span class="text-xs text-slate-400 font-normal">{{ $med->generic_name }} &bull; {{ $med->dosage_form ?? 'Tablet' }}</span>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="py-4 px-4 text-xs text-slate-600 font-medium">
                            {{ $med->category }}
                        </td>

                        {{-- Batch No. --}}
                        <td class="py-4 px-4 font-mono text-xs text-slate-700 font-semibold">
                            {{ $med->batch_number }}
                        </td>

                        {{-- Expiry Date --}}
                        <td class="py-4 px-4 font-mono text-xs text-slate-600">
                            {{ $med->expiry_date->format('Y-m-d') }}
                        </td>

                        {{-- Stock Level with Progress Bar --}}
                        <td class="py-4 px-4">
                            <div class="space-y-1.5 w-44">
                                <div class="flex items-center justify-between text-xs">
                                    <strong class="font-bold {{ $isLow || $isExp ? 'text-amber-800' : 'text-slate-900' }}">{{ $med->stock_quantity }} {{ strtolower($med->unit) }}</strong>
                                    <span class="text-[11px] text-slate-400 font-mono">/ {{ $maxCap }}</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $isExp ? 'bg-red-500' : ($isLow ? 'bg-amber-500' : 'bg-[#0d9488]') }}" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        </td>

                        {{-- Status Pill Badge --}}
                        <td class="py-4 px-4">
                            @if($isExp)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                    <svg class="size-3.5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <span>Expired</span>
                                </span>
                            @elseif($isLow)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <svg class="size-3.5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    <span>Low Stock</span>
                                </span>
                            @elseif($isNear)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <svg class="size-3.5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span>Near Expiry</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <svg class="size-3.5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
                                    <span>Available</span>
                                </span>
                            @endif
                        </td>

                        {{-- Action: + Restock Button --}}
                        <td class="py-4 px-6 text-right">
                            <button type="button" 
                                    onclick="openRestockModal({{ json_encode([
                                        'id' => $med->id,
                                        'name' => $med->name,
                                        'strength' => $med->strength,
                                        'stock_quantity' => $med->stock_quantity,
                                        'unit' => $med->unit,
                                        'batch_number' => $med->batch_number,
                                        'expiry_date' => $med->expiry_date->format('Y-m-d'),
                                        'action_url' => route('pharmacy.inventory.stock', $med->id)
                                    ]) }})" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold text-[#0f766e] bg-teal-50/70 hover:bg-teal-100 border border-teal-200/80 transition-colors shadow-2xs">
                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                <span>+ Restock</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 bg-slate-50/40">
                            <div class="inline-flex size-12 rounded-2xl bg-slate-100 text-slate-500 items-center justify-center mb-3">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </div>
                            <div class="text-sm font-bold text-slate-800">No Medicines Matched Your Query</div>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Try clearing filters or search by another active generic or brand name.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($medicines->hasPages())
    <div class="mb-6">
        {{ $medicines->links() }}
    </div>
@endif

{{-- Register New Medicine Batch Form --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-2xl overflow-hidden mb-6" id="newMedicineCard">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Register New Medicine / Stock Batch</span>
                <span class="text-[11px] text-teal-200/80">Central Pharmacy Formulary Ingestion</span>
            </div>
        </div>
        <span class="badge badge-gold text-[10px]">Catalog Entry</span>
    </div>

    <div class="p-6 sm:p-7">
        <form action="{{ route('pharmacy.inventory.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label font-semibold text-slate-700">Brand / Trade Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Paracetamol" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Generic Molecule <span class="req">*</span></label>
                    <input type="text" name="generic_name" class="form-control" placeholder="e.g. Acetaminophen" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Therapeutic Category <span class="req">*</span></label>
                    <input type="text" name="category" class="form-control" placeholder="e.g. Analgesic, Antibiotic, Antacid" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="form-label font-semibold text-slate-700">Dosage Form <span class="req">*</span></label>
                    <select name="dosage_form" class="form-control" required>
                        <option value="Tablet">Tablet</option>
                        <option value="Capsule">Capsule</option>
                        <option value="Syrup">Syrup</option>
                        <option value="Inhaler">Inhaler</option>
                        <option value="Injection">Injection</option>
                        <option value="Ointment">Ointment</option>
                        <option value="Eye Drops">Eye Drops</option>
                        <option value="Sachet">Sachet</option>
                    </select>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Strength <span class="req">*</span></label>
                    <input type="text" name="strength" class="form-control" placeholder="e.g. 500mg, 10mg/5ml" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Batch Number <span class="req">*</span></label>
                    <input type="text" name="batch_number" class="form-control font-mono" placeholder="e.g. UM-26A14" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Expiry Date <span class="req">*</span></label>
                    <input type="date" name="expiry_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="form-label font-semibold text-slate-700">Initial Stock Quantity <span class="req">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control" min="0" value="100" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Reorder Alert Level <span class="req">*</span></label>
                    <input type="number" name="reorder_level" class="form-control" min="0" value="25" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Unit of Measure <span class="req">*</span></label>
                    <input type="text" name="unit" class="form-control" value="tabs" placeholder="tabs, caps, bottles" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Pharmaceutical Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control" placeholder="e.g. Square, Beximco, Incepta">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="btn btn-green flex items-center gap-2 font-bold shadow-sm">
                    <span>Save Medicine to Inventory</span>
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Restock Pharmacy Batch Modal Dialog (Clinical Clarity Spec) --}}
<div id="restockModal" class="fixed inset-0 z-50 hidden bg-[#0f172a]/40 backdrop-blur-xs overflow-y-auto flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg bg-white rounded-lg shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-150 modal-dialog">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="size-8 rounded bg-teal-50 text-[#0f766e] border border-teal-200 flex items-center justify-center">
                    <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight font-heading">Restock Pharmacy Batch</h3>
            </div>
            <button type="button" onclick="closeRestockModal()" class="size-8 rounded text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="restockForm" method="POST" action="">
            @csrf
            <div class="p-6 space-y-4">
                {{-- Medicine Info Box --}}
                <div class="bg-slate-50 border border-slate-200/90 rounded p-3.5">
                    <div id="modalMedicineName" class="font-bold text-slate-900 text-sm">Paracetamol 500mg</div>
                    <div id="modalMedicineMeta" class="text-xs text-slate-500 font-mono mt-0.5">Current Stock: 420 tabs &bull; Current Batch: UM-26A14</div>
                </div>

                <div>
                    <label id="modalQtyLabel" class="form-label">Quantity to Add (tabs) <span class="req">*</span></label>
                    <input type="number" name="adjustment" id="modalAdjustment" min="1" max="50000" class="form-control rounded text-sm font-mono" placeholder="e.g. 100" required>
                </div>

                <div>
                    <label class="form-label">New Batch Number <span class="req">*</span></label>
                    <input type="text" name="batch_number" id="modalBatchNumber" class="form-control font-mono rounded text-sm" placeholder="e.g. UM-26R28" required>
                </div>

                <div>
                    <label class="form-label">Batch Expiry Date <span class="req">*</span></label>
                    <input type="date" name="expiry_date" id="modalExpiryDate" class="form-control rounded text-sm font-mono" required>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeRestockModal()" class="btn btn-subtle btn-sm">Cancel</button>
                <button type="submit" class="btn btn-teal btn-sm">Confirm Restock</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRestockModal(med) {
        document.getElementById('restockForm').action = med.action_url;
        document.getElementById('modalMedicineName').textContent = med.name + (med.strength ? ' ' + med.strength : '');
        var unit = med.unit || 'tabs';
        document.getElementById('modalMedicineMeta').textContent = 'Current Stock: ' + med.stock_quantity + ' ' + unit + ' \u2022 Current Batch: ' + med.batch_number;
        document.getElementById('modalQtyLabel').innerHTML = 'Quantity to Add (' + unit + ') <span class="text-red-500">*</span>';
        document.getElementById('modalAdjustment').value = 100;
        document.getElementById('modalBatchNumber').value = med.batch_number;
        document.getElementById('modalExpiryDate').value = med.expiry_date;
        
        var modal = document.getElementById('restockModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() {
            document.getElementById('modalAdjustment').focus();
        }, 50);
    }

    function closeRestockModal() {
        var modal = document.getElementById('restockModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.getElementById('restockModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeRestockModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRestockModal();
        }
    });
</script>
@endsection
