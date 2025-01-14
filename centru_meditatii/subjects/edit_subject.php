<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

$id = $_GET['id'];

$subject_query = "SELECT * FROM subjects WHERE id = $id";
$subject_result = mysqli_query($conn, $subject_query);
$subject = mysqli_fetch_assoc($subject_result);

$teachers_query = "SELECT id, name FROM teachers";
$teachers_result = mysqli_query($conn, $teachers_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $teacher_id = $_POST['teacher_id'];

    if ($name != $subject['name']) {
        $query = "UPDATE subjects SET name = '$name' WHERE id = $id";
        if (!mysqli_query($conn, $query)) {
            $error_message = "Eroare la actualizarea numelui materiei!";
        }
    }

    $check_teacher_query = "SELECT * FROM subject_teacher WHERE subject_id = $id AND teacher_id = $teacher_id";
    $check_teacher_result = mysqli_query($conn, $check_teacher_query);

    if (mysqli_num_rows($check_teacher_result) == 0) {
        $insert_teacher_query = "INSERT INTO subject_teacher (subject_id, teacher_id) VALUES ($id, $teacher_id)";
        if (!mysqli_query($conn, $insert_teacher_query)) {
            $error_message = "Eroare la adăugarea profesorului!";
        }
    }

    if (!isset($error_message)) {
        header("Location: ../subjects/list_subjects.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editează Materie</title>
    <link rel="stylesheet" href="../styles/style_subjects.css">

</head>
<body>
    <h1>Editează Materie</h1>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form action="edit_subject.php?id=<?php echo $id; ?>" method="POST">
        <label for="name">Nume Materie:</label>
        <input type="text" id="name" name="name" value="<?php echo $subject['name']; ?>" required><br><br>

        <label for="teacher_id">Profesor:</label>
        <select id="teacher_id" name="teacher_id" required>
            <option value="">Selectează un profesor</option>
            <?php while ($teacher = mysqli_fetch_assoc($teachers_result)): ?>
                <option value="<?php echo $teacher['id']; ?>" <?php if ($teacher['id'] == $subject['teacher_id']) echo 'selected'; ?>>
                    <?php echo $teacher['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Salvează Modificările</button>
    </form>
</body>
</html>
