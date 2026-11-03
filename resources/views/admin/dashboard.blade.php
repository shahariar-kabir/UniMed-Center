@extends('layouts.app')
@section('title', 'System Reporting & Analytics')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Executive Analytics Dashboard</h1>
    <p class="page-subtitle">Centralized operational reporting, department clinical load, medicine inventory monitoring, and user authorization controls.</p>
</div>

{{-- Operational Key Metrics --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">{{ $stats['total_patients'] }}</div>
        <div class="stat-label">Registered Patients</div>
        <div class="stat-sub">Students, staff &amp; faculty</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">{{ $stats['total_doctors'] + $stats['total_pharmacists'] }}</div>
        <div class="stat-label">Active Staff</div>
        <div class="stat-sub">{{ $stats['total_doctors'] }} Doctors, {{ $stats['total_pharmacists'] }} Pharmacists</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">{{ $stats['appointments_month'] }}</div>
        <div class="stat-label">Appointments This Month</div>
        <div class="stat-sub">{{ $stats['appointments_today'] }} booked for today</div>
    </div>
    <div class="stat-card">
        <div class="stat-val">{{ $stats['prescriptions_total'] }}</div>
        <div class="stat-label">Prescriptions Generated</div>
        <div class="stat-sub">{{ $stats['prescriptions_dispensed'] }} fulfilled by pharmacy</div>
    </div>
    <div class="stat-card red">
        <div class="stat-val">{{ $stats['low_stock_count'] }}</div>
        <div class="stat-label">Low Stock Medicines</div>
        <div class="stat-sub">Below reorder threshold</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">{{ $stats['near_expiry_count'] }}</div>
        <div class="stat-label">Near-Expiry Batches</div>
        <div class="stat-sub">Expiring within 60 days</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 cols: Department Breakdown & Recent Activity --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Department Utilization --}}
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">Department Clinical Load &amp; Utilization</span>
                <span class="badge badge-green">Operational Metrics</span>
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
                                <td><strong class="text-slate-900">{{ $dept->department }}</strong></td>
                                <td><strong class="text-slate-800">{{ $dept->count }}</strong> consultations</td>
                                <td>
                                    @php
                                        $totalApts = max(1, $stats['appointments_month']);
                                        $percent = round(($dept->count / $totalApts) * 100);
                                    @endphp
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-[#1a6b3a] h-2.5 rounded-full" style="width: {{ min(100, $percent) }}%;"></div>
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-1">{{ $percent }}% of monthly volume</div>
                                </td>
                                <td class="text-right"><span class="badge badge-green">Operational</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-400 text-xs">No department statistics recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Prescriptions Stream --}}
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">Recent System Prescriptions</span>
                <span class="text-xs text-emerald-200 font-normal">Live Audit Trail</span>
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
                                <td class="font-mono text-xs font-bold text-slate-800">{{ $rx->prescription_number }}</td>
                                <td class="font-medium text-slate-900">{{ $rx->patient->full_name }}</td>
                                <td class="text-xs text-slate-700">{{ $rx->doctor->name }}</td>
                                <td class="text-xs text-gray-600 truncate max-w-[200px]">{{ Str::limit($rx->diagnosis, 35) }}</td>
                                <td class="text-right">
                                    <span class="badge {{ $rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow' }}">
                                        {{ ucfirst($rx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400 text-xs">No prescriptions recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 col: Admin Controls & Health Status --}}
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                User &amp; Security Controls
            </h3>
            <div class="space-y-2">
                <a href="{{ route('admin.users') }}" class="btn btn-green w-full text-center">Manage Users &amp; Roles &rarr;</a>
                <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline w-full text-center">Medicine Inventory Control</a>
                <a href="{{ route('doctor.queue') }}" class="btn btn-outline w-full text-center">View Live Consultation Queues</a>
            </div>
        </div>
    </div>
</div>
@endsection
