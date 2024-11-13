<?php
session_start();

if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_lms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT courses.course_name, classes.class_name 
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
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
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
            position: relative;
        }
        .course-item:hover {
            background-color: #0056b3;
        }
        .options {
            display: none;
            margin-top: 10px;
            background-color: #f4f4f4;
            color: #333;
            border-radius: 5px;
            padding: 10px;
            text-align: left;
        }
        .options a {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            color: #fff;
            background-color: #28a745;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .options a:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function toggleOptions(index) {
            const options = document.getElementById('options-' + index);
            if (options.style.display === 'none' || options.style.display === '') {
                options.style.display = 'flex';
            } else {
                options.style.display = 'none';
            }
        }
    </script>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['teacher_name']); ?>!</h2>
    <h3>Your Assigned Courses and Classes</h3>
    <div class="course-list">
        <?php if (!empty($assigned_courses)) : ?>
            <?php foreach ($assigned_courses as $index => $course) : ?>
                <div class="course-item" onclick="toggleOptions(<?php echo $index; ?>)">
                    <strong>Course:</strong> <?php echo htmlspecialchars($course['course_name']); ?><br>
                    <strong>Class:</strong> <?php echo htmlspecialchars($course['class_name']); ?>
                </div>
                <div class="options" id="options-<?php echo $index; ?>">
                    <a href="view_students.php?course=<?php echo urlencode($course['course_name']); ?>&class=<?php echo urlencode($course['class_name']); ?>">View Students</a>
                    <a href="view_assignments.php?course=<?php echo urlencode($course['course_name']); ?>&class=<?php echo urlencode($course['class_name']); ?>">View Assignment</a>
                    <a href="view_quizzes.php?course=<?php echo urlencode($course['course_name']); ?>&class=<?php echo urlencode($course['class_name']); ?>">View Quiz</a>
                    <a href="make_announcement.php?course=<?php echo urlencode($course['course_name']); ?>&class=<?php echo urlencode($course['class_name']); ?>">Make Announcement</a>
                    <a href="fetch.php?course=<?php echo urlencode($course['course_name']); ?>&class=<?php echo urlencode($course['class_name']); ?>">Upload Lecture</a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No classes assigned.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
