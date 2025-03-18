<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Task.php';

class AdminController {
    private $userModel;
    private $taskModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->taskModel = new Task($pdo);
    }

    // Fetch all users
    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    // Fetch all tasks
    public function getAllTasks() {
        return $this->taskModel->getAllTasks();
    }

    // Update user role
    public function updateUserRole($userId, $role) {
        if (empty($userId) || empty($role)) {
            return "Invalid request.";
        }
        return $this->userModel->updateUserRole($userId, $role);
    }

    // Delete a user
    public function deleteUser($userId) {
        if (empty($userId)) {
            return "Invalid request.";
        }
        return $this->userModel->deleteUser($userId);
    }

    // Delete a task
    public function deleteTask($taskId) {
        if (empty($taskId)) {
            return "Invalid request.";
        }
        return $this->taskModel->deleteTask($taskId);
    }
}

// Initialize AdminController instance
$adminController = new AdminController($pdo);
?>
