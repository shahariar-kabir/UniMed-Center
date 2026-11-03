<?php

use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('home page renders successfully with services', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('University Medical Centre');
    $response->assertSee('Core Medical Centre Services');
});

test('login page renders with quick demo role buttons', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Portal Login');
    $response->assertSee('Patient Portal');
    $response->assertSee('Doctor Consultation Desk');
});

test('quick login allows instant role-based authentication', function () {
    $response = $this->get(route('login.demo', 'patient'));

    $response->assertRedirect(route('patient.dashboard'));
    $this->assertAuthenticated();
});

test('patient can access dashboard, live queue, and view prescriptions', function () {
    $patientUser = User::where('role', 'patient')->first();
    $this->actingAs($patientUser);

    // Dashboard
    $this->get(route('patient.dashboard'))
        ->assertStatus(200)
        ->assertSee('Patient Portal');

    // Live Queue
    $this->get(route('patient.queue'))
        ->assertStatus(200)
        ->assertSee('Live Consultation Queue Tracking');

    // Prescriptions Portal
    $this->get(route('patient.prescriptions'))
        ->assertStatus(200)
        ->assertSee('Digital Prescription Portal');
});

test('patient can download digital prescription pdf', function () {
    $patientUser = User::where('role', 'patient')->first();
    $this->actingAs($patientUser);

    $prescription = Prescription::first();

    $response = $this->get(route('patient.prescriptions.pdf', $prescription->id));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('public and guest users can book an appointment and receive a reference number and queue token', function () {
    $response = $this->post('/appointments', [
        'university_id' => '2024-CSE-999',
        'patient_name' => 'Tanvir Hasan',
        'department' => 'General Medicine',
        'date' => now()->toDateString(),
        'time' => '11:00',
        'reason' => 'Seasonal cough and throat pain',
    ]);

    $response->assertRedirect('/appointments');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('patients', [
        'university_id' => '2024-CSE-999',
    ]);

    $this->assertDatabaseHas('appointments', [
        'department' => 'General Medicine',
        'time_slot' => '11:00',
    ]);
});

test('doctor can manage consultation queue and inspect patient history', function () {
    $doctorUser = User::where('role', 'doctor')->first();
    $this->actingAs($doctorUser);

    // Doctor queue
    $this->get(route('doctor.queue'))
        ->assertStatus(200)
        ->assertSee('Patient Consultation Queue Management');

    // Patient History
    $patient = Patient::first();
    $this->get(route('doctor.patients.history', $patient->id))
        ->assertStatus(200)
        ->assertSee($patient->full_name);
});

test('doctor can generate a digital prescription from stock', function () {
    $doctorUser = User::where('role', 'doctor')->first();
    $this->actingAs($doctorUser);

    $patient = Patient::first();
    $med = Medicine::first();

    $response = $this->post(route('doctor.prescriptions.store'), [
        'patient_id' => $patient->id,
        'diagnosis' => 'Acute Gastritis',
        'bp' => '120/80',
        'pulse' => '72',
        'temperature' => '98.4',
        'weight' => '65',
        'clinical_advice' => 'Avoid spicy food for 1 week.',
        'medicines' => [
            [
                'medicine_id' => $med->id,
                'medicine_name' => $med->name,
                'dosage' => '1+0+1',
                'duration' => '5 days',
                'instructions' => 'After meal',
                'quantity' => 10,
            ],
        ],
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('prescriptions', [
        'patient_id' => $patient->id,
        'diagnosis' => 'Acute Gastritis',
    ]);
});

test('pharmacist can view inventory and dispense prescriptions', function () {
    $pharmacistUser = User::where('role', 'pharmacist')->first();
    $this->actingAs($pharmacistUser);

    // Inventory
    $this->get(route('pharmacy.inventory'))
        ->assertStatus(200)
        ->assertSee('Medicine Inventory Control');

    // Dispense Desk
    $this->get(route('pharmacy.dispense'))
        ->assertStatus(200)
        ->assertSee('Prescription Dispensing');

    // Dispense action
    $prescription = Prescription::where('status', 'active')->first();
    if ($prescription) {
        $this->post(route('pharmacy.dispense.store', $prescription->id))
            ->assertRedirect();

        $this->assertEquals('dispensed', $prescription->fresh()->status);
    }
});

test('admin can access operational analytics and user management', function () {
    $adminUser = User::where('role', 'admin')->first();
    $this->actingAs($adminUser);

    // Admin Dashboard
    $this->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('Executive Analytics Dashboard');

    // User Management
    $this->get(route('admin.users'))
        ->assertStatus(200)
        ->assertSee('User Management & Role Authorization');
});

test('admin registration page renders successfully', function () {
    $response = $this->get(route('admin.register'));

    $response->assertStatus(200);
    $response->assertSee('Administrator Registration');
});

test('administrator can register and is logged into admin dashboard', function () {
    $response = $this->post(route('admin.register.post'), [
        'name' => 'Prof. Dr. Zahidul Islam',
        'email' => 'zahidul.admin@bu.edu.bd',
        'university_id' => 'EMP-ADM-777',
        'phone' => '01711223344',
        'designation' => 'Chief Medical Officer',
        'department' => 'Medical Administration',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'zahidul.admin@bu.edu.bd',
        'role' => 'admin',
        'university_id' => 'EMP-ADM-777',
    ]);
});

test('registered admin can log in via login page', function () {
    User::create([
        'name' => 'Dr. Farhana Yasmin',
        'email' => 'farhana.admin@bu.edu.bd',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'university_id' => 'EMP-ADM-888',
        'phone' => '01888112233',
        'designation' => 'Health Services Director',
        'is_active' => true,
    ]);

    $response = $this->post(route('login.post'), [
        'email' => 'farhana.admin@bu.edu.bd',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticated();
});

test('doctor can register and is logged into doctor dashboard', function () {
    $response = $this->post(route('doctor.register.post'), [
        'name' => 'Dr. Rafiqul Hassan',
        'email' => 'rafiqul.doctor@bu.edu.bd',
        'university_id' => 'DOC-MED-999',
        'phone' => '01711998877',
        'department' => 'General Medicine',
        'designation' => 'Senior Medical Officer',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect(route('doctor.dashboard'));
    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'rafiqul.doctor@bu.edu.bd',
        'role' => 'doctor',
        'university_id' => 'DOC-MED-999',
    ]);
});

test('pharmacist can register and is logged into pharmacy dashboard', function () {
    $response = $this->post(route('pharmacy.register.post'), [
        'name' => 'Kazi Kamrul',
        'email' => 'kamrul.pharma@bu.edu.bd',
        'university_id' => 'PHARM-888',
        'phone' => '01888776655',
        'designation' => 'Clinical Pharmacist',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect(route('pharmacy.dashboard'));
    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'kamrul.pharma@bu.edu.bd',
        'role' => 'pharmacist',
        'university_id' => 'PHARM-888',
    ]);
});

test('emergency booking allows reserving an emergency shift slot', function () {
    $doctor = User::create([
        'name' => 'Dr. Emergency MO',
        'email' => 'emergency.mo@bu.edu.bd',
        'password' => Hash::make('password123'),
        'role' => 'doctor',
        'department' => 'General Medicine',
        'is_active' => true,
    ]);

    $response = $this->post('/appointments', [
        'patient_name' => 'Tariq Emergency',
        'university_id' => 'EMERG-STU-001',
        'department' => 'General Medicine',
        'doctor' => $doctor->id,
        'date' => now()->toDateString(),
        'time' => '22:00',
        'reason' => 'Acute chest pain and severe asthma attack',
    ]);

    $response->assertRedirect('/appointments');
    $this->assertDatabaseHas('appointments', [
        'time_slot' => '22:00',
        'department' => 'General Medicine',
    ]);
});

test('regular patient appointment booking blocks emergency shift slot', function () {
    $user = User::create([
        'name' => 'Nabila Regular',
        'email' => 'nabila.reg@bu.edu.bd',
        'password' => Hash::make('password123'),
        'role' => 'patient',
        'university_id' => 'REG-STU-002',
    ]);

    Patient::create([
        'user_id' => $user->id,
        'first_name' => 'Nabila',
        'last_name' => 'Regular',
        'university_id' => 'REG-STU-002',
        'email' => 'nabila.reg@bu.edu.bd',
        'role_category' => 'student',
        'dob' => '2002-05-15',
        'gender' => 'Female',
        'phone' => '01700112233',
        'is_verified' => true,
    ]);

    $response = $this->actingAs($user)->post(route('patient.appointments.store'), [
        'department' => 'General Medicine',
        'appointment_date' => now()->addDay()->toDateString(),
        'time_slot' => '22:00',
        'reason' => 'Routine checkup',
    ]);

    $response->assertSessionHas('error');
    $this->assertDatabaseMissing('appointments', [
        'time_slot' => '22:00',
        'reason' => 'Routine checkup',
    ]);
});

test('same email can be registered and used for multiple roles', function () {
    $sharedEmail = 'dual.identity@bu.edu.bd';

    // 1. Register as Doctor
    $docResponse = $this->post(route('doctor.register.post'), [
        'name' => 'Dr. Dual Role',
        'email' => $sharedEmail,
        'university_id' => 'DOC-DUAL-001',
        'department' => 'General Medicine',
        'designation' => 'Medical Officer',
        'phone' => '01711223399',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);
    $docResponse->assertRedirect(route('doctor.dashboard'));
    $this->assertEquals('doctor', Auth::user()->role);

    Auth::logout();

    // 2. Register as Patient with the EXACT SAME EMAIL
    $patResponse = $this->post(route('patients.register.post'), [
        'first_name' => 'Dual',
        'last_name' => 'Patient',
        'university_id' => '0802000000000001',
        'dob' => '2000-01-01',
        'gender' => 'Male',
        'role' => 'student',
        'department' => 'CSE',
        'year' => 'Summer 26',
        'email' => $sharedEmail,
        'phone' => '01711223399',
        'declaration' => '1',
    ]);
    $patResponse->assertRedirect(route('patient.dashboard'));
    $this->assertEquals('patient', Auth::user()->role);

    // Verify both records coexist in the database with the same email
    $this->assertDatabaseHas('users', ['email' => $sharedEmail, 'role' => 'doctor']);
    $this->assertDatabaseHas('users', ['email' => $sharedEmail, 'role' => 'patient']);

    // 3. Test switching roles while logged in
    $switchResponse = $this->post(route('role.switch', 'doctor'));
    $switchResponse->assertRedirect(route('doctor.dashboard'));
    $this->assertEquals('doctor', Auth::user()->role);

    Auth::logout();

    // 4. Test login with explicit role selection
    $loginDoc = $this->post(route('login.post'), [
        'email' => $sharedEmail,
        'password' => 'secret123',
        'role' => 'doctor',
    ]);
    $loginDoc->assertRedirect(route('doctor.dashboard'));
    $this->assertEquals('doctor', Auth::user()->role);
});
