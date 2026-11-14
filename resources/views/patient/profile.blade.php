@extends('layouts.app')
@section('title', 'Patient Profile & Verification')

@section('content')
{{-- Patient Profile Header --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-2xl p-6 mb-6 shadow-sm border-b-4 border-[#0d9488] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-2xl bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0">
            {{ strtoupper(substr($patient->first_name ?? $patient->full_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name ?? '', 0, 1)) }}
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-gold text-[11px] font-mono">{{ $patient->university_id }}</span>
                <span class="badge badge-cyan text-[11px]">{{ ucfirst($patient->role_category) }}</span>
                @if($patient->blood_group)
                    <span class="badge badge-red text-[11px]">Blood: {{ $patient->blood_group }}</span>
                @endif
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-white">{{ $patient->full_name }}</h1>
            <p class="text-xs text-teal-100/80">Department of {{ $patient->department ?? 'General' }} &bull; Health Profile &amp; Verification Pass</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('patient.prescriptions') }}" class="btn btn-outline-white btn-sm flex items-center gap-1.5">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span>My Prescriptions &rarr;</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    {{-- Left: Identity Verification Card (4 cols) --}}
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-white border border-slate-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-2xl p-6 text-center">
            <div class="text-[11px] font-bold text-[#0d9488] tracking-wider uppercase">University Identity Card</div>
            <h3 class="text-lg font-black text-[#091e3a] mt-1">{{ $patient->full_name }}</h3>
            <div class="font-mono text-xs text-slate-500 mt-0.5">{{ $patient->university_id }}</div>

            <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 font-bold text-[11px] py-1 px-3 rounded-full uppercase tracking-wider my-3.5 border border-emerald-200">
                <span class="badge-dot bg-emerald-500"></span>
                <span>Verified Medical Record</span>
            </div>

            <div class="text-left text-xs text-slate-600 space-y-2.5 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between"><span class="text-slate-400">Category:</span> <strong class="text-slate-800">{{ ucfirst($patient->role_category) }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-slate-400">Department:</span> <strong class="text-slate-800">{{ $patient->department ?? 'General' }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-slate-400">Semester / Year:</span> <strong class="text-slate-800">{{ $patient->year_semester ?? 'N/A' }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-slate-400">Blood Group:</span> <span class="badge badge-red font-bold">{{ $patient->blood_group ?? 'Not Set' }}</span></div>
                <div class="flex items-center justify-between"><span class="text-slate-400">Nationality:</span> <strong class="text-slate-800">{{ $patient->nationality }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-slate-400">Member Since:</span> <strong class="text-slate-800">{{ $patient->created_at->format('M Y') }}</strong></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 border-t-4 border-t-red-600 shadow-sm rounded-2xl p-6">
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-red-700 border-b border-slate-200 pb-2 mb-3">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span>Medical Alert Summary</span>
            </div>
            <div class="text-xs text-slate-600 space-y-3">
                <div>
                    <strong class="text-red-700 block mb-0.5">Known Drug Allergies:</strong>
                    <p class="leading-relaxed font-bold text-slate-800">{{ $patient->allergies ?: 'No drug or food allergies on record.' }}</p>
                </div>
                <div>
                    <strong class="text-slate-800 block mb-0.5">Pre-existing Conditions:</strong>
                    @if(!empty($patient->conditions) && is_array($patient->conditions))
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($patient->conditions as $cond)
                                <li>{{ $cond }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-slate-400">None reported.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Edit Details Form (8 cols) --}}
    <div class="lg:col-span-8 bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
            <div class="flex items-center gap-2.5">
                <div class="size-8 rounded-lg bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                    <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider block">Update Contact &amp; Emergency Information</span>
                    <span class="text-[11px] text-teal-200/80">Health Profile Settings</span>
                </div>
            </div>
            <span class="badge badge-gold text-[10px]">Profile Settings</span>
        </div>
        <div class="p-6 sm:p-7">
            <form action="{{ route('patient.profile.update') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label font-semibold text-slate-700">Phone Number <span class="req">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone) }}" required>
                    </div>
                    <div>
                        <label class="form-label font-semibold text-slate-700">Official University Email</label>
                        <input type="email" class="form-control bg-slate-50 text-slate-500 cursor-not-allowed" value="{{ $patient->email }}" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label font-semibold text-slate-700">Emergency Contact Person</label>
                        <input type="text" name="emergency_name" class="form-control" placeholder="e.g. Guardian / Parent Name" value="{{ old('emergency_name', $patient->emergency_name) }}">
                    </div>
                    <div>
                        <label class="form-label font-semibold text-slate-700">Emergency Phone Number</label>
                        <input type="text" name="emergency_phone" class="form-control" placeholder="e.g. 01XXXXXXXXX" value="{{ old('emergency_phone', $patient->emergency_phone) }}">
                    </div>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Current Hall / Residence Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $patient->address) }}</textarea>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Drug / Food Allergies</label>
                    <input type="text" name="allergies" class="form-control" placeholder="e.g. Penicillin, Sulfa drugs, Shellfish" value="{{ old('allergies', $patient->allergies) }}">
                    <span class="text-[11px] text-slate-400 mt-1 block">Crucial for doctor digital prescription warnings and emergency medicine safety.</span>
                </div>

                <div>
                    <label class="form-label font-semibold text-slate-700">Current Long-term Medications</label>
                    <textarea name="medications" class="form-control" rows="2" placeholder="e.g. Salbutamol Inhaler, Metformin 500mg">{{ old('medications', $patient->medications) }}</textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn btn-green flex items-center gap-2 font-bold shadow-sm">
                        <span>Save Profile Changes</span>
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
