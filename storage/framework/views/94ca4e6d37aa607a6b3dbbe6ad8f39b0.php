<?php $__env->startSection('title', 'Portal Login'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .login-container {
        max-width: 880px;
        margin: 1rem auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    .demo-box {
        background: #fbfdfc;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
    }
    .demo-role-item {
        background: #fff;
        border: 1px solid #dce8e0;
        border-radius: 4px;
        padding: .75rem;
        margin-bottom: .65rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
    }
    .demo-role-item:last-child { margin-bottom: 0; }
    .demo-role-info strong { display: block; font-size: 13px; color: var(--green); }
    .demo-role-info small { color: var(--muted); font-size: 11px; }

    @media (max-width: 768px) {
        .login-container { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">University Medical Centre Portal Login</div>
<div class="page-subtitle">Access your patient health records, doctor consultation desk, pharmacy dispensary, or administrative management panel.</div>

<div class="login-container">
    
    <div class="card">
        <div class="card-header">Account Login</div>
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(Route::has('login.post') ? route('login.post') : '#'); ?>">
                <?php echo csrf_field(); ?>

                <div style="margin-bottom: 1rem;">
                    <label class="form-label">University Email Address <span class="req">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="name@bu.edu.bd" value="<?php echo e(old('email')); ?>" required autofocus>
                </div>

                <div style="margin-bottom: 1.2rem;">
                    <label class="form-label">Password <span class="req">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    <small style="color:var(--muted);font-size:11px;">Default password for all seeded accounts is: <code>password</code></small>
                </div>

                <div style="margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: space-between;">
                    <label style="display:flex;align-items:center;gap:.4rem;font-size:12px;cursor:pointer;">
                        <input type="checkbox" name="remember" style="accent-color:var(--green);"> Remember session
                    </label>
                    <a href="<?php echo e(Route::has('patients.register') ? route('patients.register') : '#'); ?>" style="color:var(--green);font-size:12px;font-weight:700;text-decoration:none;">New patient? Register here</a>
                </div>

                <button type="submit" class="btn btn-green" style="width: 100%; padding: .6rem;">Sign In to Medical Portal</button>
            </form>
        </div>
    </div>

    
    <div class="demo-box">
        <h3 style="font-size:13px;text-transform:uppercase;color:var(--green-dk);margin-bottom:.4rem;letter-spacing:.04em;">1-Click Instant Demo Login</h3>
        <p style="font-size:12px;color:var(--muted);margin-bottom:1rem;">Select any pre-configured role below to log in directly and review that module's functionality:</p>

        <div class="demo-role-item">
            <div class="demo-role-info">
                <strong>Patient Portal</strong>
                <small>Rahman Al-Hasan (Student ID: 2022-CSE-011)</small>
            </div>
            <a href="<?php echo e(Route::has('login.demo') ? route('login.demo', 'patient') : '#'); ?>" class="btn btn-green btn-sm">Enter as Patient</a>
        </div>

        <div class="demo-role-item">
            <div class="demo-role-info">
                <strong>Doctor Consultation Desk</strong>
                <small>Dr. Anisur Rahman (Senior Medical Officer)</small>
            </div>
            <a href="<?php echo e(Route::has('login.demo') ? route('login.demo', 'doctor') : '#'); ?>" class="btn btn-green btn-sm">Enter as Doctor</a>
        </div>

        <div class="demo-role-item">
            <div class="demo-role-info">
                <strong>Pharmacy &amp; Inventory</strong>
                <small>Md. Rafiqul Islam (Head Pharmacist)</small>
            </div>
            <a href="<?php echo e(Route::has('login.demo') ? route('login.demo', 'pharmacist') : '#'); ?>" class="btn btn-gold btn-sm">Enter as Pharmacist</a>
        </div>

        <div class="demo-role-item">
            <div class="demo-role-info">
                <strong>System Administrator</strong>
                <small>Operational Analytics &amp; Role Management</small>
            </div>
            <a href="<?php echo e(Route::has('login.demo') ? route('login.demo', 'admin') : '#'); ?>" class="btn btn-outline btn-sm">Enter as Admin</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_1_Auth_Patient_Queue\resources\views/auth/login.blade.php ENDPATH**/ ?>