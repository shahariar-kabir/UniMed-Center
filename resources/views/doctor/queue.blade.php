@extends('layouts.app')
@section('title', 'Consultation Queue Management')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Patient Consultation Queue Management</h1>
    <p class="page-subtitle">Department: <strong>{{ $doctor->department ?? 'General Medicine' }}</strong> &bull; Attending: <strong>{{ $doctor->name }}</strong></p>
</div>

<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden mb-6">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Active Queue &mdash; {{ date('d M Y') }}</span>
        <span class="badge badge-gold">{{ $todayQueues->count() }} In Line</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Token #</th>
                    <th>Patient Name</th>
                    <th>University ID &amp; Dept</th>
                    <th>Allergies &amp; Vitals</th>
                    <th>Wait Time</th>
                    <th>Queue Status</th>
                    <th>Clinical Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayQueues as $q)
                    <tr class="{{ $q->status === 'in_consultation' ? 'bg-emerald-50/60 border-l-4 border-l-[#1a6b3a]' : '' }}">
                        <td>
                            <strong class="text-[#1a6b3a] text-base">{{ $q->token_number }}</strong>
                        </td>
                        <td>
                            <strong class="text-slate-900">{{ $q->patient->full_name }}</strong>
                            <div class="text-[11px] text-gray-500">{{ ucfirst($q->patient->role_category) }} ({{ $q->patient->gender }})</div>
                        </td>
                        <td>
                            <div class="font-medium text-slate-800">{{ $q->patient->university_id }}</div>
                            <div class="text-[11px] text-gray-500">{{ $q->patient->department ?? 'General' }}</div>
                        </td>
                        <td>
                            @if($q->patient->allergies)
                                <span class="badge badge-red">{{ $q->patient->allergies }}</span>
                            @else
                                <span class="text-[11px] text-gray-400">No allergies</span>
                            @endif
                            <div class="text-[11px] text-gray-600 mt-1">Blood: <strong>{{ $q->patient->blood_group ?? 'N/A' }}</strong></div>
                        </td>
                        <td class="text-xs text-gray-500">
                            {{ $q->created_at->diffForHumans(null, true) }} ago
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
                            <span class="badge {{ $statusBadges[$q->status] ?? 'badge-gray' }}">
                                {{ str_replace('_', ' ', ucfirst($q->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <a href="{{ route('doctor.patients.history', $q->patient_id) }}" class="btn btn-outline btn-xs">History</a>

                                @if($q->status === 'waiting')
                                    <form action="{{ route('doctor.queue.call', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-green btn-xs">Call Patient</button>
                                    </form>
                                    <form action="{{ route('doctor.queue.skip', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-xs text-red-600 border-red-200 hover:bg-red-50">Skip</button>
                                    </form>
                                @elseif($q->status === 'in_consultation')
                                    <a href="{{ route('doctor.prescriptions.create', ['queue_id' => $q->id, 'patient_id' => $q->patient_id]) }}" class="btn btn-green btn-xs">Write Rx</a>
                                    <form action="{{ route('doctor.queue.complete', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-gold btn-xs">Complete</button>
                                    </form>
                                @else
                                    <span class="text-[11px] text-gray-400">Attended</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 text-xs">No patients currently in queue.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
