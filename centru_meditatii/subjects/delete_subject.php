<?php

session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

$id = $_GET['id'];
$query = "DELETE FROM subjects WHERE id = $id";

if (mysqli_query($conn, $query)) {
    header("Location: ../subjects/list_subjects.php");
    exit();
} else {
    echo "Eroare la ștergerea materiei!";
}
?>