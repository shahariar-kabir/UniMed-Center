<?php

namespace Database\Seeders;

use App\Models\MedicalQueue;
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

        // Doctors
        $doctor1 = User::updateOrCreate(
            ['email' => 'doctor@bu.edu.bd'],
            [
                'name' => 'Dr. Anisur Rahman',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'university_id' => 'DOC-010',
                'phone' => '01711002233',
                'department' => 'General Medicine',
                'designation' => 'Senior Medical Officer (MBBS, FCPS)',
            ]
        );

        $doctor2 = User::updateOrCreate(
            ['email' => 'doctor2@bu.edu.bd'],
            [
                'name' => 'Dr. Nusrat Sultana',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'university_id' => 'DOC-011',
                'phone' => '01711002244',
                'department' => 'Gynaecology',
                'designation' => 'Consultant Physician (MBBS, DGO)',
            ]
        );

        // Patients
        $pUser = User::updateOrCreate(
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

        $p1 = Patient::updateOrCreate(
            ['university_id' => '2022-CSE-011'],
            [
                'user_id' => $pUser->id,
                'first_name' => 'Rahman',
                'last_name' => 'Al-Hasan',
                'dob' => '2002-05-14',
                'gender' => 'Male',
                'blood_group' => 'B+',
                'role_category' => 'student',
                'department' => 'Computer Science & Engineering',
                'email' => 'patient@bu.edu.bd',
                'phone' => '01911223344',
                'allergies' => 'Penicillin, Shellfish',
                'conditions' => ['Asthma / Respiratory'],
                'medications' => 'Salbutamol Inhaler as needed',
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

        $p3 = Patient::updateOrCreate(
            ['university_id' => '2021-EEE-089'],
            [
                'first_name' => 'Tanvir',
                'last_name' => 'Ahmed',
                'dob' => '2001-11-03',
                'gender' => 'Male',
                'blood_group' => 'A+',
                'role_category' => 'student',
                'department' => 'Electrical & Electronic Engineering',
                'email' => 'tanvir.eee@bu.edu.bd',
                'phone' => '01633445566',
                'is_verified' => true,
            ]
        );

        // Medicines catalog for doctor builder
        $meds = [
            ['name' => 'Paracetamol 500mg', 'generic_name' => 'Paracetamol', 'category' => 'Analgesic', 'dosage_form' => 'Tablet', 'strength' => '500mg', 'batch_number' => 'PARA-2026-A', 'stock_quantity' => 1200, 'reorder_level' => 200, 'unit' => 'strips', 'expiry_date' => Carbon::now()->addMonths(18)],
            ['name' => 'Cetirizine 10mg', 'generic_name' => 'Cetirizine Hydrochloride', 'category' => 'Antihistamine', 'dosage_form' => 'Tablet', 'strength' => '10mg', 'batch_number' => 'CET-2026-B', 'stock_quantity' => 500, 'reorder_level' => 100, 'unit' => 'strips', 'expiry_date' => Carbon::now()->addMonths(14)],
            ['name' => 'Omeprazole 20mg', 'generic_name' => 'Omeprazole', 'category' => 'Antacid / PPI', 'dosage_form' => 'Capsule', 'strength' => '20mg', 'batch_number' => 'OMEP-2026-C', 'stock_quantity' => 800, 'reorder_level' => 150, 'unit' => 'capsules', 'expiry_date' => Carbon::now()->addMonths(20)],
            ['name' => 'Amoxicillin 500mg', 'generic_name' => 'Amoxicillin Trihydrate', 'category' => 'Antibiotic', 'dosage_form' => 'Capsule', 'strength' => '500mg', 'batch_number' => 'AMOX-2026-D', 'stock_quantity' => 450, 'reorder_level' => 100, 'unit' => 'capsules', 'expiry_date' => Carbon::now()->addMonths(12)],
            ['name' => 'Salbutamol Inhaler 100mcg', 'generic_name' => 'Salbutamol', 'category' => 'Respiratory', 'dosage_form' => 'Inhaler', 'strength' => '100mcg / puff', 'batch_number' => 'SALB-2026-E', 'stock_quantity' => 85, 'reorder_level' => 25, 'unit' => 'bottles', 'expiry_date' => Carbon::now()->addMonths(16)],
            ['name' => 'Antacid Suspension 200ml', 'generic_name' => 'Aluminium & Magnesium Hydroxide', 'category' => 'Antacid', 'dosage_form' => 'Syrup', 'strength' => '200ml', 'batch_number' => 'ANT-2026-F', 'stock_quantity' => 60, 'reorder_level' => 20, 'unit' => 'bottles', 'expiry_date' => Carbon::now()->addMonths(10)],
        ];

        $medicineModels = [];
        foreach ($meds as $m) {
            $medicineModels[$m['name']] = Medicine::updateOrCreate(['batch_number' => $m['batch_number']], $m);
        }

        // Live Queue for doctor desk
        $q1 = MedicalQueue::updateOrCreate(
            ['token_number' => 'T-101', 'queue_date' => $today],
            [
                'patient_id' => $p1->id,
                'doctor_id' => $doctor1->id,
                'department' => 'General Medicine',
                'status' => 'waiting',
            ]
        );

        $q2 = MedicalQueue::updateOrCreate(
            ['token_number' => 'T-102', 'queue_date' => $today],
            [
                'patient_id' => $p2->id,
                'doctor_id' => $doctor1->id,
                'department' => 'General Medicine',
                'status' => 'in_consultation',
                'called_at' => Carbon::now()->subMinutes(5),
            ]
        );

        $q3 = MedicalQueue::updateOrCreate(
            ['token_number' => 'T-103', 'queue_date' => $today],
            [
                'patient_id' => $p3->id,
                'doctor_id' => $doctor1->id,
                'department' => 'General Medicine',
                'status' => 'waiting',
            ]
        );

        // Past prescriptions for history viewer & PDF
        $rx1 = Prescription::updateOrCreate(
            ['prescription_number' => 'RX-2026-0041'],
            [
                'patient_id' => $p1->id,
                'doctor_id' => $doctor1->id,
                'diagnosis' => 'Acute Upper Respiratory Tract Infection (Pharyngitis)',
                'bp' => '120/80 mmHg',
                'pulse' => '76 bpm',
                'temperature' => '100.2 °F',
                'weight' => '68 kg',
                'clinical_advice' => "Drink warm fluids, saline gargle 3 times daily.\nAvoid cold drinks and dusty environments.\nRest for 3 days.",
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
            ['prescription_id' => $rx1->id, 'medicine_name' => 'Cetirizine 10mg'],
            [
                'medicine_id' => $medicineModels['Cetirizine 10mg']->id,
                'dosage' => '0+0+1',
                'duration' => '5 days',
                'instructions' => 'At bedtime',
                'quantity' => 5,
                'is_dispensed' => false,
            ]
        );
    }
}
