-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2016 at 08:53 
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.5.30

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
-- Table structure for table `rkakl_full`
--

CREATE TABLE `rkakl_full` (
  `THANG` varchar(4) DEFAULT NULL,
  `KDJENDOK` varchar(2) DEFAULT NULL,
  `KDSATKER` varchar(6) DEFAULT NULL,
  `KDDEPT` varchar(3) DEFAULT NULL,
  `KDUNIT` varchar(2) DEFAULT NULL,
  `KDPROGRAM` varchar(2) DEFAULT NULL,
  `KDGIAT` varchar(4) DEFAULT NULL,
  `NMGIAT` varchar(82) DEFAULT NULL,
  `KDOUTPUT` varchar(3) DEFAULT NULL,
  `NMOUTPUT` varchar(95) DEFAULT NULL,
  `KDSOUTPUT` varchar(3) DEFAULT NULL,
  `NMSOUTPUT` varchar(76) DEFAULT NULL,
  `KDKMPNEN` varchar(3) DEFAULT NULL,
  `NMKMPNEN` varchar(91) DEFAULT NULL,
  `KDSKMPNEN` varchar(2) DEFAULT NULL,
  `NmSkmpnen` varchar(97) DEFAULT NULL,
  `KDAKUN` varchar(6) DEFAULT NULL,
  `NMAKUN` varchar(68) DEFAULT NULL,
  `KDKPPN` varchar(3) DEFAULT NULL,
  `KDBEBAN` varchar(1) DEFAULT NULL,
  `KDJNSBAN` varchar(1) DEFAULT NULL,
  `KDCTARIK` varchar(1) DEFAULT NULL,
  `REGISTER` varchar(10) DEFAULT NULL,
  `CARAHITUNG` varchar(1) DEFAULT NULL,
  `HEADER1` varchar(2) DEFAULT NULL,
  `HEADER2` varchar(2) DEFAULT NULL,
  `KDHEADER` varchar(1) DEFAULT NULL,
  `NOITEM` varchar(2) DEFAULT NULL,
  `NMITEM` varchar(112) DEFAULT NULL,
  `VOL1` varchar(3) DEFAULT NULL,
  `SAT1` varchar(4) DEFAULT NULL,
  `VOL2` varchar(3) DEFAULT NULL,
  `SAT2` varchar(5) DEFAULT NULL,
  `VOL3` varchar(3) DEFAULT NULL,
  `SAT3` varchar(4) DEFAULT NULL,
  `VOL4` varchar(2) DEFAULT NULL,
  `SAT4` varchar(3) DEFAULT NULL,
  `VOLKEG` varchar(5) DEFAULT NULL,
  `SATKEG` varchar(4) DEFAULT NULL,
  `HARGASAT` decimal(20,0) DEFAULT NULL,
  `JUMLAH` decimal(20,0) DEFAULT NULL,
  `realisasi` decimal(20,3) DEFAULT NULL,
  `usulan` decimal(20,3) DEFAULT NULL,
  `JUMLAH2` varchar(1) DEFAULT NULL,
  `PAGUPHLN` varchar(1) DEFAULT NULL,
  `PAGURMP` varchar(1) DEFAULT NULL,
  `PAGURKP` varchar(1) DEFAULT NULL,
  `KDBLOKIR` varchar(1) DEFAULT NULL,
  `BLOKIRPHLN` varchar(1) DEFAULT NULL,
  `BLOKIRRMP` varchar(1) DEFAULT NULL,
  `BLOKIRRKP` varchar(1) DEFAULT NULL,
  `RPHBLOKIR` varchar(12) DEFAULT NULL,
  `KDCOPY` varchar(10) DEFAULT NULL,
  `KDABT` varchar(10) DEFAULT NULL,
  `KDSBU` varchar(10) DEFAULT NULL,
  `VOLSBK` varchar(1) DEFAULT NULL,
  `VOLRKAKL` varchar(1) DEFAULT NULL,
  `BLNKONTRAK` varchar(10) DEFAULT NULL,
  `NOKONTRAK` varchar(10) DEFAULT NULL,
  `TGKONTRAK` varchar(10) DEFAULT NULL,
  `NILKONTRAK` varchar(1) DEFAULT NULL,
  `JANUARI` varchar(1) DEFAULT NULL,
  `PEBRUARI` varchar(1) DEFAULT NULL,
  `MARET` varchar(1) DEFAULT NULL,
  `APRIL` varchar(1) DEFAULT NULL,
  `MEI` varchar(1) DEFAULT NULL,
  `JUNI` varchar(1) DEFAULT NULL,
  `JULI` varchar(1) DEFAULT NULL,
  `AGUSTUS` varchar(1) DEFAULT NULL,
  `SEPTEMBER` varchar(1) DEFAULT NULL,
  `OKTOBER` varchar(1) DEFAULT NULL,
  `NOPEMBER` varchar(1) DEFAULT NULL,
  `DESEMBER` varchar(1) DEFAULT NULL,
  `JMLTUNDA` varchar(1) DEFAULT NULL,
  `KDLUNCURAN` varchar(10) DEFAULT NULL,
  `JMLABT` varchar(1) DEFAULT NULL,
  `NOREV` varchar(10) DEFAULT NULL,
  `KDUBAH` varchar(10) DEFAULT NULL,
  `KURS` varchar(1) DEFAULT NULL,
  `INDEXKPJM` varchar(1) DEFAULT NULL,
  `KDIB` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
