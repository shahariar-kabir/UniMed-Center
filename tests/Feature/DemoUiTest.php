<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public landing page renders successfully', function () {
    $this->get('/')
        ->assertOk()
        ->assertViewIs('home');
});
