-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 09:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miller_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`username`, `password`) VALUES
('admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lrn` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `gname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gcontact` int(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `name`, `lrn`, `password`, `grade`, `section`, `gname`, `address`, `gcontact`, `image`) VALUES
(4, 'Miller Alcantara', 2147483647, '123', '10', 'Curie', 'Domer Alcantara', 'Antipolo', 2147483647, 'C:/xampp/htdocs/system/ui/studentsqr/106925090006.png'),
(7, 'asdasdas', 12345654, '123', '12', 'Humss', 'asdasd', 'asdada', 312312312, 'C:/xampp/htdocs/system/ui/studentsqr/12345654.png'),
(8, 'Killua', 2147483647, '123', '11', 'Gas', 'asdasdasda', 'asdasdas', 312312312, 'C:/xampp/htdocs/system/ui/studentsqr/19276312386.png'),
(9, 'Hinata', 2147483647, '123', '8', 'Diamond', 'asdfasdas', 'asasdasda', 412312312, 'system/ui/studentsqr/10692765394.png'),
(10, 'lmao', 2147483647, '123', '11', 'Abm', 'adadada', 'asdasdasdas', 31231312, 'studentsqr/106925725662.png'),
(11, 'Kurapika', 1069252384, '123', '9', 'Mars', 'kasdhaks', 'audash', 2147483647, 'studentsqr/1069252384.png'),
(12, 'Gon', 2147483647, '123', '7', 'Rose', 'adasdasd', 'adadasd', 2147483647, 'studentsqr/10692865362.png'),
(13, 'Lebron James', 2147483647, '123', '9', 'Venus', 'hahaha', 'us', 76316312, 'studentsqr/106927547523.png'),
(14, 'Stephen Curry', 2147483647, '123', '10', 'Einstein', 'curry curry', 'america', 2147483647, 'studentsqr/106928643372_1746431546.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lrn` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `gname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gcontact` int(255) NOT NULL,
  `qr` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
