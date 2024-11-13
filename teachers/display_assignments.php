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
$sql = "SELECT assignment_id, assignment_title, assignment_description, due_date 
        FROM assignments 
        WHERE course_id = ? AND class_id = ? AND teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $course_id, $class_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all assignments
$assignments = [];
while ($row = $result->fetch_assoc()) {
    $assignments[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignments List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .assignment-list {
            margin-top: 20px;
            text-align: left;
        }
        .assignment-item {
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .assignment-info {
            display: inline-block;
            color: #fff;
        }
        .btn-back {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Assignments for Selected Course and Class</h2>
    
    <div class="assignment-list">
        <?php if (!empty($assignments)): ?>
            <?php foreach ($assignments as $assignment): ?>
                <div class="assignment-item">
                    <div class="assignment-info">
                        <strong>Title:</strong> <?php echo htmlspecialchars($assignment['assignment_title']); ?><br>
                        <strong>Description:</strong> <?php echo htmlspecialchars($assignment['assignment_description']); ?><br>
                        <strong>Due Date:</strong> <?php echo htmlspecialchars($assignment['due_date']); ?>
                    </div>
                    <!-- Optional: Link to view or manage assignment details -->
                    <a href="view_assignment.php?assignment_id=<?php echo $assignment['assignment_id']; ?>" style="color: #fff;">View</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No assignments found for this course and class.</p>
        <?php endif; ?>
    </div>

    <a href="teacher_dashboard.php" class="btn-back">Back to Dashboard</a>
</div>

</body>
</html>
