<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = "";
function checkCols($table, &$output) {
    $output .= "Columns of $table:\n";
    try {
        $columns = DB::select("SHOW COLUMNS FROM $table");
        foreach ($columns as $col) $output .= " - " . $col->Field . "\n";
    } catch (\Exception $e) {
        $output .= " Error: " . $e->getMessage() . "\n";
    }
}

checkCols('pharmacies', $output);
checkCols('tbl_pharmacy', $output);
checkCols('tbl_laboratory', $output);
checkCols('tbl_imaging', $output);

file_put_contents('compare_utf8.txt', $output);
