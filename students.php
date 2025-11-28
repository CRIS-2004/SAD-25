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
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'student')");
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
        <li class="nav-item"><a class="nav-link active" href="students.php">Students</a></li>
      </ul>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h2>Student Accounts</h2>

  <form method="POST" class="row g-3 mt-3">
    <div class="col-md-3"><input name="name" class="form-control" placeholder="Name" required></div>
    <div class="col-md-3"><input name="email" class="form-control" placeholder="Email" required></div>
    <div class="col-md-3"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
    <div class="col-md-3"><button class="btn btn-success w-100">Add Student</button></div>
  </form>

  <table class="table table-striped mt-4">
    <thead>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php
        $students = $conn->query("SELECT * FROM users WHERE role='student'");
        while ($row = $students->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['email']}</td>
                  <td><a href='delete_user.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a></td>
                </tr>";
        }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
