<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('hs_facility_certificates')) {
    Schema::create('hs_facility_certificates', function (Blueprint $table) {
        $table->id();
        $table->integer('hospital_id');
        $table->string('certificate_no')->unique();
        $table->date('issue_date');
        $table->date('expiry_date');
        $table->integer('issued_by');
        $table->string('status')->default('valid');
        $table->timestamps();
    });
    echo "Table hs_facility_certificates created successfully.";
} else {
    echo "Table hs_facility_certificates already exists.";
}
