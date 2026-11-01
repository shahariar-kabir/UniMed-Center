<?php $__env->startSection('title', 'Doctor Consultation Desk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .doctor-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.4rem;
        align-items: start;
    }
    .active-consult-card {
        background: #f4fbf6;
        border: 2px solid var(--green);
        border-radius: var(--radius);
        padding: 1.2rem;
        margin-bottom: 1.4rem;
        box-shadow: var(--shadow);
    }
    @media (max-width: 860px) {
        .doctor-grid { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Doctor Consultation Desk &mdash; <?php echo e($doctor->name); ?></div>
<div class="page-subtitle"><?php echo e($doctor->designation ?? 'Medical Officer'); ?> &bull; Department: <strong><?php echo e($doctor->department ?? 'General Medicine'); ?></strong></div>


<?php if($activePatientQueue): ?>
    <div class="active-consult-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem;">
            <span class="badge badge-green" style="font-size:11px;">PATIENT IN CONSULTATION NOW</span>
            <span style="font-size:12px;color:var(--muted);">Called at: <?php echo e($activePatientQueue->called_at?->format('h:i A')); ?></span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
            <div>
                <div style="font-size:1.6rem;font-weight:700;color:var(--green-dk);">
                    Token <?php echo e($activePatientQueue->token_number); ?> &mdash; <?php echo e($activePatientQueue->patient->full_name); ?>

                </div>
                <div style="font-size:12px;color:var(--muted);margin-top:2px;">
                    University ID: <strong><?php echo e($activePatientQueue->patient->university_id); ?></strong> &bull;
                    Blood Group: <strong><?php echo e($activePatientQueue->patient->blood_group ?? 'N/A'); ?></strong> &bull;
                    Allergies: <strong style="color:#c0392b;"><?php echo e($activePatientQueue->patient->allergies ?: 'None'); ?></strong>
                </div>
            </div>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                <a href="<?php echo e(Route::has('doctor.patients.history') ? route('doctor.patients.history', $activePatientQueue->patient_id) : '#'); ?>" class="btn btn-outline btn-sm">View Medical History</a>
                <a href="<?php echo e(Route::has('doctor.prescriptions.create') ? route('doctor.prescriptions.create', ['queue_id' => $activePatientQueue->id, 'patient_id' => $activePatientQueue->patient_id]) : '#'); ?>" class="btn btn-green btn-sm">Generate Digital Prescription</a>
                <form action="<?php echo e(Route::has('doctor.queue.complete') ? route('doctor.queue.complete', $activePatientQueue->id) : '#'); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-gold btn-sm">Complete Consultation</button>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="stats-grid">
    <div class="stat-card gold">
        <div class="stat-val"><?php echo e($waitingCount); ?></div>
        <div class="stat-label">Patients Waiting</div>
        <div class="stat-sub">In queue outside</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val"><?php echo e($completedTodayCount); ?></div>
        <div class="stat-label">Consultations Done</div>
        <div class="stat-sub">Attended today</div>
    </div>
    <div class="stat-card">
        <div class="stat-val"><?php echo e($recentPrescriptions->count()); ?></div>
        <div class="stat-label">Prescriptions Issued</div>
        <div class="stat-sub">Recent clinical orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color:var(--green);font-size:1.4rem;">ONLINE</div>
        <div class="stat-label">Duty Status</div>
        <div class="stat-sub">Accepting consultation queue</div>
    </div>
</div>

<div class="doctor-grid">
    
    <div>
        <div class="card" style="margin-bottom:1.4rem;">
            <div class="card-header">
                <span>Today's Consultation Queue &mdash; <?php echo e($doctor->department); ?></span>
                <a href="<?php echo e(Route::has('doctor.queue') ? route('doctor.queue') : '#'); ?>" style="color:#fff;font-size:11px;text-decoration:underline;">Manage Queue &rarr;</a>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Patient Name</th>
                            <th>ID &amp; Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $todayQueues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="<?php echo e($q->status === 'in_consultation' ? 'background:#f0f9f3;' : ''); ?>">
                                <td><strong style="color:var(--green);font-size:13px;"><?php echo e($q->token_number); ?></strong></td>
                                <td>
                                    <strong><?php echo e($q->patient->full_name); ?></strong>
                                    <div style="font-size:11px;color:var(--muted);">Allergies: <?php echo e($q->patient->allergies ?: 'None'); ?></div>
                                </td>
                                <td>
                                    <?php echo e($q->patient->university_id); ?><br>
                                    <small style="color:var(--muted);"><?php echo e(ucfirst($q->patient->role_category)); ?></small>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($q->status === 'in_consultation' ? 'badge-green' : ($q->status === 'completed' ? 'badge-blue' : 'badge-yellow')); ?>">
                                        <?php echo e(str_replace('_', ' ', ucfirst($q->status))); ?>

                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:4px;">
                                        <?php if($q->status === 'waiting'): ?>
                                            <form action="<?php echo e(Route::has('doctor.queue.call') ? route('doctor.queue.call', $q->id) : '#'); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-green btn-sm">Call Patient</button>
                                            </form>
                                        <?php elseif($q->status === 'in_consultation'): ?>
                                            <a href="<?php echo e(Route::has('doctor.prescriptions.create') ? route('doctor.prescriptions.create', ['queue_id' => $q->id, 'patient_id' => $q->patient_id]) : '#'); ?>" class="btn btn-gold btn-sm">Write Rx</a>
                                        <?php else: ?>
                                            <span style="color:var(--muted);font-size:11px;">Completed</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:1.4rem;color:var(--muted);">No patients currently in your department queue.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <span>Recent Prescriptions Generated by You</span>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Ref</th>
                            <th>Patient</th>
                            <th>Diagnosis</th>
                            <th>Medicines</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentPrescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($rx->prescription_number); ?></strong></td>
                                <td><?php echo e($rx->patient->full_name); ?></td>
                                <td style="max-width:200px;"><?php echo e(Str::limit($rx->diagnosis, 35)); ?></td>
                                <td><?php echo e($rx->items->count()); ?> item(s)</td>
                                <td>
                                    <span class="badge <?php echo e($rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow'); ?>">
                                        <?php echo e(ucfirst($rx->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(Route::has('patient.prescriptions.show') ? route('patient.prescriptions.show', $rx->id) : '#'); ?>" class="btn btn-outline btn-sm">View Rx</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:1.2rem;color:var(--muted);">No prescriptions issued today.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div>
        <div class="card" style="margin-bottom:1.4rem;">
            <div class="card-header">Clinical Quick Actions</div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;">
                <a href="<?php echo e(Route::has('doctor.prescriptions.create') ? route('doctor.prescriptions.create') : '#'); ?>" class="btn btn-green" style="width:100%;">Generate Digital Prescription</a>
                <a href="<?php echo e(Route::has('doctor.queue') ? route('doctor.queue') : '#'); ?>" class="btn btn-outline" style="width:100%;">Open Full Queue Desk</a>
                <a href="<?php echo e(Route::has('pharmacy.inventory') ? route('pharmacy.inventory') : '#'); ?>" class="btn btn-outline" style="width:100%;">Check Medicine Inventory</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Consultation Protocol</div>
            <div class="card-body" style="font-size:12px;color:var(--muted);line-height:1.6;">
                <ul style="padding-left:1.1rem;">
                    <li>Always verify student/staff identity and known drug allergies before prescribing.</li>
                    <li>Digital prescriptions are routed directly to the Central Pharmacy inventory desk.</li>
                    <li>Use standard dosage format (e.g. <code>1+0+1</code>) for clarity.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_2_Doctor_Prescription_Engine\resources\views/doctor/dashboard.blade.php ENDPATH**/ ?>