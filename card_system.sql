-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 11:47 AM
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
-- Database: `card_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(150) NOT NULL,
  `target_type` varchar(80) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `target_type`, `target_id`, `description`, `created_at`) VALUES
(1, 1, 'Login', 'User', 1, 'User logged in', '2026-05-12 09:45:00'),
(2, 1, 'Create staff', 'Staff', 0, 'Added staff record: kevin abuta nyamweya', '2026-05-12 09:46:39'),
(3, 1, 'Generate card', 'JobCard', 0, 'Generated card for kevin abuta nyamweya', '2026-05-12 09:48:58'),
(4, 1, 'Delete staff', 'Staff', 1, 'Deleted staff record: kevin abuta nyamweya', '2026-05-12 10:23:19'),
(5, 1, 'Create staff', 'Staff', 0, 'Added staff record: kevin abuta nyamweya', '2026-05-12 10:24:02'),
(6, 1, 'Generate card', 'JobCard', 0, 'Generated card for kevin abuta nyamweya', '2026-05-12 10:24:05'),
(7, 1, 'Generate card', 'JobCard', 0, 'Generated card for kevin abuta nyamweya', '2026-05-12 11:48:48'),
(8, 1, 'Login', 'User', 1, 'User logged in', '2026-05-13 10:33:42'),
(9, 1, 'Login', 'User', 1, 'User logged in', '2026-05-13 12:14:13'),
(10, 1, 'Login', 'User', 1, 'User logged in', '2026-05-14 07:31:42'),
(11, 1, 'Create user', 'User', 0, 'Created user account for Kevin Nyamweya', '2026-05-14 08:17:20'),
(12, 1, 'Update user', 'User', 2, 'Updated user account for Kevin Nyamweya', '2026-05-14 08:17:59'),
(13, 1, 'Update user', 'User', 1, 'Updated user account for Administrator', '2026-05-14 08:18:11'),
(14, 1, 'Delete card', 'JobCard', 2, 'Deleted job card for kevin abuta nyamweya', '2026-05-14 08:21:06'),
(15, 1, 'Login', 'User', 1, 'User logged in', '2026-05-14 08:48:33'),
(16, 2, 'Login', 'User', 2, 'User logged in', '2026-05-14 08:51:38'),
(17, 1, 'Login', 'User', 1, 'User logged in', '2026-05-14 08:53:05'),
(18, 1, 'Update user', 'User', 2, 'Updated user account for Kevin Nyamweya', '2026-05-14 08:54:02'),
(19, 2, 'Login', 'User', 2, 'User logged in', '2026-05-14 08:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`) VALUES
(1, 'Physical Planning', '2026-05-12 09:33:53'),
(2, 'Survey of Kenya', '2026-05-12 09:33:53'),
(3, 'NTC', '2026-05-12 09:33:53'),
(4, 'HR', '2026-05-12 09:33:53'),
(5, 'ICT', '2026-05-12 09:33:53'),
(6, 'GDC', '2026-05-13 12:12:56'),
(7, 'KISM', '2026-05-13 12:12:56'),
(8, 'NYS', '2026-05-13 12:12:56'),
(9, 'CORRESPONDENCE', '2026-05-13 12:12:56'),
(10, 'EMBAKASI RANCHING', '2026-05-13 12:12:56'),
(11, 'JNAM', '2026-05-13 12:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `job_cards`
--

CREATE TABLE `job_cards` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `card_number` varchar(120) NOT NULL,
  `issued_at` date NOT NULL,
  `expires_at` date NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_cards`
--

INSERT INTO `job_cards` (`id`, `staff_id`, `card_number`, `issued_at`, `expires_at`, `qr_code`, `created_at`) VALUES
(3, 2, 'CARD-F291F586E8', '2026-05-12', '2026-07-12', 'card_2_1778586528.png', '2026-05-12 11:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `type` enum('info','warning','alert') NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `id_number` varchar(100) NOT NULL,
  `designation` varchar(120) NOT NULL,
  `station` varchar(120) NOT NULL,
  `department_id` int(11) NOT NULL,
  `passport_photo` varchar(255) DEFAULT NULL,
  `signature_image` varchar(255) DEFAULT NULL,
  `date_issued` date NOT NULL,
  `expiry_date` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `full_name`, `id_number`, `designation`, `station`, `department_id`, `passport_photo`, `signature_image`, `date_issued`, `expiry_date`, `status`, `created_at`) VALUES
(2, 'kevin abuta nyamweya', '39239415', 'ict attachee', 'ardhi house', 5, 'photos/6a02ffc20038b_passport.jpg', '', '2026-05-12', '2026-07-12', 'Active', '2026-05-12 10:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Super Admin','Admin','HR Officer','ICT Officer','Viewer') NOT NULL DEFAULT 'Viewer',
  `email` varchar(150) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `email`, `last_login`, `created_at`, `reset_token`, `reset_expiry`, `status`) VALUES
(1, 'Administrator', 'admin', '$2y$10$E19AqTc6MfyJEcYGP31gFeGt5T8E5lbL9fHJ996pDPHPI4ggpqDJS', 'Admin', 'admin@landsplanning.gov.ke', '2026-05-14 11:53:05', '2026-05-12 09:33:53', NULL, NULL, 'Active'),
(2, 'Kevin Nyamweya', 'Lands', '$2y$10$fhsqXlqhQvaj54DiGjoGp.ViP/VxDwjMEJIC80lwEw5Y.BNRPdbU.', 'Admin', 'landsict811@gmail.com', '2026-05-14 11:54:26', '2026-05-14 08:17:20', '3c34e75061667caf3c18ebe5c9cb3176a8204b47970af44f1a2b867403c5a923', '2026-05-14 12:15:30', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_cards`
--
ALTER TABLE `job_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_number` (`card_number`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_cards`
--
ALTER TABLE `job_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `job_cards`
--
ALTER TABLE `job_cards`
  ADD CONSTRAINT `job_cards_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
