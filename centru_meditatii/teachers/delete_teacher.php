<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../auth/login_admin.php");
    exit();
}

$id = $_GET['id'];
$query = "DELETE FROM teachers WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    header("Location: list_teachers.php");
    exit();
} else {
    echo "Eroare la ștergerea profesorului.";
}
?>
