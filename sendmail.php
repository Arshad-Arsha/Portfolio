<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to = "mohammedarshadpp123@gmail.com";
    $name = trim($_POST["name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    $subject = "New Contact Message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $name <$email>";

    mail($to, $subject, $body, $headers);
    http_response_code(200);
}
?>
