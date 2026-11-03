@extends('layouts.app')
@section('title', 'Prescription Dispensing Desk')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Prescription Dispensing &amp; Fulfillment Counter</h1>
    <p class="page-subtitle">Verify doctor clinical orders, confirm stock availability, and dispense subsidised medicines to university members.</p>
</div>

<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden mb-6">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Prescriptions Awaiting Dispensation ({{ $prescriptions->total() }})</span>
        <a href="{{ route('pharmacy.inventory') }}" class="text-xs text-emerald-200 hover:underline">View Medicine Stock &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Prescription #</th>
                    <th>Patient Name &amp; ID</th>
                    <th>Prescribing Doctor</th>
                    <th>Items to Dispense</th>
                    <th>Stock Availability</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $rx)
                    <tr>
                        <td>
                            <strong class="text-[#1a6b3a] font-mono text-sm">{{ $rx->prescription_number }}</strong>
                            <div class="text-[11px] text-gray-500">{{ $rx->created_at->format('d M Y, h:i A') }}</div>
                        </td>
                        <td>
                            <strong class="text-slate-900">{{ $rx->patient->full_name }}</strong>
                            <div class="text-[11px] text-gray-500">{{ $rx->patient->university_id }} ({{ ucfirst($rx->patient->role_category) }})</div>
                            @if($rx->patient->allergies)
                                <div class="text-[10px] text-red-700 font-bold mt-0.5">Allergy: {{ $rx->patient->allergies }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="text-xs font-medium text-slate-800">{{ $rx->doctor->name }}</div>
                            <div class="text-[11px] text-gray-500">{{ $rx->doctor->department }}</div>
                        </td>
                        <td>
                            <div class="space-y-1 text-xs">
                                @foreach($rx->items as $item)
                                    <div class="flex items-center justify-between pb-1 border-b border-gray-100 last:border-b-0 gap-3">
                                        <span class="font-medium text-slate-800">{{ $item->medicine_name }}</span>
                                        <span class="text-[11px] text-gray-500">{{ $item->dosage }} &bull; {{ $item->duration }}</span>
                                        <span class="font-bold text-slate-900">Qty: {{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @php
                                $allInStock = true;
                                foreach($rx->items as $item) {
                                    if ($item->medicine && $item->medicine->stock_quantity < $item->quantity) {
                                        $allInStock = false;
                                        break;
                                    }
                                }
                            @endphp
                            @if($allInStock)
                                <span class="badge badge-green">In Stock</span>
                            @else
                                <span class="badge badge-red">Partial / Low Stock</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex flex-col gap-1 items-end">
                                <form action="{{ route('pharmacy.dispense.store', $rx->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-green btn-xs w-full">
                                        Dispense &amp; Deduct
                                    </button>
                                </form>
                                <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs w-full text-center">
                                    View Full Rx
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400 text-xs">
                            All pending prescriptions have been dispensed! No active orders currently waiting.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($prescriptions->hasPages())
    <div class="mb-6">
        {{ $prescriptions->links() }}
    </div>
@endif
@endsection
