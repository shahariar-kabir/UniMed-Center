@extends('layouts.app')
@section('title', 'User Management & Role Authorization')

@section('content')
{{-- Admin Users Header Ribbon --}}
<div class="bg-gradient-to-r from-[#091e3a] via-[#0d2a4e] to-[#0f2b48] text-white rounded-lg p-6 mb-6 shadow-sm border-b-4 border-[#0f766e] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded bg-teal-500/20 text-[#5eead4] border border-teal-400/30 flex items-center justify-center font-black text-xl shrink-0 font-mono">
            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="badge badge-amber text-[11px]">Executive Access Control</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-semibold border border-emerald-400/30">
                    <span class="badge-dot bg-emerald-400"></span>
                    <span>Role-Based Permissions</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-white font-heading">User Management &amp; Role Authorization</h1>
            <p class="text-xs text-teal-100/80">Manage campus medical personnel, assign roles (Admin, Doctor, Pharmacist, Patient), and control privileges.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-white btn-sm flex items-center gap-1.5 text-white">
            <svg class="size-4 shrink-0 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            <span class="text-white">Analytics Dashboard</span>
        </a>
        <button type="button" onclick="document.getElementById('newUserFormCard').scrollIntoView({behavior:'smooth'})" class="btn btn-secondary btn-sm flex items-center gap-1.5 shadow-sm">
            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
            <span>+ Create Staff Account</span>
        </button>
    </div>
</div>

