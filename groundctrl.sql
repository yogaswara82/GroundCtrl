-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14 Agu 2019 pada 07.04
-- Versi Server: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `groundctrl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuaca`
--

CREATE TABLE `cuaca` (
  `id` varchar(5) NOT NULL,
  `klorofil` text NOT NULL,
  `temp` varchar(10) NOT NULL,
  `windspeed` varchar(10) NOT NULL,
  `winddir` varchar(10) NOT NULL,
  `humidity` varchar(10) NOT NULL,
  `wave` varchar(10) NOT NULL,
  `sigWave` varchar(10) NOT NULL,
  `waveperiod` varchar(10) NOT NULL,
  `watertemp` varchar(10) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cuaca`
--

INSERT INTO `cuaca` (`id`, `klorofil`, `temp`, `windspeed`, `winddir`, `humidity`, `wave`, `sigWave`, `waveperiod`, `watertemp`, `description`) VALUES
('AB', ' 166 ', '25', '27', 'ESE', '77', '0.6', '1.0', '13.4', '26', 'Partly cloudy'),
('AC', ' 167 ', '25', '34', 'ESE', '79', '0.5', '0.9', '13.6', '25', 'Cloudy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `loc`
--

CREATE TABLE `loc` (
  `id` varchar(5) NOT NULL,
  `lat` text NOT NULL,
  `lon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `loc`
--

INSERT INTO `loc` (`id`, `lat`, `lon`) VALUES
('AB', '-10.790141 ', '115.839844'),
('AC', '-8.700499', '109.072266');

--
-- Trigger `loc`
--
DELIMITER $$
CREATE TRIGGER `id_after_ins_trig` AFTER INSERT ON `loc` FOR EACH ROW insert into cuaca (id) values (new.id)
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuaca`
--
ALTER TABLE `cuaca`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `loc`
--
ALTER TABLE `loc`
  ADD PRIMARY KEY (`id`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cuaca`
--
ALTER TABLE `cuaca`
  ADD CONSTRAINT `fk` FOREIGN KEY (`id`) REFERENCES `loc` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
