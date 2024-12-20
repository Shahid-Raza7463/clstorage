-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 11:03 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `notificationreadorunread`
--

CREATE TABLE `notificationreadorunread` (
  `id` int(11) NOT NULL,
  `notifications_id` int(11) NOT NULL,
  `readedby` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notificationreadorunread`
--

INSERT INTO `notificationreadorunread` (`id`, `notifications_id`, `readedby`, `status`, `created_at`, `updated_at`) VALUES
(53, 19, 844, 1, '2023-12-11 09:27:32', '2023-12-11 09:27:32'),
(54, 9, 847, 1, '2023-12-11 09:28:03', '2023-12-11 09:28:03'),
(55, 10, 878, 1, '2023-12-11 09:29:45', '2023-12-11 09:29:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notificationreadorunread`
--
ALTER TABLE `notificationreadorunread`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notificationreadorunread`
--
ALTER TABLE `notificationreadorunread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
