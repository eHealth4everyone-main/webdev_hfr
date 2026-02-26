<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = DB::select('SHOW COLUMNS FROM hs_hospitals');
$output = "";
foreach ($columns as $col) {
    $output .= $col->Field . "\n";
}
file_put_contents('columns_hs_hospitals.txt', $output);
echo "Columns of hs_hospitals written to columns_hs_hospitals.txt\n";
