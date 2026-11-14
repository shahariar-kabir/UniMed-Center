@extends('layouts.app')
@section('title', 'Patient Dashboard')

@section('content')
{{-- Patient Digital Medical Pass Ribbon --}}
<div class="bg-white border border-slate-200 rounded-lg p-6 mb-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="avatar-initials size-14 bg-gradient-to-br from-[#091e3a] to-[#0f2b48] text-white border border-[#0f766e] text-xl shadow-xs font-mono rounded">
            {{ substr($patient->first_name, 0, 1) }}
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-xl font-bold text-slate-900 font-heading">{{ $patient->full_name }}</h1>
                <span class="badge badge-teal text-xs font-medium">
                    <span class="badge-dot bg-teal-500"></span>
                    Patient Portal &bull; Verified Pass
                </span>
                @if($patient->blood_group)
                    <span class="badge badge-red text-xs font-bold">{{ $patient->blood_group }}</span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1 flex items-center gap-2 flex-wrap">
                <span>University ID: <strong class="font-mono text-slate-800">{{ $patient->university_id }}</strong></span>
                <span>&bull;</span>
                <span>Category: <strong>{{ ucfirst($patient->role_category) }}</strong></span>
                <span>&bull;</span>
                <span>Department: <strong>{{ $patient->department ?? 'General' }}</strong></span>
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2.5">
        @if(!$activeQueue)
            <form action="{{ route('patient.queue.join') }}" method="POST">
                @csrf
                <input type="hidden" name="department" value="General Medicine">
                <button type="submit" class="btn btn-teal btn-sm shadow-sm font-bold">
                    <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    Get Today's Walk-in Token
                </button>
            </form>
        @else
            <a href="{{ route('patient.queue') }}" class="btn btn-cyan btn-sm shadow-sm font-bold">
                <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Track My Live Token #{{ $activeQueue->token_number }}
            </a>
        @endif
        <a href="{{ route('patient.appointments') }}" class="btn btn-outline btn-sm shadow-xs">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            Book Appointment
        </a>
    </div>
</div>

{{-- Live Queue Banner if in Queue Today --}}
@if($activeQueue)
    <div class="bg-white border-2 border-[#0284c7] rounded-lg p-6 mb-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 h-24 w-24 bg-sky-500/10 rounded-bl-full pointer-events-none"></div>
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <span class="badge badge-cyan text-xs font-bold uppercase tracking-wider py-1 px-3">
                    <span class="badge-dot bg-sky-600 animate-pulse"></span>
                    Live Consultation Ticket Active
                </span>
                <span class="text-xs text-slate-500">Issued at {{ $activeQueue->created_at->format('h:i A') }}</span>
            </div>
            <span class="badge {{ $activeQueue->status === 'in_consultation' ? 'badge-teal font-extrabold' : 'badge-yellow font-bold' }}">
                {{ $activeQueue->status === 'in_consultation' ? 'NOW IN CONSULTATION' : 'WAITING FOR DOCTOR' }}
            </span>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-5 mb-5">
            <div class="flex items-center gap-4">
                <div class="size-16 rounded-2xl bg-[#091e3a] text-white flex flex-col items-center justify-center font-mono shadow-md border-2 border-teal-400 shrink-0">
                    <span class="text-[9px] text-teal-300 font-sans uppercase font-bold tracking-wider">Token</span>
                    <span class="text-xl font-black leading-none mt-0.5">#{{ $activeQueue->token_number }}</span>
                </div>
                <div>
                    <div class="text-lg font-bold text-slate-900 flex items-center gap-2 flex-wrap">
                        <span>OPD Room 101 &bull; {{ $activeQueue->department }}</span>
                        @if($activeQueue->status === 'in_consultation')
                            <span class="py-0.5 px-2 rounded bg-teal-50 text-teal-800 text-xs font-bold border border-teal-200">Door Open &bull; Proceed In</span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-600 mt-1">
                        @if($activeQueue->status === 'in_consultation')
                            <span class="text-teal-700 font-bold">Doctor is attending you now. Please enter Consultation Desk Room 101.</span>
                        @else
                            <span class="font-bold text-slate-800">{{ $patientsAhead }} patient(s) ahead of you</span> &mdash; estimated wait approx. <span class="font-bold text-[#0284c7]">{{ max(5, $patientsAhead * 8) }} minutes</span>.
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('patient.queue') }}" class="btn btn-teal btn-sm shadow-sm font-bold">
                    Open Live Queue Board &rarr;
                </a>
            </div>
        </div>

        {{-- 4-Step Patient Journey Stepper --}}
        <div class="pt-4 border-t border-slate-100">
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2.5">Care Journey Progress:</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="p-2.5 rounded-xl bg-teal-50 border border-teal-200 flex items-center gap-2.5">
                    <div class="stepper-node completed shrink-0">1</div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-teal-900">Token Issued</div>
                        <div class="text-[10px] text-teal-700 font-mono">#{{ $activeQueue->token_number }}</div>
                    </div>
                </div>

                <div class="p-2.5 rounded-xl {{ $activeQueue->status === 'waiting' ? 'bg-sky-50 border border-sky-300' : 'bg-teal-50 border border-teal-200' }} flex items-center gap-2.5">
                    <div class="stepper-node {{ $activeQueue->status === 'waiting' ? 'active' : 'completed' }} shrink-0">2</div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold {{ $activeQueue->status === 'waiting' ? 'text-sky-950' : 'text-teal-900' }}">Waiting Hall</div>
                        <div class="text-[10px] text-slate-600">{{ $activeQueue->status === 'waiting' ? 'In Queue' : 'Completed' }}</div>
                    </div>
                </div>

                <div class="p-2.5 rounded-xl {{ $activeQueue->status === 'in_consultation' ? 'bg-teal-50 border-2 border-teal-500' : 'bg-slate-50 border border-slate-200' }} flex items-center gap-2.5">
                    <div class="stepper-node {{ $activeQueue->status === 'in_consultation' ? 'completed pulse-live' : 'pending' }} shrink-0">3</div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold {{ $activeQueue->status === 'in_consultation' ? 'text-teal-950 font-extrabold' : 'text-slate-700' }}">Doctor Room</div>
                        <div class="text-[10px] {{ $activeQueue->status === 'in_consultation' ? 'text-teal-700 font-bold' : 'text-slate-400' }}">Room 101</div>
                    </div>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2.5 opacity-80">
                    <div class="stepper-node pending shrink-0">4</div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-slate-700">Central Pharmacy</div>
                        <div class="text-[10px] text-slate-400">Medicine Pickup</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Patient Stats Grid --}}
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Blood Group</span>
            <div class="stat-icon-box stat-icon-red">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </div>
        </div>
        <div class="stat-val text-rose-600">{{ $patient->blood_group ?? 'Not Set' }}</div>
        <div class="stat-sub">Official Clinical Record</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Upcoming Visits</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#0284c7]">{{ $upcomingAppointments->count() }}</div>
        <div class="stat-sub">Confirmed consultations</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Prescriptions On File</span>
            <div class="stat-icon-box stat-icon-teal">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-teal-700">{{ $prescriptions->count() }}</div>
        <div class="stat-sub">Subsidized digital orders</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Identity Status</span>
            <div class="stat-icon-box stat-icon-green">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
        </div>
        <div class="stat-val text-emerald-600 text-2xl mt-1">ACTIVE</div>
        <div class="stat-sub">Subsidized healthcare pass</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 cols: Prescriptions & Appointments --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Recent Digital Prescriptions --}}
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Digital Prescriptions &amp; Downloadable PDF
                </span>
                <a href="{{ route('patient.prescriptions') }}" class="text-xs text-teal-300 hover:text-white font-semibold transition-colors">View All &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Number</th>
                            <th>Prescribing Doctor</th>
                            <th>Diagnosis</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $rx)
                            <tr>
                                <td>
                                    <strong class="text-teal-800 font-mono text-xs">{{ $rx->prescription_number }}</strong>
                                    <div class="text-[11px] text-slate-500">{{ $rx->created_at->format('d M Y, h:i A') }}</div>
                                </td>
                                <td>
                                    <div class="font-bold text-slate-900 text-xs">Dr. {{ $rx->doctor->name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $rx->doctor->department ?? 'General Medicine' }}</div>
                                </td>
                                <td class="text-xs text-slate-600 truncate max-w-[200px]">{{ Str::limit($rx->diagnosis, 40) }}</td>
                                <td>
                                    <span class="badge {{ $rx->status === 'dispensed' ? 'badge-teal' : 'badge-yellow' }}">
                                        {{ ucfirst($rx->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs shadow-xs">View</a>
                                        <a href="{{ route('patient.prescriptions.pdf', $rx->id) }}" class="btn btn-teal btn-xs shadow-xs font-bold" title="Download official printable PDF">PDF &darr;</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-slate-400 text-xs">No digital prescriptions recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Upcoming Appointments --}}
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    My Appointments
                </span>
                <a href="{{ route('patient.appointments') }}" class="text-xs text-teal-300 hover:text-white font-semibold transition-colors">Book New Visit &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ref #</th>
                            <th>Department</th>
                            <th>Doctor</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingAppointments as $apt)
                            <tr>
                                <td class="font-mono text-xs font-semibold text-slate-800">{{ $apt->appointment_number }}</td>
                                <td class="text-xs text-slate-900 font-bold">{{ $apt->department }}</td>
                                <td class="text-xs text-slate-600">{{ $apt->doctor?->name ?? 'Assigned on arrival' }}</td>
                                <td>
                                    <div class="text-xs font-bold text-slate-800">{{ $apt->appointment_date->format('d M Y') }}</div>
                                    <div class="text-[11px] font-bold text-teal-700">{{ $apt->time_slot }}</div>
                                </td>
                                <td><span class="badge badge-teal font-bold">{{ ucfirst($apt->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-slate-400 text-xs">No upcoming appointments scheduled.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 col: Identity & Quick Actions --}}
    <div class="space-y-6">
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-lg p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2 mb-3.5 flex items-center gap-2 font-heading">
                <svg class="size-4 text-[#0284c7]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Identity &amp; Profile Summary
            </h3>
            <div class="text-xs text-slate-600 space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">University ID:</span>
                    <strong class="font-mono text-slate-900 bg-slate-100 px-2 py-0.5 rounded">{{ $patient->university_id }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Email:</span>
                    <strong class="text-slate-800">{{ $patient->email }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Mobile:</span>
                    <strong class="text-slate-800 font-mono">{{ $patient->phone }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Blood Group:</span>
                    <span class="badge badge-red font-bold">{{ $patient->blood_group ?? 'Not set' }}</span>
                </div>
                <div class="pt-2 border-t border-slate-100">
                    <span class="text-slate-500 font-medium">Known Drug Allergies:</span>
                    <div class="mt-1">
                        @if($patient->allergies)
                            <span class="text-rose-600 font-bold bg-rose-50 px-2 py-0.5 rounded border border-rose-200">{{ $patient->allergies }}</span>
                        @else
                            <span class="text-teal-700 font-semibold">No known drug allergies reported</span>
                        @endif
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100">
                    <span class="text-slate-500 font-medium">Emergency Contact:</span>
                    <div class="text-slate-800 font-semibold mt-0.5">{{ $patient->emergency_name ?? 'Not set' }} &ndash; {{ $patient->emergency_phone ?? 'N/A' }}</div>
                </div>
                <div class="pt-3">
                    <a href="{{ route('patient.profile') }}" class="btn btn-outline btn-sm w-full text-center shadow-xs">Edit Profile &amp; Contact Info</a>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2 mb-3.5 flex items-center gap-2">
                <svg class="size-4 text-[#0d9488]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Quick Patient Actions
            </h3>
            <div class="space-y-2.5">
                @if(!$activeQueue)
                    <form action="{{ route('patient.queue.join') }}" method="POST">
                        @csrf
                        <input type="hidden" name="department" value="General Medicine">
                        <button type="submit" class="btn btn-teal w-full shadow-sm font-bold">Get Today's Walk-in Token</button>
                    </form>
                @endif
                <a href="{{ route('patient.queue') }}" class="btn btn-outline w-full text-center shadow-xs">View Live Queue Tracking</a>
                <a href="{{ route('patient.appointments') }}" class="btn btn-outline w-full text-center shadow-xs">Book Doctor Appointment</a>
                <a href="{{ route('patient.prescriptions') }}" class="btn btn-outline w-full text-center shadow-xs">Download Prescriptions (PDF)</a>
            </div>
        </div>
    </div>
</div>
@endsection
