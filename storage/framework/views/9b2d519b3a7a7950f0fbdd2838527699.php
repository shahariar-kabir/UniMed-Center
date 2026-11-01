<?php $__env->startSection('title', 'Executive Admin Analytics'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .bar-item {
        margin-bottom: .85rem;
    }
    .bar-label {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 3px;
        font-weight: 700;
    }
    .bar-track {
        background: #edf3ee;
        border-radius: 4px;
        height: 10px;
        overflow: hidden;
    }
    .bar-fill {
        height: 100%;
        background: var(--green);
        border-radius: 4px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">University Health Center &mdash; Executive Analytics</div>
<div class="page-subtitle">Real-time health center operations, patient demographics, clinical workload, and formulary usage metrics.</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">1,420</div>
        <div class="stat-label">Registered Patients</div>
        <div class="stat-sub">Students, faculty &amp; staff</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">340</div>
        <div class="stat-label">Visits This Month</div>
        <div class="stat-sub">+18% vs previous month</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-val">28</div>
        <div class="stat-label">Today's Clinic Footfall</div>
        <div class="stat-sub">Across 4 departments</div>
    </div>
    <div class="stat-card red">
        <div class="stat-val">3</div>
        <div class="stat-label">Critical Stock Alerts</div>
        <div class="stat-sub">Central Pharmacy formulary</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:1.4rem;align-items:start;">
    <div>
        
        <div class="card">
            <div class="card-header">
                <span>Clinical Department Workload &amp; Consultations</span>
                <span class="badge badge-gold">Distribution</span>
            </div>
            <div class="card-body">
                <div class="bar-item">
                    <div class="bar-label">
                        <span>General Medicine Clinic</span>
                        <span>58% &bull; 198 visits</span>
                    </div>
                    <div class="bar-track"><div class="bar-fill" style="width:58%;"></div></div>
                </div>

                <div class="bar-item">
                    <div class="bar-label">
                        <span>Dental Surgery &amp; Oral Health</span>
                        <span>22% &bull; 75 visits</span>
                    </div>
                    <div class="bar-track"><div class="bar-fill" style="width:22%;background:#2980b9;"></div></div>
                </div>

                <div class="bar-item">
                    <div class="bar-label">
                        <span>Gynaecology &amp; Maternal Health</span>
                        <span>14% &bull; 48 visits</span>
                    </div>
                    <div class="bar-track"><div class="bar-fill" style="width:14%;background:var(--gold);"></div></div>
                </div>

                <div class="bar-item">
                    <div class="bar-label">
                        <span>Dermatology &amp; Minor Procedures</span>
                        <span>6% &bull; 19 visits</span>
                    </div>
                    <div class="bar-track"><div class="bar-fill" style="width:6%;background:#8e44ad;"></div></div>
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <span>Recent System Healthcare Activity</span>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Event Type</th>
                            <th>Actor</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10:48 AM</td>
                            <td><span class="badge badge-yellow">Prescription</span></td>
                            <td>Dr. Anisur Rahman</td>
                            <td>Issued RX-2026-0041 to Rahman Al-Hasan</td>
                        </tr>
                        <tr>
                            <td>10:30 AM</td>
                            <td><span class="badge badge-blue">Appointment</span></td>
                            <td>Nadia Akter</td>
                            <td>Consultation confirmed with General Medicine</td>
                        </tr>
                        <tr>
                            <td>09:15 AM</td>
                            <td><span class="badge badge-green">Dispensed</span></td>
                            <td>Md. Rafiqul Islam (Pharma)</td>
                            <td>Fulfilled prescription RX-2026-0035</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div>
        <div class="card">
            <div class="card-header">On-Duty Medical Personnel</div>
            <div class="card-body" style="font-size:13px;line-height:1.7;">
                <div style="border-bottom:1px solid #eef4f0;padding-bottom:.5rem;margin-bottom:.5rem;">
                    <strong>Dr. Anisur Rahman</strong><br>
                    <small style="color:var(--muted);">Senior Medical Officer &bull; Counter 1 (General)</small>
                </div>
                <div style="border-bottom:1px solid #eef4f0;padding-bottom:.5rem;margin-bottom:.5rem;">
                    <strong>Dr. Abdur Karim</strong><br>
                    <small style="color:var(--muted);">Dental Surgeon &bull; Dental Counter 2</small>
                </div>
                <div>
                    <strong>Md. Rafiqul Islam</strong><br>
                    <small style="color:var(--muted);">Head Pharmacist &bull; Central Pharmacy</small>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Administration Tools</div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;">
                <a href="<?php echo e(route('demo.admin.users')); ?>" class="btn btn-green" style="width:100%;">Manage Users &amp; Roles</a>
                <button onclick="showToast('Exporting operational CSV report simulation...')" class="btn btn-outline" style="width:100%;">Download Monthly Audit Report (CSV)</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/admin-dashboard.blade.php ENDPATH**/ ?>