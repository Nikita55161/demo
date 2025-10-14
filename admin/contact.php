<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <header>
    <nav class="navbar">
      <div class="logo">Your School</div>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <section class="contact-form">
    <h2>Contact Us</h2>
    <?php
      if (isset($_GET['success'])) {
        echo "<p style='color:green;'>Message sent successfully!</p>";
      } elseif (isset($_GET['error'])) {
        echo "<p style='color:red;'>There was an error sending the message.</p>";
      }
    ?>
    <form action="php/form-handler.php" method="POST">
      <label for="name">Name *</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email *</label>
      <input type="email" id="email" name="email" required>

      <label for="message">Message *</label>
      <textarea id="message" name="message" rows="5" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2025 Your School. All rights reserved.</p>
  </footer>

</body>
</html>
