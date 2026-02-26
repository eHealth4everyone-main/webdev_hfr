<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$views = ['pharmacy_details', 'laboratory_details', 'imaging_details'];
foreach ($views as $view) {
    try {
        $count = DB::table($view)->count();
        echo "View $view exists, count: $count\n";
    } catch (\Exception $e) {
        echo "View $view MISSING or ERROR: " . $e->getMessage() . "\n";
    }
}
