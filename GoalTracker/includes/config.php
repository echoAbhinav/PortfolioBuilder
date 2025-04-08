<?php
// Application configuration
define('APP_NAME', 'GoalTrack Pro');
define('APP_URL', 'http://localhost/goaltrack-pro');
define('APP_ROOT', dirname(dirname(__FILE__)));

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'goaltrack_pro');

// Start session
session_start();

// Set default timezone
date_default_timezone_set('UTC');

// Include other required files
require_once 'db.php';
require_once 'functions.php';
require_once 'auth.php';
?>