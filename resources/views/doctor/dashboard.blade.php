@extends('layouts.app')
@section('title', 'Doctor Consultation Desk')

@section('content')
{{-- Doctor Desk Header Ribbon --}}
<div class="bg-white border border-slate-200 rounded-lg p-6 mb-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="avatar-initials size-14 bg-gradient-to-br from-[#091e3a] to-[#0f2b48] text-white border border-[#0f766e] text-xl shadow-xs font-mono rounded">
            {{ substr($doctor->name, strpos($doctor->name, ' ') ? strpos($doctor->name, ' ') + 1 : 0, 1) }}
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-xl font-bold text-slate-900 font-heading">{{ $doctor->name }}</h1>
                <span class="badge badge-teal text-xs font-medium">
                    <span class="badge-dot bg-teal-500 animate-pulse"></span>
                    On Duty &bull; Room 101
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 flex items-center gap-2 flex-wrap">
                <span class="font-semibold text-slate-700">{{ $doctor->designation ?? 'Senior Medical Officer' }}</span>
                <span>&bull;</span>
                <span>Department: <strong class="text-teal-700">{{ $doctor->department ?? 'General Medicine' }}</strong></span>
                <span>&bull;</span>
                <span>Practitioner ID: <strong class="font-mono text-slate-800">UMC-DOC-{{ str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</strong></span>
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2.5">
        <a href="{{ route('doctor.queue') }}" class="btn btn-outline btn-sm shadow-xs">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Live OPD Queue
        </a>
        <a href="{{ route('doctor.prescriptions.create') }}" class="btn btn-teal btn-sm shadow-sm">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Issue New Prescription
        </a>
    </div>
</div>

{{-- Active Patient in Consultation Card --}}
@if($activePatientQueue)
    <div class="bg-white border-2 border-[#0f766e] rounded-lg p-6 mb-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 h-24 w-24 bg-teal-500/10 rounded-bl-full pointer-events-none"></div>
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <span class="badge badge-teal text-xs font-bold uppercase tracking-wider py-1 px-3">
                    <span class="badge-dot bg-teal-600 animate-ping"></span>
                    Patient in Consultation Room 101
                </span>
                <span class="text-xs text-slate-500">Called at {{ $activePatientQueue->called_at?->format('h:i A') }}</span>
            </div>
            <span class="text-xs font-mono font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded border border-teal-200">
                Consultation in Progress
            </span>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="avatar-initials size-14 bg-gradient-to-br from-teal-50 to-teal-100 text-teal-900 border border-teal-400 font-black text-xl shadow-xs shrink-0 rounded font-mono">
                    {{ substr($activePatientQueue->patient->full_name, 0, 1) }}
                </div>
                <div>
                    <div class="text-xl font-bold text-[#091e3a] flex items-center gap-2 flex-wrap font-heading">
                        <span class="bg-[#091e3a] text-white px-2 py-0.5 rounded text-sm font-mono tracking-wider font-bold">Token #{{ $activePatientQueue->token_number }}</span>
                        <span>{{ $activePatientQueue->patient->full_name }}</span>
                    </div>
                    <div class="text-xs text-slate-600 mt-2 flex flex-wrap gap-x-3 gap-y-1.5 items-center">
                        <span>University ID: <strong class="font-mono text-slate-800">{{ $activePatientQueue->patient->university_id }}</strong></span>
                        <span class="text-slate-300">&bull;</span>
                        <span>Category: <strong>{{ ucfirst($activePatientQueue->patient->role_category) }}</strong></span>
                        <span class="text-slate-300">&bull;</span>
                        <span>Blood Group: <strong class="text-teal-700 font-bold">{{ $activePatientQueue->patient->blood_group ?? 'N/A' }}</strong></span>
                        <span class="text-slate-300">&bull;</span>
                        <span>Allergies: 
                            @if($activePatientQueue->patient->allergies)
                                <strong class="text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-200">{{ $activePatientQueue->patient->allergies }}</strong>
                            @else
                                <strong class="text-teal-700 font-medium">None reported</strong>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <a href="{{ route('doctor.patients.history', $activePatientQueue->patient_id) }}" class="btn btn-outline btn-sm shadow-xs font-semibold">
                    <svg class="size-3.5 mr-1 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Medical History
                </a>
                <a href="{{ route('doctor.prescriptions.create', ['queue_id' => $activePatientQueue->id, 'patient_id' => $activePatientQueue->patient_id]) }}" class="btn btn-teal btn-sm shadow-sm font-bold">
                    <svg class="size-3.5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Prescribe &amp; Generate Rx &rarr;
                </a>
                <form action="{{ route('doctor.queue.complete', $activePatientQueue->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm shadow-xs font-semibold">
                        <svg class="size-3.5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Finish Consultation
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- Duty Stats Grid --}}
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Patients Waiting</span>
            <div class="stat-icon-box stat-icon-amber">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $waitingCount }}</div>
        <div class="stat-sub">Active in queue outside</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Consultations Done</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#0284c7]">{{ $completedTodayCount }}</div>
        <div class="stat-sub">Attended during shift</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Prescriptions Issued</span>
            <div class="stat-icon-box stat-icon-teal">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-teal-700">{{ $recentPrescriptions->count() }}</div>
        <div class="stat-sub">Transmitted to pharmacy</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Duty Status</span>
            <div class="stat-icon-box stat-icon-green">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
        </div>
        <div class="stat-val text-emerald-600 text-2xl mt-1">ONLINE</div>
        <div class="stat-sub">OPD room 101 active</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 cols: Consultation Queue & Prescriptions --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Today's Consultation Queue &mdash; {{ $doctor->department }}
                </span>
                <a href="{{ route('doctor.queue') }}" class="text-xs text-teal-300 hover:text-white font-semibold transition-colors">Manage Full Queue &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Patient Name</th>
                            <th>ID &amp; Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayQueues as $q)
                            <tr class="{{ $q->status === 'in_consultation' ? 'bg-teal-50/40 font-semibold' : '' }}">
                                <td>
                                    <span class="font-mono text-sm font-bold text-[#091e3a] bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200">
                                        #{{ $q->token_number }}
                                    </span>
                                </td>
                                <td>
                                    <div class="font-bold text-slate-900">{{ $q->patient->full_name }}</div>
                                    <div class="text-[11px] text-slate-500">
                                        @if($q->patient->allergies)
                                            <span class="text-rose-600 font-semibold">Allergies: {{ $q->patient->allergies }}</span>
                                        @else
                                            No drug allergies
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="font-medium text-slate-800">{{ $q->patient->university_id }}</div>
                                    <div class="text-[11px] text-slate-500">{{ ucfirst($q->patient->role_category) }}</div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($q->status) {
                                            'in_consultation' => 'badge-teal font-bold',
                                            'completed' => 'badge-cyan',
                                            'waiting' => 'badge-yellow font-bold',
                                            default => 'badge-gray',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        @if($q->status === 'in_consultation')
                                            <span class="badge-dot bg-teal-500 animate-pulse"></span>
                                        @endif
                                        {{ str_replace('_', ' ', ucfirst($q->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        @if($q->status === 'waiting')
                                            <form action="{{ route('doctor.queue.call', $q->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-teal btn-xs shadow-xs font-bold">Call Patient</button>
                                            </form>
                                        @elseif($q->status === 'in_consultation')
                                            <a href="{{ route('doctor.prescriptions.create', ['queue_id' => $q->id, 'patient_id' => $q->patient_id]) }}" class="btn btn-cyan btn-xs shadow-xs font-bold">Write Rx &rarr;</a>
                                        @else
                                            <span class="text-[11px] text-slate-400 font-semibold">Completed</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-slate-400 text-xs">No patients currently in your department queue.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Recent Prescriptions Generated by You
                </span>
                <span class="badge badge-cyan">Clinical Orders</span>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Ref</th>
                            <th>Patient</th>
                            <th>Diagnosis</th>
                            <th>Medicines</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPrescriptions as $rx)
                            <tr>
                                <td class="font-mono text-xs font-bold text-teal-800">{{ $rx->prescription_number }}</td>
                                <td class="font-bold text-slate-900">{{ $rx->patient->full_name }}</td>
                                <td class="text-xs text-slate-600 max-w-[200px] truncate">{{ Str::limit($rx->diagnosis, 35) }}</td>
                                <td class="text-xs text-slate-700 font-semibold">{{ $rx->items->count() }} item(s)</td>
                                <td>
                                    <span class="badge {{ $rx->status === 'dispensed' ? 'badge-teal' : 'badge-yellow' }}">
                                        {{ ucfirst($rx->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs shadow-xs">View Rx</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 text-xs">No prescriptions issued today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 col: Quick Actions & Protocol --}}
    <div class="space-y-6">
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2 mb-3.5 flex items-center gap-2 font-heading">
                <svg class="size-4 text-[#0f766e]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Clinical Quick Actions
            </h3>
            <div class="space-y-2.5">
                <a href="{{ route('doctor.prescriptions.create') }}" class="btn btn-teal w-full text-center shadow-xs">
                    <svg class="size-3.5 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Generate Digital Prescription
                </a>
                <a href="{{ route('doctor.queue') }}" class="btn btn-outline w-full text-center shadow-xs">
                    <svg class="size-3.5 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Open Full Queue Desk
                </a>
                <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline w-full text-center shadow-xs">
                    <svg class="size-3.5 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
                    Check Central Stock
                </a>
            </div>
        </div>

        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-lg p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2 mb-3 flex items-center gap-2">
                <svg class="size-4 text-[#0284c7]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Consultation Protocol
            </h3>
            <ul class="space-y-2.5 text-xs text-slate-600 leading-relaxed">
                <li class="flex items-start gap-2">
                    <span class="size-1.5 rounded-full bg-teal-500 mt-1.5 shrink-0"></span>
                    <span>Verify student/staff identity and clinical drug allergies prior to prescribing.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="size-1.5 rounded-full bg-teal-500 mt-1.5 shrink-0"></span>
                    <span>Digital prescriptions route instantly to Central Pharmacy for subsidized dispensing.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="size-1.5 rounded-full bg-teal-500 mt-1.5 shrink-0"></span>
                    <span>Standard dosage convention (<code class="bg-slate-100 px-1 py-0.5 rounded font-mono font-bold text-slate-800">1+0+1</code>) automatically computes dispensing quantities.</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
