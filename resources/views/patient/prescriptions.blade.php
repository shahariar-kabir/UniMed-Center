@extends('layouts.app')
@section('title', 'My Prescriptions')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Digital Prescription Portal &amp; PDF Downloads</h1>
    <p class="page-subtitle">Access all digital medical prescriptions issued by University Medical Centre doctors. View medicines, clinical instructions, and download official printable PDF documents.</p>
</div>

<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden mb-6">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Prescription History</span>
        <span class="badge badge-gold">{{ $prescriptions->count() }} Records</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Prescription #</th>
                    <th>Date Issued</th>
                    <th>Prescribing Doctor</th>
                    <th>Diagnosis</th>
                    <th>Medicines Prescribed</th>
                    <th>Pharmacy Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $rx)
                    <tr>
                        <td>
                            <strong class="text-[#1a6b3a] font-mono text-sm">{{ $rx->prescription_number }}</strong>
                        </td>
                        <td class="text-xs text-gray-600">{{ $rx->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <strong class="text-slate-900 text-xs">{{ $rx->doctor->name }}</strong>
                            <div class="text-[11px] text-gray-500">{{ $rx->doctor->department }}</div>
                        </td>
                        <td class="max-w-[220px]">
                            <strong class="text-xs text-slate-800">{{ $rx->diagnosis }}</strong>
                            @if($rx->bp || $rx->temperature)
                                <div class="text-[11px] text-gray-500 mt-0.5">
                                    BP: {{ $rx->bp ?? 'N/A' }} | Temp: {{ $rx->temperature ?? 'N/A' }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <ul class="text-xs text-gray-700 list-disc list-inside space-y-0.5">
                                @foreach($rx->items as $item)
                                    <li><strong>{{ $item->medicine_name }}</strong> ({{ $item->dosage }}, {{ $item->duration }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($rx->status === 'dispensed')
                                <span class="badge badge-green">Dispensed</span>
                                <div class="text-[10px] text-gray-400 mt-0.5">From Central Pharmacy</div>
                            @else
                                <span class="badge badge-yellow">Active / Ready to Dispense</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs">View Details</a>
                                <a href="{{ route('patient.prescriptions.pdf', $rx->id) }}" class="btn btn-green btn-xs" title="Download official PDF format">
                                    PDF &darr;
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 text-xs">No prescriptions found in your medical records.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
