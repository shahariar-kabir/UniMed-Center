<?php

use App\Models\Patient;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$patients = Patient::with('user')->get();
foreach ($patients as $p) {
    echo "Patient ID: {$p->id} | Name: {$p->full_name} | Email: {$p->email} | Category: {$p->role_category} | User ID: {$p->user_id} | User Role: ".($p->user ? $p->user->role : 'NO_USER')."\n";
}

$users = User::all();
echo "\n--- USERS ---\n";
foreach ($users as $u) {
    echo "User ID: {$u->id} | Name: {$u->name} | Email: {$u->email} | Role: {$u->role}\n";
}
