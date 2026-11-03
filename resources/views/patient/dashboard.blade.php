@extends('layouts.app')
@section('title', 'Patient Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Patient Portal &mdash; {{ $patient->full_name }}</h1>
    <p class="page-subtitle">University ID: <strong>{{ $patient->university_id }}</strong> &nbsp;|&nbsp; Category: <strong>{{ ucfirst($patient->role_category) }}</strong> &nbsp;|&nbsp; Department: <strong>{{ $patient->department ?? 'General' }}</strong></p>
</div>

{{-- Live Queue Banner if in Queue Today --}}
@if($activeQueue)
    <div class="bg-white border-2 border-[#c8922a] rounded-xl p-5 mb-6 shadow-sm">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <span class="badge badge-gold font-bold">TODAY'S LIVE QUEUE TICKET</span>
            <span class="badge {{ $activeQueue->status === 'in_consultation' ? 'badge-green' : 'badge-yellow' }}">
                {{ $activeQueue->status === 'in_consultation' ? 'NOW IN CONSULTATION' : 'WAITING FOR DOCTOR' }}
            </span>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="text-3xl font-extrabold text-[#1a6b3a]">{{ $activeQueue->token_number }}</div>
                <div class="text-xs text-gray-600 mt-1">Department: <strong>{{ $activeQueue->department }}</strong> &bull; Clinic Room 101</div>
            </div>
            <div class="text-right">
                @if($activeQueue->status === 'in_consultation')
                    <div class="text-sm font-bold text-emerald-800">Please proceed to Doctor's Consultation Room</div>
                    <div class="text-xs text-gray-500">Doctor is attending you now.</div>
                @else
                    <div class="text-sm font-bold text-slate-800">{{ $patientsAhead }} patient(s) ahead of you</div>
                    <div class="text-xs text-gray-500">Estimated wait: approx. {{ max(5, $patientsAhead * 8) }} minutes</div>
                @endif
            </div>
            <div>
                <a href="{{ route('patient.queue') }}" class="btn btn-green btn-sm">Open Live Queue Board &rarr;</a>
            </div>
        </div>
    </div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">{{ $patient->blood_group ?? 'Not Set' }}</div>
        <div class="stat-label">Blood Group</div>
        <div class="stat-sub">Medical Profile</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">{{ $upcomingAppointments->count() }}</div>
        <div class="stat-label">Upcoming Visits</div>
        <div class="stat-sub">Confirmed appointments</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">{{ $prescriptions->count() }}</div>
        <div class="stat-label">Total Prescriptions</div>
        <div class="stat-sub">Digital Rx on file</div>
    </div>
    <div class="stat-card">
        <div class="stat-val text-emerald-700">VERIFIED</div>
        <div class="stat-label">Identity Status</div>
        <div class="stat-sub">Authorized University Member</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 cols: Prescriptions & Appointments --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Recent Digital Prescriptions --}}
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">Digital Prescriptions &amp; Printable PDF</span>
                <a href="{{ route('patient.prescriptions') }}" class="text-xs text-emerald-200 hover:underline">View All &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Number</th>
                            <th>Doctor</th>
                            <th>Diagnosis</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $rx)
                            <tr>
                                <td>
                                    <strong class="text-slate-900 font-mono">{{ $rx->prescription_number }}</strong>
                                    <div class="text-[11px] text-gray-500">{{ $rx->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="text-xs font-medium text-slate-800">{{ $rx->doctor->name }}</td>
                                <td class="text-xs text-gray-600 truncate max-w-[200px]">{{ Str::limit($rx->diagnosis, 45) }}</td>
                                <td>
                                    <span class="badge {{ $rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow' }}">
                                        {{ ucfirst($rx->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs">View</a>
                                        <a href="{{ route('patient.prescriptions.pdf', $rx->id) }}" class="btn btn-green btn-xs" title="Download printable PDF">PDF &darr;</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400 text-xs">No digital prescriptions recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Upcoming Appointments --}}
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">My Appointments</span>
                <a href="{{ route('patient.appointments') }}" class="text-xs text-emerald-200 hover:underline">Book New Visit &rarr;</a>
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
                                <td class="text-xs text-slate-900 font-medium">{{ $apt->department }}</td>
                                <td class="text-xs text-gray-600">{{ $apt->doctor?->name ?? 'Assigned on arrival' }}</td>
                                <td>
                                    <div class="text-xs text-slate-800">{{ $apt->appointment_date->format('d M Y') }}</div>
                                    <div class="text-[11px] font-bold text-emerald-700">{{ $apt->time_slot }}</div>
                                </td>
                                <td><span class="badge badge-green">{{ ucfirst($apt->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400 text-xs">No upcoming appointments scheduled.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 col: Identity & Quick Actions --}}
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Identity &amp; Profile Summary
            </h3>
            <div class="text-xs text-gray-600 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">University ID:</span>
                    <strong class="text-slate-800">{{ $patient->university_id }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Email:</span>
                    <strong class="text-slate-800">{{ $patient->email }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Mobile:</span>
                    <strong class="text-slate-800">{{ $patient->phone }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Blood Group:</span>
                    <span class="badge badge-red">{{ $patient->blood_group ?? 'Not set' }}</span>
                </div>
                <div class="pt-2 border-t border-gray-100">
                    <span class="text-gray-500">Known Allergies:</span>
                    <div class="text-red-700 font-bold mt-0.5">{{ $patient->allergies ?: 'No known drug allergies reported' }}</div>
                </div>
                <div class="pt-2 border-t border-gray-100">
                    <span class="text-gray-500">Emergency Contact:</span>
                    <div class="text-slate-800 font-medium mt-0.5">{{ $patient->emergency_name ?? 'Not set' }} &ndash; {{ $patient->emergency_phone ?? 'N/A' }}</div>
                </div>
                <div class="pt-3">
                    <a href="{{ route('patient.profile') }}" class="btn btn-outline btn-sm w-full text-center">Edit Profile &amp; Contact Info</a>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Quick Patient Actions
            </h3>
            <div class="space-y-2">
                @if(!$activeQueue)
                    <form action="{{ route('patient.queue.join') }}" method="POST">
                        @csrf
                        <input type="hidden" name="department" value="General Medicine">
                        <button type="submit" class="btn btn-green w-full">Get Today's Walk-in Token</button>
                    </form>
                @endif
                <a href="{{ route('patient.queue') }}" class="btn btn-outline w-full text-center">View Live Queue Tracking</a>
                <a href="{{ route('patient.appointments') }}" class="btn btn-outline w-full text-center">Book Doctor Appointment</a>
                <a href="{{ route('patient.prescriptions') }}" class="btn btn-outline w-full text-center">Download Prescriptions (PDF)</a>
            </div>
        </div>
    </div>
</div>
@endsection
