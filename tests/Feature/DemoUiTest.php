<?php

test('all prototype demo views render HTTP 200 successfully', function () {
    $routes = [
        '/',
        '/patient/register',
        '/patient/dashboard',
        '/patient/appointments',
        '/patient/queue',
        '/patient/profile',
        '/doctor/dashboard',
        '/doctor/queue',
        '/doctor/patient-history',
        '/doctor/prescriptions/create',
        '/doctor/prescription/preview',
        '/pharmacy/dashboard',
        '/pharmacy/inventory',
        '/pharmacy/dispense',
        '/admin/dashboard',
        '/admin/users',
    ];

    foreach ($routes as $uri) {
        $response = $this->get($uri);
        $response->assertStatus(200);
    }
});
