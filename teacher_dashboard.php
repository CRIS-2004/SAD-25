<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}
$students = $conn->query("SELECT * FROM users WHERE role='student'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Teacher Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h2>Teacher Dashboard</h2>
    <p class="logout"><a href="logout.php" class="btn btn-danger btn-sm">Logout</a></p>

    <h3>Mark Attendance</h3>
    <form method="POST" action="mark_attendance.php">
      <input type="date" name="date" required>
      <table>
        <tr><th>Student</th><th>Present</th></tr>
        <?php while ($row = $students->fetch_assoc()): ?>
        <tr>
          <td><?= $row['name'] ?></td>
          <td><input type="checkbox" name="attendance[<?= $row['id'] ?>]" value="Present"></td>
        </tr>
        <?php endwhile; ?>
      </table>
      <button type="submit">Submit Attendance</button>
    </form>

    <br>
    <a href="attendance_list.php" class="btn btn-secondary">View Attendance Records</a>
  </div>
</body>
</html>
