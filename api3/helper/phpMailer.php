<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Ensure Composer autoload is included
require_once __DIR__ . '/../vendor/autoload.php';

function sendEmail($email, $name, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = getenv('EMAIL_HOST');  // Retrieve environment variables
        $mail->SMTPAuth = true;
        $mail->Username = getenv('EMAIL_USERNAME');
        $mail->Password = getenv('EMAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SMTPS for port 465
        $mail->Port = getenv('EMAIL_PORT');

        // Sender and recipient
        $mail->setFrom(getenv('EMAIL_FROM'), 'Kalpep1.0');
        $mail->addAddress($email, $name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Welcome, $name!";
        $mail->Body = $body;

        // Send email
        $mail->send();
        return "Email sent successfully to $name ($email)";
        
    } catch (Exception $e) {
        // Log error for debugging
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return "Failed to send email: " . $mail->ErrorInfo;
    }
}
