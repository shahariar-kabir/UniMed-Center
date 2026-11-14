@extends('layouts.app')
@section('title', 'Emergency Appointment')

@section('content')

{{-- Emergency Appointment Header Ribbon --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-lg p-6 mb-6 shadow-sm border-b-4 border-red-500 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded bg-red-500/20 text-red-300 border border-red-400/30 flex items-center justify-center font-black text-xl shrink-0 font-mono">
            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-red text-[11px]">Priority Medical Care</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-500/20 text-red-200 text-[11px] font-semibold border border-red-400/30">
                    <span class="badge-dot bg-red-400 animate-pulse"></span>
                    <span>Emergency Shifts &amp; Daytime OPD</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-white uppercase tracking-wide font-heading">EMERGENCY APPOINTMENT</h1>
            <p class="text-xs text-teal-100/80">Schedule an urgent or scheduled clinical consultation with a university medical officer. Bring your University ID card.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <div class="px-3.5 py-2 rounded bg-white/10 border border-white/15 text-xs text-slate-200 flex items-center gap-2">
            <svg class="size-4 text-red-400 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <div>
                <span class="block text-[10px] text-teal-200/80 uppercase tracking-wider font-semibold">Emergency Ambulance:</span>
                <span class="font-bold text-white font-mono">01888-888888</span>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-teal-50 border-t-2 border-teal-500 rounded-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-teal-900" role="alert">
        <svg class="shrink-0 size-5 text-[#0d9488]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-5 rounded-xl text-xs text-red-800 shadow-xs" role="alert">
        <div class="font-bold mb-1 flex items-center gap-x-2">
            <svg class="shrink-0 size-4 text-red-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            <span>Unable to complete booking. Please correct the following:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 ml-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    {{-- Booking Form Card (5 cols) --}}
    <div class="lg:col-span-5 bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-red-500">
            <div class="flex items-center gap-2.5">
                <div class="size-8 rounded-lg bg-red-500/20 text-red-300 flex items-center justify-center border border-red-400/30">
                    <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider block">Appointment Request</span>
                    <span class="text-[11px] text-teal-200/80">OPD &amp; Emergency Shift Booking</span>
                </div>
            </div>
            <span class="badge badge-red text-[10px]">Urgent Desk</span>
        </div>

        <form method="POST" action="{{ url('/appointments') }}">
            @csrf

            <div class="p-5 sm:p-6 space-y-4">
                <div>
                    <label class="form-label font-semibold text-slate-700">University / Patient ID <span class="req">*</span></label>
                    <input type="text" name="university_id" class="form-control" placeholder="e.g. 0802000000000000" value="{{ old('university_id', Auth::check() ? Auth::user()->university_id : '') }}" required>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Full Name <span class="req">*</span></label>
                    <input type="text" name="patient_name" class="form-control" value="{{ old('patient_name', Auth::check() ? Auth::user()->name : '') }}" required>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Consultation Type <span class="req">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <label id="cardConsultScheduled" class="relative border-2 border-[#0f766e] bg-[#f0fdfa] rounded-md p-3 flex items-start gap-2.5 cursor-pointer transition-all shadow-xs">
                            <input type="radio" name="consultation_type" id="typeScheduled" value="appointment" class="mt-0.5 text-[#0f766e] focus:ring-[#0f766e]" {{ old('consultation_type', 'appointment') === 'appointment' ? 'checked' : '' }} onchange="handleConsultationTypeChange('appointment')">
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-1.5">
                                    <svg class="size-3.5 text-[#0f766e]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                    <span class="text-xs font-bold text-[#0b1c30]">Scheduled Appointment</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-normal">Advance booking with reserved date &amp; doctor time slot.</p>
                            </div>
                        </label>

                        <label id="cardConsultWalkin" class="relative border border-slate-200 bg-white rounded-md p-3 flex items-start gap-2.5 cursor-pointer transition-all hover:border-slate-300">
                            <input type="radio" name="consultation_type" id="typeWalkin" value="walkin" class="mt-0.5 text-[#0f766e] focus:ring-[#0f766e]" {{ old('consultation_type') === 'walkin' ? 'checked' : '' }} onchange="handleConsultationTypeChange('walkin')">
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-1.5">
                                    <svg class="size-3.5 text-slate-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                                    <span class="text-xs font-bold text-[#0b1c30]">Walk-in OPD Consultation</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-normal">Same-day arrival with live electronic queue token.</p>
                            </div>
                        </label>
                    </div>
                    <div id="walkinBadgeNotice" class="hidden mt-2 p-2 rounded bg-amber-50 border border-amber-200 text-[11px] text-amber-800 flex items-center gap-1.5">
                        <svg class="size-3.5 text-amber-600 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>Walk-in selected: Date is set to today. A live OPD queue token will be generated upon submission.</span>
                    </div>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Department / Specialized Clinic <span class="req">*</span></label>
                    <select name="department" id="departmentSelect" class="form-control" required onchange="filterDoctorsByDept()">
                        <optgroup label="General Department &amp; Primary Care">
                            <option value="General Medicine" {{ old('department', 'General Medicine') === 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                        </optgroup>
                        <optgroup label="Specialized Clinics">
                            <option value="Dental" {{ old('department') === 'Dental' ? 'selected' : '' }}>Dental Clinic</option>
                            <option value="Counselling" {{ old('department') === 'Counselling' ? 'selected' : '' }}>Counselling &amp; Mental Health</option>
                            <option value="Gynaecology" {{ old('department') === 'Gynaecology' ? 'selected' : '' }}>Gynaecology</option>
                            <option value="Laboratory" {{ old('department') === 'Laboratory' ? 'selected' : '' }}>Laboratory &amp; Diagnostics</option>
                        </optgroup>
                    </select>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="form-label mb-0 font-semibold text-slate-700">Preferred Medical Officer</label>
                        <span id="doctorCountBadge" class="text-[11px] text-[#0d9488] font-bold"></span>
                    </div>
                    <select name="doctor" id="doctorSelect" class="form-control">
                        <option value="">&mdash; Any available Medical Officer &mdash;</option>
                        @if(isset($doctors) && count($doctors) > 0)
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" data-department="{{ $d->department }}" {{ old('doctor') == $d->id ? 'selected' : '' }}>{{ $d->name }} ({{ $d->department }})</option>
                            @endforeach
                        @endif
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Filtered by selected department. Leave as default to assign first available duty officer.</p>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Appointment Date <span class="req">*</span></label>
                    <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>

                <div>
                    @php
                        $regularSlots = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
                        $emergencySlots = ['20:00','21:00','22:00','23:00','00:00','02:00','04:00','06:00'];
                        $taken = $takenSlots ?? [];
                        $currentSlot = old('time', '');
                    @endphp

                    <div class="flex items-center justify-between mb-1.5">
                        <label class="form-label mb-0 font-semibold text-slate-700">Select Time Slot <span class="req">*</span></label>
                        <span class="text-[11px] text-slate-500">Selected: <strong id="selectedSlotText" class="{{ $currentSlot ? 'text-[#0d9488] font-mono font-bold' : 'text-slate-400 font-mono font-normal' }}">{{ $currentSlot ?: 'None' }}</strong></span>
                    </div>

                    {{-- Standard OPD Hours (08:00 - 20:00) --}}
                    <div class="text-[11px] font-bold text-slate-700 mb-1 flex items-center justify-between">
                        <span>Standard OPD Shifts (08:00 &ndash; 20:00)</span>
                        <span class="text-slate-400 font-normal">Daytime Consultations</span>
                    </div>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-1.5 pt-0.5 mb-3">
                        @foreach($regularSlots as $slot)
                            @php
                                $isTaken = in_array($slot, $taken);
                                $isSelected = ($currentSlot !== '' && $currentSlot === $slot);
                            @endphp
                            <button type="button"
                                class="time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center
                                {{ $isTaken ? 'bg-slate-100 text-slate-400 border-slate-200 line-through cursor-not-allowed' : ($isSelected ? 'bg-[#0d9488] text-white border-[#0d9488] shadow-xs' : 'bg-white text-slate-700 border-slate-300 hover:border-teal-600 hover:text-teal-700 cursor-pointer') }}"
                                data-slot="{{ $slot }}"
                                data-is-emergency="false"
                                onclick="{{ $isTaken ? 'void(0)' : "pickSlot(this,'{$slot}')" }}">
                                {{ $slot }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Emergency Night Shifts (20:00 - 08:00) --}}
                    <div class="p-3 rounded-xl bg-red-50/70 border border-red-200 mb-2">
                        <div class="text-[11px] font-bold text-red-800 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full bg-red-600 animate-pulse"></span>
                                Emergency Shift Slots (20:00 &ndash; 08:00)
                            </span>
                            <span class="badge badge-red text-[10px]">Emergency Access</span>
                        </div>
                        <div class="grid grid-cols-4 gap-1.5">
                            @foreach($emergencySlots as $slot)
                                @php
                                    $isSelected = ($currentSlot !== '' && $currentSlot === $slot);
                                @endphp
                                <button type="button"
                                    class="time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center cursor-pointer
                                    {{ $isSelected ? 'bg-red-700 text-white border-red-700 shadow-xs font-bold' : 'bg-white text-red-700 border-red-300 hover:bg-red-700 hover:text-white' }}"
                                    data-slot="{{ $slot }}"
                                    data-is-emergency="true"
                                    onclick="pickSlot(this,'{{ $slot }}')">
                                    {{ $slot }}
                                </button>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-red-700/80 mt-1.5">
                            * Emergency slots route directly to the active On-Call Medical Officer and prioritize queue triage.
                        </p>
                    </div>

                    {{-- Visual Slot Legend --}}
                    <div class="flex items-center flex-wrap gap-x-4 gap-y-1.5 text-[10px] text-slate-500 pt-1 pb-0.5">
                        <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-xs border border-slate-300 bg-white"></span> Available</span>
                        <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-xs bg-[#0d9488]"></span> Selected</span>
                        <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-xs bg-red-700"></span> Emergency</span>
                        <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-xs bg-slate-200 border border-slate-300"></span> Booked</span>
                    </div>

                    <input type="hidden" name="time" id="timeInput" value="{{ $currentSlot }}" required>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Reason for Visit</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="Brief description of symptoms, discomfort, or reason for emergency consultation...">{{ old('reason') }}</textarea>
                </div>
            </div>

            <div class="bg-slate-50 border-t border-slate-200 px-5 py-4 flex items-center justify-end gap-2.5">
                <button type="reset" class="btn btn-outline btn-sm">Clear Form</button>
                <button type="submit" class="btn btn-teal btn-sm flex items-center gap-1.5 font-bold shadow-sm">
                    <span>Confirm Booking</span>
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Appointment List Table Card (7 cols) --}}
    <div class="lg:col-span-7 space-y-4">
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
                <div class="flex items-center gap-2.5">
                    <div class="size-8 rounded bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                        <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider block font-heading">Campus Consultation Schedule</span>
                        <span class="text-[11px] text-teal-200/80">{{ isset($recentAppointments) ? $recentAppointments->count() : 0 }} Recent Bookings</span>
                    </div>
                </div>
                <span class="badge badge-cyan text-[11px]">Appointment Records</span>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-24">#</th>
                            <th>Patient Identity</th>
                            <th>Clinic &amp; Doctor</th>
                            <th>Date &amp; Time</th>
                            <th class="text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $badge = [
                                'Confirmed' => 'badge-green',
                                'Pending' => 'badge-yellow',
                                'Cancelled' => 'badge-red',
                                'confirmed' => 'badge-green',
                                'pending' => 'badge-yellow',
                                'cancelled' => 'badge-red',
                                'completed' => 'badge-blue',
                            ];
                        @endphp
                        @forelse($recentAppointments ?? [] as $a)
                            <tr>
                                <td>
                                    <span class="font-mono text-xs font-bold text-[#091e3a] bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                        {{ $a->appointment_number }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="size-7 rounded-lg bg-slate-100 border border-slate-200 text-[#091e3a] flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($a->patient ? $a->patient->first_name ?? $a->patient->full_name : 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="text-slate-900 block text-xs">{{ $a->patient ? $a->patient->full_name : 'Patient' }}</strong>
                                            <span class="text-[11px] text-slate-500 font-mono">{{ $a->patient ? $a->patient->university_id : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-semibold text-slate-800 text-xs">{{ $a->department }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $a->doctor ? 'Dr. ' . $a->doctor->name : 'Attending Officer' }}</div>
                                </td>
                                <td>
                                    <div class="text-xs text-slate-800 font-medium">{{ $a->appointment_date->format('d M Y') }}</div>
                                    <div class="text-[11px] font-mono font-bold text-[#0d9488]">{{ $a->time_slot }}</div>
                                </td>
                                <td class="text-right">
                                    <span class="badge {{ $badge[$a->status] ?? 'badge-green' }}">{{ ucfirst($a->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 bg-slate-50/40">
                                    <div class="inline-flex size-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#0d9488] items-center justify-center mb-2.5">
                                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                    </div>
                                    <div class="text-xs font-bold text-slate-800">No scheduled appointments found</div>
                                    <p class="text-[11px] text-slate-500 max-w-xs mx-auto mt-0.5">Use the booking request form on the left to schedule an emergency or OPD consultation.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs text-slate-600 flex items-center justify-between shadow-xs">
            <span>To cancel or reschedule an emergency consultation, contact the Medical Centre desk.</span>
            <span class="font-bold text-red-700">Hotline: 01888-888888</span>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function filterDoctorsByDept() {
        const deptSelect = document.getElementById('departmentSelect');
        const doctorSelect = document.getElementById('doctorSelect');
        const badge = document.getElementById('doctorCountBadge');
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

    function pickSlot(el, val) {
        document.querySelectorAll('.time-slot-btn:not(.line-through)').forEach(s => {
            if (s.dataset.isEmergency === 'true') {
                s.className = 'time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center cursor-pointer bg-white text-red-700 border-red-300 hover:bg-red-700 hover:text-white';
            } else {
                s.className = 'time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center bg-white text-slate-700 border-slate-300 hover:border-teal-600 hover:text-teal-700 cursor-pointer';
            }
        });

        if (el.dataset.isEmergency === 'true') {
            el.className = 'time-slot-btn py-1.5 px-2 rounded-lg text-xs font-bold border transition-all text-center bg-red-700 text-white border-red-700 shadow-xs cursor-pointer';
        } else {
            el.className = 'time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center bg-[#0d9488] text-white border-[#0d9488] shadow-xs cursor-pointer';
        }

        document.getElementById('timeInput').value = val;
        var txt = document.getElementById('selectedSlotText');
        if (txt) {
            txt.textContent = val + (el.dataset.isEmergency === 'true' ? ' (Emergency Shift)' : '');
            txt.className = (el.dataset.isEmergency === 'true') ? 'text-red-700 font-mono font-bold' : 'text-[#0d9488] font-mono font-bold';
        }
    }

    function handleConsultationTypeChange(type) {
        const scheduledCard = document.getElementById('cardConsultScheduled');
        const walkinCard = document.getElementById('cardConsultWalkin');
        const dateInput = document.querySelector('input[name="date"]');
        const walkinNotice = document.getElementById('walkinBadgeNotice');

        if (type === 'walkin') {
            if (scheduledCard) scheduledCard.className = 'relative border border-slate-200 bg-white rounded-md p-3 flex items-start gap-2.5 cursor-pointer transition-all hover:border-slate-300';
            if (walkinCard) walkinCard.className = 'relative border-2 border-[#0f766e] bg-[#f0fdfa] rounded-md p-3 flex items-start gap-2.5 cursor-pointer transition-all shadow-xs';
            if (dateInput) {
                const today = new Date().toISOString().split('T')[0];
                dateInput.value = today;
            }
            if (walkinNotice) walkinNotice.classList.remove('hidden');
        } else {
            if (scheduledCard) scheduledCard.className = 'relative border-2 border-[#0f766e] bg-[#f0fdfa] rounded-md p-3 flex items-start gap-2.5 cursor-pointer transition-all shadow-xs';
            if (walkinCard) walkinCard.className = 'relative border border-slate-200 bg-white rounded-md p-3 flex items-start gap-2.5 cursor-pointer transition-all hover:border-slate-300';
            if (walkinNotice) walkinNotice.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterDoctorsByDept();
        const walkinRadio = document.getElementById('typeWalkin');
        if (walkinRadio && walkinRadio.checked) {
            handleConsultationTypeChange('walkin');
        }

        const bookingForm = document.querySelector('form[action="{{ url('/appointments') }}"]');
        if (bookingForm) {
            bookingForm.addEventListener('reset', function() {
                setTimeout(function() {
                    document.querySelectorAll('.time-slot-btn:not(.line-through)').forEach(s => {
                        if (s.dataset.isEmergency === 'true') {
                            s.className = 'time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center cursor-pointer bg-white text-red-700 border-red-300 hover:bg-red-700 hover:text-white';
                        } else {
                            s.className = 'time-slot-btn py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all text-center bg-white text-slate-700 border-slate-300 hover:border-teal-600 hover:text-teal-700 cursor-pointer';
                        }
                    });
                    const timeInput = document.getElementById('timeInput');
                    if (timeInput) timeInput.value = '';
                    const txt = document.getElementById('selectedSlotText');
                    if (txt) {
                        txt.textContent = 'None';
                        txt.className = 'text-slate-400 font-mono font-normal';
                    }
                    handleConsultationTypeChange('appointment');
                }, 10);
            });
        }
    });
</script>
@endpush
