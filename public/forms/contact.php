<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Change this to your business email
    $to = "yourbusiness@email.com";

    $email_subject = "New Contact Form Submission: $subject";
    $email_body    = "You have received a new message from your website contact form.\n\n".
                     "Name: $name\n".
                     "Email: $email\n".
                     "Subject: $subject\n".
                     "Message:\n$message";

    $headers = "From: $name <$email>";

    if (mail($to, $email_subject, $email_body, $headers)) {
        // JS expects "OK" exactly
        echo "OK";
    } else {
        echo "Could not send your message. Please try again later.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission.";
}
?>
