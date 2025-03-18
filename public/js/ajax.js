document.addEventListener("DOMContentLoaded", function () {
    // Update Task Status via AJAX
    document.querySelectorAll(".update-task-status").forEach(button => {
        button.addEventListener("click", function () {
            const taskId = this.dataset.taskId;
            const newStatus = this.dataset.newStatus;

            fetch("backend/update_task_status.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `task_id=${taskId}&status=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Task status updated successfully!");
                    location.reload();
                } else {
                    alert("Error updating task.");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });

    // Add Comment via AJAX
    document.querySelectorAll(".add-comment-form").forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch("backend/add_comment.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Comment added successfully!");
                    location.reload();
                } else {
                    alert("Error adding comment.");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
