<?php $__env->startSection('title', 'Doctor Desk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .doctor-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.4rem;
        align-items: start;
    }
    .attending-card {
        background: #fff;
        border: 2px solid var(--green);
        border-radius: var(--radius);
        padding: 1.2rem;
        margin-bottom: 1.4rem;
        box-shadow: var(--shadow-sm);
    }
    @media (max-width: 860px) { .doctor-grid { grid-template-columns: 1fr; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Doctor Consultation Desk &mdash; Dr. Anisur Rahman</div>
<div class="page-subtitle">Designation: <strong>Senior Medical Officer (MBBS, FCPS)</strong> &bull; Department: <strong>General Medicine</strong> &bull; Counter 1</div>


<div class="attending-card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
        <span class="badge badge-green">PATIENT CURRENTLY IN CONSULTATION</span>
        <span class="badge badge-gold">TOKEN # T-100</span>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <div style="font-size:1.4rem;font-weight:700;color:var(--text);">Nadia Akter (2023-BBA-044)</div>
            <div style="font-size:12px;color:var(--muted);margin-top:2px;">Age: 21 &bull; Blood: O+ &bull; Symptoms: Acute migraine headache with nausea &bull; Called 6 mins ago</div>
        </div>
        <div style="display:flex;gap:6px;">
            <a href="<?php echo e(route('demo.doctor.history')); ?>" class="btn btn-outline btn-sm">Inspect Medical History</a>
            <a href="<?php echo e(route('demo.doctor.prescription.create')); ?>" class="btn btn-green btn-sm">+ Generate E-Prescription</a>
        </div>
    </div>
</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">3</div>
        <div class="stat-label">Patients Waiting Today</div>
        <div class="stat-sub">In queue lobby</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">8</div>
        <div class="stat-label">Consultations Completed</div>
        <div class="stat-sub">Today's shift</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">7</div>
        <div class="stat-label">Prescriptions Issued</div>
        <div class="stat-sub">Routed to Pharmacy</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color:var(--green);font-size:1.4rem;">ACTIVE</div>
        <div class="stat-label">Clinic Shift Status</div>
        <div class="stat-sub">Counter 1 Live</div>
    </div>
</div>

<div class="doctor-grid">
    <div>
        
        <div class="card">
            <div class="card-header">
                <span>Next Patients in Consultation Queue</span>
                <a href="<?php echo e(route('demo.doctor.queue')); ?>" style="color:#fff;font-size:11px;text-decoration:underline;">Open Full Queue Desk &rarr;</a>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Patient Identity</th>
                            <th>Appointment Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong style="color:var(--gold);font-size:1.1rem;">T-101</strong></td>
                            <td><strong>Rahman Al-Hasan</strong> (2022-CSE-011)</td>
                            <td>Seasonal Dry Cough &amp; Fever</td>
                            <td><span class="badge badge-yellow">Next in Line</span></td>
                            <td>
                                <a href="<?php echo e(route('demo.doctor.prescription.create')); ?>" class="btn btn-green btn-sm">Call Patient</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>T-102</strong></td>
                            <td>Tanvir Ahmed (2021-EEE-089)</td>
                            <td>Follow-up Vitals Check</td>
                            <td><span class="badge badge-blue">Waiting</span></td>
                            <td>
                                <a href="<?php echo e(route('demo.doctor.history')); ?>" class="btn btn-outline btn-sm">History</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>T-103</strong></td>
                            <td>Farzana Khan (Staff &ndash; Library)</td>
                            <td>Allergic Rhinitis Consultation</td>
                            <td><span class="badge badge-blue">Waiting</span></td>
                            <td>
                                <a href="<?php echo e(route('demo.doctor.history')); ?>" class="btn btn-outline btn-sm">History</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <span>Recent Prescriptions Generated Today</span>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Ref</th>
                            <th>Patient</th>
                            <th>Diagnosis</th>
                            <th>Medicines</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>RX-2026-0041</strong></td>
                            <td>Rahman Al-Hasan</td>
                            <td>Upper Respiratory Tract Infection</td>
                            <td>3 items (Paracetamol, Cetirizine, Omeprazole)</td>
                            <td>
                                <a href="<?php echo e(route('demo.doctor.prescription.preview')); ?>" class="btn btn-outline btn-sm">View Rx PDF</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div>
        <div class="card">
            <div class="card-header">Clinical Quick Actions</div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;">
                <a href="<?php echo e(route('demo.doctor.prescription.create')); ?>" class="btn btn-green" style="width:100%;">+ Write Digital Prescription</a>
                <a href="<?php echo e(route('demo.doctor.queue')); ?>" class="btn btn-outline" style="width:100%;">Open Full Consultation Queue</a>
                <a href="<?php echo e(route('demo.doctor.history')); ?>" class="btn btn-outline" style="width:100%;">Search Patient History</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Doctor Consultation Notice</div>
            <div class="card-body" style="font-size:12px;color:var(--muted);line-height:1.6;">
                <ul style="padding-left:1.1rem;">
                    <li>Always cross-check student drug allergies prior to submitting antibiotics.</li>
                    <li>Digital prescriptions route in real-time to Central Pharmacy.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/doctor-dashboard.blade.php ENDPATH**/ ?>