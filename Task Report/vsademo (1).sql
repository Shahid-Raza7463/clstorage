-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 07:43 AM
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
-- Database: `vsademo`
--

-- --------------------------------------------------------

--
-- Table structure for table `applyleaves`
--

CREATE TABLE `applyleaves` (
  `id` int(11) NOT NULL,
  `leavetype` varchar(400) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `examtype` int(10) DEFAULT NULL,
  `otherexam` varchar(400) DEFAULT NULL,
  `from` varchar(400) DEFAULT NULL,
  `to` varchar(400) DEFAULT NULL,
  `report` varchar(300) DEFAULT NULL,
  `reasonleave` varchar(400) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `approver` int(10) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(300) DEFAULT NULL,
  `employee_status` varchar(300) DEFAULT NULL,
  `dateofjoining` varchar(300) DEFAULT NULL,
  `twentysix` varchar(300) DEFAULT NULL,
  `twentyseven` varchar(300) DEFAULT NULL,
  `twentyeight` varchar(300) DEFAULT NULL,
  `twentynine` varchar(300) DEFAULT NULL,
  `thirty` varchar(300) DEFAULT NULL,
  `thirtyone` varchar(300) DEFAULT NULL,
  `one` varchar(300) DEFAULT NULL,
  `two` varchar(300) DEFAULT NULL,
  `three` varchar(300) DEFAULT NULL,
  `four` varchar(300) DEFAULT NULL,
  `five` varchar(300) DEFAULT NULL,
  `six` varchar(300) DEFAULT NULL,
  `seven` varchar(300) DEFAULT NULL,
  `eight` varchar(300) DEFAULT NULL,
  `nine` varchar(300) DEFAULT NULL,
  `ten` varchar(300) DEFAULT NULL,
  `eleven` varchar(300) DEFAULT NULL,
  `twelve` varchar(300) DEFAULT NULL,
  `thirteen` varchar(300) DEFAULT NULL,
  `fourteen` varchar(300) DEFAULT NULL,
  `fifteen` varchar(300) DEFAULT NULL,
  `sixteen` varchar(300) DEFAULT NULL,
  `seventeen` varchar(300) DEFAULT NULL,
  `eighteen` varchar(300) DEFAULT NULL,
  `ninghteen` varchar(300) DEFAULT NULL,
  `twenty` varchar(300) DEFAULT NULL,
  `twentyone` varchar(300) DEFAULT NULL,
  `twentytwo` varchar(300) DEFAULT NULL,
  `twentythree` varchar(300) DEFAULT NULL,
  `twentyfour` varchar(300) DEFAULT NULL,
  `twentyfive` varchar(300) DEFAULT NULL,
  `total_no_of_days` varchar(300) DEFAULT NULL,
  `no_of_days_present` varchar(300) DEFAULT NULL,
  `casual_leave` varchar(300) DEFAULT NULL,
  `sick_leave` varchar(300) DEFAULT NULL,
  `comp_off` varchar(300) DEFAULT NULL,
  `birthday_religious` varchar(300) DEFAULT NULL,
  `exam_leave` int(11) NOT NULL DEFAULT 0,
  `absent` int(11) NOT NULL DEFAULT 0,
  `lwp` varchar(300) DEFAULT NULL,
  `weekend` int(11) DEFAULT NULL,
  `totaldaystobepaid` varchar(300) DEFAULT NULL,
  `comment` varchar(400) DEFAULT NULL,
  `month` varchar(300) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `holidays` int(11) DEFAULT NULL,
  `travel` int(11) DEFAULT NULL,
  `offholidays` int(11) DEFAULT NULL,
  `sundaycount` int(11) DEFAULT NULL,
  `fulldate` date DEFAULT NULL,
  `beforejoiningcount` int(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_name`, `employee_status`, `dateofjoining`, `twentysix`, `twentyseven`, `twentyeight`, `twentynine`, `thirty`, `thirtyone`, `one`, `two`, `three`, `four`, `five`, `six`, `seven`, `eight`, `nine`, `ten`, `eleven`, `twelve`, `thirteen`, `fourteen`, `fifteen`, `sixteen`, `seventeen`, `eighteen`, `ninghteen`, `twenty`, `twentyone`, `twentytwo`, `twentythree`, `twentyfour`, `twentyfive`, `total_no_of_days`, `no_of_days_present`, `casual_leave`, `sick_leave`, `comp_off`, `birthday_religious`, `exam_leave`, `absent`, `lwp`, `weekend`, `totaldaystobepaid`, `comment`, `month`, `year`, `holidays`, `travel`, `offholidays`, `sundaycount`, `fulldate`, `beforejoiningcount`, `created_at`, `updated_at`) VALUES
(81, '936', NULL, '2024-07-26', 'P', 'P', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'W', NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 'July', 2024, NULL, NULL, NULL, 1, '2024-07-22', 4, '2024-12-05 06:56:29', '2024-12-05 06:56:29'),
(82, '933', NULL, '2024-07-26', 'P', 'P', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'W', NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 'July', 2024, NULL, NULL, NULL, 1, '2024-07-22', 4, '2024-12-05 07:01:46', '2024-12-05 07:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapprove`
--

CREATE TABLE `leaveapprove` (
  `id` int(11) NOT NULL,
  `year` int(20) DEFAULT NULL,
  `teammemberid` int(11) DEFAULT NULL,
  `leavetype` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `totaldays` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timesheetreport`
--

CREATE TABLE `timesheetreport` (
  `id` int(11) NOT NULL,
  `teamid` int(11) DEFAULT NULL,
  `week` varchar(50) DEFAULT NULL,
  `totaldays` int(11) DEFAULT NULL,
  `totaltime` int(11) DEFAULT NULL,
  `startdate` varchar(50) DEFAULT NULL,
  `enddate` varchar(50) DEFAULT NULL,
  `partnerid` int(11) DEFAULT NULL,
  `dayscount` int(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `timesheetreport`
--

INSERT INTO `timesheetreport` (`id`, `teamid`, `week`, `totaldays`, `totaltime`, `startdate`, `enddate`, `partnerid`, `dayscount`, `created_at`, `updated_at`) VALUES
(31, 936, '22-07-2024 to 27-07-2024', 4, 0, '2024-07-22', '2024-07-27', 887, 6, '2024-12-05 06:56:29', NULL),
(32, 936, '22-07-2024 to 27-07-2024', 2, 16, '2024-07-22', '2024-07-27', 934, 0, '2024-12-05 06:56:29', NULL),
(33, 933, '22-07-2024 to 27-07-2024', 4, 0, '2024-07-22', '2024-07-27', 887, 6, '2024-12-05 07:01:46', NULL),
(34, 933, '22-07-2024 to 27-07-2024', 2, 16, '2024-07-22', '2024-07-27', 933, 0, '2024-12-05 07:01:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timesheetrequests`
--

CREATE TABLE `timesheetrequests` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `partner` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `validate` varchar(300) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheetrequests`
--

INSERT INTO `timesheetrequests` (`id`, `client_id`, `assignment_id`, `attachment`, `partner`, `reason`, `createdby`, `status`, `validate`, `remark`, `created_at`, `updated_at`) VALUES
(10, NULL, NULL, '', 942, 'ddd', 936, 1, '2024-12-08', NULL, '2024-12-05 06:55:57', '2024-12-05 06:55:57'),
(11, NULL, NULL, '', 447, 'sss', 933, 1, '2024-12-08', NULL, '2024-12-05 07:12:06', '2024-12-05 07:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `month` varchar(300) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `created_by`, `date`, `month`, `status`, `created_at`, `updated_at`) VALUES
(287, 936, '2024-07-22', 'July', 1, '2024-12-05 06:54:48', '2024-12-05 06:56:29'),
(288, 936, '2024-07-23', 'July', 1, '2024-12-05 06:54:48', '2024-12-05 06:56:29'),
(289, 936, '2024-07-24', 'July', 1, '2024-12-05 06:54:48', '2024-12-05 06:56:29'),
(290, 936, '2024-07-25', 'July', 1, '2024-12-05 06:54:48', '2024-12-05 06:56:29'),
(291, 936, '2024-07-26', 'July', 1, '2024-12-05 06:54:49', '2024-12-05 06:56:30'),
(292, 936, '2024-07-27', 'July', 1, '2024-12-05 06:55:33', '2024-12-05 06:56:30'),
(293, 933, '2024-07-22', 'July', 1, '2024-12-05 07:00:54', '2024-12-05 07:01:46'),
(294, 933, '2024-07-23', 'July', 1, '2024-12-05 07:00:54', '2024-12-05 07:01:46'),
(295, 933, '2024-07-24', 'July', 1, '2024-12-05 07:00:54', '2024-12-05 07:01:46'),
(296, 933, '2024-07-25', 'July', 1, '2024-12-05 07:00:54', '2024-12-05 07:01:46'),
(297, 933, '2024-07-26', 'July', 1, '2024-12-05 07:00:54', '2024-12-05 07:01:46'),
(298, 933, '2024-07-27', 'July', 1, '2024-12-05 07:01:06', '2024-12-05 07:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `timesheetusers`
--

CREATE TABLE `timesheetusers` (
  `id` int(11) NOT NULL,
  `timesheetid` int(11) DEFAULT NULL,
  `client_id` int(10) DEFAULT NULL,
  `assignmentgenerate_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner` int(11) DEFAULT NULL,
  `totalhour` varchar(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `project_id` varchar(400) DEFAULT NULL,
  `date` varchar(400) DEFAULT NULL,
  `job_id` varchar(50) DEFAULT NULL,
  `workitem` varchar(1000) DEFAULT NULL,
  `location` varchar(400) DEFAULT NULL,
  `billable_status` varchar(400) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `hour` varchar(400) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `rejectedby` int(11) DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_croatian_ci;

--
-- Dumping data for table `timesheetusers`
--

INSERT INTO `timesheetusers` (`id`, `timesheetid`, `client_id`, `assignmentgenerate_id`, `partner`, `totalhour`, `assignment_id`, `project_id`, `date`, `job_id`, `workitem`, `location`, `billable_status`, `description`, `status`, `hour`, `createdby`, `rejectedby`, `updatedby`, `created_at`, `updated_at`) VALUES
(288, 287, 29, NULL, 887, '0', 213, NULL, '2024-07-22', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 936, NULL, NULL, '2024-12-05 12:24:48', '2024-12-05 12:26:29'),
(289, 288, 29, NULL, 887, '0', 213, NULL, '2024-07-23', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 936, NULL, NULL, '2024-12-05 12:24:48', '2024-12-05 12:26:29'),
(290, 289, 29, NULL, 887, '0', 213, NULL, '2024-07-24', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 936, NULL, NULL, '2024-12-05 12:24:48', '2024-12-05 12:26:29'),
(291, 290, 29, NULL, 887, '0', 213, NULL, '2024-07-25', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 936, NULL, NULL, '2024-12-05 12:24:48', '2024-12-05 12:26:29'),
(292, 291, 140, 'MAN100025', 934, '8', 200, NULL, '2024-07-26', NULL, 'sss', 'sss', NULL, NULL, 1, '8', 936, NULL, NULL, '2024-12-05 12:24:49', '2024-12-05 12:26:30'),
(293, 292, 140, 'MAN100025', 934, '8', 200, NULL, '2024-07-27', NULL, 'ddd', 'dd', NULL, NULL, 1, '8', 936, NULL, NULL, '2024-12-05 12:25:33', '2024-12-05 12:26:30'),
(294, 293, 29, NULL, 887, '0', 213, NULL, '2024-07-22', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 933, NULL, NULL, '2024-12-05 12:30:54', '2024-12-05 12:31:46'),
(295, 294, 29, NULL, 887, '0', 213, NULL, '2024-07-23', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 933, NULL, NULL, '2024-12-05 12:30:54', '2024-12-05 12:31:46'),
(296, 295, 29, NULL, 887, '0', 213, NULL, '2024-07-24', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 933, NULL, NULL, '2024-12-05 12:30:54', '2024-12-05 12:31:46'),
(297, 296, 29, NULL, 887, '0', 213, NULL, '2024-07-25', NULL, 'NA', 'NA', NULL, NULL, 1, '0', 933, NULL, NULL, '2024-12-05 12:30:54', '2024-12-05 12:31:46'),
(298, 297, 140, 'MAN100035', 933, '8', 200, NULL, '2024-07-26', NULL, 'dd', 'ddd', NULL, NULL, 1, '8', 933, NULL, NULL, '2024-12-05 12:30:54', '2024-12-05 12:31:46'),
(299, 298, 137, 'CAP100045', 933, '8', 222, NULL, '2024-07-27', NULL, 'sss', 'ss', NULL, NULL, 1, '8', 933, NULL, NULL, '2024-12-05 12:31:06', '2024-12-05 12:31:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applyleaves`
--
ALTER TABLE `applyleaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaveapprove`
--
ALTER TABLE `leaveapprove`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaverequest`
--
ALTER TABLE `leaverequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheetreport`
--
ALTER TABLE `timesheetreport`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `timesheetrequests`
--
ALTER TABLE `timesheetrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheetusers`
--
ALTER TABLE `timesheetusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applyleaves`
--
ALTER TABLE `applyleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `leaveapprove`
--
ALTER TABLE `leaveapprove`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `leaverequest`
--
ALTER TABLE `leaverequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `timesheetreport`
--
ALTER TABLE `timesheetreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `timesheetrequests`
--
ALTER TABLE `timesheetrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT for table `timesheetusers`
--
ALTER TABLE `timesheetusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
