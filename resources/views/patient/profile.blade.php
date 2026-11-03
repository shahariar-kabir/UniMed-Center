@extends('layouts.app')
@section('title', 'Patient Profile & Verification')

@section('content')
<div class="mb-6">
    <h1 class="page-title">Patient Profile &amp; Identity Verification</h1>
    <p class="page-subtitle">Manage your verified university health profile, pre-existing medical conditions, emergency contacts, and allergies.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    {{-- Left: Identity Verification Card (4 cols) --}}
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl p-5 text-center">
            <div class="text-[11px] font-bold text-[#1a6b3a] tracking-wider uppercase">University Identity Card</div>
            <h3 class="text-base font-bold text-[#134d2a] mt-1">{{ $patient->full_name }}</h3>
            <div class="text-xs text-gray-500 mt-0.5">{{ $patient->university_id }}</div>

            <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 font-bold text-[11px] py-1 px-3 rounded-full uppercase tracking-wider my-3 border border-emerald-200">
                Verified Identity
            </div>

            <div class="text-left text-xs text-gray-600 space-y-2 pt-3 border-t border-gray-100">
                <div class="flex items-center justify-between"><span class="text-gray-500">Category:</span> <strong class="text-slate-800">{{ ucfirst($patient->role_category) }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-gray-500">Department:</span> <strong class="text-slate-800">{{ $patient->department ?? 'General' }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-gray-500">Semester / Year:</span> <strong class="text-slate-800">{{ $patient->year_semester ?? 'N/A' }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-gray-500">Blood Group:</span> <span class="badge badge-red">{{ $patient->blood_group ?? 'Not Set' }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-500">Nationality:</span> <strong class="text-slate-800">{{ $patient->nationality }}</strong></div>
                <div class="flex items-center justify-between"><span class="text-gray-500">Member Since:</span> <strong class="text-slate-800">{{ $patient->created_at->format('M Y') }}</strong></div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 border-t-4 border-t-red-600 shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-red-700 border-b border-gray-200 pb-2 mb-3">
                Medical Alert Summary
            </h3>
            <div class="text-xs text-gray-600 space-y-3">
                <div>
                    <strong class="text-red-700 block mb-0.5">Allergies:</strong>
                    <p class="leading-relaxed">{{ $patient->allergies ?: 'No drug or food allergies on record.' }}</p>
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
                        <p class="text-gray-400">None reported.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Edit Details Form (8 cols) --}}
    <div class="lg:col-span-8 bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Update Contact &amp; Emergency Information</span>
            <span class="badge badge-gold">Profile Settings</span>
        </div>
        <div class="p-5 sm:p-6">
            <form action="{{ route('patient.profile.update') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Phone Number <span class="req">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone) }}" required>
                    </div>
                    <div>
                        <label class="form-label">Official University Email</label>
                        <input type="email" class="form-control bg-slate-50 text-gray-500 cursor-not-allowed" value="{{ $patient->email }}" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Emergency Contact Person</label>
                        <input type="text" name="emergency_name" class="form-control" placeholder="e.g. Guardian / Parent Name" value="{{ old('emergency_name', $patient->emergency_name) }}">
                    </div>
                    <div>
                        <label class="form-label">Emergency Phone Number</label>
                        <input type="text" name="emergency_phone" class="form-control" placeholder="e.g. 01XXXXXXXXX" value="{{ old('emergency_phone', $patient->emergency_phone) }}">
                    </div>
                </div>

                <div>
                    <label class="form-label">Current Hall / Residence Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $patient->address) }}</textarea>
                </div>

                <div>
                    <label class="form-label">Drug / Food Allergies</label>
                    <input type="text" name="allergies" class="form-control" placeholder="e.g. Penicillin, Sulfa drugs, Shellfish" value="{{ old('allergies', $patient->allergies) }}">
                    <span class="text-[11px] text-gray-400 mt-1 block">Crucial for doctor digital prescription warnings.</span>
                </div>

                <div>
                    <label class="form-label">Current Long-term Medications</label>
                    <textarea name="medications" class="form-control" rows="2" placeholder="e.g. Salbutamol Inhaler, Metformin 500mg">{{ old('medications', $patient->medications) }}</textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn btn-green">Save Profile Changes &rarr;</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
