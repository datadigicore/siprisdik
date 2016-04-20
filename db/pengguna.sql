-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2016 at 12:33 
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

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
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '2',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `kdprogram` varchar(8) NOT NULL,
  `direktorat` varchar(10) NOT NULL,
  `kdoutput` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `password`, `email`, `level`, `status`, `kdprogram`, `direktorat`, `kdoutput`) VALUES
(1, 'Yohanes Christomas Daimler', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'yohanes.christomas@gmail.com', 0, 1, '', '', ''),
(2, 'Yohanes Christomas Daimler', 'user1', '9ec62c20118ff506dac139ec30a521d12b9883e55da92b7d9adeefe09ed4e0bd152e2a099339871424263784f8103391f83b781c432f45eccb03e18e28060d2f', 'yohanes.christomas@gmail.com', 1, 1, '', '5698', ''),
(3, 'Yohanes Christomas Daimler', 'user2', '291116775902b38dd09587ad6235cec503fc14dbf9c09cad761f2e5a5755102eaceb54b95ffd179c22652c3910dbc6ed85ddde7e09eef1ecf3ad219225f509f5', 'yohanes.christomas@gmail.com', 2, 1, '', '5698', ''),
(4, 'Yohanes Christomas Daimler', 'user3', '8ac4145c8e388ddfe3cd94886f026260d917cab07903c533f3a26945019bc4a50e6f23f266acbb0cbae89130fa3242c9a5145e4218c3ef1deebccb58d1a64a43', 'yohanes.christomas@gmail.com', 3, 1, '', '5698', ''),
(10, 'bpp 5696', 'bpp5696', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5696@gmail.com', 2, 1, '', '5696', ''),
(11, 'bpp 5697', 'bpp5697', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5697@gmail.com', 2, 1, '', '5697', ''),
(12, 'bpp 5698', 'bpp5698', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5698@gmail.com', 2, 1, '', '5698', ''),
(13, 'bpp 5699', 'bpp5699', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5699@gmail.com', 2, 1, '', '5699', ''),
(14, 'bpp 5700', 'bpp5700', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5700@gmail.com', 2, 1, '', '5700', ''),
(15, 'opt bpp 5696', 'optbpp5696', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5696@gmail.com', 3, 1, '', '5696', ''),
(16, 'opt bpp 5697', 'optbpp5697', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5697@gmail.com', 3, 1, '', '5697', ''),
(17, 'opt bpp 5698', 'optbpp5698', 'e9bedc44dfc848de3f0dcf1644cb98b37c355cc139c35b98a2800d7556c7f31d2971316c9431b14d81b221d27f7ee50f8cee721dc9bcb3ae83a4059f1b1b487f', 'optbpp5698@gmail.com', 3, 1, '', '5698', ''),
(18, 'opt bpp 5699', 'optbpp5699', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5699@gmail.com', 3, 1, '', '5699', ''),
(19, 'opt bpp 5700', 'optbpp5700', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5700@gmail.com', 3, 1, '', '5700', ''),
(20, 'harris', 'tes', 'b551ea951724d66921f7e4991ee3b86e883921abf6a14552c73a4032cc87fa4900b2faa27d1cca5139d71a12937797cd29b589561fcc7fbb60dca460141afa65', 'adsf@gmail.com', 3, 1, '06', '5697', ''),
(21, 'nknlk', 'admin', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 'knlknl@lkn.com', 2, 1, '06', '5696', '001,004,994'),
(22, 'kjnkj', 'asd', 'e54ee7e285fbb0275279143abc4c554e5314e7b417ecac83a5984a964facbaad68866a2841c3e83ddf125a2985566261c4014f9f960ec60253aebcda9513a9b4', 'jknkj@scsdc.com', 2, 1, '06', '5698', '003,007');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
