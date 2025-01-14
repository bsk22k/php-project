<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../auth/login_admin.php");
    exit();
}

$query = "SELECT * FROM teachers";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listă Profesori</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f7f3;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #7e4d32;
        }

        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #7e4d32;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #5d4037;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #e0d1b1;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #5d4037;
        }

        td {
            background-color: #fff;
        }

        td a {
            background-color:#5d4037;
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }

        td a:hover {
            background-color:#5d4037;
        }
    </style>
</head>
<body>
    <h1>Listă Profesori</h1>
    <a href="add_teacher.php">Adaugă Profesor</a>
    <a href="../admin/dashboard.php">Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($teacher = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($teacher['id']); ?></td>
                <td><?php echo htmlspecialchars($teacher['name']); ?></td>
                <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                <td>
                    <a href="edit_teacher.php?id=<?php echo $teacher['id']; ?>">Editează</a>
                    <a href="delete_teacher.php?id=<?php echo $teacher['id']; ?>" onclick="return confirm('Ești sigur?')">Șterge</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
