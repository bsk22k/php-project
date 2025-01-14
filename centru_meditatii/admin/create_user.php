<?php
session_start();
require_once('../config/db.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    if (empty($username) || empty($password)) {
        $error_message = "Toate câmpurile sunt obligatorii!";
    } else {
        $checkQuery = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Utilizatorul există deja!";
        } else {
            $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                $success_message = "Cont creat cu succes!";
            } else {
                $error_message = "Eroare la crearea contului!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creare Cont Utilizator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f7f3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #7e4d32;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
            color: #5d4037;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        button {
            background-color: #7e4d32;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5d4037;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
        }

        .success-message {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crează un cont</h2>
        <?php 
        if (isset($error_message)) { 
            echo "<p class='error-message'>$error_message</p>"; 
        } 
        if (isset($success_message)) { 
            echo "<p class='success-message'>$success_message</p>"; 
        } 
        ?>
        <form action="create_user.php" method="POST">
            <label for="username">Nume Utilizator:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Parolă:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Crează Cont</button>
        </form>
    </div>
</body>
</html>
