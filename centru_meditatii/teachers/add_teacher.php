<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../auth/login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $query = "INSERT INTO teachers (name, email) VALUES ('$name', '$email')";
    if (mysqli_query($conn, $query)) {
        header("Location: list_teachers.php");
        exit();
    } else {
        echo "Eroare la adăugarea profesorului.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Profesor</title>
    <link rel="stylesheet" href="../styles/style_teachers.css">
</head>
<body>
    <h1>Adaugă Profesor</h1>
    <form action="add_teacher.php" method="POST">
        <label for="name">Nume:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Adaugă</button>
    </form>
</body>
</html>
