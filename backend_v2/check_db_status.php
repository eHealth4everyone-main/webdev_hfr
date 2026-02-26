<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
echo "All Tables:\n";
foreach ($tables as $table) {
    if (strpos(array_values((array)$table)[0], 'lst_') !== false) {
        echo "- " . array_values((array)$table)[0] . "\n";
    }
}

try {
    $services = DB::table('lst_hosp_services')->limit(5)->get();
    echo "\nlst_hosp_services count: " . DB::table('lst_hosp_services')->count() . "\n";
    foreach ($services as $service) {
        echo " - ID: {$service->id}, Name: {$service->name}, Category: {$service->service_category_id}\n";
    }
} catch (\Exception $e) {
    echo "\nError checking lst_hosp_services: " . $e->getMessage() . "\n";
}
