<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM teachers WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $query = "UPDATE teachers SET name = '$name', email = '$email' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: list_teachers.php");
        exit();
    } else {
        echo "Eroare la actualizarea profesorului.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editează Profesor</title>
    <link rel="stylesheet" href="../styles/style_teachers.css">

</head>
<body>
    <h1>Editează Profesor</h1>
    <form action="edit_teacher.php?id=<?php echo $teacher['id']; ?>" method="POST">
        <label for="name">Nume:</label>
        <input type="text" id="name" name="name" value="<?php echo $teacher['name']; ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $teacher['email']; ?>" required><br><br>
        <button type="submit">Actualizează</button>
    </form>
</body>
</html>
