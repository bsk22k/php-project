<?php
session_start();
require_once('../config/db.php');

if (isset($_SESSION['user_id'])) {
    header("Location: orar.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: orar.php"); 
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
    <title>Autentificare Utilizator</title>
    <link rel="stylesheet" href="../styles/style_auth.css">

</head>
<body>
    <h2>Autentificare Utilizator</h2>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form action="login_user.php" method="POST">
        <label for="username">Nume Utilizator:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Autentificare</button>
    </form>
    <a href="../index.html">Inapoi</a><br>
</body>
</html>
