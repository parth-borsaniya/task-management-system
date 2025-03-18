<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../../../config/config.php";
require_once "../../models/Task.php";

$taskModel = new Task($pdo);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../../../index.php");
    exit();
}

$task_id = $_GET['id'];
$task = $taskModel->getTaskById($task_id, $_SESSION['user_id']);

if (!$task) {
    header("Location: ../../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Task | Task Management</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Task Details</h2>
        <div class="card p-4">
            <h4 class="mb-3"><?php echo htmlspecialchars($task['title']); ?></h4>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
            <p><strong>Due Date:</strong> <?php echo $task['due_date']; ?></p>
            <p>
                <strong>Priority:</strong> 
                <span class="badge bg-<?php echo strtolower($task['priority']); ?>">
                    <?php echo ucfirst($task['priority']); ?>
                </span>
            </p>
            <p>
                <strong>Status:</strong> 
                <span class="badge bg-<?php echo ($task['status'] == 'Completed') ? 'success' : 'warning'; ?>">
                    <?php echo $task['status']; ?>
                </span>
            </p>
            <a href="../../../index.php" class="btn btn-secondary w-100 mt-3">Back to Dashboard</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
