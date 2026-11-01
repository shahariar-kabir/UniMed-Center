<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemoUiController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Models\Appointment;
use App\Models\MedicalQueue;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public landing page and UI prototype pages.
Route::get('/', [DemoUiController::class, 'home'])->name('home');
Route::get('/demo', [DemoUiController::class, 'home'])->name('demo.home');
Route::prefix('demo')->name('demo.')->controller(DemoUiController::class)->group(function () {
    Route::get('/patient/register', 'patientRegister')->name('patient.register');
    Route::get('/patient/dashboard', 'patientDashboard')->name('patient.dashboard');
    Route::get('/patient/appointments', 'appointmentBooking')->name('patient.appointments');
    Route::get('/patient/queue', 'liveQueue')->name('patient.queue');
    Route::get('/patient/profile', 'patientProfile')->name('patient.profile');
    Route::get('/doctor/dashboard', 'doctorDashboard')->name('doctor.dashboard');
    Route::get('/doctor/queue', 'doctorQueue')->name('doctor.queue');
    Route::get('/doctor/history', 'doctorPatientHistory')->name('doctor.history');
    Route::get('/doctor/prescriptions/create', 'doctorPrescriptionCreate')->name('doctor.prescription.create');
    Route::get('/prescriptions/preview', 'prescriptionPreview')->name('doctor.prescription.preview');
    Route::get('/pharmacy/dashboard', 'pharmacyDashboard')->name('pharmacy.dashboard');
    Route::get('/pharmacy/inventory', 'pharmacyInventory')->name('pharmacy.inventory');
    Route::get('/pharmacy/dispense', 'pharmacyDispense')->name('pharmacy.dispense');
    Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');
    Route::get('/admin/users', 'adminUsers')->name('admin.users');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/login/demo/{role}', [AuthController::class, 'quickLogin'])->name('login.demo');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Doctor Module
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/queue', [DoctorController::class, 'queue'])->name('queue');
    Route::post('/queue/{queue}/call', [DoctorController::class, 'callPatient'])->name('queue.call');
    Route::post('/queue/{queue}/complete', [DoctorController::class, 'completeConsultation'])->name('queue.complete');
    Route::post('/queue/{queue}/skip', [DoctorController::class, 'skipPatient'])->name('queue.skip');
    Route::get('/patients/{patient}/history', [DoctorController::class, 'patientHistory'])->name('patients.history');
    Route::get('/prescriptions/create', [DoctorController::class, 'createPrescription'])->name('prescriptions.create');
    Route::post('/prescriptions', [DoctorController::class, 'storePrescription'])->name('prescriptions.store');
});

// Prescription View & PDF (Authorized)
Route::middleware('auth')->group(function () {
    Route::get('/prescriptions/{prescription}', [DoctorController::class, 'showPrescription'])->name('patient.prescriptions.show');
    Route::get('/prescriptions/{prescription}/pdf', [DoctorController::class, 'downloadPrescriptionPdf'])->name('patient.prescriptions.pdf');
});

// Patient Registration
Route::get('/patients/register', fn () => view('patients.register'))->name('patients.register');
Route::post('/patients/register', [AuthController::class, 'registerPatient'])->name('patients.register.post');

// Appointments (Public bridge)
Route::get('/appointments', function () {
    if (Auth::check() && Auth::user()->isPatient()) {
        return redirect()->route('patient.appointments');
    }

    $doctors = User::where('role', 'doctor')->where('is_active', true)->get();
    $recentAppointments = Appointment::with(['doctor', 'patient'])->latest()->take(6)->get();

    return view('appointments.index', compact('doctors', 'recentAppointments'));
})->name('appointments');

