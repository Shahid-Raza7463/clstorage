-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 10:50 AM
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
-- Table structure for table `leaverequest`
--

CREATE TABLE `leaverequest` (
  `id` int(11) NOT NULL,
  `applyleaveid` int(11) NOT NULL,
  `createdby` int(11) DEFAULT NULL,
  `approver` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaverequest`
--

INSERT INTO `leaverequest` (`id`, `applyleaveid`, `createdby`, `approver`, `reason`, `date`, `status`, `created_at`, `updated_at`) VALUES
(2, 131, 844, 878, 'aaaaaaaaaa', '2023-12-14', 1, '2023-12-13 10:08:49', '2023-12-13 10:08:49'),
(3, 132, 844, 878, 'qwqw', '2023-12-20', 0, '2023-12-15 08:43:01', '2023-12-15 08:43:01'),
(4, 133, 844, 878, 'yyyy', '2024-01-03', 0, '2023-12-15 20:22:59', '2023-12-15 20:22:59'),
(6, 135, 844, 878, 'song', '2024-01-18', 1, '2023-12-16 07:47:29', '2023-12-16 07:47:29'),
(7, 137, 844, 878, 'qqqqqqqq', '2024-02-03', 1, '2023-12-16 11:08:45', '2023-12-16 11:08:45'),
(8, 138, 844, 878, 'ccccccccccc', '2024-03-04', 1, '2023-12-16 11:26:25', '2023-12-16 11:26:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leaverequest`
--
ALTER TABLE `leaverequest`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaverequest`
--
ALTER TABLE `leaverequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
