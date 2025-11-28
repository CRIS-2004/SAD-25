<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM attendance WHERE student_id=$user_id OR teacher_id=$user_id");
$conn->query("DELETE FROM users WHERE id=$id");
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
