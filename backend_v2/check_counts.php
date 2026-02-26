<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "hs_hospitals count: " . DB::table('hs_hospitals')->count() . PHP_EOL;
echo "hs_hospitals_history count: " . DB::table('hs_hospitals_history')->count() . PHP_EOL;
echo "hospital_details count: " . DB::table('hospital_details')->count() . PHP_EOL;
