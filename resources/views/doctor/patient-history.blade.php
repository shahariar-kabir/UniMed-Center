@extends('layouts.app')
@section('title', 'Patient Medical History - ' . $patient->full_name)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-200">
    <div>
        <h1 class="page-title">Medical Record &amp; History &mdash; {{ $patient->full_name }}</h1>
        <div class="text-xs text-gray-600 flex flex-wrap items-center gap-x-3 gap-y-1 mt-1">
            <span>University ID: <strong>{{ $patient->university_id }}</strong></span>
            <span>&bull;</span>
            <span>Department: <strong>{{ $patient->department ?? 'General' }}</strong></span>
            <span>&bull;</span>
            <span>Blood Group: <strong class="text-red-700">{{ $patient->blood_group ?? 'Not Set' }}</strong></span>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('doctor.prescriptions.create', ['patient_id' => $patient->id]) }}" class="btn btn-green btn-sm">Generate New Prescription</a>
        <a href="javascript:history.back()" class="btn btn-outline btn-sm">&larr; Back</a>
    </div>
</div>

{{-- Medical Alerts Banner --}}
<div class="bg-white border border-gray-200 border-l-4 border-l-red-600 rounded-xl p-5 mb-6 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
        <div>
            <strong class="text-red-700 uppercase tracking-wider text-[11px] block mb-1">Known Allergies</strong>
            <p class="font-bold text-slate-800">{{ $patient->allergies ?: 'No known drug or food allergies' }}</p>
        </div>
        <div>
            <strong class="text-slate-700 uppercase tracking-wider text-[11px] block mb-1">Pre-existing Medical Conditions</strong>
            <p class="text-gray-600">
                @if(!empty($patient->conditions) && is_array($patient->conditions))
                    {{ implode(', ', $patient->conditions) }}
                @else
                    None reported
                @endif
            </p>
        </div>
        <div>
            <strong class="text-slate-700 uppercase tracking-wider text-[11px] block mb-1">Current Routine Medications</strong>
            <p class="text-gray-600">{{ $patient->medications ?: 'None reported' }}</p>
        </div>
        <div>
            <strong class="text-slate-700 uppercase tracking-wider text-[11px] block mb-1">Emergency Contact</strong>
            <p class="text-gray-600">{{ $patient->emergency_name ?? 'N/A' }} ({{ $patient->emergency_phone ?? 'N/A' }})</p>
        </div>
    </div>
</div>

{{-- Past Prescriptions History --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden mb-6">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Prescription History ({{ $patient->prescriptions->count() }})</span>
        <span class="badge badge-gold">Clinical Records</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rx Reference</th>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Diagnosis &amp; Vitals</th>
                    <th>Prescribed Medicines</th>
                    <th>Clinical Advice</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->prescriptions as $rx)
                    <tr>
                        <td>
                            <strong class="text-[#1a6b3a] font-mono text-xs">{{ $rx->prescription_number }}</strong>
                            <div class="mt-1">
                                <span class="badge {{ $rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow' }}">
                                    {{ ucfirst($rx->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="text-xs text-gray-600">{{ $rx->created_at->format('d M Y') }}</td>
                        <td class="text-xs font-medium text-slate-800">{{ $rx->doctor->name }}</td>
                        <td>
                            <strong class="text-xs text-slate-900">{{ $rx->diagnosis }}</strong>
                            <div class="text-[11px] text-gray-500 mt-0.5">
                                BP: {{ $rx->bp ?: 'N/A' }} &bull; Temp: {{ $rx->temperature ?: 'N/A' }} &bull; Wt: {{ $rx->weight ?: 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <ul class="text-xs text-gray-700 list-disc list-inside space-y-0.5">
                                @foreach($rx->items as $item)
                                    <li><strong>{{ $item->medicine_name }}</strong> &mdash; {{ $item->dosage }} ({{ $item->duration }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-xs text-gray-600 max-w-[200px] truncate">
                            {{ Str::limit($rx->clinical_advice, 60) }}
                        </td>
                        <td class="text-right">
                            <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs">Full Rx</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 text-xs">No past prescriptions recorded for this patient.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Past Appointments History --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Consultation &amp; Appointment History</span>
        <span class="badge badge-gold">Visits</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Date &amp; Time</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Reason for Consultation</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->appointments as $apt)
                    <tr>
                        <td><strong class="font-mono text-xs text-slate-800">{{ $apt->appointment_number }}</strong></td>
                        <td>
                            <div class="text-xs text-slate-800">{{ $apt->appointment_date->format('d M Y') }}</div>
                            <div class="text-[11px] font-bold text-emerald-700">{{ $apt->time_slot }}</div>
                        </td>
                        <td class="text-xs text-slate-900 font-medium">{{ $apt->department }}</td>
                        <td class="text-xs text-gray-600">{{ $apt->doctor?->name ?? 'Attending Officer' }}</td>
                        <td class="text-xs text-gray-600">{{ $apt->reason ?: 'General health evaluation' }}</td>
                        <td class="text-right"><span class="badge badge-green">{{ ucfirst($apt->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 text-xs">No previous appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
