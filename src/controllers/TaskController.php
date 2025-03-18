<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $taskModel;

    public function __construct($pdo) {
        $this->taskModel = new Task($pdo);
    }

    // Fetch tasks for the logged-in user
    public function getUserTasks($userId) {
        return $this->taskModel->getUserTasks($userId);
    }

    // Create a new task
    public function createTask($title, $description, $dueDate, $priority, $status, $userId) {
        if (empty($title) || empty($description) || empty($dueDate) || empty($priority) || empty($status)) {
            return "All fields are required.";
        }

        return $this->taskModel->createTask($title, $description, $dueDate, $priority, $status, $userId);
    }

    // Edit task details
    public function editTask($taskId, $title, $description, $dueDate, $priority, $status, $userId) {
        if (empty($taskId) || empty($title) || empty($description) || empty($dueDate) || empty($priority) || empty($status)) {
            return "All fields are required.";
        }

        return $this->taskModel->updateTask($taskId, $title, $description, $dueDate, $priority, $status, $userId);
    }

    // Delete a task
    public function deleteTask($taskId, $userId) {
        if (empty($taskId)) {
            return "Task ID is required.";
        }

        return $this->taskModel->deleteTask($taskId, $userId);
    }
}

// Initialize TaskController instance
$taskController = new TaskController($pdo);
?>