{{-- Top Filter & Search Bar --}}
<div class="bg-white border border-slate-200 rounded-lg p-4 mb-6 shadow-sm flex flex-wrap items-center justify-between gap-3">
    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
        <div class="relative w-64 input-icon-container">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </span>
            <input type="text" name="search" class="form-control !pl-10 text-xs rounded" placeholder="Search name, email, ID..." value="{{ request('search') }}">
        </div>

        <select name="role" class="form-control w-48 text-xs rounded">
            <option value="">&mdash; All Roles &mdash;</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrators</option>
            <option value="doctor" {{ request('role') === 'doctor' ? 'selected' : '' }}>Medical Officers (Doctors)</option>
            <option value="pharmacist" {{ request('role') === 'pharmacist' ? 'selected' : '' }}>Pharmacists</option>
            <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Registered Patients</option>
        </select>

        <button type="submit" class="btn btn-teal btn-sm flex items-center gap-1 font-bold">
            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span>Filter Users</span>
        </button>
            <span>Filter Users</span>
        </button>

        @if(request()->hasAny(['search', 'role']))
            <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Users Table --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0f766e] shadow-sm rounded-lg overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block font-heading">System Accounts Directory</span>
                <span class="text-[11px] text-teal-200/80">{{ $users->total() }} Registered User Profiles</span>
            </div>
        </div>
        <span class="badge badge-cyan text-[11px]">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User Identity</th>
                    <th>Email Address</th>
                    <th>Role &amp; Privilege</th>
                    <th>Department &amp; Title</th>
                    <th>Status</th>
                    <th class="text-right">Modify Authorization</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="size-8 rounded bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300 text-[#091e3a] flex items-center justify-center font-bold text-xs shrink-0 font-mono">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                                <div>
                                    <strong class="text-slate-900 block text-xs sm:text-sm font-semibold">{{ $u->name }}</strong>
                                    @if($u->university_id)
                                        <span class="font-mono text-[11px] text-slate-500 font-semibold">{{ $u->university_id }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-xs text-slate-700 font-medium">{{ $u->email }}</td>
                        <td>
                            @php
                                $roleBadges = [
                                    'admin' => 'badge-red',
                                    'doctor' => 'badge-blue',
                                    'pharmacist' => 'badge-gold',
                                    'patient' => 'badge-green',
                                ];
                            @endphp
                            <span class="badge {{ $roleBadges[$u->role] ?? 'badge-gray' }} inline-flex items-center gap-1 text-[11px]">
                                <span class="badge-dot {{ $u->role === 'doctor' ? 'bg-sky-500' : ($u->role === 'admin' ? 'bg-rose-500' : ($u->role === 'pharmacist' ? 'bg-amber-500' : 'bg-emerald-500')) }}"></span>
                                <span>{{ ucfirst($u->role) }}</span>
                            </span>
                        </td>
                        <td>
                            <div class="text-xs font-semibold text-slate-800">{{ $u->department ?? 'General' }}</div>
                            <div class="text-[11px] text-slate-500">{{ $u->designation ?? 'Member' }}</div>
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="badge badge-green inline-flex items-center gap-1 text-[11px]">
                                    <span class="badge-dot bg-emerald-500"></span>
                                    <span>Active</span>
                                </span>
                            @else
                                <span class="badge badge-red inline-flex items-center gap-1 text-[11px]">
                                    <span class="badge-dot bg-red-600"></span>
                                    <span>Deactivated</span>
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <form action="{{ route('admin.users.update', $u->id) }}" method="POST" class="inline-flex items-center gap-1.5 justify-end">
                                @csrf
                                @method('PUT')
                                <select name="role" class="py-1 px-2 text-xs border border-slate-300 rounded font-semibold text-slate-700 w-28">
                                    <option value="patient" {{ $u->role === 'patient' ? 'selected' : '' }}>Patient</option>
                                    <option value="doctor" {{ $u->role === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="pharmacist" {{ $u->role === 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <select name="is_active" class="py-1 px-2 text-xs border border-slate-300 rounded font-semibold text-slate-700 w-24">
                                    <option value="1" {{ $u->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$u->is_active ? 'selected' : '' }}>Disabled</option>
                                </select>
                                <button type="submit" class="btn btn-outline btn-xs text-[#0d9488] hover:bg-teal-50" title="Apply changes">
                                    Save
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 bg-slate-50/50">
                            <div class="inline-flex size-12 rounded-2xl bg-slate-100 text-slate-500 items-center justify-center mb-3">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <div class="text-sm font-bold text-slate-800">No User Profiles Found</div>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Try modifying your role or search filters.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
    <div class="mb-6">
        {{ $users->links() }}
    </div>
@endif

{{-- Create New Staff Account Form --}}
<div class="bg-white border border-slate-200 border-t-4 border-t-[#0284c7] shadow-sm rounded-lg overflow-hidden" id="newUserFormCard">
    <div class="bg-gradient-to-r from-[#091e3a] to-[#0f2b48] text-white px-5 py-4 flex items-center justify-between border-b-2 border-[#0f766e]">
        <div class="flex items-center gap-2.5">
            <div class="size-8 rounded bg-white/10 flex items-center justify-center text-[#5eead4] border border-white/15">
                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block font-heading">Provision New Staff Account</span>
                <span class="text-[11px] text-teal-200/80">Authorize Doctor, Pharmacist, or Administrative Personnel</span>
            </div>
        </div>
        <span class="badge badge-amber text-[10px]">Staff Enrollment</span>
    </div>

    <div class="p-6 sm:p-7">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label font-semibold text-slate-700">Full Staff Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Sabrina Rahman" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">University Email Address <span class="req">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="staff@bu.edu.bd" required>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Initial Password <span class="req">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="form-label font-semibold text-slate-700">Assigned System Role <span class="req">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="doctor">Medical Officer (Doctor)</option>
                        <option value="pharmacist">Pharmacist</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Clinical Department</label>
                    <input type="text" name="department" class="form-control" placeholder="e.g. General Medicine, Dental">
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">Professional Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="e.g. Senior Medical Officer">
                </div>
                <div>
                    <label class="form-label font-semibold text-slate-700">University Staff ID</label>
                    <input type="text" name="university_id" class="form-control" placeholder="e.g. BU-DOC-102">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="btn btn-green flex items-center gap-2 font-bold shadow-sm">
                    <span>Create &amp; Authorize Account</span>
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
