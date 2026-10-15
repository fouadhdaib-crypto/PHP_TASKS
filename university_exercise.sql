-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2026 at 01:35 PM
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
-- Database: `university_exercise`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `enroll_student` (IN `p_student_id` INT UNSIGNED, IN `p_assignment_id` INT UNSIGNED)  MODIFIES SQL DATA BEGIN
    DECLARE v_course_id INT UNSIGNED;
    DECLARE v_capacity INT UNSIGNED;
    DECLARE v_count INT UNSIGNED;
    DECLARE v_found BOOLEAN DEFAULT TRUE;

    DECLARE CONTINUE HANDLER FOR NOT FOUND
        SET v_found = FALSE;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    SELECT course_id, capacity
    INTO v_course_id, v_capacity
    FROM CourseAssignments
    WHERE assignment_id = p_assignment_id
    FOR UPDATE;

    IF NOT v_found THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Course offering does not exist';
    END IF;

    SELECT COUNT(*)
    INTO v_count
    FROM Enrollments
    WHERE assignment_id = p_assignment_id;

    IF NOT EXISTS (
        SELECT 1 FROM Students
        WHERE student_id = p_student_id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Student does not exist';
    END IF;

    IF EXISTS (
        SELECT 1 FROM Enrollments
        WHERE student_id = p_student_id
          AND assignment_id = p_assignment_id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Student is already enrolled';
    END IF;

    IF v_count >= v_capacity THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Course capacity exceeded';
    END IF;

    INSERT INTO Enrollments
        (student_id, course_id, assignment_id, grade)
    VALUES
        (p_student_id, v_course_id, p_assignment_id, NULL);

    COMMIT;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `student_age` (`p_date_of_birth` DATE) RETURNS INT(11) NO SQL BEGIN
    RETURN TIMESTAMPDIFF(YEAR, p_date_of_birth, CURDATE());
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courseassignments`
--

CREATE TABLE `courseassignments` (
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `instructor_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `semester` enum('Spring','Summer','Fall') NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `capacity` smallint(5) UNSIGNED NOT NULL DEFAULT 30
) ;

--
-- Dumping data for table `courseassignments`
--

INSERT INTO `courseassignments` (`assignment_id`, `instructor_id`, `course_id`, `semester`, `year`, `capacity`) VALUES
(1, 1, 1, 'Fall', 2026, 30),
(2, 2, 2, 'Fall', 2026, 30),
(3, 3, 3, 'Fall', 2026, 30),
(4, 4, 4, 'Fall', 2026, 30),
(5, 5, 5, 'Fall', 2026, 30),
(6, 2, 6, 'Fall', 2026, 20);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(10) UNSIGNED NOT NULL,
  `course_name` varchar(120) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `credits` tinyint(3) UNSIGNED NOT NULL,
  `department` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `credits`, `department`) VALUES
(1, 'Introduction to Programming', 'CS101', 3, 'Computer Science'),
(2, 'Database Systems', 'CS201', 3, 'Computer Science'),
(3, 'Calculus I', 'MATH101', 4, 'Mathematics'),
(4, 'General Physics', 'PHY101', 4, 'Physics'),
(5, 'Academic Writing', 'ENG101', 2, 'English'),
(6, 'Artificial Intelligence', 'CS301', 3, 'Computer Science');

-- --------------------------------------------------------

