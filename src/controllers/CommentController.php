<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    private $commentModel;

    public function __construct($pdo) {
        $this->commentModel = new Comment($pdo);
    }

    // Fetch comments for a specific task
    public function getTaskComments($taskId) {
        if (empty($taskId)) {
            return [];
        }
        return $this->commentModel->getTaskComments($taskId);
    }

    // Add a new comment
    public function addComment($taskId, $userId, $commentText) {
        if (empty($taskId) || empty($userId) || empty($commentText)) {
            return "All fields are required.";
        }
        return $this->commentModel->addComment($taskId, $userId, $commentText);
    }

    // Delete a comment
    public function deleteComment($commentId, $userId) {
        if (empty($commentId) || empty($userId)) {
            return "Invalid request.";
        }
        return $this->commentModel->deleteComment($commentId, $userId);
    }
}

// Initialize CommentController instance
$commentController = new CommentController($pdo);
?>
