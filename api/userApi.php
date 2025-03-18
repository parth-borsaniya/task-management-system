<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';

header("Content-Type: application/json");

$userModel = new User($pdo);
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($action) {

    // ✅ Fetch user details
    case 'fetch_user':
        if ($method === 'GET') {
            $userId = $_GET['user_id'] ?? null;
            if ($userId) {
                echo json_encode($userModel->getUserById($userId));
            } else {
                echo json_encode(["error" => "User ID is required"]);
            }
        }
        break;

    // ✅ Register a new user
    case 'register_user':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $userModel->register($data['username'], $data['email'], $data['password']);
            echo json_encode($result);
        }
        break;

    // ✅ User login
    case 'login_user':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $userModel->login($data['email'], $data['password']);
            echo json_encode($result);
        }
        break;

    // ✅ Update user profile
    case 'update_user':
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $userModel->updateUser($data['user_id'], $data['username'], $data['email']);
            echo json_encode($result);
        }
        break;

    // ✅ Delete user account
    case 'delete_user':
        if ($method === 'DELETE') {
            $userId = $_GET['user_id'] ?? null;
            if ($userId) {
                echo json_encode($userModel->deleteUser($userId));
            } else {
                echo json_encode(["error" => "User ID is required"]);
            }
        }
        break;

    // ❌ Invalid API request
    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}

?>
