<?php $__env->startSection('title', 'Patient Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
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
        box-shadow: var(--shadow);
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

    @media (max-width: 860px) {
        .patient-grid { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Patient Portal &mdash; <?php echo e($patient->full_name); ?></div>
<div class="page-subtitle">University ID: <strong><?php echo e($patient->university_id); ?></strong> &nbsp;|&nbsp; Category: <strong><?php echo e(ucfirst($patient->role_category)); ?></strong> &nbsp;|&nbsp; Department: <strong><?php echo e($patient->department ?? 'General'); ?></strong></div>


<?php if($activeQueue): ?>
    <div class="queue-status-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
            <span class="badge badge-gold" style="font-size:11px;">TODAY'S LIVE QUEUE TICKET</span>
            <span class="badge <?php echo e($activeQueue->status === 'in_consultation' ? 'badge-green' : 'badge-yellow'); ?>">
                <?php echo e($activeQueue->status === 'in_consultation' ? 'NOW IN CONSULTATION' : 'WAITING FOR DOCTOR'); ?>

            </span>
        </div>
        <div class="token-display">
            <div>
                <div class="token-num"><?php echo e($activeQueue->token_number); ?></div>
                <div class="token-sub">Department: <strong><?php echo e($activeQueue->department); ?></strong> &nbsp;|&nbsp; Clinic Counter 1</div>
            </div>
            <div style="text-align:right;">
                <?php if($activeQueue->status === 'in_consultation'): ?>
                    <div style="font-size:14px;font-weight:700;color:var(--green);">Please proceed to Doctor's Consultation Room</div>
                    <div style="font-size:12px;color:var(--muted);">Doctor is attending you now.</div>
                <?php else: ?>
                    <div style="font-size:14px;font-weight:700;color:var(--text);"><?php echo e($patientsAhead); ?> patient(s) ahead of you</div>
                    <div style="font-size:12px;color:var(--muted);">Estimated wait: approx. <?php echo e(max(5, $patientsAhead * 8)); ?> minutes</div>
                <?php endif; ?>
            </div>
            <div>
                <a href="<?php echo e(Route::has('patient.queue') ? route('patient.queue') : '#'); ?>" class="btn btn-green btn-sm">Open Live Queue Board &rarr;</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val"><?php echo e($patient->blood_group ?? 'Not Set'); ?></div>
        <div class="stat-label">Blood Group</div>
        <div class="stat-sub">Medical Profile</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val"><?php echo e($upcomingAppointments->count()); ?></div>
        <div class="stat-label">Upcoming Visits</div>
        <div class="stat-sub">Confirmed appointments</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val"><?php echo e($prescriptions->count()); ?></div>
        <div class="stat-label">Total Prescriptions</div>
        <div class="stat-sub">Digital Rx on file</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color:var(--green);font-size:1.4rem;">VERIFIED</div>
        <div class="stat-label">Identity Status</div>
        <div class="stat-sub">Authorized University Member</div>
    </div>
</div>

<div class="patient-grid">
    
    <div>
        
        <div class="card" style="margin-bottom:1.4rem;">
            <div class="card-header">
                <span>Digital Prescriptions &amp; Printable PDF</span>
                <a href="<?php echo e(Route::has('patient.prescriptions') ? route('patient.prescriptions') : '#'); ?>" style="color:#fff;font-size:11px;text-decoration:underline;">View All &rarr;</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($rx->prescription_number); ?></strong><br><small style="color:var(--muted);"><?php echo e($rx->created_at->format('d M Y')); ?></small></td>
                                <td><?php echo e($rx->doctor->name); ?></td>
                                <td style="max-width:240px;"><?php echo e(Str::limit($rx->diagnosis, 45)); ?></td>
                                <td>
                                    <span class="badge <?php echo e($rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow'); ?>">
                                        <?php echo e(ucfirst($rx->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:4px;">
                                        <a href="<?php echo e(Route::has('patient.prescriptions.show') ? route('patient.prescriptions.show', $rx->id) : '#'); ?>" class="btn btn-outline btn-sm">View</a>
                                        <a href="<?php echo e(Route::has('patient.prescriptions.pdf') ? route('patient.prescriptions.pdf', $rx->id) : '#'); ?>" class="btn btn-green btn-sm" title="Download printable PDF">PDF &darr;</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:1.2rem;color:var(--muted);">No digital prescriptions recorded yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <span>My Appointments</span>
                <a href="<?php echo e(Route::has('patient.appointments') ? route('patient.appointments') : '#'); ?>" style="color:#fff;font-size:11px;text-decoration:underline;">Book New Visit &rarr;</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($apt->appointment_number); ?></strong></td>
                                <td><?php echo e($apt->department); ?></td>
                                <td><?php echo e($apt->doctor?->name ?? 'Assigned on arrival'); ?></td>
                                <td><?php echo e($apt->appointment_date->format('d M Y')); ?> at <?php echo e($apt->time_slot); ?></td>
                                <td><span class="badge badge-green"><?php echo e(ucfirst($apt->status)); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:1.2rem;color:var(--muted);">No upcoming appointments scheduled.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div>
        <div class="card" style="margin-bottom:1.4rem;">
            <div class="card-header">Identity &amp; Profile Summary</div>
            <div class="card-body" style="font-size:13px;line-height:1.7;">
                <div><strong>University ID:</strong> <?php echo e($patient->university_id); ?></div>
                <div><strong>Email:</strong> <?php echo e($patient->email); ?></div>
                <div><strong>Mobile:</strong> <?php echo e($patient->phone); ?></div>
                <div><strong>Blood Group:</strong> <span class="badge badge-red"><?php echo e($patient->blood_group ?? 'Not set'); ?></span></div>
                <div style="margin-top:.5rem;border-top:1px solid #ecf2ee;padding-top:.5rem;">
                    <strong>Known Allergies:</strong><br>
                    <span style="color:#c0392b;font-weight:700;"><?php echo e($patient->allergies ?: 'No known drug allergies reported'); ?></span>
                </div>
                <div style="margin-top:.5rem;border-top:1px solid #ecf2ee;padding-top:.5rem;">
                    <strong>Emergency Contact:</strong><br>
                    <?php echo e($patient->emergency_name ?? 'Not set'); ?> &ndash; <?php echo e($patient->emergency_phone ?? 'N/A'); ?>

                </div>
                <div style="margin-top:1rem;">
                    <a href="<?php echo e(Route::has('patient.profile') ? route('patient.profile') : '#'); ?>" class="btn btn-outline btn-sm" style="width:100%;">Edit Profile &amp; Contact Info</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;">
                <?php if(!$activeQueue): ?>
                    <form action="<?php echo e(Route::has('patient.queue.join') ? route('patient.queue.join') : '#'); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="department" value="General Medicine">
                        <button type="submit" class="btn btn-green" style="width:100%;">Get Today's Walk-in Queue Token</button>
                    </form>
                <?php endif; ?>
                <a href="<?php echo e(Route::has('patient.queue') ? route('patient.queue') : '#'); ?>" class="btn btn-outline" style="width:100%;">View Live Queue Tracking</a>
                <a href="<?php echo e(Route::has('patient.appointments') ? route('patient.appointments') : '#'); ?>" class="btn btn-outline" style="width:100%;">Book Doctor Appointment</a>
                <a href="<?php echo e(Route::has('patient.prescriptions') ? route('patient.prescriptions') : '#'); ?>" class="btn btn-outline" style="width:100%;">Download Prescriptions (PDF)</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_1_Auth_Patient_Queue\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>