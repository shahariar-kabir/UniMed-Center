@extends('layouts.app')
@section('title', 'Select Portal')

@section('content')
<div class="max-w-xl mx-auto py-6">
    <div class="mb-6 text-center">
        <div class="inline-flex items-center gap-x-2 py-1 px-3 rounded-full bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 mb-2">
            <span class="size-2 rounded-full bg-[#c8922a]"></span> Unified University Account
        </div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Select Medical Portal</h1>
        <p class="text-xs text-gray-600 mt-1">Your email is associated with multiple roles in the medical system. Choose the portal you want to enter for this session:</p>
    </div>

    <div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden p-6 sm:p-8 space-y-4">
        @php
            $roleMeta = [
                'admin' => ['title' => 'System Administrator', 'desc' => 'Executive Analytics, Staff Provisioning & User Controls', 'badge' => 'badge-red'],
                'doctor' => ['title' => 'Doctor Consultation Desk', 'desc' => 'Live Patient Queue, Diagnostic History & Digital Rx', 'badge' => 'badge-blue'],
                'pharmacist' => ['title' => 'Pharmacy & Dispensary', 'desc' => 'Central Medicine Inventory, Stock Reorder & Prescriptions', 'badge' => 'badge-gold'],
                'patient' => ['title' => 'Patient Portal', 'desc' => 'Consultation Bookings, Digital Prescriptions & Health Profile', 'badge' => 'badge-green'],
            ];
        @endphp

        <form method="POST" action="{{ route('login.choose-portal.post') }}" class="space-y-3">
            @csrf

            @foreach($users as $u)
                @php $meta = $roleMeta[$u->role] ?? ['title' => ucfirst($u->role), 'desc' => 'Authorized Access', 'badge' => 'badge-gray']; @endphp
                <label class="block p-4 rounded-xl border border-gray-200 hover:border-emerald-600 hover:bg-emerald-50/30 transition-all cursor-pointer relative group">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <input type="radio" name="user_id" value="{{ $u->id }}" {{ $loop->first ? 'checked' : '' }} class="mt-1 size-4 text-[#1a6b3a] border-gray-300 focus:ring-emerald-500">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-slate-900 group-hover:text-[#1a6b3a] transition-colors">{{ $meta['title'] }}</span>
                                    <span class="badge {{ $meta['badge'] }} text-[10px]">{{ ucfirst($u->role) }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $meta['desc'] }}</div>
                                <div class="text-[11px] text-gray-400 mt-1 font-mono">
                                    ID: {{ $u->university_id ?? 'N/A' }} &bull; {{ $u->name }} ({{ $u->designation ?? ucfirst($u->role) }})
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            @endforeach

            <div class="pt-3">
                <button type="submit" class="btn btn-green w-full py-2.5">
                    Continue to Selected Portal &rarr;
                </button>
            </div>
        </form>

        <div class="pt-3 text-center border-t border-gray-100 text-xs">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-slate-800">
                &larr; Cancel and sign in with a different email
            </a>
        </div>
    </div>
</div>
@endsection
