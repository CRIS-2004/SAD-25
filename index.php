<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password'] || password_verify($password, $user['password'])) {

            $_SESSION['user'] = $user;
            if ($user['role'] == 'admin') header("Location: admin_dashboard.php");
            elseif ($user['role'] == 'teacher') header("Location: teacher_dashboard.php");
            else header("Location: student_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Attendance Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h2>Attendance Tracker Login</h2>
    <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn w-100">Login</button>
    </form>
  </div>
</body>
</html>
