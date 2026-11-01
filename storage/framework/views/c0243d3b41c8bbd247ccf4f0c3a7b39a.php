<?php $__env->startSection('title', 'E-Prescription Builder'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .rx-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.4rem;
        align-items: start;
    }
    .med-row {
        background: #fbfdfc;
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: .85rem;
        margin-bottom: .8rem;
    }
    @media (max-width: 860px) { .rx-grid { grid-template-columns: 1fr; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Digital E-Prescription Builder</div>
<div class="page-subtitle">Prescribe medications, dosage regimens, vitals, and clinical advice for consultation.</div>

<div class="rx-grid">
    <div class="card">
        <div class="card-header">
            <span>Clinical Prescription Form</span>
            <span class="badge badge-gold">Dynamic UI Builder</span>
        </div>
        <div class="card-body">
            <form onsubmit="event.preventDefault(); showToast('Prescription generated! Form routed to Central Pharmacy.'); window.location.href='<?php echo e(route('demo.doctor.prescription.preview')); ?>';">
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label class="form-label">Consulting Patient</label>
                        <select class="form-control">
                            <option selected><?php echo e($patient['name']); ?> (<?php echo e($patient['university_id']); ?>)</option>
                            <option>Nadia Akter (2023-BBA-044)</option>
                            <option>Tanvir Ahmed (2021-EEE-089)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Clinical Diagnosis <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="Acute Upper Respiratory Tract Infection (Pharyngitis)">
                    </div>
                </div>

                
                <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:.8rem;margin-bottom:1.2rem;background:#f8faf9;border:1px solid #e2ece5;padding:.8rem;border-radius:4px;">
                    <div>
                        <label class="form-label">Blood Pressure</label>
                        <input type="text" class="form-control" value="120/80 mmHg">
                    </div>
                    <div>
                        <label class="form-label">Pulse (bpm)</label>
                        <input type="text" class="form-control" value="76">
                    </div>
                    <div>
                        <label class="form-label">Temperature (°F)</label>
                        <input type="text" class="form-control" value="100.2 °F">
                    </div>
                    <div>
                        <label class="form-label">Body Weight</label>
                        <input type="text" class="form-control" value="68 kg">
                    </div>
                </div>

                
                <div style="margin-bottom:1.2rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                        <label class="form-label" style="margin-bottom:0;">Prescribed Medications (Dynamic Multi-Row)</label>
                        <button type="button" onclick="addMedicineRow()" class="btn btn-outline btn-sm">+ Add Medicine</button>
                    </div>

                    <div id="medicines-container">
                        
                        <div class="med-row">
                            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 30px;gap:.6rem;align-items:center;">
                                <div>
                                    <input type="text" class="form-control" value="Paracetamol 500mg" placeholder="Medicine Name">
                                </div>
                                <div>
                                    <input type="text" class="form-control" value="1+0+1" placeholder="Dosage">
                                </div>
                                <div>
                                    <input type="text" class="form-control" value="5 days" placeholder="Duration">
                                </div>
                                <div>
                                    <input type="number" class="form-control" value="10" placeholder="Qty">
                                </div>
                                <div>
                                    <button type="button" onclick="this.closest('.med-row').remove()" style="color:#c0392b;background:none;border:none;cursor:pointer;font-weight:700;">&times;</button>
                                </div>
                            </div>
                            <div style="margin-top:.4rem;">
                                <input type="text" class="form-control" style="font-size:12px;" value="Take after meals with warm water." placeholder="Special instructions...">
                            </div>
                        </div>

                        
                        <div class="med-row">
                            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 30px;gap:.6rem;align-items:center;">
                                <div>
                                    <input type="text" class="form-control" value="Cetirizine 10mg" placeholder="Medicine Name">
                                </div>
                                <div>
                                    <input type="text" class="form-control" value="0+0+1" placeholder="Dosage">
                                </div>
                                <div>
                                    <input type="text" class="form-control" value="5 days" placeholder="Duration">
                                </div>
                                <div>
                                    <input type="number" class="form-control" value="5" placeholder="Qty">
                                </div>
                                <div>
                                    <button type="button" onclick="this.closest('.med-row').remove()" style="color:#c0392b;background:none;border:none;cursor:pointer;font-weight:700;">&times;</button>
                                </div>
                            </div>
                            <div style="margin-top:.4rem;">
                                <input type="text" class="form-control" style="font-size:12px;" value="At bedtime." placeholder="Special instructions...">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div style="margin-bottom:1.4rem;">
                    <label class="form-label">Clinical Advice &amp; Lifestyle Instructions</label>
                    <textarea class="form-control" rows="3">Drink warm fluids, saline gargle 3 times daily. Avoid cold drinks. Rest for 3 days. Return to clinic if fever persists beyond 72 hours.</textarea>
                </div>

                <div style="display:flex;gap:1rem;">
                    <button type="submit" class="btn btn-green" style="flex:1;padding:.65rem;">
                        Sign &amp; Route to Central Pharmacy &rarr;
                    </button>
                    <a href="<?php echo e(route('demo.doctor.prescription.preview')); ?>" class="btn btn-outline" style="padding:.65rem;">
                        Preview Printable Rx Layout
                    </a>
                </div>
            </form>
        </div>
    </div>

    
    <div>
        <div class="card">
            <div class="card-header">Allergy &amp; Identity Warning</div>
            <div class="card-body" style="font-size:13px;line-height:1.7;">
                <span class="badge badge-red" style="margin-bottom:.5rem;">PENICILLIN ALLERGY</span>
                <p style="font-size:12px;color:#721c24;margin-bottom:1rem;">
                    Do not prescribe Amoxicillin, Ampicillin or Augmentin without checking alternative antibiotic sensitivities.
                </p>
                <div style="border-top:1px solid #eef4f0;padding-top:.8rem;">
                    <div><strong>Patient:</strong> <?php echo e($patient['name']); ?></div>
                    <div><strong>ID:</strong> <?php echo e($patient['university_id']); ?></div>
                    <div><strong>Category:</strong> <?php echo e($patient['role_category']); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addMedicineRow() {
        const container = document.getElementById('medicines-container');
        const row = document.createElement('div');
        row.className = 'med-row';
        row.innerHTML = `
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 30px;gap:.6rem;align-items:center;">
                <div><input type="text" class="form-control" placeholder="Medicine Name (e.g. Omeprazole 20mg)"></div>
                <div><input type="text" class="form-control" placeholder="1+0+0"></div>
                <div><input type="text" class="form-control" placeholder="7 days"></div>
                <div><input type="number" class="form-control" placeholder="7"></div>
                <div><button type="button" onclick="this.closest('.med-row').remove()" style="color:#c0392b;background:none;border:none;cursor:pointer;font-weight:700;">&times;</button></div>
            </div>
            <div style="margin-top:.4rem;">
                <input type="text" class="form-control" style="font-size:12px;" placeholder="Instructions (e.g. Before breakfast)">
            </div>
        `;
        container.appendChild(row);
        showToast('Added new medicine row');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\UniMed_Center\resources\views/demo/doctor-prescription-create.blade.php ENDPATH**/ ?>