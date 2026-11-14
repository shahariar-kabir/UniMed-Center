@extends('layouts.app')
@section('title', 'Prescription Dispensing Desk')

@section('content')
{{-- Pharmacy Dispensing Header --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-2xl p-6 mb-6 shadow-sm border-b-4 border-[#0d9488] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-2xl bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0">
            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-gold text-[11px]">Pharmacy Dispensing Counter</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-semibold border border-emerald-400/30">
                    <span class="badge-dot bg-emerald-400"></span>
                    <span>Live Dispensation Counter</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-white">Prescription Fulfillment Desk</h1>
            <p class="text-xs text-teal-100/80">Verify doctor clinical orders, audit stock availability, and dispense subsidised campus medicines.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline-white btn-sm flex items-center gap-1.5">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
            <span>Stock Inventory &rarr;</span>
        </a>
    </div>
</div>

{{-- Prescriptions Table --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Prescriptions Awaiting Dispensation</span>
                <span class="text-[11px] text-teal-200/80">{{ $prescriptions->total() }} Active Doctor Orders</span>
            </div>
        </div>
        <span class="badge badge-gold text-[11px]">{{ $prescriptions->total() }} In Queue</span>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-28">Prescription #</th>
                    <th>Patient Name &amp; ID</th>
                    <th>Prescribing Doctor</th>
                    <th>Items to Dispense</th>
                    <th>Stock Status</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $rx)
                    @php
                        $allInStock = true;
                        foreach($rx->items as $item) {
                            if ($item->medicine && $item->medicine->stock_quantity < $item->quantity) {
                                $allInStock = false;
                                break;
                            }
                        }
                    @endphp
                    <tr>
                        <td>
                            <div class="space-y-1">
                                <span class="font-mono font-bold text-xs text-[#091e3a] bg-slate-100 px-2 py-1 rounded border border-slate-200 block w-fit">
                                    {{ $rx->prescription_number }}
                                </span>
                                <div class="text-[11px] text-slate-500 font-mono">{{ $rx->created_at->format('d M, h:i A') }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="size-9 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300 text-[#091e3a] flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($rx->patient->first_name ?? $rx->patient->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-slate-900 block text-xs sm:text-sm font-bold">{{ $rx->patient->full_name }}</strong>
                                    <span class="text-[11px] text-slate-500 font-mono">{{ $rx->patient->university_id }} &bull; {{ ucfirst($rx->patient->role_category) }}</span>
                                    @if($rx->patient->allergies)
                                        <div class="inline-flex items-center gap-1 text-[10px] text-red-700 font-bold bg-red-50 px-1.5 py-0.5 rounded border border-red-200 mt-0.5">
                                            <span>Allergy: {{ $rx->patient->allergies }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong class="text-xs text-slate-800 block">Dr. {{ $rx->doctor->name }}</strong>
                            <span class="text-[11px] text-slate-500">{{ $rx->doctor->department ?? 'General Medicine' }}</span>
                        </td>
                        <td class="max-w-xs">
                            <div class="space-y-1.5 text-xs">
                                @foreach($rx->items as $item)
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between gap-2">
                                        <div>
                                            <span class="font-bold text-slate-900 block">{{ $item->medicine_name }}</span>
                                            <span class="text-[11px] text-slate-500 font-mono">{{ $item->dosage }} &bull; {{ $item->duration }}</span>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="font-mono font-bold text-xs text-teal-900 bg-teal-50 px-2 py-0.5 rounded border border-teal-200">
                                                Qty: {{ $item->quantity }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @if($allInStock)
                                <span class="badge badge-green inline-flex items-center gap-1 text-[11px]">
                                    <span class="badge-dot bg-emerald-500"></span>
                                    <span>Full Stock Available</span>
                                </span>
                            @else
                                <span class="badge badge-red inline-flex items-center gap-1 text-[11px]">
                                    <span class="badge-dot bg-red-600 animate-pulse"></span>
                                    <span>Partial / Low Stock</span>
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex flex-col gap-1.5 items-end">
                                <form action="{{ route('pharmacy.dispense.store', $rx->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-green btn-xs flex items-center gap-1 w-36 justify-center shadow-xs">
                                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        <span>Dispense &amp; Deduct</span>
                                    </button>
                                </form>
                                <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs w-36 text-center justify-center">
                                    View Full Rx &rarr;
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 bg-slate-50/50">
                            <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-3">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                            <div class="text-sm font-bold text-slate-800">All Prescriptions Dispensed</div>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">There are currently no outstanding prescription orders waiting at the counter.</p>
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
