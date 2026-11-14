@php
    $user = Auth::user();
    $role = $user?->role ?? 'guest';
@endphp

<div class="space-y-3">
    {{-- Workspace Role Header --}}
    <div class="px-3 pt-1.5 pb-2.5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">Workspace</span>
            <span class="text-xs font-bold text-[#091e3a]">
                @if($role === 'doctor')
                    Doctor Clinical Desk
                @elseif($role === 'pharmacist')
                    Dispensary Console
                @elseif($role === 'admin')
                    System Administration
                @elseif($role === 'patient')
                    Patient Health Pass
                @else
                    Medical Centre Desk
                @endif
            </span>
        </div>
        @if($role === 'doctor')
            <span class="badge badge-teal text-[10px]">Active Shift</span>
        @elseif($role === 'pharmacist')
            <span class="badge badge-cyan text-[10px]">Dispensary</span>
        @elseif($role === 'admin')
            <span class="badge badge-red text-[10px]">Admin Level</span>
        @elseif($role === 'patient')
            <span class="badge badge-blue text-[10px]">Student / Staff</span>
        @else
            <span class="badge badge-gray text-[10px]">Public Desk</span>
        @endif
    </div>

    {{-- Vertical Navigation Links (Clinical Clarity Style per Image) --}}
    <nav class="space-y-1">
        @if($role === 'doctor')
            {{-- 1. Doctor Workspace & Desk --}}
            @php $active = request()->routeIs('doctor.dashboard'); @endphp
            <a href="{{ route('doctor.dashboard') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                <span class="truncate">Doctor Workspace &amp; Rx</span>
            </a>

            {{-- 2. Patient Queue & Records --}}
            @php $active = request()->routeIs('doctor.queue'); @endphp
            <a href="{{ route('doctor.queue') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="truncate">Patient Queue &amp; Records</span>
            </a>

            {{-- 3. Issue Digital Rx --}}
            @php $active = request()->routeIs('doctor.prescriptions.create'); @endphp
            <a href="{{ route('doctor.prescriptions.create') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span class="truncate">Generate Prescription</span>
            </a>

            {{-- 4. Dispensary & Inventory --}}
            @php $active = request()->routeIs('pharmacy.inventory'); @endphp
            <a href="{{ route('pharmacy.inventory') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                <span class="truncate">Dispensary &amp; Inventory</span>
            </a>

            {{-- 5. Emergency Triage Log --}}
            @php $active = request()->routeIs('appointments*'); @endphp
            <a href="{{ route('appointments') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m4.93 4.93 14.14 14.14"/><path d="M2 12h20"/><path d="m19.07 4.93-14.14 14.14"/></svg>
                <span class="truncate">Emergency Triage Log</span>
            </a>

        @elseif($role === 'pharmacist')
            {{-- 1. Dispensary & Inventory --}}
            @php $active = request()->routeIs('pharmacy.dashboard'); @endphp
            <a href="{{ route('pharmacy.dashboard') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                <span class="truncate">Dispensary &amp; Inventory</span>
            </a>

            {{-- 2. Medicine Stock & Batches --}}
            @php $active = request()->routeIs('pharmacy.inventory'); @endphp
            <a href="{{ route('pharmacy.inventory') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                <span class="truncate">Medicine Stock &amp; Batches</span>
            </a>

            {{-- 3. Dispense Prescriptions --}}
            @php $active = request()->routeIs('pharmacy.dispense'); @endphp
            <a href="{{ route('pharmacy.dispense') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span class="truncate">Dispense Prescriptions</span>
            </a>

            {{-- 4. Patient Queue & Records --}}
            @php $active = request()->routeIs('doctor.queue'); @endphp
            <a href="{{ route('doctor.queue') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="truncate">Patient Queue &amp; Records</span>
            </a>

            {{-- 5. Emergency Supply Registry --}}
            @php $active = request()->routeIs('appointments*'); @endphp
            <a href="{{ route('appointments') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m4.93 4.93 14.14 14.14"/><path d="M2 12h20"/><path d="m19.07 4.93-14.14 14.14"/></svg>
                <span class="truncate">Emergency Triage Log</span>
            </a>

        @elseif($role === 'admin')
            {{-- 1. Campus Health Stats --}}
            @php $active = request()->routeIs('admin.dashboard'); @endphp
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                <span class="truncate">Campus Health Stats</span>
            </a>

            {{-- 2. Staff & User Management --}}
            @php $active = request()->routeIs('admin.users*'); @endphp
            <a href="{{ route('admin.users') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                <span class="truncate">User &amp; Staff Directory</span>
            </a>

            {{-- 3. Dispensary & Inventory --}}
            @php $active = request()->routeIs('pharmacy.inventory'); @endphp
            <a href="{{ route('pharmacy.inventory') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                <span class="truncate">Dispensary &amp; Inventory</span>
            </a>

            {{-- 4. Patient Queue & Records --}}
            @php $active = request()->routeIs('doctor.queue'); @endphp
            <a href="{{ route('doctor.queue') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="truncate">Patient Queue &amp; Records</span>
            </a>

            {{-- 5. Emergency Triage Log --}}
            @php $active = request()->routeIs('appointments*'); @endphp
            <a href="{{ route('appointments') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m4.93 4.93 14.14 14.14"/><path d="M2 12h20"/><path d="m19.07 4.93-14.14 14.14"/></svg>
                <span class="truncate">Emergency Triage Log</span>
            </a>

        @elseif($role === 'patient')
            {{-- 1. Patient Health Pass --}}
            @php $active = request()->routeIs('patient.dashboard'); @endphp
            <a href="{{ route('patient.dashboard') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="truncate">My Health Pass</span>
            </a>

            {{-- 2. Live Queue & Token --}}
            @php $active = request()->routeIs('patient.queue'); @endphp
            <a href="{{ route('patient.queue') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                <span class="truncate">Live Queue &amp; Token</span>
            </a>

            {{-- 3. Book Appointment --}}
            @php $active = request()->routeIs('patient.appointments*'); @endphp
            <a href="{{ route('patient.appointments') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <span class="truncate">Book Appointment Slot</span>
            </a>

            {{-- 4. My Prescriptions & Meds --}}
            @php $active = request()->routeIs('patient.prescriptions*'); @endphp
            <a href="{{ route('patient.prescriptions') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                <span class="truncate">Prescriptions &amp; Digital Rx</span>
            </a>

            {{-- 5. Medical Profile --}}
            @php $active = request()->routeIs('patient.profile'); @endphp
            <a href="{{ route('patient.profile') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="truncate">Medical Profile &amp; History</span>
            </a>

        @else
            {{-- Public / Guest Navigation --}}
            @php $active = request()->is('/'); @endphp
            <a href="{{ url('/') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span class="truncate">Campus Health Portal</span>
            </a>

            @php $active = request()->routeIs('appointments*'); @endphp
            <a href="{{ route('appointments') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m4.93 4.93 14.14 14.14"/><path d="M2 12h20"/><path d="m19.07 4.93-14.14 14.14"/></svg>
                <span class="truncate">Emergency Appointment</span>
            </a>

            @php $active = request()->routeIs('patients.register'); @endphp
            <a href="{{ route('patients.register') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                <span class="truncate">Patient Registration</span>
            </a>

            @php $active = request()->routeIs('login'); @endphp
            <a href="{{ route('login') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded text-xs font-semibold transition-all duration-150 {{ $active ? 'bg-[#0f766e] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="size-4 shrink-0 {{ $active ? 'text-[#5eead4]' : 'text-slate-500 group-hover:text-[#0f766e]' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                <span class="truncate">Portal Sign In</span>
            </a>
        @endif
    </nav>

    {{-- Institutional Telemetry Footer in Sidebar --}}
    <div class="pt-2 border-t border-slate-100 space-y-2">
        <div class="px-2 py-1.5 rounded bg-slate-50 border border-slate-200/60 text-[11px] text-slate-600 flex items-center justify-between">
            <span class="flex items-center gap-1.5 font-medium">
                <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                UMC Online
            </span>
            <span class="font-mono text-[10px] text-slate-400">v2.4</span>
        </div>
        <a href="tel:0188888888" class="block px-2 py-1 text-[11px] text-red-700 hover:text-red-800 font-semibold flex items-center gap-1.5 no-underline">
            <svg class="size-3 text-red-500 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span>Hotline: 01888-888888</span>
        </a>
    </div>
</div>
