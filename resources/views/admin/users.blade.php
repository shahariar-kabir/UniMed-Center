@extends('layouts.app')
@section('title', 'User Management & Role Authorization')

@section('content')
<div class="mb-6">
    <h1 class="page-title">User Management &amp; Role Authorization</h1>
    <p class="page-subtitle">Configure medical personnel, assign roles (Admin, Doctor, Pharmacist, Patient), and manage access permissions.</p>
</div>

{{-- Top Filter & Add User Button --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap items-center gap-2">
        <input type="text" name="search" class="form-control w-56 text-xs" placeholder="Search name, email, ID..." value="{{ request('search') }}">
        <select name="role" class="form-control w-44 text-xs">
            <option value="">&mdash; All Roles &mdash;</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            <option value="doctor" {{ request('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
            <option value="pharmacist" {{ request('role') === 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
            <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Patient</option>
        </select>
        <button type="submit" class="btn btn-green btn-sm">Filter Users</button>
        @if(request()->hasAny(['search', 'role']))
            <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm">Clear</a>
        @endif
    </form>

    <button type="button" onclick="document.getElementById('newUserFormCard').scrollIntoView({behavior:'smooth'})" class="btn btn-gold btn-sm">
        + Create New Staff Account
    </button>
</div>

{{-- Users Table --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#1a6b3a] shadow-sm rounded-xl overflow-hidden mb-6">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">System Users Directory ({{ $users->total() }})</span>
        <span class="text-xs text-emerald-200 font-normal">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email Address</th>
                    <th>Role &amp; Authorization</th>
                    <th>Department &amp; Designation</th>
                    <th>Status</th>
                    <th>Modify Authorization</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>
                            <strong class="text-slate-900">{{ $u->name }}</strong>
                            @if($u->university_id)
                                <div class="text-[11px] text-gray-500">ID: {{ $u->university_id }}</div>
                            @endif
                        </td>
                        <td class="text-xs text-slate-700">{{ $u->email }}</td>
                        <td>
                            @php
                                $roleBadges = [
                                    'admin' => 'badge-red',
                                    'doctor' => 'badge-blue',
                                    'pharmacist' => 'badge-gold',
                                    'patient' => 'badge-green',
                                ];
                            @endphp
                            <span class="badge {{ $roleBadges[$u->role] ?? 'badge-gray' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td>
                            <div class="text-xs font-medium text-slate-800">{{ $u->department ?? 'General' }}</div>
                            <div class="text-[11px] text-gray-500">{{ $u->designation ?? 'Member' }}</div>
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-red">Deactivated</span>
                            @endif
                        </td>
                        <td>
                            {{-- Quick Role / Status Update Form --}}
                            <form action="{{ route('admin.users.update', $u->id) }}" method="POST" class="flex items-center gap-1.5">
                                @csrf
                                @method('PUT')
                                <select name="role" class="py-1 px-2 text-xs border border-gray-300 rounded w-24">
                                    <option value="patient" {{ $u->role === 'patient' ? 'selected' : '' }}>Patient</option>
                                    <option value="doctor" {{ $u->role === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="pharmacist" {{ $u->role === 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <select name="is_active" class="py-1 px-2 text-xs border border-gray-300 rounded w-20">
                                    <option value="1" {{ $u->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$u->is_active ? 'selected' : '' }}>Disable</option>
                                </select>
                                <button type="submit" class="btn btn-outline btn-xs">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 text-xs">No users found matching query.</td>
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

{{-- Create New User Card --}}
<div class="bg-white border border-gray-200 border-t-4 border-t-[#c8922a] shadow-sm rounded-xl overflow-hidden" id="newUserFormCard">
    <div class="bg-[#134d2a] text-white px-5 py-3.5 flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider">Create New Medical Staff or Administrative Account</span>
        <span class="badge badge-gold">Staff Provisioning</span>
    </div>
    <div class="p-5 sm:p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Full Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Mahfuzur Rahman" required>
                </div>
                <div>
                    <label class="form-label">Email Address <span class="req">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="name@university.edu.bd" required>
                </div>
                <div>
                    <label class="form-label">Assigned Role &amp; Access <span class="req">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="doctor">Doctor (Consultation Desk)</option>
                        <option value="pharmacist">Pharmacist (Inventory &amp; Dispensary)</option>
                        <option value="admin">System Administrator</option>
                        <option value="patient">Patient (Student / Staff)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Password <span class="req">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Initial password" required minlength="6">
                </div>
                <div>
                    <label class="form-label">University / Employee ID</label>
                    <input type="text" name="university_id" class="form-control" placeholder="e.g. DOC-019">
                </div>
                <div>
                    <label class="form-label">Department / Clinic</label>
                    <input type="text" name="department" class="form-control" placeholder="e.g. General Medicine, Dental">
                </div>
                <div>
                    <label class="form-label">Official Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="e.g. Medical Officer">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="btn btn-green">Create &amp; Authorize Account &rarr;</button>
            </div>
        </form>
    </div>
</div>
@endsection
