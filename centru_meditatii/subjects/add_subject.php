<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $teacher_id = $_POST['teacher_id'];

    $check_teacher_query = "SELECT * FROM teachers WHERE id = '$teacher_id'";
    $check_teacher_result = mysqli_query($conn, $check_teacher_query);

    if (mysqli_num_rows($check_teacher_result) == 0) {
        $error_message = "Profesorul selectat nu există în baza de date!";
    } else {
        $check_subject_query = "SELECT * FROM subjects WHERE name = '$name'";
        $check_subject_result = mysqli_query($conn, $check_subject_query);

        if (mysqli_num_rows($check_subject_result) > 0) {
            $subject = mysqli_fetch_assoc($check_subject_result);
            $subject_id = $subject['id'];

            $check_teacher_query = "SELECT * FROM subject_teacher WHERE subject_id = '$subject_id' AND teacher_id = '$teacher_id'";
            $check_teacher_result = mysqli_query($conn, $check_teacher_query);

            if (mysqli_num_rows($check_teacher_result) == 0) {
                $insert_teacher_query = "INSERT INTO subject_teacher (subject_id, teacher_id) VALUES ('$subject_id', '$teacher_id')";
                if (mysqli_query($conn, $insert_teacher_query)) {
                    header("Location: ../subjects/list_subjects.php");
                    exit();
                } else {
                    $error_message = "Eroare la adăugarea profesorului la materie!";
                }
            } else {
                $error_message = "Profesorul este deja asociat cu această materie!";
            }
        } else {
            $query = "INSERT INTO subjects (name, teacher_id) VALUES ('$name', '$teacher_id')";
            if (mysqli_query($conn, $query)) {
                header("Location: ../subjects/list_subjects.php");
                exit();
            } else {
                $error_message = "Eroare la adăugarea materiei!";
            }
        }
    }
}

$teachers_query = "SELECT id, name FROM teachers";
$teachers_result = mysqli_query($conn, $teachers_query);

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Materie</title>
    <link rel="stylesheet" href="../styles/style_subjects.css">
</head>
<body>
    <h1>Adaugă Materie</h1>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form action="add_subject.php" method="POST">
        <label for="name">Nume Materie:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="teacher_id">Profesor:</label>
        <select id="teacher_id" name="teacher_id" required>
            <option value="">Selectează un profesor</option>
            <?php while ($teacher = mysqli_fetch_assoc($teachers_result)): ?>
                <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Adaugă Materie</button>
    </form>
</body>
</html>
