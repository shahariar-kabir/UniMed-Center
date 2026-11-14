@extends('layouts.app')
@section('title', 'Patient Medical History - ' . $patient->full_name)

@section('content')
{{-- Patient Medical Record Header --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-2xl p-6 mb-6 shadow-sm border-b-4 border-[#0d9488] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-2xl bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0">
            {{ strtoupper(substr($patient->first_name ?? $patient->full_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name ?? '', 0, 1)) }}
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-gold text-[11px] font-mono">{{ $patient->university_id }}</span>
                <span class="badge badge-cyan text-[11px]">{{ ucfirst($patient->role_category) }}</span>
                @if($patient->blood_group)
                    <span class="badge badge-red text-[11px]">Blood: {{ $patient->blood_group }}</span>
                @endif
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-white">{{ $patient->full_name }}</h1>
            <p class="text-xs text-teal-100/80">Department: {{ $patient->department ?? 'General' }} &bull; Age: {{ $patient->dob ? $patient->dob->age . ' yrs' : 'N/A' }} &bull; Gender: {{ $patient->gender }}</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('doctor.prescriptions.create', ['patient_id' => $patient->id]) }}" class="btn btn-green btn-sm flex items-center gap-1.5 shadow-sm font-bold">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <span>Generate New Prescription</span>
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-white btn-sm flex items-center gap-1.5">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back</span>
        </a>
    </div>
</div>

{{-- Medical Alerts Banner --}}
<div class="bg-white border border-slate-200 border-l-4 border-l-red-600 rounded-2xl p-5 mb-6 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
        <div>
            <div class="flex items-center gap-1.5 text-red-700 font-bold uppercase tracking-wider text-[11px] mb-1">
                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span>Known Drug Allergies</span>
            </div>
            <p class="font-bold text-slate-800 text-xs">{{ $patient->allergies ?: 'No known drug or food allergies' }}</p>
        </div>
        <div>
            <span class="text-slate-600 font-bold uppercase tracking-wider text-[11px] block mb-1">Pre-existing Medical Conditions</span>
            <p class="text-slate-700">
                @if(!empty($patient->conditions) && is_array($patient->conditions))
                    {{ implode(', ', $patient->conditions) }}
                @else
                    None reported
                @endif
            </p>
        </div>
        <div>
            <span class="text-slate-600 font-bold uppercase tracking-wider text-[11px] block mb-1">Current Routine Medications</span>
            <p class="text-slate-700">{{ $patient->medications ?: 'None reported' }}</p>
        </div>
        <div>
            <span class="text-slate-600 font-bold uppercase tracking-wider text-[11px] block mb-1">Emergency Contact</span>
            <p class="text-slate-700 font-medium">{{ $patient->emergency_name ?? 'N/A' }} <span class="font-mono text-slate-500">({{ $patient->emergency_phone ?? 'N/A' }})</span></p>
        </div>
    </div>
</div>

{{-- Past Prescriptions History --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Past Prescriptions History</span>
                <span class="text-[11px] text-teal-200/80">{{ $patient->prescriptions->count() }} Clinical Orders Recorded</span>
            </div>
        </div>
        <span class="badge badge-gold text-[10px]">{{ $patient->prescriptions->count() }} Prescriptions</span>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-32">Rx Reference</th>
                    <th>Date Issued</th>
                    <th>Attending Doctor</th>
                    <th>Diagnosis &amp; Vitals</th>
                    <th>Prescribed Medicines</th>
                    <th>Clinical Advice</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->prescriptions as $rx)
                    <tr>
                        <td>
                            <span class="font-mono font-bold text-xs text-[#091e3a] bg-slate-100 px-2 py-0.5 rounded border border-slate-200 block w-fit">
                                {{ $rx->prescription_number }}
                            </span>
                            <div class="mt-1">
                                <span class="badge {{ $rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow' }} text-[10px]">
                                    {{ ucfirst($rx->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="text-xs text-slate-600 font-mono">{{ $rx->created_at->format('d M Y') }}</td>
                        <td class="text-xs font-medium text-slate-800">Dr. {{ $rx->doctor->name }}</td>
                        <td>
                            <strong class="text-xs text-slate-900 block">{{ $rx->diagnosis }}</strong>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                                BP: {{ $rx->bp ?: 'N/A' }} &bull; Temp: {{ $rx->temperature ?: 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <div class="space-y-1 text-xs">
                                @foreach($rx->items as $item)
                                    <div>
                                        <strong class="text-slate-900">{{ $item->medicine_name }}</strong>
                                        <span class="text-slate-500 font-mono">({{ $item->dosage }}, {{ $item->duration }})</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-xs text-slate-600 max-w-[200px] truncate">
                            {{ Str::limit($rx->clinical_advice, 60) }}
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs">Full Rx</a>
                                <a href="{{ route('patient.prescriptions.pdf', $rx->id) }}" class="btn btn-green btn-xs">PDF</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 bg-slate-50/50">
                            <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-2.5">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div class="text-xs font-bold text-slate-800">No Past Prescriptions Recorded</div>
                            <p class="text-[11px] text-slate-500 max-w-xs mx-auto mt-0.5">This patient does not have any prior digital prescriptions on record.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Past Appointments History --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Consultation &amp; Appointment Visits</span>
                <span class="text-[11px] text-teal-200/80">{{ $patient->appointments->count() }} Prior Visits</span>
            </div>
        </div>
        <span class="badge badge-gold text-[10px]">Visits</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-24">Ref #</th>
                    <th>Date &amp; Time</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Reason for Consultation</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->appointments as $apt)
                    <tr>
                        <td>
                            <span class="font-mono text-xs font-bold text-[#091e3a] bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                {{ $apt->appointment_number }}
                            </span>
                        </td>
                        <td>
                            <div class="text-xs text-slate-800 font-medium">{{ $apt->appointment_date->format('d M Y') }}</div>
                            <div class="text-[11px] font-mono font-bold text-[#0d9488]">{{ $apt->time_slot }}</div>
                        </td>
                        <td class="text-xs text-slate-900 font-semibold">{{ $apt->department }}</td>
                        <td class="text-xs text-slate-600">{{ $apt->doctor?->name ? 'Dr. ' . $apt->doctor->name : 'Attending Officer' }}</td>
                        <td class="text-xs text-slate-600">{{ $apt->reason ?: 'General health evaluation' }}</td>
                        <td class="text-right"><span class="badge badge-green">{{ ucfirst($apt->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 bg-slate-50/50">
                            <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-2.5">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            </div>
                            <div class="text-xs font-bold text-slate-800">No Previous Appointments Found</div>
                            <p class="text-[11px] text-slate-500 max-w-xs mx-auto mt-0.5">No prior appointments recorded for this patient.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
