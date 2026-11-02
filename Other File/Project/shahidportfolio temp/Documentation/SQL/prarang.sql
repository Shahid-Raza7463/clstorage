-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 11:34 PM
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
-- Database: `prarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `preview_image` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `preview_image`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'heading1', '<p style=\"text-align: justify;\"><font face=\"Inter, sans-serif\"><b>Hello, fellow colleagues! Today</b> I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do Hello, fellow colleagues! Today I will share my knowledge and</font></p>', 'images/GES5NPM23hwuJ05YatenjczTCVaLaZivNiQFBH2J.png', 'heading1', '2023-08-18 04:40:39', '2024-05-13 15:34:23'),
(2, 'heading2', '<b>Hello, fellow colleagues! Today</b> I will share my knowledge<span style=\"background-color: rgb(255, 0, 0);\"> and</span> observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, <span style=\"background-color: rgb(255, 255, 0);\">fellow </span>colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do Hello, fellow colleagues! Today I will share my knowledge and', 'images/hvxh4JTfFHYqeaTcjmOa4EE4zicLFPlT3CfnJDgj.jpg', 'heading2', '2023-08-18 04:42:11', '2024-05-13 15:34:35'),
(3, 'heading3', 'Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do Hello, fellow colleagues! Today I will share my knowledge and', 'images/kH3QIs6SnXYj6TSHkuXFryJ6O1cCgXGaqN7LEuSK.png', 'heading3', '2023-08-18 04:44:14', '2024-05-13 15:34:48'),
(4, 'heading4', 'Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do to start making money in the adult games niche under the PPS model and I’ll also tell you HOW you can do it. A quick intro My name is Alexander. I finished my studies 7 years ago and how are you and and and Hello, fellow colleagues! Today I will share my knowledge and observations about WHAT you need to do Hello, fellow colleagues! Today I will share my knowledge and', 'images/CXgU1LvRs4ubdUfcTmRncwbGbmQQ3ROSOt5IZCRJ.jpg', 'heading4', '2023-08-18 04:45:57', '2024-05-13 15:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'shahid', 'abcde@gmail.com', '2023-07-11 04:41:07', '$2y$10$S.6d.MH2BS2Xj/xAEx7Rduuto/kS7cQYFe2uzadX64SKTR33sqhny', 'exb2MiGlLa5XDrs3h66QGxHF90LP2FhzHLtinYLUKr5ZcmxDZWJnqwiQf8nu', '2023-06-16 23:38:02', '2024-05-13 15:55:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
