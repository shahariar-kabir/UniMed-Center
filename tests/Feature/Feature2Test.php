<?php

use App\Models\MedicalQueue;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;

beforeEach(function () {
    $this->seed();
});

test('doctor demo login works and accesses doctor desk', function () {
    $response = $this->get('/login/demo/doctor');
    $response->assertRedirect('/doctor/dashboard');
    $this->assertAuthenticated();
});

test('doctor can view queue, call patient and inspect history', function () {
    $doctor = User::where('role', 'doctor')->first();
    $this->actingAs($doctor);

    $this->get('/doctor/dashboard')->assertStatus(200);
    $this->get('/doctor/queue')->assertStatus(200);

    $patient = Patient::first();
    $this->get("/doctor/patients/{$patient->id}/history")->assertStatus(200);

    $queue = MedicalQueue::where('status', 'waiting')->first();
    if ($queue) {
        $call = $this->post("/doctor/queue/{$queue->id}/call");
        $call->assertRedirect();
        expect($queue->fresh()->status)->toBe('in_consultation');
    }
});

test('doctor can generate prescription and export PDF', function () {
    $doctor = User::where('role', 'doctor')->first();
    $patient = Patient::first();
    $med = Medicine::first();
    $this->actingAs($doctor);

    $this->get('/doctor/prescriptions/create')->assertStatus(200);

    $postData = [
        'patient_id' => $patient->id,
        'diagnosis' => 'Acute Pharyngitis & Mild Fever',
        'bp' => '120/80',
        'pulse' => '78',
        'clinical_advice' => 'Plenty of fluids and rest',
        'medicines' => [
            [
                'medicine_id' => $med->id,
                'medicine_name' => $med->name,
                'dosage' => '1+0+1',
                'duration' => '5 days',
                'instructions' => 'After meals',
                'quantity' => 10,
            ],
        ],
    ];

    $response = $this->post('/doctor/prescriptions', $postData);
    $response->assertRedirect();

    $rx = Prescription::latest('id')->first();
    expect($rx)->not->toBeNull();

    // View & PDF
    $this->get("/prescriptions/{$rx->id}")->assertStatus(200);
    $this->get("/prescriptions/{$rx->id}/pdf")->assertStatus(200);
});