Route::post('/appointments', function (Request $request) {
    $appointmentDate = $request->input('appointment_date') ?: $request->input('date');
    $timeSlot = $request->input('time_slot') ?: $request->input('time');
    $patientName = $request->input('patient_name');
    $universityId = $request->input('university_id');
    $department = $request->input('department');
    $doctorId = $request->input('doctor_id') ?: $request->input('doctor');
    $reason = $request->input('reason');

    $request->merge([
        'appointment_date' => $appointmentDate,
        'time_slot' => $timeSlot,
    ]);

    $request->validate([
        'department' => 'required|string',
        'appointment_date' => 'required|date|after_or_equal:today',
        'time_slot' => 'required|string',
    ]);

    if (Auth::check()) {
        $user = Auth::user();
        $patient = $user->patient ?? Patient::where('user_id', $user->id)->first();
        if (! $patient) {
            $nameParts = explode(' ', $user->name, 2);
            $patient = Patient::create([
                'user_id' => $user->id,
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? 'User',
                'university_id' => $user->university_id ?? 'STU-'.str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                'dob' => '2002-01-01',
                'gender' => 'Male',
                'email' => $user->email,
                'phone' => $user->phone ?? '0188888888',
                'is_verified' => true,
            ]);
        }
    } else {
        $request->validate([
            'patient_name' => 'required|string|max:100',
            'university_id' => 'required|string|max:50',
        ]);

        $patient = Patient::where('university_id', $universityId)->first();
        if (! $patient) {
            $nameParts = explode(' ', (string) $patientName, 2);
            $patient = Patient::create([
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? 'User',
                'university_id' => $universityId,
                'dob' => '2002-01-01',
                'gender' => 'Other',
                'email' => strtolower(str_replace(' ', '', (string) $nameParts[0])).'@bu.edu.bd',
                'phone' => '0188888888',
                'role_category' => 'student',
                'is_verified' => true,
            ]);
        }
    }

    $resolvedDoctorId = null;
    if (is_numeric($doctorId)) {
        $resolvedDoctorId = (int) $doctorId;
    } elseif ($doctorId) {
        $doc = User::where('role', 'doctor')
            ->where(function ($q) use ($doctorId) {
                $q->where('department', 'like', "%{$doctorId}%")
                    ->orWhere('name', 'like', "%{$doctorId}%");
            })->first();
        $resolvedDoctorId = $doc?->id;
    }
    if (! $resolvedDoctorId) {
        $doc = User::where('role', 'doctor')
            ->where('department', 'like', "%{$department}%")->first();
        $resolvedDoctorId = $doc?->id ?? User::where('role', 'doctor')->first()?->id;
    }

    $aptCount = Appointment::count() + 1;
    $appointmentNumber = 'APT-'.date('Y').'-'.str_pad((string) $aptCount, 4, '0', STR_PAD_LEFT);

    $appointment = Appointment::create([
        'appointment_number' => $appointmentNumber,
        'patient_id' => $patient->id,
        'doctor_id' => $resolvedDoctorId,
        'department' => $department,
        'appointment_date' => $appointmentDate,
        'time_slot' => $timeSlot,
        'reason' => $reason,
        'status' => 'confirmed',
    ]);

    $queueMsg = '';
    if (Carbon::parse($appointmentDate)->isToday()) {
        $lastToken = MedicalQueue::whereDate('queue_date', Carbon::today())->max('token_number');
        $nextNum = 101;
        if ($lastToken && preg_match('/T-(\d+)/', $lastToken, $matches)) {
            $nextNum = ((int) $matches[1]) + 1;
        }
        $token = "T-{$nextNum}";

        MedicalQueue::create([
            'token_number' => $token,
            'queue_date' => Carbon::today(),
            'patient_id' => $patient->id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'department' => $appointment->department,
            'status' => 'waiting',
        ]);
        $queueMsg = " Live Queue Token assigned: {$token}.";
    }

    return redirect('/appointments')->with('success', "Appointment booked successfully! Reference: {$appointment->appointment_number}. Date: {$appointment->appointment_date->format('d M Y')} at {$appointment->time_slot}.{$queueMsg}");
});

// Patient Module
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::post('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
    Route::get('/queue', [PatientController::class, 'queue'])->name('queue');
    Route::post('/queue/join', [PatientController::class, 'joinQueue'])->name('queue.join');
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    Route::post('/appointments', [PatientController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/prescriptions', [PatientController::class, 'prescriptions'])->name('prescriptions');
});
