<?php $__env->startSection('title', 'Live Queue Tracking'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .queue-board-top {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 1.4rem;
        margin-bottom: 1.5rem;
    }
    .current-token-display {
        background: linear-gradient(135deg, var(--green-dk) 0%, var(--green) 100%);
        color: #fff;
        border-radius: var(--radius);
        padding: 1.5rem;
        text-align: center;
        border-bottom: 4px solid var(--gold);
        box-shadow: var(--shadow);
    }
    .current-token-display .large-token {
        font-size: 3.5rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        margin: .6rem 0;
        letter-spacing: .02em;
    }
    .my-token-box {
        background: #fff;
        border: 2px solid var(--border);
        border-radius: var(--radius);
        padding: 1.2rem;
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .my-token-box.active {
        border-color: var(--gold);
        background: #fffcf5;
    }
    @media (max-width: 820px) {
        .queue-board-top { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Live Consultation Queue Tracking</div>
<div class="page-subtitle">Real-time status of university medical centre consultation rooms and patient queuing.</div>

<div class="queue-board-top">
    
    <div class="current-token-display">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;opacity:.85;font-weight:700;">CURRENTLY CALLING TOKEN</div>
        <div class="large-token">
            <?php echo e($nowCalling ? $nowCalling->token_number : 'NONE'); ?>

        </div>
        <div style="font-size:13px;font-weight:700;">
            <?php if($nowCalling): ?>
                Room 1 &mdash; <?php echo e($nowCalling->department); ?>

                <div style="font-size:11px;opacity:.8;font-weight:400;margin-top:2px;">Patient: <?php echo e($nowCalling->patient->full_name); ?></div>
            <?php else: ?>
                Doctor's Desk Ready for Next Patient
            <?php endif; ?>
        </div>
    </div>

    
    <div class="my-token-box <?php echo e($myToken ? 'active' : ''); ?>">
        <?php if($myToken): ?>
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span class="badge badge-gold">MY ACTIVE TOKEN</span>
                    <span class="badge <?php echo e($myToken->status === 'in_consultation' ? 'badge-green' : 'badge-yellow'); ?>">
                        <?php echo e($myToken->status === 'in_consultation' ? 'NOW IN CONSULTATION' : 'WAITING'); ?>

                    </span>
                </div>
                <div style="display:flex;align-items:baseline;gap:1rem;margin-top:.6rem;">
                    <span style="font-size:2.4rem;font-weight:700;color:var(--green);"><?php echo e($myToken->token_number); ?></span>
                    <span style="font-size:13px;color:var(--muted);">Department: <strong><?php echo e($myToken->department); ?></strong></span>
                </div>
                <div style="font-size:13px;margin-top:.4rem;">
                    <?php if($myToken->status === 'in_consultation'): ?>
                        <strong style="color:var(--green);">Your token is being called right now! Please step inside the doctor's room.</strong>
                    <?php else: ?>
                        <span><strong><?php echo e($patientsAhead); ?></strong> patient(s) ahead of you in line.</span>
                        <span style="color:var(--muted);margin-left:6px;">Estimated waiting time: <strong>~<?php echo e(max(5, $patientsAhead * 8)); ?> minutes</strong></span>
                    <?php endif; ?>
                </div>
            </div>
            <div style="font-size:11px;color:var(--muted);border-top:1px solid #ecf2ee;padding-top:.5rem;margin-top:.8rem;">
                Issued today at <?php echo e($myToken->created_at->format('h:i A')); ?>. Please remain in the reception waiting area.
            </div>
        <?php else: ?>
            <div>
                <span class="badge badge-gray">WALK-IN QUEUE REGISTRATION</span>
                <h3 style="font-size:15px;color:var(--green-dk);margin-top:.4rem;">Visiting the Medical Centre Today?</h3>
                <p style="font-size:12px;color:var(--muted);margin-top:4px;line-height:1.5;">
                    If you do not have an advance appointment, you can generate a walk-in queue token instantly for general consultation today.
                </p>
                <form action="<?php echo e(Route::has('patient.queue.join') ? route('patient.queue.join') : '#'); ?>" method="POST" style="margin-top:.8rem;display:flex;gap:.6rem;flex-wrap:wrap;">
                    <?php echo csrf_field(); ?>
                    <select name="department" class="form-control" style="max-width:220px;" required>
                        <option value="General Medicine">General Medicine</option>
                        <option value="Dental">Dental Clinic</option>
                        <option value="Counselling">Counselling &amp; Mental Health</option>
                    </select>
                    <button type="submit" class="btn btn-green">Get Walk-in Queue Token</button>
                </form>
            </div>
            <div style="font-size:11px;color:var(--muted);margin-top:.8rem;">
                * Walk-in tokens are valid for the day of issue only.
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val"><?php echo e($todayQueues->count()); ?></div>
        <div class="stat-label">Total Tokens Today</div>
        <div class="stat-sub">Patients registered</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val"><?php echo e($waitingCount); ?></div>
        <div class="stat-label">Currently Waiting</div>
        <div class="stat-sub">In queue line</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val"><?php echo e($completedCount); ?></div>
        <div class="stat-label">Completed Consultations</div>
        <div class="stat-sub">Attended by doctor today</div>
    </div>
    <div class="stat-card">
        <div class="stat-val">~8 min</div>
        <div class="stat-label">Avg. Consultation Time</div>
        <div class="stat-sub">Standard medical review</div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <span>Today's Live Queue Board &mdash; <?php echo e(date('d M Y')); ?></span>
        <span style="font-size:11px;font-weight:400;text-transform:none;">Auto-refreshes with consultation room activity</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Token</th>
                    <th>Patient Name</th>
                    <th>Department</th>
                    <th>Assigned Doctor</th>
                    <th>Issued At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $todayQueues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="<?php echo e($myToken && $myToken->id === $q->id ? 'background:#fdf9ed;font-weight:700;' : ''); ?>">
                        <td>
                            <strong style="color:var(--green);font-size:14px;"><?php echo e($q->token_number); ?></strong>
                            <?php if($myToken && $myToken->id === $q->id): ?>
                                <span class="badge badge-gold" style="font-size:9px;margin-left:4px;">YOU</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($q->patient->full_name); ?></td>
                        <td><?php echo e($q->department); ?></td>
                        <td><?php echo e($q->doctor?->name ?? 'Next available'); ?></td>
                        <td style="font-size:11px;color:var(--muted);"><?php echo e($q->created_at->format('h:i A')); ?></td>
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
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:1.4rem;color:var(--muted);">No queue tokens issued yet today.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_1_Auth_Patient_Queue\resources\views/patient/queue.blade.php ENDPATH**/ ?>