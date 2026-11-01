<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // Admin & Pharmacist
        $admin = User::updateOrCreate(
            ['email' => 'admin@bu.edu.bd'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'university_id' => 'ADMIN-001',
                'phone' => '0188888888',
                'department' => 'Administration',
                'designation' => 'System Director',
            ]
        );

        $pharmacist = User::updateOrCreate(
            ['email' => 'pharma@bu.edu.bd'],
            [
                'name' => 'Md. Rafiqul Islam',
                'password' => Hash::make('password'),
                'role' => 'pharmacist',
                'university_id' => 'PHARM-005',
                'phone' => '01822334455',
                'department' => 'Central Pharmacy',
                'designation' => 'Head Pharmacist (B.Pharm, M.Pharm)',
            ]
        );

        $doctor = User::updateOrCreate(
            ['email' => 'doctor@bu.edu.bd'],
            [
                'name' => 'Dr. Anisur Rahman',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'university_id' => 'DOC-010',
                'phone' => '01711002233',
                'department' => 'General Medicine',
                'designation' => 'Senior Medical Officer',
            ]
        );

        $patientUser = User::updateOrCreate(
            ['email' => 'patient@bu.edu.bd'],
            [
                'name' => 'Rahman Al-Hasan',
                'password' => Hash::make('password'),
                'role' => 'patient',
                'university_id' => '2022-CSE-011',
                'phone' => '01911223344',
                'department' => 'Computer Science & Engineering',
            ]
        );

        // Patients
        $p1 = Patient::updateOrCreate(
            ['university_id' => '2022-CSE-011'],
            [
                'user_id' => $patientUser->id,
                'first_name' => 'Rahman',
                'last_name' => 'Al-Hasan',
                'dob' => '2002-05-14',
                'gender' => 'Male',
                'blood_group' => 'B+',
                'role_category' => 'student',
                'department' => 'Computer Science & Engineering',
                'email' => 'patient@bu.edu.bd',
                'phone' => '01911223344',
                'is_verified' => true,
            ]
        );

        $p2 = Patient::updateOrCreate(
            ['university_id' => '2023-BBA-044'],
            [
                'first_name' => 'Nadia',
                'last_name' => 'Akter',
                'dob' => '2003-08-22',
                'gender' => 'Female',
                'blood_group' => 'O+',
                'role_category' => 'student',
                'department' => 'Business Administration',
                'email' => 'nadia.akter@bu.edu.bd',
                'phone' => '01755667788',
                'is_verified' => true,
            ]
        );

        // Appointments for stats
        Appointment::updateOrCreate(
            ['appointment_number' => 'APT-2026-0001'],
            ['patient_id' => $p1->id, 'doctor_id' => $doctor->id, 'department' => 'General Medicine', 'appointment_date' => $today, 'time_slot' => '10:00 AM', 'status' => 'confirmed']
        );
        Appointment::updateOrCreate(
            ['appointment_number' => 'APT-2026-0002'],
            ['patient_id' => $p2->id, 'doctor_id' => $doctor->id, 'department' => 'General Medicine', 'appointment_date' => $today, 'time_slot' => '10:30 AM', 'status' => 'confirmed']
        );

        // Medicines: Normal, Low-Stock, and Near-Expiry
        $meds = [
            ['name' => 'Paracetamol 500mg', 'generic_name' => 'Paracetamol', 'category' => 'Analgesic', 'dosage_form' => 'Tablet', 'strength' => '500mg', 'batch_number' => 'PARA-2026-A', 'stock_quantity' => 1200, 'reorder_level' => 200, 'unit' => 'strips', 'expiry_date' => Carbon::now()->addMonths(18)],
            ['name' => 'Amoxicillin 500mg', 'generic_name' => 'Amoxicillin Trihydrate', 'category' => 'Antibiotic', 'dosage_form' => 'Capsule', 'strength' => '500mg', 'batch_number' => 'AMOX-2026-D', 'stock_quantity' => 450, 'reorder_level' => 100, 'unit' => 'capsules', 'expiry_date' => Carbon::now()->addMonths(12)],
            // Low stock
            ['name' => 'Metformin 500mg', 'generic_name' => 'Metformin HCl', 'category' => 'Antidiabetic', 'dosage_form' => 'Tablet', 'strength' => '500mg', 'batch_number' => 'MET-2026-L1', 'stock_quantity' => 15, 'reorder_level' => 30, 'unit' => 'strips', 'expiry_date' => Carbon::now()->addMonths(15)],
            ['name' => 'Azithromycin 500mg', 'generic_name' => 'Azithromycin', 'category' => 'Antibiotic', 'dosage_form' => 'Tablet', 'strength' => '500mg', 'batch_number' => 'AZI-2026-L2', 'stock_quantity' => 10, 'reorder_level' => 25, 'unit' => 'strips', 'expiry_date' => Carbon::now()->addMonths(9)],
            // Near expiry (< 60 days)
            ['name' => 'Oral Rehydration Salts (ORS)', 'generic_name' => 'Electrolyte Powder', 'category' => 'Rehydration', 'dosage_form' => 'Sachet', 'strength' => 'Standard', 'batch_number' => 'ORS-2026-E1', 'stock_quantity' => 150, 'reorder_level' => 50, 'unit' => 'packets', 'expiry_date' => Carbon::now()->addDays(28)],
            ['name' => 'Ciprofloxacin Eye Drops', 'generic_name' => 'Ciprofloxacin 0.3%', 'category' => 'Ophthalmic', 'dosage_form' => 'Drops', 'strength' => '5ml', 'batch_number' => 'CIP-2026-E2', 'stock_quantity' => 40, 'reorder_level' => 15, 'unit' => 'bottles', 'expiry_date' => Carbon::now()->addDays(42)],
        ];

        $medicineModels = [];
        foreach ($meds as $m) {
            $medicineModels[$m['name']] = Medicine::updateOrCreate(['batch_number' => $m['batch_number']], $m);
        }

        // Active Prescription ready for dispensing at the pharmacy desk!
        $rx1 = Prescription::updateOrCreate(
            ['prescription_number' => 'RX-2026-0041'],
            [
                'patient_id' => $p1->id,
                'doctor_id' => $doctor->id,
                'diagnosis' => 'Acute Upper Respiratory Tract Infection',
                'clinical_advice' => 'Complete full 5-day course. Rest and drink fluids.',
                'status' => 'active',
            ]
        );

        PrescriptionItem::updateOrCreate(
            ['prescription_id' => $rx1->id, 'medicine_name' => 'Paracetamol 500mg'],
            [
                'medicine_id' => $medicineModels['Paracetamol 500mg']->id,
                'dosage' => '1+0+1',
                'duration' => '5 days',
                'instructions' => 'After meal',
                'quantity' => 10,
                'is_dispensed' => false,
            ]
        );

        PrescriptionItem::updateOrCreate(
            ['prescription_id' => $rx1->id, 'medicine_name' => 'Amoxicillin 500mg'],
            [
                'medicine_id' => $medicineModels['Amoxicillin 500mg']->id,
                'dosage' => '1+1+1',
                'duration' => '5 days',
                'instructions' => 'After meal',
                'quantity' => 15,
                'is_dispensed' => false,
            ]
        );
    }
}
