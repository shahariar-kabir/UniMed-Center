<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public & Landing
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->isPharmacist()) {
            return redirect()->route('pharmacy.dashboard');
        }
    }

    return redirect()->route('login');
})->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/login/demo/{role}', [AuthController::class, 'quickLogin'])->name('login.demo');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pharmacy & Inventory Module
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
