<?php

namespace App\Middleware;

session_start();

class AuthMiddleware {
    public static function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /src/views/auth/login.php");
            exit();
        }
    }

    public static function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: /index.php");
            exit();
        }
    }
}
