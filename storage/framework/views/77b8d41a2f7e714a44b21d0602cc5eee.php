<?php $__env->startSection('title', 'Patient Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Medical Profile &amp; Emergency Contacts</div>
<div class="page-subtitle">Personal identity details, emergency notifications, blood group, and verified medical records.</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.4rem;align-items:start;">
    <div class="card">
        <div class="card-header">
            <span>Identity &amp; Emergency Profile Form</span>
        </div>
        <div class="card-body">
            <form onsubmit="event.preventDefault(); showToast('Profile update simulation: Medical records updated successfully!');">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="<?php echo e($patient['name']); ?>" readonly style="background:#f9f9f9;">
                    </div>
                    <div>
                        <label class="form-label">University ID</label>
                        <input type="text" class="form-control" value="<?php echo e($patient['university_id']); ?>" readonly style="background:#f9f9f9;">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label class="form-label">Blood Group</label>
                        <select class="form-control">
                            <option selected>B+</option>
                            <option>A+</option>
                            <option>O+</option>
                            <option>AB+</option>
                            <option>B-</option>
                            <option>O-</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" value="<?php echo e($patient['phone']); ?>">
                    </div>
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="<?php echo e($patient['email']); ?>">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label class="form-label">Emergency Contact Name</label>
                        <input type="text" class="form-control" value="<?php echo e($patient['emergency_name']); ?>">
                    </div>
                    <div>
                        <label class="form-label">Emergency Contact Phone</label>
                        <input type="text" class="form-control" value="<?php echo e($patient['emergency_phone']); ?>">
                    </div>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label">Known Drug Allergies &amp; Reactions</label>
                    <textarea class="form-control"><?php echo e($patient['allergies']); ?></textarea>
                    <small style="color:#c0392b;font-size:11px;">Crucial for preventing adverse drug reactions in prescription writer.</small>
                </div>

                <div style="margin-bottom:1.4rem;">
                    <label class="form-label">Campus Hall / Residential Address</label>
                    <input type="text" class="form-control" value="<?php echo e($patient['address']); ?>">
                </div>

                <button type="submit" class="btn btn-green" style="padding:.6rem 1.4rem;">
                    Save Profile Changes
                </button>
            </form>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-header">Verification Status</div>
            <div class="card-body" style="font-size:13px;line-height:1.7;">
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:.5rem;">
                    <span class="badge badge-green">VERIFIED IDENTITY</span>
                </div>
                <p style="color:var(--muted);font-size:12px;">
                    Linked to Registrar Student Database &bull; Active Campus Member
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/patient-profile.blade.php ENDPATH**/ ?>