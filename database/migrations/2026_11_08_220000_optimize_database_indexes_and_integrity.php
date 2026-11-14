<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Optimize patients indexes
        Schema::table('patients', function (Blueprint $table) {
            $table->index('email', 'patients_email_index');
            $table->index('phone', 'patients_phone_index');
            $table->index(['user_id', 'is_verified'], 'patients_user_id_verified_index');
        });

        // 2. Optimize medical_queues composite indexes
        Schema::table('medical_queues', function (Blueprint $table) {
            $table->index(['queue_date', 'status'], 'queues_date_status_index');
            $table->index(['patient_id', 'queue_date', 'status'], 'queues_patient_date_status_index');
            $table->index(['doctor_id', 'queue_date', 'status'], 'queues_doctor_date_status_index');
        });

        // 3. Optimize appointments composite indexes
        Schema::table('appointments', function (Blueprint $table) {
            $table->index(['appointment_date', 'time_slot'], 'appointments_date_slot_index');
            $table->index(['patient_id', 'appointment_date'], 'appointments_patient_date_index');
            $table->index(['doctor_id', 'appointment_date', 'time_slot'], 'appointments_doc_date_slot_index');
        });

        // 4. Optimize prescriptions composite indexes
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->index(['doctor_id', 'created_at'], 'prescriptions_doc_created_index');
            $table->index(['patient_id', 'created_at'], 'prescriptions_patient_created_index');
            $table->index(['status', 'dispensed_at'], 'prescriptions_status_dispensed_index');
        });

        // 5. Optimize medicines indexes
        Schema::table('medicines', function (Blueprint $table) {
            $table->index('is_active', 'medicines_is_active_index');
            $table->index(['is_active', 'expiry_date'], 'medicines_active_expiry_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropIndex('medicines_is_active_index');
            $table->dropIndex('medicines_active_expiry_index');
        });

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropIndex('prescriptions_doc_created_index');
            $table->dropIndex('prescriptions_patient_created_index');
            $table->dropIndex('prescriptions_status_dispensed_index');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('appointments_date_slot_index');
            $table->dropIndex('appointments_patient_date_index');
            $table->dropIndex('appointments_doc_date_slot_index');
        });

        Schema::table('medical_queues', function (Blueprint $table) {
            $table->dropIndex('queues_date_status_index');
            $table->dropIndex('queues_patient_date_status_index');
            $table->dropIndex('queues_doctor_date_status_index');
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex('patients_email_index');
            $table->dropIndex('patients_phone_index');
            $table->dropIndex('patients_user_id_verified_index');
        });
    }
};
