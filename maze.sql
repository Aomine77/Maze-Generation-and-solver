-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 03:00 PM
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
-- Database: `maze`
--

-- --------------------------------------------------------

--
-- Table structure for table `maze_user`
--

CREATE TABLE `maze_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_verified` varchar(25) DEFAULT '0',
  `is_created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maze_user`
--

INSERT INTO `maze_user` (`user_id`, `username`, `email`, `passkey`, `otp`, `otp_verified`, `is_created_at`) VALUES
(22, 'user', 'sthabipin29@gmail.com', '$2y$10$J61H5Gu3IM6oDwewTJrGpOkQAzGcShX0pXhk/vuvMgR/rnJffsF4a', '689332', '1', '2024-08-16 20:07:38'),
(24, 'Bipin', 'sthabipin27@gmail.com', '$2y$10$PnkJUThyUSnQNlzfCXyCi.EmUSEn67Ego3HWQxWEd4oqujiIzL5ba', '124005', '1', '2024-08-17 07:46:27'),
(26, 'test', 'sthabipin22@gmail.com', '$2y$10$f66RZ/ubXEIikAboIrjoHO48OLxFEPKsPB9Y45doZZG7.zZcgSTCu', '340779', '0', '2024-08-17 07:48:53'),
(27, 'Aomine', 'sthabipin0713@gmail.com', '$2y$10$D9FsgMsYWomear2OtEeF9eXItaWxUHm5xp.5K37G81fqkZCcMKcDS', '947107', '1', '2024-09-23 18:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_scores`
--

CREATE TABLE `user_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Level` varchar(255) NOT NULL,
  `time_taken` varchar(225) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_scores`
--

INSERT INTO `user_scores` (`id`, `user_id`, `Level`, `time_taken`, `created_at`) VALUES
(24, 24, 'easy', '00:32', '2024-09-20 02:29:37'),
(25, 24, 'veryeasy', '00:10', '2024-09-20 02:30:38'),
(26, 24, 'veryeasy', '00:08', '2024-09-20 06:32:28'),
(27, 24, 'veryeasy', '00:07', '2024-09-20 21:48:19'),
(28, 24, 'veryeasy', '00:11', '2024-09-21 00:12:20'),
(29, 24, 'veryeasy', '00:08', '2024-09-22 06:42:34'),
(30, 24, 'veryeasy', '00:09', '2024-09-22 06:44:27'),
(31, 24, 'veryeasy', '00:08', '2024-09-22 06:45:07'),
(32, 24, 'veryeasy', '00:08', '2024-09-22 06:45:21'),
(33, 24, 'veryeasy', '00:08', '2024-09-22 06:45:50'),
(34, 24, 'veryeasy', '00:09', '2024-09-22 06:47:05'),
(35, 24, 'veryeasy', '00:09', '2024-09-22 06:47:12'),
(36, 24, 'veryeasy', '00:10', '2024-09-22 06:53:16'),
(37, 24, 'medium', '00:47', '2024-09-22 22:47:35'),
(38, 24, 'veryeasy', '00:07', '2024-09-22 22:53:12'),
(39, 24, 'veryeasy', '00:10:45', '2024-09-22 22:53:48'),
(40, 27, 'veryeasy', '00:11:00', '2024-09-23 07:11:41'),
(41, 27, 'veryeasy', '00:07:77', '2024-09-23 07:12:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `maze_user`
--
ALTER TABLE `maze_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `maze_user`
--
ALTER TABLE `maze_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_scores`
--
ALTER TABLE `user_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD CONSTRAINT `user_scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `maze_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
