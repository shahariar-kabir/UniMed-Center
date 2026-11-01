<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DemoUiController extends Controller
{
    // Mock patient profile
    private function mockPatient(): array
    {
        return [
            'name' => 'Rahman Al-Hasan',
            'university_id' => '2022-CSE-011',
            'role_category' => 'Undergraduate Student (Year 3)',
            'department' => 'Computer Science & Engineering',
            'blood_group' => 'B+',
            'email' => 'rahman.cse@bu.edu.bd',
            'phone' => '+880 1911-223344',
            'emergency_name' => 'Md. Hasan Ali (Father)',
            'emergency_phone' => '+880 1711-223344',
            'allergies' => 'Penicillin, Shellfish',
            'address' => 'Room 312, Fazlul Huq Hall, University Campus',
            'status' => 'Verified Student',
        ];
    }

    // 1. Landing Page
    public function home(): View
    {
        return view('demo.home');
    }

    // 2. Patient Registration Form (UI Idea)
    public function patientRegister(): View
    {
        return view('demo.patient-register');
    }

    // 3. Patient Dashboard
    public function patientDashboard(): View
    {
        $patient = $this->mockPatient();

        return view('demo.patient-dashboard', compact('patient'));
    }

    // 4. Patient Appointments Booking UI
    public function appointmentBooking(): View
    {
        $patient = $this->mockPatient();

        return view('demo.appointment-booking', compact('patient'));
    }

    // 5. Patient Live Queue UI
    public function liveQueue(): View
    {
        $patient = $this->mockPatient();

        return view('demo.live-queue', compact('patient'));
    }

    // 6. Patient Profile UI
    public function patientProfile(): View
    {
        $patient = $this->mockPatient();

        return view('demo.patient-profile', compact('patient'));
    }

    // 7. Doctor Consultation Dashboard UI
    public function doctorDashboard(): View
    {
        return view('demo.doctor-dashboard');
    }

    // 8. Doctor Queue Management UI
    public function doctorQueue(): View
    {
        return view('demo.doctor-queue');
    }

    // 9. Doctor Patient History UI
    public function doctorPatientHistory(): View
    {
        $patient = $this->mockPatient();

        return view('demo.doctor-patient-history', compact('patient'));
    }

    // 10. Doctor Prescription Creator UI
    public function doctorPrescriptionCreate(): View
    {
        $patient = $this->mockPatient();

        return view('demo.doctor-prescription-create', compact('patient'));
    }

    // 11. Prescription Preview & PDF Layout UI
    public function prescriptionPreview(): View
    {
        $patient = $this->mockPatient();

        return view('demo.prescription-preview', compact('patient'));
    }

    // 12. Pharmacy Dashboard UI
    public function pharmacyDashboard(): View
    {
        return view('demo.pharmacy-dashboard');
    }

    // 13. Pharmacy Medicine Inventory UI
    public function pharmacyInventory(): View
    {
        return view('demo.pharmacy-inventory');
    }

    // 14. Pharmacy Dispense Desk UI
    public function pharmacyDispense(): View
    {
        return view('demo.pharmacy-dispense');
    }

    // 15. Admin Executive Analytics Dashboard UI
    public function adminDashboard(): View
    {
        return view('demo.admin-dashboard');
    }

    // 16. Admin User Management UI
    public function adminUsers(): View
    {
        return view('demo.admin-users');
    }
}
