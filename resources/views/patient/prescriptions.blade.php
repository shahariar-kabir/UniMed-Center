@extends('layouts.app')
@section('title', 'My Prescriptions')

@section('content')
{{-- Prescriptions Portal Header --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-2xl p-6 mb-6 shadow-sm border-b-4 border-[#0d9488] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-2xl bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0">
            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-gold text-[11px]">Digital Medical Records</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-semibold border border-emerald-400/30">
                    <span class="badge-dot bg-emerald-400"></span>
                    <span>Digitally Verified Records</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-white">Digital Prescription Portal &amp; PDF Downloads</h1>
            <p class="text-xs text-teal-100/80">Access all clinical medical prescriptions issued by University Medical Centre doctors. Download official printable PDF documents.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('patient.queue') }}" class="btn btn-outline-white btn-sm flex items-center gap-1.5">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <span>Live Queue &rarr;</span>
        </a>
    </div>
</div>

{{-- Prescriptions Table --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Clinical Prescription Records</span>
                <span class="text-[11px] text-teal-200/80">{{ $prescriptions->count() }} Prescriptions on File</span>
            </div>
        </div>
        <span class="badge badge-gold text-[11px]">{{ $prescriptions->count() }} Documents</span>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-32">Prescription #</th>
                    <th>Date Issued</th>
                    <th>Prescribing Physician</th>
                    <th>Clinical Diagnosis &amp; Vitals</th>
                    <th>Prescribed Medicines</th>
                    <th>Pharmacy Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $rx)
                    <tr>
                        <td>
                            <div class="space-y-1">
                                <span class="font-mono font-bold text-xs text-[#091e3a] bg-slate-100 px-2 py-1 rounded border border-slate-200 block w-fit">
                                    {{ $rx->prescription_number }}
                                </span>
                            </div>
                        </td>
                        <td class="text-xs text-slate-600 font-mono">
                            {{ $rx->created_at->format('d M Y') }}
                            <div class="text-[11px] text-slate-400">{{ $rx->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="size-8 rounded-lg bg-teal-500/10 text-[#0d9488] flex items-center justify-center font-bold text-xs shrink-0 border border-teal-500/20">
                                    Dr
                                </div>
                                <div>
                                    <strong class="text-slate-900 block text-xs">Dr. {{ $rx->doctor->name }}</strong>
                                    <span class="text-[11px] text-slate-500">{{ $rx->doctor->department ?? 'General Medicine' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="max-w-[220px]">
                            <strong class="text-xs text-slate-800 block">{{ $rx->diagnosis }}</strong>
                            @if($rx->bp || $rx->temperature)
                                <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-2 font-mono">
                                    <span>BP: {{ $rx->bp ?? 'N/A' }}</span>
                                    <span>&bull;</span>
                                    <span>Temp: {{ $rx->temperature ?? 'N/A' }}&deg;F</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="space-y-1 text-xs">
                                @foreach($rx->items as $item)
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <strong class="text-slate-900">{{ $item->medicine_name }}</strong>
                                        <span class="text-[10px] font-mono font-bold text-teal-800 bg-teal-50 px-1.5 py-0.2 rounded border border-teal-200">{{ $item->dosage }}</span>
                                        <span class="text-[11px] text-slate-500">({{ $item->duration }})</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @if($rx->status === 'dispensed')
                                <span class="badge badge-green inline-flex items-center gap-1 text-[11px]">
                                    <span class="badge-dot bg-emerald-500"></span>
                                    <span>Dispensed</span>
                                </span>
                                <div class="text-[10px] text-slate-400 mt-0.5">Central Pharmacy</div>
                            @else
                                <span class="badge badge-yellow inline-flex items-center gap-1 text-[11px]">
                                    <span class="badge-dot bg-amber-500"></span>
                                    <span>Active / Ready to Collect</span>
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="btn btn-outline btn-xs" title="View digital details">
                                    <span>View</span>
                                </a>
                                <a href="{{ route('patient.prescriptions.pdf', $rx->id) }}" class="btn btn-green btn-xs flex items-center gap-1 shadow-xs" title="Download official printable PDF format">
                                    <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                    <span>PDF</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 bg-slate-50/40">
                            <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-2.5">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </div>
                            <div class="text-xs font-bold text-slate-800">No Prescriptions On File</div>
                            <p class="text-[11px] text-slate-500 max-w-xs mx-auto mt-0.5">When attending a doctor consultation, issued digital prescriptions and medicine orders will appear here.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
