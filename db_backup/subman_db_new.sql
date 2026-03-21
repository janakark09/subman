-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 03:39 PM
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
-- Database: `subman_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(32) NOT NULL,
  `user` int(32) NOT NULL,
  `description` varchar(500) NOT NULL,
  `attUser` int(32) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `NotifyStatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user`, `description`, `attUser`, `createdDT`, `NotifyStatus`) VALUES
(1, 1001, 'Agreement No:  1 has been approved by System Admin.', 1001, '2026-03-21 15:40:09', 0),
(2, 1001, 'Agreement No:  2 has been cancelled by System Admin.', 1001, '2026-03-21 15:42:05', 0),
(3, 1001, 'Gatepass No:  1 has been approved by System Admin.', 1001, '2026-03-21 15:49:20', 0),
(4, 1001, 'Gatepass No:  2 has been approved by System Admin.', 1001, '2026-03-21 15:51:43', 0),
(5, 1002, 'Production Record No:  2 has been approved by Nihal Perera.', 1002, '2026-03-21 16:14:59', 0),
(6, 1002, 'Production Record No:  1 has been approved by Nihal Perera.', 1002, '2026-03-21 16:18:13', 0),
(7, 1001, 'GRN No:  1 has been approved by System Admin.', 1001, '2026-03-21 16:35:38', 0),
(8, 1001, 'Payment No:  1001 has been approved by System Admin.', 1001, '2026-03-21 16:40:21', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Notify_user` (`user`),
  ADD KEY `FK_Notify_att` (`attUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_Notify_att` FOREIGN KEY (`attUser`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Notify_user` FOREIGN KEY (`user`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
