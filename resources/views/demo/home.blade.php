@extends('layouts.demo')
@section('title', 'System Overview & Portals')

@section('content')
<div class="page-title">University Medical Centre Management System</div>
<div class="page-subtitle">Centralized healthcare administration, clinical consultations, dispensary, and patient management portal.</div>

{{-- Campus Healthcare Banner --}}
<div class="card" style="border-left: 4px solid var(--green); background: #f7faf8; margin-bottom: 2rem;">
    <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <strong style="color:var(--green);font-size:14px;display:block;margin-bottom:2px;">Campus Healthcare Network</strong>
            <span style="color:var(--muted);font-size:13px;">Providing comprehensive medical services, specialist consultations, and pharmacy dispensary to university students, faculty, and staff.</span>
        </div>
        <span class="badge badge-green" style="font-size:12px;padding:6px 12px;">Active Medical Services</span>
    </div>
</div>

{{-- 4 Core Modules Card Grid --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(270px, 1fr));gap:1.4rem;margin-bottom:2.5rem;">
    {{-- Card 1: Patient Module --}}
    <div class="card" style="border-top:4px solid var(--green);">
        <div class="card-header" style="background:var(--green);">
            <span>1. Patient Module &amp; Queue</span>
            <span>👤</span>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;justify-content:space-between;height:calc(100% - 40px);">
            <p style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:1.2rem;">
                Verified student/staff profiles, online doctor appointments, walk-in tokens, and live queue tracking board.
            </p>
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                <a href="{{ route('demo.patient.dashboard') }}" class="btn btn-green btn-sm">Patient Dashboard &rarr;</a>
                <a href="{{ route('demo.patient.appointments') }}" class="btn btn-outline btn-sm">Appointment Booking</a>
                <a href="{{ route('demo.patient.queue') }}" class="btn btn-outline btn-sm">Live Queue Board</a>
                <a href="{{ route('demo.patient.register') }}" class="btn btn-outline btn-sm">Patient Registration</a>
            </div>
        </div>
    </div>

    {{-- Card 2: Doctor Desk --}}
    <div class="card" style="border-top:4px solid #2980b9;">
        <div class="card-header" style="background:#2980b9;">
            <span>2. Doctor Consultation Desk</span>
            <span>🩺</span>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;justify-content:space-between;height:calc(100% - 40px);">
            <p style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:1.2rem;">
                Real-time consultation queue, patient medical history inspection, vitals recording, and dynamic multi-item e-prescription builder.
            </p>
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                <a href="{{ route('demo.doctor.dashboard') }}" class="btn btn-green btn-sm" style="background:#2980b9;">Doctor Desk &rarr;</a>
                <a href="{{ route('demo.doctor.queue') }}" class="btn btn-outline btn-sm">Consultation Queue Desk</a>
                <a href="{{ route('demo.doctor.history') }}" class="btn btn-outline btn-sm">Patient History Viewer</a>
                <a href="{{ route('demo.doctor.prescription.create') }}" class="btn btn-outline btn-sm">Prescription Builder (Dynamic JS)</a>
            </div>
        </div>
    </div>

    {{-- Card 3: Pharmacy --}}
    <div class="card" style="border-top:4px solid var(--gold);">
        <div class="card-header" style="background:var(--gold);">
            <span>3. Pharmacy &amp; Inventory</span>
            <span>💊</span>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;justify-content:space-between;height:calc(100% - 40px);">
            <p style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:1.2rem;">
                Central medicine inventory catalog, low-stock and near-expiry automated indicators, stock adjustments, and dispensing desk.
            </p>
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                <a href="{{ route('demo.pharmacy.dashboard') }}" class="btn btn-gold btn-sm">Pharmacy Dashboard &rarr;</a>
                <a href="{{ route('demo.pharmacy.inventory') }}" class="btn btn-outline btn-sm">Medicine Stock Catalog</a>
                <a href="{{ route('demo.pharmacy.dispense') }}" class="btn btn-outline btn-sm">Prescription Dispense Counter</a>
            </div>
        </div>
    </div>

    {{-- Card 4: Admin --}}
    <div class="card" style="border-top:4px solid #8e44ad;">
        <div class="card-header" style="background:#8e44ad;">
            <span>4. Admin Analytics &amp; Users</span>
            <span>📊</span>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;justify-content:space-between;height:calc(100% - 40px);">
            <p style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:1.2rem;">
                Campus healthcare executive analytics, patient footfall by department, medicine distribution rates, and staff user management.
            </p>
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                <a href="{{ route('demo.admin.dashboard') }}" class="btn btn-green btn-sm" style="background:#8e44ad;">Admin Analytics &rarr;</a>
                <a href="{{ route('demo.admin.users') }}" class="btn btn-outline btn-sm">Staff &amp; Role Management</a>
            </div>
        </div>
    </div>
</div>

{{-- Quick Action Section --}}
<div class="card">
    <div class="card-header">University Health Center Services Quick Directory</div>
    <div class="card-body" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1rem;font-size:13px;">
        <div style="border-left:3px solid var(--green);padding-left:.8rem;">
            <strong style="color:var(--green);display:block;margin-bottom:3px;">General Medicine</strong>
            <span style="color:var(--muted);">Routine consultations, fever clinic, primary diagnosis &amp; first-aid.</span>
        </div>
        <div style="border-left:3px solid var(--gold);padding-left:.8rem;">
            <strong style="color:var(--gold);display:block;margin-bottom:3px;">Central Pharmacy</strong>
            <span style="color:var(--muted);">Essential medicines dispensing, dosage instructions, and catalog check.</span>
        </div>
        <div style="border-left:3px solid #2980b9;padding-left:.8rem;">
            <strong style="color:#2980b9;display:block;margin-bottom:3px;">Dental &amp; Specialty Care</strong>
            <span style="color:var(--muted);">Oral health consultations, minor procedures, and scheduled visits.</span>
        </div>
        <div style="border-left:3px solid #c0392b;padding-left:.8rem;">
            <strong style="color:#c0392b;display:block;margin-bottom:3px;">24/7 Ambulance &amp; Emergency</strong>
            <span style="color:var(--muted);">Emergency response: Call <strong>0188888888</strong>. Medical team on duty.</span>
        </div>
    </div>
</div>
@endsection
