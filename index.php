<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: src/views/auth/login.php");
    exit();
}

require_once "config/config.php";
require_once "src/models/Task.php";

$taskModel = new Task($pdo);
$filter = isset($_GET['filter']) ? strtolower($_GET['filter']) : null;
$tasks = $taskModel->getUserTasks($_SESSION['user_id'], $filter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Task Manager</a>
            <button class="btn btn-light" id="darkModeToggle">Dark Mode</button>
            <a href="src/views/auth/logout.php" class="btn btn-danger ms-3">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

        <div class="row mt-4">
            <div class="col-md-3">
                <a href="src/views/tasks/create.php" class="btn btn-success w-100 mb-3">Create Task</a>
                <ul class="list-group">
                    <li class="list-group-item active">Task Categories</li>
                    <li class="list-group-item">
                        <a href="index.php" class="<?= $filter == null ? 'fw-bold' : '' ?>">All Tasks</a>
                    </li>
                    <li class="list-group-item">
                        <a href="index.php?filter=pending" class="<?= $filter == 'pending' ? 'fw-bold' : '' ?>">Pending</a>
                    </li>
                    <li class="list-group-item">
                        <a href="index.php?filter=in-progress" class="<?= $filter == 'in-progress' ? 'fw-bold' : '' ?>">In Progress</a>
                    </li>
                    <li class="list-group-item">
                        <a href="index.php?filter=past-due" class="<?= $filter == 'past-due' ? 'fw-bold' : '' ?>">Past Due</a>
                    </li>
                    <li class="list-group-item">
                        <a href="index.php?filter=completed" class="<?= $filter == 'completed' ? 'fw-bold' : '' ?>">Completed</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo strtolower($task['priority']); ?>">
                                            <?php echo ucfirst($task['priority']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo ($task['status'] == 'Completed') ? 'success' : 'warning'; ?>">
                                            <?php echo htmlspecialchars($task['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="src/views/tasks/edit.php?id=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="src/views/tasks/delete.php?id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($tasks)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No tasks found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
