<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = strip_tags(trim($_POST["name"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST["message"]);

  if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
    header("Location: ../contact.php?error=1");
    exit;
  }

  $recipient = "your-email@example.com";
  $subject = "New Contact Message from $name";
  $email_content = "Name: $name\nEmail: $email\n\nMessage:\n$message";
  $email_headers = "From: $name <$email>";

  if (mail($recipient, $subject, $email_content, $email_headers)) {
    header("Location: ../contact.php?success=1");
  } else {
    header("Location: ../contact.php?error=1");
  }
} else {
  header("Location: ../contact.php");
}
?>
