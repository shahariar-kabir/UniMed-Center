<?php $__env->startSection('title', 'Live Queue Board'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .queue-board {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 1.4rem;
        align-items: start;
    }
    .calling-display {
        background: #fff;
        border: 2px solid var(--green);
        border-radius: var(--radius);
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--shadow);
    }
    .calling-token {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--green);
        line-height: 1;
        margin: .5rem 0;
    }
    .my-token-banner {
        background: var(--gold-lt);
        border: 1.5px solid var(--gold);
        border-radius: var(--radius);
        padding: 1rem 1.4rem;
        margin-bottom: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    @media (max-width: 860px) { .queue-board { grid-template-columns: 1fr; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Live Clinic Queue Display Board</div>
<div class="page-subtitle">Real-time doctor queue counter, token announcements, and waiting time tracker.</div>


<div class="my-token-banner">
    <div>
        <span class="badge badge-gold" style="font-size:10px;">MY CURRENT QUEUE TICKET</span>
        <div style="font-size:1.8rem;font-weight:700;color:var(--text);margin-top:2px;">Token # T-101</div>
        <div style="font-size:12px;color:var(--muted);">Department: General Medicine &bull; Consultation Counter 1</div>
    </div>
    <div style="text-align:right;">
        <span class="badge badge-yellow" style="font-size:12px;padding:4px 10px;">2 Patients Ahead of You</span>
        <div style="font-size:12px;color:var(--muted);margin-top:4px;">Estimated consultation in approx. 12 mins</div>
    </div>
</div>

<div class="queue-board">
    
    <div>
        <div class="calling-display">
            <span class="badge badge-green" style="font-size:11px;">NOW CALLING</span>
            <div class="calling-token" id="calling-token">T-100</div>
            <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:2px;">Counter 1: Dr. Anisur Rahman</div>
            <div style="font-size:12px;color:var(--muted);margin-bottom:1.2rem;">Department: General Medicine</div>
            
            <button onclick="advanceQueue()" class="btn btn-outline btn-sm" style="width:100%;">
                ⏩ Simulate Next Token Advance
            </button>
        </div>

        <div class="card" style="margin-top:1.4rem;">
            <div class="card-header">Walk-in Queue Token</div>
            <div class="card-body" style="font-size:12px;color:var(--muted);">
                <p style="margin-bottom:.8rem;">
                    Don't have an online appointment? Tap below to simulate generating an on-the-spot walk-in queue ticket:
                </p>
                <button onclick="showToast('Walk-in Token T-106 generated! Proceed to waiting lobby.')" class="btn btn-green btn-sm" style="width:100%;">
                    + Issue Walk-in Ticket
                </button>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <span>Today's Live Queue Roster (General Medicine)</span>
            <span style="font-size:11px;opacity:.9;">Live Synced</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Patient Identity</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Wait Time</th>
                    </tr>
                </thead>
                <tbody id="queue-rows">
                    <tr style="background:#f4fbf6;">
                        <td><strong style="color:var(--green);font-size:1.1rem;">T-100</strong></td>
                        <td>Nadia Akter (2023-BBA-044)</td>
                        <td>General Medicine</td>
                        <td><span class="badge badge-green">In Consultation</span></td>
                        <td>Attending Now</td>
                    </tr>
                    <tr style="background:#fffcf2;">
                        <td><strong style="color:var(--gold);font-size:1.1rem;">T-101</strong></td>
                        <td><strong>Rahman Al-Hasan (You)</strong></td>
                        <td>General Medicine</td>
                        <td><span class="badge badge-yellow">Next in Line</span></td>
                        <td>~5 mins</td>
                    </tr>
                    <tr>
                        <td><strong>T-102</strong></td>
                        <td>Tanvir Ahmed (2021-EEE-089)</td>
                        <td>General Medicine</td>
                        <td><span class="badge badge-blue">Waiting</span></td>
                        <td>~15 mins</td>
                    </tr>
                    <tr>
                        <td><strong>T-103</strong></td>
                        <td>Farzana Khan (Staff &ndash; Library)</td>
                        <td>General Medicine</td>
                        <td><span class="badge badge-blue">Waiting</span></td>
                        <td>~25 mins</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let currentToken = 100;
    function advanceQueue() {
        currentToken++;
        document.getElementById('calling-token').innerText = 'T-' + currentToken;
        showToast('Now calling Token T-' + currentToken + ' to Counter 1');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/live-queue.blade.php ENDPATH**/ ?>