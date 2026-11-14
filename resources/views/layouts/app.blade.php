<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMC') | University Medical Centre</title>

    {{-- Medical Centre Favicon & App Icons --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v={{ file_exists(public_path('favicon.svg')) ? filemtime(public_path('favicon.svg')) : 100 }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v={{ file_exists(public_path('favicon-32x32.png')) ? filemtime(public_path('favicon-32x32.png')) : 100 }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v={{ file_exists(public_path('favicon-16x16.png')) ? filemtime(public_path('favicon-16x16.png')) : 100 }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ file_exists(public_path('favicon.ico')) ? filemtime(public_path('favicon.ico')) : 100 }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v={{ file_exists(public_path('apple-touch-icon.png')) ? filemtime(public_path('apple-touch-icon.png')) : 100 }}">

    {{-- High-Craft Modern Typography: Plus Jakarta Sans, Inter & JetBrains Mono (Clinical Clarity Spec) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans antialiased">

{{-- Institutional Medical Header --}}
<header class="bg-gradient-to-r from-[#091e3a] via-[#0b2446] to-[#0d3159] text-white border-b-2 border-[#0d9488] shadow-md relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ url('/') }}" class="flex items-center gap-x-3 text-white no-underline group focus-visible:outline-hidden">
            <div class="relative inline-flex justify-center items-center h-11 w-11 rounded-xl bg-gradient-to-br from-white to-slate-100 text-[#091e3a] border-2 border-[#0d9488] shrink-0 shadow-md group-hover:scale-105 transition-transform">
                <svg class="size-6 text-[#0d9488]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 6v12m6-6H6"/>
                </svg>
                <span class="absolute -bottom-1 -right-1 size-3 bg-[#14b8a6] rounded-full border-2 border-[#091e3a]"></span>
            </div>
            <div>
                <div class="font-bold text-xl tracking-tight text-white flex items-center gap-1.5">
                    <span>UniMed</span><span class="text-[#2dd4bf] font-extrabold">Center</span>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-teal-500/20 text-teal-200 border border-teal-400/30 ml-1">Clinical Portal</span>
                </div>
                <div class="text-[11px] text-teal-200/80 font-medium tracking-wide">
                    University Medical Centre &bull; Central Campus Healthcare
                </div>
            </div>
        </a>

        <div class="flex items-center gap-x-3">
            <div class="hidden lg:flex items-center gap-x-2.5 py-1.5 px-3.5 rounded-xl bg-black/40 backdrop-blur-md border border-white/15 text-xs text-white shadow-xs">
                <span class="relative flex size-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full size-2.5 bg-emerald-500"></span>
                </span>
                <span class="font-bold text-white tracking-wide">Emergency Hotline:</span>
                <a href="tel:0188888888" class="text-teal-300 font-bold hover:underline font-mono">01888-888888</a>
                <span class="text-white/30">|</span>
                <span class="text-teal-200/80 text-[11px]">24/7 Paramedic Response</span>
            </div>

            @guest
                <a href="{{ route('appointments') }}" class="btn btn-teal btn-sm shadow-sm">
                    <svg class="size-3.5 mr-1.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Emergency Appointment
                </a>
            @endguest
        </div>
    </div>
</header>

{{-- Sticky Navigation Bar --}}
<nav class="sticky top-0 z-50 bg-[#071527]/95 backdrop-blur-md border-b border-white/10 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        {{-- Navigation Links with SVG Icons --}}
        <div class="flex items-center gap-1.5 overflow-x-auto py-2 scrollbar-none">
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-1.5 rounded text-slate-300 hover:text-white hover:bg-white/10 shrink-0" aria-label="Toggle navigation menu" title="Open Navigation">
                <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
            </button>
            <a href="{{ url('/') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->is('/') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                Home
            </a>

            @auth
                @if(Auth::user()->isPatient())
                    <a href="{{ route('patient.dashboard') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('patient.dashboard') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        My Dashboard
                    </a>
                    <a href="{{ route('patient.queue') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('patient.queue') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Live Queue
                    </a>
                    <a href="{{ route('patient.appointments') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('patient.appointments*') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        Appointments
                    </a>
                    <a href="{{ route('patient.prescriptions') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('patient.prescriptions*') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                        Prescriptions
                    </a>
                    <a href="{{ route('patient.profile') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('patient.profile') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        My Profile
                    </a>
                @elseif(Auth::user()->isDoctor())
                    <a href="{{ route('doctor.dashboard') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('doctor.dashboard') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>
                        Doctor Desk
                    </a>
                    <a href="{{ route('doctor.queue') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('doctor.queue') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Consultation Queue
                    </a>
                    <a href="{{ route('doctor.prescriptions.create') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('doctor.prescriptions.create') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Generate Prescription
                    </a>
                @elseif(Auth::user()->isPharmacist())
                    <a href="{{ route('pharmacy.dashboard') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('pharmacy.dashboard') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        Pharmacy Desk
                    </a>
                    <a href="{{ route('pharmacy.inventory') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('pharmacy.inventory') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                        Medicine Inventory
                    </a>
                    <a href="{{ route('pharmacy.dispense') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('pharmacy.dispense') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Dispense Prescriptions
                    </a>
                @elseif(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        Admin Analytics
                    </a>
                    <a href="{{ route('admin.users') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('admin.users*') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        User Management
                    </a>
                    <a href="{{ route('pharmacy.inventory') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('pharmacy.inventory') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                        Medicine Stock
                    </a>
                    <a href="{{ route('doctor.queue') }}" class="py-1.5 px-3 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('doctor.queue') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Live Queues
                    </a>
                @endif
            @else
                <a href="{{ route('patients.register') }}" class="py-1.5 px-3.5 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('patients.register') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    Patient Registration
                </a>
                <a href="{{ route('appointments') }}" class="py-1.5 px-3.5 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('appointments') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Emergency Appointment
                </a>
                <a href="{{ route('login') }}" class="py-1.5 px-3.5 inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg transition-all {{ request()->routeIs('login') ? 'bg-[#0d9488] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                    Portal Login
                </a>
            @endauth
        </div>

        {{-- User Pill / Logout --}}
        <div class="flex items-center gap-x-2.5 py-2">
            @auth
                <div class="inline-flex items-center gap-x-2 py-1 px-2.5 rounded bg-white/10 border border-white/15 text-xs">
                    <span class="avatar-initials size-6 bg-teal-500/20 text-teal-300 border border-teal-400/40 text-[11px] font-mono">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                    <span class="text-white font-medium max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                    @php
                        $roleBadges = [
                            'admin' => 'badge-red',
                            'doctor' => 'badge-blue',
                            'pharmacist' => 'badge-cyan',
                            'patient' => 'badge-teal',
                        ];
                    @endphp
                    <span class="badge {{ $roleBadges[Auth::user()->role] ?? 'badge-gray' }} py-0.5 px-2">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="py-1 px-2.5 inline-flex items-center gap-1 text-xs font-semibold rounded border border-white/25 text-white hover:bg-white/15 transition-colors cursor-pointer" title="Log Out">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
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
                <a href="{{ url('/') }}" class="text-[#0d9488] hover:text-[#0f766e] font-semibold flex items-center gap-x-1">
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
    @if(Auth::check() || (!request()->is('/') && !request()->routeIs('home')))
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            @include('layouts.sidebar')
            <div class="flex-1 min-w-0 w-full">
                @if(session('success'))
                    <div class="bg-teal-50 border-l-4 border-[#0d9488] rounded-r-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-teal-950 border-y border-r border-teal-200" role="alert">
                        <svg class="shrink-0 size-5 text-[#0d9488]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        <div class="font-medium">{{ session('success') }}</div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-600 rounded-r-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-rose-950 border-y border-r border-rose-200" role="alert">
                        <svg class="shrink-0 size-5 text-rose-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        <div class="font-medium">{{ session('error') }}</div>
                    </div>
                @endif
                @if(session('info'))
                    <div class="bg-sky-50 border-l-4 border-sky-600 rounded-r-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-sky-950 border-y border-r border-sky-200" role="alert">
                        <svg class="shrink-0 size-5 text-sky-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <div class="font-medium">{{ session('info') }}</div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    @else
        @if(session('success'))
            <div class="bg-teal-50 border-l-4 border-[#0d9488] rounded-r-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-teal-950 border-y border-r border-teal-200" role="alert">
                <svg class="shrink-0 size-5 text-[#0d9488]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-600 rounded-r-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-rose-950 border-y border-r border-rose-200" role="alert">
                <svg class="shrink-0 size-5 text-rose-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif
        @if(session('info'))
            <div class="bg-sky-50 border-l-4 border-sky-600 rounded-r-xl p-4 mb-5 shadow-xs flex items-center gap-x-3 text-sm text-sky-950 border-y border-r border-sky-200" role="alert">
                <svg class="shrink-0 size-5 text-sky-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <div class="font-medium">{{ session('info') }}</div>
            </div>
        @endif

        @yield('content')
    @endif
</main>

{{-- Institutional Footer --}}
<footer class="mt-auto bg-[#071527] text-white border-t-2 border-[#0d9488]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-300">
        <div>
            <div class="font-bold text-white text-sm tracking-tight mb-1 flex items-center gap-2">
                <span>University Medical Centre</span>
                <span class="text-[10px] bg-[#0d9488]/30 text-teal-300 px-2 py-0.5 rounded-full border border-teal-500/30">Central Campus</span>
            </div>
            <p class="text-slate-400">Health &amp; Clinical Services Division &nbsp;|&nbsp; 24/7 Emergency Shifts &nbsp;|&nbsp; Hotline: 01888-888888</p>
            <p class="text-slate-500 text-[11px] mt-1">&copy; {{ date('Y') }} UniMedCenter. Subsidized clinical &amp; pharmaceutical services for university members.</p>
        </div>
        <div class="text-teal-400 font-bold tracking-wider text-xs bg-white/5 px-3 py-1.5 rounded-lg border border-white/10">
            UNIMED HEALTHCARE
        </div>
    </div>
</footer>

{{-- Mobile Sidebar Off-Canvas Drawer --}}
<div id="mobileSidebarDrawer" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden lg:hidden" onclick="toggleMobileSidebar()">
    <div class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-white shadow-2xl p-4 flex flex-col justify-between overflow-y-auto" onclick="event.stopPropagation()">
        <div>
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-[#0f766e] text-white flex items-center justify-center font-bold text-xs shadow-xs">UMC</div>
                    <div>
                        <span class="block text-xs font-bold text-[#091e3a]">UniMed Center</span>
                        <span class="block text-[10px] text-slate-400 font-medium">Campus Health Portal</span>
                    </div>
                </div>
                <button type="button" onclick="toggleMobileSidebar()" class="p-1 rounded text-slate-400 hover:text-slate-700" aria-label="Close menu">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>
            </div>
            @include('layouts.sidebar-links')
        </div>
    </div>
</div>

<script>
    function toggleMobileSidebar() {
        const drawer = document.getElementById('mobileSidebarDrawer');
        if (drawer) {
            drawer.classList.toggle('hidden');
        }
    }

    function togglePasswordVisibility(inputId, btn) {
        var input = document.getElementById(inputId);
        if (!input) return;
        var isPassword = (input.type === 'password');
        input.type = isPassword ? 'text' : 'password';
        var openIcon = btn.querySelector('.eye-open');
        var closedIcon = btn.querySelector('.eye-closed');
        if (openIcon && closedIcon) {
            if (isPassword) {
                openIcon.classList.add('hidden');
                closedIcon.classList.remove('hidden');
            } else {
                openIcon.classList.remove('hidden');
                closedIcon.classList.add('hidden');
            }
        }
    }
</script>

@stack('scripts')
</body>
</html>
