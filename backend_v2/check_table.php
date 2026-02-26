<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = DB::select('DESC hs_hospitals_history');
foreach ($columns as $column) {
    echo $column->Field . ' (' . $column->Type . ')' . PHP_EOL;
}
