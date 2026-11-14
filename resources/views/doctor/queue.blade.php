@extends('layouts.app')
@section('title', 'Consultation Queue Management')

@section('content')
{{-- Doctor Desk Header Ribbon --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-lg p-6 mb-6 shadow-sm border-b-4 border-[#0f766e] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0 font-mono">
            {{ strtoupper(substr($doctor->name, 0, 2)) }}
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-cyan text-[11px]">Consultation Room 101</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-semibold border border-emerald-400/30">
                    <span class="badge-dot bg-emerald-400"></span>
                    <span>Live OPD Session</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-white font-heading">Dr. {{ $doctor->name }}</h1>
            <p class="text-xs text-teal-100/80">{{ $doctor->designation ?? 'Senior Medical Officer' }} &bull; Department of {{ $doctor->department ?? 'General Medicine' }}</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('doctor.prescriptions.create') }}" class="btn btn-teal btn-sm flex items-center gap-1.5 shadow-sm">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <span>Issue Direct Rx</span>
        </a>
        <a href="{{ route('doctor.queue') }}" class="btn btn-outline-white btn-sm flex items-center gap-1.5 text-white" title="Refresh queue">
            <svg class="size-4 shrink-0 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
            <span class="text-white font-medium">Sync Queue</span>
        </a>
    </div>
</div>

{{-- Queue Telemetry Grid --}}
@php
    $waitingCount = $todayQueues->where('status', 'waiting')->count();
    $inConsultCount = $todayQueues->where('status', 'in_consultation')->count();
    $completedCount = $todayQueues->where('status', 'completed')->count();
    $totalCount = $todayQueues->count();
@endphp

<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Current Queue Token</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#0284c7] font-mono">
            {{ $todayQueues->where('status', 'in_consultation')->first()?->token_number ?? ($todayQueues->where('status', 'waiting')->first()?->token_number ?? 'T-104') }}
        </div>
        <div class="stat-sub">
            @if($inConsult = $todayQueues->where('status', 'in_consultation')->first())
                Dr. {{ $doctor->name }} &bull; In Consultation
            @elseif($nextWait = $todayQueues->where('status', 'waiting')->first())
                Dr. {{ $doctor->name }} &bull; Waiting
            @else
                All patients attended
            @endif
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Patients Waiting</span>
            <div class="stat-icon-box stat-icon-amber">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $waitingCount }}</div>
        <div class="stat-sub">Priority triage active (Urgent &amp; Routine)</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Physicians On Duty</span>
            <div class="stat-icon-box stat-icon-teal">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>
            </div>
        </div>
        <div class="stat-val text-teal-700">{{ \App\Models\User::where('role', 'doctor')->count() }}</div>
        <div class="stat-sub">+1 evening shift scheduled</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Consultations Completed</span>
            <div class="stat-icon-box stat-icon-green">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $completedCount }}</div>
        <div class="stat-sub">Digital Rx synced with pharmacy</div>
    </div>
</div>

{{-- Queue Management Board --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block font-heading">Patient Consultation Queue Management</span>
                <span class="text-[11px] text-teal-200/80">{{ date('l, d F Y') }}</span>
            </div>
        </div>
        <span class="badge badge-gold font-bold">{{ $waitingCount }} Waiting in Reception</span>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-20">Token #</th>
                    <th>Patient Name &amp; Profile</th>
                    <th>University ID &amp; Dept</th>
                    <th>Clinical Status &amp; Allergies</th>
                    <th>Wait Time</th>
                    <th>Queue State</th>
                    <th class="text-right">Clinical Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayQueues as $q)
                    @php
                        $isInConsult = $q->status === 'in_consultation';
                    @endphp
                    <tr class="{{ $isInConsult ? 'bg-teal-50/70 border-l-4 border-l-[#0f766e] shadow-xs' : '' }}">
                        <td>
                            <div class="inline-flex items-center px-2 py-0.5 rounded {{ $isInConsult ? 'bg-[#0f766e] text-white shadow-xs' : 'bg-slate-100 text-[#091e3a]' }} font-mono font-bold text-xs">
                                {{ $q->token_number }}
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="size-8 rounded bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300 text-[#091e3a] flex items-center justify-center font-bold text-xs shrink-0 font-mono">
                                    {{ strtoupper(substr($q->patient->first_name ?? $q->patient->full_name, 0, 1)) }}{{ strtoupper(substr($q->patient->last_name ?? '', 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-slate-900 block text-xs sm:text-sm font-semibold">{{ $q->patient->full_name }}</strong>
                                    <span class="text-[11px] text-slate-500">{{ ucfirst($q->patient->role_category) }} &bull; {{ $q->patient->gender }} &bull; {{ $q->patient->dob ? $q->patient->dob->age . ' yrs' : 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-mono text-xs font-bold text-[#091e3a]">{{ $q->patient->university_id }}</div>
                            <div class="text-[11px] text-slate-500">{{ $q->patient->department ?? 'General' }}</div>
                        </td>
                        <td>
                            <div class="space-y-1">
                                <div>
                                    @if($q->patient->allergies)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-red-100 text-red-800 text-[10px] font-bold border border-red-200">
                                            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                            <span>Allergy: {{ $q->patient->allergies }}</span>
                                        </span>
                                    @else
                                        <span class="text-[11px] text-emerald-700 font-medium">No known drug allergies</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-600">
                                    Blood Group: <strong class="text-slate-900">{{ $q->patient->blood_group ?: 'Not recorded' }}</strong>
                                </div>
                            </div>
                        </td>
                        <td class="text-xs text-slate-500">
                            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-600">
                                <svg class="size-3 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span>{{ $q->created_at->diffForHumans(null, true) }} ago</span>
                            </span>
                        </td>
                        <td>
                            @php
                                $statusBadges = [
                                    'in_consultation' => 'badge-green',
                                    'waiting' => 'badge-yellow',
                                    'completed' => 'badge-blue',
                                    'skipped' => 'badge-red',
                                ];
                            @endphp
                            <span class="badge {{ $statusBadges[$q->status] ?? 'badge-gray' }} flex items-center gap-1 w-fit">
                                <span class="badge-dot {{ $isInConsult ? 'bg-emerald-500 animate-pulse' : ($q->status === 'waiting' ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                                <span>{{ str_replace('_', ' ', ucfirst($q->status)) }}</span>
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                <a href="{{ route('doctor.patients.history', $q->patient_id) }}" class="btn btn-outline btn-xs" title="View Patient Medical History">
                                    <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
                                    <span>History</span>
                                </a>

                                @if($q->status === 'waiting')
                                    <form action="{{ route('doctor.queue.call', $q->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-green btn-xs flex items-center gap-1 shadow-xs hover:shadow">
                                            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                                            <span>Call In</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('doctor.queue.skip', $q->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-xs !text-red-700 !border-red-200 hover:!bg-red-50">Skip</button>
                                    </form>
                                @elseif($isInConsult)
                                    <a href="{{ route('doctor.prescriptions.create', ['queue_id' => $q->id, 'patient_id' => $q->patient_id]) }}" class="btn btn-green btn-xs flex items-center gap-1 shadow-xs">
                                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        <span>Write Rx</span>
                                    </a>
                                    <form action="{{ route('doctor.queue.complete', $q->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-gold btn-xs flex items-center gap-1">
                                            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            <span>Done</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-400">
                                        <svg class="size-3 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        <span>Attended</span>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 bg-slate-50/50">
                            <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-3">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div class="text-sm font-bold text-slate-800">No Patients in Queue</div>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Reception has no patients waiting at this time. Patients who arrive or generate walk-in tokens will appear here instantly.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
