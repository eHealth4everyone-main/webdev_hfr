<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Checking tables for ambulance_services...\n";

$tables = ['hs_hospitals', 'hs_hospitals_history'];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        if (!Schema::hasColumn($table, 'ambulance_services')) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('ambulance_services')->nullable()->after('status_id');
            });
            echo "Column 'ambulance_services' added to $table.\n";
        } else {
            echo "Column 'ambulance_services' already exists in $table.\n";
        }
    } else {
        echo "Table $table does not exist.\n";
    }
}
