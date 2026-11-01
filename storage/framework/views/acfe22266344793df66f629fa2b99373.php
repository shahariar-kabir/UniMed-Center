<?php $__env->startSection('title', 'Pharmacy Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Central Pharmacy Management Dashboard</div>
<div class="page-subtitle">Dispensary inventory monitoring, real-time stock levels, expiring batch alerts, and e-prescription fulfillment.</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">128</div>
        <div class="stat-label">Total Medicine Items</div>
        <div class="stat-sub">Central formulary catalog</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">4</div>
        <div class="stat-label">Pending Prescriptions</div>
        <div class="stat-sub">Ready for dispensing</div>
    </div>
    <div class="stat-card red">
        <div class="stat-val">3</div>
        <div class="stat-label">Low Stock Alerts</div>
        <div class="stat-sub">Below reorder minimum</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">2</div>
        <div class="stat-label">Near-Expiry Batches</div>
        <div class="stat-sub">Expiring within 60 days</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.4rem;align-items:start;">
    <div>
        
        <div class="card">
            <div class="card-header" style="background:#c0392b;">
                <span>⚠️ Stock Alerts Requiring Action</span>
                <span class="badge badge-gold">Auto Flagged</span>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Batch #</th>
                            <th>Current Stock</th>
                            <th>Reorder Level</th>
                            <th>Expiry Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Metformin 500mg</strong></td>
                            <td>MET-2026-L1</td>
                            <td><span class="badge badge-red">15 strips</span></td>
                            <td>30 strips</td>
                            <td>2027-02-15</td>
                            <td>
                                <button onclick="showToast('Stock reorder simulated for Metformin 500mg')" class="btn btn-outline btn-sm">Reorder</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Azithromycin 500mg</strong></td>
                            <td>AZI-2026-L2</td>
                            <td><span class="badge badge-red">10 strips</span></td>
                            <td>25 strips</td>
                            <td>2026-12-10</td>
                            <td>
                                <button onclick="showToast('Stock reorder simulated for Azithromycin 500mg')" class="btn btn-outline btn-sm">Reorder</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Oral Rehydration Salts (ORS)</strong></td>
                            <td>ORS-2026-E1</td>
                            <td>150 pkts</td>
                            <td>50 pkts</td>
                            <td><span class="badge badge-yellow">28 days left</span></td>
                            <td>
                                <button onclick="showToast('Disposal protocol simulated')" class="btn btn-outline btn-sm">Quarantine</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <span>Prescriptions Waiting at Dispensing Counter</span>
                <a href="<?php echo e(route('demo.pharmacy.dispense')); ?>" style="color:#fff;font-size:11px;text-decoration:underline;">View All Dispense Orders &rarr;</a>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rx Number</th>
                            <th>Patient Identity</th>
                            <th>Doctor</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>RX-2026-0041</strong></td>
                            <td>Rahman Al-Hasan (2022-CSE-011)</td>
                            <td>Dr. Anisur Rahman</td>
                            <td>Paracetamol, Cetirizine, Omeprazole</td>
                            <td><span class="badge badge-yellow">Ready</span></td>
                            <td>
                                <a href="<?php echo e(route('demo.pharmacy.dispense')); ?>" class="btn btn-green btn-sm">Dispense &rarr;</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div>
        <div class="card">
            <div class="card-header">Pharmacy Quick Actions</div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;">
                <a href="<?php echo e(route('demo.pharmacy.inventory')); ?>" class="btn btn-green" style="width:100%;">Inspect Medicine Inventory</a>
                <a href="<?php echo e(route('demo.pharmacy.dispense')); ?>" class="btn btn-outline" style="width:100%;">Open Dispensing Desk</a>
                <button onclick="showToast('Add new medicine modal simulation opened')" class="btn btn-outline" style="width:100%;">+ Add Medicine to Formulary</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/pharmacy-dashboard.blade.php ENDPATH**/ ?>