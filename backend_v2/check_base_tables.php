<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$baseTables = ['pharmacies', 'lb_laboratories', 'im_imagings', 'dhis_log'];
foreach ($baseTables as $table) {
    if (Schema::hasTable($table)) {
        echo "Table $table exists.\n";
    } else {
        echo "Table $table MISSING.\n";
    }
}
echo "Full table list:\n";
$tables = DB::select('SHOW TABLES');
foreach ($tables as $t) {
    foreach ($t as $v) echo " - $v\n";
}
