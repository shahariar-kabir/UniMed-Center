@extends('layouts.app')
@section('title', 'Doctor Consultation Desk')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Doctor Consultation Desk &mdash; {{ $doctor->name }}</h1>
    <p class="page-subtitle">{{ $doctor->designation ?? 'Medical Officer' }} &bull; Department: <strong>{{ $doctor->department ?? 'General Medicine' }}</strong></p>
</div>

{{-- Active Patient in Consultation Card --}}
@if($activePatientQueue)
    <div class="bg-white border-2 border-[#1a6b3a] rounded-xl p-5 mb-6 shadow-sm">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <span class="badge badge-green font-bold">PATIENT IN CONSULTATION NOW</span>
            <span class="text-xs text-gray-500">Called at: {{ $activePatientQueue->called_at?->format('h:i A') }}</span>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="text-xl font-bold text-[#134d2a]">
                    Token {{ $activePatientQueue->token_number }} &mdash; {{ $activePatientQueue->patient->full_name }}
                </div>
                <div class="text-xs text-gray-600 mt-1 flex flex-wrap gap-x-3 gap-y-1">
                    <span>University ID: <strong>{{ $activePatientQueue->patient->university_id }}</strong></span>
                    <span>&bull;</span>
                    <span>Blood Group: <strong>{{ $activePatientQueue->patient->blood_group ?? 'N/A' }}</strong></span>
                    <span>&bull;</span>
                    <span>Allergies: <strong class="text-red-700">{{ $activePatientQueue->patient->allergies ?: 'None' }}</strong></span>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('doctor.patients.history', $activePatientQueue->patient_id) }}" class="btn btn-outline btn-sm">View Medical History</a>
                <a href="{{ route('doctor.prescriptions.create', ['queue_id' => $activePatientQueue->id, 'patient_id' => $activePatientQueue->patient_id]) }}" class="btn btn-green btn-sm">Generate Digital Prescription</a>
                <form action="{{ route('doctor.queue.complete', $activePatientQueue->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-gold btn-sm">Complete Consultation</button>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- Duty Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card gold">
        <div class="stat-val">{{ $waitingCount }}</div>
        <div class="stat-label">Patients Waiting</div>
        <div class="stat-sub">In queue outside</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">{{ $completedTodayCount }}</div>
        <div class="stat-label">Consultations Done</div>
        <div class="stat-sub">Attended today</div>
    </div>
    <div class="stat-card">
        <div class="stat-val">{{ $recentPrescriptions->count() }}</div>
        <div class="stat-label">Prescriptions Issued</div>
        <div class="stat-sub">Recent clinical orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-val text-emerald-700">ONLINE</div>
        <div class="stat-label">Duty Status</div>
        <div class="stat-sub">Accepting consultation queue</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left 2 cols: Consultation Queue & Prescriptions --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">Today's Consultation Queue &mdash; {{ $doctor->department }}</span>
                <a href="{{ route('doctor.queue') }}" class="text-xs text-emerald-200 hover:underline">Manage Queue &rarr;</a>
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
                            <tr class="{{ $q->status === 'in_consultation' ? 'bg-emerald-50/50' : '' }}">
                                <td><strong class="text-[#1a6b3a] text-sm">{{ $q->token_number }}</strong></td>
                                <td>
                                    <div class="font-bold text-slate-900">{{ $q->patient->full_name }}</div>
                                    <div class="text-[11px] text-gray-500">Allergies: {{ $q->patient->allergies ?: 'None' }}</div>
                                </td>
                                <td>
                                    <div class="font-medium text-slate-800">{{ $q->patient->university_id }}</div>
                                    <div class="text-[11px] text-gray-500">{{ ucfirst($q->patient->role_category) }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $q->status === 'in_consultation' ? 'badge-green' : ($q->status === 'completed' ? 'badge-blue' : 'badge-yellow') }}">
                                        {{ str_replace('_', ' ', ucfirst($q->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        @if($q->status === 'waiting')
                                            <form action="{{ route('doctor.queue.call', $q->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-green btn-xs">Call Patient</button>
                                            </form>
                                        @elseif($q->status === 'in_consultation')
                                            <a href="{{ route('doctor.prescriptions.create', ['queue_id' => $q->id, 'patient_id' => $q->patient_id]) }}" class="btn btn-gold btn-xs">Write Rx</a>
                                        @else
                                            <span class="text-[11px] text-gray-400">Completed</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400 text-xs">No patients currently in your department queue.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">Recent Prescriptions Generated by You</span>
                <span class="badge badge-gold">Clinical Orders</span>
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
                                <td class="font-mono text-xs font-bold text-slate-800">{{ $rx->prescription_number }}</td>
                                <td class="font-medium text-slate-900">{{ $rx->patient->full_name }}</td>
                                <td class="text-xs text-gray-600 max-w-[200px] truncate">{{ Str::limit($rx->diagnosis, 35) }}</td>
                                <td class="text-xs text-gray-700">{{ $rx->items->count() }} item(s)</td>
                                <td>
                                    <span class="badge {{ $rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow' }}">
                                        {{ ucfirst($rx->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs">View Rx</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400 text-xs">No prescriptions issued today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right 1 col: Quick Actions & Protocol --}}
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Clinical Quick Actions
            </h3>
            <div class="space-y-2">
                <a href="{{ route('doctor.prescriptions.create') }}" class="btn btn-green w-full text-center">Generate Digital Prescription</a>
                <a href="{{ route('doctor.queue') }}" class="btn btn-outline w-full text-center">Open Full Queue Desk</a>
                <a href="{{ route('pharmacy.inventory') }}" class="btn btn-outline w-full text-center">Check Medicine Inventory</a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Consultation Protocol
            </h3>
            <ul class="space-y-2 text-xs text-gray-600 leading-relaxed list-disc list-inside">
                <li>Verify student/staff identity and known drug allergies before prescribing.</li>
                <li>Digital prescriptions are routed directly to the Central Pharmacy inventory desk.</li>
                <li>Use standard dosage format (e.g. <code class="bg-gray-100 px-1 py-0.5 rounded text-slate-800">1+0+1</code>) for clarity.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
