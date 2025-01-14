<?php
session_start();
require_once('../config/db.php');


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}


$filter_query = "SELECT DISTINCT start_date FROM courses ORDER BY start_date";
$filter_result = mysqli_query($conn, $filter_query);


$selected_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$filter_condition = $selected_date ? "WHERE courses.start_date = '$selected_date'" : '';


$query = "
    SELECT courses.id, courses.day, teachers.name AS teacher_name, subjects.name AS subject_name, 
           courses.start_time, courses.end_time, courses.start_date, courses.end_date
    FROM courses
    JOIN teachers ON courses.teacher_id = teachers.id
    JOIN subjects ON courses.subject_id = subjects.id
    $filter_condition
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Cursuri</title>
    <link rel="stylesheet" href="../styles/style_list_courses.css">
</head>
<body>
    <h2>Lista Cursuri</h2>

    <a href="add_course.php">Adaugă Curs</a>
    <a href="../admin/dashboard.php">Dashboard</a>

   
    <form method="GET" action="">
        <label for="filter_date">filtreaza dupa ora de inceput:</label>
        <select id="filter_date" name="filter_date" onchange="this.form.submit()">
            <option value="">toate datele</option>
            <?php while ($row = mysqli_fetch_assoc($filter_result)) { ?>
                <option value="<?= $row['start_date'] ?>" <?= $selected_date == $row['start_date'] ? 'selected' : '' ?>>
                    <?= $row['start_date'] ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <table>
        <thead>
            <tr>
                <th>Ziua Săptămânii</th>
                <th>Profesor</th>
                <th>Materie</th>
                <th>Data început</th>
                <th>Data sfârșit</th>
                <th>Ora Început</th>
                <th>Ora Sfârșit</th>
                <th>Studenți</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($course = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $course['day'] ?></td> 
                    <td><?= $course['teacher_name'] ?></td>
                    <td><?= $course['subject_name'] ?></td>
                    <td><?= $course['start_date'] ?></td>
                    <td><?= $course['end_date'] ?></td>
                    <td><?= $course['start_time'] ?></td>
                    <td><?= $course['end_time'] ?></td>
                    <td>
                        <?php
                        $course_id = $course['id'];
                        $student_query = "
                            SELECT students.name 
                            FROM course_students
                            JOIN students ON course_students.student_id = students.id
                            WHERE course_students.course_id = $course_id
                        ";
                        $students_result = mysqli_query($conn, $student_query);
                        $students_count = mysqli_num_rows($students_result);

                        if ($students_count > 0) {
                            while ($student = mysqli_fetch_assoc($students_result)) {
                                echo $student['name'] . "<br>";
                            }
                        } else {
                            echo "Fără studenți";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="edit_course.php?id=<?= $course['id'] ?>">Editează</a>
                        <a href="delete_course.php?id=<?= $course['id'] ?>" onclick="return confirm('Ești sigur?')">Șterge</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
