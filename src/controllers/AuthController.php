<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // User Registration with Role Selection
    public function register($name, $email, $password, $role) {
        // Check if email already exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            return "Email is already registered.";
        }

        // Hash password before storing
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database with selected role
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $role]) ? "success" : "Registration failed.";
    }

    // User Login
    public function login($email, $password) {
        // Check if user exists
        $stmt = $this->pdo->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Store user session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            return "success";
        } else {
            return "Invalid email or password.";
        }
    }

    // Logout User
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../../public/auth/login.php");
        exit();
    }

    // Check if User is Logged In
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Get Logged-in User's Role
    public function getUserRole() {
        return $_SESSION['role'] ?? null;
    }
}
