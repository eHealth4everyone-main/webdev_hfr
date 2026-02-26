<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::select('SHOW TABLES');
$output = "";
foreach ($tables as $t) {
    foreach ($t as $v) $output .= "$v\n";
}
file_put_contents('tables_utf8.txt', $output);
