<?php $__env->startSection('title', 'Pharmacy Dispense Counter'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Prescription Dispensing Desk</div>
<div class="page-subtitle">Verify electronic prescriptions, confirm patient identity, check medication inventory, and dispense drugs.</div>


<div class="card">
    <div class="card-header">
        <span>Active Prescriptions Awaiting Fulfillment</span>
        <span class="badge badge-gold">1 Order Ready</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rx Reference</th>
                    <th>Patient Identity</th>
                    <th>Prescribing Physician</th>
                    <th>Prescribed Items &amp; Dosages</th>
                    <th>Inventory Status</th>
                    <th>Dispensing Action</th>
                </tr>
            </thead>
            <tbody>
                <tr id="dispense-row-1">
                    <td>
                        <strong style="color:var(--green);font-size:1.1rem;">RX-2026-0041</strong><br>
                        <small style="color:var(--muted);">Issued: Today 10:45 AM</small>
                    </td>
                    <td>
                        <strong>Rahman Al-Hasan</strong><br>
                        <small style="color:var(--muted);">2022-CSE-011 &bull; Student</small>
                    </td>
                    <td>Dr. Anisur Rahman</td>
                    <td>
                        <div style="font-size:12px;line-height:1.6;">
                            <div>&bull; <strong>Paracetamol 500mg</strong> &ndash; 1+0+1 (10 strips)</div>
                            <div>&bull; <strong>Cetirizine 10mg</strong> &ndash; 0+0+1 (5 strips)</div>
                            <div>&bull; <strong>Omeprazole 20mg</strong> &ndash; 1+0+0 (7 caps)</div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-green" id="stock-badge-1">ALL IN STOCK</span>
                    </td>
                    <td>
                        <button onclick="dispenseRx(1)" id="dispense-btn-1" class="btn btn-green btn-sm" style="width:100%;">
                            Dispense &amp; Deduct Stock
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="card" style="margin-top:1.5rem;">
    <div class="card-header">
        <span>Recently Completed Dispensations Today</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rx Ref</th>
                    <th>Patient</th>
                    <th>Items Dispensed</th>
                    <th>Dispensed At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>RX-2026-0035</strong></td>
                    <td>Rahman Al-Hasan</td>
                    <td>Salbutamol Inhaler 100mcg (1 unit)</td>
                    <td>Today at 09:15 AM</td>
                    <td><span class="badge badge-green">DISPENSED</span></td>
                </tr>
                <tr>
                    <td><strong>RX-2026-0034</strong></td>
                    <td>Nadia Akter</td>
                    <td>Antacid Suspension 200ml (1 bottle)</td>
                    <td>Today at 08:50 AM</td>
                    <td><span class="badge badge-green">DISPENSED</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function dispenseRx(id) {
        document.getElementById('stock-badge-' + id).innerText = 'DISPENSED';
        document.getElementById('dispense-btn-' + id).className = 'btn btn-outline btn-sm';
        document.getElementById('dispense-btn-' + id).innerText = '✓ Fulfilled';
        document.getElementById('dispense-btn-' + id).disabled = true;
        showToast('Prescription RX-2026-0041 dispensed! Medicine inventory automatically deducted.');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/pharmacy-dispense.blade.php ENDPATH**/ ?>