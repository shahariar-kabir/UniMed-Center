<?php $__env->startSection('title', 'Consultation Queue Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Patient Consultation Queue Management</div>
<div class="page-subtitle">Department: <strong><?php echo e($doctor->department ?? 'General Medicine'); ?></strong> &bull; Attending: <strong><?php echo e($doctor->name); ?></strong></div>

<div class="card">
    <div class="card-header">
        <span>Active Queue &mdash; <?php echo e(date('d M Y')); ?></span>
        <span style="font-size:11px;font-weight:400;text-transform:none;">Total in line: <?php echo e($todayQueues->count()); ?></span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Token #</th>
                    <th>Patient Name</th>
                    <th>University ID &amp; Dept</th>
                    <th>Allergies &amp; Vitals</th>
                    <th>Wait Time</th>
                    <th>Queue Status</th>
                    <th>Clinical Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $todayQueues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="<?php echo e($q->status === 'in_consultation' ? 'background:#f0f9f3;border-left:4px solid var(--green);' : ''); ?>">
                        <td>
                            <strong style="color:var(--green);font-size:15px;"><?php echo e($q->token_number); ?></strong>
                        </td>
                        <td>
                            <strong><?php echo e($q->patient->full_name); ?></strong>
                            <div style="font-size:11px;color:var(--muted);"><?php echo e(ucfirst($q->patient->role_category)); ?> (<?php echo e($q->patient->gender); ?>)</div>
                        </td>
                        <td>
                            <div><?php echo e($q->patient->university_id); ?></div>
                            <div style="font-size:11px;color:var(--muted);"><?php echo e($q->patient->department ?? 'General'); ?></div>
                        </td>
                        <td>
                            <?php if($q->patient->allergies): ?>
                                <span class="badge badge-red" style="font-size:10px;"><?php echo e($q->patient->allergies); ?></span>
                            <?php else: ?>
                                <span style="font-size:11px;color:var(--muted);">No allergies reported</span>
                            <?php endif; ?>
                            <div style="font-size:11px;margin-top:2px;">Blood: <strong><?php echo e($q->patient->blood_group ?? 'N/A'); ?></strong></div>
                        </td>
                        <td style="font-size:12px;">
                            <?php echo e($q->created_at->diffForHumans(null, true)); ?> ago
                        </td>
                        <td>
                            <?php
                                $statusBadges = [
                                    'in_consultation' => 'badge-green',
                                    'waiting' => 'badge-yellow',
                                    'completed' => 'badge-blue',
                                    'skipped' => 'badge-red',
                                ];
                            ?>
                            <span class="badge <?php echo e($statusBadges[$q->status] ?? 'badge-gray'); ?>">
                                <?php echo e(str_replace('_', ' ', ucfirst($q->status))); ?>

                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                <a href="<?php echo e(Route::has('doctor.patients.history') ? route('doctor.patients.history', $q->patient_id) : '#'); ?>" class="btn btn-outline btn-sm" title="View past history">History</a>

                                <?php if($q->status === 'waiting'): ?>
                                    <form action="<?php echo e(Route::has('doctor.queue.call') ? route('doctor.queue.call', $q->id) : '#'); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-green btn-sm">Call Patient</button>
                                    </form>
                                    <form action="<?php echo e(Route::has('doctor.queue.skip') ? route('doctor.queue.skip', $q->id) : '#'); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline btn-sm" style="color:#c0392b;border-color:#e0a098;">Skip</button>
                                    </form>
                                <?php elseif($q->status === 'in_consultation'): ?>
                                    <a href="<?php echo e(Route::has('doctor.prescriptions.create') ? route('doctor.prescriptions.create', ['queue_id' => $q->id, 'patient_id' => $q->patient_id]) : '#'); ?>" class="btn btn-green btn-sm">Write Rx</a>
                                    <form action="<?php echo e(Route::has('doctor.queue.complete') ? route('doctor.queue.complete', $q->id) : '#'); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-gold btn-sm">Complete</button>
                                    </form>
                                <?php else: ?>
                                    <span style="font-size:11px;color:var(--muted);">Attended</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:1.6rem;color:var(--muted);">No patients currently in queue.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_2_Doctor_Prescription_Engine\resources\views/doctor/queue.blade.php ENDPATH**/ ?>