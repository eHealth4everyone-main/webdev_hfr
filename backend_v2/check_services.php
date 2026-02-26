<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$columns = Schema::getColumnListing('lst_hosp_services');
echo "Columns: " . implode(', ', $columns) . "\n";

$data = DB::table('lst_hosp_services')->get();
echo "Total Services: " . count($data) . "\n";
foreach ($data as $d) {
    echo "- ID: {$d->id}, Name: " . ($d->name ?? $d->service ?? 'N/A') . ", Category: {$d->service_category_id}\n";
}
