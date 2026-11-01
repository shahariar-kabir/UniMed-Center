<?php $__env->startSection('title', 'Patient Medical History - ' . $patient->full_name); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;flex-wrap:wrap;gap:.5rem;">
    <div>
        <div class="page-title">Medical Record &amp; History &mdash; <?php echo e($patient->full_name); ?></div>
        <div class="page-subtitle" style="margin-bottom:0;border-bottom:none;padding-bottom:0;">
            University ID: <strong><?php echo e($patient->university_id); ?></strong> &bull;
            Department: <strong><?php echo e($patient->department ?? 'General'); ?></strong> &bull;
            Blood Group: <strong style="color:#c0392b;"><?php echo e($patient->blood_group ?? 'Not Set'); ?></strong>
        </div>
    </div>
    <div>
        <a href="<?php echo e(Route::has('doctor.prescriptions.create') ? route('doctor.prescriptions.create', ['patient_id' => $patient->id]) : '#'); ?>" class="btn btn-green btn-sm">Generate New Prescription</a>
        <a href="javascript:history.back()" class="btn btn-outline btn-sm">&larr; Back to Queue</a>
    </div>
</div>

<hr style="border:none;border-bottom:1px solid var(--border);margin:1rem 0 1.4rem 0;">


<div style="background:#fff;border:1px solid var(--border);border-left:4px solid #c0392b;border-radius:var(--radius);padding:1rem 1.2rem;margin-bottom:1.4rem;">
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1rem;font-size:12px;">
        <div>
            <strong style="color:#c0392b;text-transform:uppercase;font-size:11px;">Known Allergies</strong>
            <p style="margin-top:2px;font-weight:700;"><?php echo e($patient->allergies ?: 'No known drug or food allergies'); ?></p>
        </div>
        <div>
            <strong style="color:var(--text);text-transform:uppercase;font-size:11px;">Pre-existing Medical Conditions</strong>
            <p style="margin-top:2px;">
                <?php if(!empty($patient->conditions) && is_array($patient->conditions)): ?>
                    <?php echo e(implode(', ', $patient->conditions)); ?>

                <?php else: ?>
                    None reported
                <?php endif; ?>
            </p>
        </div>
        <div>
            <strong style="color:var(--text);text-transform:uppercase;font-size:11px;">Current Routine Medications</strong>
            <p style="margin-top:2px;"><?php echo e($patient->medications ?: 'None reported'); ?></p>
        </div>
        <div>
            <strong style="color:var(--text);text-transform:uppercase;font-size:11px;">Emergency Contact</strong>
            <p style="margin-top:2px;"><?php echo e($patient->emergency_name ?? 'N/A'); ?> (<?php echo e($patient->emergency_phone ?? 'N/A'); ?>)</p>
        </div>
    </div>
</div>


<div class="card" style="margin-bottom:1.4rem;">
    <div class="card-header">
        <span>Prescription History (<?php echo e($patient->prescriptions->count()); ?>)</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rx Reference</th>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Diagnosis &amp; Vitals</th>
                    <th>Prescribed Medicines</th>
                    <th>Clinical Advice</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $patient->prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <strong style="color:var(--green);"><?php echo e($rx->prescription_number); ?></strong><br>
                            <span class="badge <?php echo e($rx->status === 'dispensed' ? 'badge-green' : 'badge-yellow'); ?>" style="font-size:9px;">
                                <?php echo e(ucfirst($rx->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($rx->created_at->format('d M Y')); ?></td>
                        <td><?php echo e($rx->doctor->name); ?></td>
                        <td>
                            <strong><?php echo e($rx->diagnosis); ?></strong>
                            <div style="font-size:11px;color:var(--muted);margin-top:2px;">
                                BP: <?php echo e($rx->bp ?: 'N/A'); ?> | Temp: <?php echo e($rx->temperature ?: 'N/A'); ?> | Wt: <?php echo e($rx->weight ?: 'N/A'); ?>

                            </div>
                        </td>
                        <td>
                            <ul style="padding-left:1rem;margin:0;font-size:12px;">
                                <?php $__currentLoopData = $rx->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><strong><?php echo e($item->medicine_name); ?></strong> &mdash; <?php echo e($item->dosage); ?> (<?php echo e($item->duration); ?>)</li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td style="max-width:200px;font-size:12px;color:var(--muted);">
                            <?php echo e(Str::limit($rx->clinical_advice, 60)); ?>

                        </td>
                        <td>
                            <a href="<?php echo e(Route::has('patient.prescriptions.show') ? route('patient.prescriptions.show', $rx->id) : '#'); ?>" class="btn btn-outline btn-sm">Full Rx</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:1.4rem;color:var(--muted);">No past prescriptions recorded for this patient.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <span>Consultation &amp; Appointment History</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Date</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Reason for Consultation</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $patient->appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($apt->appointment_number); ?></strong></td>
                        <td><?php echo e($apt->appointment_date->format('d M Y')); ?> at <?php echo e($apt->time_slot); ?></td>
                        <td><?php echo e($apt->department); ?></td>
                        <td><?php echo e($apt->doctor?->name ?? 'Attending Officer'); ?></td>
                        <td><?php echo e($apt->reason ?: 'General health evaluation'); ?></td>
                        <td><span class="badge badge-green"><?php echo e(ucfirst($apt->status)); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:1.2rem;color:var(--muted);">No previous appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_2_Doctor_Prescription_Engine\resources\views/doctor/patient-history.blade.php ENDPATH**/ ?>