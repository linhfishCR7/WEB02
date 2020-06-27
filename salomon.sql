-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for salomon
DROP DATABASE IF EXISTS `salomon`;
CREATE DATABASE IF NOT EXISTS `salomon` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `salomon`;

-- Dumping structure for table salomon.blog
DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `bl_ma` int(11) NOT NULL AUTO_INCREMENT,
  `bl_chude` varchar(50) DEFAULT NULL,
  `bl_hinhanh` varchar(50) DEFAULT NULL,
  `bl_mota_ngan` text DEFAULT NULL,
  `bl_noidung` text DEFAULT NULL,
  `bl_ngay` date DEFAULT NULL,
  `bl_tags` varchar(50) DEFAULT NULL,
  `lsp_ma` int(11) DEFAULT NULL,
  `kh_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`bl_ma`),
  KEY `FK_khachhang_blog` (`kh_ma`),
  KEY `Loaisanpham_blog` (`lsp_ma`),
  CONSTRAINT `FK_khachhang_blog` FOREIGN KEY (`kh_ma`) REFERENCES `khachhang` (`kh_ma`),
  CONSTRAINT `FK_loaisanpham_blog` FOREIGN KEY (`lsp_ma`) REFERENCES `loaisanpham` (`lsp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table salomon.chudegopy
