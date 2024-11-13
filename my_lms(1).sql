-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 02:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(2) NOT NULL,
  `admin_name` varchar(10) NOT NULL,
  `admin_email` varchar(20) NOT NULL,
  `admin_password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(3, 'noman', 'noman123@gmail.com', '$2y$10$IrJ');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `assignment_title` varchar(255) NOT NULL,
  `assignment_description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `assignment_title`, `assignment_description`, `due_date`, `course_id`, `class_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(5, 'sdfsf', 'fs', '2023-10-02', 3, 3, 2, '2024-11-08 17:13:23', '2024-11-08 17:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `assign_course`
--

CREATE TABLE `assign_course` (
  `assign_c_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assign_course`
--

INSERT INTO `assign_course` (`assign_c_id`, `class_id`, `teacher_id`, `course_id`) VALUES
(18, 1, 1, 6),
(20, 2, 1, 6),
(22, 5, 1, 7),
(23, 3, 2, 3),
(24, 6, 2, 5),
(25, 3, 2, 4),
(27, 8, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(10) NOT NULL,
  `class_name` varchar(10) NOT NULL,
  `total_students` int(11) DEFAULT 0,
  `girls_total` int(11) DEFAULT 0,
  `boys_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `total_students`, `girls_total`, `boys_total`) VALUES
