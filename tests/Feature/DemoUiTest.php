<?php

test('all prototype demo views render HTTP 200 successfully', function () {
    $routes = [
        '/',
        '/demo',
        '/demo/patient/register',
        '/demo/patient/dashboard',
        '/demo/patient/appointments',
        '/demo/patient/queue',
        '/demo/patient/profile',
        '/demo/doctor/dashboard',
        '/demo/doctor/queue',
        '/demo/doctor/history',
        '/demo/doctor/prescriptions/create',
        '/demo/prescriptions/preview',
        '/demo/pharmacy/dashboard',
        '/demo/pharmacy/inventory',
        '/demo/pharmacy/dispense',
        '/demo/admin/dashboard',
        '/demo/admin/users',
    ];

    foreach ($routes as $uri) {
        $response = $this->get($uri);
        $response->assertStatus(200);
    }
});
