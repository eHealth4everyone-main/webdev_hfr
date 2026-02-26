<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function checkCols($table) {
    echo "Columns of $table:\n";
    try {
        $columns = DB::select("SHOW COLUMNS FROM $table");
        foreach ($columns as $col) echo " - " . $col->Field . "\n";
    } catch (\Exception $e) {
        echo " Error: " . $e->getMessage() . "\n";
    }
}

checkCols('im_imagings');
checkCols('pharmacies');
checkCols('laboratory');
