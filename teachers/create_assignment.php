<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

// Get the course_id and class_id from the URL parameters
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;

// Redirect back if course_id or class_id is missing
if ($course_id === null || $class_id === null) {
    header("Location: teacher_dashboard.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_lms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assignment_title = $_POST['assignment_title'];
    $assignment_description = $_POST['assignment_description'];
    $due_date = $_POST['due_date'];
    $teacher_id = $_SESSION['teacher_id']; // Assuming teacher_id is stored in the session

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO assignments (assignment_title, assignment_description, due_date, course_id, class_id, teacher_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiii", $assignment_title, $assignment_description, $due_date, $course_id, $class_id, $teacher_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Assignment created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Assignment</title>
</head>
<body>

<h2>Create Assignment</h2>

<form method="POST" action="">
    <label for="assignment_title">Title:</label><br>
    <input type="text" id="assignment_title" name="assignment_title" required><br><br>
    
    <label for="assignment_description">Description:</label><br>
    <textarea id="assignment_description" name="assignment_description" rows="4" cols="50"></textarea><br><br>
    
    <label for="due_date">Due Date:</label><br>
    <input type="date" id="due_date" name="due_date" required><br><br>
    
    <input type="submit" value="Create Assignment">
</form>
<a href="display_assignments.php"> click me </a>


</body>
</html>
