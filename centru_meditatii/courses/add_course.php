<?php
session_start();
require_once('../config/db.php');

// Verifică dacă utilizatorul este autentificat ca administrator
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}

// Gestionare încărcare profesori pe baza materiei selectate (AJAX request)
if (isset($_GET['subject_id']) && !empty($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    $query = "
        SELECT t.id, t.name 
        FROM teachers t
        JOIN subject_teacher st ON t.id = st.teacher_id
        WHERE st.subject_id = '$subject_id'
    ";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
    } else {
        echo "<option value=''>Nu există profesori disponibili</option>";
    }
    exit();
}

// Gestionare trimitere formular pentru adăugarea unui curs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];
    $teacher_id = $_POST['teacher_id'];
    $day = $_POST['day'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $students = isset($_POST['students']) ? $_POST['students'] : [];

    // Inserare curs în tabelul `courses`
    $query = "
        INSERT INTO courses (subject_id, teacher_id, day, start_date, end_date, start_time, end_time) 
        VALUES ('$subject_id', '$teacher_id', '$day', '$start_date', '$end_date', '$start_time', '$end_time')
    ";

    if (mysqli_query($conn, $query)) {
        $course_id = mysqli_insert_id($conn);

        // Asociere elevi cu cursul (dacă există elevi selectați)
        if (!empty($students)) {
            foreach ($students as $student_id) {
                $student_query = "
                    INSERT INTO course_students (course_id, student_id) 
                    VALUES ('$course_id', '$student_id')
                ";
                mysqli_query($conn, $student_query);
            }
        }

        $_SESSION['success'] = "Curs adăugat cu succes!";
        header("Location: list_courses.php");
        exit();
    } else {
        $error_message = "Eroare la adăugarea cursului: " . mysqli_error($conn);
    }
}

// Obține lista materiilor
$subjects_query = "SELECT * FROM subjects";
$subjects_result = mysqli_query($conn, $subjects_query);

// Obține lista elevilor
$students_query = "SELECT id, name FROM students";
$students_result = mysqli_query($conn, $students_query);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Curs</title>
    <link rel="stylesheet" href="../styles/style_courses.css">
</head>
<body>
    <h1>Adaugă Curs</h1>

    <?php if (isset($error_message)) { ?>
        <p class="error"><?= $error_message ?></p>
    <?php } ?>

    <form method="POST" action="">
        <label for="subject_id">Materie:</label>
        <select id="subject_id" name="subject_id" onchange="loadTeachers()" required>
            <option value="">Selectează Materia</option>
            <?php while ($row = mysqli_fetch_assoc($subjects_result)) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select>

        <label for="teacher_id">Profesor:</label>
        <select id="teacher_id" name="teacher_id" required>
            <option value="">Selectează Profesorul</option>
        </select>

        <label for="day">Ziua:</label>
        <select id="day" name="day" required>
            <option value="Luni">Luni</option>
            <option value="Marți">Marți</option>
            <option value="Miercuri">Miercuri</option>
            <option value="Joi">Joi</option>
            <option value="Vineri">Vineri</option>
            <option value="Sâmbătă">Sâmbătă</option>
            <option value="Duminică">Duminică</option>
        </select>

        <label for="start_date">Ziua de început:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">Ziua de sfârșit:</label>
        <input type="date" id="end_date" name="end_date" required>

        <label for="start_time">Ora de început:</label>
        <input type="time" id="start_time" name="start_time" required>

        <label for="end_time">Ora de sfârșit:</label>
        <input type="time" id="end_time" name="end_time" required>

        <label for="students">Elevi:</label>
        <div class="student-list">
            <?php while ($row = mysqli_fetch_assoc($students_result)) { ?>
                <label class="student-item">
                    <input type="checkbox" name="students[]" value="<?= $row['id'] ?>">
                    <span><?= $row['name'] ?></span>
                </label>
            <?php } ?>
        </div>

        <button type="submit">Adaugă Curs</button>
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
    </script>
</body>
</html>
