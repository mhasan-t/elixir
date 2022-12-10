-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2020 at 06:16 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdamn_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm_users`
--

CREATE TABLE `crm_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `roles` enum('manager','sales') NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_users`
--

INSERT INTO `crm_users` (`id`, `name`, `email`, `password`, `roles`, `status`) VALUES
(1, 'Jhon Smith', 'smith@webdamn.com', '202cb962ac59075b964b07152d234b70', 'sales', 1),
(2, 'Kane William', 'william@webdamn.com', '202cb962ac59075b964b07152d234b70', 'manager', 1),
(3, 'Mary', 'mary@test.com', '202cb962ac59075b964b07152d234b70', 'sales', 1),
(4, 'Rich', 'rich@test.com', '202cb962ac59075b964b07152d234b70', 'sales', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_users`
--
ALTER TABLE `crm_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_users`
--
ALTER TABLE `crm_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
