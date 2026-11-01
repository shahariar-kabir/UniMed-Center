<?php $__env->startSection('title', 'Doctor Consultation Queue'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Doctor Consultation Queue Desk</div>
<div class="page-subtitle">Manage patient intake, call waiting tickets, and review live queue status.</div>

<div class="card">
    <div class="card-header">
        <span>Today's Consultation Desk (Counter 1 &ndash; General Medicine)</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Token</th>
                    <th>Patient Name &amp; ID</th>
                    <th>Department</th>
                    <th>Reason / Appointment</th>
                    <th>Status</th>
                    <th>Consultation Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background:#f4fbf6;">
                    <td><strong style="color:var(--green);font-size:1.15rem;">T-100</strong></td>
                    <td>
                        <strong>Nadia Akter</strong><br>
                        <small style="color:var(--muted);">2023-BBA-044 &bull; Student</small>
                    </td>
                    <td>General Medicine</td>
                    <td>Severe acute migraine headache</td>
                    <td><span class="badge badge-green">In Consultation</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?php echo e(route('demo.doctor.prescription.create')); ?>" class="btn btn-green btn-sm">+ Prescribe</a>
                            <button onclick="showToast('Consultation marked completed for Token T-100')" class="btn btn-outline btn-sm">Complete</button>
                        </div>
                    </td>
                </tr>
                <tr style="background:#fffcf2;">
                    <td><strong style="color:var(--gold);font-size:1.15rem;">T-101</strong></td>
                    <td>
                        <strong>Rahman Al-Hasan</strong><br>
                        <small style="color:var(--muted);">2022-CSE-011 &bull; Student</small>
                    </td>
                    <td>General Medicine</td>
                    <td>Dry cough, fever for 2 days</td>
                    <td><span class="badge badge-yellow">Next in Line</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?php echo e(route('demo.doctor.prescription.create')); ?>" class="btn btn-green btn-sm">Call Patient &rarr;</a>
                            <a href="<?php echo e(route('demo.doctor.history')); ?>" class="btn btn-outline btn-sm">History</a>
                            <button onclick="showToast('Token T-101 marked as skipped')" class="btn btn-outline btn-sm" style="color:#c0392b;border-color:#c0392b;">Skip</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong style="font-size:1.15rem;">T-102</strong></td>
                    <td>
                        <strong>Tanvir Ahmed</strong><br>
                        <small style="color:var(--muted);">2021-EEE-089 &bull; Student</small>
                    </td>
                    <td>General Medicine</td>
                    <td>Follow-up blood pressure check</td>
                    <td><span class="badge badge-blue">Waiting</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?php echo e(route('demo.doctor.history')); ?>" class="btn btn-outline btn-sm">History</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/doctor-queue.blade.php ENDPATH**/ ?>