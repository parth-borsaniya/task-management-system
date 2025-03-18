<?php
require_once __DIR__ . '/../../config/config.php';

class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch all tasks with user details
    public function getAllTasks($sort = 'due_date') {
        $allowedSorts = ['due_date', 'priority', 'status'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'due_date';
        
        $sql = "SELECT tasks.id, tasks.title, tasks.description, tasks.due_date, tasks.priority, tasks.status, users.username 
                FROM tasks 
                INNER JOIN users ON tasks.user_id = users.id 
                ORDER BY $sort ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch tasks assigned to a specific user with optional filtering and sorting
    public function getUserTasks($userId, $filter = null, $sort = 'due_date') {
        $allowedSorts = ['due_date', 'priority', 'status'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'due_date';
        
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id";

        if ($filter) {
            switch ($filter) {
                case 'pending':
                    $sql .= " AND status = 'Pending'";
                    break;
                case 'in-progress':
                    $sql .= " AND status = 'In Progress'";
                    break;
                case 'past-due':
                    $sql .= " AND due_date < CURDATE() AND status != 'Completed'";
                    break;
                case 'completed':
                    $sql .= " AND status = 'Completed'";
                    break;
                case 'high-priority':
                    $sql .= " AND priority = 'High'";
                    break;
            }
        }

        $sql .= " ORDER BY $sort ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new task
    public function createTask($userId, $title, $description, $dueDate, $priority, $status) {
        try {
            $title = htmlspecialchars(strip_tags($title));
            $description = htmlspecialchars(strip_tags($description));
            
            $sql = "INSERT INTO tasks (user_id, title, description, due_date, priority, status) 
                    VALUES (:user_id, :title, :description, :due_date, :priority, :status)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':due_date', $dueDate, PDO::PARAM_STR);
            $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error creating task: " . $e->getMessage());
        }
    }

    // Update a task
    public function updateTask($taskId, $title, $description, $dueDate, $priority, $status) {
        $title = htmlspecialchars(strip_tags($title));
        $description = htmlspecialchars(strip_tags($description));
        
        $sql = "UPDATE tasks 
                SET title = :title, description = :description, due_date = :due_date, priority = :priority, status = :status 
                WHERE id = :task_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':due_date', $dueDate, PDO::PARAM_STR);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Delete a task
    public function deleteTask($taskId) {
        $sql = "DELETE FROM tasks WHERE id = :task_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Get a single task by ID
    public function getTaskById($taskId) {
        $sql = "SELECT * FROM tasks WHERE id = :task_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}