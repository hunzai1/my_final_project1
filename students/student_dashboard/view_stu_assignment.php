<?php
session_start();

if (!isset($_SESSION['students_id'])) {
    header("Location: student_login.php");
    exit();
}

$students_id = $_SESSION['students_id'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_lms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT courses.course_name, classes.class_name
        FROM course_enroll 
        INNER JOIN courses ON course_enroll.course_id = courses.course_id 
        WHERE course_enroll.students_id = ?";