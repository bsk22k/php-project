<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login_user.php");
    exit();
}

$query = "
    SELECT courses.id, courses.day, teachers.name AS teacher_name, subjects.name AS subject_name, 
           courses.start_time, courses.end_time
    FROM courses
    JOIN teachers ON courses.teacher_id = teachers.id
    JOIN subjects ON courses.subject_id = subjects.id
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


    <table>
        <thead>
            <tr>
                <th>Ziua Săptămânii</th>
                <th>Profesor</th>
                <th>Materie</th>
                <th>Ora Început</th>
                <th>Ora Sfârșit</th>
                <th>Studenți</th>
                
            </tr>
        </thead>
        <tbody>
            <?php while ($course = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $course['day'] ?></td> 
                    <td><?= $course['teacher_name'] ?></td>
                    <td><?= $course['subject_name'] ?></td>
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
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../auth/logout_user.php">Logout</a><br>
</body>
</html>
