@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- Modern Clinical Hero Section --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#091e3a] via-[#0b2749] to-[#0d3663] text-white p-6 sm:p-8 lg:p-10 mb-8 shadow-md border border-cyan-500/20">
    {{-- Ambient Decorative Glow Circles --}}
    <div class="absolute -top-24 -right-24 size-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 size-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        {{-- Left Hero Text & Actions --}}
        <div class="lg:col-span-7">
            <div class="inline-flex items-center gap-x-2 py-1 px-3.5 rounded-full bg-teal-500/15 backdrop-blur-md border border-teal-400/30 text-xs font-semibold text-teal-200 mb-4 shadow-xs">
                <span class="relative flex size-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full size-2 bg-teal-400"></span>
                </span>
                <span>University Health &amp; Clinical Services Division</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mb-4 text-white leading-tight">
                Digital Healthcare for <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-teal-200 to-sky-300">University Members</span>
            </h1>
            
            <p class="text-sm sm:text-base text-slate-200/90 leading-relaxed mb-6 font-normal max-w-2xl">
                Integrated campus medical portal providing instant doctor consultations, live outpatient queue tracking, electronic prescription management, and subsidized medicine fulfillment from Central Pharmacy.
            </p>

            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if(Auth::user()->isPatient())
                        <a href="{{ route('patient.dashboard') }}" class="btn btn-teal shadow-md">
                            <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            My Patient Dashboard
                        </a>
                        <a href="{{ route('patient.queue') }}" class="btn btn-outline shadow-xs">
                            <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            View Live Queue
                        </a>
                    @elseif(Auth::user()->isDoctor())
                        <a href="{{ route('doctor.dashboard') }}" class="btn btn-teal shadow-md">
                            <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>
                            Doctor Consultation Desk
                        </a>
                        <a href="{{ route('doctor.queue') }}" class="btn btn-outline shadow-xs">Consultation Queue</a>
                    @elseif(Auth::user()->isPharmacist())
                        <a href="{{ route('pharmacy.dashboard') }}" class="btn btn-teal shadow-md">
                            <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            Pharmacy Desk
                        </a>
                        <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline shadow-xs">Inventory Control</a>
                    @elseif(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-teal shadow-md">Admin Analytics Panel</a>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline shadow-xs">User Management</a>
                    @endif
                @else
                    <a href="{{ route('patients.register') }}" class="btn btn-teal shadow-md">
                        <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        Register as a Patient
                    </a>
                    <a href="{{ route('appointments') }}" class="btn bg-white/10 hover:bg-white/20 text-white border border-white/25 backdrop-blur-md shadow-xs">
                        <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        Emergency Appointment
                    </a>
                    <a href="{{ route('login') }}" class="btn bg-white text-[#091e3a] hover:bg-slate-100 shadow-sm font-bold">
                        <svg class="size-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                        Portal Sign In
                    </a>
                @endauth
            </div>

            <div class="flex items-center gap-2 mt-4 text-xs text-teal-200/90 font-medium">
                <svg class="size-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Subsidized primary healthcare with valid University Student or Employee ID card.</span>
            </div>
        </div>

        {{-- Right Hero Live Campus Telemetry Card --}}
        <div class="lg:col-span-5">
            <div class="bg-black/35 backdrop-blur-md border border-white/15 rounded-2xl p-5 text-white shadow-xl">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-white/15">
                    <span class="text-xs font-bold uppercase tracking-wider text-teal-200 flex items-center gap-2">
                        <span class="size-2 rounded-full bg-[#14b8a6]"></span>
                        Campus Live Status
                    </span>
                    <span class="text-[11px] text-[#38bdf8] font-bold bg-sky-500/10 px-2.5 py-0.5 rounded-full border border-sky-400/20">Central Medical Hub</span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                        <div class="text-[11px] font-semibold text-slate-300">Doctors On Duty</div>
                        <div class="text-2xl font-black text-white mt-1">{{ $doctors->count() }}</div>
                        <div class="text-[10px] text-teal-300 mt-0.5 font-medium">OPD &amp; Emergency</div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                        <div class="text-[11px] font-semibold text-slate-300">Central Pharmacy</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">OPEN</div>
                        <div class="text-[10px] text-slate-300 mt-0.5 font-medium">Stock Dispensing</div>
                    </div>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-white/5 border border-white/10">
                        <span class="text-slate-300 font-medium">Standard OPD Hours:</span>
                        <span class="font-bold text-white">8:00 AM &ndash; 8:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-400/20 text-emerald-300">
                        <span class="font-medium flex items-center gap-1.5">
                            <span class="size-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Emergency Medical Unit:
                        </span>
                        <span class="font-bold">24/7 Active Shift</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Two Column Content Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 Columns: Core Services Grid + Duty Roster --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Modern Core Medical Services (6-Card Interactive Grid) --}}
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-5">
                <div>
                    <h2 class="text-base font-bold text-slate-900 tracking-tight">
                        Core Medical Centre Services
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Specialized healthcare units operating at Central Campus</p>
                </div>
                <span class="badge badge-teal">On-Campus Facility</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Service 1: General OPD --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-teal-500/40 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-xl bg-teal-50 text-[#0d9488] border border-teal-200/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-teal-700 transition-colors">General Medicine &amp; OPD</h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">Walk-in clinical examinations, acute illness treatments, health certifications, and specialist referrals.</p>
                        </div>
                    </div>
                </div>

                {{-- Service 2: Pharmacy --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-teal-500/40 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-xl bg-sky-50 text-[#0284c7] border border-sky-200/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><mpath d="M10.5 20.5 20.5 10.5a4.95 4.95 0 1 0-7-7L3.5 13.5a4.95 4.95 0 0 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-sky-700 transition-colors">Central Pharmacy &amp; Stock</h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">Direct subsidized dispensing of digital prescriptions with batch tracking and student ID verification.</p>
                        </div>
                    </div>
                </div>

                {{-- Service 3: Dental Clinic --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-teal-500/40 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a4 4 0 0 0-4 4v3a2 2 0 0 1-2 2H5a3 3 0 0 0-3 3v2a6 6 0 0 0 6 6h8a6 6 0 0 0 6-6v-2a3 3 0 0 0-3-3h-1a2 2 0 0 1-2-2V6a4 4 0 0 0-4-4z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-amber-800 transition-colors">Dental Clinic</h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">Comprehensive oral check-ups, teeth scaling, emergency toothache relief, and dental extractions.</p>
                        </div>
                    </div>
                </div>

                {{-- Service 4: 24/7 Emergency --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-rose-500/40 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-xl bg-rose-50 text-rose-600 border border-rose-200/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-rose-700 transition-colors">Emergency &amp; Ambulance</h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">Immediate paramedic resuscitation, trauma stabilization, and 24/7 emergency campus ambulance.</p>
                        </div>
                    </div>
                </div>

                {{-- Service 5: Diagnostics --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-teal-500/40 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-200/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2v17.5c0 1.4-1.1 2.5-2.5 2.5s-2.5-1.1-2.5-2.5V2"/><path d="M8.5 2h7"/><path d="M14.5 16h-5"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-700 transition-colors">Laboratory &amp; Diagnostics</h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">Rapid blood tests, urinalysis, glucose monitoring, and infection panels with fast electronic reporting.</p>
                        </div>
                    </div>
                </div>

                {{-- Service 6: Counselling --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-teal-500/40 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Mental Health &amp; Wellbeing</h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">Confidential psychological counselling, stress management, and student mental health advisory.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Doctors on Duty Today --}}
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900 tracking-tight">
                        Doctors on Duty Today
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Active shift schedule and consultation availability</p>
                </div>
                <span class="badge badge-cyan">Live Roster</span>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Physician</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Duty Shift</th>
                            <th class="text-right">Consultation Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $index => $doc)
                            @php
                                $shifts = [
                                    ['name' => 'Morning Shift', 'time' => '08:00am &ndash; 02:00pm', 'badge' => 'badge-cyan', 'status' => 'Available Now', 'status_badge' => 'badge-teal'],
                                    ['name' => 'Evening Shift', 'time' => '02:00pm &ndash; 08:00pm', 'badge' => 'badge-navy', 'status' => 'Available Now', 'status_badge' => 'badge-teal'],
                                    ['name' => 'Emergency Shift', 'time' => '08:00pm &ndash; 08:00am', 'badge' => 'badge-red', 'status' => 'On-Call Emergency', 'status_badge' => 'badge-red'],
                                ];
                                $shift = $shifts[$index % count($shifts)];
                            @endphp
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2.5">
                                        <div class="avatar-initials size-8 bg-gradient-to-br from-teal-500 to-teal-700 text-white text-xs shadow-xs">
                                            {{ substr($doc->name, strpos($doc->name, ' ') ? strpos($doc->name, ' ') + 1 : 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-xs">{{ $doc->name }}</div>
                                            <div class="text-[10px] text-slate-500">Room {{ 101 + $index }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-semibold text-slate-800 text-xs">{{ $doc->department ?? 'General Medicine' }}</span>
                                </td>
                                <td>
                                    <span class="text-xs text-slate-600">{{ $doc->designation ?? 'Medical Officer' }}</span>
                                </td>
                                <td>
                                    <div class="font-bold text-slate-800 text-xs">{!! $shift['time'] !!}</div>
                                    <span class="badge {{ $shift['badge'] }} text-[10px] mt-0.5 py-0 px-1.5">{{ $shift['name'] }}</span>
                                </td>
                                <td class="text-right">
                                    <span class="badge {{ $shift['status_badge'] }} text-[11px] font-bold">
                                        <span class="badge-dot {{ $shift['status_badge'] === 'badge-red' ? 'bg-red-500 animate-pulse' : 'bg-teal-500' }}"></span>
                                        {{ $shift['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center bg-slate-50/50">
                                    <div class="inline-flex size-10 rounded-full bg-teal-50 text-[#0d9488] items-center justify-center mb-2 border border-teal-100">
                                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                    <div class="text-xs font-semibold text-slate-700">Roster in Preparation</div>
                                    <p class="text-[11px] text-slate-500 max-w-sm mx-auto mt-0.5">Emergency Medical Officer is on active duty 24/7 at Room 101. Regular consultations resume during standard OPD hours.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 Column: Notice Board & Operating Hours --}}
    <div class="space-y-6">
        {{-- Notice Board --}}
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#091e3a] shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <svg class="size-4 text-[#091e3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Campus Notice Board
                </h2>
                <span class="badge badge-navy">Health Alerts</span>
            </div>

            <div class="space-y-3">
                <div class="p-3.5 rounded-xl border border-red-200 border-l-4 border-l-red-500 bg-red-50/40">
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="badge badge-red py-0 px-1.5 text-[10px]">URGENT</span>
                        <span class="font-bold text-xs text-red-950">Annual Health Screening</span>
                    </div>
                    <p class="text-xs text-red-900/80 leading-relaxed">Free routine clinical checkups for all 1st year students at Room 102.</p>
                </div>

                <div class="p-3.5 rounded-xl border border-sky-200 border-l-4 border-l-[#0284c7] bg-sky-50/40">
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="badge badge-cyan py-0 px-1.5 text-[10px]">VACCINATION</span>
                        <span class="font-bold text-xs text-sky-950">Seasonal Flu Vaccine Drive</span>
                    </div>
                    <p class="text-xs text-sky-900/80 leading-relaxed">Available at Pharmacy counter. Walk-ins accepted with student ID.</p>
                </div>

                <div class="p-3.5 rounded-xl border border-teal-200 border-l-4 border-l-[#0d9488] bg-teal-50/40">
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="badge badge-teal py-0 px-1.5 text-[10px]">GENERAL</span>
                        <span class="font-bold text-xs text-teal-950">Emergency Hotline 24/7</span>
                    </div>
                    <p class="text-xs text-teal-900/80 leading-relaxed">Direct dial <strong class="text-teal-800 font-bold">01888-888888</strong> for on-campus medical transport.</p>
                </div>
            </div>
        </div>

        {{-- Operating Hours --}}
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <svg class="size-4 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Operating Hours
                </h2>
                <span class="badge badge-teal">Schedule</span>
            </div>

            <div class="divide-y divide-slate-100 text-xs">
                {{-- Monday - Friday --}}
                <div class="py-3 first:pt-0 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-slate-800">Monday &ndash; Friday (Standard OPD)</span>
                        <span class="text-slate-900 font-bold">8:00am &ndash; 8:00pm</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-red-700 bg-red-50/80 px-2.5 py-1 rounded-lg border border-red-200/60">
                        <span class="font-semibold flex items-center gap-1.5">
                            <span class="size-1.5 rounded-full bg-red-600 animate-pulse"></span>Emergency Shift (Mon&ndash;Fri):
                        </span>
                        <span class="font-bold">8:00pm &ndash; 8:00am</span>
                    </div>
                </div>

                {{-- Saturday --}}
                <div class="py-3 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-slate-800">Saturday (Standard OPD)</span>
                        <span class="text-slate-900 font-bold">9:00am &ndash; 2:00pm</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-red-700 bg-red-50/80 px-2.5 py-1 rounded-lg border border-red-200/60">
                        <span class="font-semibold flex items-center gap-1.5">
                            <span class="size-1.5 rounded-full bg-red-600 animate-pulse"></span>Emergency Shift (Saturday):
                        </span>
                        <span class="font-bold">2:00pm &ndash; 8:00am</span>
                    </div>
                </div>

                {{-- Sunday --}}
                <div class="py-3 last:pb-0 space-y-1">
                    <div class="flex items-center justify-between text-red-700 font-bold">
                        <span>Sunday</span>
                        <span class="badge badge-red text-[10px]">24h Emergency Only</span>
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Trauma doctor on active duty &amp; campus ambulance available 24/7.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
