<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin_dashboard.php">Attendance Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
        <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
      </ul>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h2>Welcome, Admin 👋</h2>
  <p class="text-muted">Manage attendance, teachers, and students from here.</p>

  <div class="row mt-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <h3>
            <?php
              $teacherCount = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='teacher'")->fetch_assoc()['total'];
              echo $teacherCount;
            ?>
          </h3>
          <p>Teachers</p>
          <a href="teachers.php" class="btn btn-primary btn-sm">Manage</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <h3>
            <?php
              $studentCount = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='student'")->fetch_assoc()['total'];
              echo $studentCount;
            ?>
          </h3>
          <p>Students</p>
          <a href="students.php" class="btn btn-success btn-sm">Manage</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <h3>
            <?php
              $attCount = $conn->query("SELECT COUNT(*) AS total FROM attendance")->fetch_assoc()['total'];
              echo $attCount;
            ?>
          </h3>
          <p>Attendance Records</p>
          <a href="#attendance-section" class="btn btn-warning btn-sm">View Records</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Attendance Section -->
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
