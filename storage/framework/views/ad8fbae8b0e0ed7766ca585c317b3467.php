<?php $__env->startSection('title', 'Book Appointment'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .slot-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 8px;
        margin-top: 6px;
    }
    .slot-pill {
        background: #f4f8f5;
        border: 1.5px solid var(--border);
        border-radius: 4px;
        padding: 8px;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s;
    }
    .slot-pill:hover, .slot-pill.selected {
        background: var(--green);
        color: #fff;
        border-color: var(--green-dk);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">Book Doctor Appointment</div>
<div class="page-subtitle">Schedule a consultation with a University Medical Centre physician or specialist.</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.4rem;align-items:start;">
    
    <div class="card">
        <div class="card-header">
            <span>Appointment Details Form</span>
        </div>
        <div class="card-body">
            <form onsubmit="event.preventDefault(); showToast('Appointment simulation: Slot confirmed! Token generated.');">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label class="form-label">Medical Department</label>
                        <select class="form-control" id="dept-select">
                            <option>General Medicine (Fever, Flu, Routine)</option>
                            <option>Dental Surgery &amp; Oral Health</option>
                            <option>Gynaecology &amp; Women's Health</option>
                            <option>Dermatology &amp; Skin Care</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Consultant Physician</label>
                        <select class="form-control">
                            <option>Dr. Anisur Rahman (MBBS, FCPS &ndash; Senior Officer)</option>
                            <option>Dr. Nusrat Sultana (MBBS, DGO &ndash; Consultant)</option>
                            <option>Dr. Abdur Karim (BDS, PGT &ndash; Dental Surgeon)</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label class="form-label">Preferred Date</label>
                        <input type="date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                    </div>
                    <div>
                        <label class="form-label">Patient University ID</label>
                        <input type="text" class="form-control" value="<?php echo e($patient['university_id']); ?>" readonly style="background:#f9f9f9;">
                    </div>
                </div>

                <div style="margin-bottom:1.2rem;">
                    <label class="form-label">Select Available Time Slot</label>
                    <div class="slot-grid">
                        <div class="slot-pill selected" onclick="selectSlot(this)">09:30 AM</div>
                        <div class="slot-pill" onclick="selectSlot(this)">10:00 AM</div>
                        <div class="slot-pill" onclick="selectSlot(this)">10:30 AM</div>
                        <div class="slot-pill" onclick="selectSlot(this)">11:00 AM</div>
                        <div class="slot-pill" onclick="selectSlot(this)">02:00 PM</div>
                        <div class="slot-pill" onclick="selectSlot(this)">02:30 PM</div>
                    </div>
                </div>

                <div style="margin-bottom:1.4rem;">
                    <label class="form-label">Symptoms / Reason for Visit (Optional)</label>
                    <textarea class="form-control" placeholder="Describe your health symptoms or reason for visit..."></textarea>
                </div>

                <button type="submit" class="btn btn-green" style="width:100%;padding:.65rem;">
                    Confirm &amp; Generate Appointment Token &rarr;
                </button>
            </form>
        </div>
    </div>

    
    <div>
        <div class="card">
            <div class="card-header">Consultation Guidelines</div>
            <div class="card-body" style="font-size:12px;line-height:1.7;color:var(--muted);">
                <p style="margin-bottom:.8rem;">
                    <strong>Same-Day Visits:</strong> Appointments booked for today are automatically assigned a live queue token ticket upon booking.
                </p>
                <p style="margin-bottom:.8rem;">
                    <strong>Student Verification:</strong> Please bring your University Student ID Card or Digital ID Card during doctor consultation.
                </p>
                <p>
                    <strong>Emergency:</strong> For acute chest pain, severe trauma, or breathing distress, proceed directly to Counter 1 Emergency.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function selectSlot(el) {
        document.querySelectorAll('.slot-pill').forEach(s => s.classList.remove('selected'));
        el.classList.add('selected');
        showToast('Selected slot: ' + el.innerText);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.demo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\UniMed_Center\resources\views/demo/appointment-booking.blade.php ENDPATH**/ ?>