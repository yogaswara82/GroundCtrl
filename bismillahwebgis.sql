-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2019 at 09:17 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bismillahwebgis`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `lat` text NOT NULL,
  `lon` text NOT NULL,
  `x` text NOT NULL,
  `y` text NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `nama`, `lat`, `lon`, `x`, `y`, `msg`) VALUES
(1, 'ATC Srandakan', '110.368870', '-7.746485', '', '', 'Diharapkan, pengetahuan dan materi edukasi yang sudah diberikan bisa diteruskan kepada warga nelayan lainnya, agar aplikasi Laut Nusantara bisa dimanfaatkan oleh masyarakat yang lebih luas. ');

-- --------------------------------------------------------

--
-- Table structure for table `uny`
--

CREATE TABLE `uny` (
  `id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `addres` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `lon` text NOT NULL,
  `lat` text NOT NULL,
  `x` text NOT NULL,
  `y` text NOT NULL,
  `a` text NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uny`
--

INSERT INTO `uny` (`id`, `name`, `addres`, `type`, `lon`, `lat`, `x`, `y`, `a`, `msg`) VALUES
('1', 'STC Parangtritis', 'Tanjung Priok', 'Radar Pantau', '110.364763', '-7.8013800', '12', '1', 'A123C', 'aman sekali'),
('2', 'Ahmad ', 'Surabaya', 'Penakar Ikan', '110.22171', '-8.265855', '33.23', '0.58', '0', 'Kapten Edi Prana Senja'),
('3', 'Jendral ', 'Kapten Edi Prana Senja', '0', '110.397550', '-7.759437', '239.87', '4.19', '-7.746485', '110.368870');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uny`
--
ALTER TABLE `uny`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
