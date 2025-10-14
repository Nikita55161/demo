<?php
session_start();

// Dummy credentials (replace with database verification later)
$admin_username = "admin";
$admin_password = "password123";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username']; // Corrected from 'admin'
  $password = $_POST['password'];

  if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: index.php");
    exit();
  } else {
    $error = "Invalid login credentials.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #e6f0ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      margin-bottom: 20px;
      color: #002244;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background: #002244;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .error {
      color: red;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login">
    </form>
  </div>
</body>
</html>
