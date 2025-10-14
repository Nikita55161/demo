<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Kamelilo Secondary</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f4f7ff;
    }

    header {
      background-color: #002244;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .dashboard {
      max-width: 1000px;
      margin: 30px auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      padding: 20px;
    }

    .card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 20px;
      text-align: center;
      transition: 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card i {
      font-size: 36px;
      color: #002244;
      margin-bottom: 15px;
    }

    .card a {
      text-decoration: none;
      font-weight: bold;
      color: #002244;
      display: block;
      margin-top: 10px;
    }

    .logout {
      text-align: center;
      margin-top: 30px;
    }

    .logout a {
      background-color: red;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 8px;
    }

    .logout a:hover {
      background-color: darkred;
    }
  </style>
</head>
<body>

<header>
  <h1>Welcome, Admin</h1>
  <p>Kamelilo Day Secondary School | Dashboard</p>
</header>

<div class="dashboard">

  <div class="card">
    <i class="fas fa-images"></i>
    <h3>Gallery</h3>
    <a href="gallery.php">Manage Gallery</a>
  </div>

  <div class="card">
    <i class="fas fa-calendar-alt"></i>
    <h3>Events</h3>
    <a href="events.php">Manage Events</a>
  </div>

  <div class="card">
    <i class="fas fa-download"></i>
    <h3>Downloads</h3>
    <a href="downloads.php">Manage Downloads</a>
  </div>

  <div class="card">
    <i class="fas fa-blog"></i>
    <h3>Blog</h3>
    <a href="blog.php">Manage Blog</a>
  </div>

  <div class="card">
    <i class="fas fa-envelope"></i>
    <h3>Messages</h3>
    <a href="messages.php">View Messages</a>
  </div>

</div>

<div class="logout">
  <a href="logout.php">Logout</a>
</div>

</body>
</html>
