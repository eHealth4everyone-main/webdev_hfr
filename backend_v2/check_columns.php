<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$out = "";
$columns = Schema::getColumnListing('hospital_details');
$out .= "hospital_details: " . implode(', ', $columns) . "\n\n";

if (Schema::hasTable('hs_hospitals_history')) {
    $columns = Schema::getColumnListing('hs_hospitals_history');
    $out .= "hs_hospitals_history: " . implode(', ', $columns) . "\n\n";
}

file_put_contents('db_check_results.txt', $out);
echo "Results written to db_check_results.txt\n";
