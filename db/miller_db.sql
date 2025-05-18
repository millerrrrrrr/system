-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 04:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lrn` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `morningIn` datetime NOT NULL,
  `morningOut` datetime NOT NULL,
  `afternoonIn` datetime NOT NULL,
  `afternoonOut` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`id`, `name`, `lrn`, `date`, `morningIn`, `morningOut`, `afternoonIn`, `afternoonOut`) VALUES
(13, 'Tung Tung Tung Sahur', '106928636501', '2025-05-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Kurt', '106928649531', '2025-05-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Jlo', '106926743592', '2025-05-14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Blabla', '106823565266', '2025-05-16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'ella mae lorenzo', '106925140022', '2025-05-16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lrn` varchar(255) NOT NULL,
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
(17, 'Miller', '106925090006', '123', '11', 'Stem', 'HAHAHA', 'HEHEHE', 123124123, 'studentsqr/106925090006_1746948381.png'),
(18, 'Vookbar', '106925120038', '123', '10', 'Curie', 'LALALA', 'LELELE', 2147483647, 'studentsqr/106925120038_1746948470.png'),
(19, 'asdas', '123312', '', '', '', '', '', 0, ''),
(20, 'Jman', '1078235687290', '123', '8', 'Emerald', 'adsdasda', 'adsadas', 2147483647, 'studentsqr/1078235687290_1746982085.png'),
(21, 'Lebron James', '106925248572', '123', '9', 'Mars', 'LOLOLOL', 'LULULULU', 2147483647, 'studentsqr/106925248572_1746982575.png'),
(22, 'Kurapika', '106928451442', '123', '8', 'Sapphire', 'KAKAKA', 'KEKEKE', 1312312123, 'studentsqr/106928451442_1746983105.png'),
(23, 'Tung Tung Tung Sahur', '106928636501', '123', '11', 'Humss', 'PAPAPAPA', 'POPOPOPO', 2147483647, 'studentsqr/106928636501_1746983341.png'),
(24, 'Kurt', '106928649531', '123', '10', 'Tesla', 'JAJAJA', 'JEJEJE', 2147483647, 'studentsqr/106928649531_1747053276.png'),
(25, 'Jlo', '106926743592', '123', '9', 'Earth', 'TATATA', 'TETETTEE', 2147483647, 'studentsqr/106926743592_1747207190.png'),
(26, 'Blabla', '106823565266', '123', '9', 'Mars', 'YAYAYA', 'YEYEYE', 2147483647, 'studentsqr/106823565266_1747357147.png'),
(27, 'ella mae lorenzo', '106925140022', '123', '11', 'Stem', 'emma lorenzo', 'antipolo', 2147483647, 'studentsqr/106925140022_1747357446.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lrn` (`lrn`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
