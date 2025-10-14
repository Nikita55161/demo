<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

// Set up blog storage
$blogFile = "../data/blogs.json";
if (!file_exists("../data")) {
  mkdir("../data", 0777, true);
}
if (!file_exists($blogFile)) {
  file_put_contents($blogFile, json_encode([]));
}

$blogs = json_decode(file_get_contents($blogFile), true);

// Handle blog submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
  $newBlog = [
    'id' => uniqid(),
    'title' => $_POST['title'],
    'content' => $_POST['content'],
    'timestamp' => time()
  ];
  $blogs[] = $newBlog;
  file_put_contents($blogFile, json_encode($blogs, JSON_PRETTY_PRINT));
  header("Location: blog.php");
  exit();
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $blogs = array_filter($blogs, fn($b) => $b['id'] !== $_POST['delete_id']);
  file_put_contents($blogFile, json_encode(array_values($blogs), JSON_PRETTY_PRINT));
  header("Location: blog.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Blog | Admin Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f0f4f9;
    }

    h2 {
      color: #002244;
    }

    .blog-form, .blog-post {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      margin-top: 15px;
      background: #002244;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .blog-post h3 {
      margin: 0;
      color: #002244;
    }

    .blog-post p {
      line-height: 1.6;
      margin-top: 10px;
    }

    .delete-btn {
      background: red;
      color: white;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      float: right;
      border-radius: 4px;
    }

    .timestamp {
      font-size: 12px;
      color: #777;
    }
  </style>
</head>
<body>

<h2>Blog Management</h2>

<!-- Blog Upload Form -->
<div class="blog-form">
  <form method="POST">
    <label><strong>Title:</strong></label>
    <input type="text" name="title" required>

    <label><strong>Content:</strong></label>
    <textarea name="content" rows="6" required></textarea>

    <input type="submit" value="Post Blog">
  </form>
</div>

<!-- Blog Listing -->
<h3>Existing Blog Posts</h3>

<?php foreach (array_reverse($blogs) as $blog): ?>
  <div class="blog-post">
    <form method="POST" style="float:right;">
      <input type="hidden" name="delete_id" value="<?= $blog['id'] ?>">
      <button class="delete-btn" onclick="return confirm('Are you sure you want to delete this blog post?');">Delete</button>
    </form>
    <h3><?= htmlspecialchars($blog['title']) ?></h3>
    <div class="timestamp"><?= date("F j, Y, g:i a", $blog['timestamp']) ?></div>
    <p><?= nl2br(htmlspecialchars($blog['content'])) ?></p>
  </div>
<?php endforeach; ?>

</body>
</html>
