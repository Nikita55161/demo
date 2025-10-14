<?php
// Connect to DB
$conn = new mysqli("localhost", "your_username", "your_password", "your_database");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch messages
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Messages</title>
  <style>
    table {
      width: 100%; border-collapse: collapse;
    }
    th, td {
      padding: 10px; border: 1px solid #ccc;
    }
    th {
      background-color: #1a3dc1;
      color: white;
    }
  </style>
</head>
<body>
  <h2>Contact Messages</h2>
  <table>
    <tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
        <td><?= $row['created_at'] ?></td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
