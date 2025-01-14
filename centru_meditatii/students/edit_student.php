<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM students WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $query = "UPDATE students SET name = '$name', email = '$email' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: list_students.php");
        exit();
    } else {
        echo "Eroare la actualizarea studentului.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editează Student</title>
    <link rel="stylesheet" href="../styles/style_students.css">

</head>
<body>
    <h1>Editează Student</h1>
    <form action="edit_student.php?id=<?php echo $student['id']; ?>" method="POST">
        <label for="name">Nume:</label>
        <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required><br><br>
        <button type="submit">Actualizează</button>
    </form>
</body>
</html>
