<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Set content type first
header('Content-Type: application/json');

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get and sanitize form data
$to = "mohammedarshadpp123@gmail.com";
$name = trim($_POST["name"] ?? '');
$email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
$message = trim($_POST["message"] ?? '');

// Validate inputs
if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Please fill all fields correctly']);
    exit;
}

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.example.com';  // Your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your-email@example.com'; // SMTP username
    $mail->Password   = 'your-smtp-password';      // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port       = 587; // TCP port to connect to
    
    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress($to); // Add a recipient
    
    // Content
    $mail->Subject = "New Contact Message from $name";
    $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    
    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}
?>
