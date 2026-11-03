@extends('layouts.app')
@section('title', 'Portal Login')

@section('content')
<div class="max-w-4xl mx-auto mb-6">
    <h1 class="page-title">University Medical Centre Portal Login</h1>
    <p class="page-subtitle">Access your administrative console, patient health records, doctor consultation desk, or pharmacy dispensary.</p>
</div>

@if(\App\Models\User::where('role', 'admin')->count() === 0)
    <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4 mb-6 max-w-4xl mx-auto flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs" role="alert">
        <div class="flex items-center gap-x-3">
            <svg class="shrink-0 size-5 text-amber-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                <strong class="font-bold">Initial System Setup:</strong> No Administrator account is currently registered.
                <span class="block text-amber-900/80 mt-0.5">Please register the primary Administrator account to configure the medical centre.</span>
            </div>
        </div>
        <a href="{{ route('admin.register') }}" class="btn btn-green btn-sm">Register First Admin &rarr;</a>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto items-stretch">
    {{-- Main Preline Login Form --}}
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col">
        <div class="bg-[#134d2a] text-white px-5 py-3.5">
            <span class="text-xs font-bold uppercase tracking-wider">Medical Portal Sign In</span>
        </div>

        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                @if($errors->any())
                    <div class="bg-red-50 border-s-4 border-red-500 p-3.5 mb-4 rounded-md text-xs text-red-800 flex items-center gap-x-2" role="alert">
                        <svg class="shrink-0 size-4 text-red-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="form-label">University Email Address <span class="req">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="user@university.edu.bd" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div>
                        <label class="form-label">Password <span class="req">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your account password" required>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="form-label mb-0">Portal Destination</label>
                            <span class="text-[11px] text-gray-400">Auto-Detect by Default</span>
                        </div>
                        <select name="role" class="form-control text-xs">
                            <option value="">&mdash; Auto-Detect from Credentials &mdash;</option>
                            <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient Portal</option>
                            <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor Consultation Desk</option>
                            <option value="pharmacist" {{ old('role') === 'pharmacist' ? 'selected' : '' }}>Pharmacy &amp; Dispensary</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>System Administrator</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between pt-1 text-xs">
                        <label class="flex items-center gap-x-2 cursor-pointer text-slate-700 select-none">
                            <input type="checkbox" name="remember" class="shrink-0 border-gray-300 rounded text-emerald-600 focus:ring-emerald-500">
                            <span>Remember session</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn btn-green w-full py-2.5">Sign In to Medical Portal</button>
                    </div>
                </form>
            </div>

            <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span>Need an account?</span>
                <a href="{{ route('patients.register') }}" class="text-[#1a6b3a] font-bold hover:underline">Register as Patient</a>
            </div>
        </div>
    </div>

    {{-- System Gateways & Portal Overview --}}
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Medical Centre Portals</span>
            <span class="badge badge-gold">Role-Based Access</span>
        </div>

        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                    Sign in with your university credentials. The system automatically redirects you to your authorized portal:
                </p>

                <div class="space-y-3">
                    {{-- Admin Portal --}}
                    <div class="p-3.5 rounded-lg border border-gray-200 bg-slate-50/60 hover:bg-slate-50 transition-colors flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-800">System Administrator</div>
                            <div class="text-[11px] text-gray-500">Analytics, Roster &amp; Staff Roles</div>
                        </div>
                        <a href="{{ route('admin.register') }}" class="btn btn-outline btn-sm w-36 shrink-0 text-center justify-center">Register Admin</a>
                    </div>

                    {{-- Patient Portal --}}
                    <div class="p-3.5 rounded-lg border border-gray-200 bg-slate-50/60 hover:bg-slate-50 transition-colors flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Patient Portal</div>
                            <div class="text-[11px] text-gray-500">Appointments &amp; Prescriptions</div>
                        </div>
                        <a href="{{ route('patients.register') }}" class="btn btn-outline btn-sm w-36 shrink-0 text-center justify-center">Register Patient</a>
                    </div>

                    {{-- Doctor Consultation Desk --}}
                    <div class="p-3.5 rounded-lg border border-gray-200 bg-slate-50/60 hover:bg-slate-50 transition-colors flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Doctor Consultation Desk</div>
                            <div class="text-[11px] text-gray-500">Patient Queue &amp; Digital Rx</div>
                        </div>
                        <a href="{{ route('doctor.register') }}" class="btn btn-outline btn-sm w-36 shrink-0 text-center justify-center">Register Doctor</a>
                    </div>

                    {{-- Pharmacy Desk --}}
                    <div class="p-3.5 rounded-lg border border-gray-200 bg-slate-50/60 hover:bg-slate-50 transition-colors flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Pharmacy &amp; Inventory</div>
                            <div class="text-[11px] text-gray-500">Stock Management &amp; Dispensing</div>
                        </div>
                        <a href="{{ route('pharmacy.register') }}" class="btn btn-outline btn-sm w-36 shrink-0 text-center justify-center">Register Pharma</a>
                    </div>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-gray-100 text-xs text-gray-500 flex items-center justify-between">
                <span>Emergency Contact:</span>
                <strong class="text-emerald-800 font-semibold">01888-888888</strong>
            </div>
        </div>
    </div>
</div>
@endsection
