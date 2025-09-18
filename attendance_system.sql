-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 01:13 PM
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
  `a_time_out` time NOT NULL,
  `a_user` int(11) NOT NULL,
  `a_actual_time_in` time NOT NULL,
  `a_actual_time_out` time NOT NULL,
  `a_timesheet` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`a_id`, `a_date`, `a_time_in`, `a_time_out`, `a_user`, `a_actual_time_in`, `a_actual_time_out`, `a_timesheet`) VALUES
(17, '2025-09-15', '11:00:00', '22:00:00', 2, '11:00:00', '22:00:00', ''),
(18, '2025-08-07', '14:48:00', '23:21:00', 2, '11:00:00', '22:00:00', ''),
(20, '2025-09-18', '13:10:02', '13:11:01', 2, '11:00:00', '22:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `ia_id` int(11) NOT NULL,
  `ia_address` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ip_addresses`
--

INSERT INTO `ip_addresses` (`ia_id`, `ia_address`) VALUES
(1, '192.155.10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(70) NOT NULL,
  `u_email` varchar(50) NOT NULL,
  `u_password` varchar(50) NOT NULL,
  `u_profile_img` varchar(300) NOT NULL,
  `u_role` enum('Admin','User') NOT NULL,
  `u_status` enum('0','1') NOT NULL,
  `u_designation` varchar(50) NOT NULL,
  `u_salary` float NOT NULL,
  `u_dob` date NOT NULL,
  `u_job_type` enum('Permanent','Probation','Notice Period') NOT NULL,
  `u_joining_date` date NOT NULL,
  `u_working_days` int(11) NOT NULL,
  `u_time_in` time NOT NULL,
  `u_time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_profile_img`, `u_role`, `u_status`, `u_designation`, `u_salary`, `u_dob`, `u_job_type`, `u_joining_date`, `u_working_days`, `u_time_in`, `u_time_out`) VALUES
(1, 'Admin ', 'admin@domain.com', '@dmin12345', 'Logo.png', 'Admin', '1', 'Boss', 0, '2025-09-12', '', '2025-09-10', 0, '00:00:00', '00:00:00'),
(2, 'Arbaz Ali', 'arbu1499@gmail.com', 'arbazali', '', 'User', '1', 'CEO of HakamTechSol', 130000, '1999-01-14', 'Permanent', '2025-09-10', 7, '11:00:00', '22:00:00'),
(5, 'Ibrahim Sharif', 'ibrahimsharif3812@gmail.com', '12345', '', 'User', '1', 'Team Lead', 35000, '2025-09-11', 'Probation', '2025-09-10', 0, '14:00:00', '21:00:00'),
(6, 'Aqsa Hussain', 'aqsahussain126@gmail.com', '12345', '', 'User', '1', 'Freelancer Bidder', 10000, '2002-06-12', 'Probation', '2025-08-26', 0, '11:00:00', '18:00:00'),
(7, 'Mohammad Noman', 'mughal17071999@gmail.com', '12345', '', 'User', '1', 'PHP/Laravel Developer', 20000, '1999-07-17', 'Probation', '2025-05-01', 6, '11:00:00', '20:00:00');

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
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`ia_id`);

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
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `ia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
