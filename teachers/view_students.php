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

// If course_id or class_id is missing, redirect to dashboard
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

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch course and teacher details
$sql = "SELECT courses.course_name, teachers.teacher_name
        FROM assign_course 
        INNER JOIN courses ON assign_course.course_id = courses.course_id
        INNER JOIN teachers ON assign_course.teacher_id = teachers.teacher_id
        WHERE assign_course.course_id = ? AND assign_course.class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $course_id, $class_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the course and teacher information
$course_details = $result->fetch_assoc();

if (!$course_details) {
    echo "Course not found or invalid course/class ID.";
    exit();
}

$course_name = $course_details['course_name'];
$teacher_name = $course_details['teacher_name'];

// Query to fetch all students enrolled in this course and class with additional details
$sql_students = "SELECT students.students_name, students.students_email, students.gender, students.profile_picture
                 FROM course_enroll 
                 INNER JOIN students ON course_enroll.students_id = students.students_id
                 WHERE course_enroll.course_id = ? AND course_enroll.class_id = ?";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("ii", $course_id, $class_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();

// Fetch all student details
$students = [];
while ($row = $result_students->fetch_assoc()) {
    $students[] = $row;
}

// Close the database connection
$stmt->close();
$stmt_students->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
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
        .course-details {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .course-details h3 {
            margin: 0;
        }
        .student-list {
            margin-top: 20px;
            text-align: left;
        }
        .student-item {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .student-picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            background-color: #fff;
        }
        .student-info {
            display: inline-block;
            color: #fff;
        }
        .btn-back {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>View Students</h2>
    
    <div class="course-details">
        <h3>Course: <?php echo htmlspecialchars($course_name); ?></h3>
        <p>Teacher: <?php echo htmlspecialchars($teacher_name); ?></p>
    </div>
    
    <div class="student-list">
        <h4>Enrolled Students:</h4>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $student): ?>
                <div class="student-item">
                    <!-- Display profile picture if available, otherwise show a placeholder -->
                    <?php 
                    $profilePic = !empty($student['profile_picture']) ? htmlspecialchars($student['profile_picture']) : 'uploads/placeholder.png'; 
                    ?>
                    <img src="<?php echo $profilePic; ?>" alt="Profile Picture" class="student-picture">
                    <div class="student-info">
                        <strong>Name:</strong> <?php echo htmlspecialchars($student['students_name']); ?><br>
                        <strong>Email:</strong> <?php echo htmlspecialchars($student['students_email']); ?><br>
                        <strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No students enrolled in this course/class.</p>
        <?php endif; ?>
    </div>

    <a href="teacher_dashboard.php" class="btn-back">Back to Dashboard</a>
</div>

</body>
</html>