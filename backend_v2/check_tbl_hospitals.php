<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = "Columns of tbl_hospitals:\n";
try {
    $columns = DB::select("SHOW COLUMNS FROM tbl_hospitals");
    foreach ($columns as $col) $output .= " - " . $col->Field . "\n";
} catch (\Exception $e) {
    $output .= " Error: " . $e->getMessage() . "\n";
}
file_put_contents('tbl_hospitals_cols.txt', $output);
