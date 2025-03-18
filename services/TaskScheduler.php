<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../services/MailService.php';

class TaskScheduler {
    private $pdo;
    private $taskModel;
    private $mailService;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->taskModel = new Task($pdo);
        $this->mailService = new MailService();
    }

    // Mark overdue tasks
    public function markOverdueTasks() {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = 'Past Due' WHERE due_date < NOW() AND status != 'Completed'");
        $stmt->execute();
    }

    // Send task reminders
    public function sendTaskReminders() {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE due_date = CURDATE() AND status != 'Completed'");
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as $task) {
            $userEmail = $this->getUserEmail($task['user_id']);
            if ($userEmail) {
                $subject = "Task Reminder: " . $task['title'];
                $message = "Your task \"" . $task['title'] . "\" is due today. Please complete it on time.";
                $this->mailService->sendEmail($userEmail, $subject, $message);
            }
        }
    }

    // Get user email by user ID
    private function getUserEmail($userId) {
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['email'] : null;
    }

    // Run all scheduled tasks
    public function run() {
        $this->markOverdueTasks();
        $this->sendTaskReminders();
    }
}

// Run the scheduler
$scheduler = new TaskScheduler($pdo);
$scheduler->run();
?>
