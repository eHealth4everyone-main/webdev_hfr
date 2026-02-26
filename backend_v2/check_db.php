<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::select('SHOW TABLES');
echo "Tables in " . DB::getDatabaseName() . ":" . PHP_EOL;
foreach ($tables as $table) {
    foreach ($table as $key => $value) {
        if (strpos($value, 'hs_') === 0 || strpos($value, 'hospital') !== false || strpos($value, 'facility') !== false) {
            echo $value . PHP_EOL;
        }
    }
}
