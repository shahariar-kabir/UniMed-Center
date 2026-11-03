@extends('layouts.app')
@section('title', 'Live Queue Tracking')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Live Consultation Queue Tracking</h1>
    <p class="page-subtitle">Real-time status of university medical centre consultation rooms and patient queuing.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch mb-6">
    {{-- Now Serving Token (5 cols) --}}
    <div class="lg:col-span-5 bg-gradient-to-br from-[#134d2a] to-[#1a6b3a] text-white rounded-xl p-6 shadow-sm border-b-4 border-[#c8922a] flex flex-col justify-between">
        <div>
            <div class="text-[11px] uppercase tracking-wider text-emerald-200 font-bold mb-2">Currently Calling Token</div>
            <div class="text-5xl font-black tracking-tight text-white my-3">
                {{ $nowCalling ? $nowCalling->token_number : 'NONE' }}
            </div>
            <div class="text-sm font-semibold text-white">
                @if($nowCalling)
                    Clinic Room 101 &mdash; {{ $nowCalling->department }}
                    <div class="text-xs text-emerald-100 font-normal mt-1">Patient: {{ $nowCalling->patient->full_name }}</div>
                @else
                    Doctor's Desk Ready for Next Patient
                @endif
            </div>
        </div>
        <div class="pt-4 border-t border-white/15 text-xs text-emerald-100/80">
            Please watch the waiting room display monitor.
        </div>
    </div>

    {{-- My Token Status / Join Queue (7 cols) --}}
    <div class="lg:col-span-7 bg-white border {{ $myToken ? 'border-[#c8922a] bg-amber-50/20' : 'border-gray-200' }} shadow-sm rounded-xl p-6 flex flex-col justify-between">
        @if($myToken)
            <div>
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <span class="badge badge-gold">MY ACTIVE TOKEN</span>
                    <span class="badge {{ $myToken->status === 'in_consultation' ? 'badge-green' : 'badge-yellow' }}">
                        {{ $myToken->status === 'in_consultation' ? 'NOW IN CONSULTATION' : 'WAITING' }}
                    </span>
                </div>
                <div class="flex items-baseline gap-3 my-3">
                    <span class="text-4xl font-extrabold text-[#1a6b3a]">{{ $myToken->token_number }}</span>
                    <span class="text-xs text-gray-600">Department: <strong>{{ $myToken->department }}</strong></span>
                </div>
                <div class="text-xs text-slate-800 leading-relaxed">
                    @if($myToken->status === 'in_consultation')
                        <strong class="text-emerald-800 font-bold">Your token is being called right now! Please step inside the doctor's room.</strong>
                    @else
                        <span><strong>{{ $patientsAhead }}</strong> patient(s) ahead of you in line.</span>
                        <span class="text-gray-500 ml-2">Estimated wait: <strong>~{{ max(5, $patientsAhead * 8) }} minutes</strong></span>
                    @endif
                </div>
            </div>
            <div class="text-[11px] text-gray-500 pt-3 border-t border-gray-100">
                Issued today at {{ $myToken->created_at->format('h:i A') }}. Please remain in the reception waiting area.
            </div>
        @else
            <div>
                <span class="badge badge-gray mb-2">WALK-IN QUEUE REGISTRATION</span>
                <h3 class="text-sm font-bold text-slate-900 mt-1">Visiting the Medical Centre Today?</h3>
                <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                    If you do not have an advance appointment, you can generate a walk-in queue token instantly for general consultation today.
                </p>
                <form action="{{ route('patient.queue.join') }}" method="POST" class="flex flex-wrap items-center gap-2 mt-4">
                    @csrf
                    <select name="department" class="form-control w-52 text-xs" required>
                        <option value="General Medicine">General Medicine</option>
                        <option value="Dental">Dental Clinic</option>
                        <option value="Counselling">Counselling &amp; Mental Health</option>
                    </select>
                    <button type="submit" class="btn btn-green btn-sm">Get Walk-in Queue Token</button>
                </form>
            </div>
            <div class="text-[11px] text-gray-400 pt-3 border-t border-gray-100 mt-3">
                * Walk-in tokens are valid for the day of issue only.
            </div>
        @endif
    </div>
</div>

{{-- Queue Overview Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">{{ $todayQueues->count() }}</div>
        <div class="stat-label">Total Tokens Today</div>
        <div class="stat-sub">Patients registered</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">{{ $waitingCount }}</div>
        <div class="stat-label">Currently Waiting</div>
        <div class="stat-sub">In queue line</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">{{ $completedCount }}</div>
        <div class="stat-label">Completed Consultations</div>
        <div class="stat-sub">Attended by doctor today</div>
    </div>
    <div class="stat-card">
        <div class="stat-val text-emerald-700">~8 min</div>
        <div class="stat-label">Avg. Consultation Time</div>
        <div class="stat-sub">Standard medical review</div>
    </div>
</div>

{{-- Full Queue Board Table --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Today's Live Queue Board &mdash; {{ date('d M Y') }}</span>
        <span class="text-xs text-emerald-200 font-normal">Real-Time Sync</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Token</th>
                    <th>Patient Name</th>
                    <th>Department</th>
                    <th>Assigned Doctor</th>
                    <th>Issued At</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayQueues as $q)
                    <tr class="{{ $myToken && $myToken->id === $q->id ? 'bg-amber-50 font-bold' : '' }}">
                        <td>
                            <strong class="text-[#1a6b3a] text-sm">{{ $q->token_number }}</strong>
                            @if($myToken && $myToken->id === $q->id)
                                <span class="badge badge-gold ml-1 text-[10px]">YOU</span>
                            @endif
                        </td>
                        <td class="font-medium text-slate-900">{{ $q->patient->full_name }}</td>
                        <td class="text-xs text-slate-800">{{ $q->department }}</td>
                        <td class="text-xs text-gray-600">{{ $q->doctor?->name ?? 'Next available' }}</td>
                        <td class="text-xs text-gray-500">{{ $q->created_at->format('h:i A') }}</td>
                        <td class="text-right">
                            @php
                                $statusBadges = [
                                    'in_consultation' => 'badge-green',
                                    'waiting' => 'badge-yellow',
                                    'completed' => 'badge-blue',
                                    'skipped' => 'badge-red',
                                ];
                            @endphp
                            <span class="badge {{ $statusBadges[$q->status] ?? 'badge-gray' }}">
                                {{ str_replace('_', ' ', ucfirst($q->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 text-xs">No queue tokens issued yet today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
