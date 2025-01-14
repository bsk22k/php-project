<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login_admin.php");
    exit();
}
?>


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
            margin-bottom: 30px;
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

        li {
            list-style-type: none;
        }

        li a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #7e4d32;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            transition: background-color 0.3s;
        }

        li a:hover {
            background-color: #5d4037;
        }

        .dashboard-container {
            width: 50%;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Dashboard Admin</h1>
        <a href="../students/list_students.php">Lista Studenților</a><br>
        <a href="../teachers/list_teachers.php">Lista Profesorilor</a><br>
        <a href="../courses/list_courses.php">Lista Cursurilor</a><br>
        <a href="../subjects/list_subjects.php">Lista Materiilor</a><br>
        <a href="../auth/logout.php">Logout</a><br>
        <li><a href="create_user.php">Crează cont nou (viewer)</a></li>
    </div>
</body>
</html>