DROP TABLE IF EXISTS `chudegopy`;
CREATE TABLE IF NOT EXISTS `chudegopy` (
  `cdgy_ma` int(11) NOT NULL AUTO_INCREMENT,
  `cdgy_ten` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cdgy_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table salomon.dondathang
DROP TABLE IF EXISTS `dondathang`;
CREATE TABLE IF NOT EXISTS `dondathang` (
  `dh_ma` int(11) NOT NULL AUTO_INCREMENT,
  `dh_ngaylap` datetime NOT NULL,
  `dh_ngaygiao` datetime DEFAULT NULL,
  `dh_noigiao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dh_trangthaithanhtoan` int(11) NOT NULL,
  `httt_ma` int(11) NOT NULL,
  `kh_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`dh_ma`),
  KEY `dondathang_hinhthucthanhtoan_idx` (`httt_ma`),
  KEY `dondathang_khachhang_idx` (`kh_ma`),
  CONSTRAINT `dondathang_hinhthucthanhtoan` FOREIGN KEY (`httt_ma`) REFERENCES `hinhthucthanhtoan` (`httt_ma`),
  CONSTRAINT `dondathang_khachhang` FOREIGN KEY (`kh_ma`) REFERENCES `khachhang` (`kh_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.gopy
DROP TABLE IF EXISTS `gopy`;
CREATE TABLE IF NOT EXISTS `gopy` (
  `gy_ma` int(11) NOT NULL AUTO_INCREMENT,
  `gy_hoten` varchar(50) DEFAULT NULL,
  `gy_email` varchar(50) DEFAULT NULL,
  `gy_diachi` varchar(500) DEFAULT NULL,
  `gy_dienthoai` varchar(20) DEFAULT NULL,
  `gy_tieude` varchar(50) DEFAULT NULL,
  `gy_noidung` text DEFAULT NULL,
  `gy_ngaygopy` datetime DEFAULT NULL,
  `cdgy_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`gy_ma`),
  KEY `cdgy_ma` (`cdgy_ma`),
  CONSTRAINT `chudegopy_gopy` FOREIGN KEY (`cdgy_ma`) REFERENCES `chudegopy` (`cdgy_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table salomon.gopy_blog
DROP TABLE IF EXISTS `gopy_blog`;
CREATE TABLE IF NOT EXISTS `gopy_blog` (
  `gy_bl_ma` int(11) NOT NULL AUTO_INCREMENT,
  `gy_bl_noidung` text DEFAULT NULL,
  `bl_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`gy_bl_ma`),
  KEY `blog_gopyblog` (`bl_ma`),
  CONSTRAINT `FK_blog_gopy` FOREIGN KEY (`bl_ma`) REFERENCES `blog` (`bl_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table salomon.hinhblog
DROP TABLE IF EXISTS `hinhblog`;
CREATE TABLE IF NOT EXISTS `hinhblog` (
  `hb_ma` int(11) NOT NULL AUTO_INCREMENT,
  `hb_tentaptin` varchar(255) DEFAULT NULL,
  `bl_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`hb_ma`),
  KEY `hinhblog_blog` (`bl_ma`),
  CONSTRAINT `FK_blog_hinhblog` FOREIGN KEY (`bl_ma`) REFERENCES `blog` (`bl_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table salomon.hinhsanpham
DROP TABLE IF EXISTS `hinhsanpham`;
CREATE TABLE IF NOT EXISTS `hinhsanpham` (
  `hsp_ma` int(11) NOT NULL AUTO_INCREMENT,
  `hsp_tentaptin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sp_ma` int(11) NOT NULL,
  PRIMARY KEY (`hsp_ma`),
  KEY `fk_hinhsanpham_sanpham1_idx` (`sp_ma`),
  CONSTRAINT `fk_hinhsanpham_sanpham1` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.hinhthucthanhtoan
DROP TABLE IF EXISTS `hinhthucthanhtoan`;
CREATE TABLE IF NOT EXISTS `hinhthucthanhtoan` (
  `httt_ma` int(11) NOT NULL AUTO_INCREMENT,
  `httt_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`httt_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.khachhang
DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `kh_ma` int(11) NOT NULL AUTO_INCREMENT,
  `kh_tendangnhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kh_matkhau` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kh_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kh_gioitinh` int(11) NOT NULL,
  `kh_diachi` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `kh_dienthoai` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kh_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kh_ngaysinh` int(11) DEFAULT NULL,
  `kh_thangsinh` int(11) DEFAULT NULL,
  `kh_namsinh` int(11) NOT NULL,
  `kh_cmnd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kh_makichhoat` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kh_trangthai` int(11) NOT NULL,
  `kh_quantri` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`kh_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.khuyenmai
DROP TABLE IF EXISTS `khuyenmai`;
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `km_ma` int(11) NOT NULL AUTO_INCREMENT,
  `km_ten` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `km_noidung` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `km_tungay` date DEFAULT NULL,
  `km_denngay` date DEFAULT NULL,
  PRIMARY KEY (`km_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.loaisanpham
DROP TABLE IF EXISTS `loaisanpham`;
CREATE TABLE IF NOT EXISTS `loaisanpham` (
  `lsp_ma` int(11) NOT NULL AUTO_INCREMENT,
  `lsp_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lsp_mota` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lsp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.nhasanxuat
DROP TABLE IF EXISTS `nhasanxuat`;
CREATE TABLE IF NOT EXISTS `nhasanxuat` (
  `nsx_ma` int(11) NOT NULL AUTO_INCREMENT,
  `nsx_ten` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`nsx_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.review
DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `rv_ma` int(11) NOT NULL AUTO_INCREMENT,
  `rv_ten` varchar(100) NOT NULL,
  `rv_noidung` text DEFAULT NULL,
  `rv_hsp` varchar(255) DEFAULT NULL,
  `sp_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`rv_ma`,`rv_ten`),
  KEY `review_sanpham` (`sp_ma`),
  CONSTRAINT `review_sanpham` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table salomon.sanpham
DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `sp_ma` int(11) NOT NULL AUTO_INCREMENT,
  `sp_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sp_gia` decimal(12,2) DEFAULT NULL,
  `sp_giacu` decimal(12,2) DEFAULT NULL,
  `sp_mota_ngan` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `sp_mota_chitiet` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sp_ngaycapnhat` datetime NOT NULL,
  `sp_soluong` int(11) DEFAULT NULL,
  `sp_khoiluong` float DEFAULT NULL,
  `sp_availability` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sp_shipping` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sp_phantram` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lsp_ma` int(11) NOT NULL,
  `nsx_ma` int(11) NOT NULL,
  `km_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`sp_ma`),
  KEY `sanpham_loaisanpham_idx` (`lsp_ma`),
  KEY `sanpham_nhasanxuat_idx` (`nsx_ma`),
  KEY `sanpham_khuyenmai_idx` (`km_ma`),
  CONSTRAINT `sanpham_khuyemmai` FOREIGN KEY (`km_ma`) REFERENCES `khuyenmai` (`km_ma`),
  CONSTRAINT `sanpham_loaisanpham` FOREIGN KEY (`lsp_ma`) REFERENCES `loaisanpham` (`lsp_ma`),
  CONSTRAINT `sanpham_nhasanxuat` FOREIGN KEY (`nsx_ma`) REFERENCES `nhasanxuat` (`nsx_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table salomon.sanpham_dondathang
DROP TABLE IF EXISTS `sanpham_dondathang`;
CREATE TABLE IF NOT EXISTS `sanpham_dondathang` (
  `sp_ma` int(11) NOT NULL,
  `dh_ma` int(11) NOT NULL,
  `sp_dh_soluong` int(11) NOT NULL,
  `sp_dh_dongia` decimal(12,2) NOT NULL,
  PRIMARY KEY (`sp_ma`,`dh_ma`),
  KEY `sanpham_donhang_sanpham_idx` (`sp_ma`),
  KEY `sanpham_donhang_dondathang_idx` (`dh_ma`),
  CONSTRAINT `sanpham_donhang_dondathang` FOREIGN KEY (`dh_ma`) REFERENCES `dondathang` (`dh_ma`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sanpham_donhang_sanpham` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
