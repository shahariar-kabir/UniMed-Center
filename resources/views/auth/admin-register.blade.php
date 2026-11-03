@extends('layouts.app')
@section('title', 'Admin Registration')

@section('content')
<div class="max-w-2xl mx-auto mb-6">
    <h1 class="page-title">Administrator Registration</h1>
    <p class="page-subtitle">Register an authorized administrative account to manage medical personnel, doctor queues, medicine inventory, and operational reports.</p>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-6 py-4 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Administrator Account Creation</span>
            <span class="badge badge-gold">Executive Portal</span>
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

            <form method="POST" action="{{ route('admin.register.post') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Dr. Administrator Name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div>
                        <label class="form-label">University Employee / Staff ID <span class="req">*</span></label>
                        <input type="text" name="university_id" class="form-control" placeholder="EMP-ADM-001" value="{{ old('university_id') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Official University Email <span class="req">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="admin@university.edu.bd" value="{{ old('email') }}" required>
                    </div>

                    <div>
                        <label class="form-label">Contact Phone Number <span class="req">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="01711000000" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Official Designation <span class="req">*</span></label>
                        <select name="designation" class="form-control" required>
                            <option value="">-- Select Administrative Designation --</option>
                            <option value="Chief Medical Officer" {{ old('designation') == 'Chief Medical Officer' ? 'selected' : '' }}>Chief Medical Officer</option>
                            <option value="Health Services Director" {{ old('designation') == 'Health Services Director' ? 'selected' : '' }}>Health Services Director</option>
                            <option value="Senior Medical Registrar" {{ old('designation') == 'Senior Medical Registrar' ? 'selected' : '' }}>Senior Medical Registrar</option>
                            <option value="System Administrator" {{ old('designation') == 'System Administrator' ? 'selected' : '' }}>System Administrator</option>
                            <option value="Clinical Operations Manager" {{ old('designation') == 'Clinical Operations Manager' ? 'selected' : '' }}>Clinical Operations Manager</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Department / Unit</label>
                        <input type="text" name="department" class="form-control" placeholder="Medical Administration" value="{{ old('department', 'Medical Administration') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="form-label">Account Password <span class="req">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                    </div>

                    <div>
                        <label class="form-label">Confirm Password <span class="req">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                    </div>
                </div>

                <div class="p-3.5 rounded-lg bg-slate-50 border border-slate-200 text-xs text-slate-600">
                    <strong class="text-slate-800 font-bold">Administrative Access Notice:</strong> Creating an administrator account grants full role authority to manage users, add doctors, update pharmacy stock, and access university clinical reports.
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-green w-full py-2.5">
                        Register Administrator Account &rarr;
                    </button>
                </div>

                <div class="text-center pt-2 text-xs text-gray-500">
                    Already have an account? <a href="{{ route('login') }}" class="text-[#1a6b3a] font-bold hover:underline">Sign in to Medical Portal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
