<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMC') | University Medical Centre</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans antialiased">

{{-- Institutional Medical Header --}}
<header class="bg-[#1a6b3a] text-white border-b-2 border-[#c8922a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ url('/') }}" class="flex items-center gap-x-3 text-white no-underline group">
            <div class="inline-flex justify-center items-center h-10 min-w-10 px-2.5 rounded-lg bg-white text-[#1a6b3a] font-black text-xs tracking-wider shrink-0 shadow-sm">
                UMC
            </div>
            <div>
                <div class="font-bold text-lg tracking-tight text-white flex items-center gap-1">
                    <span>UniMed</span><span class="text-[#c8922a]">Center</span>
                </div>
                <div class="text-[11px] text-emerald-100 font-medium tracking-wide uppercase">
                    University Medical Centre &mdash; Central Campus
                </div>
            </div>
        </a>

        <div class="hidden md:flex items-center gap-x-3">
            <div class="inline-flex items-center gap-x-2 py-1.5 px-3.5 rounded-lg bg-black/20 border border-white/15 text-xs text-white">
                <span class="size-2 rounded-full bg-emerald-300 animate-pulse"></span>
                <span class="font-bold text-white">Emergency Hotline: 01888-888888</span>
                <span class="text-white/40">|</span>
                <span class="text-emerald-100 text-[11px]">OPD 8:00am&ndash;8:00pm &bull; 24/7 Emergency Shifts</span>
            </div>
        </div>
    </div>
</header>

{{-- Sticky Navigation Bar --}}
<nav class="sticky top-0 z-50 bg-[#134d2a] border-b border-black/15 text-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        {{-- Navigation Links --}}
        <div class="flex items-center gap-1 overflow-x-auto py-2">
            <a href="{{ url('/') }}" class="py-1.5 px-3.5 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->is('/') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Home</a>

            @auth
                @if(Auth::user()->isPatient())
                    <a href="{{ route('patient.dashboard') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('patient.dashboard') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">My Dashboard</a>
                    <a href="{{ route('patient.queue') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('patient.queue') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Live Queue</a>
                    <a href="{{ route('patient.appointments') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('patient.appointments*') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Appointments</a>
                    <a href="{{ route('patient.prescriptions') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('patient.prescriptions*') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Prescriptions</a>
                    <a href="{{ route('patient.profile') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('patient.profile') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">My Profile</a>
                @elseif(Auth::user()->isDoctor())
                    <a href="{{ route('doctor.dashboard') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('doctor.dashboard') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Doctor Desk</a>
                    <a href="{{ route('doctor.queue') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('doctor.queue') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Consultation Queue</a>
                    <a href="{{ route('doctor.prescriptions.create') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('doctor.prescriptions.create') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Generate Prescription</a>
                @elseif(Auth::user()->isPharmacist())
                    <a href="{{ route('pharmacy.dashboard') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pharmacy.dashboard') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Pharmacy Desk</a>
                    <a href="{{ route('pharmacy.inventory') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pharmacy.inventory') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Medicine Inventory</a>
                    <a href="{{ route('pharmacy.dispense') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pharmacy.dispense') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Dispense Prescriptions</a>
                @elseif(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Admin Analytics</a>
                    <a href="{{ route('admin.users') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">User Management</a>
                    <a href="{{ route('pharmacy.inventory') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pharmacy.inventory') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Medicine Stock</a>
                    <a href="{{ route('doctor.queue') }}" class="py-1.5 px-3 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('doctor.queue') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Live Queues</a>
                @endif
            @else
                <a href="{{ route('appointments') }}" class="py-1.5 px-3.5 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('appointments') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Emergency Booking</a>
                <a href="{{ route('login') }}" class="py-1.5 px-3.5 inline-flex items-center text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('login') ? 'bg-[#1a6b3a] text-white shadow-xs border-b-2 border-[#c8922a]' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">Portal Login</a>
            @endauth
        </div>

        {{-- Preline User Pill / Logout --}}
        <div class="flex items-center gap-x-2.5 py-2">
            @auth
                @php
                    $otherAccounts = Auth::user()->otherRoleAccounts();
                @endphp
                @if($otherAccounts->count() > 0)
                    <div class="hidden sm:inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-full bg-white/10 border border-white/15 text-xs text-white">
                        <span class="text-emerald-200 text-[11px]">Switch Portal:</span>
                        @foreach($otherAccounts as $alt)
                            <form action="{{ route('role.switch', $alt->role) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="font-bold underline text-[#c8922a] hover:text-white transition-colors cursor-pointer text-xs">
                                    {{ ucfirst($alt->role) }}
                                </button>
                            </form>
                            @if(! $loop->last)<span class="text-white/30">&bull;</span>@endif
                        @endforeach
                    </div>
                @endif
                <div class="inline-flex items-center gap-x-2 py-1 px-3 rounded-full bg-white/10 border border-white/15 text-xs">
                    <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                    @php
                        $roleBadges = [
                            'admin' => 'badge-red',
                            'doctor' => 'badge-blue',
                            'pharmacist' => 'badge-gold',
                            'patient' => 'badge-green',
                        ];
                    @endphp
                    <span class="badge {{ $roleBadges[Auth::user()->role] ?? 'badge-gray' }}">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="py-1 px-2.5 inline-flex items-center text-xs font-medium rounded-md border border-white/30 text-white hover:bg-white/15 transition-colors">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

{{-- Breadcrumbs Line --}}
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5">
        <ol class="flex items-center whitespace-nowrap text-xs text-gray-500 gap-x-2">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="text-[#1a6b3a] hover:text-[#134d2a] font-semibold flex items-center gap-x-1">
                    Home
                </a>
            </li>
            <li>
                <svg class="shrink-0 size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </li>
            <li class="font-semibold text-gray-800 truncate">
                @yield('title', 'Portal')
            </li>
        </ol>
    </div>
</div>

{{-- Main Container --}}
<main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
    @if(session('success'))
        <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-teal-800" role="alert">
            <svg class="shrink-0 size-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-5 rounded-md text-sm text-red-800 shadow-xs flex items-center gap-x-3" role="alert">
            <svg class="shrink-0 size-4 text-red-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-sm text-blue-800 rounded-lg p-4 mb-5 shadow-xs flex items-center gap-x-3" role="alert">
            <svg class="shrink-0 size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    @yield('content')
</main>

{{-- Institutional Preline Footer --}}
<footer class="mt-auto bg-[#134d2a] text-white border-t-2 border-[#c8922a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-wrap items-center justify-between gap-4 text-xs text-emerald-100/80">
        <div>
            <div class="font-bold text-white text-sm tracking-tight mb-1">University Medical Centre</div>
            <p class="text-emerald-200/70">Health &amp; Wellness Division &mdash; Central Campus &nbsp;|&nbsp; Hotline: 01888-888888</p>
            <p class="text-emerald-200/50 text-[11px] mt-1">&copy; {{ date('Y') }} All rights reserved. Subsidized clinical services for university members.</p>
        </div>
        <div class="text-emerald-200/60 font-medium text-xs">
            UNIMED
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
