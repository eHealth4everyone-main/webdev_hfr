<?php
$log = 'storage/logs/laravel.log';
if (file_exists($log)) {
    $lines = file($log);
    $last_lines = array_slice($lines, -20);
    echo implode("", $last_lines);
} else {
    echo "Log file not found";
}
