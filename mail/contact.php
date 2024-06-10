<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled and email is valid
    if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        exit();
    }

    // Sanitize user input to prevent XSS attacks
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $m_subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Set the recipient email address
    $to = "pholaxi@gmail.com"; // Change this to your email address

    // Compose the email message
    $subject = "$m_subject: $name";
    $body = "You have received a new message from your website contact form.\n\n";
    $body .= "Here are the details:\n\n";
    $body .= "Name: $name\n\n";
    $body .= "Email: $email\n\n";
    $body .= "Subject: $m_subject\n\n";
    $body .= "Message:\n$message\n";

    // Set additional headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send the email
    if(mail($to, $subject, $body, $headers)) {
        http_response_code(200); // Success
        echo "Message sent successfully.";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed.";
}
?>
