<?php
session_start();
include 'db.php';
if ($_SESSION['user']['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}
$records = $conn->query("SELECT a.date, u.name, a.status 
                         FROM attendance a 
                         JOIN users u ON a.student_id=u.id 
                         ORDER BY a.date DESC");
?>

<h2>Attendance Records</h2>
<p><a href="teacher_dashboard.php">Back</a></p>
<table border="1">
    <tr><th>Date</th><th>Student</th><th>Status</th></tr>
    <?php while ($row = $records->fetch_assoc()): ?>
        <tr>
            <td><?= $row['date'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
