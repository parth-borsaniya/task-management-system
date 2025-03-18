<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../models/Task.php";
require_once __DIR__ . "/../models/Comment.php";
require_once __DIR__ . "/../models/User.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

$taskModel = new Task($pdo);
$commentModel = new Comment($pdo);
$userModel = new User($pdo);

switch ($endpoint) {
    
    // ✅ Fetch all tasks
    case 'tasks':
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
    case 'task_create':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $taskModel->createTask($data['user_id'], $data['title'], $data['description'], $data['due_date'], $data['priority']);
            echo json_encode($result);
        }
        break;

    // ✅ Update a task
    case 'task_update':
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $taskModel->updateTask($data['task_id'], $data['title'], $data['description'], $data['due_date'], $data['priority'], $data['status']);
            echo json_encode($result);
        }
        break;

    // ✅ Delete a task
    case 'task_delete':
        if ($method === 'DELETE') {
            $taskId = $_GET['task_id'] ?? null;
            if ($taskId) {
                echo json_encode($taskModel->deleteTask($taskId));
            } else {
                echo json_encode(["error" => "Task ID is required"]);
            }
        }
        break;

    // ✅ Fetch all comments for a task
    case 'comments':
        if ($method === 'GET') {
            $taskId = $_GET['task_id'] ?? null;
            if ($taskId) {
                echo json_encode($commentModel->getCommentsByTask($taskId));
            } else {
                echo json_encode(["error" => "Task ID is required"]);
            }
        }
        break;

    // ✅ Add a comment
    case 'comment_add':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $commentModel->addComment($data['task_id'], $data['user_id'], $data['comment']);
            echo json_encode($result);
        }
        break;

    // ✅ Delete a comment
    case 'comment_delete':
        if ($method === 'DELETE') {
            $commentId = $_GET['comment_id'] ?? null;
            if ($commentId) {
                echo json_encode($commentModel->deleteComment($commentId));
            } else {
                echo json_encode(["error" => "Comment ID is required"]);
            }
        }
        break;

    // ✅ User login
    case 'login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $userModel->login($data['email'], $data['password']);
            echo json_encode($result);
        }
        break;

    // ✅ User registration
    case 'register':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $userModel->register($data['username'], $data['email'], $data['password']);
            echo json_encode($result);
        }
        break;

    // ✅ Fetch all users (Admin Only)
    case 'users':
        if ($method === 'GET') {
            echo json_encode($userModel->getAllUsers());
        }
        break;

    // ❌ Invalid API request
    default:
        echo json_encode(["error" => "Invalid API endpoint"]);
        break;
}

?>
