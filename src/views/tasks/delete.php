<?php
session_start();
require_once "../../../config/config.php";
require_once "../../models/Task.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$taskModel = new Task($pdo);

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Check if task exists before deleting
    $task = $taskModel->getTaskById($task_id);

    if ($task) {
        $taskModel->deleteTask($task_id);
        header("Location: ../../../index.php?success=Task deleted successfully"); // Redirect to home
        exit();
    } else {
        header("Location: ../../views/tasks/index.php?error=Task not found"); // Redirect to tasks page
        exit();
    }
} else {
    header("Location: ../../views/tasks/index.php?error=Invalid request"); // Redirect to tasks page
    exit();
}
?>
