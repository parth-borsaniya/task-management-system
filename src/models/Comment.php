<?php
class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Add a new comment
    public function addComment($taskId, $userId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO comments (task_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$taskId, $userId, $content]);
    }

    // Get all comments for a specific task
    public function getCommentsByTask($taskId) {
        $stmt = $this->pdo->prepare("
            SELECT comments.id, comments.content, comments.created_at, users.name AS author 
            FROM comments 
            JOIN users ON comments.user_id = users.id 
            WHERE comments.task_id = ? 
            ORDER BY comments.created_at DESC
        ");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a comment
    public function deleteComment($commentId, $userId) {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
        return $stmt->execute([$commentId, $userId]);
    }
}
?>
