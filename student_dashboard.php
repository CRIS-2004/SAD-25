<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header("Location: index.php");
    exit();
}
$id = $_SESSION['user']['id'];
$attendance = $conn->query("SELECT * FROM attendance WHERE student_id=$id");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h2>Student Dashboard</h2>
    <p class="logout"><a href="logout.php" class="btn btn-danger btn-sm">Logout</a></p>

    <h3>Your Attendance</h3>
    <table>
      <tr><th>Date</th><th>Status</th></tr>
      <?php while ($row = $attendance->fetch_assoc()): ?>
      <tr><td><?= $row['date'] ?></td><td><?= $row['status'] ?></td></tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
