-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2017 at 06:04 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmaintenance`
--

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `facility_id` int(11) NOT NULL,
  `workman` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name_workman` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name_workman` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`facility_id`, `workman`, `first_name_workman`, `last_name_workman`, `telephone`) VALUES
(1, 'Carpenter', 'John', 'Doe', '0244366333'),
(2, 'Plumber', 'Kojo', 'Amuah', '0200000221'),
(3, 'Electrician', 'Carlos', 'Abari', '0200333909'),
(4, 'Cleaner', 'Abeku', 'Fuego', '0546667778'),
(8, 'Cook', 'Beatrice', 'Dongo', '0244555567'),
(9, 'Gardener', 'John', 'Kamau', '0200456765'),
(10, 'Tecnhician', 'Floyd', 'Mango', '0244666777');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_job`
--

CREATE TABLE `maintenance_job` (
  `work_order` int(11) NOT NULL,
  `dr_maint` datetime NOT NULL,
  `dr_artisan` datetime NOT NULL,
  `dr_materials` datetime NOT NULL,
  `ds_materials` datetime NOT NULL,
  `dc_job` datetime NOT NULL,
  `location` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `job_state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_area` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facility_id` int(11) NOT NULL,
  `user_firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dt_commenc` datetime NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `maintenance_job`
--

INSERT INTO `maintenance_job` (`work_order`, `dr_maint`, `dr_artisan`, `dr_materials`, `ds_materials`, `dc_job`, `location`, `description`, `job_state`, `user_id`, `job_area`, `facility_id`, `user_firstname`, `user_lastname`, `dt_commenc`, `comments`) VALUES
(6, '2017-01-15 17:12:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Tana', 'Broken car ', 'Urgent', 1, 'College', 2, 'Kenneth', 'Harlley', '0000-00-00 00:00:00', 'Hopefully this works'),
(15, '2017-02-03 02:40:43', '2017-02-03 01:39:00', '2017-02-03 01:39:00', '2017-02-03 01:40:00', '0000-00-00 00:00:00', 'Kariba Room 8', 'The door handle is rusted ', 'Routine', 1, 'Hostels', 1, 'Kenneth', 'Harlley', '2017-02-03 01:40:00', ' \r\n      Please fix this quickly ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `access_level` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telephonenum` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `password`, `email`, `access_level`, `telephonenum`) VALUES
(1, 'Kenneth', 'Harlley', 'Password1', 'email@yahoo.com', 'admin', '0202344544'),
(2, 'Dela', 'Harllet', 'Password1', 'delah@yahoo.com', 'user', '0300404000'),
(3, 'Kwame', 'Kwakwa', 'Highkey1', 'kwakwak@gmail.com', 'user', '0122222222'),
(4, 'John', 'Stones', 'Stones1', 'johns@yahoo.com', 'user', '0244567567'),
(5, 'Phillip', 'Jag', 'Jag123', 'ja@gmail.com', 'user', '0244567567'),
(10, 'John', 'Doe', 'Password1', 'johnd@gmail.com', 'user', '0200456765');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `maintenance_job`
--
ALTER TABLE `maintenance_job`
  ADD PRIMARY KEY (`work_order`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `maintenance_job`
--
ALTER TABLE `maintenance_job`
  MODIFY `work_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
