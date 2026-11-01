@extends('layouts.demo')
@section('title', 'Patient Dashboard')

@push('styles')
<style>
    .patient-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.4rem;
        align-items: start;
    }
    .queue-status-card {
        background: #fff;
        border: 2px solid var(--gold);
        border-radius: var(--radius);
        padding: 1.2rem;
        margin-bottom: 1.4rem;
        box-shadow: var(--shadow-sm);
    }
    .token-display {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .token-num {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--green);
        line-height: 1;
    }
    .token-sub { font-size: 12px; color: var(--muted); margin-top: 4px; }
    @media (max-width: 860px) { .patient-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="page-title">Patient Portal &mdash; {{ $patient['name'] }}</div>
<div class="page-subtitle">University ID: <strong>{{ $patient['university_id'] }}</strong> &nbsp;|&nbsp; Category: <strong>{{ $patient['role_category'] }}</strong> &nbsp;|&nbsp; Department: <strong>{{ $patient['department'] }}</strong></div>

{{-- Live Queue Banner --}}
<div class="queue-status-card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
        <span class="badge badge-gold" style="font-size:11px;">TODAY'S LIVE QUEUE TICKET</span>
        <span class="badge badge-yellow">WAITING FOR DOCTOR</span>
    </div>
    <div class="token-display">
        <div>
            <div class="token-num">T-101</div>
            <div class="token-sub">Department: <strong>General Medicine</strong> &nbsp;|&nbsp; Counter 1 (Dr. Anisur Rahman)</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:14px;font-weight:700;color:var(--text);">2 patient(s) ahead of you</div>
            <div style="font-size:12px;color:var(--muted);">Estimated wait: approx. 15 minutes</div>
        </div>
        <div>
            <a href="{{ route('demo.patient.queue') }}" class="btn btn-green btn-sm">Open Live Queue Board &rarr;</a>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">{{ $patient['blood_group'] }}</div>
        <div class="stat-label">Blood Group</div>
        <div class="stat-sub">Medical Profile</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">2</div>
        <div class="stat-label">Upcoming Visits</div>
        <div class="stat-sub">Confirmed appointments</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">3</div>
        <div class="stat-label">Digital Prescriptions</div>
        <div class="stat-sub">On campus medical file</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color:var(--green);font-size:1.4rem;">VERIFIED</div>
        <div class="stat-label">Identity Status</div>
        <div class="stat-sub">Authorized University Member</div>
    </div>
</div>

<div class="patient-grid">
    <div>
        {{-- Recent Prescriptions Table --}}
        <div class="card">
            <div class="card-header">
                <span>Recent E-Prescriptions &amp; Printable PDF</span>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Number</th>
                            <th>Doctor</th>
                            <th>Diagnosis</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>RX-2026-0041</strong></td>
                            <td>Dr. Anisur Rahman</td>
                            <td>Acute Pharyngitis &amp; Fever</td>
                            <td><span class="badge badge-yellow">At Pharmacy</span></td>
                            <td>
                                <div style="display:flex;gap:4px;">
                                    <a href="{{ route('demo.doctor.prescription.preview') }}" class="btn btn-outline btn-sm">View Rx</a>
                                    <button onclick="showToast('Simulating PDF download for RX-2026-0041...')" class="btn btn-green btn-sm">PDF &darr;</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>RX-2026-0035</strong></td>
                            <td>Dr. Anisur Rahman</td>
                            <td>Mild Bronchial Spasm / Wheezing</td>
                            <td><span class="badge badge-green">Dispensed</span></td>
                            <td>
                                <div style="display:flex;gap:4px;">
                                    <a href="{{ route('demo.doctor.prescription.preview') }}" class="btn btn-outline btn-sm">View Rx</a>
                                    <button onclick="showToast('Simulating PDF download for RX-2026-0035...')" class="btn btn-green btn-sm">PDF &darr;</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Upcoming Appointments Table --}}
        <div class="card">
            <div class="card-header">
                <span>My Appointments Schedule</span>
                <a href="{{ route('demo.patient.appointments') }}" style="color:#fff;font-size:11px;text-decoration:underline;">Book New Visit &rarr;</a>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ref #</th>
                            <th>Department</th>
                            <th>Doctor</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>APT-2026-0001</strong></td>
                            <td>General Medicine</td>
                            <td>Dr. Anisur Rahman</td>
                            <td>Today at 10:30 AM</td>
                            <td><span class="badge badge-green">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td><strong>APT-2026-0002</strong></td>
                            <td>Dental Clinic</td>
                            <td>Dr. Abdur Karim</td>
                            <td>Tomorrow at 11:00 AM</td>
                            <td><span class="badge badge-green">Confirmed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div>
        <div class="card">
            <div class="card-header">Patient Summary &amp; Allergies</div>
            <div class="card-body" style="font-size:13px;line-height:1.7;">
                <div><strong>University ID:</strong> {{ $patient['university_id'] }}</div>
                <div><strong>Email:</strong> {{ $patient['email'] }}</div>
                <div><strong>Mobile:</strong> {{ $patient['phone'] }}</div>
                <div><strong>Blood Group:</strong> <span class="badge badge-red">{{ $patient['blood_group'] }}</span></div>
                
                <div style="margin-top:.7rem;border-top:1px solid #eef4f0;padding-top:.7rem;">
                    <strong>Known Drug Allergies:</strong><br>
                    <span style="color:#c0392b;font-weight:700;">{{ $patient['allergies'] }}</span>
                </div>
                
                <div style="margin-top:.7rem;border-top:1px solid #eef4f0;padding-top:.7rem;">
                    <strong>Emergency Contact:</strong><br>
                    {{ $patient['emergency_name'] }} &ndash; {{ $patient['emergency_phone'] }}
                </div>
                
                <div style="margin-top:1rem;">
                    <a href="{{ route('demo.patient.profile') }}" class="btn btn-outline btn-sm" style="width:100%;">Edit Profile &amp; Contact Info</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Quick Action Buttons</div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;">
                <a href="{{ route('demo.patient.queue') }}" class="btn btn-green" style="width:100%;">View Live Queue Tracking</a>
                <a href="{{ route('demo.patient.appointments') }}" class="btn btn-outline" style="width:100%;">Book Doctor Appointment</a>
                <a href="{{ route('demo.doctor.prescription.preview') }}" class="btn btn-outline" style="width:100%;">View Sample Rx (PDF)</a>
            </div>
        </div>
    </div>
</div>
@endsection
