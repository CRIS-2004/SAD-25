<?php
session_start();
include 'db.php';
if ($_SESSION['user']['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}

$date = $_POST['date'];
$attendance = $_POST['attendance'] ?? [];

$students = $conn->query("SELECT * FROM users WHERE role='student'");
while ($student = $students->fetch_assoc()) {
    $status = isset($attendance[$student['id']]) ? 'Present' : 'Absent';
    $conn->query("INSERT INTO attendance (student_id, teacher_id, date, status) 
                  VALUES ({$student['id']}, {$_SESSION['user']['id']}, '$date', '$status')");
}

header("Location: teacher_dashboard.php");
?>
