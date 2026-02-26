<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$res = DB::select('SHOW CREATE VIEW hospital_details');
$def = array_values((array)$res[0])[1]; // The 'Create View' column
file_put_contents('view_definition.sql', $def);
echo "View definition written to view_definition.sql\n";
