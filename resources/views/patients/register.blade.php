@extends('layouts.app')
@section('title', 'Patient Registration')

@section('content')

<div class="mb-6">
    <h1 class="page-title">Patient Registration</h1>
    <p class="page-subtitle">Complete the form below to register as a patient of the University Medical Centre. Please fill in all required fields accurately. Your clinical records are kept in strict confidentiality.</p>
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
            <span>Please correct the following errors:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 ml-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Main Form (2 cols) --}}
    <div class="lg:col-span-2 space-y-6">
        <form method="POST" action="{{ url('/patients/register') }}" novalidate class="space-y-6">
            @csrf

            {{-- Section 1: Personal Details --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                    <span class="text-xs font-bold uppercase tracking-wider">Section 1 &mdash; Personal Details</span>
                    <span class="badge badge-gold">Identity</span>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Date of Birth <span class="req">*</span></label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group" class="form-control">
                                <option value="">&mdash; Select &mdash;</option>
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Bangladeshi') }}">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Gender <span class="req">*</span></label>
                        <div class="flex items-center gap-4 flex-wrap pt-1 text-xs">
                            @foreach(['Male','Female','Other','Prefer not to say'] as $g)
                                <label class="flex items-center gap-x-2 cursor-pointer text-slate-700">
                                    <input type="radio" name="gender" value="{{ $g }}" {{ old('gender') === $g ? 'checked' : '' }} required class="text-emerald-600 focus:ring-teal-500">
                                    <span>{{ $g }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: University Details --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                    <span class="text-xs font-bold uppercase tracking-wider">Section 2 &mdash; University Affiliation</span>
                    <span class="badge badge-gold">Academic</span>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">University ID / Employee ID <span class="req">*</span></label>
                            <input type="text" name="university_id" class="form-control" placeholder="e.g. 0802000000000000" value="{{ old('university_id') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Category <span class="req">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="">&mdash; Select Category &mdash;</option>
                                <option value="student"  {{ old('role') === 'student'  ? 'selected' : '' }}>Student (Undergraduate)</option>
                                <option value="postgrad" {{ old('role') === 'postgrad' ? 'selected' : '' }}>Student (Postgraduate)</option>
                                <option value="faculty"  {{ old('role') === 'faculty'  ? 'selected' : '' }}>Faculty / Academic Staff</option>
                                <option value="staff"    {{ old('role') === 'staff'    ? 'selected' : '' }}>Administrative Staff</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Department / Faculty</label>
                            <input type="text" name="department" class="form-control" placeholder="e.g. CSE" value="{{ old('department') }}">
                        </div>
                        <div>
                            <label class="form-label">Semester &amp; Year (Students only)</label>
                            <input type="text" name="year" class="form-control" placeholder="e.g. Summer 26" value="{{ old('year') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: Contact & Emergency --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                    <span class="text-xs font-bold uppercase tracking-wider">Section 3 &mdash; Contact &amp; Emergency Details</span>
                    <span class="badge badge-gold">Contact</span>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">University Email <span class="req">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="yourname@university.edu.bd" value="{{ old('email') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Mobile Number <span class="req">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Emergency Contact Name</label>
                            <input type="text" name="emergency_name" class="form-control" placeholder="Parent / Guardian Name" value="{{ old('emergency_name') }}">
                        </div>
                        <div>
                            <label class="form-label">Emergency Contact Number</label>
                            <input type="tel" name="emergency_phone" class="form-control" placeholder="01XXXXXXXXX" value="{{ old('emergency_phone') }}">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Current Address (Hall / Dormitory or Campus Residence)</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Section 4: Medical History --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                    <span class="text-xs font-bold uppercase tracking-wider">Section 4 &mdash; Medical Profile &amp; Allergies</span>
                    <span class="badge badge-gold">Clinical</span>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div>
                        <label class="form-label">Known Allergies (drugs, food, other)</label>
                        <input type="text" name="allergies" class="form-control" placeholder="e.g. Penicillin, Sulfa, Dust — leave blank if none" value="{{ old('allergies') }}">
                    </div>

                    <div>
                        <label class="form-label">Pre-existing Health Conditions <small class="text-gray-400 font-normal lowercase">(select all that apply)</small></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-1">
                            @foreach(['Diabetes (Type 1 or 2)','Hypertension / High BP','Asthma / Respiratory','Heart Disease','Epilepsy / Seizures','Thyroid Disorder','Anaemia','Anxiety / Depression','Kidney Disease','None of the above'] as $cond)
                                <label class="flex items-center gap-x-2 text-xs text-slate-700 cursor-pointer">
                                    <input type="checkbox" name="conditions[]" value="{{ $cond }}"
                                        {{ in_array($cond, old('conditions', [])) ? 'checked' : '' }}
                                        class="rounded text-emerald-600 focus:ring-teal-500">
                                    <span>{{ $cond }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Current Medications (name, dose, frequency)</label>
                        <textarea name="medications" class="form-control" rows="2" placeholder="e.g. Paracetamol as needed, Inhaler daily — leave blank if none">{{ old('medications') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Section 5: Declaration & Submission --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-3.5 flex items-center justify-between border-b-2 border-[#0d9488]">
                    <span class="text-xs font-bold uppercase tracking-wider">Patient Declaration</span>
                    <span class="badge badge-green">Consent</span>
                </div>
                <div class="p-5 sm:p-6">
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        I declare that the information provided above is accurate and complete to the best of my knowledge.
                        I understand that providing false information may result in the suspension of Medical Centre services.
                        I consent to the collection and processing of my medical data for the purpose of healthcare delivery at University Medical Centre.
                    </p>

                    <label class="flex items-start gap-x-2.5 text-xs text-slate-800 font-medium cursor-pointer">
                        <input type="checkbox" name="declaration" required class="mt-0.5 rounded text-emerald-600 focus:ring-teal-500">
                        <span>I have read and agree to the patient consent declaration above. <span class="req">*</span></span>
                    </label>
                </div>
                <div class="bg-slate-50 border-t border-gray-200 px-5 py-3.5 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-[11px] text-gray-500">* All marked fields are mandatory.</span>
                    <div class="flex items-center gap-2">
                        <button type="reset" class="btn btn-outline btn-sm">Clear Form</button>
                        <button type="submit" class="btn btn-green btn-sm">Complete Patient Registration &rarr;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Sidebar Information (1 col) --}}
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Before You Register
            </h3>
            <ul class="space-y-2 text-xs text-gray-600 leading-relaxed list-disc list-inside">
                <li>You <strong>must</strong> be a current student or staff member of the University.</li>
                <li>Have your <strong>university ID card</strong> available.</li>
                <li>Registration is a <strong>one-time procedure</strong>.</li>
                <li>Your data is protected under institutional privacy policies.</li>
            </ul>
        </div>

        <div class="bg-white border border-gray-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Need Assistance?
            </h3>
            <div class="text-xs text-gray-600 space-y-2">
                <p>Medical Centre Reception Counter:</p>
                <div class="p-2.5 bg-slate-50 rounded-lg space-y-1 font-mono text-[11px]">
                    <div>Phone: <strong class="text-slate-800">01888-888888</strong></div>
                    <div>Email: <strong class="text-slate-800">medcentre@university.edu.bd</strong></div>
                    <div>Hours: <span class="text-slate-700">Mon&ndash;Fri 8:00am&ndash;8:00pm</span></div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-gray-200 pb-2 mb-3">
                Already Registered?
            </h3>
            <p class="text-xs text-gray-600 leading-relaxed mb-4">
                If you already have a patient record in the system, you do not need to re-register.
            </p>
            <a href="{{ route('login') }}" class="btn btn-outline w-full text-center">Sign In to Patient Portal &rarr;</a>
        </div>
    </div>
</div>

@endsection
