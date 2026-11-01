<?php $__env->startSection('title', 'Patient Medical History'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Patient Medical History &mdash; <?php echo e($patient['name']); ?></div>
<div class="page-subtitle">University ID: <strong><?php echo e($patient['university_id']); ?></strong> &bull; Department: <strong><?php echo e($patient['department']); ?></strong> &bull; Category: <strong><?php echo e($patient['role_category']); ?></strong></div>


<div class="card" style="border-left: 4px solid #c0392b; background: #fdf5f5; margin-bottom: 1.5rem;">
    <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <strong style="color:#c0392b;font-size:14px;display:block;">⚠️ KNOWN DRUG ALLERGIES REPORTED</strong>
            <span style="font-size:13px;color:#721c24;"><?php echo e($patient['allergies']); ?> &bull; Patient experiences hives with penicillin group antibiotics.</span>
        </div>
        <span class="badge badge-red" style="font-size:11px;">Clinical Alert</span>
    </div>
</div>


<div style="display:grid;grid-template-columns:1fr 340px;gap:1.4rem;align-items:start;">
    <div>
        
        <div class="card">
            <div class="card-header">
                <span>Past Clinical Consultations &amp; Prescriptions</span>
                <span class="badge badge-gold">Historical File</span>
            </div>
            <div class="card-body">
                
                <div style="border-bottom:1px solid #eef4f0;padding-bottom:1.2rem;margin-bottom:1.2rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <div>
                            <strong style="color:var(--green);font-size:14px;">RX-2026-0041</strong> &bull; Upper Respiratory Tract Infection (Pharyngitis)
                        </div>
                        <span class="badge badge-yellow">At Pharmacy</span>
                    </div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:.5rem;">
                        Attending Doctor: <strong>Dr. Anisur Rahman</strong> &bull; Date: Today &bull; Vitals: BP 120/80 mmHg, Pulse 76 bpm, Temp 100.2 °F, Weight 68 kg
                    </div>
                    <div style="background:#f9fbfa;border:1px solid #e2ece5;border-radius:4px;padding:.8rem;font-size:12px;">
                        <strong>Prescribed Medicines:</strong>
                        <ul style="padding-left:1.2rem;margin-top:4px;">
                            <li>Paracetamol 500mg &ndash; 1+0+1 (5 days) &ndash; After meal</li>
                            <li>Cetirizine 10mg &ndash; 0+0+1 (5 days) &ndash; At bedtime</li>
                            <li>Omeprazole 20mg &ndash; 1+0+0 (7 days) &ndash; Before breakfast</li>
                        </ul>
                    </div>
                </div>

                
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <div>
                            <strong style="color:var(--green);font-size:14px;">RX-2026-0035</strong> &bull; Mild Bronchial Spasm / Wheezing
                        </div>
                        <span class="badge badge-green">Dispensed</span>
                    </div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:.5rem;">
                        Attending Doctor: <strong>Dr. Anisur Rahman</strong> &bull; Date: 15 days ago &bull; Vitals: BP 118/78 mmHg, Pulse 80 bpm, Temp 98.6 °F, Weight 67 kg
                    </div>
                    <div style="background:#f9fbfa;border:1px solid #e2ece5;border-radius:4px;padding:.8rem;font-size:12px;">
                        <strong>Prescribed Medicines:</strong>
                        <ul style="padding-left:1.2rem;margin-top:4px;">
                            <li>Salbutamol Inhaler 100mcg &ndash; 2 puffs as needed &ndash; Inhale through spacer</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div>
        <div class="card">
            <div class="card-header">Patient Vitals Baseline</div>
            <div class="card-body" style="font-size:13px;line-height:1.7;">
                <div><strong>Blood Group:</strong> <span class="badge badge-red"><?php echo e($patient['blood_group']); ?></span></div>
                <div><strong>Mobile:</strong> <?php echo e($patient['phone']); ?></div>
                <div><strong>Campus Address:</strong> <?php echo e($patient['address']); ?></div>
                <div><strong>Emergency:</strong> <?php echo e($patient['emergency_name']); ?> (<?php echo e($patient['emergency_phone']); ?>)</div>
                
                <div style="margin-top:1.2rem;">
                    <a href="<?php echo e(route('demo.doctor.prescription.create')); ?>" class="btn btn-green btn-sm" style="width:100%;">
                        + Write New Prescription for Patient
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/doctor-patient-history.blade.php ENDPATH**/ ?>