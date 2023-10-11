-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2023 at 11:02 AM
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
-- Database: `gtlm`
--
DROP DATABASE IF EXISTS `gtlm`;
CREATE DATABASE IF NOT EXISTS `gtlm` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gtlm`;

-- --------------------------------------------------------

--
-- Table structure for table `event_logs`
--

CREATE TABLE `event_logs` (
  `eventId` int(5) NOT NULL,
  `action` varchar(100) NOT NULL,
  `userId` int(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_logs`
--

INSERT INTO `event_logs` (`eventId`, `action`, `userId`, `timestamp`) VALUES
(20001, 'Test action', 30001, '2023-09-25 23:38:36'),
(20002, 'Test 2', 30001, '2023-09-26 00:01:39'),
(20003, 'Test 3', 30004, '2023-10-04 07:12:22'),
(20004, 'Test 4', 30004, '2023-10-04 07:19:34'),
(20005, 'Login User 30004 Henry Lockwood (Supervisor)', 30004, '2023-10-04 10:26:01'),
(20006, 'Task reviewed', 30004, '2023-10-04 11:49:26'),
(20007, 'Task assigned by supervisor', 30004, '2023-10-04 11:52:12'),
(20008, 'Task updated by supervisor', 30004, '2023-10-04 11:56:41'),
(20009, 'Task declined by supervisor', 30004, '2023-10-04 11:59:15'),
(20010, 'Task reviewed by supervisor', 30004, '2023-10-04 12:05:17'),
(20011, 'Task assigned by supervisor', 30004, '2023-10-04 12:05:34'),
(20012, 'Report updated by supervisor', 30004, '2023-10-04 12:06:38'),
(20013, 'Logged in', 30004, '2023-10-04 12:22:27'),
(20014, 'Logged in', 30004, '2023-10-05 00:43:41'),
(20015, 'Task reviewed by supervisor', 30004, '2023-10-05 00:45:29'),
(20016, 'Task assigned by supervisor', 30004, '2023-10-05 00:47:07'),
(20017, 'Report updated by supervisor', 30004, '2023-10-05 00:51:24'),
(20018, 'Logged in', 30004, '2023-10-05 02:10:05'),
(20019, 'Task reviewed by supervisor', 30004, '2023-10-05 02:14:08'),
(20020, 'Task assigned by supervisor', 30004, '2023-10-05 02:14:19'),
(20021, 'Logged in', 30004, '2023-10-05 10:06:10'),
(20022, 'Logged in', 30004, '2023-10-05 11:00:44'),
(20023, 'Task declined by supervisor', 30004, '2023-10-05 11:11:17'),
(20024, 'Task reviewed by supervisor', 30004, '2023-10-05 11:12:04'),
(20025, 'Task assigned by supervisor', 30004, '2023-10-05 11:12:58'),
(20026, 'Task updated by supervisor', 30004, '2023-10-05 11:18:50'),
(20027, 'Task updated by supervisor', 30004, '2023-10-05 11:19:19'),
(20028, 'Task reviewed by supervisor', 30004, '2023-10-05 11:19:33'),
(20029, 'Task assigned by supervisor', 30004, '2023-10-05 11:19:49'),
(20030, 'Report updated by supervisor', 30004, '2023-10-05 11:24:50'),
(20031, 'Report updated by supervisor', 30004, '2023-10-05 11:28:43'),
(20032, 'Report updated by supervisor', 30004, '2023-10-05 11:41:38'),
(20033, 'Supervisor completes the report of Security Officer', 30004, '2023-10-06 09:35:49'),
(20034, 'Supervisor completes the report of Security Officer', 30004, '2023-10-06 09:39:51'),
(20035, 'Logged in', 30009, '2023-10-08 01:47:02'),
(20036, 'Logged in', 30004, '2023-10-08 01:47:25'),
(20037, 'Supervisor submits a report', 30004, '2023-10-08 03:03:02'),
(20038, 'Task reviewed by supervisor', 30004, '2023-10-08 03:13:37'),
(20039, 'Task assigned by supervisor', 30004, '2023-10-08 03:13:56'),
(20040, 'Supervisor submits a report', 30004, '2023-10-08 03:20:28'),
(20041, 'Supervisor completes the report of Security Officer', 30004, '2023-10-08 03:22:52'),
(20042, 'Supervisor submits a report', 30004, '2023-10-08 03:23:11'),
(20043, 'Supervisor submits a report', 30004, '2023-10-08 03:24:10'),
(20044, 'Supervisor submits a report', 30004, '2023-10-08 03:35:06'),
(20045, 'Supervisor completes the report of Security Officer', 30004, '2023-10-08 03:37:34'),
(20046, 'Supervisor submits a report', 30004, '2023-10-08 03:37:44'),
(20047, 'Supervisor submits a report', 30004, '2023-10-08 03:38:59'),
(20048, 'Supervisor submits a report', 30004, '2023-10-08 03:40:31'),
(20049, 'Supervisor submits a report', 30004, '2023-10-08 03:40:41'),
(20050, 'Logged in', 30004, '2023-10-08 04:04:25'),
(20051, 'Logged in', 30003, '2023-10-08 06:51:28'),
(20052, 'Logged in', 30004, '2023-10-08 08:36:44'),
(20053, 'Logged in', 30003, '2023-10-08 08:47:10'),
(20054, 'Task assigned by supervisor', 30003, '2023-10-09 01:50:16'),
(20055, 'Task assigned by supervisor', 30003, '2023-10-09 01:57:34'),
(20056, 'Logged in', 30009, '2023-10-09 01:59:17'),
(20057, 'Logged in', 30003, '2023-10-09 02:50:34'),
(20058, 'Task assigned by supervisor', 30003, '2023-10-09 02:52:03'),
(20059, 'Logged in', 30009, '2023-10-09 02:53:22'),
(20060, 'Logged in', 30003, '2023-10-09 02:53:57'),
(20061, 'Logged in', 30009, '2023-10-09 03:00:29'),
(20062, 'Task declined by supervisor', 30009, '2023-10-09 03:00:49'),
(20063, 'Logged in', 30009, '2023-10-09 03:05:01'),
(20064, 'Task declined by supervisor', 30009, '2023-10-09 03:05:17'),
(20065, 'Logged in', 30003, '2023-10-09 03:06:05'),
(20066, 'Task assigned by supervisor', 30003, '2023-10-09 03:09:14'),
(20067, 'Logged in', 30004, '2023-10-09 03:09:49'),
(20068, 'Task declined by supervisor', 30004, '2023-10-09 03:10:11'),
(20069, 'Logged in', 30003, '2023-10-09 03:10:46'),
(20070, 'Task assigned by supervisor', 30003, '2023-10-09 03:11:16'),
(20071, 'Logged in', 30009, '2023-10-09 03:11:34'),
(20072, 'Logged in', 30004, '2023-10-09 03:12:09'),
(20073, 'Task declined by supervisor', 30004, '2023-10-09 03:12:21'),
(20074, 'Logged in', 30003, '2023-10-09 03:12:27'),
(20075, 'Task assigned by supervisor', 30003, '2023-10-09 03:12:53'),
(20076, 'Logged in', 30009, '2023-10-09 03:13:01'),
(20077, 'Task reviewed by supervisor', 30009, '2023-10-09 03:13:13'),
(20078, 'Logged in', 30003, '2023-10-09 03:13:31'),
(20079, 'Logged in', 30009, '2023-10-09 03:16:20'),
(20080, 'Task reviewed by supervisor', 30009, '2023-10-09 03:16:26'),
(20081, 'Logged in', 30003, '2023-10-09 03:16:52'),
(20082, 'Logged in', 30004, '2023-10-09 03:36:56'),
(20083, 'Logged in', 30003, '2023-10-09 03:38:55'),
(20084, 'Logged in', 30008, '2023-10-09 16:24:57'),
(20085, 'Logged in', 30008, '2023-10-09 16:25:54'),
(20086, 'Logged in', 30004, '2023-10-09 16:26:26'),
(20087, 'Logged in', 30008, '2023-10-09 17:22:56'),
(20088, 'Logged in', 30008, '2023-10-09 17:25:47'),
(20089, 'Logged in', 30009, '2023-10-10 00:12:46'),
(20090, 'Logged in', 30004, '2023-10-10 00:14:21'),
(20091, 'Logged in', 30009, '2023-10-10 00:16:41'),
(20092, 'Logged in', 30004, '2023-10-10 00:22:31'),
(20093, 'Logged in', 30005, '2023-10-10 00:22:59'),
(20094, 'Logged in', 30004, '2023-10-10 00:27:20'),
(20095, 'Logged in', 30009, '2023-10-10 00:28:28'),
(20096, 'Logged in', 30004, '2023-10-10 00:28:59'),
(20097, 'Logged in', 30004, '2023-10-10 00:33:31'),
(20098, 'Logged in', 30005, '2023-10-10 01:01:48'),
(20099, 'Logged in', 30005, '2023-10-10 01:02:05'),
(20100, 'Logged in', 30005, '2023-10-10 01:30:30'),
(20101, 'Logged in', 30004, '2023-10-10 03:37:30'),
(20102, 'Logged in', 30004, '2023-10-10 03:52:25'),
(20103, 'Logged in', 30005, '2023-10-10 03:53:25'),
(20104, 'Logged in', 30004, '2023-10-10 03:54:25'),
(20105, 'Logged in', 30005, '2023-10-10 04:30:29'),
(20106, 'Logged in', 30004, '2023-10-10 04:31:19'),
(20107, 'Logged in', 30004, '2023-10-10 06:59:16'),
(20108, 'Logged in', 30005, '2023-10-10 07:11:17'),
(20109, 'Logged in', 30004, '2023-10-10 07:14:10'),
(20110, 'Logged in', 30005, '2023-10-10 07:54:20'),
(20111, 'Logged in', 30004, '2023-10-10 09:27:35'),
(20112, 'Logged in', 30005, '2023-10-10 10:23:22'),
(20113, 'Logged in', 30005, '2023-10-10 15:55:25'),
(20114, 'Logged in', 30005, '2023-10-11 01:25:49'),
(20115, 'Logged in', 30004, '2023-10-11 02:28:12'),
(20116, 'Logged in', 30005, '2023-10-11 03:13:47'),
(20117, 'Logged in', 30004, '2023-10-11 03:29:57'),
(20118, 'Logged in', 30004, '2023-10-11 03:31:05'),
(20119, 'Logged in', 30005, '2023-10-11 03:33:42'),
(20120, 'Logged in', 30005, '2023-10-11 03:36:24'),
(20121, 'Logged in', 30005, '2023-10-11 03:47:48'),
(20122, 'Logged in', 30005, '2023-10-11 03:53:42'),
(20123, 'Logged in', 30005, '2023-10-11 05:38:17'),
(20124, 'Logged in', 30002, '2023-10-11 07:22:43'),
(20125, 'Logged in', 30002, '2023-10-11 07:23:12'),
(20126, 'Logged in', 30005, '2023-10-11 07:33:22'),
(20127, 'Logged in', 30003, '2023-10-11 07:37:02'),
(20128, 'Logged in', 30005, '2023-10-11 07:44:40'),
(20129, 'Logged in', 30004, '2023-10-11 08:32:23'),
(20130, 'Logged in', 30005, '2023-10-11 08:41:56'),
(20131, 'Report submitted by security officer', 30005, '2023-10-11 08:46:19'),
(20132, 'Report submitted by security officer', 30005, '2023-10-11 08:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `new_hires`
--

CREATE TABLE `new_hires` (
  `requestId` int(5) NOT NULL,
  `statusId` char(5) NOT NULL,
  `dateRequest` date NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_hires`
--

INSERT INTO `new_hires` (`requestId`, `statusId`, `dateRequest`, `fName`, `lName`, `description`, `timestamp`) VALUES
(10001, 'ADM01', '2023-09-26', 'Aaron', 'Caparas', 'This will be a new hire with a role of Security Officer', '2023-09-25 23:28:44'),
(10002, 'ADM01', '2023-09-28', 'Kayn', 'Darkin', 'This will be a new hire with a role of Security Officer', '2023-09-25 23:22:44'),
(10003, 'ADM01', '2023-10-28', 'Gragas', 'Duke', 'This will be a new hire with a role of Security Officer', '2023-09-26 23:22:44'),
(10004, 'ADM01', '2023-10-06', 'Evelyn', 'Slayer', 'This will be a new hire with a role of Security Officer', '2023-09-22 22:22:44'),
(10005, 'ADM01', '2023-09-27', 'Valor', 'Quinn', 'This will be a new hire with a role of Security Officer', '2023-09-24 23:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `taskId` int(5) NOT NULL,
  `userId` int(5) NOT NULL,
  `report` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusId` char(5) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusId`, `status`) VALUES
('', ''),
('ADM01', 'Onboarding'),
('ADM02', 'Completed'),
('DIS01', 'Client Request'),
('DIS02', 'Pending Supervisor Approval'),
('DIS03', 'Declined Task by Supervisor'),
('DIS04', 'Assigned to Supervisor'),
('DIS05', 'Completed'),
('SO01', 'Report submitted by Security officer'),
('SO02', 'Report submitted by Security officer'),
('SUP01', 'Review Tasks'),
('SUP02', 'Accepted Tasks'),
('SUP03', 'Assigned to Security Officer'),
('SUP04', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `sysSettingId` int(5) NOT NULL,
  `loginMsg1` text DEFAULT NULL,
  `loginMsg2` text DEFAULT NULL,
  `loginMsg3` text DEFAULT NULL,
  `loginMsg4` text DEFAULT NULL,
  `contactInfo` text DEFAULT NULL,
  `emergencyAssit` text DEFAULT NULL,
  `privacyPolicy` text DEFAULT NULL,
  `termsOfService` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`sysSettingId`, `loginMsg1`, `loginMsg2`, `loginMsg3`, `loginMsg4`, `contactInfo`, `emergencyAssit`, `privacyPolicy`, `termsOfService`, `timestamp`) VALUES
(90001, 'At Task Force Security, we are not just a security agency; we are your dedicated partners in ensuring the safety and security of what matters most to you. With years of experience and a commitment to excellence, we have become a trusted name in the security industry.', 'Our mission is simple yet profound: to provide unwavering protection for our clients\' assets, properties, and, most importantly, their peace of mind. We understand that security is not just about physical presence but also about trust, reliability, and professionalism. Our security force is comprised of highly trained and skilled professionals who are passionate about what they do. We take pride in our team\'s ability to adapt to various security challenges, whether it\'s safeguarding a corporate office, securing a construction site, or providing protection for VIPs.\r\n', 'Please don\'t hesitate to contact our support team at support@taskforcesecurity.com', 'Join us & become a security officer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-09-26 01:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `taskId` int(5) NOT NULL,
  `taskName` varchar(50) NOT NULL,
  `taskDetailsCli` text NOT NULL,
  `taskDetailsDis` text DEFAULT NULL,
  `taskDetailsSup` text DEFAULT NULL,
  `dateCreated` date NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `statusDis` char(5) NOT NULL,
  `statusSup` char(5) DEFAULT NULL,
  `dispatcherId` int(5) DEFAULT NULL,
  `securityOfficerId` int(11) DEFAULT NULL,
  `supervisorId` int(5) DEFAULT NULL,
  `scheduleId` int(5) DEFAULT NULL,
  `declineReason` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskId`, `taskName`, `taskDetailsCli`, `taskDetailsDis`, `taskDetailsSup`, `dateCreated`, `dateFrom`, `dateTo`, `statusDis`, `statusSup`, `dispatcherId`, `securityOfficerId`, `supervisorId`, `scheduleId`, `declineReason`, `timestamp`) VALUES
(50001, 'Secure perimeter fencing around BFH area', 'CLI\r\n\r\nWe need to make sure that site A and B of BFH are secured with 2 or more SO. Assing 20 SO to this task. \r\n\r\nBe on alert for any possible disturbances, especially in site A.\r\n\r\n', 'DIS\r\n\r\nWe need to make sure that site A and B of BFH are secured with 2 or more SO. Assing 20 SO to this task. \r\n\r\nBe on alert for any possible disturbances, especially in site A.', NULL, '2023-09-26', '2023-09-26', '2023-09-26', 'DIS04', 'SUP01', 30003, 30005, 30004, NULL, NULL, '2023-10-11 08:54:59'),
(50002, 'Help site ABC', 'CLI\r\n\r\nPlease secure all exits blah blah blah', 'DIS\r\n\r\nPlease secure all exits blah blah blah', 'Supervisor\'s report is written here\r\nSecond try', '2023-09-30', '2023-10-01', '2023-10-03', 'DIS04', 'SUP03', 30003, 30005, 30004, 40001, NULL, '2023-10-11 08:54:51'),
(50003, 'Protect and Serve', 'CLI\r\n\r\nGo to work and to your thing', 'DIS\r\n\r\nGo to work and to your thing', 'Assign to 3 SO\'s', '2023-09-30', '2023-10-01', '2023-10-02', 'DIS04', 'SUP02', 30003, 30005, 30004, 40002, NULL, '2023-10-11 08:54:55'),
(50004, 'Run for your life', 'CLI\r\n\r\nDon\'t run, just walk', 'DIS\r\n\r\nDon\'t run, just walk', 'Run, dont walk!', '2023-09-27', '2023-09-28', '2023-09-30', 'DIS04', 'SUP03', 30003, 30005, 30004, 40003, NULL, '2023-10-11 08:54:45'),
(50005, 'Project Zero', 'CLI \r\n\r\nNeed officers to guard 55 story building', 'DIS \r\n\r\nOk giving it to Yussaf! Yussaff! get this!', NULL, '2023-10-08', '2023-10-09', '2023-10-13', 'DIS04', 'SUP03', 30003, 30005, 30009, NULL, NULL, '2023-10-10 07:53:39');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(5) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `dateStart` date NOT NULL,
  `password` varchar(30) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `DOB` varchar(255) NOT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `usi` int(11) DEFAULT NULL,
  `licence` varchar(255) DEFAULT NULL,
  `Driving_licence` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `fName`, `lName`, `role`, `dateStart`, `password`, `timestamp`, `DOB`, `sex`, `address`, `contact`, `email`, `usi`, `licence`, `Driving_licence`) VALUES
