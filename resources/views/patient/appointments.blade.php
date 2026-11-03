@extends('layouts.app')
@section('title', 'Appointments')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Appointment Booking &amp; Schedule</h1>
    <p class="page-subtitle">Schedule advance consultations with university medical officers and specialists. Appointments booked for today automatically generate a queue token.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    {{-- Booking Form Card (5 cols) --}}
    <div class="lg:col-span-5 bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Book New Appointment</span>
            <span class="badge badge-gold">Patient Portal</span>
        </div>
        <div class="p-5 sm:p-6">
            <form action="{{ route('patient.appointments.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="form-label">Clinic / Department <span class="req">*</span></label>
                    <select name="department" class="form-control" required>
                        <option value="General Medicine">General Medicine</option>
                        <option value="Dental">Dental Clinic</option>
                        <option value="Counselling">Counselling &amp; Mental Health</option>
                        <option value="Gynaecology">Gynaecology</option>
                        <option value="Diagnostics">Laboratory &amp; Diagnostics</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Preferred Doctor (Optional)</label>
                    <select name="doctor_id" class="form-control">
                        <option value="">&mdash; Any Available Medical Officer &mdash;</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->department }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Appointment Date <span class="req">*</span></label>
                    <input type="date" name="appointment_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="form-label mb-0">Preferred Time Slot <span class="req">*</span></label>
                        <span class="text-[11px] text-gray-500">Selected: <strong id="slotDisplay" class="text-emerald-700 font-bold">09:00</strong></span>
                    </div>
                    <input type="hidden" name="time_slot" id="timeSlotInput" value="09:00" required>

                    @php
                        $regularSlots = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
                        $emergencySlots = ['20:00','21:00','22:00','23:00','00:00','02:00','04:00','06:00'];
                    @endphp

                    {{-- Standard OPD Shifts (Available) --}}
                    <div class="text-[11px] font-bold text-gray-700 mb-1 flex items-center justify-between">
                        <span>Standard OPD Shifts (08:00 &ndash; 20:00)</span>
                        <span class="text-emerald-700 font-semibold text-[10px]">Available</span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5 pt-0.5 mb-3">
                        @foreach($regularSlots as $slot)
                            <button type="button"
                                class="slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center {{ $slot === '09:00' ? 'bg-[#1a6b3a] text-white border-[#1a6b3a] shadow-xs' : 'bg-white text-slate-700 border-gray-300 hover:border-emerald-600 hover:text-emerald-700 cursor-pointer' }}"
                                onclick="selectSlot(this, '{{ $slot }}')">
                                {{ $slot }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Emergency Night Shifts (Unavailable for regular booking) --}}
                    <div class="p-2.5 rounded-lg bg-red-50/60 border border-red-200/50">
                        <div class="text-[11px] font-bold text-red-900 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full bg-red-400"></span>
                                Emergency Shifts (20:00 &ndash; 08:00)
                            </span>
                            <span class="badge badge-red text-[10px]">Unavailable (Emergency Only)</span>
                        </div>
                        <div class="grid grid-cols-4 gap-1.5 opacity-60">
                            @foreach($emergencySlots as $slot)
                                <button type="button"
                                    disabled
                                    title="Emergency shift slot: only selectable via Emergency Booking"
                                    class="py-1.5 px-2 rounded-md text-xs font-medium border text-center bg-red-100/70 text-red-400 border-red-200 line-through cursor-not-allowed select-none">
                                    {{ $slot }}
                                </button>
                            @endforeach
                        </div>
                        <div class="mt-2 text-[10px] text-red-800 leading-normal flex items-start gap-1">
                            <svg class="size-3 text-red-600 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span>Emergency shift timings are restricted. Only <a href="{{ route('appointments') }}" class="font-bold underline text-red-700">Emergency Bookings</a> get to select these time slots.</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="form-label">Reason for Consultation</label>
                    <textarea name="reason" class="form-control" rows="2" placeholder="Briefly describe your symptoms or reason for visit..."></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-green w-full py-2.5">Confirm &amp; Book Appointment &rarr;</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Appointment History Table (7 cols) --}}
    <div class="lg:col-span-7 bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">My Appointment History</span>
            <span class="badge badge-gold">{{ $appointments->count() }} Booked</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Department</th>
                        <th>Doctor</th>
                        <th>Date &amp; Time</th>
                        <th>Reason</th>
                        <th class="text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $apt)
                        <tr>
                            <td><strong class="font-mono text-xs text-slate-900">{{ $apt->appointment_number }}</strong></td>
                            <td class="text-xs font-medium text-slate-800">{{ $apt->department }}</td>
                            <td class="text-xs text-gray-600">{{ $apt->doctor?->name ?? 'First Available' }}</td>
                            <td>
                                <div class="text-xs text-slate-800">{{ $apt->appointment_date->format('d M Y') }}</div>
                                <div class="text-[11px] font-bold text-emerald-700">{{ $apt->time_slot }}</div>
                            </td>
                            <td class="text-xs text-gray-600 truncate max-w-[180px]">{{ Str::limit($apt->reason ?: 'General review', 45) }}</td>
                            <td class="text-right">
                                <span class="badge {{ $apt->status === 'completed' ? 'badge-blue' : ($apt->status === 'cancelled' ? 'badge-red' : 'badge-green') }}">
                                    {{ ucfirst($apt->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400 text-xs">No appointments booked yet.</td>
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
    function selectSlot(el, slot) {
        document.querySelectorAll('.slot-btn').forEach(b => {
            b.className = 'slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center bg-white text-slate-700 border-gray-300 hover:border-emerald-600 hover:text-emerald-700 cursor-pointer';
        });
        el.className = 'slot-btn py-1.5 px-2 rounded-md text-xs font-semibold border transition-all text-center bg-[#1a6b3a] text-white border-[#1a6b3a] shadow-xs';
        document.getElementById('timeSlotInput').value = slot;
        var disp = document.getElementById('slotDisplay');
        if (disp) disp.textContent = slot;
    }
</script>
@endpush
