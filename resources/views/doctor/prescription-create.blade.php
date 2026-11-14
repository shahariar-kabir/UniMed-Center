@extends('layouts.app')
@section('title', 'Generate Digital Prescription')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Digital Prescription Generator</h1>
    <p class="page-subtitle">Prescribe medicines directly from Central Pharmacy stock, specify dosages, duration, and clinical advice.</p>
</div>

@if($errors->any())
    <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-5 rounded-md text-xs text-red-800 shadow-xs" role="alert">
        <div class="font-bold mb-1">Please correct the following errors:</div>
        <ul class="list-disc list-inside space-y-0.5 ml-4">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('doctor.prescriptions.store') }}" method="POST" id="prescriptionForm">
    @csrf
    @if($queueId)
        <input type="hidden" name="queue_id" value="{{ $queueId }}">
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- Main Prescription Builder (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Patient Selection & Clinical Vitals --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                    <span class="text-xs font-bold uppercase tracking-wider font-heading">1. Patient &amp; Clinical Examination</span>
                    <span class="badge badge-cyan">Patient Vitals</span>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div>
                        <label class="form-label">Consulting Patient <span class="req">*</span></label>
                        <select name="patient_id" id="patientSelect" class="form-control" required onchange="updatePatientInfo(this)">
                            <option value="">&mdash; Select Patient &mdash;</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}"
                                    data-allergies="{{ $p->allergies }}"
                                    data-id="{{ $p->university_id }}"
                                    data-blood="{{ $p->blood_group }}"
                                    {{ (old('patient_id', $selectedPatient?->id) == $p->id) ? 'selected' : '' }}>
                                    {{ $p->full_name }} ({{ $p->university_id }}) &mdash; Blood: {{ $p->blood_group ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Vitals --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="form-label">BP (mmHg)</label>
                            <input type="text" name="bp" class="form-control" placeholder="120/80" value="{{ old('bp', '120/80') }}">
                        </div>
                        <div>
                            <label class="form-label">Pulse (bpm)</label>
                            <input type="text" name="pulse" class="form-control" placeholder="72" value="{{ old('pulse', '74') }}">
                        </div>
                        <div>
                            <label class="form-label">Temp (&deg;F)</label>
                            <input type="text" name="temperature" class="form-control" placeholder="98.6" value="{{ old('temperature', '98.6') }}">
                        </div>
                        <div>
                            <label class="form-label">Weight (kg)</label>
                            <input type="text" name="weight" class="form-control" placeholder="65" value="{{ old('weight', '68') }}">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Clinical Diagnosis <span class="req">*</span></label>
                        <textarea name="diagnosis" class="form-control" rows="2" placeholder="e.g. Acute Pharyngitis, Seasonal Rhinitis, Tension Headache..." required>{{ old('diagnosis') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Prescribed Medicines --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                    <span class="text-xs font-bold uppercase tracking-wider">2. Prescribed Medicines (From Stock)</span>
                    <button type="button" class="btn btn-outline-white btn-xs" onclick="addMedicineRow()">+ Add Medicine</button>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div id="medicinesContainer" class="space-y-4">
                        {{-- Row 0 --}}
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3.5 med-row" id="row_0">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                <div class="flex items-center gap-2">
                                    <span class="size-6 rounded-full bg-[#0d9488] text-white text-xs font-bold flex items-center justify-center">1</span>
                                    <strong class="text-xs font-bold text-slate-800 uppercase tracking-wide">Medicine Item #1</strong>
                                </div>
                                <button type="button" onclick="removeRow('row_0')" class="btn btn-outline btn-xs text-red-600 border-red-200 hover:bg-red-50">Remove</button>
                            </div>

                            {{-- 1. Medicine selection --}}
                            <div>
                                <label class="form-label">Select Medicine from Stock <span class="req">*</span></label>
                                <select name="medicines[0][medicine_id]" id="med_select_0" class="form-control med-select" required onchange="onMedSelect(this, 0)">
                                    <option value="">&mdash; Choose from Available Stock &mdash;</option>
                                    @foreach($medicines as $med)
                                        <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-instructions="{{ $med->instructions_default }}" data-stock="{{ $med->stock_quantity }}" data-unit="{{ $med->unit }}">
                                            {{ $med->name }} ({{ $med->strength }}) &mdash; Stock: {{ $med->stock_quantity }} {{ $med->unit }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="medicines[0][medicine_name]" id="med_name_0">
                            </div>

                            {{-- 2. Dynamic Dosage Selection (Morning, Noon, Night) --}}
                            <div class="p-3.5 bg-white rounded-lg border border-slate-200 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <label class="form-label mb-0 text-slate-800 font-bold">Dynamic Dosage Selection <span class="req">*</span></label>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] text-slate-500">Pattern:</span>
                                        <span class="text-xs font-black text-teal-800 font-mono bg-teal-50 px-2.5 py-0.5 rounded border border-teal-200" id="dosage_preview_0">1+0+1</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 text-center">
                                    <div class="p-2 rounded-md bg-slate-50 border border-slate-200">
                                        <span class="block text-[11px] font-semibold text-slate-700 mb-1">Morning (সকাল)</span>
                                        <select id="dose_morning_0" class="form-control py-1 px-2 text-xs text-center font-bold" onchange="onDoseChange(0)">
                                            <option value="0">0</option>
                                            <option value="0.5">1/2</option>
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                    <div class="p-2 rounded-md bg-slate-50 border border-slate-200">
                                        <span class="block text-[11px] font-semibold text-slate-700 mb-1">Noon (দুপুর)</span>
                                        <select id="dose_noon_0" class="form-control py-1 px-2 text-xs text-center font-bold" onchange="onDoseChange(0)">
                                            <option value="0" selected>0</option>
                                            <option value="0.5">1/2</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                    <div class="p-2 rounded-md bg-slate-50 border border-slate-200">
                                        <span class="block text-[11px] font-semibold text-slate-700 mb-1">Night (রাত)</span>
                                        <select id="dose_night_0" class="form-control py-1 px-2 text-xs text-center font-bold" onchange="onDoseChange(0)">
                                            <option value="0">0</option>
                                            <option value="0.5">1/2</option>
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Quick Dosage Presets --}}
                                <div class="flex items-center gap-1.5 flex-wrap pt-0.5">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Quick Presets:</span>
                                    <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(0, 1, 0, 1)">1+0+1</button>
                                    <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(0, 1, 1, 1)">1+1+1</button>
                                    <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(0, 1, 0, 0)">1+0+0</button>
                                    <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(0, 0, 0, 1)">0+0+1</button>
                                    <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(0, 0, 1, 0)">0+1+0</button>
                                    <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(0, 2, 0, 2)">2+0+2</button>
                                </div>

                                <input type="hidden" name="medicines[0][dosage]" id="dosage_0" value="1+0+1">
                            </div>

                            {{-- 3. Duration & Instructions --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label">Duration (Days) <span class="req">*</span></label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" id="dur_days_0" class="form-control w-24 text-center font-bold" min="1" max="180" value="7" oninput="onDurationChange(0)" required>
                                        <span class="text-xs font-semibold text-slate-500">Days</span>
                                        <input type="hidden" name="medicines[0][duration]" id="dur_0" value="7 days">
                                    </div>
                                    <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                                        <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(0, 3)">3d</button>
                                        <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(0, 5)">5d</button>
                                        <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(0, 7)">7d</button>
                                        <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(0, 10)">10d</button>
                                        <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(0, 14)">14d</button>
                                        <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(0, 30)">30d (1 mo)</button>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Instructions / Advice</label>
                                    <input type="text" name="medicines[0][instructions]" id="inst_0" class="form-control" placeholder="e.g. After meal" value="After meal">
                                    <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                                        <span class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-medium text-slate-600 cursor-pointer" onclick="setInstruction(0, 'After meal')">After meal</span>
                                        <span class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-medium text-slate-600 cursor-pointer" onclick="setInstruction(0, 'Before meal')">Before meal</span>
                                        <span class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-medium text-slate-600 cursor-pointer" onclick="setInstruction(0, 'With water')">With water</span>
                                    </div>
                                </div>
                            </div>

                            {{-- 4. Dynamic Total Quantity Display (Total Given Days x Dosages) --}}
                            <div class="p-3 bg-teal-50/70 border border-teal-200 rounded-lg flex flex-wrap items-center justify-between gap-2 shadow-xs">
                                <div class="flex items-center gap-2">
                                    <span class="size-2 rounded-full bg-[#0d9488]"></span>
                                    <span class="text-xs font-bold text-teal-950 uppercase tracking-wide">Total Dispensing Quantity:</span>
                                    <span class="text-sm font-black text-teal-900 font-mono" id="qty_display_0">14 tablets</span>
                                </div>
                                <div class="text-xs font-semibold text-teal-800" id="qty_breakdown_0">
                                    2 doses/day &times; 7 days = 14 tablets
                                </div>
                                <input type="hidden" name="medicines[0][quantity]" id="qty_0" value="14">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline btn-sm" onclick="addMedicineRow()">+ Add Another Medicine Row</button>
                </div>
            </div>

            {{-- Clinical Advice --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0f766e]">
                    <span class="text-xs font-bold uppercase tracking-wider font-heading">3. Clinical Advice &amp; Follow-up Instructions</span>
                    <span class="badge badge-cyan">Patient Guidance</span>
                </div>
                <div class="p-5 sm:p-6">
                    <textarea name="clinical_advice" class="form-control" rows="4" placeholder="Dietary restrictions, rest instructions, follow-up date, or alarm symptoms...">Drink plenty of warm fluids. Take adequate bed rest. Avoid cold foods/drinks. Return to medical centre if symptoms worsen or fever persists past 3 days.</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('doctor.queue') }}" class="btn btn-outline btn-sm">Cancel</a>
                <button type="submit" class="btn btn-teal btn-sm">Issue &amp; Generate Prescription &rarr;</button>
            </div>
        </div>

        {{-- Right Alerts & Dosage Legend (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-gray-200 border-t-4 border-t-red-600 shadow-sm rounded-lg p-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-red-700 border-b border-gray-200 pb-2 mb-3">
                    Patient Allergy Alert
                </h3>
                <div id="patientAllergyAlert" class="text-xs text-gray-600 leading-relaxed">
                    @if($selectedPatient)
                        <div><strong>Patient:</strong> {{ $selectedPatient->full_name }}</div>
                        <div class="mt-1"><strong>Allergies:</strong> <span class="text-red-700 font-bold">{{ $selectedPatient->allergies ?: 'None reported' }}</span></div>
                        <div class="mt-1"><strong>Blood Group:</strong> {{ $selectedPatient->blood_group ?? 'Not Set' }}</div>
                    @else
                        <span class="text-gray-400">Select a patient above to inspect their clinical drug allergies.</span>
                    @endif
                </div>
            </div>

            <div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-xl p-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                    Dosage Pattern Legend
                </h3>
                <div class="text-xs text-gray-600 space-y-2">
                    <div class="flex items-center justify-between"><code class="bg-slate-100 px-1.5 py-0.5 rounded font-bold text-slate-800">1+0+1</code> <span class="text-gray-500">Morning + Night</span></div>
                    <div class="flex items-center justify-between"><code class="bg-slate-100 px-1.5 py-0.5 rounded font-bold text-slate-800">1+1+1</code> <span class="text-gray-500">Morning + Noon + Night</span></div>
                    <div class="flex items-center justify-between"><code class="bg-slate-100 px-1.5 py-0.5 rounded font-bold text-slate-800">1+0+0</code> <span class="text-gray-500">Morning only</span></div>
                    <div class="flex items-center justify-between"><code class="bg-slate-100 px-1.5 py-0.5 rounded font-bold text-slate-800">0+0+1</code> <span class="text-gray-500">Night only</span></div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Hidden Template for Dynamic Rows --}}
<template id="medicineRowTemplate">
    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3.5 med-row" id="row_INDEX">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <div class="flex items-center gap-2">
                <span class="size-6 rounded-full bg-[#0d9488] text-white text-xs font-bold flex items-center justify-center">INDEX_PLUS</span>
                <strong class="text-xs font-bold text-slate-800 uppercase tracking-wide">Medicine Item #INDEX_PLUS</strong>
            </div>
            <button type="button" onclick="removeRow('row_INDEX')" class="btn btn-outline btn-xs text-red-600 border-red-200 hover:bg-red-50">Remove</button>
        </div>

        {{-- 1. Medicine selection --}}
        <div>
            <label class="form-label">Select Medicine from Stock <span class="req">*</span></label>
            <select name="medicines[INDEX][medicine_id]" id="med_select_INDEX" class="form-control med-select" required onchange="onMedSelect(this, INDEX)">
                <option value="">&mdash; Choose from Available Stock &mdash;</option>
                @foreach($medicines as $med)
                    <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-instructions="{{ $med->instructions_default }}" data-stock="{{ $med->stock_quantity }}" data-unit="{{ $med->unit }}">
                        {{ $med->name }} ({{ $med->strength }}) &mdash; Stock: {{ $med->stock_quantity }} {{ $med->unit }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="medicines[INDEX][medicine_name]" id="med_name_INDEX">
        </div>

        {{-- 2. Dynamic Dosage Selection (Morning, Noon, Night) --}}
        <div class="p-3.5 bg-white rounded-lg border border-slate-200 space-y-2.5">
            <div class="flex items-center justify-between">
                <label class="form-label mb-0 text-slate-800 font-bold">Dynamic Dosage Selection <span class="req">*</span></label>
                <div class="flex items-center gap-2">
                    <span class="text-[11px] text-slate-500">Pattern:</span>
                    <span class="text-xs font-black text-teal-800 font-mono bg-teal-50 px-2.5 py-0.5 rounded border border-teal-200" id="dosage_preview_INDEX">1+0+1</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="p-2 rounded-md bg-slate-50 border border-slate-200">
                    <span class="block text-[11px] font-semibold text-slate-700 mb-1">Morning (সকাল)</span>
                    <select id="dose_morning_INDEX" class="form-control py-1 px-2 text-xs text-center font-bold" onchange="onDoseChange(INDEX)">
                        <option value="0">0</option>
                        <option value="0.5">1/2</option>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="p-2 rounded-md bg-slate-50 border border-slate-200">
                    <span class="block text-[11px] font-semibold text-slate-700 mb-1">Noon (দুপুর)</span>
                    <select id="dose_noon_INDEX" class="form-control py-1 px-2 text-xs text-center font-bold" onchange="onDoseChange(INDEX)">
                        <option value="0" selected>0</option>
                        <option value="0.5">1/2</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="p-2 rounded-md bg-slate-50 border border-slate-200">
                    <span class="block text-[11px] font-semibold text-slate-700 mb-1">Night (রাত)</span>
                    <select id="dose_night_INDEX" class="form-control py-1 px-2 text-xs text-center font-bold" onchange="onDoseChange(INDEX)">
                        <option value="0">0</option>
                        <option value="0.5">1/2</option>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>

            {{-- Quick Dosage Presets --}}
            <div class="flex items-center gap-1.5 flex-wrap pt-0.5">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Quick Presets:</span>
                <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(INDEX, 1, 0, 1)">1+0+1</button>
                <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(INDEX, 1, 1, 1)">1+1+1</button>
                <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(INDEX, 1, 0, 0)">1+0+0</button>
                <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(INDEX, 0, 0, 1)">0+0+1</button>
                <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(INDEX, 0, 1, 0)">0+1+0</button>
                <button type="button" class="py-0.5 px-2 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[11px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="applyPresetDosage(INDEX, 2, 0, 2)">2+0+2</button>
            </div>

            <input type="hidden" name="medicines[INDEX][dosage]" id="dosage_INDEX" value="1+0+1">
        </div>

        {{-- 3. Duration & Instructions --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="form-label">Duration (Days) <span class="req">*</span></label>
                <div class="flex items-center gap-2">
                    <input type="number" id="dur_days_INDEX" class="form-control w-24 text-center font-bold" min="1" max="180" value="7" oninput="onDurationChange(INDEX)" required>
                    <span class="text-xs font-semibold text-slate-500">Days</span>
                    <input type="hidden" name="medicines[INDEX][duration]" id="dur_INDEX" value="7 days">
                </div>
                <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                    <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(INDEX, 3)">3d</button>
                    <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(INDEX, 5)">5d</button>
                    <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(INDEX, 7)">7d</button>
                    <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(INDEX, 10)">10d</button>
                    <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(INDEX, 14)">14d</button>
                    <button type="button" class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-bold text-slate-700 transition-colors cursor-pointer" onclick="setDurationDays(INDEX, 30)">30d (1 mo)</button>
                </div>
            </div>

            <div>
                <label class="form-label">Instructions / Advice</label>
                <input type="text" name="medicines[INDEX][instructions]" id="inst_INDEX" class="form-control" placeholder="e.g. After meal" value="After meal">
                <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                    <span class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-medium text-slate-600 cursor-pointer" onclick="setInstruction(INDEX, 'After meal')">After meal</span>
                    <span class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-medium text-slate-600 cursor-pointer" onclick="setInstruction(INDEX, 'Before meal')">Before meal</span>
                    <span class="py-0.5 px-1.5 rounded bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-[10px] font-medium text-slate-600 cursor-pointer" onclick="setInstruction(INDEX, 'With water')">With water</span>
                </div>
            </div>
        </div>

        {{-- 4. Dynamic Total Quantity Display (Total Given Days x Dosages) --}}
        <div class="p-3 bg-teal-50/70 border border-teal-200 rounded-lg flex flex-wrap items-center justify-between gap-2 shadow-xs">
            <div class="flex items-center gap-2">
                <span class="size-2 rounded-full bg-[#0d9488]"></span>
                <span class="text-xs font-bold text-teal-950 uppercase tracking-wide">Total Dispensing Quantity:</span>
                <span class="text-sm font-black text-teal-900 font-mono" id="qty_display_INDEX">14 tablets</span>
            </div>
            <div class="text-xs font-semibold text-teal-800" id="qty_breakdown_INDEX">
                2 doses/day &times; 7 days = 14 tablets
            </div>
            <input type="hidden" name="medicines[INDEX][quantity]" id="qty_INDEX" value="14">
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    let rowIndex = 1;

    function formatNumberLabel(num) {
        if (num === 0.5) return '1/2';
        return num.toString();
    }

    function calculateRowTotal(idx) {
        const morningEl = document.getElementById('dose_morning_' + idx);
        const noonEl = document.getElementById('dose_noon_' + idx);
        const nightEl = document.getElementById('dose_night_' + idx);
        const daysEl = document.getElementById('dur_days_' + idx);
        const selectEl = document.getElementById('med_select_' + idx);

        const m = morningEl ? parseFloat(morningEl.value) || 0 : 1;
        const n = noonEl ? parseFloat(noonEl.value) || 0 : 0;
        const e = nightEl ? parseFloat(nightEl.value) || 0 : 1;
        const days = daysEl ? Math.max(1, parseInt(daysEl.value, 10) || 1) : 7;

        // Daily doses
        const dailyDoses = m + n + e;
        const pattern = `${formatNumberLabel(m)}+${formatNumberLabel(n)}+${formatNumberLabel(e)}`;

        // Update hidden dosage input & preview
        const dosageHidden = document.getElementById('dosage_' + idx);
        if (dosageHidden) dosageHidden.value = pattern;
        const dosagePreview = document.getElementById('dosage_preview_' + idx);
        if (dosagePreview) dosagePreview.textContent = pattern;

        // Update hidden duration input
        const durHidden = document.getElementById('dur_' + idx);
        if (durHidden) durHidden.value = `${days} days`;

        // Total calculated quantity
        const totalQty = Math.max(1, Math.ceil(dailyDoses * days));

        // Get unit from selected medicine
        let unit = 'tablets';
        if (selectEl && selectEl.selectedIndex > 0) {
            const opt = selectEl.options[selectEl.selectedIndex];
            unit = opt.getAttribute('data-unit') || 'tablets';
        }

        // Update hidden quantity input
        const qtyHidden = document.getElementById('qty_' + idx);
        if (qtyHidden) qtyHidden.value = totalQty;

        // Update display badge
        const qtyDisplay = document.getElementById('qty_display_' + idx);
        if (qtyDisplay) qtyDisplay.textContent = `${totalQty} ${unit}`;

        // Update breakdown description
        const qtyBreakdown = document.getElementById('qty_breakdown_' + idx);
        if (qtyBreakdown) {
            qtyBreakdown.innerHTML = `${dailyDoses} doses/day &times; ${days} days = ${totalQty} ${unit}`;
        }
    }

    function onDoseChange(idx) {
        calculateRowTotal(idx);
    }

    function onDurationChange(idx) {
        calculateRowTotal(idx);
    }

    function applyPresetDosage(idx, m, n, e) {
        const morningEl = document.getElementById('dose_morning_' + idx);
        const noonEl = document.getElementById('dose_noon_' + idx);
        const nightEl = document.getElementById('dose_night_' + idx);

        if (morningEl) morningEl.value = m;
        if (noonEl) noonEl.value = n;
        if (nightEl) nightEl.value = e;

        calculateRowTotal(idx);
    }

    function setDurationDays(idx, days) {
        const daysEl = document.getElementById('dur_days_' + idx);
        if (daysEl) {
            daysEl.value = days;
            calculateRowTotal(idx);
        }
    }

    function setInstruction(idx, val) {
        const instEl = document.getElementById('inst_' + idx);
        if (instEl) instEl.value = val;
    }

    function onMedSelect(selectEl, idx) {
        const selected = selectEl.options[selectEl.selectedIndex];
        const medName = selected.getAttribute('data-name');
        const defaultInst = selected.getAttribute('data-instructions');

        const nameInput = document.getElementById('med_name_' + idx);
        if (nameInput) nameInput.value = medName || '';

        const instInput = document.getElementById('inst_' + idx);
        if (instInput && defaultInst && !instInput.value.trim()) {
            instInput.value = defaultInst;
        }

        calculateRowTotal(idx);
    }

    function addMedicineRow() {
        const container = document.getElementById('medicinesContainer');
        const template = document.getElementById('medicineRowTemplate').innerHTML;
        const newHtml = template
            .replace(/INDEX_PLUS/g, rowIndex + 1)
            .replace(/INDEX/g, rowIndex);

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newHtml;
        const newElement = tempDiv.firstElementChild;
        container.appendChild(newElement);

        calculateRowTotal(rowIndex);
        rowIndex++;
    }

    function removeRow(rowId) {
        const rows = document.querySelectorAll('.med-row');
        if (rows.length <= 1) {
            alert('At least one medicine is required on a digital prescription.');
            return;
        }
        const row = document.getElementById(rowId);
        if (row) row.remove();
    }

    function updatePatientInfo(selectEl) {
        const opt = selectEl.options[selectEl.selectedIndex];
        const alertBox = document.getElementById('patientAllergyAlert');
        if (!opt.value) {
            alertBox.innerHTML = '<span class="text-gray-400">Select a patient above to inspect their clinical drug allergies.</span>';
            return;
        }

        const allergies = opt.getAttribute('data-allergies') || 'None reported';
        const blood = opt.getAttribute('data-blood') || 'Not Set';
        const id = opt.getAttribute('data-id');

        alertBox.innerHTML = `
            <div><strong>Patient ID:</strong> ${id}</div>
            <div class="mt-1"><strong>Allergies:</strong> <span class="text-red-700 font-bold">${allergies}</span></div>
            <div class="mt-1"><strong>Blood Group:</strong> ${blood}</div>
        `;
    }

    document.addEventListener('DOMContentLoaded', function() {
        calculateRowTotal(0);

        const sel = document.getElementById('med_select_0');
        if (sel && sel.selectedIndex > 0) {
            onMedSelect(sel, 0);
        }
    });
</script>
@endpush
