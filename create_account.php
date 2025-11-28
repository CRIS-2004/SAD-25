<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role  = $_POST['role'];

    $exists = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($exists->num_rows > 0) {
        $msg = "<div class='alert alert-danger'>Email already exists!</div>";
    } else {
        $conn->query("INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$pass','$role')");
        $msg = "<div class='alert alert-success'>Account created successfully!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary px-3">
  <a href="admin_dashboard.php" class="navbar-brand">← Back to Dashboard</a>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-3 text-center">Create Account</h3>
          <?= $msg ?>
          <form method="POST">
            <div class="mb-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Role</label>
              <select name="role" class="form-select" required>
                <option value="">Select role</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
              </select>
            </div>
            <button class="btn btn-primary w-100">Create Account</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
