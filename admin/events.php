<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

// File path
$eventsFile = "../data/events.json";
$imagesDir = "../images/events/";

// Ensure folders exist
if (!file_exists($imagesDir)) mkdir($imagesDir, 0777, true);
if (!file_exists($eventsFile)) file_put_contents($eventsFile, json_encode([]));

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
  $title = $_POST['title'];
  $date = $_POST['date'];
  $description = $_POST['description'];
  $imageName = "";

  // Handle image upload
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageName = time() . "_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagesDir . $imageName);
  }

  $newEvent = [
    'title' => $title,
    'date' => $date,
    'description' => $description,
    'image' => $imageName
  ];

  $events = json_decode(file_get_contents($eventsFile), true);
  $events[] = $newEvent;
  file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));

  header("Location: events.php");
  exit();
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_index'])) {
  $events = json_decode(file_get_contents($eventsFile), true);
  $index = $_POST['delete_index'];

  if (isset($events[$index])) {
    if (!empty($events[$index]['image'])) {
      $imgPath = $imagesDir . $events[$index]['image'];
      if (file_exists($imgPath)) unlink($imgPath);
    }
    array_splice($events, $index, 1);
    file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));
  }

  header("Location: events.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Events | Admin Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    h2 {
      color: #002244;
    }

    .form-box {
      background: #f2f2f2;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
    }

    .form-box input, .form-box textarea {
      width: 100%;
      margin: 10px 0;
      padding: 8px;
    }

    .form-box input[type="submit"] {
      background-color: #002244;
      color: white;
      border: none;
      cursor: pointer;
      padding: 10px 15px;
    }

    .event-list {
      border-top: 1px solid #ccc;
      padding-top: 20px;
    }

    .event-item {
      background: #fff;
      border: 1px solid #ccc;
      margin-bottom: 15px;
      padding: 15px;
      border-radius: 8px;
      position: relative;
    }

    .event-item h4 {
      margin: 0 0 10px;
    }

    .event-item img {
      max-width: 100px;
      border-radius: 6px;
      margin-top: 10px;
    }

    .delete-btn {
      background: red;
      color: white;
      border: none;
      padding: 6px 12px;
      position: absolute;
      top: 15px;
      right: 15px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h2>Event Management</h2>

<div class="form-box">
  <form method="POST" enctype="multipart/form-data">
    <label>Event Title:</label>
    <input type="text" name="title" required>

    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Description:</label>
    <textarea name="description" rows="5" required></textarea>

    <label>Optional Image:</label>
    <input type="file" name="image">

    <input type="submit" name="add_event" value="Add Event">
  </form>
</div>

<div class="event-list">
  <h3>Upcoming Events</h3>
  <?php
    $events = json_decode(file_get_contents($eventsFile), true);
    foreach ($events as $index => $event):
  ?>
    <div class="event-item">
      <h4><?= htmlspecialchars($event['title']) ?> <small>(<?= $event['date'] ?>)</small></h4>
      <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
      <?php if (!empty($event['image'])): ?>
        <img src="<?= $imagesDir . $event['image'] ?>" alt="Event Image">
      <?php endif; ?>
      <form method="POST">
        <input type="hidden" name="delete_index" value="<?= $index ?>">
        <button class="delete-btn" type="submit">Delete</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>
