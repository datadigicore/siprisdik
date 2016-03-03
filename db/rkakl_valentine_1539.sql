-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2016 at 09:38 
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
-- Table structure for table `direktorat`
--

CREATE TABLE `direktorat` (
  `id` int(20) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `ppk` varchar(255) DEFAULT NULL,
  `nip_ppk` varchar(30) DEFAULT NULL,
  `bpp` varchar(255) DEFAULT NULL,
  `nip_bpp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kuitansi`
--

CREATE TABLE `kuitansi` (
  `id` int(20) NOT NULL DEFAULT '0',
  `no_kuitansi` int(20) DEFAULT NULL,
  `no_kuitansi_update` int(20) DEFAULT NULL,
  `rabview_id` int(20) DEFAULT NULL,
  `thang` varchar(20) DEFAULT NULL,
  `kdprogram` varchar(20) DEFAULT NULL,
  `kdgiat` varchar(20) DEFAULT NULL,
  `kdoutput` varchar(20) DEFAULT NULL,
  `kdsoutput` varchar(20) DEFAULT NULL,
  `kdkmpnen` varchar(20) DEFAULT NULL,
  `kdskmpnen` varchar(20) DEFAULT NULL,
  `kdakun` varchar(20) DEFAULT NULL,
  `noitem` varchar(20) DEFAULT NULL,
  `deskripsi` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `uang_muka` decimal(20,3) DEFAULT '0.000',
  `realisasi_spj` decimal(20,3) DEFAULT '0.000',
  `realisasi_pajak` decimal(20,3) DEFAULT '0.000',
  `sisa` decimal(20,3) DEFAULT '0.000',
  `status` int(5) DEFAULT '0',
  `jenis` int(5) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `pajak` varchar(255) DEFAULT NULL,
  `ppn` decimal(20,3) DEFAULT NULL,
  `pph` decimal(20,3) DEFAULT NULL,
  `golongan` varchar(200) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `value` decimal(20,3) DEFAULT '0.000',
  `belanja` decimal(20,3) DEFAULT '0.000',
  `honor_output` decimal(20,3) DEFAULT '0.000',
  `honor_profesi` decimal(20,3) DEFAULT '0.000',
  `uang_saku` decimal(20,3) DEFAULT '0.000',
  `trans_lokal` decimal(20,3) DEFAULT '0.000',
  `uang_harian` decimal(20,3) DEFAULT '0.000',
  `tiket` decimal(20,3) DEFAULT '0.000',
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `tingkat_jalan` varchar(10) DEFAULT NULL,
  `alat_trans` varchar(255) DEFAULT NULL,
  `kota_asal` varchar(255) DEFAULT NULL,
  `kota_tujuan` varchar(255) DEFAULT NULL,
  `taxi_asal` decimal(20,3) DEFAULT '0.000',
  `taxi_tujuan` decimal(20,3) DEFAULT '0.000',
  `airport_tax` decimal(20,3) DEFAULT '0.000',
  `rute1` varchar(255) DEFAULT NULL,
  `rute2` varchar(255) DEFAULT NULL,
  `rute3` varchar(255) DEFAULT NULL,
  `rute4` varchar(255) DEFAULT NULL,
  `harga_tiket` varchar(255) DEFAULT NULL,
  `lama_hari` varchar(255) DEFAULT NULL,
  `klmpk_hr` varchar(255) DEFAULT NULL,
  `pns` int(3) DEFAULT NULL,
  `malam` varchar(255) DEFAULT NULL,
  `biaya_akom` decimal(20,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `direktorat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `password`, `email`, `level`, `status`, `direktorat`) VALUES
(1, 'Yohanes Christomas Daimler', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'yohanes.christomas@gmail.com', 0, 1, ''),
(2, 'Yohanes Christomas Daimler', 'user1', '9ec62c20118ff506dac139ec30a521d12b9883e55da92b7d9adeefe09ed4e0bd152e2a099339871424263784f8103391f83b781c432f45eccb03e18e28060d2f', 'yohanes.christomas@gmail.com', 1, 1, '5698'),
(3, 'Yohanes Christomas Daimler', 'user2', '291116775902b38dd09587ad6235cec503fc14dbf9c09cad761f2e5a5755102eaceb54b95ffd179c22652c3910dbc6ed85ddde7e09eef1ecf3ad219225f509f5', 'yohanes.christomas@gmail.com', 2, 1, '5698'),
(4, 'Yohanes Christomas Daimler', 'user3', '8ac4145c8e388ddfe3cd94886f026260d917cab07903c533f3a26945019bc4a50e6f23f266acbb0cbae89130fa3242c9a5145e4218c3ef1deebccb58d1a64a43', 'yohanes.christomas@gmail.com', 3, 1, '5698'),
(5, 'opt bp 5696', 'optbp5696', 'c1b40fff327d7ce4c0c96835e77304b7b82555f59424ad13188dda9f3fb07cf77c2c240156cd74ce5ee7a0fd29389f3c553c78499885436c86ff812e995dc598', 'bp@gmail.com', 1, 1, '5696'),
(6, 'opt bp 5697', 'optbp5697', 'c1b40fff327d7ce4c0c96835e77304b7b82555f59424ad13188dda9f3fb07cf77c2c240156cd74ce5ee7a0fd29389f3c553c78499885436c86ff812e995dc598', 'optbp5697@gmail.com', 1, 1, '5697'),
(7, 'opt bp 5698', 'optbp5698', 'c1b40fff327d7ce4c0c96835e77304b7b82555f59424ad13188dda9f3fb07cf77c2c240156cd74ce5ee7a0fd29389f3c553c78499885436c86ff812e995dc598', 'optbp5698@gmail.com', 1, 1, '5698'),
(8, 'opt bp 5699', 'optbp5699', 'c1b40fff327d7ce4c0c96835e77304b7b82555f59424ad13188dda9f3fb07cf77c2c240156cd74ce5ee7a0fd29389f3c553c78499885436c86ff812e995dc598', 'optbp5699@gmail.com', 1, 1, '5699'),
(9, 'opt bp 5700', 'optbp5700', 'c1b40fff327d7ce4c0c96835e77304b7b82555f59424ad13188dda9f3fb07cf77c2c240156cd74ce5ee7a0fd29389f3c553c78499885436c86ff812e995dc598', 'optbp5700@gmail.com', 1, 1, '5700'),
(10, 'bpp 5696', 'bpp5696', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5696@gmail.com', 2, 1, '5696'),
(11, 'bpp 5697', 'bpp5697', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5697@gmail.com', 2, 1, '5697'),
(12, 'bpp 5698', 'bpp5698', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5698@gmail.com', 2, 1, '5698'),
(13, 'bpp 5699', 'bpp5699', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5699@gmail.com', 2, 1, '5699'),
(14, 'bpp 5700', 'bpp5700', '3e162394472f9b09c72321b192bf13816df99aff55020c70d83719c1d01c1f80a62951ad466516080479be82f28ebd1ac268d3051725cdb9f4e6260530bb7c5f', 'bpp5700@gmail.com', 2, 1, '5700'),
(15, 'opt bpp 5696', 'optbpp5696', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5696@gmail.com', 3, 1, '5696'),
(16, 'opt bpp 5697', 'optbpp5697', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5697@gmail.com', 3, 1, '5697'),
(17, 'opt bpp 5698', 'optbpp5698', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5698@gmail.com', 3, 1, '5698'),
(18, 'opt bpp 5699', 'optbpp5699', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5699@gmail.com', 3, 1, '5699'),
(19, 'opt bpp 5700', 'optbpp5700', '61848eb89040f67b4c4037519ecfaf73b53d1ceeee2e0727e5f4f6c2733b290d074fd2b821be2ffbcead6bdd5a0d98238dd0e14b746597644ca2fc2b09728c6a', 'optbpp5700@gmail.com', 3, 1, '5700');

-- --------------------------------------------------------

--
-- Table structure for table `perjalanan`
--

CREATE TABLE `perjalanan` (
  `id` int(20) NOT NULL DEFAULT '0',
  `rabfull_id` int(20) DEFAULT NULL,
  `rute` varchar(255) DEFAULT NULL,
  `thang` varchar(20) DEFAULT NULL,
  `kdprogram` varchar(20) DEFAULT NULL,
  `kdgiat` varchar(20) DEFAULT NULL,
  `kdoutput` varchar(20) DEFAULT NULL,
  `kdsoutput` varchar(20) DEFAULT NULL,
  `kdkmpnen` varchar(20) DEFAULT NULL,
  `kdskmpnen` varchar(20) DEFAULT NULL,
  `kdakun` varchar(20) DEFAULT NULL,
  `noitem` varchar(20) DEFAULT NULL,
  `no_kuitansi` int(20) DEFAULT NULL,
  `deskripsi` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `uang_muka` decimal(20,3) DEFAULT '0.000',
  `realisasi_spj` decimal(20,3) DEFAULT '0.000',
  `realisasi_pajak` decimal(20,3) DEFAULT '0.000',
  `sisa` decimal(20,3) DEFAULT '0.000',
  `status` int(5) DEFAULT '0',
  `jenis` int(5) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `pajak` int(10) DEFAULT '0',
  `golongan` varchar(200) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `pns` int(3) DEFAULT '1',
  `value` decimal(20,3) DEFAULT '0.000',
  `belanja` decimal(20,3) DEFAULT '0.000',
  `honor_output` decimal(20,3) DEFAULT '0.000',
  `honor_profesi` decimal(20,3) DEFAULT '0.000',
  `uang_saku` decimal(20,3) DEFAULT '0.000',
  `trans_lokal` decimal(20,3) DEFAULT '0.000',
  `uang_harian` decimal(20,3) DEFAULT '0.000',
  `tiket` decimal(20,3) DEFAULT '0.000',
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `tingkat_jalan` varchar(10) DEFAULT NULL,
  `alat_trans` varchar(255) DEFAULT NULL,
  `kota_asal` varchar(255) DEFAULT NULL,
  `kota_tujuan` varchar(255) DEFAULT NULL,
  `taxi_asal` decimal(20,3) DEFAULT '0.000',
  `taxi_tujuan` decimal(20,3) DEFAULT '0.000',
  `airport_tax` decimal(20,3) DEFAULT '0.000',
  `harga_tiket` varchar(255) DEFAULT NULL,
  `lama_hari` varchar(255) DEFAULT NULL,
  `klmpk_hr` varchar(255) DEFAULT NULL,
  `malam` varchar(255) DEFAULT NULL,
  `biaya_akom` decimal(20,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rabfull`
--

CREATE TABLE `rabfull` (
  `id` int(20) NOT NULL,
  `rabview_id` int(20) DEFAULT NULL,
  `thang` varchar(20) DEFAULT NULL,
  `kdprogram` varchar(20) DEFAULT NULL,
  `kdgiat` varchar(20) DEFAULT NULL,
  `kdoutput` varchar(20) DEFAULT NULL,
  `kdsoutput` varchar(20) DEFAULT NULL,
  `kdkmpnen` varchar(20) DEFAULT NULL,
  `kdskmpnen` varchar(20) DEFAULT NULL,
  `kdakun` varchar(20) DEFAULT NULL,
  `noitem` varchar(20) DEFAULT NULL,
  `no_kuitansi` int(20) DEFAULT NULL,
  `deskripsi` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `uang_muka` decimal(20,3) DEFAULT '0.000',
  `realisasi_spj` decimal(20,3) DEFAULT '0.000',
  `realisasi_pajak` decimal(20,3) DEFAULT '0.000',
  `sisa` decimal(20,3) DEFAULT '0.000',
  `status` int(5) DEFAULT '0',
  `jenis` int(5) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `pajak` int(3) DEFAULT NULL,
  `pph` decimal(20,3) DEFAULT '0.000',
  `ppn` decimal(20,3) DEFAULT NULL,
  `golongan` varchar(200) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `pns` int(3) DEFAULT '1',
  `value` decimal(20,3) DEFAULT '0.000',
  `belanja` decimal(20,3) DEFAULT '0.000',
  `honor_output` decimal(20,3) DEFAULT '0.000',
  `honor_profesi` decimal(20,3) DEFAULT '0.000',
  `uang_saku` decimal(20,3) DEFAULT '0.000',
  `trans_lokal` decimal(20,3) DEFAULT '0.000',
  `uang_harian` decimal(20,3) DEFAULT '0.000',
  `tiket` decimal(20,3) DEFAULT '0.000',
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `tingkat_jalan` varchar(10) DEFAULT NULL,
  `alat_trans` varchar(255) DEFAULT NULL,
  `kota_asal` varchar(255) DEFAULT NULL,
  `kota_tujuan` varchar(255) DEFAULT NULL,
  `taxi_asal` decimal(20,3) DEFAULT '0.000',
  `taxi_tujuan` decimal(20,3) DEFAULT '0.000',
  `airport_tax` decimal(20,3) DEFAULT '0.000',
  `rute1` varchar(255) DEFAULT NULL,
  `rute2` varchar(255) DEFAULT NULL,
  `rute3` varchar(255) DEFAULT NULL,
  `rute4` varchar(255) DEFAULT NULL,
  `harga_tiket` varchar(255) DEFAULT NULL,
  `lama_hari` varchar(255) DEFAULT NULL,
  `klmpk_hr` varchar(255) DEFAULT NULL,
  `malam` varchar(255) DEFAULT NULL,
  `biaya_akom` decimal(20,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rabview`
--

CREATE TABLE `rabview` (
  `id` int(20) NOT NULL,
  `thang` varchar(20) DEFAULT NULL,
  `kdprogram` varchar(20) DEFAULT NULL,
  `kdgiat` varchar(20) DEFAULT NULL,
  `kdoutput` varchar(20) DEFAULT NULL,
  `kdsoutput` varchar(20) DEFAULT NULL,
  `kdkmpnen` varchar(20) NOT NULL,
  `kdskmpnen` varchar(20) DEFAULT NULL,
  `deskripsi` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(200) DEFAULT NULL,
  `uang_muka` decimal(20,3) NOT NULL,
  `realisasi_spj` decimal(20,3) DEFAULT NULL,
  `realisasi_pajak` decimal(20,3) DEFAULT NULL,
  `sisa` decimal(20,3) DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT '0',
  `submit_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submit_by` int(20) NOT NULL,
  `approve_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approve_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `rkakl_view`
--

CREATE TABLE `rkakl_view` (
  `id` int(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesave` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tahun` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `versi` int(16) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `direktorat`
--
ALTER TABLE `direktorat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rabfull`
--
ALTER TABLE `rabfull`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rabview`
--
ALTER TABLE `rabview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rkakl_view`
--
ALTER TABLE `rkakl_view`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `direktorat`
--
ALTER TABLE `direktorat`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `rabfull`
--
ALTER TABLE `rabfull`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rabview`
--
ALTER TABLE `rabview`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rkakl_view`
--
ALTER TABLE `rkakl_view`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
