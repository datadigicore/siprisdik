-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 30, 2016 at 01:26 
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rkakl`
--

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE `grup` (
  `id` int(255) NOT NULL,
  `kode` varchar(8) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kdprogram` varchar(255) NOT NULL,
  `direktorat` varchar(255) NOT NULL,
  `kdoutput` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`id`, `kode`, `nama`, `kdprogram`, `direktorat`, `kdoutput`, `status`) VALUES
(4, '3802', 'Biro Humas dan Hukum', '06', '06-5696', '06-5696-001', 1),
(5, '3803', 'Biro Perencanaan dan Organisasi', '06', '06-5698,06-5700', '06-5698-003,06-5698-007', 1),
(6, '3804', 'Biro Keuangan dan Rumah Tangga', '06', '06-5697,06-5699', '06-5697-003,06-5697-006,06-5699-002', 1),
(7, '3806', 'Biro Keuangan dan Rumah Tangga', '06', '06-5696,06-5697,06-5698,06-5699,06-5700', '06-5696-001,06-5696-002,06-5696-003,06-5696-004,06-5696-005,06-5696-007,06-5696-994,06-5697-001,06-5697-003,06-5697-004,06-5697-005,06-5697-006,06-5697-007,06-5698-001,06-5698-003,06-5698-005,06-5698-006,06-5698-007,06-5698-008,06-5698-009,06-5699-001,06-5699-002,06-5699-003,06-5699-004,06-5699-005,06-5700-001,06-5700-002,06-5700-003,06-5700-004', 1),
(8, '3810', 'gunadarma', '06', '06-5697,06-5699', '06-5697-003,06-5697-006,06-5699-002', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
