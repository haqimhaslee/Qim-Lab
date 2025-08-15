<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CORS headers (must be before any output)
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    $name    = strip_tags(trim($_POST["name"] ?? ''));
    $email   = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = trim($_POST["message"] ?? '');

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Please complete all fields.";
        exit;
    }

    // Recipient
    $to = "qimlab.official@gmail.com"; // Change this

    // Email subject and body
    $email_subject = "New Contact Form Submission: $subject";
    $email_body = "You have received a new message:\n\n" .
                  "Name: $name\n" .
                  "Email: $email\n" .
                  "Subject: $subject\n\n" .
                  "Message:\n$message\n";

    // Headers
    $headers  = "From: Your Website <noreply@qimlab.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "OK";
    } else {
        http_response_code(500);
        echo "Could not send your message. Please try again later.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission.";
}
?>
