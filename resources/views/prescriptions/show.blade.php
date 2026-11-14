@extends('layouts.app')
@section('title', 'Prescription ' . $prescription->prescription_number)

@push('styles')
<style>
    .rx-paper {
        max-width: 820px;
        margin: 1.5rem auto;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 1rem;
        padding: 2.25rem 2.5rem;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
    }
    @media print {
        body * { visibility: hidden; }
        .rx-paper, .rx-paper * { visibility: visible; }
        .rx-paper { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; padding: 0; }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="no-print max-w-[820px] mx-auto mb-4 flex items-center justify-between flex-wrap gap-3">
    <a href="javascript:history.back()" class="btn btn-outline btn-sm flex items-center gap-1.5">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        <span>Back to Portal</span>
    </a>
    <div class="flex items-center gap-2">
        <button onclick="window.print()" class="btn btn-outline btn-sm flex items-center gap-1.5">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            <span>Print View</span>
        </button>
        <a href="{{ route('patient.prescriptions.pdf', $prescription->id) }}" class="btn btn-green btn-sm flex items-center gap-1.5 shadow-sm font-bold">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            <span>Download Official PDF</span>
        </a>
    </div>
</div>

<div class="rx-paper">
    {{-- Header --}}
    <div class="flex items-start justify-between pb-4 mb-4 border-b-2 border-[#091e3a]">
        <div class="flex items-center gap-3.5">
            <div class="size-12 rounded-xl bg-[#091e3a] text-white flex items-center justify-center font-black text-lg border-2 border-[#0d9488] shadow-xs">
                UMC
            </div>
            <div>
                <h2 class="text-xl font-black text-[#091e3a] tracking-tight">University Medical Centre</h2>
                <p class="text-xs text-slate-600 mt-0.5">Clinical Services &amp; Health Division &bull; Central Campus, Dhaka</p>
                <p class="text-[11px] text-slate-500">Central Pharmacy &bull; 24/7 Emergency Shifts &bull; Medical Hotline: <strong>01888-888888</strong></p>
            </div>
        </div>
        <div class="text-right">
            <span class="font-mono font-black text-base text-[#091e3a] block">{{ $prescription->prescription_number }}</span>
            <span class="text-xs text-slate-500 font-mono">Issued: {{ $prescription->created_at->format('d M Y, h:i A') }}</span>
            <div class="mt-1">
                <span class="badge {{ $prescription->status === 'dispensed' ? 'badge-green' : 'badge-yellow' }} text-[10px]">
                    {{ $prescription->status === 'dispensed' ? 'Dispensed at Pharmacy' : 'Active Prescription' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Doctor & Patient Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200 mb-4 text-xs">
        <div>
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#0d9488] pb-1 mb-2 border-b border-slate-200">Patient Information</div>
            <div class="space-y-1">
                <div>Name: <strong class="text-slate-900">{{ $prescription->patient->full_name }}</strong></div>
                <div>University ID: <strong class="font-mono text-[#091e3a]">{{ $prescription->patient->university_id }}</strong></div>
                <div>Age / Gender: <span class="text-slate-700">{{ $prescription->patient->dob ? $prescription->patient->dob->age . ' yrs' : 'N/A' }} / {{ $prescription->patient->gender }}</span></div>
                <div>Blood Group: <strong class="text-slate-900">{{ $prescription->patient->blood_group ?: 'Not Set' }}</strong></div>
                <div>
                    Allergies:
                    @if($prescription->patient->allergies)
                        <span class="font-bold text-red-700">{{ $prescription->patient->allergies }}</span>
                    @else
                        <span class="text-emerald-700 font-medium">None reported</span>
                    @endif
                </div>
            </div>
        </div>
        <div>
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#0d9488] pb-1 mb-2 border-b border-slate-200">Attending Physician</div>
            <div class="space-y-1">
                <div>Doctor: <strong class="text-slate-900">Dr. {{ $prescription->doctor->name }}</strong></div>
                <div>Designation: <span class="text-slate-700">{{ $prescription->doctor->designation ?? 'Senior Medical Officer' }}</span></div>
                <div>Department: <span class="text-slate-700">{{ $prescription->doctor->department ?? 'General Medicine' }}</span></div>
                <div>Practitioner ID: <span class="font-mono text-slate-700">UMC-DOC-{{ str_pad($prescription->doctor->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                <div>Emergency Desk: <span class="text-emerald-700 font-semibold">Active OPD Session</span></div>
            </div>
        </div>
    </div>

    {{-- Vitals Strip --}}
    <div class="flex items-center gap-4 flex-wrap p-3 rounded-xl bg-sky-50/70 border border-sky-200 mb-4 text-xs text-sky-950 font-medium">
        <span class="font-bold uppercase tracking-wider text-sky-800 text-[10px]">Patient Vitals:</span>
        <div>BP: <strong class="font-mono text-slate-900">{{ $prescription->bp ?: '120/80 mmHg' }}</strong></div>
        <div>Pulse: <strong class="font-mono text-slate-900">{{ $prescription->pulse ?: '74 bpm' }}</strong></div>
        <div>Temp: <strong class="font-mono text-slate-900">{{ $prescription->temperature ?: '98.6' }}&deg;F</strong></div>
        <div>Weight: <strong class="font-mono text-slate-900">{{ $prescription->weight ?: '68' }} kg</strong></div>
    </div>

    {{-- Clinical Diagnosis --}}
    <div class="p-3.5 rounded-xl bg-teal-50/60 border-l-4 border-l-[#0d9488] border border-teal-200 mb-4">
        <div class="text-[10px] font-bold uppercase tracking-wider text-[#0d9488] mb-0.5">Clinical Diagnosis</div>
        <div class="text-sm font-bold text-slate-900">{{ $prescription->diagnosis }}</div>
    </div>

    {{-- Rx Symbol --}}
    <div class="my-3">
        <span class="font-serif text-3xl font-bold text-[#091e3a]">R<sub class="text-xl italic relative top-1">x</sub></span>
    </div>

    {{-- Medicines Table --}}
    <div class="overflow-x-auto rounded-xl border border-slate-200 mb-4">
        <table class="w-full text-xs">
            <thead>
                <tr class="bg-[#091e3a] text-white">
                    <th class="py-2 px-3 text-left w-8">#</th>
                    <th class="py-2 px-3 text-left">Medicine &amp; Formulation</th>
                    <th class="py-2 px-3 text-center w-24">Dosage Pattern</th>
                    <th class="py-2 px-3 text-center w-24">Duration</th>
                    <th class="py-2 px-3 text-left">Instructions</th>
                    <th class="py-2 px-3 text-center w-24">Total Qty</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($prescription->items as $idx => $item)
                    <tr class="{{ $idx % 2 === 0 ? 'bg-white' : 'bg-slate-50/60' }}">
                        <td class="py-2.5 px-3 font-bold text-slate-400">{{ $idx + 1 }}</td>
                        <td class="py-2.5 px-3">
                            <strong class="text-slate-900 text-xs sm:text-sm block">{{ $item->medicine_name }}</strong>
                            @if($item->medicine)
                                <div class="text-[11px] text-slate-500">{{ $item->medicine->generic_name }} ({{ $item->medicine->strength }})</div>
                            @endif
                        </td>
                        <td class="py-2.5 px-3 text-center">
                            <span class="badge badge-gold font-mono text-[11px]">{{ $item->dosage }}</span>
                        </td>
                        <td class="py-2.5 px-3 text-center font-medium text-slate-700">{{ $item->duration }}</td>
                        <td class="py-2.5 px-3 text-slate-600">{{ $item->instructions ?: 'As directed by physician' }}</td>
                        <td class="py-2.5 px-3 text-center font-mono font-bold text-slate-900">{{ $item->quantity }} {{ $item->medicine?->unit ?? 'units' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Clinical Advice --}}
    @if($prescription->clinical_advice)
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 mb-6">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#0d9488] mb-1">Clinical Advice &amp; Instructions</div>
            <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line">{{ $prescription->clinical_advice }}</div>
        </div>
    @endif

    {{-- Footer & Verification --}}
    <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div class="text-[11px] text-slate-500 max-w-sm space-y-1">
            <div class="font-bold text-[#091e3a] uppercase tracking-wide">Electronically Verified Prescription</div>
            <p>Subsidized medicines can be collected directly from the Central Pharmacy counter with this digital record.</p>
            <div class="font-mono text-[10px] text-slate-400 pt-1">Ref ID: {{ $prescription->prescription_number }} &bull; Printed: {{ date('d M Y, h:i A') }}</div>
        </div>
        <div class="text-right">
            <div class="inline-block text-center w-52">
                <div class="font-serif italic font-bold text-xl text-[#091e3a] mb-1">
                    Dr. {{ $prescription->doctor->name }}
                </div>
                <div class="border-t-2 border-[#091e3a] pt-1 text-xs">
                    <strong class="text-slate-900 block">Dr. {{ $prescription->doctor->name }}</strong>
                    <span class="text-[11px] text-slate-600 block">{{ $prescription->doctor->designation ?? 'Senior Medical Officer' }}</span>
                    <span class="text-[10px] text-slate-400 block">Dept. of {{ $prescription->doctor->department ?? 'General Medicine' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
