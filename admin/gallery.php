<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

$folder = "../images/gallery/";
if (!file_exists($folder)) {
  mkdir($folder, 0777, true);
}

// Handle upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
  $target_file = $folder . basename($_FILES["image"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

  if (in_array($imageFileType, $allowedTypes)) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $message = "Image uploaded successfully.";
    } else {
      $message = "Error uploading image.";
    }
  } else {
    $message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
  }
}

// Handle delete
if (isset($_POST['delete']) && !empty($_POST['filename'])) {
  $fileToDelete = $folder . basename($_POST['filename']);
  if (file_exists($fileToDelete)) {
    unlink($fileToDelete);
    $message = "Image deleted successfully.";
  } else {
    $message = "Image not found.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Gallery | Admin Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f9f9f9;
    }

    h2 {
      color: #002244;
    }

    .upload-form {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    input[type="file"], input[type="submit"] {
      margin-top: 10px;
    }

    .message {
      color: green;
      font-weight: bold;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 15px;
    }

    .gallery-grid img {
      width: 100%;
      border-radius: 8px;
    }

    .delete-btn {
      color: red;
      font-size: 14px;
      display: block;
      text-align: center;
      margin-top: 5px;
    }
  </style>
</head>
<body>

<h2>Gallery Management</h2>

<?php if (isset($message)): ?>
  <p class="message"><?= $message ?></p>
<?php endif; ?>

<div class="upload-form">
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Select image to upload:</label><br>
    <input type="file" name="image" required><br>
    <input type="submit" value="Upload Image" name="submit">
  </form>
</div>

<h3>Uploaded Images</h3>
<div class="gallery-grid">
  <?php
  $images = glob($folder . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
  foreach ($images as $image):
    $filename = basename($image);
  ?>
    <div>
      <img src="<?= $folder . $filename ?>" alt="Gallery Image">
      <form method="POST" action="">
        <input type="hidden" name="filename" value="<?= $filename ?>">
        <button class="delete-btn" name="delete" type="submit">Delete</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>
