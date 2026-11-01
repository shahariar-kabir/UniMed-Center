<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\MedicalQueue;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // 1. Users
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

        $doctor3 = User::updateOrCreate(
            ['email' => 'doctor3@bu.edu.bd'],
            [
                'name' => 'Dr. Abdur Karim',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'university_id' => 'DOC-012',
                'phone' => '01711002255',
                'department' => 'Dental',
                'designation' => 'Dental Surgeon (BDS, PGT)',
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
                'designation' => 'Undergraduate Student (Year 3)',
            ]
        );

        // 2. Patient Profiles
        $p1 = Patient::updateOrCreate(
            ['university_id' => '2022-CSE-011'],
            [
                'user_id' => $patientUser->id,
                'first_name' => 'Rahman',
                'last_name' => 'Al-Hasan',
                'dob' => '2002-05-14',
                'gender' => 'Male',
                'blood_group' => 'B+',
                'nationality' => 'Bangladeshi',
                'role_category' => 'student',
                'department' => 'Computer Science & Engineering',
                'year_semester' => 'Year 3, Semester 5',
                'email' => 'patient@bu.edu.bd',
                'phone' => '01911223344',
                'emergency_name' => 'Md. Hasan Ali (Father)',
                'emergency_phone' => '01711223344',
                'address' => 'Room 312, Fazlul Huq Hall, University Campus',
                'allergies' => 'Penicillin, Shellfish',
                'conditions' => ['Asthma / Respiratory', 'Allergic Rhinitis'],
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
                'nationality' => 'Bangladeshi',
                'role_category' => 'student',
                'department' => 'Business Administration',
                'year_semester' => 'Year 2, Semester 3',
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
                'nationality' => 'Bangladeshi',
                'role_category' => 'student',
                'department' => 'Electrical & Electronic Engineering',
                'year_semester' => 'Year 4, Semester 8',
                'email' => 'tanvir.eee@bu.edu.bd',
                'phone' => '01633445566',
                'is_verified' => true,
            ]
        );

        // 3. Appointments
        $apt1 = Appointment::updateOrCreate(
            ['appointment_number' => 'APT-2026-0001'],
            [
                'patient_id' => $p1->id,
                'doctor_id' => $doctor1->id,
                'department' => 'General Medicine',
                'appointment_date' => $today,
                'time_slot' => '10:00 AM - 10:30 AM',
                'reason' => 'Persistent seasonal dry cough, mild sore throat and fever for 2 days.',
                'status' => 'confirmed',
            ]
        );

        $apt2 = Appointment::updateOrCreate(
            ['appointment_number' => 'APT-2026-0002'],
            [
                'patient_id' => $p2->id,
                'doctor_id' => $doctor1->id,
                'department' => 'General Medicine',
                'appointment_date' => $today,
                'time_slot' => '10:30 AM - 11:00 AM',
                'reason' => 'Severe acute migraine headache with nausea.',
                'status' => 'confirmed',
            ]
        );

        $apt3 = Appointment::updateOrCreate(
            ['appointment_number' => 'APT-2026-0003'],
            [
                'patient_id' => $p3->id,
                'doctor_id' => $doctor3->id,
                'department' => 'Dental',
                'appointment_date' => $today,
                'time_slot' => '11:00 AM - 11:30 AM',
                'reason' => 'Tooth cavity check-up.',
                'status' => 'confirmed',
            ]
        );

        // 4. Medical Queues for today
        MedicalQueue::updateOrCreate(
            ['token_number' => 'T-101', 'queue_date' => $today],
            [
                'patient_id' => $p1->id,
                'doctor_id' => $doctor1->id,
                'appointment_id' => $apt1->id,
                'department' => 'General Medicine',
                'status' => 'waiting',
            ]
        );

        MedicalQueue::updateOrCreate(
            ['token_number' => 'T-102', 'queue_date' => $today],
            [
                'patient_id' => $p2->id,
                'doctor_id' => $doctor1->id,
                'appointment_id' => $apt2->id,
                'department' => 'General Medicine',
                'status' => 'in_consultation',
                'called_at' => Carbon::now()->subMinutes(8),
            ]
        );

        MedicalQueue::updateOrCreate(
            ['token_number' => 'T-103', 'queue_date' => $today],
            [
                'patient_id' => $p3->id,
                'doctor_id' => $doctor3->id,
                'appointment_id' => $apt3->id,
                'department' => 'Dental',
                'status' => 'waiting',
            ]
        );
    }
}
