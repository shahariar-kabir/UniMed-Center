@extends('layouts.app')
@section('title', 'Emergency Booking')

@section('content')

<div class="mb-6">
    <h1 class="page-title">Emergency Booking</h1>
    <p class="page-subtitle">Schedule an urgent or advance consultation with a university medical officer. Bring your University ID card on the day of your appointment.</p>
</div>

@if(session('success'))
    <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-teal-800" role="alert">
        <svg class="shrink-0 size-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-5 rounded-md text-xs text-red-800 shadow-xs" role="alert">
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
    <div class="lg:col-span-5 bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Emergency Booking Request</span>
            <span class="badge badge-gold">Emergency Desk</span>
        </div>

        <form method="POST" action="{{ url('/appointments') }}">
            @csrf

            <div class="p-5 space-y-4">
                <div>
                    <label class="form-label">University / Patient ID <span class="req">*</span></label>
                    <input type="text" name="university_id" class="form-control" placeholder="e.g. 0802000000000000" value="{{ old('university_id', Auth::check() ? Auth::user()->university_id : '') }}" required>
                </div>

                <div>
                    <label class="form-label">Full Name <span class="req">*</span></label>
                    <input type="text" name="patient_name" class="form-control" value="{{ old('patient_name', Auth::check() ? Auth::user()->name : '') }}" required>
                </div>

                <div>
                    <label class="form-label">Department / Clinic <span class="req">*</span></label>
                    <select name="department" class="form-control" required>
                        <option value="General Medicine" {{ old('department') === 'General Medicine' ? 'selected' : '' }}>General Medicine (Walk-in + Appt)</option>
                        <option value="Dental" {{ old('department') === 'Dental' ? 'selected' : '' }}>Dental Clinic</option>
                        <option value="Counselling" {{ old('department') === 'Counselling' ? 'selected' : '' }}>Counselling &amp; Mental Health</option>
                        <option value="Gynaecology" {{ old('department') === 'Gynaecology' ? 'selected' : '' }}>Gynaecology</option>
                        <option value="Laboratory" {{ old('department') === 'Laboratory' ? 'selected' : '' }}>Laboratory &amp; Diagnostics</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Preferred Doctor</label>
                    <select name="doctor" class="form-control">
                        <option value="">&mdash; Any available Medical Officer &mdash;</option>
                        @if(isset($doctors) && count($doctors) > 0)
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ old('doctor') == $d->id ? 'selected' : '' }}>{{ $d->name }} ({{ $d->department }})</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label class="form-label">Appointment Date <span class="req">*</span></label>
                    <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="form-label mb-0">Select Time Slot <span class="req">*</span></label>
                        <span class="text-[11px] text-gray-500">Selected: <strong id="selectedSlotText" class="text-emerald-700 font-bold">{{ old('time', '09:30') }}</strong></span>
                    </div>

                    @php
                        $regularSlots = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
                        $emergencySlots = ['20:00','21:00','22:00','23:00','00:00','02:00','04:00','06:00'];
                        $taken = $takenSlots ?? [];
                        $currentSlot = old('time', '09:30');
                    @endphp

                    {{-- Standard OPD Hours (08:00 - 20:00) --}}
                    <div class="text-[11px] font-bold text-gray-700 mb-1 flex items-center justify-between">
                        <span>Standard OPD Shifts (08:00 &ndash; 20:00)</span>
                        <span class="text-gray-400 font-normal">Daytime Consultations</span>
                    </div>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-1.5 pt-0.5 mb-3">
                        @foreach($regularSlots as $slot)
                            @php
                                $isTaken = in_array($slot, $taken);
                                $isSelected = ($currentSlot === $slot);
                            @endphp
                            <button type="button"
                                class="time-slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center
                                {{ $isTaken ? 'bg-gray-100 text-gray-400 border-gray-200 line-through cursor-not-allowed' : ($isSelected ? 'bg-[#1a6b3a] text-white border-[#1a6b3a] shadow-xs' : 'bg-white text-slate-700 border-gray-300 hover:border-emerald-600 hover:text-emerald-700 cursor-pointer') }}"
                                data-slot="{{ $slot }}"
                                data-is-emergency="false"
                                onclick="{{ $isTaken ? 'void(0)' : "pickSlot(this,'{$slot}')" }}">
                                {{ $slot }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Emergency Night Shifts (20:00 - 08:00) --}}
                    <div class="p-2.5 rounded-lg bg-red-50/70 border border-red-200/60 mb-2">
                        <div class="text-[11px] font-bold text-red-800 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full bg-red-600 animate-pulse"></span>
                                Emergency Shift Slots (20:00 &ndash; 08:00)
                            </span>
                            <span class="badge badge-red text-[10px]">Emergency Booking Access</span>
                        </div>
                        <div class="grid grid-cols-4 gap-1.5">
                            @foreach($emergencySlots as $slot)
                                @php
                                    $isSelected = ($currentSlot === $slot);
                                @endphp
                                <button type="button"
                                    class="time-slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center cursor-pointer
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

                    <input type="hidden" name="time" id="timeInput" value="{{ $currentSlot }}" required>
                </div>

                <div>
                    <label class="form-label">Reason for Visit</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="Brief description of symptoms or reason for consultation...">{{ old('reason') }}</textarea>
                </div>
            </div>

            <div class="bg-slate-50 border-t border-gray-200 px-5 py-3.5 flex items-center justify-end gap-2.5">
                <button type="reset" class="btn btn-outline btn-sm">Clear Form</button>
                <button type="submit" class="btn btn-green btn-sm">Confirm Booking &rarr;</button>
            </div>
        </form>
    </div>

    {{-- Appointment List Table Card (7 cols) --}}
    <div class="lg:col-span-7 space-y-4">
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider">Appointment Schedule</span>
                <span class="badge badge-gold">{{ isset($recentAppointments) ? $recentAppointments->count() : 0 }} Records</span>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
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
                                <td class="font-mono text-xs text-gray-500 font-semibold">{{ $a->appointment_number }}</td>
                                <td>
                                    <div class="font-bold text-slate-900">{{ $a->patient ? $a->patient->full_name : 'Patient' }}</div>
                                    <div class="text-[11px] text-gray-500">ID: {{ $a->patient ? $a->patient->university_id : 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold text-slate-800">{{ $a->department }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $a->doctor ? $a->doctor->name : 'Attending Officer' }}</div>
                                </td>
                                <td>
                                    <div class="text-xs text-slate-800 font-medium">{{ $a->appointment_date->format('d M Y') }}</div>
                                    <div class="text-[11px] font-bold text-emerald-700">{{ $a->time_slot }}</div>
                                </td>
                                <td class="text-right">
                                    <span class="badge {{ $badge[$a->status] ?? 'badge-green' }}">{{ ucfirst($a->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    <div class="text-xs">No scheduled appointments found.</div>
                                    <div class="text-[11px] text-gray-400 mt-1">Use the booking form on the left to schedule your visit.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-3.5 rounded-lg bg-white border border-gray-200 text-xs text-gray-600 flex items-center justify-between">
            <span>To cancel or reschedule an appointment, contact the Medical Centre counter.</span>
            <span class="font-semibold text-emerald-800">Hotline: 01888-888888</span>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function pickSlot(el, val) {
        document.querySelectorAll('.time-slot-btn:not(.line-through)').forEach(s => {
            if (s.dataset.isEmergency === 'true') {
                s.className = 'time-slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center cursor-pointer bg-white text-red-700 border-red-300 hover:bg-red-700 hover:text-white';
            } else {
                s.className = 'time-slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center bg-white text-slate-700 border-gray-300 hover:border-emerald-600 hover:text-emerald-700 cursor-pointer';
            }
        });

        if (el.dataset.isEmergency === 'true') {
            el.className = 'time-slot-btn py-1.5 px-2 rounded-md text-xs font-bold border transition-all text-center bg-red-700 text-white border-red-700 shadow-xs cursor-pointer';
        } else {
            el.className = 'time-slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center bg-[#1a6b3a] text-white border-[#1a6b3a] shadow-xs cursor-pointer';
        }

        document.getElementById('timeInput').value = val;
        var txt = document.getElementById('selectedSlotText');
        if (txt) {
            txt.textContent = val + (el.dataset.isEmergency === 'true' ? ' (Emergency Shift)' : '');
        }
    }
</script>
@endpush
