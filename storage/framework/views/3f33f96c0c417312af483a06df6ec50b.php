<?php $__env->startSection('title', 'Patient Registration'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">University Member Medical Registration</div>
<div class="page-subtitle">Register for automated healthcare services, live queue tracking, and digital e-prescriptions.</div>

<div class="card" style="max-width:860px;margin:0 auto;">
    <div class="card-header">
        <span>New Patient Intake Form</span>
    </div>
    <div class="card-body">
        <form onsubmit="event.preventDefault(); showToast('Registration simulation: Account verified and registered!');">
            <h4 style="font-size:13px;text-transform:uppercase;color:var(--green);border-bottom:1px solid #eef4f0;padding-bottom:.4rem;margin-bottom:1rem;">
                1. Institutional Identity
            </h4>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label class="form-label">First Name <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g. Rahman">
                </div>
                <div>
                    <label class="form-label">Last Name <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g. Al-Hasan">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label class="form-label">University ID / Roll Number <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g. 2022-CSE-011">
                </div>
                <div>
                    <label class="form-label">Member Category <span style="color:red;">*</span></label>
                    <select class="form-control">
                        <option>Undergraduate Student</option>
                        <option>Graduate Student / Researcher</option>
                        <option>Faculty Member</option>
                        <option>Administrative Staff</option>
                    </select>
                </div>
            </div>

            <h4 style="font-size:13px;text-transform:uppercase;color:var(--green);border-bottom:1px solid #eef4f0;padding-bottom:.4rem;margin-bottom:1rem;margin-top:1.5rem;">
                2. Health &amp; Emergency Details
            </h4>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label class="form-label">Blood Group</label>
                    <select class="form-control">
                        <option>B+</option>
                        <option>A+</option>
                        <option>O+</option>
                        <option>AB+</option>
                        <option>B-</option>
                        <option>O-</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" value="2002-05-14">
                </div>
                <div>
                    <label class="form-label">Gender</label>
                    <select class="form-control">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:1rem;">
                <label class="form-label">Known Allergies / Medical Notes</label>
                <textarea class="form-control" placeholder="e.g. Penicillin, allergic to cold weather, asthmatic..."></textarea>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:6px;font-size:12px;cursor:pointer;">
                    <input type="checkbox" checked style="accent-color:var(--green);">
                    <span>I declare that the information provided is accurate and corresponds to my university institutional records.</span>
                </label>
            </div>

            <button type="submit" class="btn btn-green" style="width:100%;padding:.7rem;font-size:14px;">
                Complete Registration (UI Simulation) &rarr;
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/patient-register.blade.php ENDPATH**/ ?>