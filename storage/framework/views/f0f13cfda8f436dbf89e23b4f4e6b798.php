<?php $__env->startSection('title', 'Appointments'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .appt-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    .slot-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 5px;
        margin-top: 5px;
    }
    .slot-btn {
        border: 1px solid #b0c4b8;
        border-radius: 3px;
        padding: .4rem .2rem;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        background: #fff;
        color: var(--text);
        font-family: Arial, Helvetica, sans-serif;
        transition: all .12s;
    }
    .slot-btn:hover { background: var(--green-pale); border-color: var(--green); color: var(--green); }
    .slot-btn.selected { background: var(--green); border-color: var(--green); color: #fff; }

    @media (max-width: 860px) {
        .appt-layout { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Appointment Booking &amp; Schedule</div>
<div class="page-subtitle">Schedule advance consultations with university medical officers and specialists. Appointments booked for today automatically generate a queue token.</div>

<div class="appt-layout">
    
    <div class="card">
        <div class="card-header">Book New Appointment</div>
        <div class="card-body">
            <form action="<?php echo e(Route::has('patient.appointments.store') ? route('patient.appointments.store') : '#'); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div style="margin-bottom:.8rem;">
                    <label class="form-label">Clinic / Department <span class="req">*</span></label>
                    <select name="department" class="form-control" required>
                        <option value="General Medicine">General Medicine</option>
                        <option value="Dental">Dental Clinic</option>
                        <option value="Counselling">Counselling &amp; Mental Health</option>
                        <option value="Gynaecology">Gynaecology</option>
                        <option value="Diagnostics">Laboratory &amp; Diagnostics</option>
                    </select>
                </div>

                <div style="margin-bottom:.8rem;">
                    <label class="form-label">Preferred Doctor (Optional)</label>
                    <select name="doctor_id" class="form-control">
                        <option value="">&mdash; Any Available Medical Officer &mdash;</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($doc->id); ?>"><?php echo e($doc->name); ?> (<?php echo e($doc->department); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div style="margin-bottom:.8rem;">
                    <label class="form-label">Date <span class="req">*</span></label>
                    <input type="date" name="appointment_date" class="form-control" min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>

                <div style="margin-bottom:.8rem;">
                    <label class="form-label">Preferred Time Slot <span class="req">*</span></label>
                    <input type="hidden" name="time_slot" id="timeSlotInput" value="09:00" required>
                    <div class="slot-grid">
                        <?php $__currentLoopData = ['08:30','09:00','09:30','10:00','10:30','11:00','11:30','14:00','14:30','15:00','15:30','16:00']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="slot-btn <?php echo e($slot === '09:00' ? 'selected' : ''); ?>" onclick="selectSlot(this, '<?php echo e($slot); ?>')">
                                <?php echo e($slot); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div style="margin-bottom:1.1rem;">
                    <label class="form-label">Reason for Consultation</label>
                    <textarea name="reason" class="form-control" rows="2" placeholder="Briefly describe your symptoms or reason for visit..."></textarea>
                </div>

                <button type="submit" class="btn btn-green" style="width:100%;">Confirm &amp; Book Appointment</button>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <span>My Appointment History</span>
            <span style="font-size:11px;font-weight:400;text-transform:none;">Total booked: <?php echo e($appointments->count()); ?></span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Department</th>
                        <th>Doctor</th>
                        <th>Date &amp; Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($apt->appointment_number); ?></strong></td>
                            <td><?php echo e($apt->department); ?></td>
                            <td><?php echo e($apt->doctor?->name ?? 'First Available'); ?></td>
                            <td>
                                <div><?php echo e($apt->appointment_date->format('d M Y')); ?></div>
                                <div style="font-size:11px;color:var(--muted);font-weight:700;"><?php echo e($apt->time_slot); ?></div>
                            </td>
                            <td style="max-width:200px;font-size:12px;"><?php echo e(Str::limit($apt->reason ?: 'General review', 45)); ?></td>
                            <td>
                                <span class="badge <?php echo e($apt->status === 'completed' ? 'badge-blue' : ($apt->status === 'cancelled' ? 'badge-red' : 'badge-green')); ?>">
                                    <?php echo e(ucfirst($apt->status)); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:1.4rem;color:var(--muted);">No appointments booked yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function selectSlot(el, slot) {
        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('timeSlotInput').value = slot;
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_1_Auth_Patient_Queue\resources\views/patient/appointments.blade.php ENDPATH**/ ?>