(30002, 'Jason', 'Henrich', 'Administrator', '2023-09-27', 'admin', '2023-09-25 23:53:03', '11-10-1998', 'Male', '936 Kiehn Route', 121333, 'jh@taskforcessecurity.com.au', 3434434, '42ygby4222', '1234567'),
(30003, 'Mia', 'Valdez', 'Dispatcher', '2023-09-27', 'dis', '2023-09-27 07:10:38', '11-10-1998', 'Male', '4059 Carling Avenue', 1321221, 'mv@taskforcessecurity.com.au', 455645, '25534557', '456366'),
(30004, 'Henry', 'Lockwood', 'Supervisor', '2023-09-27', 'super', '2023-09-27 07:11:09', '11-10-1998', 'Male', '60 Caradon Hill', 45363453, 'hl@taskforcessecurity.com.au', 434353, '353535', '42422121'),
(30005, 'Lukas', 'Johnson', 'Security Officer', '2023-09-27', 'so', '2023-09-27 07:11:41', '11-10-1998', 'Male', '289 Mohr Heights', 34233243, 'lj@taskforcessecurity.com.au', 435353, '53335', '221frrftfvg244'),
(30006, 'Louis', 'Reyes', 'Security Officer', '2023-09-28', 'so', '2023-09-28 04:43:07', '11-10-1998', 'Male', '15 Sellamuttu Avenue, 03', 2343434, 'lr@taskforcessecurity.com.au', 5544564, '33324', '2214ololk,o221'),
(30007, 'Ena Bea', 'Reyes', 'Security Officer', '2023-09-28', 'so', '2023-09-28 05:04:21', '11-10-1998', 'Male', '60/d, Purana paltan (1st floor west side), 1000', 32322, 'erjh@taskforcessecurity.com.au', 43565656, '345333', '22ws3awqa1411'),
(30008, 'Carlo', 'Tugsoan', 'Security Officer', '2023-09-28', 'so', '2023-09-28 10:38:38', '011-10-1998', 'Male', '65 Calle Industria 1100', 332434, 'ct@taskforcessecurity.com.au', 5665465, '3354', '22iosdcko114'),
(30009, 'Yussaf', 'Holland', 'Supervisor', '2023-09-30', 'super', '2023-09-30 01:56:53', '11-10-1998', 'Male', '89 Katherine Street', 342323, 'yh@taskforcessecurity.com.au', 544533, '553424', '7tgtyg5555');

