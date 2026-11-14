@extends('layouts.app')
@section('title', 'Doctor Registration')

@section('content')
<div class="max-w-2xl mx-auto mb-6">
    <h1 class="page-title">Doctor Consultation Desk &mdash; Registration</h1>
    <p class="page-subtitle">Register your authorized medical credentials to attend waiting patients, issue digital prescriptions, and access clinical histories.</p>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-gray-200 border-t-4 border-t-[#0d9488] shadow-sm rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0d9488]">
            <span class="text-xs font-bold uppercase tracking-wider">Doctor Account Provisioning</span>
            <span class="badge badge-blue">Clinical Desk</span>
        </div>

        <div class="p-6 sm:p-8">
            @if($errors->any())
                <div class="bg-red-50 border-s-4 border-red-500 p-4 mb-5 rounded-md text-xs text-red-800" role="alert">
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

            <form method="POST" action="{{ route('doctor.register.post') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Full Name &amp; Title <span class="req">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Full Name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div>
                        <label class="form-label">University Staff / Doctor ID <span class="req">*</span></label>
                        <input type="text" name="university_id" class="form-control" placeholder="DOC-MED-001" value="{{ old('university_id') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Official University Email <span class="req">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="doctor@university.edu.bd" value="{{ old('email') }}" required>
                    </div>

                    <div>
                        <label class="form-label">Contact Phone Number <span class="req">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="01711000000" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Clinical Department <span class="req">*</span></label>
                        <select name="department" class="form-control" required>
                            <option value="">-- Select Department --</option>
                            <option value="General Medicine" {{ old('department') == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                            <option value="Dental" {{ old('department') == 'Dental' ? 'selected' : '' }}>Dental Clinic</option>
                            <option value="Counselling" {{ old('department') == 'Counselling' ? 'selected' : '' }}>Counselling &amp; Mental Health</option>
                            <option value="Gynaecology" {{ old('department') == 'Gynaecology' ? 'selected' : '' }}>Gynaecology</option>
                            <option value="Diagnostics" {{ old('department') == 'Diagnostics' ? 'selected' : '' }}>Laboratory &amp; Diagnostics</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Designation <span class="req">*</span></label>
                        <select name="designation" class="form-control" required>
                            <option value="">-- Select Designation --</option>
                            <option value="Medical Officer" {{ old('designation') == 'Medical Officer' ? 'selected' : '' }}>Medical Officer</option>
                            <option value="Senior Medical Officer" {{ old('designation') == 'Senior Medical Officer' ? 'selected' : '' }}>Senior Medical Officer</option>
                            <option value="Consultant Physician" {{ old('designation') == 'Consultant Physician' ? 'selected' : '' }}>Consultant Physician</option>
                            <option value="Resident Dental Surgeon" {{ old('designation') == 'Resident Dental Surgeon' ? 'selected' : '' }}>Resident Dental Surgeon</option>
                            <option value="Clinical Psychologist" {{ old('designation') == 'Clinical Psychologist' ? 'selected' : '' }}>Clinical Psychologist</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="form-label">Account Password <span class="req">*</span></label>
                        <div class="relative">
                            <input type="password" id="docPassword" name="password" class="form-control pr-10" placeholder="Minimum 6 characters" required>
                            <button type="button" onclick="togglePasswordVisibility('docPassword', this)" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-slate-700 cursor-pointer focus:outline-hidden" title="Show or hide password" aria-label="Toggle password visibility">
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
                        <label class="form-label">Confirm Password <span class="req">*</span></label>
                        <div class="relative">
                            <input type="password" id="docPasswordConfirm" name="password_confirmation" class="form-control pr-10" placeholder="Re-enter password" required>
                            <button type="button" onclick="togglePasswordVisibility('docPasswordConfirm', this)" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-slate-700 cursor-pointer focus:outline-hidden" title="Show or hide password" aria-label="Toggle password visibility">
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
                </div>

                <div class="p-3.5 rounded-lg bg-slate-50 border border-slate-200 text-xs text-slate-600">
                    <strong class="text-slate-800 font-bold">Clinical Duty Notice:</strong> Registering as a Medical Officer grants authority to attend active patient queues, write and sign digital prescriptions, and review student clinical histories.
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-green w-full py-2.5">
                        Register Doctor Account &rarr;
                    </button>
                </div>

                <div class="text-center pt-2 text-xs text-gray-500">
                    Already registered? <a href="{{ route('login') }}" class="text-[#0d9488] font-bold hover:underline">Sign in to Medical Portal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
