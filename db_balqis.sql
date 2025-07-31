/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - dbklinik
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbklinik` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `dbklinik`;

/*Table structure for table `booking` */

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `idbooking` varchar(30) NOT NULL,
  `id_pasien` varchar(30) NOT NULL,
  `idjadwal` varchar(30) NOT NULL,
  `idjenis` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status` enum('diproses','diterima','ditolak','diperiksa','selesai') NOT NULL DEFAULT 'diproses',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `konsultasi` double DEFAULT NULL,
  `catatan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idbooking`),
  KEY `fk_booking_pasien` (`id_pasien`),
  KEY `fk_booking_jadwal` (`idjadwal`),
  KEY `fk_booking_jenis` (`idjenis`),
  KEY `idx_booking_tanggal` (`tanggal`),
  KEY `idx_booking_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `booking` */

/*Table structure for table `detail_perawatan` */

DROP TABLE IF EXISTS `detail_perawatan`;

CREATE TABLE `detail_perawatan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `idperawatan` char(30) DEFAULT NULL,
  `idobat` char(30) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detail_perawatan` (`idperawatan`),
  KEY `fk_detail_obat` (`idobat`),
  CONSTRAINT `fk_detail_obat` FOREIGN KEY (`idobat`) REFERENCES `obat` (`idobat`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_detail_perawatan` FOREIGN KEY (`idperawatan`) REFERENCES `perawatan` (`idperawatan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `detail_perawatan` */

/*Table structure for table `dokter` */

DROP TABLE IF EXISTS `dokter`;

CREATE TABLE `dokter` (
  `id_dokter` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `tgllahir` date DEFAULT NULL,
  `nohp` char(30) DEFAULT NULL,
  `jenkel` enum('L','P') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `iduser` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dokter`),
  KEY `fk_dokter_user` (`iduser`),
  CONSTRAINT `fk_dokter_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `dokter` */

insert  into `dokter`(`id_dokter`,`nama`,`alamat`,`tgllahir`,`nohp`,`jenkel`,`foto`,`iduser`,`created_at`,`updated_at`,`deleted_at`) values 
('DK0001','DR. Balqis','Pariaman','2025-07-03','08129323923','L','foto-20250722-DK0001.png',9,'2025-07-03 06:30:48','2025-07-22 02:14:24',NULL),
('DK0002','DR. Sarah','Padang','1985-05-15','08123456789','P','foto-20250727-DK0002.png',NULL,'2025-07-27 08:00:00','2025-07-27 08:00:00',NULL);

/*Table structure for table `jadwal` */

DROP TABLE IF EXISTS `jadwal`;

CREATE TABLE `jadwal` (
  `idjadwal` char(30) NOT NULL,
  `hari` varchar(50) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `iddokter` char(30) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idjadwal`),
  KEY `fk_jadwal_dokter` (`iddokter`),
  KEY `idx_jadwal_hari` (`hari`),
  CONSTRAINT `fk_jadwal_dokter` FOREIGN KEY (`iddokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `jadwal` */

insert  into `jadwal`(`idjadwal`,`hari`,`waktu_mulai`,`waktu_selesai`,`iddokter`,`is_active`,`created_at`,`updated_at`,`deleted_at`) values 
('JD0001','Rabu','14:00:00','15:00:00','DK0001',1,'2025-07-15 15:53:53','2025-07-23 22:00:44',NULL),
('JD0002','Rabu','15:00:00','16:00:00','DK0001',1,'2025-07-15 16:27:55','2025-07-18 20:07:21',NULL),
('JD0003','Rabu','01:00:00','03:00:00','DK0001',1,'2025-07-16 14:51:31','2025-07-16 14:51:31',NULL),
('JD0004','Sabtu','18:00:00','23:50:00','DK0001',1,'2025-07-23 20:50:04','2025-07-23 22:01:13',NULL),
('JD0005','Rabu','09:00:00','12:00:00','DK0002',1,'2025-07-27 08:00:00','2025-07-27 08:00:00',NULL);

/*Table structure for table `jenis_perawatan` */

DROP TABLE IF EXISTS `jenis_perawatan`;

CREATE TABLE `jenis_perawatan` (
  `idjenis` char(30) NOT NULL,
  `namajenis` varchar(50) NOT NULL,
  `estimasi` int NOT NULL COMMENT 'Estimasi waktu dalam menit',
  `harga` double NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idjenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `jenis_perawatan` */

insert  into `jenis_perawatan`(`idjenis`,`namajenis`,`estimasi`,`harga`,`keterangan`,`created_at`,`updated_at`,`deleted_at`) values 
('JP0001','Cabut gigi',30,250000,'Pencabutan gigi dengan bius lokal','2025-07-16 04:03:40','2025-07-16 04:03:40',NULL),
('JP0002','Gigi berlubang',45,50000,'Penambalan gigi berlubang','2025-07-16 14:35:19','2025-07-16 14:35:30',NULL),
('JP0003','Pembersihan karang gigi',60,150000,'Scaling dan pembersihan karang gigi','2025-07-27 08:00:00','2025-07-27 08:00:00',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`version`,`class`,`group`,`namespace`,`time`,`batch`) values 
(1,'2023-08-01-000001','App\\Database\\Migrations\\CreateUsersTable','default','App',1749937856,1),
(2,'2023-10-10-000001','App\\Database\\Migrations\\CreateOtpCodesTable','default','App',1749937893,2);

/*Table structure for table `obat` */

DROP TABLE IF EXISTS `obat`;

CREATE TABLE `obat` (
  `idobat` char(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `stok` int DEFAULT '0',
  `jenis` enum('minum','bahan') NOT NULL,
  `harga` double DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idobat`),
  KEY `idx_obat_jenis` (`jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `obat` */

insert  into `obat`(`idobat`,`nama`,`stok`,`jenis`,`harga`,`keterangan`,`created_at`,`updated_at`,`deleted_at`) values 
('OB0001','Cetak Gigi',103,'bahan',50000,'Bahan Gigi Depan','2025-07-26 21:47:56','2025-07-30 00:07:08',NULL),
('OB0002','Paracetamol',52,'minum',5000,'Obat pereda nyeri','2025-07-27 08:00:00','2025-07-30 00:07:08',NULL),
('OB0003','Amoxicillin',30,'minum',15000,'Antibiotik untuk infeksi','2025-07-27 08:00:00','2025-07-30 01:25:57',NULL);

/*Table structure for table `obatmasuk` */

DROP TABLE IF EXISTS `obatmasuk`;

CREATE TABLE `obatmasuk` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `faktur` varchar(50) DEFAULT NULL,
  `tglmasuk` date DEFAULT NULL,
  `idobat` char(30) DEFAULT NULL,
  `tglexpired` date DEFAULT NULL,
  `qty` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_obatmasuk_obat` (`idobat`),
  CONSTRAINT `fk_obatmasuk_obat` FOREIGN KEY (`idobat`) REFERENCES `obat` (`idobat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `obatmasuk` */

insert  into `obatmasuk`(`id`,`faktur`,`tglmasuk`,`idobat`,`tglexpired`,`qty`) values 
(1,'FA2020','2025-07-23','OB0001','2028-07-23',10),
(2,'FA2021','2025-07-23','OB0002','2027-01-23',50),
(3,'FK2020','2025-07-23','OB0001','2028-07-22',10),
(4,'FK2021','2025-07-27','OB0003','2027-07-27',30);

/*Table structure for table `otp_codes` */

DROP TABLE IF EXISTS `otp_codes`;

CREATE TABLE `otp_codes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `type` enum('register','forgot_password') NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_otp_code` (`otp_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `otp_codes` */

/*Table structure for table `pasien` */

DROP TABLE IF EXISTS `pasien`;

CREATE TABLE `pasien` (
  `id_pasien` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `tgllahir` date DEFAULT NULL,
  `nohp` char(30) DEFAULT NULL,
  `jenkel` enum('L','P') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `iduser` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pasien`),
  KEY `fk_pasien_user` (`iduser`),
  CONSTRAINT `fk_pasien_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pasien` */

insert  into `pasien`(`id_pasien`,`nama`,`alamat`,`tgllahir`,`nohp`,`jenkel`,`foto`,`iduser`,`created_at`,`updated_at`,`deleted_at`) values 
('PS0001','Ahmad Rizki','Jl. Sudirman No. 123','1990-01-15','08111234567','L',NULL,20,'2025-07-27 08:00:00','2025-07-27 08:00:00',NULL),
('PS0002','Siti Aminah','Jl. Merdeka No. 456','1995-03-20','08221234567','L',NULL,22,'2025-07-27 08:00:00','2025-07-30 00:47:41',NULL),
('PS0003','Jokowi','Jawa','2025-07-27','081234567','L','foto-20250727-PS0003.png',NULL,'2025-07-27 01:55:57','2025-07-30 00:47:49',NULL),
('PS0004','Penggaris Joyko','sadad','2025-07-29','123213','L','foto-20250729-PS0004.png',NULL,'2025-07-29 23:52:49','2025-07-30 00:47:58',NULL),
('PS0005','tes','padang','2025-07-30','0812155','L',NULL,24,'2025-07-30 00:50:16','2025-07-30 00:50:16',NULL);

/*Table structure for table `perawatan` */

DROP TABLE IF EXISTS `perawatan`;

CREATE TABLE `perawatan` (
  `idperawatan` char(30) NOT NULL,
  `idbooking` varchar(30) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `resep` text,
  `total` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idperawatan`),
  KEY `fk_perawatan_booking` (`idbooking`),
  KEY `idx_perawatan_tanggal` (`tanggal`),
  CONSTRAINT `fk_perawatan_booking` FOREIGN KEY (`idbooking`) REFERENCES `booking` (`idbooking`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `perawatan` */

/*Table structure for table `temp` */

DROP TABLE IF EXISTS `temp`;

CREATE TABLE `temp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idobat` char(30) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_temp_obat` (`idobat`),
  CONSTRAINT `fk_temp_obat` FOREIGN KEY (`idobat`) REFERENCES `obat` (`idobat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `temp` */

/*Table structure for table `temp_masuk` */

DROP TABLE IF EXISTS `temp_masuk`;

CREATE TABLE `temp_masuk` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `faktur` varchar(255) DEFAULT NULL,
  `tglmasuk` date DEFAULT NULL,
  `idobat` char(30) DEFAULT NULL,
  `tglexpired` date DEFAULT NULL,
  `qty` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_temp_masuk_obat` (`idobat`),
  CONSTRAINT `fk_temp_masuk_obat` FOREIGN KEY (`idobat`) REFERENCES `obat` (`idobat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `temp_masuk` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'pasien',
  `status` varchar(20) NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`status`,`last_login`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'balqis','admin@example.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','admin','active','2025-07-31 09:37:35',NULL,'2025-06-14 21:50:56','2025-06-14 21:50:56',NULL),
(9,'drbalqis','dokterbalqis@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','dokter','active','2025-07-28 21:52:58',NULL,'2025-06-28 10:30:11','2025-06-28 10:30:11',NULL),
(19,'pimpinan','pimpinan@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','pimpinan','active','2025-07-27 01:24:55',NULL,'2025-07-24 17:33:56','2025-07-24 17:33:56',NULL),
(20,'pasien01','pasien01@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','pasien','active',NULL,NULL,'2025-07-27 08:00:00','2025-07-27 08:00:00',NULL),
(22,'jokowi','jokowi@gmail.com','$2y$10$NSOyg6AQeyFOVfVHQ4fcTu4cEcTZMcCEedRoc22.5NvXiQ93O4jc.','pasien','active','2025-07-27 06:42:25',NULL,'2025-07-27 01:56:16','2025-07-27 01:56:16',NULL),
(24,'pasien02','pasien02@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','pasien','active','2025-07-30 00:49:06',NULL,'2025-07-27 08:00:00','2025-07-27 08:00:00',NULL);

/*Table structure for table `v_jadwal_dokter` */

DROP TABLE IF EXISTS `v_jadwal_dokter`;

/*!50001 DROP VIEW IF EXISTS `v_jadwal_dokter` */;
/*!50001 DROP TABLE IF EXISTS `v_jadwal_dokter` */;

/*!50001 CREATE TABLE  `v_jadwal_dokter`(
 `idjadwal` char(30) ,
 `hari` varchar(50) ,
 `waktu_mulai` time ,
 `waktu_selesai` time ,
 `is_active` tinyint(1) ,
 `id_dokter` char(30) ,
 `nama_dokter` varchar(50) ,
 `nohp` char(30) ,
 `email_dokter` varchar(100) 
)*/;

/*Table structure for table `v_stok_obat` */

DROP TABLE IF EXISTS `v_stok_obat`;

/*!50001 DROP VIEW IF EXISTS `v_stok_obat` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_obat` */;

/*!50001 CREATE TABLE  `v_stok_obat`(
 `idobat` char(30) ,
 `nama` varchar(50) ,
 `jenis` enum('minum','bahan') ,
 `stok` int ,
 `harga` double ,
 `total_masuk` decimal(32,0) ,
 `keterangan` text 
)*/;

/*View structure for view v_jadwal_dokter */

/*!50001 DROP TABLE IF EXISTS `v_jadwal_dokter` */;
/*!50001 DROP VIEW IF EXISTS `v_jadwal_dokter` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jadwal_dokter` AS select `j`.`idjadwal` AS `idjadwal`,`j`.`hari` AS `hari`,`j`.`waktu_mulai` AS `waktu_mulai`,`j`.`waktu_selesai` AS `waktu_selesai`,`j`.`is_active` AS `is_active`,`d`.`id_dokter` AS `id_dokter`,`d`.`nama` AS `nama_dokter`,`d`.`nohp` AS `nohp`,`u`.`email` AS `email_dokter` from ((`jadwal` `j` join `dokter` `d` on((`j`.`iddokter` = `d`.`id_dokter`))) left join `users` `u` on((`d`.`iduser` = `u`.`id`))) where ((`j`.`deleted_at` is null) and (`j`.`is_active` = 1)) */;

/*View structure for view v_stok_obat */

/*!50001 DROP TABLE IF EXISTS `v_stok_obat` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_obat` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_obat` AS select `o`.`idobat` AS `idobat`,`o`.`nama` AS `nama`,`o`.`jenis` AS `jenis`,`o`.`stok` AS `stok`,`o`.`harga` AS `harga`,coalesce(sum(`om`.`qty`),0) AS `total_masuk`,`o`.`keterangan` AS `keterangan` from (`obat` `o` left join `obatmasuk` `om` on((`o`.`idobat` = `om`.`idobat`))) where (`o`.`deleted_at` is null) group by `o`.`idobat`,`o`.`nama`,`o`.`jenis`,`o`.`stok`,`o`.`harga`,`o`.`keterangan` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
