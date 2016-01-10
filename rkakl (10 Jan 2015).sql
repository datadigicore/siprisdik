/*
SQLyog Ultimate v10.42 
MySQL - 5.6.25 : Database - rkakl
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rkakl` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `rkakl`;

/*Table structure for table `pengguna` */

DROP TABLE IF EXISTS `pengguna`;

CREATE TABLE `pengguna` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '2',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `direktorat` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `rabfull` */

DROP TABLE IF EXISTS `rabfull`;

CREATE TABLE `rabfull` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rabview_id` int(20) DEFAULT NULL,
  `thang` int(20) DEFAULT NULL,
  `kdprogram` int(20) DEFAULT NULL,
  `kdgiat` int(20) DEFAULT NULL,
  `kdoutput` int(20) DEFAULT NULL,
  `kdsoutput` int(20) DEFAULT NULL,
  `kdkmpnen` int(20) DEFAULT NULL,
  `kdskmpnen` int(20) DEFAULT NULL,
  `desc` text,
  `date` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `uang_muka` decimal(20,3) DEFAULT '0.000',
  `realisasi_spj` decimal(20,3) DEFAULT '0.000',
  `realisasi_pajak` decimal(20,3) DEFAULT '0.000',
  `sisa` decimal(20,3) DEFAULT '0.000',
  `status` int(5) DEFAULT NULL,
  `kdakun` int(20) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `pajak` varchar(255) DEFAULT NULL,
  `golongan` varchar(200) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `belanja` varchar(200) DEFAULT NULL,
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
  `biaya_akom` decimal(20,3) DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `rabview` */

DROP TABLE IF EXISTS `rabview`;

CREATE TABLE `rabview` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `thang` int(20) DEFAULT NULL,
  `kdprogram` int(20) DEFAULT NULL,
  `kdgiat` int(20) DEFAULT NULL,
  `kdoutput` int(20) DEFAULT NULL,
  `kdsoutput` int(20) DEFAULT NULL,
  `kdkmpnen` int(20) NOT NULL,
  `kdskmpnen` int(20) DEFAULT NULL,
  `desc` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(200) DEFAULT NULL,
  `uang_muka` decimal(20,3) NOT NULL,
  `realisasi_spj` decimal(20,3) DEFAULT NULL,
  `realisasi_pajak` decimal(20,3) DEFAULT NULL,
  `sisa` decimal(20,3) DEFAULT NULL,
  `status` int(5) NOT NULL,
  `submit_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submit_by` int(20) NOT NULL,
  `approve_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approve_by` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `rkakl_full` */

DROP TABLE IF EXISTS `rkakl_full`;

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

/*Table structure for table `rkakl_view` */

DROP TABLE IF EXISTS `rkakl_view`;

CREATE TABLE `rkakl_view` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesave` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tahun` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tes_phpexcel` */

DROP TABLE IF EXISTS `tes_phpexcel`;

CREATE TABLE `tes_phpexcel` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
