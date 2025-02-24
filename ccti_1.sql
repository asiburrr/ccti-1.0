-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 07:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccti_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `activities` datetime NOT NULL,
  `password` text NOT NULL,
  `salt` text NOT NULL,
  `user_token` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `role`, `username`, `email`, `phone_number`, `first_name`, `last_name`, `full_name`, `activities`, `password`, `salt`, `user_token`, `timestamp`) VALUES
(1001, 'administration', 'asiburrahman1001', 'asiburarave@gmail.com', '01927573409', 'Asibur Rahman', 'Aravi', 'Asibur Rahman Aravi', '2025-02-12 22:28:54', 'a41f2324771cf90f12c47e250d458d08bf0ace3ce005fa8451ff6ae1920d918d', 'NmREvztBlTFuvR7I6Tas7sBtb4sVlukn', 'KVbP3n5LD8NR4DB5AR4B9HQ64zcCbsONrduynhKq9j8gORRBGjT8rgn3BDLPZDOs', '2024-05-15 17:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `fee` int(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `name`, `start_time`, `end_time`, `fee`, `timestamp`) VALUES
(1, ' Showing rows 0 - 0 (1 total, Query took 0.0003 seconds.)', '10:00', '11:00', 2000, '2024-12-13 05:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `c_users`
--

CREATE TABLE `c_users` (
  `student_id` bigint(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `full_name` varchar(100) GENERATED ALWAYS AS (concat(`first_name`,' ',`last_name`)) STORED,
  `education_level` enum('JSC','SSC') NOT NULL,
  `roll` varchar(20) NOT NULL,
  `registration` varchar(20) NOT NULL,
  `institute` varchar(150) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `board` enum('Mymensingh','Dhaka','Chattogram','Cumilla','Sylhet','Barisal','Dinajpur','Rajshahi','Jashore','Technical','Madrasah') NOT NULL,
  `dob` date NOT NULL,
  `id_type` enum('Birth Certificate','National ID Card') NOT NULL,
  `id_no` varchar(50) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_number` char(11) NOT NULL,
  `guardian_number` char(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `religion` enum('Islam','Hinduism','Buddhism','Christianity') NOT NULL,
  `photos` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `terms` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `c_users`
--

INSERT INTO `c_users` (`student_id`, `first_name`, `last_name`, `education_level`, `roll`, `registration`, `institute`, `passing_year`, `board`, `dob`, `id_type`, `id_no`, `father_name`, `mother_name`, `address`, `email`, `user_number`, `guardian_number`, `guardian_name`, `gender`, `religion`, `photos`, `password`, `salt`, `terms`, `timestamp`) VALUES
(1, 'Asibur', 'Aravi', 'JSC', '207949', '11', 'Altaf Golondaz Collage', '2010', 'Mymensingh', '2009-12-31', 'Birth Certificate', '111', 'ddddddd', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburarave@gmail.com', '01927573409', '01927573409', 'aa', 'Male', 'Islam', NULL, '', '', 1, '2025-02-23 17:39:36'),
(4, 'Asibur', 'Aravi', 'JSC', '207949', '222', 'Altaf Golondaz Collage', '2025', 'Mymensingh', '2009-12-30', 'Birth Certificate', '1111', 'ddddddd', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburaravi@gmail.com', '01927573408', '01927573409', 'aaa', 'Male', 'Islam', NULL, '', '', 1, '2025-02-23 17:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `en_id` int(50) NOT NULL,
  `course_id` varchar(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`en_id`, `course_id`, `student_id`, `timestamp`) VALUES
(1, '1', '11111', '2024-12-13 05:50:43'),
(2, '1', '11112', '2024-12-13 06:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(50) NOT NULL,
  `invid` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `due_amount` int(255) NOT NULL,
  `received_amount` int(255) NOT NULL,
  `discount` int(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `invid`, `student_id`, `course_id`, `amount`, `due_amount`, `received_amount`, `discount`, `timestamp`) VALUES
(1, 'INV1734069043', '11111', '1', 2000, 0, 2000, 0, '2024-12-13 05:50:43'),
(2, 'INV1734069976', '11112', '1', 2000, 2000, 0, 0, '2024-12-13 06:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `ph_id` int(50) NOT NULL,
  `invid` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `amount` int(100) NOT NULL,
  `discount` int(100) NOT NULL,
  `trxid` varchar(255) NOT NULL,
  `method` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`ph_id`, `invid`, `student_id`, `course_id`, `amount`, `discount`, `trxid`, `method`, `timestamp`) VALUES
(1, 'INV1734069043', '11111', '1', 2000, 0, 'TRX1734069112', 'Cash', '2024-12-13 05:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `sms_history`
--

CREATE TABLE `sms_history` (
  `sms_id` int(100) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `student_id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `education_level` varchar(50) NOT NULL,
  `roll` varchar(50) NOT NULL,
  `registration` varchar(100) NOT NULL,
  `institute` varchar(255) NOT NULL,
  `passing_year` varchar(50) NOT NULL,
  `board` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `id_type` varchar(50) NOT NULL,
  `id_no` varchar(200) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `address` varchar(400) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_number` varchar(255) NOT NULL,
  `guardian_number` varchar(100) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `photos` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `salt` varchar(1000) NOT NULL,
  `terms` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`student_id`, `first_name`, `last_name`, `full_name`, `education_level`, `roll`, `registration`, `institute`, `passing_year`, `board`, `dob`, `id_type`, `id_no`, `father_name`, `mother_name`, `address`, `email`, `user_number`, `guardian_number`, `guardian_name`, `gender`, `religion`, `photos`, `password`, `salt`, `terms`, `timestamp`) VALUES
(1, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', 'er', 'Altaf Golondaz Collage', '2025', 'Mymensingh', '2009-12-29', 'Birth Certificate', '1234', 'ddddddd', 'ad', 'Near the bus station Gafargaon, Mymensingh', 'asiburarave@gmail.com', '01927573409', '01927573409', 'aaa', 'Male', 'Islam', '', '', '', '1', '2025-02-23 17:19:21'),
(2, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', '11', 'Altaf Golondaz Collage', '2009', 'Mymensingh', '2009-12-31', 'National ID Card', '1234', 'ddddddd', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburaravi@gmail.com', '01927573409', '01927573409', 'aa', 'Male', 'Islam', '', '', '', '1', '2025-02-23 17:24:29'),
(3, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', '222', 'Altaf Golondaz Collage', '2025', 'Mymensingh', '2009-12-31', 'Birth Certificate', '1234', 'ddddddd', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburaravea@gmail.com', '01927573409', '01927573409', 'sda', 'Male', 'Islam', '', '', '', '1', '2025-02-23 18:11:23'),
(4, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', '44', 'Altaf Golondaz Collage', '2024', 'Mymensingh', '2009-12-29', 'Birth Certificate', '1234', 'ddddddd', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburarav@gmail.com', '01927573409', '01927573409', '55', 'Male', 'Islam', '', '', '', '1', '2025-02-24 08:32:20'),
(5, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', '212', 'Altaf Golondaz Collage', '2010', 'Mymensingh', '2009-12-31', 'Birth Certificate', '1234', 'Shahanur Rahmann', 'ROKEYA BEGUM', 'Near the bus station Gafargaon, Mymensingh', 'asiburaraasave@gmail.com', '01927573409', '01927573409', 'aa', 'Male', 'Islam', '', '', '', '1', '2025-02-24 08:51:04'),
(6, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', 'aa', 'Altaf Golondaz Collage', '2025', 'Mymensingh', '2009-12-30', 'Birth Certificate', '1234', 'ddddddd', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburarava@gmail.com', '01927573409', '01927573409', 'aaa', 'Male', 'Islam', '', '', '', '1', '2025-02-24 09:08:39'),
(7, 'Asibur', 'Aravi', 'Asibur Aravi', 'JSC', '207949', '111', 'Altaf Golondaz Collage', '2025', 'Mymensingh', '2009-12-30', 'Birth Certificate', '1234', 'aa', 'add', 'Near the bus station Gafargaon, Mymensingh', 'asiburaravii@gmail.com', '01927573409', '01927573409', 'aa', 'Male', 'Islam', '', '', '', '1', '2025-02-24 09:19:43'),
(8, 'Asibur Rahman', 'Aravi', 'Asibur Rahman Aravi', 'JSC', 'Gtr', 'Hha', 'Altaf Golondaz Degree College', '2018', 'Barisal', '2009-12-08', 'Birth Certificate', 'Haha', 'Md ismail bhuiyan', 'Nurnesa begum', 'Gafargaon, Mymensingh', 'asiburaraveaj@gmail.com', '01927573409', '01927573409', 'Hha', 'Male', 'Islam', '', '', '', '1', '2025-02-24 09:23:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `c_users`
--
ALTER TABLE `c_users`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `id_no` (`id_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_number` (`user_number`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_user_number` (`user_number`),
  ADD KEY `idx_users_roll` (`roll`),
  ADD KEY `idx_users_id_no` (`id_no`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`ph_id`);

--
-- Indexes for table `sms_history`
--
ALTER TABLE `sms_history`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `c_users`
--
ALTER TABLE `c_users`
  MODIFY `student_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `en_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `ph_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_history`
--
ALTER TABLE `sms_history`
  MODIFY `sms_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `student_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
