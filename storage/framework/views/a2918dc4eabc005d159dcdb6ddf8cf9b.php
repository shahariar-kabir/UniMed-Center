<?php $__env->startSection('title', 'Patient Profile & Verification'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .profile-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    .id-badge-card {
        background: #fff;
        border: 2px solid var(--green);
        border-radius: var(--radius);
        padding: 1.4rem;
        text-align: center;
        box-shadow: var(--shadow);
    }
    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #d4edda;
        color: #155724;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: .05em;
        text-transform: uppercase;
        margin-top: .6rem;
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
        margin-bottom: .8rem;
    }
    @media (max-width: 820px) {
        .profile-layout { grid-template-columns: 1fr; }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Patient Profile &amp; Identity Verification</div>
<div class="page-subtitle">Manage your verified university health profile, pre-existing medical conditions, emergency contacts, and allergies.</div>

<div class="profile-layout">
    
    <div>
        <div class="id-badge-card">
            <div style="font-size:11px;font-weight:700;color:var(--green);letter-spacing:.08em;text-transform:uppercase;">University Identity Card</div>
            <h3 style="font-size:16px;color:var(--green-dk);margin-top:.4rem;"><?php echo e($patient->full_name); ?></h3>
            <div style="font-size:12px;color:var(--muted);margin-top:2px;"><?php echo e($patient->university_id); ?></div>

            <div class="verified-badge">
                Verified Student Identity
            </div>

            <div style="text-align:left;font-size:12px;margin-top:1.4rem;line-height:1.7;border-top:1px solid #ecf2ee;padding-top:1rem;">
                <div><strong>Category:</strong> <?php echo e(ucfirst($patient->role_category)); ?></div>
                <div><strong>Department:</strong> <?php echo e($patient->department ?? 'General'); ?></div>
                <div><strong>Semester / Year:</strong> <?php echo e($patient->year_semester ?? 'N/A'); ?></div>
                <div><strong>Blood Group:</strong> <span class="badge badge-red"><?php echo e($patient->blood_group ?? 'Not Set'); ?></span></div>
                <div><strong>Nationality:</strong> <?php echo e($patient->nationality); ?></div>
                <div><strong>Member Since:</strong> <?php echo e($patient->created_at->format('M Y')); ?></div>
            </div>
        </div>

        <div class="card" style="margin-top:1.2rem;">
            <div class="card-header">Medical Alert Summary</div>
            <div class="card-body" style="font-size:12px;line-height:1.6;">
                <strong style="color:#c0392b;">Allergies:</strong>
                <p><?php echo e($patient->allergies ?: 'No drug or food allergies on record.'); ?></p>
                <div style="margin-top:.6rem;">
                    <strong>Pre-existing Conditions:</strong>
                    <?php if(!empty($patient->conditions) && is_array($patient->conditions)): ?>
                        <ul style="padding-left:1.1rem;margin-top:3px;">
                            <?php $__currentLoopData = $patient->conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cond): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($cond); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p style="color:var(--muted);margin-top:2px;">None reported.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">Update Contact &amp; Emergency Information</div>
        <div class="card-body">
            <form action="<?php echo e(Route::has('patient.profile.update') ? route('patient.profile.update') : '#'); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="form-grid-2">
                    <div>
                        <label class="form-label">Phone Number <span class="req">*</span></label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $patient->phone)); ?>" required>
                    </div>
                    <div>
                        <label class="form-label">Email (Official University Email)</label>
                        <input type="email" class="form-control" value="<?php echo e($patient->email); ?>" disabled style="background:#f4f8f5;">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div>
                        <label class="form-label">Emergency Contact Person</label>
                        <input type="text" name="emergency_name" class="form-control" placeholder="e.g. Guardian / Parent Name" value="<?php echo e(old('emergency_name', $patient->emergency_name)); ?>">
                    </div>
                    <div>
                        <label class="form-label">Emergency Phone Number</label>
                        <input type="text" name="emergency_phone" class="form-control" placeholder="e.g. 01XXXXXXXXX" value="<?php echo e(old('emergency_phone', $patient->emergency_phone)); ?>">
                    </div>
                </div>

                <div style="margin-bottom:.8rem;">
                    <label class="form-label">Current Hall / Residence Address</label>
                    <textarea name="address" class="form-control" rows="2"><?php echo e(old('address', $patient->address)); ?></textarea>
                </div>

                <div style="margin-bottom:.8rem;">
                    <label class="form-label">Drug / Food Allergies</label>
                    <input type="text" name="allergies" class="form-control" placeholder="e.g. Penicillin, Sulfa drugs, Shellfish" value="<?php echo e(old('allergies', $patient->allergies)); ?>">
                    <small style="color:var(--muted);font-size:11px;">Crucial for doctor digital prescription warnings.</small>
                </div>

                <div style="margin-bottom:1.2rem;">
                    <label class="form-label">Current Long-term Medications</label>
                    <textarea name="medications" class="form-control" rows="2" placeholder="e.g. Salbutamol Inhaler, Metformin 500mg"><?php echo e(old('medications', $patient->medications)); ?></textarea>
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn btn-green">Save Profile Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_1_Auth_Patient_Queue\resources\views/patient/profile.blade.php ENDPATH**/ ?>