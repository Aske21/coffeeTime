-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2019 at 06:43 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee1`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 2, 1, 'ADOOOOOOOOOOOOO', '2019-07-24 15:03:50', 0),
(2, 1, 2, 'ELJUBEEEEE', '2019-07-24 15:03:56', 0),
(3, 3, 1, 'a', '2019-07-24 15:19:32', 1),
(4, 2, 1, 'a', '2019-07-24 15:19:38', 1),
(5, 2, 1, 'a', '2019-07-24 15:21:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_type` enum('no','yes') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 1, '2019-07-24 14:59:23', 'no'),
(2, 2, '2019-07-24 15:02:51', 'no'),
(3, 1, '2019-07-24 15:03:31', 'no'),
(4, 1, '2019-07-24 15:03:35', 'no'),
(5, 2, '2019-07-24 15:03:37', 'no'),
(6, 3, '2019-07-24 15:06:44', 'no'),
(7, 2, '2019-07-24 15:08:55', 'no'),
(8, 2, '2019-07-24 15:09:40', 'no'),
(9, 2, '2019-07-24 15:09:55', 'no'),
(10, 2, '2019-07-24 15:10:26', 'no'),
(11, 2, '2019-07-24 15:10:53', 'no'),
(12, 2, '2019-07-24 15:11:01', 'no'),
(13, 2, '2019-07-24 15:11:04', 'no'),
(14, 2, '2019-07-24 15:11:13', 'no'),
(15, 2, '2019-07-24 15:11:26', 'no'),
(16, 2, '2019-07-24 15:11:32', 'no'),
(17, 1, '2019-07-24 15:19:26', 'no'),
(18, 1, '2019-07-24 15:26:30', 'no'),
(19, 3, '2019-07-24 15:29:33', 'no'),
(20, 1, '2019-07-24 15:34:43', 'no'),
(21, 1, '2019-07-24 16:15:39', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `interestOne` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `interestTwo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `interestThree` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `interestFour` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `interestFive` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_joined` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `last_name`, `interestOne`, `interestTwo`, `interestThree`, `interestFour`, `interestFive`, `date_joined`) VALUES
(1, 'eljub53', '482c811da5d5b4bc6d497ffa98491e38', 'Eljub', 'EljuboviÄ‡', 'School in V-3', 'Teacher Kemala', 'Fishing', 'Going Out In Town', 'IT Akademija', '2019-07-24 16:57:02'),
(2, 'ado', '482c811da5d5b4bc6d497ffa98491e38', 'Ado', 'Anoninimni', 'Fat Chicks', '', 'Looking at nothing', 'Java', '', '2019-07-24 17:02:45'),
(3, 'fikreta12', '482c811da5d5b4bc6d497ffa98491e38', 'Fikreta', 'FiÄ‡o', 'FiÄ‡o', 'BMW Crni onaj', 'Kona Kemala', 'Sin', 'C# Development', '2019-07-24 17:06:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
