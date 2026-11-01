<?php $__env->startSection('title', 'Official Prescription PDF'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .rx-paper {
        background: #fff;
        max-width: 820px;
        margin: 0 auto;
        border: 1px solid #d5e0d8;
        border-radius: 4px;
        box-shadow: 0 4px 16px rgba(0,0,0,.08);
        padding: 2.2rem;
    }
    .rx-header {
        border-bottom: 2px solid var(--green);
        padding-bottom: 1.2rem;
        margin-bottom: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .rx-vitals-box {
        background: #f8fbf9;
        border: 1px solid #d8e6dc;
        border-radius: 4px;
        padding: .8rem 1rem;
        margin-bottom: 1.4rem;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: .8rem;
        font-size: 12px;
    }
    .rx-symbol {
        font-size: 2.4rem;
        font-weight: 700;
        font-style: italic;
        color: var(--green);
        font-family: 'Times New Roman', serif;
        margin-bottom: .6rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Digital E-Prescription Document Preview</div>
<div class="page-subtitle">Standardized A4 PDF layout template generated for university medical records and pharmacy fulfillment.</div>

<div style="text-align:right;max-width:820px;margin:0 auto 1rem auto;">
    <button onclick="window.print()" class="btn btn-green btn-sm">🖨️ Print Prescription</button>
    <button onclick="showToast('Simulating DomPDF download...')" class="btn btn-outline btn-sm">Download PDF &darr;</button>
</div>


<div class="rx-paper">
    <div class="rx-header">
        <div>
            <h2 style="font-size:1.4rem;color:var(--green);font-weight:700;margin-bottom:2px;">UNIVERSITY MEDICAL CENTRE</h2>
            <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;">University Healthcare &bull; Central Medical Building</div>
            <div style="font-size:12px;color:var(--text);margin-top:6px;">
                <strong>Dr. Anisur Rahman</strong>, Senior Medical Officer (MBBS, FCPS)
            </div>
        </div>
        <div style="text-align:right;font-size:12px;line-height:1.6;">
            <div><strong>Rx Ref:</strong> RX-2026-0041</div>
            <div><strong>Date:</strong> <?php echo e(date('d M Y')); ?></div>
            <div><strong>Counter:</strong> 1 (General Medicine)</div>
        </div>
    </div>

    
    <div style="display:flex;justify-content:space-between;border-bottom:1px solid #eef4f0;padding-bottom:.8rem;margin-bottom:1rem;font-size:13px;">
        <div><strong>Patient Name:</strong> <?php echo e($patient['name']); ?></div>
        <div><strong>University ID:</strong> <?php echo e($patient['university_id']); ?></div>
        <div><strong>Age:</strong> 22 yrs &bull; <strong>Gender:</strong> Male</div>
        <div><strong>Blood Group:</strong> <span class="badge badge-red"><?php echo e($patient['blood_group']); ?></span></div>
    </div>

    
    <div class="rx-vitals-box">
        <div><strong>BP:</strong> 120/80 mmHg</div>
        <div><strong>Pulse:</strong> 76 bpm</div>
        <div><strong>Temp:</strong> 100.2 °F</div>
        <div><strong>Weight:</strong> 68 kg</div>
    </div>

    <div style="margin-bottom:1rem;font-size:13px;">
        <strong>Clinical Diagnosis:</strong> Acute Upper Respiratory Tract Infection (Pharyngitis)
    </div>

    
    <div class="rx-symbol">℞</div>

    
    <table class="data-table" style="margin-bottom:1.5rem;">
        <thead>
            <tr>
                <th>#</th>
                <th>Medicine Name &amp; Strength</th>
                <th>Dosage Frequency</th>
                <th>Duration</th>
                <th>Qty</th>
                <th>Instructions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><strong>Paracetamol 500mg</strong></td>
                <td>1 + 0 + 1</td>
                <td>5 days</td>
                <td>10</td>
                <td>After meal with warm water</td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>Cetirizine 10mg</strong></td>
                <td>0 + 0 + 1</td>
                <td>5 days</td>
                <td>5</td>
                <td>At bedtime</td>
            </tr>
            <tr>
                <td>3</td>
                <td><strong>Omeprazole 20mg</strong></td>
                <td>1 + 0 + 0</td>
                <td>7 days</td>
                <td>7</td>
                <td>Before breakfast</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-bottom:2rem;font-size:13px;background:#fbfbfb;border-left:3px solid var(--green);padding:.8rem;border-radius:2px;">
        <strong>Physician Advice:</strong><br>
        Drink warm fluids, saline gargle 3 times daily. Avoid cold drinks. Rest for 3 days. Return to clinic if fever persists beyond 72 hours.
    </div>

    
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-top:3rem;padding-top:1rem;border-top:1px solid #eef4f0;font-size:12px;">
        <div>
            <span class="badge badge-yellow">Central Pharmacy Routing: Ready for Dispense</span>
        </div>
        <div style="text-align:center;">
            <div style="font-family:'Brush Script MT', cursive;font-size:1.6rem;color:var(--green-dk);">Dr. Anisur Rahman</div>
            <div style="border-top:1px solid #999;width:180px;padding-top:2px;">Authorized Medical Officer</div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AndroidStudioProjects\university_medical_center_management_system\demo_ui_app\resources\views/demo/prescription-preview.blade.php ENDPATH**/ ?>