@extends('layouts.app')
@section('title', 'My Prescriptions')

@section('content')
<div class="page-title">Digital Prescriptions</div>
<div class="page-subtitle">Prescription records and electronic medication history</div>

<div class="card" style="margin-top:1.5rem;">
    <div class="card-header">E-Prescription Module</div>
    <div class="card-body" style="padding:2.5rem 1.5rem;text-align:center;">
        <div style="font-size:3rem;margin-bottom:1rem;">📋</div>
        <h3 style="color:var(--green);margin-bottom:.6rem;">Digital Prescription Records</h3>
        <p style="color:var(--muted);max-width:540px;margin:0 auto 1.5rem auto;line-height:1.6;">
            The digital prescription creator, doctor consultation desk, and PDF export are encapsulated in 
            the Physician & Clinical Consultation Module. Run that feature app to test full prescription workflows.
        </p>
        <div style="display:flex;justify-content:center;gap:.8rem;">
            <a href="{{ Route::has('patient.dashboard') ? route('patient.dashboard') : '#' }}" class="btn btn-green">&larr; Back to Patient Dashboard</a>
            <a href="{{ Route::has('patient.queue') ? route('patient.queue') : '#' }}" class="btn btn-outline">Check Live Queue &rarr;</a>
        </div>
    </div>
</div>
@endsection