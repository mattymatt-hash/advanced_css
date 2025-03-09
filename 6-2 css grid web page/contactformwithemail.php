<?php

$to = 'domainmaster@mathewstevens.info'; // Change this to your email
$subject = 'New Message from the candy store';
$date = date("m/d/Y");

// Collect input data
$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$reason = htmlspecialchars(trim($_POST["reason"]), ENT_QUOTES, 'UTF-8');
$comments = strip_tags(trim($_POST["comments"]));

// Validate input
if (empty($name) || empty($email) || empty($comments)) {
    echo "Please fill out all required fields.";
    exit;
}

if (!empty($_POST['honeypot'])) {
    // Reject form submission, as it's likely from a bot
    exit('Bot detected!');
}

if ($email === false) {
    echo "Invalid email format.";
    exit;
}

// Message content for the email to the domainmaster
$message = "Hi Matt,\n\n"; 
$message .= "You've received a new inquiry through your website!\n\n";
$message .= "Here are the details:\n";
$message .= "Name: $name\n";
$message .= "Email: $email\n";
$message .= "Reason for Contact: $reason\n";
$message .= "Comments: $comments\n";

// Email headers for the domainmaster email
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send the main email
if (mail($to, $subject, $message, $headers)) {
    echo "Thanks, we have received your message!<br>";

    // Send a confirmation email to the user
    $confirmation_subject = "Confirming your sent form";
    $confirmation_message = "Hi $name,\n\nThank you for your interest. Your email has been received. I will get back to you soon.\n";

    // Set up headers for the confirmation email
    $confirmation_headers = "From: domainmaster@mathewstevens.info\r\n";
    $confirmation_headers .= "Reply-To: domainmaster@mathewstevens.info\r\n";
    $confirmation_headers .= "MIME-Version: 1.0\r\n";
    $confirmation_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the confirmation email
    if (mail($email, $confirmation_subject, $confirmation_message, $confirmation_headers)) {
        echo "A confirmation email has been sent to $email";
    } else {
        echo "Problem sending confirmation message.";
    }

} else {
    echo "Problem sending message.";
}

?>
