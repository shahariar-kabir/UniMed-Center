@extends('layouts.app')
@section('title', 'Live Queue Tracking')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 border border-teal-200/80 text-[#0d9488] text-xs font-semibold mb-2">
            <span class="badge-dot bg-emerald-500 animate-pulse"></span>
            <span>Real-Time Consultation Display</span>
        </div>
        <h1 class="page-title text-2xl sm:text-3xl font-extrabold text-[#091e3a]">Live Consultation Queue Tracking</h1>
        <p class="page-subtitle text-xs sm:text-sm text-slate-500">Real-time telemetry of University Medical Centre consultation suites, calling tokens, and queue wait times.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('patient.queue') }}" class="btn btn-outline btn-sm flex items-center gap-1.5" title="Refresh live status">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
            <span>Live Sync</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch mb-6">
    {{-- Now Serving Token Card (5 cols) --}}
    <div class="lg:col-span-5 bg-gradient-to-br from-[#091e3a] via-[#0d2a4e] to-[#071527] text-white rounded-lg p-6 shadow-sm border-b-4 border-[#0f766e] flex flex-col justify-between relative overflow-hidden">
        {{-- Ambient decorative background glow --}}
        <div class="absolute -top-12 -right-12 size-40 bg-teal-500/15 rounded-full blur-2xl pointer-events-none"></div>

        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-teal-500/20 text-[#5eead4] border border-teal-400/30 text-[10px] font-bold uppercase tracking-wider">
                    <span class="badge-dot bg-emerald-400 animate-pulse"></span>
                    <span>Calling Token Now</span>
                </span>
                <span class="text-[11px] text-teal-200/80 font-mono">OPD Suite 101</span>
            </div>

            <div class="my-4">
                <div class="text-xs uppercase tracking-wider text-slate-300 font-bold mb-1">Now Calling Into Consultation:</div>
                <div class="text-5xl sm:text-6xl font-black tracking-tight text-white font-mono flex items-center gap-3">
                    @if($nowCalling)
                        <span class="text-[#5eead4] drop-shadow-sm">{{ $nowCalling->token_number }}</span>
                    @else
                        <span class="text-slate-400 text-3xl font-sans font-bold">Desk Ready</span>
                    @endif
                </div>
            </div>

            <div class="p-3 rounded-xl bg-white/10 border border-white/15 backdrop-blur-xs text-xs space-y-1">
                @if($nowCalling)
                    <div class="flex items-center justify-between">
                        <span class="text-teal-200">Department:</span>
                        <strong class="text-white">{{ $nowCalling->department }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-teal-200">Attending Physician:</span>
                        <strong class="text-white">{{ $nowCalling->doctor ? 'Dr. ' . $nowCalling->doctor->name : 'Medical Officer' }}</strong>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-white/10">
                        <span class="text-teal-200">Patient Calling:</span>
                        <span class="text-white font-bold">{{ $nowCalling->patient->full_name }}</span>
                    </div>
                @else
                    <div class="text-teal-100/90 leading-relaxed">
                        Medical officers are currently available in the OPD consultation suites. Tokens are called automatically in sequence.
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-4 border-t border-white/15 text-[11px] text-teal-100/70 flex items-center justify-between mt-4">
            <span>Please observe audio announcements &amp; screen monitors</span>
            <span class="font-mono text-[#5eead4] font-bold">UMC &bull; Live</span>
        </div>
    </div>

    {{-- My Token Status / Join Queue (7 cols) --}}
    <div class="lg:col-span-7 bg-white border {{ $myToken ? 'border-teal-300 bg-teal-50/20 shadow-teal-500/5' : 'border-slate-200' }} shadow-sm rounded-2xl p-6 flex flex-col justify-between transition-shadow hover:shadow-md">
        @if($myToken)
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-gold font-bold text-xs">YOUR ACTIVE QUEUE TOKEN</span>
                        <span class="text-xs text-slate-500">Issued {{ $myToken->created_at->format('h:i A') }}</span>
                    </div>
                    <span class="badge {{ $myToken->status === 'in_consultation' ? 'badge-green' : 'badge-yellow' }} flex items-center gap-1.5 text-xs font-bold">
                        <span class="badge-dot {{ $myToken->status === 'in_consultation' ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                        <span>{{ $myToken->status === 'in_consultation' ? 'IN CONSULTATION NOW' : 'WAITING IN QUEUE' }}</span>
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 my-4">
                    <div>
                        <span class="text-xs text-slate-500 block uppercase tracking-wider font-semibold">Your Assigned Token:</span>
                        <div class="text-4xl sm:text-5xl font-black text-[#0d9488] font-mono tracking-tight">{{ $myToken->token_number }}</div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                        <div>Department: <strong class="text-slate-800">{{ $myToken->department }}</strong></div>
                        <div>Assigned Desk: <strong class="text-slate-800">OPD Suite 101</strong></div>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl {{ $myToken->status === 'in_consultation' ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50/80 border border-amber-200 text-amber-900' }} text-xs leading-relaxed">
                    @if($myToken->status === 'in_consultation')
                        <div class="flex items-center gap-2 font-bold text-sm">
                            <svg class="size-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                            <span>Your token is being called right now!</span>
                        </div>
                        <p class="mt-1 text-emerald-800">Please proceed directly inside Consultation Room 101 with your student / staff ID.</p>
                    @else
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <span><strong>{{ $patientsAhead }}</strong> patient(s) ahead of you in line.</span>
                            <span class="font-bold text-amber-950">Estimated wait: ~{{ max(5, $patientsAhead * 8) }} minutes</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-[11px] text-slate-400 pt-3 border-t border-slate-100 mt-4 flex items-center justify-between">
                <span>Please remain in the reception waiting lounge within audio range.</span>
                <span class="font-semibold text-[#0d9488]">Token #{{ $myToken->token_number }}</span>
            </div>
        @else
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="badge badge-cyan font-bold text-xs">WALK-IN TOKEN REGISTRATION</span>
                    <span class="text-xs text-slate-500">Same-Day Consultation</span>
                </div>

                <div class="my-4">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Visiting University Medical Centre Today?</h3>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                        If you do not have an advance scheduled appointment, you can instantly generate a walk-in consultation token for today's OPD session.
                    </p>
                </div>

                <form action="{{ route('patient.queue.join') }}" method="POST" class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    @csrf
                    <div>
                        <label class="form-label text-xs font-semibold text-slate-700">Select Medical Service / Department <span class="req">*</span></label>
                        <select name="department" class="form-control text-xs" required>
                            <option value="General Medicine">General Medicine &amp; Primary Care</option>
                            <option value="Dental">Dental Clinic</option>
                            <option value="Counselling">Counselling &amp; Mental Health Support</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-green w-full py-2.5 flex items-center justify-center gap-2 font-bold text-xs shadow-xs">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        <span>Generate Walk-In Queue Token</span>
                    </button>
                </form>
            </div>
            <div class="text-[11px] text-slate-400 pt-3 border-t border-slate-100 mt-3">
                * Walk-in tokens are valid for the current day's OPD session only.
            </div>
        @endif
    </div>
</div>

{{-- Queue Overview Stats Grid --}}
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Current Queue Token</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#0284c7] font-mono">
            {{ $nowCalling ? $nowCalling->token_number : ($todayQueues->where('status', 'waiting')->first()?->token_number ?? 'T-104') }}
        </div>
        <div class="stat-sub">
            @if($nowCalling)
                Dr. {{ $nowCalling->doctor?->name ?? 'Alan Chen' }} &bull; In Consultation
            @elseif($firstWait = $todayQueues->where('status', 'waiting')->first())
                Dr. {{ $firstWait->doctor?->name ?? 'Alan Chen' }} &bull; Waiting
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

{{-- Full Queue Board Table --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Today's Live Queue Board</span>
                <span class="text-[11px] text-teal-200/80">{{ date('d M Y') }} &bull; Synchronized Live</span>
            </div>
        </div>
        <span class="badge badge-cyan text-[11px]">Real-Time Sync</span>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-20">Token</th>
                    <th>Patient Name</th>
                    <th>Department</th>
                    <th>Attending Doctor</th>
                    <th>Issued At</th>
                    <th class="text-right">Current Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayQueues as $q)
                    @php
                        $isMe = $myToken && $myToken->id === $q->id;
                    @endphp
                    <tr class="{{ $isMe ? 'bg-amber-50/70 border-l-4 border-l-amber-500 font-bold' : '' }}">
                        <td>
                            <div class="inline-flex items-center gap-1.5">
                                <span class="px-2.5 py-1 rounded-lg {{ $isMe ? 'bg-amber-500 text-white' : 'bg-slate-100 text-[#091e3a]' }} font-mono font-bold text-xs">
                                    {{ $q->token_number }}
                                </span>
                                @if($isMe)
                                    <span class="badge badge-gold text-[10px]">YOU</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="size-8 rounded-lg bg-slate-100 border border-slate-200 text-[#091e3a] flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($q->patient->first_name ?? $q->patient->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-slate-900 block text-xs">{{ $q->patient->full_name }}</strong>
                                    <span class="text-[11px] text-slate-500">{{ ucfirst($q->patient->role_category) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-xs text-slate-800 font-medium">{{ $q->department }}</td>
                        <td class="text-xs text-slate-600">
                            {{ $q->doctor ? 'Dr. ' . $q->doctor->name : 'First available' }}
                        </td>
                        <td class="text-xs text-slate-500 font-mono">{{ $q->created_at->format('h:i A') }}</td>
                        <td class="text-right">
                            @php
                                $statusBadges = [
                                    'in_consultation' => 'badge-green',
                                    'waiting' => 'badge-yellow',
                                    'completed' => 'badge-blue',
                                    'skipped' => 'badge-red',
                                ];
                            @endphp
                            <span class="badge {{ $statusBadges[$q->status] ?? 'badge-gray' }} inline-flex items-center gap-1">
                                <span class="badge-dot {{ $q->status === 'in_consultation' ? 'bg-emerald-500 animate-pulse' : ($q->status === 'waiting' ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                                <span>{{ str_replace('_', ' ', ucfirst($q->status)) }}</span>
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 bg-slate-50/40">
                            <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-2.5">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div class="text-xs font-bold text-slate-800">No active queue tokens registered today</div>
                            <p class="text-[11px] text-slate-500 max-w-xs mx-auto mt-0.5">Generate a walk-in token using the box above to take your turn at the consultation suite.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