(1, '9th', 3, 0, 3),
(2, '10th', 3, 2, 1),
(3, '11th', 1, 0, 1),
(5, '7th', 0, NULL, NULL),
(6, '8th', 0, NULL, NULL),
(7, '12th', 1, 1, NULL),
(8, '4th', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(100) NOT NULL,
  `course_name` varchar(10) NOT NULL,
  `course_des` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_des`) VALUES
(2, 'chemistry', 'learning'),
(3, 'biology', 'learning'),
(4, 'maths', 'learn'),
(5, 'urdu', 'learning'),
(6, 'islamiyat', 'learning'),
(7, 'chinease', 'hfsf'),
(8, 'chinease', 'hfsf'),
(9, 'english', 'jkkes'),
(10, 'freanc', 'jk'),
(11, 'freanc', 'jk');

-- --------------------------------------------------------

--
-- Table structure for table `course_enroll`
--

CREATE TABLE `course_enroll` (
  `enroll_id` int(11) NOT NULL,
  `students_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_enroll`
--

INSERT INTO `course_enroll` (`enroll_id`, `students_id`, `course_id`, `class_id`) VALUES
(4, 2, 7, 3),
(5, 2, 10, 3),
(8, 3, 9, 2),
(9, 3, 10, 2),
(10, 3, 10, 2),
(11, 3, 9, 2),
(12, 5, 9, 1),
(13, 5, 9, 1),
(14, 5, 9, 1),
(15, 2, 3, 3),
(16, 2, 6, 3),
(17, 2, 2, 3),
(18, 3, 7, 2),
(19, 1, 4, 1),
(20, 1, 8, 1),
(21, 1, 5, 1),
(22, 1, 7, 1),
(23, 7, 4, 2),
(24, 6, 4, 2),
(25, 7, 4, 2),
(28, 9, 4, 3),
(29, 3, 4, 3),
(36, 10, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `students_id` int(11) NOT NULL,
  `students_name` varchar(100) NOT NULL,
  `students_email` varchar(255) NOT NULL,
  `students_password` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`students_id`, `students_name`, `students_email`, `students_password`, `gender`, `class_id`, `profile_picture`) VALUES
(1, 'karim', 'karim123@gmail.com', '$2y$10$H9a5BQbePa6IXUGZt0CeLuZaF1.K5qqyuWOBDofkWTDEU4rhMonBC', 'Male', 1, 'uploads/profile_pictures/MYXJ_20240714202452163_save.jpg'),
(2, 'sakhi', 'sakhi123@gmail.com', '$2y$10$0TtulcPC8/yrDv5uIcq4MOtzcIHKeNAD6tao9ToyRrdm5V.ONuCSa', 'Male', 3, 'uploads/profile_pictures/IMG20240623200508.jpg'),
(3, 'manzoori', 'manzoor123@gmail.com', '$2y$10$q6exeh5j6a54w/dIQBh4heNHwVRY7PGZSXL/HX8mspQ.l9vzXccxO', 'Male', 2, 'uploads/profile_pictures/MYXJ_20240715142832923_fast.jpg'),
(4, 'tanveer', 'tanveer123@gmail.com', '$2y$10$liF.wqBDJXc8MZ5XRtSQmOKRPw3ID0ayPSdbVQG8oQyocpP6YJgKC', 'Male', 1, NULL),
(5, 'deedar', 'deedar123@gmail.com', '$2y$10$5.o2gxPjkVSMNF2RX1Z2e.cJx.9UlxJFwDWkqz8VbW.0YNWyviUwC', 'Male', 1, NULL),
(6, 'sania', 'sania123@gmail.com', '$2y$10$jplL.c4vPDIQjJ.hU1dafeiiTqdKjPqCH53iUS5eU1loNGLJwyxVS', 'Female', 2, NULL),
(7, 'sonia', 'sonia123@gmail.com', '$2y$10$wDL0.OylBeYC7wG5EyERm.GQa/gAKmZ2SfHDMe9XPAcBfSD5s88Re', 'Female', 2, NULL),
(8, 'anila', 'anila123@gmail.com', '$2y$10$LrQ81IDEBme.ywHg.ivgZuMmOcoWkqohI8CiboalreRXqep6Eh.1i', 'Female', 7, NULL),
(9, 'junaid', 'junaid123@gmail.com', '$2y$10$0nXvTYsrrM3YV1Mv8H4cWOOuB9qaU0hyzQjBuNstUiT4Mtz7bmvma', 'Male', 3, 'uploads/profile_pictures/IMG20240623200613.jpg'),
(10, 'NAEEM ', 'naeem123@gmail.com', '$2y$10$JVhnRokWNAW9h3jV0.rWLeKbLSdQIY4zJiLTLVIDDlRFnocBt85M2', 'Male', 8, 'uploads/profile_pictures/IMG20240620181631.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_email` varchar(255) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `teacher_quali` varchar(100) DEFAULT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `teacher_gender` enum('Male','Female','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_email`, `teacher_password`, `teacher_quali`, `teacher_name`, `teacher_gender`) VALUES
(1, 'aliyan123@gmail.com', '$2y$10$2ah6uR2AshuMGMsIBru41uVRtCwBe5G4xJr4VzYCioU6USn/sCxXO', 'bscs', 'aliyan', 'Male'),
(2, 'tasleem123@gmail.com', '$2y$10$4qNa5Zaoi1GoY3vF.8Qk/O9HBl7uVo/TMgsmgk0dQ5TWgLLmMdUiK', 'bs', 'tasleem', 'Female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `assign_course`
--
ALTER TABLE `assign_course`
  ADD PRIMARY KEY (`assign_c_id`),
  ADD KEY `keys1` (`class_id`),
  ADD KEY `keys2` (`course_id`),
  ADD KEY `key3` (`teacher_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_enroll`
--
ALTER TABLE `course_enroll`
  ADD PRIMARY KEY (`enroll_id`),
  ADD KEY `enroll_key1` (`students_id`),
  ADD KEY `enroll_key2` (`course_id`),
  ADD KEY `enroll_key3` (`class_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`students_id`),
  ADD UNIQUE KEY `students_email` (`students_email`),
  ADD KEY `fk_class_id` (`class_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `teacher_email` (`teacher_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assign_course`
--
ALTER TABLE `assign_course`
  MODIFY `assign_c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_enroll`
--
ALTER TABLE `course_enroll`
  MODIFY `enroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `students_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assignments_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE SET NULL;

--
-- Constraints for table `assign_course`
--
ALTER TABLE `assign_course`
  ADD CONSTRAINT `key3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keys1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keys2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_enroll`
--
ALTER TABLE `course_enroll`
  ADD CONSTRAINT `enroll_key1` FOREIGN KEY (`students_id`) REFERENCES `students` (`students_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enroll_key2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enroll_key3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
