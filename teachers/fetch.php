<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

// Retrieve the teacher's name from the session
$teacher_name = isset($_SESSION['teacher_name']) ? $_SESSION['teacher_name'] : 'Teacher';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_lms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch assigned courses for the logged-in teacher
$teacher_id = $_SESSION['teacher_id'];
$sql = "SELECT courses.course_name, classes.class_name, courses.course_id, classes.class_id 
        FROM assign_course 
        INNER JOIN courses ON assign_course.course_id = courses.course_id 
        INNER JOIN classes ON assign_course.class_id = classes.class_id 
        WHERE assign_course.teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$assigned_courses = [];
while ($row = $result->fetch_assoc()) {
    $assigned_courses[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
        .course-list {
            text-align: left;
            margin-top: 20px;
        }
        .course-item {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .course-item:hover {
            background-color: #0056b3;
        }
        .buttons {
            display: none; /* Initially hide the buttons */
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            color: #fff;
            background-color: #28a745;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($teacher_name); ?>!</h2>
    <p>You are logged in as a teacher.</p>
    
    <h3>Your Assigned Courses:</h3>
    <div class="course-list">
        <?php if (!empty($assigned_courses)) : ?>
            <?php foreach ($assigned_courses as $course) : ?>
                <div class="course-item">
                    <strong>Course:</strong> <?php echo htmlspecialchars($course['course_name']); ?><br>
                    <strong>Class:</strong> <?php echo htmlspecialchars($course['class_name']); ?>
                    
                    <!-- Buttons, initially hidden -->
                    <div class="buttons">
                        <a href="view_students.php?course_id=<?php echo $course['course_id']; ?>&class_id=<?php echo $course['class_id']; ?>" class="btn">View Students</a>
                        <a href="create_assignment.php?course_id=<?php echo $course['course_id']; ?>&class_id=<?php echo $course['class_id']; ?>" class="btn">View Assignments</a>
                        <a href="view_quizzes.php?course_id=<?php echo $course['course_id']; ?>&class_id=<?php echo $course['class_id']; ?>" class="btn">View Quizzes</a>
                        <a href="make_announcement.php?course_id=<?php echo $course['course_id']; ?>&class_id=<?php echo $course['class_id']; ?>" class="btn">Make Announcement</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No courses assigned.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    // Get all course items
    const courseItems = document.querySelectorAll('.course-item');

    // Add click event listener to each course item
    courseItems.forEach(courseItem => {
        courseItem.addEventListener('click', function() {
            // Toggle the visibility of the buttons within the clicked course item
            const buttons = this.querySelector('.buttons');
            if (buttons.style.display === 'none' || buttons.style.display === '') {
                buttons.style.display = 'block';  // Show the buttons
            } else {
                buttons.style.display = 'none';  // Hide the buttons
            }
        });
    });
</script>

</body>
</html>
