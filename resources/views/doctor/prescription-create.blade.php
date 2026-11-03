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
            <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
                <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider">1. Patient &amp; Clinical Examination</span>
                    <span class="badge badge-gold">Patient Vitals</span>
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
            <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
                <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider">2. Prescribed Medicines (From Stock)</span>
                    <button type="button" class="btn btn-outline btn-xs" onclick="addMedicineRow()">+ Add Medicine</button>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div id="medicinesContainer" class="space-y-4">
                        {{-- Row 0 --}}
                        <div class="p-4 rounded-lg bg-slate-50 border border-gray-200 space-y-3 med-row" id="row_0">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <strong class="text-xs font-bold text-[#1a6b3a] uppercase">Medicine Item #1</strong>
                                <button type="button" onclick="removeRow('row_0')" class="btn btn-outline btn-xs text-red-600 border-red-200 hover:bg-red-50">Remove</button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="sm:col-span-2">
                                    <label class="form-label">Select Medicine from Stock <span class="req">*</span></label>
                                    <select name="medicines[0][medicine_id]" class="form-control med-select" required onchange="onMedSelect(this, 0)">
                                        <option value="">&mdash; Choose from Available Stock &mdash;</option>
                                        @foreach($medicines as $med)
                                            <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-instructions="{{ $med->instructions_default }}" data-stock="{{ $med->stock_quantity }}">
                                                {{ $med->name }} ({{ $med->strength }}) &mdash; Stock: {{ $med->stock_quantity }} {{ $med->unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="medicines[0][medicine_name]" id="med_name_0">
                                </div>
                                <div>
                                    <label class="form-label">Total Qty <span class="req">*</span></label>
                                    <input type="number" name="medicines[0][quantity]" class="form-control" min="1" value="10" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="form-label">Dosage (Pattern) <span class="req">*</span></label>
                                    <input type="text" name="medicines[0][dosage]" id="dosage_0" class="form-control text-xs" placeholder="e.g. 1+0+1" value="1+0+1" required>
                                    <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(0, '1+0+1')">1+0+1</span>
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(0, '1+1+1')">1+1+1</span>
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(0, '1+0+0')">1+0+0</span>
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(0, '0+0+1')">0+0+1</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Duration <span class="req">*</span></label>
                                    <input type="text" name="medicines[0][duration]" id="dur_0" class="form-control text-xs" placeholder="e.g. 5 days" value="5 days" required>
                                    <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDuration(0, '3 days')">3d</span>
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDuration(0, '5 days')">5d</span>
                                        <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDuration(0, '7 days')">7d</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Instructions / Advice</label>
                                    <input type="text" name="medicines[0][instructions]" id="inst_0" class="form-control text-xs" placeholder="e.g. After meal" value="After meal">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline btn-sm" onclick="addMedicineRow()">+ Add Another Medicine Row</button>
                </div>
            </div>

            {{-- Clinical Advice --}}
            <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden">
                <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider">3. Clinical Advice &amp; Follow-up Instructions</span>
                    <span class="badge badge-gold">Patient Guidance</span>
                </div>
                <div class="p-5 sm:p-6">
                    <textarea name="clinical_advice" class="form-control" rows="3" placeholder="Dietary restrictions, rest instructions, follow-up date, or alarm symptoms...">Drink plenty of warm fluids. Take adequate bed rest. Avoid cold foods/drinks. Return to medical centre if symptoms worsen or fever persists past 3 days.</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('doctor.queue') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-green py-2.5 px-6">Issue &amp; Generate Prescription &rarr;</button>
            </div>
        </div>

        {{-- Right Alerts & Dosage Legend (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-gray-200 border-t-4 border-t-red-600 shadow-sm rounded-xl p-5">
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

            <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl p-5">
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
    <div class="p-4 rounded-lg bg-slate-50 border border-gray-200 space-y-3 med-row" id="row_INDEX">
        <div class="flex items-center justify-between border-b border-gray-200 pb-2">
            <strong class="text-xs font-bold text-[#1a6b3a] uppercase">Medicine Item #INDEX_PLUS</strong>
            <button type="button" onclick="removeRow('row_INDEX')" class="btn btn-outline btn-xs text-red-600 border-red-200 hover:bg-red-50">Remove</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-2">
                <label class="form-label">Select Medicine from Stock <span class="req">*</span></label>
                <select name="medicines[INDEX][medicine_id]" class="form-control med-select" required onchange="onMedSelect(this, INDEX)">
                    <option value="">&mdash; Choose from Available Stock &mdash;</option>
                    @foreach($medicines as $med)
                        <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-instructions="{{ $med->instructions_default }}" data-stock="{{ $med->stock_quantity }}">
                            {{ $med->name }} ({{ $med->strength }}) &mdash; Stock: {{ $med->stock_quantity }} {{ $med->unit }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="medicines[INDEX][medicine_name]" id="med_name_INDEX">
            </div>
            <div>
                <label class="form-label">Total Qty <span class="req">*</span></label>
                <input type="number" name="medicines[INDEX][quantity]" class="form-control" min="1" value="10" required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="form-label">Dosage (Pattern) <span class="req">*</span></label>
                <input type="text" name="medicines[INDEX][dosage]" id="dosage_INDEX" class="form-control text-xs" placeholder="e.g. 1+0+1" value="1+0+1" required>
                <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(INDEX, '1+0+1')">1+0+1</span>
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(INDEX, '1+1+1')">1+1+1</span>
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(INDEX, '1+0+0')">1+0+0</span>
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDosage(INDEX, '0+0+1')">0+0+1</span>
                </div>
            </div>
            <div>
                <label class="form-label">Duration <span class="req">*</span></label>
                <input type="text" name="medicines[INDEX][duration]" id="dur_INDEX" class="form-control text-xs" placeholder="e.g. 5 days" value="5 days" required>
                <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDuration(INDEX, '3 days')">3d</span>
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDuration(INDEX, '5 days')">5d</span>
                    <span class="py-0.5 px-1.5 rounded bg-white border border-gray-300 text-[10px] font-bold text-[#134d2a] cursor-pointer hover:bg-emerald-50" onclick="setDuration(INDEX, '7 days')">7d</span>
                </div>
            </div>
            <div>
                <label class="form-label">Instructions / Advice</label>
                <input type="text" name="medicines[INDEX][instructions]" id="inst_INDEX" class="form-control text-xs" placeholder="e.g. After meal" value="After meal">
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    let rowIndex = 1;

    function onMedSelect(selectEl, idx) {
        const selected = selectEl.options[selectEl.selectedIndex];
        const medName = selected.getAttribute('data-name');
        const defaultInst = selected.getAttribute('data-instructions');

        const nameInput = document.getElementById('med_name_' + idx);
        if (nameInput) nameInput.value = medName || '';

        const instInput = document.getElementById('inst_' + idx);
        if (instInput && defaultInst) instInput.value = defaultInst;
    }

    function setDosage(idx, val) {
        const el = document.getElementById('dosage_' + idx);
        if (el) el.value = val;
    }

    function setDuration(idx, val) {
        const el = document.getElementById('dur_' + idx);
        if (el) el.value = val;
    }

    function addMedicineRow() {
        const container = document.getElementById('medicinesContainer');
        const template = document.getElementById('medicineRowTemplate').innerHTML;
        const newHtml = template
            .replace(/INDEX_PLUS/g, rowIndex + 1)
            .replace(/INDEX/g, rowIndex);

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newHtml;
        container.appendChild(tempDiv.firstElementChild);
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
        const sel = document.querySelector('.med-select');
        if (sel && sel.selectedIndex > 0) {
            onMedSelect(sel, 0);
        }
    });
</script>
@endpush
