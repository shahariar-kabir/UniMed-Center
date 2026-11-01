<?php $__env->startSection('title', 'User & Role Management'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .role-pill {
        display: inline-block;
        background: #fff;
        border: 1px solid var(--border);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s;
    }
    .role-pill:hover, .role-pill.active {
        background: var(--green);
        color: #fff;
        border-color: var(--green-dk);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Campus Healthcare User &amp; Role Management</div>
<div class="page-subtitle">Assign system access permissions across Medical Officers, Pharmacists, Patients, and System Directors.</div>


<div class="card" style="margin-bottom:1.4rem;">
    <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div style="flex:1;min-width:240px;">
            <input type="text" id="user-search" oninput="filterUsers()" class="form-control" placeholder="🔍 Search user by name, email, or institutional ID...">
        </div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;">
            <span class="role-pill active" onclick="filterRole(this, 'all')">All Roles</span>
            <span class="role-pill" onclick="filterRole(this, 'Doctor')">Doctors</span>
            <span class="role-pill" onclick="filterRole(this, 'Pharmacist')">Pharmacists</span>
            <span class="role-pill" onclick="filterRole(this, 'Admin')">Admins</span>
            <span class="role-pill" onclick="filterRole(this, 'Patient')">Patients</span>
        </div>
        <button onclick="showToast('Create new user account modal simulation')" class="btn btn-green btn-sm">+ Add New User</button>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <span>Campus User Directory</span>
        <span class="badge badge-gold">Active Roster</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table" id="users-table">
            <thead>
                <tr>
                    <th>Name &amp; Email</th>
                    <th>Institutional ID</th>
                    <th>System Role</th>
                    <th>Department &amp; Title</th>
                    <th>Account Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr data-role="Admin">
                    <td>
                        <strong>System Administrator</strong><br>
                        <small style="color:var(--muted);">admin@bu.edu.bd</small>
                    </td>
                    <td>ADMIN-001</td>
                    <td><span class="badge badge-red">Admin</span></td>
                    <td>Administration &bull; Director</td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td>
                        <button onclick="showToast('Editing user permissions simulation')" class="btn btn-outline btn-sm">Edit Role</button>
                    </td>
                </tr>
                <tr data-role="Doctor">
                    <td>
                        <strong>Dr. Anisur Rahman</strong><br>
                        <small style="color:var(--muted);">doctor@bu.edu.bd</small>
                    </td>
                    <td>DOC-010</td>
                    <td><span class="badge badge-blue">Doctor</span></td>
                    <td>General Medicine &bull; Senior Officer</td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td>
                        <button onclick="showToast('Editing user permissions simulation')" class="btn btn-outline btn-sm">Edit Role</button>
                    </td>
                </tr>
                <tr data-role="Doctor">
                    <td>
                        <strong>Dr. Nusrat Sultana</strong><br>
                        <small style="color:var(--muted);">doctor2@bu.edu.bd</small>
                    </td>
                    <td>DOC-011</td>
                    <td><span class="badge badge-blue">Doctor</span></td>
                    <td>Gynaecology &bull; Consultant</td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td>
                        <button onclick="showToast('Editing user permissions simulation')" class="btn btn-outline btn-sm">Edit Role</button>
                    </td>
                </tr>
                <tr data-role="Pharmacist">
                    <td>
                        <strong>Md. Rafiqul Islam</strong><br>
                        <small style="color:var(--muted);">pharma@bu.edu.bd</small>
                    </td>
                    <td>PHARM-005</td>
                    <td><span class="badge badge-gold">Pharmacist</span></td>
                    <td>Central Pharmacy &bull; Head Pharmacist</td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td>
                        <button onclick="showToast('Editing user permissions simulation')" class="btn btn-outline btn-sm">Edit Role</button>
                    </td>
                </tr>
                <tr data-role="Patient">
                    <td>
                        <strong>Rahman Al-Hasan</strong><br>
                        <small style="color:var(--muted);">patient@bu.edu.bd</small>
                    </td>
                    <td>2022-CSE-011</td>
                    <td><span class="badge badge-green">Patient</span></td>
                    <td>Computer Science &bull; Student (Yr 3)</td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td>
                        <button onclick="showToast('Editing user permissions simulation')" class="btn btn-outline btn-sm">Edit Role</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterUsers() {
        const q = document.getElementById('user-search').value.toLowerCase();
        const rows = document.querySelectorAll('#users-table tbody tr');
        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            r.style.display = text.includes(q) ? '' : 'none';
        });
    }

    function filterRole(el, role) {
        document.querySelectorAll('.role-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        const rows = document.querySelectorAll('#users-table tbody tr');
        rows.forEach(r => {
            if (role === 'all' || r.getAttribute('data-role') === role) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\UniMed_Center\resources\views/demo/admin-users.blade.php ENDPATH**/ ?>