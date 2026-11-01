<?php

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;

beforeEach(function () {
    $this->seed();
});

test('guest can access login and appointments page', function () {
    $this->get('/login')->assertStatus(200);
    $this->get('/appointments')->assertStatus(200);
    $this->get('/patients/register')->assertStatus(200);
});

test('patient demo login works and redirects to dashboard', function () {
    $response = $this->get('/login/demo/patient');
    $response->assertRedirect('/patient/dashboard');
    $this->assertAuthenticated();
});

test('patient can access portal, view live queue and book appointments', function () {
    $user = User::where('role', 'patient')->first();
    $this->actingAs($user);

    $this->get('/patient/dashboard')->assertStatus(200);
    $this->get('/patient/profile')->assertStatus(200);
    $this->get('/patient/queue')->assertStatus(200);
    $this->get('/patient/appointments')->assertStatus(200);
    $this->get('/patient/prescriptions')->assertStatus(200);

    // Join walk-in queue or check existing
    $postQueue = $this->post('/patient/queue/join', [
        'department' => 'Dental',
    ]);
    $postQueue->assertRedirect();

    // Book appointment
    $postApt = $this->post('/patient/appointments', [
        'department' => 'General Medicine',
        'appointment_date' => Carbon::tomorrow()->toDateString(),
        'time_slot' => '11:00 AM - 11:30 AM',
        'reason' => 'Routine health checkup',
    ]);
    $postApt->assertRedirect();
    $postApt->assertSessionHas('success');
});
