@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- Preline Balanced Hero Section --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#134d2a] via-[#1a6b3a] to-[#228448] text-white p-6 sm:p-8 lg:p-10 mb-8 shadow-sm border border-emerald-900/20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        {{-- Left Hero Text & Actions --}}
        <div class="lg:col-span-7">
            <div class="inline-flex items-center gap-x-2 py-1 px-3 rounded-full bg-white/10 backdrop-blur border border-white/20 text-xs font-semibold text-emerald-100 mb-3">
                <span class="size-2 rounded-full bg-[#c8922a]"></span> University Health Services
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight mb-3 text-white">
                University Medical Centre
            </h1>
            <p class="text-sm sm:text-base text-white/90 leading-relaxed mb-6 font-normal max-w-2xl">
                Centralized digital healthcare platform for students, faculty, and university personnel. Manage your patient profile, book doctor consultations, track live waiting queues, view and download prescriptions, and access pharmacy dispensing services.
            </p>

            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if(Auth::user()->isPatient())
                        <a href="{{ route('patient.dashboard') }}" class="btn btn-gold">Go to My Patient Dashboard</a>
                        <a href="{{ route('patient.queue') }}" class="btn btn-outline">View Live Queue</a>
                    @elseif(Auth::user()->isDoctor())
                        <a href="{{ route('doctor.dashboard') }}" class="btn btn-gold">Doctor Consultation Desk</a>
                        <a href="{{ route('doctor.queue') }}" class="btn btn-outline">Patient Queue</a>
                    @elseif(Auth::user()->isPharmacist())
                        <a href="{{ route('pharmacy.dashboard') }}" class="btn btn-gold">Pharmacy Desk</a>
                        <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline">Inventory Control</a>
                    @elseif(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-gold">Admin Analytics Panel</a>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline">User Management</a>
                    @endif
                @else
                    <a href="{{ route('patients.register') }}" class="btn btn-gold">Register as a Patient</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Portal Sign In</a>
                @endauth
            </div>

            <p class="text-xs text-emerald-100/80 mt-4 font-medium">
                * Subsidized primary medical care with valid University Student or Employee ID card.
            </p>
        </div>

        {{-- Right Hero Quick Overview Card --}}
        <div class="lg:col-span-5">
            <div class="bg-black/20 backdrop-blur-md border border-white/15 rounded-xl p-5 text-white shadow-inner">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/15">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-100">Healthcare Pillars</span>
                    <span class="text-[11px] text-[#c8922a] font-semibold">Campus Clinical Network</span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-x-3 p-2.5 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="size-7 rounded-md bg-[#c8922a]/20 border border-[#c8922a]/40 flex items-center justify-center shrink-0 text-[#c8922a] font-bold">
                            1
                        </div>
                        <div>
                            <div class="font-bold text-white">Outpatient Consultations</div>
                            <div class="text-emerald-100/80 text-[11px]">Walk-in triage &amp; scheduled visits with university medical officers.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-x-3 p-2.5 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="size-7 rounded-md bg-emerald-400/20 border border-emerald-400/40 flex items-center justify-center shrink-0 text-emerald-300 font-bold">
                            2
                        </div>
                        <div>
                            <div class="font-bold text-white">Digital Prescriptions</div>
                            <div class="text-emerald-100/80 text-[11px]">Direct electronic transmission from doctor desk to dispensary.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-x-3 p-2.5 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="size-7 rounded-md bg-amber-400/20 border border-amber-400/40 flex items-center justify-center shrink-0 text-amber-300 font-bold">
                            3
                        </div>
                        <div>
                            <div class="font-bold text-white">Central Dispensary</div>
                            <div class="text-emerald-100/80 text-[11px]">On-campus medicine inventory with batch &amp; expiry tracking.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Preline Two Column Content Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 Columns: Services + Duty Roster --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Core Services --}}
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl p-6">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">
                    Core Medical Centre Services
                </h2>
                <span class="badge badge-green">Available On Campus</span>
            </div>

            <div class="divide-y divide-gray-100">
                <div class="py-3.5 first:pt-0 last:pb-0 hover:bg-slate-50/80 px-2 rounded-lg transition-colors">
                    <h4 class="text-sm font-semibold text-slate-900 mb-0.5">General Medicine &amp; Consultation</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">Walk-in and appointment consultations for common illnesses, clinical assessments, and referral letters.</p>
                </div>

                <div class="py-3.5 hover:bg-slate-50/80 px-2 rounded-lg transition-colors">
                    <h4 class="text-sm font-semibold text-slate-900 mb-0.5">Dental Clinic</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">Dental check-ups, scaling, extractions, fillings, and emergency oral care.</p>
                </div>

                <div class="py-3.5 hover:bg-slate-50/80 px-2 rounded-lg transition-colors">
                    <h4 class="text-sm font-semibold text-slate-900 mb-0.5">Counselling &amp; Mental Health</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">Confidential mental health guidance and professional psychological counselling.</p>
                </div>

                <div class="py-3.5 hover:bg-slate-50/80 px-2 rounded-lg transition-colors">
                    <h4 class="text-sm font-semibold text-slate-900 mb-0.5">Laboratory &amp; Diagnostics</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">Routine diagnostic tests, blood work, urinalysis, and glucose screening with rapid turnaround.</p>
                </div>

                <div class="py-3.5 first:pt-0 last:pb-0 hover:bg-slate-50/80 px-2 rounded-lg transition-colors">
                    <h4 class="text-sm font-semibold text-slate-900 mb-0.5">Central Pharmacy &amp; Dispensary</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">Subsidized dispensing of prescribed medications directly from the medical centre inventory.</p>
                </div>
            </div>
        </div>

        {{-- Doctors on Duty --}}
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl p-6">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">
                    Doctors on Duty Today
                </h2>
                <span class="badge badge-blue">Live Roster</span>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-500 uppercase font-semibold">
                            <th class="py-3 px-4 text-left">Doctor</th>
                            <th class="py-3 px-4 text-left">Department</th>
                            <th class="py-3 px-4 text-left">Designation</th>
                            <th class="py-3 px-4 text-left">Duty Shift &amp; Timings</th>
                            <th class="py-3 px-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($doctors as $index => $doc)
                            @php
                                $shifts = [
                                    ['name' => 'Morning Shift', 'time' => '08:00am &ndash; 02:00pm', 'badge' => 'badge-blue', 'status' => 'On Duty', 'status_badge' => 'badge-green'],
                                    ['name' => 'Evening Shift', 'time' => '02:00pm &ndash; 08:00pm', 'badge' => 'badge-gold', 'status' => 'On Duty', 'status_badge' => 'badge-green'],
                                    ['name' => 'Emergency Shift', 'time' => '08:00pm &ndash; 08:00am', 'badge' => 'badge-red', 'status' => 'Emergency On-Call', 'status_badge' => 'badge-red'],
                                ];
                                $shift = $shifts[$index % count($shifts)];
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="font-bold py-3 px-4 text-slate-900">{{ $doc->name }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $doc->department ?? 'General Medicine' }}</td>
                                <td class="py-3 px-4 text-gray-500">{{ $doc->designation ?? 'Medical Officer' }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800">{!! $shift['time'] !!}</div>
                                    <span class="badge {{ $shift['badge'] }} text-[10px] mt-0.5">{{ $shift['name'] }}</span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <span class="badge {{ $shift['status_badge'] }}">{{ $shift['status'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-400 py-6">Doctor roster is being refreshed. Emergency Medical Officer on duty 24/7 at Room 101.</td>
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
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl p-6">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">
                    Campus Notice Board
                </h2>
                <span class="badge badge-gold">Health Alerts</span>
            </div>

            <div class="space-y-3.5">
                <div class="p-3.5 rounded-r-lg border border-red-200/80 border-l-4 border-l-red-500 bg-red-50/50">
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="badge badge-red">URGENT</span>
                        <span class="font-bold text-xs text-red-950">Annual Health Screening</span>
                    </div>
                    <p class="text-xs text-red-900/80 leading-relaxed">Free routine checkups for all 1st year students at Room 102.</p>
                </div>

                <div class="p-3.5 rounded-r-lg border border-amber-200/80 border-l-4 border-l-[#c8922a] bg-amber-50/50">
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="badge badge-gold">VACCINATION</span>
                        <span class="font-bold text-xs text-amber-950">Seasonal Flu Vaccine Drive</span>
                    </div>
                    <p class="text-xs text-amber-900/80 leading-relaxed">Available at Pharmacy counter. Walk-ins accepted with student ID.</p>
                </div>

                <div class="p-3.5 rounded-r-lg border border-emerald-200/80 border-l-4 border-l-[#1a6b3a] bg-emerald-50/50">
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="badge badge-green">GENERAL</span>
                        <span class="font-bold text-xs text-emerald-950">Emergency Hotline 24/7</span>
                    </div>
                    <p class="text-xs text-emerald-900/80 leading-relaxed">Call <strong class="text-emerald-800 font-bold">01888-888888</strong> for on-campus medical transport.</p>
                </div>
            </div>
        </div>

        {{-- Operating Hours --}}
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl p-6">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">
                    Operating Hours
                </h2>
                <span class="badge badge-green">Standard &amp; Emergency</span>
            </div>

            <div class="divide-y divide-gray-100 text-xs">
                {{-- Monday - Friday --}}
                <div class="py-3 first:pt-0 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-slate-800">Monday &ndash; Friday (Standard OPD)</span>
                        <span class="text-slate-900 font-bold">8:00am &ndash; 8:00pm</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-red-700 bg-red-50/80 px-2.5 py-1 rounded-md border border-red-200/60">
                        <span class="font-semibold flex items-center gap-1.5">
                            <span class="size-1.5 rounded-full bg-red-600 animate-pulse"></span>Emergency Shift (Mon&ndash;Fri):
                        </span>
                        <span class="font-bold">8:00pm &ndash; 8:00am (On-Call)</span>
                    </div>
                </div>

                {{-- Saturday --}}
                <div class="py-3 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-slate-800">Saturday (Standard OPD)</span>
                        <span class="text-slate-900 font-bold">9:00am &ndash; 2:00pm</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-red-700 bg-red-50/80 px-2.5 py-1 rounded-md border border-red-200/60">
                        <span class="font-semibold flex items-center gap-1.5">
                            <span class="size-1.5 rounded-full bg-red-600 animate-pulse"></span>Emergency Shift (Saturday):
                        </span>
                        <span class="font-bold">2:00pm &ndash; 8:00am (On-Call)</span>
                    </div>
                </div>

                {{-- Sunday --}}
                <div class="py-3 last:pb-0 space-y-1">
                    <div class="flex items-center justify-between text-red-700 font-bold">
                        <span>Sunday</span>
                        <span class="badge badge-red">24 Hours Emergency Only</span>
                    </div>
                    <div class="text-[11px] text-gray-500">
                        Trauma, on-call medical officer &amp; campus ambulance active 24/7.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
