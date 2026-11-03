@extends('layouts.app')
@section('title', 'Medicine Inventory Management')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Medicine Inventory Control &amp; Stock Monitoring</h1>
    <p class="page-subtitle">Central Pharmacy stock records, batch numbers, manufacturer details, expiry tracking, and restock controls.</p>
</div>

{{-- Top Controls --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form action="{{ route('pharmacy.inventory') }}" method="GET" class="flex flex-wrap items-center gap-2">
        <input type="text" name="search" class="form-control w-56 text-xs" placeholder="Search name, generic, batch..." value="{{ request('search') }}">
        <select name="category" class="form-control w-44 text-xs">
            <option value="">&mdash; All Categories &mdash;</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="filter" class="form-control w-44 text-xs">
            <option value="">&mdash; All Stock Status &mdash;</option>
            <option value="low_stock" {{ request('filter') === 'low_stock' ? 'selected' : '' }}>Low Stock Only</option>
            <option value="near_expiry" {{ request('filter') === 'near_expiry' ? 'selected' : '' }}>Near Expiry (&lt; 60d)</option>
        </select>
        <button type="submit" class="btn btn-green btn-sm">Filter</button>
        @if(request()->hasAny(['search', 'category', 'filter']))
            <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline btn-sm">Clear</a>
        @endif
    </form>

    <button type="button" onclick="document.getElementById('newMedicineCard').scrollIntoView({behavior:'smooth'})" class="btn btn-gold btn-sm">
        + Add New Medicine Batch
    </button>
</div>

{{-- Inventory Table --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden mb-6">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Pharmacy Stock Catalog ({{ $medicines->total() }})</span>
        <span class="text-xs text-emerald-200 font-normal">Page {{ $medicines->currentPage() }} of {{ $medicines->lastPage() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Medicine &amp; Strength</th>
                    <th>Generic Name</th>
                    <th>Category</th>
                    <th>Batch #</th>
                    <th>Stock Level</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Restock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $med)
                    <tr>
                        <td>
                            <strong class="text-slate-900">{{ $med->name }}</strong>
                            <div class="text-[11px] text-gray-500">{{ $med->dosage_form }} ({{ $med->strength }})</div>
                        </td>
                        <td class="text-xs text-gray-700">{{ $med->generic_name ?? 'N/A' }}</td>
                        <td class="text-xs text-gray-600">{{ $med->category }}</td>
                        <td class="font-mono text-xs font-medium">{{ $med->batch_number }}</td>
                        <td>
                            <strong class="{{ $med->isLowStock() ? 'text-red-700' : 'text-slate-900' }} text-sm">{{ $med->stock_quantity }}</strong> {{ $med->unit }}
                            <div class="text-[10px] text-gray-400">Reorder at {{ $med->reorder_level }}</div>
                        </td>
                        <td class="text-xs text-slate-700">
                            {{ $med->expiry_date->format('d M Y') }}
                        </td>
                        <td>
                            @if($med->isExpired())
                                <span class="badge badge-red">Expired</span>
                            @elseif($med->isLowStock())
                                <span class="badge badge-red">Low Stock</span>
                            @elseif($med->isNearExpiry())
                                <span class="badge badge-yellow">Near Expiry</span>
                            @else
                                <span class="badge badge-green">In Stock</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('pharmacy.inventory.stock', $med->id) }}" method="POST" class="flex items-center gap-1.5">
                                @csrf
                                <input type="hidden" name="action" value="add">
                                <input type="number" name="adjustment" value="50" class="w-16 py-1 px-2 text-xs border border-gray-300 rounded">
                                <button type="submit" class="btn btn-outline btn-xs">+Add</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400 text-xs">No medicines matched your search criteria.</td>
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

{{-- Add New Medicine Batch Form --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden" id="newMedicineCard">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Register New Medicine / Stock Batch</span>
        <span class="badge badge-gold">Catalog Entry</span>
    </div>
    <div class="p-5 sm:p-6">
        <form action="{{ route('pharmacy.inventory.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Brand / Trade Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Paracetamol 500mg" required>
                </div>
                <div>
                    <label class="form-label">Generic Name <span class="req">*</span></label>
                    <input type="text" name="generic_name" class="form-control" placeholder="e.g. Acetaminophen" required>
                </div>
                <div>
                    <label class="form-label">Category <span class="req">*</span></label>
                    <input type="text" name="category" class="form-control" placeholder="e.g. Analgesic, Antibiotic, Antacid" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Dosage Form <span class="req">*</span></label>
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
                    <label class="form-label">Strength <span class="req">*</span></label>
                    <input type="text" name="strength" class="form-control" placeholder="e.g. 500mg, 10mg" required>
                </div>
                <div>
                    <label class="form-label">Batch Number <span class="req">*</span></label>
                    <input type="text" name="batch_number" class="form-control" placeholder="e.g. BCH-2026-99" required>
                </div>
                <div>
                    <label class="form-label">Expiry Date <span class="req">*</span></label>
                    <input type="date" name="expiry_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Initial Stock Quantity <span class="req">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control" min="0" value="100" required>
                </div>
                <div>
                    <label class="form-label">Reorder Alert Level <span class="req">*</span></label>
                    <input type="number" name="reorder_level" class="form-control" min="0" value="25" required>
                </div>
                <div>
                    <label class="form-label">Unit of Measure <span class="req">*</span></label>
                    <input type="text" name="unit" class="form-control" value="tablets" placeholder="tablets, bottles" required>
                </div>
                <div>
                    <label class="form-label">Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control" placeholder="e.g. Square, Beximco">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="btn btn-green">Save Medicine to Inventory &rarr;</button>
            </div>
        </form>
    </div>
</div>
@endsection
