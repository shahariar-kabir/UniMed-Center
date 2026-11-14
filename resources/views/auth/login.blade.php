@extends('layouts.app')
@section('title', 'Portal Login')

@section('content')
<div class="max-w-5xl mx-auto mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 border border-teal-200/80 text-[#0d9488] text-xs font-semibold mb-2">
                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Institutional Healthcare Access</span>
            </div>
            <h1 class="page-title text-2xl sm:text-3xl font-extrabold text-[#091e3a]">University Medical Centre Portal Login</h1>
            <p class="page-subtitle text-xs sm:text-sm text-slate-500">Sign in to access your administrative console, patient health pass, doctor consultation desk, or pharmacy dispensary.</p>
        </div>
        <div class="hidden sm:flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 shadow-xs text-xs text-slate-600">
            <span class="badge-dot bg-emerald-500"></span>
            <span>OPD &amp; Emergency Systems Online</span>
        </div>
    </div>
</div>

@if(\App\Models\User::where('role', 'admin')->count() === 0)
    <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4 mb-6 max-w-5xl mx-auto flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs" role="alert">
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

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 max-w-5xl mx-auto items-stretch">
    {{-- Main Login Form (7 cols) --}}
    <div class="lg:col-span-7 bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden flex flex-col transition-shadow hover:shadow-md">
        <div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
            <div class="flex items-center gap-2.5">
                <div class="size-8 rounded bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                    <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider block font-heading">Medical Portal Sign In</span>
                    <span class="text-[11px] text-teal-200/80">Secured with University Credentials</span>
                </div>
            </div>
            <span class="badge badge-cyan text-[11px]">Authorized SSO</span>
        </div>

        <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-6">
            <div>
                @if($errors->any())
                    <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-5 rounded-xl text-xs text-red-800 flex items-start gap-x-2.5" role="alert">
                        <svg class="shrink-0 size-4 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        <div>
                            <div class="font-bold mb-0.5">Authentication Failed</div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-4" id="loginForm">
                    @csrf

                    <div>
                        <label class="form-label font-semibold text-slate-700">University Email Address <span class="req">*</span></label>
                        <div class="relative input-icon-container">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </span>
                            <input type="email" id="loginEmail" name="email" class="form-control !pl-10 text-xs rounded" placeholder="user@university.edu.bd" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="form-label mb-0 font-semibold text-slate-700">Password <span class="req">*</span></label>
                            <span class="text-[11px] text-slate-400">Encrypted</span>
                        </div>
                        <div class="relative input-icon-container">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input type="password" id="loginPassword" name="password" class="form-control !pl-10 pr-10 text-xs rounded" placeholder="Enter your password" required>
                            <button type="button" onclick="togglePasswordVisibility('loginPassword', this)" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-slate-700 cursor-pointer focus:outline-hidden" title="Show or hide password" aria-label="Toggle password visibility">
                                <svg class="eye-open size-4.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="eye-closed size-4.5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="form-label mb-0 font-semibold text-slate-700">Target Medical Console</label>
                            <span class="text-[11px] text-[#0d9488] font-medium">Auto-detected if left default</span>
                        </div>
                        <select name="role" id="loginRole" class="form-control text-xs">
                            <option value="">&mdash; Auto-Detect from User Role &mdash;</option>
                            <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient Health Portal</option>
                            <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor Consultation Desk</option>
                            <option value="pharmacist" {{ old('role') === 'pharmacist' ? 'selected' : '' }}>Central Pharmacy &amp; Inventory Hub</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Executive Healthcare Administration</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between pt-1 text-xs">
                        <label class="flex items-center gap-x-2 cursor-pointer text-slate-700 select-none">
                            <input type="checkbox" name="remember" class="shrink-0 size-4 border-slate-300 rounded text-[#0d9488] focus:ring-[#0d9488]">
                            <span>Remember active session</span>
                        </label>
                        <span class="text-slate-400 text-[11px]">Protected by CSRF &amp; Rate Limits</span>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn btn-green w-full py-2.5 flex items-center justify-center gap-2 text-sm font-bold shadow-sm hover:shadow">
                            <span>Sign In to Medical Portal</span>
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>New patient at campus?</span>
                <a href="{{ route('patients.register') }}" class="text-[#0d9488] font-bold hover:underline inline-flex items-center gap-1">
                    <span>Register Patient Profile</span>
                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- System Gateways & Demo Credentials (5 cols) --}}
    <div class="lg:col-span-5 bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden flex flex-col transition-shadow hover:shadow-md">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block">Portals &amp; One-Click Demo</span>
                <span class="text-[11px] text-teal-200/80">Click a role to prefill demo credentials</span>
            </div>
            <span class="badge badge-gold text-[10px]">Role-Based</span>
        </div>

        <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                {{-- Doctor Console --}}
                <div class="p-3 rounded-xl border border-slate-200/90 bg-slate-50/70 hover:bg-teal-50/50 hover:border-teal-200 transition-all flex items-center justify-between gap-3 group">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-lg bg-teal-500/10 text-[#0d9488] flex items-center justify-center shrink-0 border border-teal-500/20 group-hover:bg-[#0d9488] group-hover:text-white transition-colors">
                            <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 19 2-2M14 5l2-2"/><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/><path d="M18 19c0-3.3-2.7-6-6-6s-6 2.7-6 6"/><path d="M18 12a3 3 0 0 0 3-3V7"/><path d="M3 7v2a3 3 0 0 0 3 3"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>Doctor Consultation</span>
                                <span class="badge badge-cyan text-[10px]">OPD Desk</span>
                            </div>
                            <div class="text-[11px] text-slate-500">Live Queue &amp; Digital Rx Generator</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" onclick="fillDemo('doctor@bu.edu.bd', 'password', 'doctor')" class="px-2 py-1 rounded bg-teal-100/70 hover:bg-teal-200 text-[#0f766e] text-[10px] font-bold transition-colors cursor-pointer" title="Auto-fill doctor demo login">
                            Demo Fill
                        </button>
                        <a href="{{ route('doctor.register') }}" class="btn btn-outline btn-xs !py-1 !px-2 text-[10px]">Register</a>
                    </div>
                </div>

                {{-- Patient Portal --}}
                <div class="p-3 rounded-xl border border-slate-200/90 bg-slate-50/70 hover:bg-emerald-50/50 hover:border-emerald-200 transition-all flex items-center justify-between gap-3 group">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-lg bg-emerald-500/10 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-500/20 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>Patient Portal</span>
                                <span class="badge badge-green text-[10px]">Health Pass</span>
                            </div>
                            <div class="text-[11px] text-slate-500">Prescriptions, Appointments, Tokens</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" onclick="fillDemo('patient@bu.edu.bd', 'password', 'patient')" class="px-2 py-1 rounded bg-emerald-100/70 hover:bg-emerald-200 text-emerald-800 text-[10px] font-bold transition-colors cursor-pointer" title="Auto-fill patient demo login">
                            Demo Fill
                        </button>
                        <a href="{{ route('patients.register') }}" class="btn btn-outline btn-xs !py-1 !px-2 text-[10px]">Register</a>
                    </div>
                </div>

                {{-- Central Pharmacy --}}
                <div class="p-3 rounded-xl border border-slate-200/90 bg-slate-50/70 hover:bg-amber-50/50 hover:border-amber-200 transition-all flex items-center justify-between gap-3 group">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-lg bg-amber-500/10 text-amber-700 flex items-center justify-center shrink-0 border border-amber-500/20 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>Central Pharmacy</span>
                                <span class="badge badge-gold text-[10px]">Dispensary</span>
                            </div>
                            <div class="text-[11px] text-slate-500">Medicine Stock, Batches &amp; Dispensing</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" onclick="fillDemo('pharma@bu.edu.bd', 'password', 'pharmacist')" class="px-2 py-1 rounded bg-amber-100/70 hover:bg-amber-200 text-amber-800 text-[10px] font-bold transition-colors cursor-pointer" title="Auto-fill pharmacist demo login">
                            Demo Fill
                        </button>
                        <a href="{{ route('pharmacy.register') }}" class="btn btn-outline btn-xs !py-1 !px-2 text-[10px]">Register</a>
                    </div>
                </div>

                {{-- System Administrator --}}
                <div class="p-3 rounded-xl border border-slate-200/90 bg-slate-50/70 hover:bg-rose-50/50 hover:border-rose-200 transition-all flex items-center justify-between gap-3 group">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-lg bg-rose-500/10 text-rose-700 flex items-center justify-center shrink-0 border border-rose-500/20 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 0-5 5v2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V7a5 5 0 0 0-5-5z"/><path d="M12 14v3"/><circle cx="12" cy="7" r="2"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>Administration</span>
                                <span class="badge badge-red text-[10px]">Director</span>
                            </div>
                            <div class="text-[11px] text-slate-500">Analytics, Roster &amp; Staff Roles</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" onclick="fillDemo('admin@bu.edu.bd', 'password', 'admin')" class="px-2 py-1 rounded bg-rose-100/70 hover:bg-rose-200 text-rose-800 text-[10px] font-bold transition-colors cursor-pointer" title="Auto-fill admin demo login">
                            Demo Fill
                        </button>
                        <a href="{{ route('admin.register') }}" class="btn btn-outline btn-xs !py-1 !px-2 text-[10px]">Register</a>
                    </div>
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="badge-dot bg-red-500"></span>
                    <span class="font-medium">Emergency Assistance:</span>
                </div>
                <a href="tel:01888888888" class="font-black text-rose-700 hover:underline">01888-888888</a>
            </div>
        </div>
    </div>
</div>

<script>
function fillDemo(email, pass, role) {
    document.getElementById('loginEmail').value = email;
    document.getElementById('loginPassword').value = pass;
    document.getElementById('loginRole').value = role;
    // Highlight inputs briefly
    ['loginEmail', 'loginPassword', 'loginRole'].forEach(id => {
        const el = document.getElementById(id);
        el.classList.add('ring-2', 'ring-teal-400');
        setTimeout(() => el.classList.remove('ring-2', 'ring-teal-400'), 700);
    });
}
</script>
@endsection
