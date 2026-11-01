<?php

use App\Http\Controllers\DemoUiController;
use Illuminate\Support\Facades\Route;

// 1. Landing & Home
Route::get('/', [DemoUiController::class, 'home'])->name('demo.home');
Route::get('/patient/register', [DemoUiController::class, 'patientRegister'])->name('demo.patient.register');

// 2. Patient Module UI
Route::prefix('patient')->name('demo.patient.')->group(function () {
    Route::get('/dashboard', [DemoUiController::class, 'patientDashboard'])->name('dashboard');
    Route::get('/appointments', [DemoUiController::class, 'appointmentBooking'])->name('appointments');
    Route::get('/queue', [DemoUiController::class, 'liveQueue'])->name('queue');
    Route::get('/profile', [DemoUiController::class, 'patientProfile'])->name('profile');
});

// 3. Doctor Module UI
Route::prefix('doctor')->name('demo.doctor.')->group(function () {
    Route::get('/dashboard', [DemoUiController::class, 'doctorDashboard'])->name('dashboard');
    Route::get('/queue', [DemoUiController::class, 'doctorQueue'])->name('queue');
    Route::get('/patient-history', [DemoUiController::class, 'doctorPatientHistory'])->name('history');
    Route::get('/prescriptions/create', [DemoUiController::class, 'doctorPrescriptionCreate'])->name('prescription.create');
    Route::get('/prescription/preview', [DemoUiController::class, 'prescriptionPreview'])->name('prescription.preview');
});

// 4. Pharmacy Module UI
Route::prefix('pharmacy')->name('demo.pharmacy.')->group(function () {
    Route::get('/dashboard', [DemoUiController::class, 'pharmacyDashboard'])->name('dashboard');
    Route::get('/inventory', [DemoUiController::class, 'pharmacyInventory'])->name('inventory');
    Route::get('/dispense', [DemoUiController::class, 'pharmacyDispense'])->name('dispense');
});

// 5. Admin Module UI
Route::prefix('admin')->name('demo.admin.')->group(function () {
    Route::get('/dashboard', [DemoUiController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/users', [DemoUiController::class, 'adminUsers'])->name('users');
});
