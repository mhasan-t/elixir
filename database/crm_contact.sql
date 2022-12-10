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
-- Table structure for table `crm_contact`
--

CREATE TABLE `crm_contact` (
  `id` int(11) NOT NULL,
  `contact_title` varchar(255) NOT NULL,
  `contact_first` varchar(255) NOT NULL,
  `contact_middle` varchar(255) NOT NULL,
  `contact_last` varchar(255) NOT NULL,
  `initial_contact_date` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` enum('Lead','Proposal','Customer / won','Archive') NOT NULL,
  `website` varchar(255) NOT NULL,
  `sales_rep` int(11) NOT NULL,
  `project_type` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `proposal_due_date` varchar(255) NOT NULL,
  `budget` int(11) NOT NULL,
  `deliverables` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_contact`
--

INSERT INTO `crm_contact` (`id`, `contact_title`, `contact_first`, `contact_middle`, `contact_last`, `initial_contact_date`, `title`, `company`, `industry`, `address`, `city`, `state`, `country`, `zip`, `phone`, `email`, `status`, `website`, `sales_rep`, `project_type`, `project_description`, `proposal_due_date`, `budget`, `deliverables`) VALUES
(1, '', 'David', '', 'Smith', '0000-00-00 00:00:00', '', 'ABC', 'Food', '', '', '', 'France', 112245, 123456789, 'david@tes.com', 'Lead', 'www.testabc.com', 1, '', '', '', 15000, ''),
(2, '', 'Goerge', '', 'Wood', '0000-00-00 00:00:00', '', 'XYZ', 'Motor', '', '', '', '', 0, 123456789, 'goerg@test.com', 'Lead', 'www.mtobc.com', 1, '', '', '', 0, ''),
(5, '', 'adam', '', 'smith', '2020-11-13 20:47:02', '', 'vzxvzx', 'xzvzx', '', '', '', '', 0, 123456789, 'dgsdgsd@wty.com', 'Proposal', 'www.mtobc.com', 1, '', '', '', 0, ''),
(6, '', 'xvzxxzv', '', 'xvzxvzxv', '2020-11-13 20:56:27', '', 'uyttyi', 'reyery', '', '', '', '', 0, 123456789, 'werwrwe@wr.com', 'Customer / won', 'www.fggg.com', 1, '', '', '', 3400, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_contact`
--
ALTER TABLE `crm_contact`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_contact`
--
ALTER TABLE `crm_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
