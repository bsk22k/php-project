<?php

session_start();
require_once('../config/db.php');

if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/dashboard.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        if ($password == $admin['password']) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            header("Location: ../admin/dashboard.php"); 
            exit();
        } else {
            $error_message = "Parolă incorectă!";
        }
    } else {
        $error_message = "Utilizatorul nu a fost găsit!";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare</title>
    <link rel="stylesheet" href="../styles/style_auth.css">

</head>
<body>
    <h2>Autentificare</h2>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form action="login_admin.php" method="POST">
        <label for="username">Nume Utilizator:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Autentificare</button>
    </form>
    <a href="../index.html">Inapoi</a><br>

</body>
</html>
