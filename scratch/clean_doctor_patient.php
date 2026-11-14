<?php

use App\Models\Patient;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$p = Patient::find(2);
if ($p && $p->user_id == 30001) {
    $p->delete();
    echo "Deleted erroneous doctor-linked patient record #2\n";
} else {
    echo "Patient #2 not found or user_id mismatch\n";
}
