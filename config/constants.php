<?php
// Base URL of the project
define('BASE_URL', 'http://localhost/task-management-system/');

// Database Configuration (If needed separately)
define('DB_HOST', 'localhost');
define('DB_NAME', 'task_management');
define('DB_USER', 'root');
define('DB_PASS', '');

// User Roles
define('ROLE_ADMIN', 'admin');
define('ROLE_USER', 'user');

// Task Statuses
define('STATUS_PENDING', 'Pending');
define('STATUS_IN_PROGRESS', 'In Progress');
define('STATUS_PAST_DUE', 'Past Due');
define('STATUS_COMPLETED', 'Completed');

// Task Priorities
define('PRIORITY_LOW', 'Low');
define('PRIORITY_MEDIUM', 'Medium');
define('PRIORITY_HIGH', 'High');

// Email Notification Settings
define('EMAIL_FROM', 'noreply@taskmanager.com'); // Update this with actual email
define('EMAIL_NAME', 'Task Manager');

// Security
define('TOKEN_SECRET', 'your_random_secret_key'); // Change this for CSRF protection

?>
