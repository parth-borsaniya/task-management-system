<?php

use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Controllers\AdminController;
use App\Controllers\CommentController;
use App\Controllers\UserController;

require_once "config/config.php";
require_once "src/controllers/AuthController.php";
require_once "src/controllers/TaskController.php";
require_once "src/controllers/AdminController.php";
require_once "src/controllers/CommentController.php";
require_once "src/controllers/UserController.php";

session_start();

// Define routes
$routes = [
    "/"                     => [TaskController::class, 'index'],
    "/login"                => [AuthController::class, 'showLoginForm'],
    "/register"             => [AuthController::class, 'showRegisterForm'],
    "/logout"               => [AuthController::class, 'logout'],
    "/tasks/create"         => [TaskController::class, 'create'],
    "/tasks/store"          => [TaskController::class, 'store'],
    "/tasks/edit"           => [TaskController::class, 'edit'],
    "/tasks/update"         => [TaskController::class, 'update'],
    "/tasks/delete"         => [TaskController::class, 'delete'],
    "/comments/store"       => [CommentController::class, 'store'],
    "/admin/users"          => [AdminController::class, 'manageUsers'],
    "/admin/tasks"          => [AdminController::class, 'manageTasks'],
    "/admin/comments"       => [AdminController::class, 'manageComments'],
    "/profile"              => [UserController::class, 'profile'],
];

// Get the requested URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if the route exists
if (array_key_exists($requestUri, $routes)) {
    $controller = new $routes[$requestUri][0]();
    $method = $routes[$requestUri][1];
    $controller->$method();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
