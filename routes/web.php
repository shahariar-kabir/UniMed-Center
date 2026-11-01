<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public & Landing
Route::get('/', function () {
    if (Auth::check() && Auth::user()->isDoctor()) {
        return redirect()->route('doctor.dashboard');
    }

    return redirect()->route('login');
})->name('home');

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
    Route::get('/patient/prescriptions', [DoctorController::class, 'patientPrescriptions'])->name('patient.prescriptions');
});
