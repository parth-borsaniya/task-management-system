<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Task.php';

header("Content-Type: application/json");

$taskModel = new Task($pdo);
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($action) {

    // ✅ Fetch all tasks for a specific user
    case 'fetch_tasks':
        if ($method === 'GET') {
            $userId = $_GET['user_id'] ?? null;
            if ($userId) {
                echo json_encode($taskModel->getUserTasks($userId));
            } else {
                echo json_encode(["error" => "User ID is required"]);
            }
        }
        break;

    // ✅ Create a new task
    case 'create_task':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $taskModel->createTask($data['user_id'], $data['title'], $data['description'], $data['due_date'], $data['priority']);
            echo json_encode($result);
        }
        break;

    // ✅ Update an existing task
    case 'update_task':
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $taskModel->updateTask($data['task_id'], $data['title'], $data['description'], $data['due_date'], $data['priority'], $data['status']);
            echo json_encode($result);
        }
        break;

    // ✅ Delete a task
    case 'delete_task':
        if ($method === 'DELETE') {
            $taskId = $_GET['task_id'] ?? null;
            if ($taskId) {
                echo json_encode($taskModel->deleteTask($taskId));
            } else {
                echo json_encode(["error" => "Task ID is required"]);
            }
        }
        break;

    // ❌ Invalid API request
    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}

?>
