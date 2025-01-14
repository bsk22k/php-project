<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../courses/list_courses.php");
    exit();
}

$course_id = intval($_GET['id']); 

$query = "
    SELECT courses.subject_id, courses.teacher_id, courses.day, courses.start_time, courses.end_time
    FROM courses
    WHERE courses.id = $course_id
";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../courses/list_courses.php");
    exit();
}

$course = mysqli_fetch_assoc($result);

$selected_students_query = "
    SELECT student_id 
    FROM course_students 
    WHERE course_id = $course_id
";
$selected_students_result = mysqli_query($conn, $selected_students_query);
$selected_students = [];
while ($row = mysqli_fetch_assoc($selected_students_result)) {
    $selected_students[] = $row['student_id'];
}

$subjects_query = "SELECT id, name FROM subjects";
$subjects_result = mysqli_query($conn, $subjects_query);

$students_query = "SELECT id, name FROM students";
$students_result = mysqli_query($conn, $students_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = intval($_POST['subject_id']);
    $teacher_id = intval($_POST['teacher_id']);
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $students = $_POST['students']; 

    $update_query = "
        UPDATE courses 
        SET subject_id = '$subject_id', teacher_id = '$teacher_id', day = '$day', 
            start_time = '$start_time', end_time = '$end_time'
        WHERE id = $course_id
    ";

    if (mysqli_query($conn, $update_query)) {
        $delete_students_query = "DELETE FROM course_students WHERE course_id = $course_id";
        mysqli_query($conn, $delete_students_query);

        foreach ($students as $student_id) {
            $insert_student_query = "
                INSERT INTO course_students (course_id, student_id) 
                VALUES ('$course_id', '$student_id')
            ";
            mysqli_query($conn, $insert_student_query);
        }

        $_SESSION['success'] = "Curs actualizat cu succes!";
        header("Location: list_courses.php");
        exit();
    } else {
        $error_message = "Eroare la actualizarea cursului: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editează Curs</title>
    <link rel="stylesheet" href="../styles/style_courses.css">
</head>
<body>
    <h1>Editează Curs</h1>

    <?php if (isset($error_message)) { ?>
        <p style="color:red;"><?= $error_message ?></p>
    <?php } ?>

    <form method="POST" action="">
        <label for="subject_id">Materie:</label>
        <select id="subject_id" name="subject_id" onchange="loadTeachers()" required>
            <option value="">Selectează Materia</option>
            <?php while ($row = mysqli_fetch_assoc($subjects_result)) { ?>
                <option value="<?= $row['id'] ?>" <?= ($row['id'] == $course['subject_id']) ? 'selected' : '' ?>>
                    <?= $row['name'] ?>
                </option>
            <?php } ?>
        </select>

        <label for="teacher_id">Profesor:</label>
        <select id="teacher_id" name="teacher_id" required>
            <option value="">Selectează Profesorul</option>
        </select>

        <label for="day">Ziua:</label>
        <select id="day" name="day" required>
            <option value="Luni" <?= ($course['day'] == 'Luni') ? 'selected' : '' ?>>Luni</option>
            <option value="Marți" <?= ($course['day'] == 'Marți') ? 'selected' : '' ?>>Marți</option>
            <option value="Miercuri" <?= ($course['day'] == 'Miercuri') ? 'selected' : '' ?>>Miercuri</option>
            <option value="Joi" <?= ($course['day'] == 'Joi') ? 'selected' : '' ?>>Joi</option>
            <option value="Vineri" <?= ($course['day'] == 'Vineri') ? 'selected' : '' ?>>Vineri</option>
            <option value="Sâmbătă" <?= ($course['day'] == 'Sâmbătă') ? 'selected' : '' ?>>Sâmbătă</option>
            <option value="Duminică" <?= ($course['day'] == 'Duminică') ? 'selected' : '' ?>>Duminică</option>
        </select>

        <label for="start_time">Ora de început:</label>
        <input type="time" id="start_time" name="start_time" value="<?= $course['start_time'] ?>" required>

        <label for="end_time">Ora de sfârșit:</label>
        <input type="time" id="end_time" name="end_time" value="<?= $course['end_time'] ?>" required>

        <label for="students">Elevi:</label>
        <div class="student-list">
            <?php while ($row = mysqli_fetch_assoc($students_result)) { ?>
                <label class="student-item">
                    <input type="checkbox" name="students[]" value="<?= $row['id'] ?>" <?= in_array($row['id'], $selected_students) ? 'checked' : '' ?>>
                    <span><?= $row['name'] ?></span>
                </label>
            <?php } ?>
        </div>

        <button type="submit">Actualizează Curs</button>
    </form>

    <script>
        function loadTeachers() {
            const subjectId = document.getElementById("subject_id").value;
            const teacherDropdown = document.getElementById("teacher_id");

            if (subjectId) {
                fetch(`add_course.php?subject_id=${subjectId}`)
                    .then(response => response.text())
                    .then(data => {
                        teacherDropdown.innerHTML = data;
                    })
                    .catch(error => console.error("Eroare la încărcarea profesorilor:", error));
            } else {
                teacherDropdown.innerHTML = '<option value="">Selectează Profesorul</option>';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            loadTeachers();
        });
    </script>
</body>
</html>
