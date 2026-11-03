<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Route;

// Public & Landing
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication & Registration
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/login/choose-portal', [AuthController::class, 'showChoosePortal'])->name('login.choose-portal');
Route::post('/login/choose-portal', [AuthController::class, 'selectPortal'])->name('login.choose-portal.post');
Route::post('/switch-role/{role}', [AuthController::class, 'switchRole'])->middleware('auth')->name('role.switch');
Route::get('/login/demo/{role}', [AuthController::class, 'quickLogin'])->name('login.demo');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Registration
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->name('admin.register.post');

// Doctor Registration
Route::get('/doctor/register', [AuthController::class, 'showDoctorRegister'])->name('doctor.register');
Route::post('/doctor/register', [AuthController::class, 'registerDoctor'])->name('doctor.register.post');

// Pharmacy Registration
Route::get('/pharmacy/register', [AuthController::class, 'showPharmacyRegister'])->name('pharmacy.register');
Route::post('/pharmacy/register', [AuthController::class, 'registerPharmacy'])->name('pharmacy.register.post');

// Patient Registration
Route::get('/patients/register', fn () => view('patients.register'))->name('patients.register');
Route::post('/patients/register', [AuthController::class, 'registerPatient'])->name('patients.register.post');

// Appointments (Public & Guest Access)
Route::get('/appointments', [PatientController::class, 'publicAppointments'])->name('appointments');
Route::post('/appointments', [PatientController::class, 'publicStoreAppointment'])->name('appointments.store.public');

// Prescriptions (Web view & PDF download)
Route::middleware('auth')->group(function () {
    Route::get('/prescriptions/{prescription}', [PatientController::class, 'showPrescription'])->name('patient.prescriptions.show');
    Route::get('/prescriptions/{prescription}/pdf', [PatientController::class, 'downloadPrescriptionPdf'])->name('patient.prescriptions.pdf');
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

// Pharmacy Module
Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacy')->name('pharmacy.')->group(function () {
    Route::get('/dashboard', [PharmacyController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventory', [PharmacyController::class, 'inventory'])->name('inventory');
    Route::post('/inventory', [PharmacyController::class, 'storeMedicine'])->name('inventory.store');
    Route::post('/inventory/{medicine}/stock', [PharmacyController::class, 'updateStock'])->name('inventory.stock');
    Route::get('/dispense', [PharmacyController::class, 'dispenseList'])->name('dispense');
    Route::post('/dispense/{prescription}', [PharmacyController::class, 'dispense'])->name('dispense.store');
});

// Administrator Module
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
});