--
-- Stand-in structure for view `enrollmentgradepoints`
-- (See below for the actual view)
--
CREATE TABLE `enrollmentgradepoints` (
`enrollment_id` int(10) unsigned
,`student_id` int(10) unsigned
,`course_id` int(10) unsigned
,`assignment_id` int(10) unsigned
,`grade` char(1)
,`grade_points` decimal(2,1)
);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `grade` char(1) DEFAULT NULL
) ;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `assignment_id`, `grade`) VALUES
(1, 1, 1, 1, 'A'),
(2, 1, 2, 2, 'A'),
(3, 1, 3, 3, 'B'),
(4, 1, 4, 4, 'A'),
(5, 2, 1, 1, 'B'),
(6, 2, 3, 3, 'A'),
(7, 3, 3, 3, 'B'),
(8, 3, 4, 4, 'A'),
(9, 4, 1, 1, 'A'),
(10, 4, 2, 2, 'B'),
(11, 5, 1, 1, 'C'),
(12, 5, 5, 5, 'B'),
(13, 6, 2, 2, 'B'),
(14, 6, 3, 3, 'A'),
(15, 7, 3, 3, 'C'),
(16, 7, 4, 4, 'B'),
(17, 8, 1, 1, 'A'),
(18, 8, 2, 2, 'I'),
(19, 9, 4, 4, 'D'),
(20, 9, 5, 5, 'B'),
(21, 10, 1, 1, NULL),
(22, 10, 5, 5, 'A'),
(23, 2, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `hire_date` date NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `first_name`, `last_name`, `email`, `hire_date`, `department`) VALUES
(1, 'Amal', 'Haddad', 'amal@example.edu', '2015-08-20', 'Computer Science'),
(2, 'Rami', 'Mansour', 'rami@example.edu', '2017-02-01', 'Computer Science'),
(3, 'Dina', 'Saad', 'dina@example.edu', '2014-09-01', 'Mathematics'),
(4, 'Fadi', 'Jaber', 'fadi@example.edu', '2018-01-15', 'Physics'),
(5, 'Leila', 'Yasin', 'leila@example.edu', '2016-08-10', 'English');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `major` varchar(100) NOT NULL,
  `enrollment_year` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `date_of_birth`, `gender`, `major`, `enrollment_year`) VALUES
(1, 'Adam', 'Ali', 'adam@example.edu', '2004-03-15', 'Male', 'Computer Science', 2023),
(2, 'Sara', 'Omar', 'sara@example.edu', '2005-07-20', 'Female', 'Mathematics', 2023),
(3, 'Yousef', 'Hassan', 'yousef@example.edu', '2003-11-05', 'Male', 'Physics', 2022),
(4, 'Lina', 'Khalil', 'lina@example.edu', '2004-01-12', 'Female', 'Computer Science', 2023),
(5, 'Omar', 'Saleh', 'omar@example.edu', '2005-09-30', 'Male', 'English', 2024),
(6, 'Nour', 'Ahmad', 'nour@example.edu', '2004-06-18', 'Female', 'Mathematics', 2023),
(7, 'Zaid', 'Nasser', 'zaid@example.edu', '2003-12-25', 'Male', 'Physics', 2022),
(8, 'Maya', 'Samir', 'maya@example.edu', '2005-04-10', 'Female', 'Computer Science', 2024),
(9, 'Kareem', 'Farah', 'kareem@example.edu', '2004-08-22', 'Male', 'English', 2023),
(10, 'Hana', 'Issa', 'hana@example.edu', '2005-02-14', 'Female', 'Computer Science', 2024);

-- --------------------------------------------------------

--
-- Structure for view `enrollmentgradepoints`
--
DROP TABLE IF EXISTS `enrollmentgradepoints`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `enrollmentgradepoints`  AS SELECT `e`.`enrollment_id` AS `enrollment_id`, `e`.`student_id` AS `student_id`, `e`.`course_id` AS `course_id`, `e`.`assignment_id` AS `assignment_id`, `e`.`grade` AS `grade`, CASE `e`.`grade` WHEN 'A' THEN 4.0 WHEN 'B' THEN 3.0 WHEN 'C' THEN 2.0 WHEN 'D' THEN 1.0 WHEN 'F' THEN 0.0 ELSE NULL END AS `grade_points` FROM `enrollments` AS `e` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courseassignments`
--
ALTER TABLE `courseassignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `course_id` (`course_id`,`semester`,`year`),
  ADD UNIQUE KEY `assignment_id` (`assignment_id`,`course_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `idx_assignment_term` (`year`,`semester`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `idx_course_code` (`course_code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`assignment_id`),
  ADD KEY `idx_enrollment_assignment` (`assignment_id`,`course_id`),
  ADD KEY `idx_enrollment_course_student` (`course_id`,`student_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `uq_student_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courseassignments`
--
ALTER TABLE `courseassignments`
  MODIFY `assignment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courseassignments`
--
ALTER TABLE `courseassignments`
  ADD CONSTRAINT `courseassignments_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`),
  ADD CONSTRAINT `courseassignments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `enrollments_ibfk_3` FOREIGN KEY (`assignment_id`,`course_id`) REFERENCES `courseassignments` (`assignment_id`, `course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
