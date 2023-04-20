-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 06:01 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sam_barangay`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_charter`
--

CREATE TABLE `c_charter` (
  `service_id` int(11) NOT NULL,
  `service_name` text NOT NULL,
  `req` text NOT NULL,
  `steps` text NOT NULL,
  `fees` text NOT NULL,
  `time` text NOT NULL,
  `person` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `c_charter`
--

INSERT INTO `c_charter` (`service_id`, `service_name`, `req`, `steps`, `fees`, `time`, `person`) VALUES
(1, 'brgy id', 'valid id', '1. wake up\r\n\r\n2. toothbrush\r\n\r\n3. eat', '1500', '8 years', 'ma\'am dem');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_charter`
--
ALTER TABLE `c_charter`
  ADD PRIMARY KEY (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_charter`
--
ALTER TABLE `c_charter`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
