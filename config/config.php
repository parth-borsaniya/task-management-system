<?php
// Ensure session is started only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define database credentials
define('DB_HOST', 'localhost');    // Database Host (usually localhost)
define('DB_USER', 'root');         // MySQL Username (default: root)
define('DB_PASS', 'Parth');             // MySQL Password (default: empty)
define('DB_NAME', 'task_management'); // Database Name

// Establish Database Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Define Base URL (For asset linking)
define('BASE_URL', 'http://localhost/task-management-system/');

// Set default timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting (Turn Off in Production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
