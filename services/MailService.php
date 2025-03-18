<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php"; // Ensure PHPMailer is installed via Composer

class MailService {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer() {
        try {
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.example.com'; // Change to your SMTP server
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'your-email@example.com'; // Your email
            $this->mail->Password   = 'your-email-password'; // Your email password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587; // Usually 587 for TLS
            
            $this->mail->setFrom('no-reply@example.com', 'Task Management System');
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            error_log("Mail setup error: " . $e->getMessage());
        }
    }

    public function sendMail($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Mail sending failed: " . $e->getMessage());
            return false;
        }
    }

    public function sendRegistrationConfirmation($userEmail, $userName) {
        $subject = "Welcome to Task Manager, $userName!";
        $body = "<p>Dear $userName,</p>
                 <p>Thank you for registering with Task Management System. You can now manage your tasks efficiently.</p>
                 <p>Best Regards,<br>Task Management Team</p>";

        return $this->sendMail($userEmail, $subject, $body);
    }

    public function sendPasswordReset($userEmail, $resetLink) {
        $subject = "Password Reset Request";
        $body = "<p>You have requested to reset your password. Click the link below to proceed:</p>
                 <p><a href='$resetLink'>$resetLink</a></p>
                 <p>If you did not request this, please ignore this email.</p>";

        return $this->sendMail($userEmail, $subject, $body);
    }

    public function sendTaskNotification($userEmail, $taskTitle, $dueDate) {
        $subject = "Task Reminder: $taskTitle";
        $body = "<p>This is a reminder for your task <strong>$taskTitle</strong> due on <strong>$dueDate</strong>.</p>
                 <p>Make sure to complete it on time!</p>";

        return $this->sendMail($userEmail, $subject, $body);
    }

    public function sendAdminAlert($adminEmail, $message) {
        $subject = "Admin Alert: Important Notification";
        $body = "<p>Dear Admin,</p>
                 <p>$message</p>
                 <p>Please take necessary action.</p>";

        return $this->sendMail($adminEmail, $subject, $body);
    }
}