-- --------------------------------------------------------

--
-- Table structure for table `user_schedule`
--

CREATE TABLE `user_schedule` (
  `scheduleId` int(5) NOT NULL,
  `userId` int(5) NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_schedule`
--

INSERT INTO `user_schedule` (`scheduleId`, `userId`, `dateFrom`, `dateTo`, `timestamp`) VALUES
(40001, 30005, '2023-10-01', '2023-10-03', '2023-10-05 11:12:58'),
(40002, 30006, '2023-10-01', '2023-10-02', '2023-10-05 11:19:49'),
(40002, 30007, '2023-10-01', '2023-10-02', '2023-10-05 11:19:49'),
(40002, 30008, '2023-10-01', '2023-10-02', '2023-10-05 11:19:49'),
(40003, 30008, '2023-09-28', '2023-09-30', '2023-10-08 03:13:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_logs`
--
ALTER TABLE `event_logs`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `new_hires`
--
ALTER TABLE `new_hires`
  ADD PRIMARY KEY (`requestId`,`statusId`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`taskId`,`userId`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusId`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`sysSettingId`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`taskId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `user_schedule`
--
ALTER TABLE `user_schedule`
  ADD PRIMARY KEY (`scheduleId`,`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_logs`
--
ALTER TABLE `event_logs`
  MODIFY `eventId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20133;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





CREATE user IF NOT EXISTS dbadmin@localhost;

GRANT all privileges ON GTLM.Event_Logs TO dbadmin@localhost;
GRANT all privileges ON GTLM.New_Hires TO dbadmin@localhost;
GRANT all privileges ON GTLM.Report TO dbadmin@localhost;
GRANT all privileges ON GTLM.Status TO dbadmin@localhost;
GRANT all privileges ON GTLM.System_Settings TO dbadmin@localhost;
GRANT all privileges ON GTLM.Task TO dbadmin@localhost;
GRANT all privileges ON GTLM.User TO dbadmin@localhost;
GRANT all privileges ON GTLM.User_Schedule TO dbadmin@localhost;
