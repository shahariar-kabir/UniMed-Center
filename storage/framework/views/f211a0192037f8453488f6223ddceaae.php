<?php $__env->startSection('title', 'Patient Registration'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .reg-layout {
        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 1.4rem;
        align-items: start;
    }

    /* form sections */
    .form-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .form-card-head {
        background: var(--green);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        padding: .5rem .9rem;
    }
    .form-card-body { padding: 1rem; }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
        margin-bottom: .75rem;
    }
    .field-row.three { grid-template-columns: 1fr 1fr 1fr; }
    .field-row.full  { grid-template-columns: 1fr; }
    .field-group { display: flex; flex-direction: column; gap: 3px; }

    .radio-inline { display: flex; gap: 1.2rem; flex-wrap: wrap; padding-top: 3px; }
    .radio-inline label { display: flex; align-items: center; gap: .3rem; font-size: 13px; cursor: pointer; font-weight: 400; }
    .radio-inline input { accent-color: var(--green); }

    .check-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .35rem; margin-top: 4px; }
    .check-grid label { display: flex; align-items: center; gap: .3rem; font-size: 12px; cursor: pointer; font-weight: 400; }
    .check-grid input { accent-color: var(--green); }

    .form-actions {
        background: #f4f8f5;
        border-top: 1px solid var(--border);
        padding: .75rem 1rem;
        display: flex;
        justify-content: flex-end;
        gap: .6rem;
        align-items: center;
    }
    .form-actions small { font-size: 11px; color: var(--muted); font-weight: 400; margin-right: auto; }

    /* sidebar info */
    .info-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .info-card-head {
        background: var(--green-dk);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        padding: .45rem .75rem;
    }
    .info-card-body {
        padding: .75rem;
        font-size: 12px;
        color: var(--muted);
        font-weight: 400;
        line-height: 1.6;
    }
    .info-card-body ul { padding-left: 1rem; }
    .info-card-body li { margin-bottom: .3rem; }
    .info-card-body strong { color: var(--text); }

    .required-note { font-size: 11px; color: var(--muted); font-weight: 400; margin-bottom: 1rem; }

    @media (max-width: 820px) {
        .reg-layout { grid-template-columns: 1fr; }
        .field-row, .field-row.three { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="page-title">Patient Registration</div>
<div class="page-subtitle">Complete the form below to register as a patient of the University Medical Centre. Please fill in all required fields accurately. Your information will be treated in strict confidence.</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="alert alert-error">
        <strong>Please correct the following errors:</strong>
        <ul style="padding-left:1.2rem;margin-top:4px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="reg-layout">
    
    <div>
        <p class="required-note">Fields marked <span style="color:#c0392b;">*</span> are required.</p>

        <form method="POST" action="<?php echo e(url('/patients/register')); ?>" novalidate>
            <?php echo csrf_field(); ?>

            
            <div class="form-card">
                <div class="form-card-head">Section 1 &mdash; Personal Details</div>
                <div class="form-card-body">
                    <div class="field-row">
                        <div class="field-group">
                            <label class="form-label">First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name')); ?>" required>
                        </div>
                        <div class="field-group">
                            <label class="form-label">Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name')); ?>" required>
                        </div>
                    </div>
                    <div class="field-row three">
                        <div class="field-group">
                            <label class="form-label">Date of Birth <span class="req">*</span></label>
                            <input type="date" name="dob" class="form-control" value="<?php echo e(old('dob')); ?>" required>
                        </div>
                        <div class="field-group">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group" class="form-control">
                                <option value="">— Select —</option>
                                <?php $__currentLoopData = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bg); ?>" <?php echo e(old('blood_group') === $bg ? 'selected' : ''); ?>><?php echo e($bg); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control" value="<?php echo e(old('nationality', 'Bangladeshi')); ?>">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="form-label">Gender <span class="req">*</span></label>
                        <div class="radio-inline">
                            <?php $__currentLoopData = ['Male','Female','Other','Prefer not to say']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label>
                                    <input type="radio" name="gender" value="<?php echo e($g); ?>" <?php echo e(old('gender') === $g ? 'checked' : ''); ?> required>
                                    <?php echo e($g); ?>

                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-head">Section 2 &mdash; University Details</div>
                <div class="form-card-body">
                    <div class="field-row">
                        <div class="field-group">
                            <label class="form-label">University ID / Employee ID <span class="req">*</span></label>
                            <input type="text" name="university_id" class="form-control" placeholder="e.g. 2021-CSE-042" value="<?php echo e(old('university_id')); ?>" required>
                        </div>
                        <div class="field-group">
                            <label class="form-label">Category <span class="req">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="">— Select —</option>
                                <option value="student"  <?php echo e(old('role') === 'student'  ? 'selected' : ''); ?>>Student (Undergraduate)</option>
                                <option value="postgrad" <?php echo e(old('role') === 'postgrad' ? 'selected' : ''); ?>>Student (Postgraduate)</option>
                                <option value="faculty"  <?php echo e(old('role') === 'faculty'  ? 'selected' : ''); ?>>Faculty / Academic Staff</option>
                                <option value="staff"    <?php echo e(old('role') === 'staff'    ? 'selected' : ''); ?>>Administrative Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="form-label">Department / Faculty</label>
                            <input type="text" name="department" class="form-control" placeholder="e.g. Computer Science & Engineering" value="<?php echo e(old('department')); ?>">
                        </div>
                        <div class="field-group">
                            <label class="form-label">Year / Semester (Students only)</label>
                            <input type="text" name="year" class="form-control" placeholder="e.g. Year 3, Semester 5" value="<?php echo e(old('year')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-head">Section 3 &mdash; Contact Information</div>
                <div class="form-card-body">
                    <div class="field-row">
                        <div class="field-group">
                            <label class="form-label">University Email <span class="req">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="yourname@bu.edu.bd" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="field-group">
                            <label class="form-label">Mobile Number <span class="req">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" value="<?php echo e(old('phone')); ?>" required>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="form-label">Emergency Contact Name</label>
                            <input type="text" name="emergency_name" class="form-control" placeholder="Parent / Guardian name" value="<?php echo e(old('emergency_name')); ?>">
                        </div>
                        <div class="field-group">
                            <label class="form-label">Emergency Contact Number</label>
                            <input type="tel" name="emergency_phone" class="form-control" placeholder="01XXXXXXXXX" value="<?php echo e(old('emergency_phone')); ?>">
                        </div>
                    </div>
                    <div class="field-row full">
                        <div class="field-group">
                            <label class="form-label">Current Address (Hall / Dormitory or Home)</label>
                            <textarea name="address" class="form-control" rows="2"><?php echo e(old('address')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-head">Section 4 &mdash; Medical History</div>
                <div class="form-card-body">
                    <div class="field-row full" style="margin-bottom:.75rem;">
                        <div class="field-group">
                            <label class="form-label">Known Allergies (drugs, food, other)</label>
                            <input type="text" name="allergies" class="form-control" placeholder="e.g. Penicillin, Shellfish — leave blank if none" value="<?php echo e(old('allergies')); ?>">
                        </div>
                    </div>
                    <div class="field-group" style="margin-bottom:.75rem;">
                        <label class="form-label">Pre-existing Conditions <small style="text-transform:none;font-weight:400;">(tick all that apply)</small></label>
                        <div class="check-grid">
                            <?php $__currentLoopData = ['Diabetes (Type 1 or 2)','Hypertension / High BP','Asthma / Respiratory','Heart Disease','Epilepsy / Seizures','Thyroid Disorder','Anaemia','Anxiety / Depression','Kidney Disease','None of the above']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cond): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label>
                                    <input type="checkbox" name="conditions[]" value="<?php echo e($cond); ?>"
                                        <?php echo e(in_array($cond, old('conditions', [])) ? 'checked' : ''); ?>>
                                    <?php echo e($cond); ?>

                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="field-row full">
                        <div class="field-group">
                            <label class="form-label">Current Medications (name, dose, frequency)</label>
                            <textarea name="medications" class="form-control" placeholder="e.g. Metformin 500mg twice daily — leave blank if none"><?php echo e(old('medications')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-head">Declaration</div>
                <div class="form-card-body">
                    <p style="font-size:12px;color:var(--muted);font-weight:400;line-height:1.7;margin-bottom:.75rem;">
                        I declare that the information provided above is accurate and complete to the best of my knowledge.
                        I understand that providing false information may result in the termination of my access to Medical Centre services.
                        I consent to the collection and processing of my personal and medical data for the purpose of healthcare delivery at University Medical Centre.
                    </p>
                    <label style="display:flex;align-items:flex-start;gap:.5rem;font-size:13px;cursor:pointer;font-weight:400;">
                        <input type="checkbox" name="declaration" required style="accent-color:var(--green);margin-top:2px;flex-shrink:0;">
                        I have read and agree to the declaration above. <span style="color:#c0392b;margin-left:2px;">*</span>
                    </label>
                </div>
                <div class="form-actions">
                    <small>All fields marked * are mandatory.</small>
                    <button type="reset"  class="btn btn-outline">Clear Form</button>
                    <button type="submit" class="btn btn-green">Submit Registration</button>
                </div>
            </div>
        </form>
    </div>

    
    <div>
        <div class="info-card">
            <div class="info-card-head">Before You Register</div>
            <div class="info-card-body">
                <ul>
                    <li>You <strong>must</strong> be a current student or staff member of the University.</li>
                    <li>Have your <strong>university ID card</strong> ready.</li>
                    <li>Registration is a <strong>one-time process</strong>. Once submitted, visit the centre to collect your patient card.</li>
                    <li>Your data is handled under the university's <strong>data protection policy</strong>.</li>
                </ul>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-head">Need Help?</div>
            <div class="info-card-body">
                Contact the Medical Centre reception:<br><br>
                <strong>Phone:</strong> 0188888888<br>
                <strong>Email:</strong> medcentre@bu.edu.bd<br>
                <strong>Counter hours:</strong> Mon–Fri 8am–5pm
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-head">Already Registered?</div>
            <div class="info-card-body">
                If you already have a patient record, do not re-register. Instead, <a href="<?php echo e(url('/appointments')); ?>" style="color:var(--green);">book an appointment</a> directly or visit the counter with your patient card.
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_1_Auth_Patient_Queue\resources\views/patients/register.blade.php ENDPATH**/ ?>