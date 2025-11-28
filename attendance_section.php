<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'attendance')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Students</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin_dashboard.php">Attendance Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link " href="admin_dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
        <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
        <li class="nav-item"><a class="nav-link active" href="students.php">Attendance</a></li>
      </ul>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h2>Attendance Section!</h2>

  <div class="mt-5" id="attendance-section">
    <h3>📋 Attendance Records</h3>
    <div class="table-responsive mt-3">
      <table class="table table-striped table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Date</th>
            <th>Student Name</th>
            <th>Teacher</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT a.date, a.status, 
                         s.name AS student_name, 
                         t.name AS teacher_name
                  FROM attendance a
                  JOIN users s ON a.student_id = s.id
                  JOIN users t ON a.teacher_id = t.id
                  ORDER BY a.date DESC";

          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['date']}</td>
                          <td>{$row['student_name']}</td>
                          <td>{$row['teacher_name']}</td>
                          <td><span class='badge " . 
                              ($row['status'] == 'Present' ? 'bg-success' : 'bg-danger') . 
                              "'>{$row['status']}</span></td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='4' class='text-center text-muted'>No attendance records yet.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
