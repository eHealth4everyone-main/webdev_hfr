<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sqlFile = $argv[1] ?? 'restore_views.sql';
if (!file_exists($sqlFile)) {
    die("File $sqlFile not found\n");
}

echo "Running $sqlFile...\n";
$queries = file_get_contents($sqlFile);
$statements = array_filter(array_map('trim', explode(';', $queries)));

foreach ($statements as $statement) {
    if (empty($statement)) continue;
    try {
        DB::unprepared($statement);
        echo "Executed: " . substr($statement, 0, 50) . "...\n";
    } catch (\Exception $e) {
        echo "Error executing statement: " . $e->getMessage() . "\n";
    }
}
echo "Finished running $sqlFile.\n";
