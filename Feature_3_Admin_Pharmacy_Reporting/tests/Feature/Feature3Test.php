<?php

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\User;

beforeEach(function () {
    $this->seed();
});

test('admin can access dashboard and manage users', function () {
    $admin = User::where('role', 'admin')->first();
    $this->actingAs($admin);

    $this->get('/admin/dashboard')->assertStatus(200);
    $this->get('/admin/users')->assertStatus(200);

    $newUser = [
        'name' => 'Dr. Test Physician',
        'email' => 'dr.test@bu.edu.bd',
        'role' => 'doctor',
        'password' => 'password123',
        'department' => 'Cardiology',
    ];

    $this->post('/admin/users', $newUser)->assertSessionHas('success');
    expect(User::where('email', 'dr.test@bu.edu.bd')->exists())->toBeTrue();
});

test('pharmacist can view inventory, update stock and dispense prescription', function () {
    $pharmacist = User::where('role', 'pharmacist')->first();
    $this->actingAs($pharmacist);

    $this->get('/pharmacy/dashboard')->assertStatus(200);
    $this->get('/pharmacy/inventory')->assertStatus(200);
    $this->get('/pharmacy/dispense')->assertStatus(200);

    // Adjust medicine stock
    $med = Medicine::first();
    $initialStock = $med->stock_quantity;
    $this->post("/pharmacy/inventory/{$med->id}/stock", [
        'adjustment' => 50,
        'action' => 'add',
    ])->assertSessionHas('success');

    expect($med->fresh()->stock_quantity)->toBe($initialStock + 50);

    // Dispense an active prescription
    $rx = Prescription::where('status', 'active')->first();
    if ($rx) {
        $this->post("/pharmacy/dispense/{$rx->id}")->assertSessionHas('success');
        expect($rx->fresh()->status)->toBe('dispensed');
    }
});
