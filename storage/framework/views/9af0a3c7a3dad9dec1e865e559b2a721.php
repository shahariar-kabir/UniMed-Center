<?php $__env->startSection('title', 'Prescription ' . $prescription->prescription_number); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .rx-paper {
        max-width: 800px;
        margin: 1rem auto;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 2.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,.08);
        font-family: Arial, Helvetica, sans-serif;
    }
    .rx-header {
        border-bottom: 2px solid var(--green);
        padding-bottom: 1.2rem;
        margin-bottom: 1.2rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .rx-brand h2 { font-size: 1.4rem; color: var(--green); font-weight: 700; }
    .rx-brand p { font-size: 12px; color: var(--muted); margin-top: 2px; }
    .rx-meta { text-align: right; font-size: 12px; color: var(--muted); }
    .rx-meta strong { font-size: 14px; color: var(--text); display: block; }

    .rx-parties {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: .85rem 1rem;
        margin-bottom: 1.2rem;
        font-size: 12px;
        line-height: 1.6;
    }

    .vitals-strip {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        background: #fdfaf3;
        border: 1px solid #fae6c3;
        border-radius: 4px;
        padding: .6rem 1rem;
        font-size: 12px;
        margin-bottom: 1.2rem;
    }
    .vitals-strip span { font-weight: 700; color: var(--gold); }

    .rx-symbol {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Times New Roman', serif;
        color: var(--green);
        margin-bottom: .6rem;
    }

    .rx-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
        font-size: 13px;
    }
    .rx-table th {
        background: var(--green-pale);
        color: var(--green-dk);
        text-align: left;
        padding: .6rem .8rem;
        font-size: 11px;
        text-transform: uppercase;
        border-bottom: 2px solid var(--green);
    }
    .rx-table td {
        padding: .7rem .8rem;
        border-bottom: 1px solid #ecf2ee;
        vertical-align: middle;
    }

    .rx-footer {
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .sig-line {
        border-top: 1px dashed #333;
        width: 220px;
        text-align: center;
        font-size: 11px;
        padding-top: 4px;
        color: var(--muted);
    }

    @media print {
        body * { visibility: hidden; }
        .rx-paper, .rx-paper * { visibility: visible; }
        .rx-paper { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; padding: 0; }
        .no-print { display: none !important; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="no-print" style="max-width:800px;margin:0 auto 1rem auto;display:flex;justify-content:space-between;align-items:center;">
    <a href="javascript:history.back()" class="btn btn-outline btn-sm">&larr; Back to Portal</a>
    <div style="display:flex;gap:.5rem;">
        <button onclick="window.print()" class="btn btn-outline btn-sm">Print Prescription</button>
        <a href="<?php echo e(Route::has('patient.prescriptions.pdf') ? route('patient.prescriptions.pdf', $prescription->id) : '#'); ?>" class="btn btn-green btn-sm">Download Official PDF</a>
    </div>
</div>

<div class="rx-paper">
    <div class="rx-header">
        <div class="rx-brand">
            <h2>UniMedCenter &bull; University Medical Centre</h2>
            <p>Health &amp; Wellness Division &bull; Central Campus, Dhaka &bull; Hotline: 0188888888</p>
        </div>
        <div class="rx-meta">
            <strong><?php echo e($prescription->prescription_number); ?></strong>
            <div>Date: <?php echo e($prescription->created_at->format('d M Y, h:i A')); ?></div>
            <div style="margin-top:2px;">
                <span class="badge <?php echo e($prescription->status === 'dispensed' ? 'badge-green' : 'badge-yellow'); ?>">
                    <?php echo e(ucfirst($prescription->status)); ?>

                </span>
            </div>
        </div>
    </div>

    
    <div class="rx-parties">
        <div>
            <strong style="color:var(--green);font-size:13px;">PATIENT DETAILS</strong>
            <div>Name: <strong><?php echo e($prescription->patient->full_name); ?></strong></div>
            <div>University ID: <strong><?php echo e($prescription->patient->university_id); ?></strong></div>
            <div>Age / Gender: <?php echo e($prescription->patient->dob ? $prescription->patient->dob->age . ' yrs' : 'N/A'); ?> / <?php echo e($prescription->patient->gender); ?></div>
            <div>Blood Group: <strong><?php echo e($prescription->patient->blood_group ?? 'Not Set'); ?></strong></div>
            <div>Allergies: <span style="color:#c0392b;font-weight:700;"><?php echo e($prescription->patient->allergies ?: 'None reported'); ?></span></div>
        </div>
        <div>
            <strong style="color:var(--green);font-size:13px;">ATTENDING PHYSICIAN</strong>
            <div>Doctor: <strong><?php echo e($prescription->doctor->name); ?></strong></div>
            <div>Designation: <?php echo e($prescription->doctor->designation ?? 'Medical Officer'); ?></div>
            <div>Department: <?php echo e($prescription->doctor->department ?? 'General Medicine'); ?></div>
            <div>Phone: <?php echo e($prescription->doctor->phone ?? 'University Ext.'); ?></div>
        </div>
    </div>

    
    <div class="vitals-strip">
        <div>BP: <span><?php echo e($prescription->bp ?: '120/80 mmHg'); ?></span></div>
        <div>Pulse: <span><?php echo e($prescription->pulse ?: '72 bpm'); ?></span></div>
        <div>Temp: <span><?php echo e($prescription->temperature ?: '98.6 °F'); ?></span></div>
        <div>Weight: <span><?php echo e($prescription->weight ?: '65 kg'); ?></span></div>
    </div>

    <div style="margin-bottom:1.2rem;">
        <div class="form-label" style="color:var(--green);">CLINICAL DIAGNOSIS</div>
        <div style="font-size:14px;font-weight:700;color:var(--text);background:#f9fbfa;border:1px solid var(--border);border-radius:4px;padding:.5rem .8rem;">
            <?php echo e($prescription->diagnosis); ?>

        </div>
    </div>

    <div class="rx-symbol">&#8478;</div>

    
    <table class="rx-table">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Medicine / Formulation</th>
                <th>Dosage Pattern</th>
                <th>Duration</th>
                <th>Instructions</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $prescription->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($idx + 1); ?></td>
                    <td>
                        <strong style="font-size:13px;"><?php echo e($item->medicine_name); ?></strong>
                        <?php if($item->medicine): ?>
                            <div style="font-size:11px;color:var(--muted);"><?php echo e($item->medicine->generic_name); ?> (<?php echo e($item->medicine->strength); ?>)</div>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge badge-gold" style="font-size:12px;"><?php echo e($item->dosage); ?></span></td>
                    <td><?php echo e($item->duration); ?></td>
                    <td style="font-size:12px;"><?php echo e($item->instructions ?: 'As directed'); ?></td>
                    <td><strong><?php echo e($item->quantity); ?></strong></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    
    <?php if($prescription->clinical_advice): ?>
        <div style="background:#f9fbfa;border:1px solid var(--border);border-radius:4px;padding:.8rem;margin-bottom:1.5rem;">
            <div class="form-label" style="color:var(--green);">CLINICAL ADVICE &amp; INSTRUCTIONS</div>
            <div style="font-size:12px;line-height:1.6;white-space:pre-line;"><?php echo e($prescription->clinical_advice); ?></div>
        </div>
    <?php endif; ?>

    <div class="rx-footer">
        <div style="font-size:11px;color:var(--muted);max-width:320px;">
            * This digital prescription is electronically certified and verifiable at Central Pharmacy.
        </div>
        <div style="text-align:center;">
            <div style="font-family:'Brush Script MT', cursive;font-size:22px;color:var(--green-dk);margin-bottom:3px;">
                <?php echo e($prescription->doctor->name); ?>

            </div>
            <div class="sig-line">
                Prescribing Medical Officer Signature &amp; Seal
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\feature_apps\Feature_2_Doctor_Prescription_Engine\resources\views/prescriptions/show.blade.php ENDPATH**/ ?>