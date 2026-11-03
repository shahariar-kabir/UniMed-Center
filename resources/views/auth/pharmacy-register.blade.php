@extends('layouts.app')
@section('title', 'Pharmacist Registration')

@section('content')
<div class="max-w-2xl mx-auto mb-6">
    <h1 class="page-title">Pharmacy &amp; Dispensary &mdash; Registration</h1>
    <p class="page-subtitle">Register authorized pharmacy personnel to manage central medicine inventory, track batch expiry, and fulfill digital prescriptions.</p>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden">
        <div class="bg-[#134d2a] text-white px-6 py-4 flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider">Pharmacist Account Provisioning</span>
            <span class="badge badge-gold">Dispensary Desk</span>
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

            <form method="POST" action="{{ route('pharmacy.register.post') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Md. Tariqul Islam" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div>
                        <label class="form-label">University Staff / Pharmacist ID <span class="req">*</span></label>
                        <input type="text" name="university_id" class="form-control" placeholder="PHARM-001" value="{{ old('university_id') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Official University Email <span class="req">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="pharmacist@university.edu.bd" value="{{ old('email') }}" required>
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
                            <option value="">-- Select Designation --</option>
                            <option value="Head Pharmacist" {{ old('designation') == 'Head Pharmacist' ? 'selected' : '' }}>Head Pharmacist</option>
                            <option value="Clinical Pharmacist" {{ old('designation') == 'Clinical Pharmacist' ? 'selected' : '' }}>Clinical Pharmacist</option>
                            <option value="Dispensary Officer" {{ old('designation') == 'Dispensary Officer' ? 'selected' : '' }}>Dispensary Officer</option>
                            <option value="Assistant Pharmacist" {{ old('designation') == 'Assistant Pharmacist' ? 'selected' : '' }}>Assistant Pharmacist</option>
                            <option value="Inventory Controller" {{ old('designation') == 'Inventory Controller' ? 'selected' : '' }}>Inventory Controller</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Assigned Department</label>
                        <input type="text" class="form-control bg-slate-50 text-gray-500" value="Central Pharmacy &amp; Dispensary" disabled>
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
                    <strong class="text-slate-800 font-bold">Pharmacy Authority:</strong> Registering grants authority to dispense medications, update physical stock inventory, and monitor expiring batches.
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-green w-full py-2.5">
                        Register Pharmacist Account &rarr;
                    </button>
                </div>

                <div class="text-center pt-2 text-xs text-gray-500">
                    Already registered? <a href="{{ route('login') }}" class="text-[#1a6b3a] font-bold hover:underline">Sign in to Medical Portal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
