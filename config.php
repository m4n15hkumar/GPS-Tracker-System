<?php
// config.php - MUST be in C:\xampp\htdocs\gps-tracker\
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gps_tracker');

// Error handling
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/php-errors.log');
?>