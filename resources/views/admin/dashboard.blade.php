@extends('layouts.app')
@section('title', 'System Reporting & Analytics')

@section('content')
{{-- Admin Header Ribbon --}}
<div class="bg-white border border-slate-200 rounded-lg p-6 mb-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="avatar-initials size-14 bg-gradient-to-br from-[#091e3a] to-[#0f2b48] text-white border border-[#0f766e] text-xl shadow-xs font-mono rounded">
            A
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-xl font-bold text-slate-900 font-heading">Executive Analytics Dashboard</h1>
                <span class="badge badge-navy text-xs font-bold">
                    <span class="badge-dot bg-teal-500"></span>
                    Director Access Level
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 flex items-center gap-2 flex-wrap">
                <span>Centralized Operations</span>
                <span>&bull;</span>
                <span>Clinical Load Monitoring</span>
                <span>&bull;</span>
                <span>Campus Pharmacy Inventory</span>
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2.5">
        <a href="{{ route('admin.users') }}" class="btn btn-teal btn-sm shadow-sm font-bold">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Manage System Users
        </a>
        <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline btn-sm shadow-xs">
            <svg class="size-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
            Central Stock
        </a>
    </div>
</div>

{{-- Operational Key Metrics (6 Stat Cards) --}}
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Registered Patients</span>
            <div class="stat-icon-box stat-icon-teal">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $stats['total_patients'] }}</div>
        <div class="stat-sub">Campus beneficiaries</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Clinical Staff</span>
            <div class="stat-icon-box stat-icon-blue">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>
            </div>
        </div>
        <div class="stat-val text-[#0284c7]">{{ $stats['total_doctors'] + $stats['total_pharmacists'] }}</div>
        <div class="stat-sub">{{ $stats['total_doctors'] }} Doctors &bull; {{ $stats['total_pharmacists'] }} Pharmacists</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Appointments This Month</span>
            <div class="stat-icon-box stat-icon-amber">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $stats['appointments_month'] }}</div>
        <div class="stat-sub">{{ $stats['appointments_today'] }} booked for today</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Prescriptions Generated</span>
            <div class="stat-icon-box stat-icon-navy">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-slate-900">{{ $stats['prescriptions_total'] }}</div>
        <div class="stat-sub">{{ $stats['prescriptions_dispensed'] }} fulfilled at pharmacy</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Low Stock Medicines</span>
            <div class="stat-icon-box stat-icon-red">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-val text-rose-600">{{ $stats['low_stock_count'] }}</div>
        <div class="stat-sub">Below reorder threshold</div>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between gap-3">
            <span class="stat-label">Near-Expiry Batches</span>
            <div class="stat-icon-box stat-icon-amber">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="stat-val text-amber-600">{{ $stats['near_expiry_count'] }}</div>
        <div class="stat-sub">Expiring within 60 days</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 cols: Department Breakdown & Recent Activity --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Department Utilization --}}
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    Department Clinical Load &amp; Utilization
                </span>
                <span class="badge badge-teal">Operational Metrics</span>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Department / Specialty</th>
                            <th>Total Visits Booked</th>
                            <th>Utilization Share</th>
                            <th class="text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departmentStats as $dept)
                            <tr>
                                <td><strong class="text-slate-900 text-xs">{{ $dept->department }}</strong></td>
                                <td><strong class="text-slate-800 font-mono">{{ $dept->count }}</strong> <span class="text-[11px] text-slate-500">consultations</span></td>
                                <td>
                                    @php
                                        $totalApts = max(1, $stats['appointments_month']);
                                        $percent = round(($dept->count / $totalApts) * 100);
                                    @endphp
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-teal-500 to-teal-700 h-2.5 rounded-full" style="width: {{ min(100, $percent) }}%;"></div>
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-1 font-semibold">{{ $percent }}% of monthly volume</div>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-teal font-bold">
                                        <span class="badge-dot bg-teal-500"></span>
                                        Operational
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-slate-400 text-xs">No department statistics recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Prescriptions Stream --}}
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg class="size-4 text-teal-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Recent System Prescriptions
                </span>
                <span class="text-xs text-teal-200 font-medium">Live Audit Trail</span>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Ref</th>
                            <th>Patient</th>
                            <th>Prescribing Doctor</th>
                            <th>Diagnosis</th>
                            <th class="text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPrescriptions as $rx)
                            <tr>
                                <td class="font-mono text-xs font-bold text-teal-800">{{ $rx->prescription_number }}</td>
                                <td class="font-bold text-slate-900 text-xs">{{ $rx->patient->full_name }}</td>
                                <td class="text-xs text-slate-700">Dr. {{ $rx->doctor->name }}</td>
                                <td class="text-xs text-slate-600 truncate max-w-[200px]">{{ Str::limit($rx->diagnosis, 35) }}</td>
                                <td class="text-right">
                                    <span class="badge {{ $rx->status === 'dispensed' ? 'badge-teal' : 'badge-yellow' }}">
                                        {{ ucfirst($rx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-slate-400 text-xs">No prescriptions recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 col: Admin Controls & Health Status --}}
    <div class="space-y-6">
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2 mb-3.5 flex items-center gap-2">
                <svg class="size-4 text-[#0d9488]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                User &amp; Security Controls
            </h3>
            <div class="space-y-2.5">
                <a href="{{ route('admin.users') }}" class="btn btn-teal w-full text-center shadow-xs font-bold">
                    <svg class="size-3.5 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Manage Users &amp; Roles &rarr;
                </a>
                <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline w-full text-center shadow-xs">
                    <svg class="size-3.5 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
                    Medicine Inventory Control
                </a>
                <a href="{{ route('doctor.queue') }}" class="btn btn-outline w-full text-center shadow-xs">
                    <svg class="size-3.5 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    View Live Consultation Queues
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
