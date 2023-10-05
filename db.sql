DROP DATABASE IF EXISTS GTLM;
CREATE DATABASE GTLM;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 05, 2023 at 05:20 AM
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
-- Database: `GTLM`
--

-- --------------------------------------------------------

--
-- Table structure for table `Event_Logs`
--

CREATE TABLE `Event_Logs` (
  `eventId` int(5) NOT NULL,
  `action` varchar(100) NOT NULL,
  `userId` int(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Event_Logs`
--

INSERT INTO `Event_Logs` (`eventId`, `action`, `userId`, `timestamp`) VALUES
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
(20020, 'Task assigned by supervisor', 30004, '2023-10-05 02:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `New_Hires`
--

CREATE TABLE `New_Hires` (
  `requestId` int(5) NOT NULL,
  `statusId` char(5) NOT NULL,
  `dateRequest` date NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `New_Hires`
--

INSERT INTO `New_Hires` (`requestId`, `statusId`, `dateRequest`, `fName`, `lName`, `description`, `timestamp`) VALUES
(10001, 'ADM01', '2023-09-26', 'Aaron', 'Caparas', 'This will be a new hire with a role of Security Officer', '2023-09-25 23:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `Report`
--

CREATE TABLE `Report` (
  `taskId` int(5) NOT NULL,
  `userId` int(5) NOT NULL,
  `reportSO` text DEFAULT NULL,
  `attachmentSO` longblob DEFAULT NULL,
  `statusSO` varchar(50) DEFAULT NULL,
  `timestampSO` timestamp NULL DEFAULT NULL,
  `reportSup` text DEFAULT NULL,
  `statusSup` varchar(50) DEFAULT NULL,
  `timestampSup` timestamp NULL DEFAULT NULL,
  `reportDis` text DEFAULT NULL,
  `statusDis` varchar(50) DEFAULT NULL,
  `timestampDis` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Report`
--

INSERT INTO `Report` (`taskId`, `userId`, `reportSO`, `attachmentSO`, `statusSO`, `timestampSO`, `reportSup`, `statusSup`, `timestampSup`, `reportDis`, `statusDis`, `timestampDis`) VALUES
(50002, 30005, NULL, NULL, 'Completed', '2023-10-04 11:06:04', 'Ok report', 'Submitted', '2023-10-04 12:06:38', NULL, 'Pending', NULL),
(50002, 30006, 'ive completed it', NULL, 'Completed', '2023-10-04 23:49:43', 'ive competed', 'Submitted', '2023-10-05 00:51:24', NULL, 'Pending', NULL),
(50003, 30008, NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL),
(50004, 30005, NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL),
(50004, 30006, NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL),
(50004, 30007, NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL, NULL, 'Pending', NULL),
(50004, 30008, 'ive compelted to report', NULL, 'Submitted', '2023-10-05 01:14:44', NULL, 'Pending', NULL, NULL, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE `Status` (
  `statusId` char(5) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`statusId`, `status`) VALUES
('', ''),
('ADM01', 'Onboarding'),
('ADM02', 'Completed'),
('DIS01', 'Client Request'),
('DIS02', 'Pending Supervisor’s Approval'),
('DIS03', 'Declined Task by Supervisor'),
('DIS04', 'Assigned to Supervisor'),
('DIS05', 'Completed'),
('SUP01', 'Review Tasks'),
('SUP02', 'Accepted Tasks'),
('SUP03', 'Assigned to Security Officer'),
('SUP04', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `System_Settings`
--

CREATE TABLE `System_Settings` (
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
-- Dumping data for table `System_Settings`
--

INSERT INTO `System_Settings` (`sysSettingId`, `loginMsg1`, `loginMsg2`, `loginMsg3`, `loginMsg4`, `contactInfo`, `emergencyAssit`, `privacyPolicy`, `termsOfService`, `timestamp`) VALUES
(90001, 'At Task Force Security, we are not just a security agency; we are your dedicated partners in ensuring the safety and security of what matters most to you. With years of experience and a commitment to excellence, we have become a trusted name in the security industry.', 'Our mission is simple yet profound: to provide unwavering protection for our clients\' assets, properties, and, most importantly, their peace of mind. We understand that security is not just about physical presence but also about trust, reliability, and professionalism. Our security force is comprised of highly trained and skilled professionals who are passionate about what they do. We take pride in our team\'s ability to adapt to various security challenges, whether it\'s safeguarding a corporate office, securing a construction site, or providing protection for VIPs.\r\n', 'Please don\'t hesitate to contact our support team at support@taskforcesecurity.com', 'Join us & become a security officer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-09-26 01:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE `Task` (
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
  `supervisorId` int(5) DEFAULT NULL,
  `scheduleId` int(5) DEFAULT NULL,
  `declineReason` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`taskId`, `taskName`, `taskDetailsCli`, `taskDetailsDis`, `taskDetailsSup`, `dateCreated`, `dateFrom`, `dateTo`, `statusDis`, `statusSup`, `dispatcherId`, `supervisorId`, `scheduleId`, `declineReason`, `timestamp`) VALUES
(50001, 'Secure perimeter fencing around BFH area', 'We need to make sure that site A and B of BFH are secured with 2 or more SO. Assing 20 SO to this task. \r\n\r\nBe on alert for any possible disturbances, especially in site A.', 'We need to make sure that site A and B of BFH are secured with 2 or more SO. Assing 20 SO to this task. \r\n\r\nBe on alert for any possible disturbances, especially in site A.', NULL, '2023-09-26', '2023-09-26', '2023-09-26', 'DIS01', NULL, 30003, NULL, NULL, NULL, '2023-10-05 03:13:02'),
(50002, 'Help site ABC', 'Please secure all exits blah blah blah', 'Please secure all exits blah blah blah', '', '2023-09-30', '2023-10-01', '2023-10-03', 'DIS04', 'SUP04', 30003, 30004, 40001, NULL, '2023-10-05 03:13:15'),
(50003, 'Protect and Serve', 'Go to work and to your thing', 'Go to work and to your thing', 'sdsdaaadad', '2023-09-30', '2023-10-01', '2023-10-02', 'DIS04', 'SUP03', 30003, 30004, 40002, NULL, '2023-10-05 03:16:21'),
(50004, 'Run for your life', 'Don\'t run, just walk', 'Don\'t run, just walk', 'asdfsdafds', '2023-09-27', '2023-09-28', '2023-09-30', 'DIS04', 'SUP03', 30003, 30004, 40003, NULL, '2023-10-05 03:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userId` int(5) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `dateStart` date NOT NULL,
  `password` varchar(30) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userId`, `fName`, `lName`, `role`, `dateStart`, `password`, `timestamp`) VALUES
(30002, 'Jason', 'Henrich', 'Administrator', '2023-09-27', 'admin', '2023-09-25 23:53:03'),
(30003, 'Mia', 'Valdez', 'Dispatcher', '2023-09-27', 'dis', '2023-09-27 07:10:38'),
(30004, 'Henry', 'Lockwood', 'Supervisor', '2023-09-27', 'super', '2023-09-27 07:11:09'),
(30005, 'Lukas', 'Johnson', 'Security Officer', '2023-09-27', 'so', '2023-09-27 07:11:41'),
(30006, 'Louis', 'Reyes', 'Security Officer', '2023-09-28', 'so', '2023-09-28 04:43:07'),
(30007, 'Ena Bea', 'Reyes', 'Security Officer', '2023-09-28', 'so', '2023-09-28 05:04:21'),
(30008, 'Carlo', 'Tugsoan', 'Security Officer', '2023-09-28', 'so', '2023-09-28 10:38:38'),
(30009, 'Yussaf', 'Holland', 'Supervisor', '2023-09-30', 'super', '2023-09-30 01:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `User_Schedule`
--

CREATE TABLE `User_Schedule` (
  `scheduleId` int(5) NOT NULL,
  `userId` int(5) NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Schedule`
--

INSERT INTO `User_Schedule` (`scheduleId`, `userId`, `dateFrom`, `dateTo`, `timestamp`) VALUES
(40001, 30005, '2023-10-01', '2023-10-03', '2023-10-04 12:05:34'),
(40001, 30006, '2023-10-01', '2023-10-03', '2023-10-04 12:05:34'),
(40002, 30008, '2023-10-01', '2023-10-02', '2023-10-05 00:47:07'),
(40003, 30005, '2023-09-28', '2023-09-30', '2023-10-05 02:14:19'),
(40003, 30006, '2023-09-28', '2023-09-30', '2023-10-05 02:14:19'),
(40003, 30007, '2023-09-28', '2023-09-30', '2023-10-05 02:14:19'),
(40003, 30008, '2023-09-28', '2023-09-30', '2023-10-05 02:14:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Event_Logs`
--
ALTER TABLE `Event_Logs`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `New_Hires`
--
ALTER TABLE `New_Hires`
  ADD PRIMARY KEY (`requestId`,`statusId`);

--
-- Indexes for table `Report`
--
ALTER TABLE `Report`
  ADD PRIMARY KEY (`taskId`,`userId`);

--
-- Indexes for table `Status`
--
ALTER TABLE `Status`
  ADD PRIMARY KEY (`statusId`);

--
-- Indexes for table `System_Settings`
--
ALTER TABLE `System_Settings`
  ADD PRIMARY KEY (`sysSettingId`);

--
-- Indexes for table `Task`
--
ALTER TABLE `Task`
  ADD PRIMARY KEY (`taskId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `User_Schedule`
--
ALTER TABLE `User_Schedule`
  ADD PRIMARY KEY (`scheduleId`,`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Event_Logs`
--
ALTER TABLE `Event_Logs`
  MODIFY `eventId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20021;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



USE GTLM;

CREATE user IF NOT EXISTS dbadmin@localhost;

GRANT all privileges ON GTLM.Event_Logs TO dbadmin@localhost;
GRANT all privileges ON GTLM.New_Hires TO dbadmin@localhost;
GRANT all privileges ON GTLM.Report TO dbadmin@localhost;
GRANT all privileges ON GTLM.Status TO dbadmin@localhost;
GRANT all privileges ON GTLM.System_Settings TO dbadmin@localhost;
GRANT all privileges ON GTLM.Task TO dbadmin@localhost;
GRANT all privileges ON GTLM.User TO dbadmin@localhost;
GRANT all privileges ON GTLM.User_Schedule TO dbadmin@localhost;
