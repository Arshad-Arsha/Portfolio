<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Set content type first
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'error' => null
];

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    $response['error'] = 'Method not allowed';
    echo json_encode($response);
    exit;
}

// Get and sanitize form data
$to = "mohammedarshadpp123@gmail.com";
$name = trim($_POST["name"] ?? '');
$email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
$message = trim($_POST["message"] ?? '');

// Validate inputs
if (empty($name)) {
    $response['error'] = 'Name is required';
} elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['error'] = 'Valid email is required';
} elseif (empty($message)) {
    $response['error'] = 'Message is required';
}

// If validation errors, return them
if ($response['error'] !== null) {
    http_response_code(400);
    echo json_encode($response);
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
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    
    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress($to);
    $mail->addReplyTo($email, $name);
    
    // Content
    $mail->Subject = "New Contact Message from $name";
    $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    
    $mail->send();
    $response['success'] = true;
    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    $response['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo json_encode($response);
}
?>
