@extends('layouts.app')
@section('title', 'Appointments')

@section('content')
{{-- Patient Appointments Header --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-2xl p-6 mb-6 shadow-sm border-b-4 border-[#0d9488] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-2xl bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0">
            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-gold text-[11px]">Advance Booking</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-semibold border border-emerald-400/30">
                    <span class="badge-dot bg-emerald-400"></span>
                    <span>OPD Consultation Schedule</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-white">Consultation Booking &amp; Schedule</h1>
            <p class="text-xs text-teal-100/80">Schedule advance consultations with university medical officers. Same-day bookings automatically create a consultation queue token.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('patient.queue') }}" class="btn btn-outline-white btn-sm flex items-center gap-1.5">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <span>Live Queue &rarr;</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    {{-- Booking Form Card (5 cols) --}}
    <div class="lg:col-span-5 bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
            <div class="flex items-center gap-2.5">
                <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                    <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider block">Book New Appointment</span>
                    <span class="text-[11px] text-teal-200/80">Scheduled Consultation</span>
                </div>
            </div>
            <span class="badge badge-gold text-[10px]">Patient Portal</span>
        </div>
        <div class="p-5 sm:p-6">
            <form action="{{ route('patient.appointments.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="form-label font-semibold text-slate-700">Clinic / Department <span class="req">*</span></label>
                    <select name="department" id="patientDeptSelect" class="form-control" required onchange="filterPatientDoctorsByDept()">
                        <option value="General Medicine">General Medicine &amp; Primary Care</option>
                        <option value="Dental">Dental Clinic</option>
                        <option value="Counselling">Counselling &amp; Mental Health</option>
                        <option value="Gynaecology">Gynaecology</option>
                        <option value="Diagnostics">Laboratory &amp; Diagnostics</option>
                    </select>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="form-label mb-0 font-semibold text-slate-700">Preferred Doctor (Optional)</label>
                        <span id="patientDoctorCountBadge" class="text-[11px] text-[#0d9488] font-bold"></span>
                    </div>
                    <select name="doctor_id" id="patientDoctorSelect" class="form-control">
                        <option value="">&mdash; Any Available Medical Officer &mdash;</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" data-department="{{ $doc->department }}">{{ $doc->name }} ({{ $doc->department }})</option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Filtered by selected department. Leave blank for first available duty officer.</p>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Appointment Date <span class="req">*</span></label>
                    <input type="date" name="appointment_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                </div>

                <div>
                    @php
                        $regularSlots = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
                        $emergencySlots = ['20:00','21:00','22:00','23:00','00:00','02:00','04:00','06:00'];
                        $currentPatientSlot = old('time_slot', '');
                    @endphp

                    <div class="flex items-center justify-between mb-1.5">
                        <label class="form-label mb-0 font-semibold text-slate-700">Preferred Time Slot <span class="req">*</span></label>
                        <span class="text-[11px] text-slate-500">Selected: <strong id="slotDisplay" class="{{ $currentPatientSlot ? 'text-[#0d9488] font-mono font-bold' : 'text-slate-400 font-mono font-normal' }}">{{ $currentPatientSlot ?: 'None' }}</strong></span>
                    </div>
                    <input type="hidden" name="time_slot" id="timeSlotInput" value="{{ $currentPatientSlot }}" required>

                    {{-- Standard OPD Shifts (Available) --}}
                    <div class="text-[11px] font-bold text-slate-700 mb-1 flex items-center justify-between">
                        <span>Standard OPD Shifts (08:00 &ndash; 20:00)</span>
                        <span class="text-[#0d9488] font-bold text-[10px]">Open for Booking</span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5 pt-0.5 mb-3">
                        @foreach($regularSlots as $slot)
                            @php
                                $isSlotSelected = ($currentPatientSlot !== '' && $currentPatientSlot === $slot);
                            @endphp
                            <button type="button"
                                class="slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center {{ $isSlotSelected ? 'bg-[#0d9488] text-white border-[#0d9488] shadow-xs' : 'bg-white text-slate-700 border-slate-300 hover:border-teal-600 hover:text-teal-700 cursor-pointer' }}"
                                onclick="selectSlot(this, '{{ $slot }}')">
                                {{ $slot }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Emergency Night Shifts (Unavailable for regular booking) --}}
                    <div class="p-3 rounded-xl bg-red-50/70 border border-red-200">
                        <div class="text-[11px] font-bold text-red-900 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full bg-red-500 animate-pulse"></span>
                                Emergency Shifts (20:00 &ndash; 08:00)
                            </span>
                            <span class="badge badge-red text-[10px]">Emergency Only</span>
                        </div>
                        <div class="grid grid-cols-4 gap-1.5 opacity-60">
                            @foreach($emergencySlots as $slot)
                                <button type="button"
                                    disabled
                                    title="Emergency shift slot: only selectable via Emergency Appointment"
                                    class="py-1.5 px-2 rounded-lg text-xs font-medium border text-center bg-red-100/70 text-red-400 border-red-200 line-through cursor-not-allowed select-none">
                                    {{ $slot }}
                                </button>
                            @endforeach
                        </div>
                        <div class="mt-2 text-[10px] text-red-800 leading-normal flex items-start gap-1">
                            <svg class="size-3 text-red-600 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span>Emergency shift slots are restricted. Use <a href="{{ route('appointments') }}" class="font-bold underline text-red-700">EMERGENCY APPOINTMENT</a> for priority night hours.</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Reason for Consultation</label>
                    <textarea name="reason" class="form-control" rows="2" placeholder="Briefly describe your symptoms or reason for visit..."></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-green w-full py-2.5 flex items-center justify-center gap-2 font-bold shadow-sm">
                        <span>Confirm &amp; Book Appointment</span>
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Appointment History Table (7 cols) --}}
    <div class="lg:col-span-7 bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
            <div class="flex items-center gap-2.5">
                <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                    <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider block">My Appointment History</span>
                    <span class="text-[11px] text-teal-200/80">{{ $appointments->count() }} Bookings on Record</span>
                </div>
            </div>
            <span class="badge badge-gold text-[10px]">{{ $appointments->count() }} Booked</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="w-24">Reference</th>
                        <th>Department</th>
                        <th>Physician</th>
                        <th>Date &amp; Time</th>
                        <th>Reason</th>
                        <th class="text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $apt)
                        <tr>
                            <td>
                                <span class="font-mono text-xs font-bold text-[#091e3a] bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                    {{ $apt->appointment_number }}
                                </span>
                            </td>
                            <td class="text-xs font-semibold text-slate-800">{{ $apt->department }}</td>
                            <td class="text-xs text-slate-600">
                                {{ $apt->doctor?->name ? 'Dr. ' . $apt->doctor->name : 'First Available' }}
                            </td>
                            <td>
                                <div class="text-xs text-slate-800 font-medium">{{ $apt->appointment_date->format('d M Y') }}</div>
                                <div class="text-[11px] font-mono font-bold text-[#0d9488]">{{ $apt->time_slot }}</div>
                            </td>
                            <td class="text-xs text-slate-600 truncate max-w-[180px]">{{ Str::limit($apt->reason ?: 'General clinical review', 45) }}</td>
                            <td class="text-right">
                                <span class="badge {{ $apt->status === 'completed' ? 'badge-blue' : ($apt->status === 'cancelled' ? 'badge-red' : 'badge-green') }}">
                                    {{ ucfirst($apt->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 bg-slate-50/40">
                                <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-2.5">
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                </div>
                                <div class="text-xs font-bold text-slate-800">No appointments scheduled</div>
                                <p class="text-[11px] text-slate-500 max-w-xs mx-auto mt-0.5">Book your consultation using the appointment form on the left.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterPatientDoctorsByDept() {
        const deptSelect = document.getElementById('patientDeptSelect');
        const doctorSelect = document.getElementById('patientDoctorSelect');
        const badge = document.getElementById('patientDoctorCountBadge');
        if (!deptSelect || !doctorSelect) return;

        const selectedDept = deptSelect.value.trim().toLowerCase();
        let matchedCount = 0;
        let selectedStillVisible = false;

        Array.from(doctorSelect.options).forEach((opt, idx) => {
            if (idx === 0) {
                opt.hidden = false;
                opt.disabled = false;
                return;
            }

            const docDept = (opt.dataset.department || '').trim().toLowerCase();
            const matches = !selectedDept ||
                docDept.includes(selectedDept) ||
                selectedDept.includes(docDept) ||
                (selectedDept.includes('medicine') && docDept.includes('medicine')) ||
                (selectedDept.includes('dental') && docDept.includes('dental')) ||
                (selectedDept.includes('gynae') && docDept.includes('gynae')) ||
                (selectedDept.includes('counsel') && docDept.includes('counsel')) ||
                (selectedDept.includes('diagnostics') && docDept.includes('lab')) ||
                (selectedDept.includes('lab') && docDept.includes('lab'));

            if (matches) {
                opt.hidden = false;
                opt.disabled = false;
                opt.style.display = '';
                matchedCount++;
                if (opt.selected) {
                    selectedStillVisible = true;
                }
            } else {
                opt.hidden = true;
                opt.disabled = true;
                opt.style.display = 'none';
                if (opt.selected) {
                    opt.selected = false;
                }
            }
        });

        if (!selectedStillVisible && doctorSelect.selectedIndex > 0) {
            doctorSelect.value = '';
        }

        if (badge) {
            badge.textContent = matchedCount > 0 ? `${matchedCount} doctor${matchedCount > 1 ? 's' : ''} available` : 'Duty officer will be assigned';
        }
    }

    function selectSlot(el, slot) {
        document.querySelectorAll('.slot-btn').forEach(b => {
            b.className = 'slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center bg-white text-slate-700 border-slate-300 hover:border-teal-600 hover:text-teal-700 cursor-pointer';
        });
        el.className = 'slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center bg-[#0d9488] text-white border-[#0d9488] shadow-xs';
        document.getElementById('timeSlotInput').value = slot;
        var disp = document.getElementById('slotDisplay');
        if (disp) {
            disp.textContent = slot;
            disp.className = 'text-[#0d9488] font-mono font-bold';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterPatientDoctorsByDept();
    });
</script>
@endpush
