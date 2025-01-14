<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../courses/list_courses.php");
    exit();
}

$course_id = $_GET['id'];

$delete_query = "DELETE FROM courses WHERE id = $course_id";

if (mysqli_query($conn, $delete_query)) {
    $_SESSION['success'] = "Curs șters cu succes!";
} else {
    $_SESSION['error'] = "Eroare la ștergerea cursului.";
}

header("Location: ../courses/list_courses.php");
exit();
