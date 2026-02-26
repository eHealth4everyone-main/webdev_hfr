<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $columns = DB::select("SHOW COLUMNS FROM hospital_details");
    foreach ($columns as $col) echo " - " . $col->Field . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
