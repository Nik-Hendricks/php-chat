-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 23, 2020 at 07:12 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpchat`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) NOT NULL,
  `uid` varchar(100) NOT NULL,
  `room_uid` varchar(100) NOT NULL,
  `message` varchar(500) NOT NULL,
  `user_uid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `uid`, `room_uid`, `message`, `user_uid`) VALUES
(14, 'acf2c53878757', '197c4b991a10c', 'Hello World', '60ec281a4eee1'),
(15, '9ac92890815a6', 'faa246eb5552d', 'hello nik', 'bc130350c0c8e'),
(16, '68e0801eaf570', 'faa246eb5552d', 'very cool', '60ec281a4eee1'),
(17, 'cacd378d821b9', '197c4b991a10c', 'hello', 'bc130350c0c8e'),
(18, 'd3ce07a58663c', '197c4b991a10c', 'private room now work', 'bc130350c0c8e'),
(19, '3543668969cc0', '197c4b991a10c', 'very cool', '60ec281a4eee1');

-- --------------------------------------------------------

--
-- Table structure for table `private_rooms`
--

CREATE TABLE `private_rooms` (
  `id` int(100) NOT NULL,
  `room_uid` varchar(100) NOT NULL,
  `to_uid` varchar(100) NOT NULL,
  `from_uid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `private_rooms`
--

INSERT INTO `private_rooms` (`id`, `room_uid`, `to_uid`, `from_uid`) VALUES
(5, 'faa246eb5552d', '60ec281a4eee1', 'bc130350c0c8e'),
(6, 'faa246eb5552d', 'bc130350c0c8e', '60ec281a4eee1');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(10) NOT NULL,
  `room_uid` varchar(100) NOT NULL,
  `room_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_uid`, `room_name`) VALUES
(6, '197c4b991a10c', 'general-chat'),
(9, 'faa246eb5552d', 'private');

-- --------------------------------------------------------

--
-- Table structure for table `room_subscribers`
--

CREATE TABLE `room_subscribers` (
  `id` int(10) NOT NULL,
  `room_uid` varchar(100) NOT NULL,
  `user_uid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_subscribers`
--

INSERT INTO `room_subscribers` (`id`, `room_uid`, `user_uid`) VALUES
(5, '197c4b991a10c', '371119173f1d1'),
(6, '197c4b991a10c', 'beb2ae3e4fa45'),
(11, '197c4b991a10c', '60ec281a4eee1'),
(12, '197c4b991a10c', 'bc130350c0c8e'),
(13, 'faa246eb5552d', '60ec281a4eee1'),
(14, 'faa246eb5552d', 'bc130350c0c8e');

-- --------------------------------------------------------

--
-- Table structure for table `unread_messages`
--

CREATE TABLE `unread_messages` (
  `id` int(10) NOT NULL,
  `user_uid` varchar(100) NOT NULL,
  `message_uid` varchar(100) NOT NULL,
  `room_uid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unread_messages`
--

INSERT INTO `unread_messages` (`id`, `user_uid`, `message_uid`, `room_uid`) VALUES
(23, '371119173f1d1', 'acf2c53878757', '197c4b991a10c'),
(24, 'beb2ae3e4fa45', 'acf2c53878757', '197c4b991a10c'),
(31, '371119173f1d1', 'cacd378d821b9', '197c4b991a10c'),
(32, 'beb2ae3e4fa45', 'cacd378d821b9', '197c4b991a10c'),
(35, '371119173f1d1', 'd3ce07a58663c', '197c4b991a10c'),
(36, 'beb2ae3e4fa45', 'd3ce07a58663c', '197c4b991a10c'),
(39, '371119173f1d1', '3543668969cc0', '197c4b991a10c'),
(40, 'beb2ae3e4fa45', '3543668969cc0', '197c4b991a10c');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uid` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `current_room_uid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `username`, `password`, `current_room_uid`) VALUES
(29, '60ec281a4eee1', 'nik', 'nik', '197c4b991a10c'),
(30, 'bc130350c0c8e', 'joe', 'joe', '197c4b991a10c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `private_rooms`
--
ALTER TABLE `private_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_subscribers`
--
ALTER TABLE `room_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unread_messages`
--
ALTER TABLE `unread_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `private_rooms`
--
ALTER TABLE `private_rooms`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `room_subscribers`
--
ALTER TABLE `room_subscribers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `unread_messages`
--
ALTER TABLE `unread_messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
