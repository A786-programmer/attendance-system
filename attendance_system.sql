-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 02:50 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `a_id` int(11) NOT NULL,
  `a_date` date NOT NULL,
  `a_time_in` time NOT NULL,
  `a_time_out` time DEFAULT NULL,
  `a_user` int(11) NOT NULL,
  `a_actual_time_in` time NOT NULL,
  `a_actual_time_out` time DEFAULT NULL,
  `a_timesheet` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`a_id`, `a_date`, `a_time_in`, `a_time_out`, `a_user`, `a_actual_time_in`, `a_actual_time_out`, `a_timesheet`) VALUES
(17, '2025-09-15', '11:14:50', '22:00:00', 2, '11:00:00', '22:00:00', 'Working'),
(18, '2025-08-07', '14:48:00', '23:21:00', 2, '11:00:00', '22:00:00', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(24, '2025-09-20', '02:21:25', '02:22:36', 2, '11:00:00', '22:00:00', 'No worked done today');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `ec_id` int(11) NOT NULL,
  `ec_name` varchar(20) NOT NULL,
  `ec_relation` varchar(20) NOT NULL,
  `ec_number` varchar(15) NOT NULL,
  `ec_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `ia_id` int(11) NOT NULL,
  `ia_address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ip_addresses`
--

INSERT INTO `ip_addresses` (`ia_id`, `ia_address`) VALUES
(2, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `n_id` int(11) NOT NULL,
  `n_title` varchar(50) NOT NULL,
  `n_content` varchar(10000) NOT NULL,
  `n_user` int(11) NOT NULL,
  `n_date_time` datetime NOT NULL,
  `n_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(70) NOT NULL,
  `u_email` varchar(50) NOT NULL,
  `u_password` varchar(50) NOT NULL,
  `u_profile_img` varchar(300) DEFAULT NULL,
  `u_role` enum('Admin','User') NOT NULL,
  `u_status` enum('0','1') NOT NULL,
  `u_designation` varchar(50) NOT NULL,
  `u_salary` float NOT NULL,
  `u_dob` date NOT NULL,
  `u_job_type` enum('Permanent','Probation','Notice Period') NOT NULL,
  `u_joining_date` date NOT NULL,
  `u_working_days` int(11) NOT NULL,
  `u_time_in` time NOT NULL,
  `u_time_out` time NOT NULL,
  `u_nic_bayform` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_profile_img`, `u_role`, `u_status`, `u_designation`, `u_salary`, `u_dob`, `u_job_type`, `u_joining_date`, `u_working_days`, `u_time_in`, `u_time_out`, `u_nic_bayform`) VALUES
(1, 'Admin ', 'admin@domain.com', '@dmin', 'Logo.png', 'Admin', '1', 'Boss', 0, '2025-09-21', '', '2025-09-10', 0, '00:00:00', '00:00:00', NULL),
(2, 'Arbaz Ali', 'arbu1499@gmail.com', 'arbazali', '', 'User', '1', 'CEO of HakamTechSol', 130000, '1999-01-14', 'Permanent', '2025-09-10', 7, '11:00:00', '22:00:00', NULL),
(6, 'Aqsa Hussain', 'aqsahussain126@gmail.com', '12345', '', 'User', '1', 'Freelancer Bidder', 10000, '2002-06-12', 'Probation', '2025-08-26', 0, '11:00:00', '18:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `attendance_ibfk_1` (`a_user`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`ec_id`),
  ADD KEY `emergency_contacts_ibfk_1` (`ec_user`);

--
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`ia_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `ec_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `ia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `n_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`a_user`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD CONSTRAINT `emergency_contacts_ibfk_1` FOREIGN KEY (`ec_user`) REFERENCES `users` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
