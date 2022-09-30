/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : sk_egik

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 02/02/2021 21:16:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_boat
-- ----------------------------
DROP TABLE IF EXISTS `tbl_boat`;
CREATE TABLE `tbl_boat`  (
  `kodeboat` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodejenis` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kodeowner` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `keteranganboat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `hargaboat` int(11) DEFAULT NULL,
  `gambarboat_1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gambarboat_2` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gambarboat_3` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gambarboat_4` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dateaddboat` datetime(0) DEFAULT NULL,
  `dateupdboat` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`kodeboat`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_boat
-- ----------------------------
INSERT INTO `tbl_boat` VALUES ('BOAT001', 'JENIS002', 'OWNER001', NULL, 'Terdapat dua susunan dalam, yakni persneling-v dan persneling langsung. Persneling langsung memiliki pembangkit yang dipasang dekat bagian tengah perahu dengan batang baling-baling lurus ke belakang, yang persneling-v memiliki pembangkit yang dipasang di bagian belakang perahu yang menghadap ke belakang dan memiliki batang ke depan perahu kemudian membuat putaran &amp;#39;V&amp;#39; ke belakang. Persneling-v menjadi semakin populer berkat olahraga wakeboarding dan wakesurfing.', 200000, 'pic_1605618508_the-hinckley-sport-boat_water.jpg', '', '', '', '2020-11-17 13:02:00', '2020-11-17 13:08:00');
INSERT INTO `tbl_boat` VALUES ('BOAT002', 'JENIS002', 'OWNER001', NULL, 'Lanchester mulai mengalami konflik antara pekerjaannya sebagai pengurus dan kerja penyelidikannya terganggu. Dengan itu, pada tahun 1893, dia berhenti dari kedudukannya dan digantikan oleh adiknya George. Pada masa yang sama dia menghasilkan mesin kedua yang sama rancangannya dengan sebelumnya tetapi menggunakan benzena 800 r.p.m. Bagian penting mesin barunya adalah karburatornya yang revolusioner karena mencampurkan bahan bakar dan udara dengan benar. Penemuannya dikenal sebagai kaburator sumbu, kerana bahan bakar ditarik masuk melalui baris sumbu, yang kemudian menguap. Dia mematenkan ciptaannya pada tahun 1905.', 200000, 'pic_1605618501_boat-lettering.jpg', '', '', '', '2020-11-17 13:04:00', '2020-11-17 13:08:00');
INSERT INTO `tbl_boat` VALUES ('BOAT003', 'JENIS001', 'OWNER002', NULL, 'Lanchester memasang mesin bensin barunya pada kapal berkas berlantai dasar buatannya, yang mesin berputar menggunakan roda pendayung belakang. Lanchester membuat kapal berkasnya di taman rumahnya di Olton, Warwickshire. Perahu ini diluncurkan di tempat peluncuran Salter di Oxford pada tahun 1904, dan merupakan perahu motor pertama.', 450000, 'pic_1605618490_boat.jpg', '', '', '', '2020-11-17 13:05:00', '2020-11-17 13:08:00');

-- ----------------------------
-- Table structure for tbl_booking
-- ----------------------------
DROP TABLE IF EXISTS `tbl_booking`;
CREATE TABLE `tbl_booking`  (
  `kodebooking` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodepelanggan` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kodeboat` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `tanggalbooking` datetime(0) DEFAULT NULL,
  `keteranganbooking` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `statusbooking` int(1) DEFAULT NULL COMMENT '0 = pending, 1 = menunggu konfirmasi, 2 = valid',
  `dateaddbooking` datetime(0) DEFAULT NULL,
  `dateupdbooking` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`kodebooking`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_booking
-- ----------------------------
INSERT INTO `tbl_booking` VALUES ('BOOKING001', 'PEL001', 'BOAT003', 450000, '2021-01-07 00:00:00', 'ok', 2, '2021-01-03 03:56:00', '2021-01-03 03:56:00');

-- ----------------------------
-- Table structure for tbl_jenis
-- ----------------------------
DROP TABLE IF EXISTS `tbl_jenis`;
CREATE TABLE `tbl_jenis`  (
  `kodejenis` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `namajenis` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dateaddjenis` datetime(0) DEFAULT NULL,
  `dateupdjenis` datetime(0) DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_jenis
-- ----------------------------
INSERT INTO `tbl_jenis` VALUES ('JENIS001', 'Jukung Kayu', '2020-11-16 17:20:00', '2021-01-01 07:32:00');
INSERT INTO `tbl_jenis` VALUES ('JENIS002', 'Boat', '2020-11-16 17:27:00', '2020-12-19 10:06:00');

-- ----------------------------
-- Table structure for tbl_konfirmasi
-- ----------------------------
DROP TABLE IF EXISTS `tbl_konfirmasi`;
CREATE TABLE `tbl_konfirmasi`  (
  `kodekonfirmasi` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodebooking` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bank` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `an` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `norek` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gambarbukti` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggalkonfirmasi` date DEFAULT NULL,
  PRIMARY KEY (`kodekonfirmasi`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_konfirmasi
-- ----------------------------
INSERT INTO `tbl_konfirmasi` VALUES ('KONFIRMASI001', 'BOOKING001', 'BNI', 'Gde Suariana', '8884773889', 'pic_1609646214_powerstone4.jpeg', '2021-01-03');

-- ----------------------------
-- Table structure for tbl_owner
-- ----------------------------
DROP TABLE IF EXISTS `tbl_owner`;
CREATE TABLE `tbl_owner`  (
  `kodeowner` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namaowner` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `emailowner` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alamatowner` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `noteleponowner` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dateaddowner` datetime(0) DEFAULT NULL,
  `dateupdowner` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`kodeowner`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_owner
-- ----------------------------
INSERT INTO `tbl_owner` VALUES ('OWNER001', 'Ni Nyoman Chandra', 'chandradewi@gmail.com', 'Jalan Sanitasi Block C No 5', '086552663772', '2020-11-17 12:21:00', '2020-11-17 12:21:00');
INSERT INTO `tbl_owner` VALUES ('OWNER002', 'Iwan Styawan', 'curlylazy@gmail.com', 'Jalan Mertasari No 170B', '087663774883', '2020-11-17 12:22:00', '2020-11-17 12:22:00');

-- ----------------------------
-- Table structure for tbl_pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pelanggan`;
CREATE TABLE `tbl_pelanggan`  (
  `kodepelanggan` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `userpelanggan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `passwordpelanggan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `namapelanggan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `emailpelanggan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alamatpelanggan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `noteleponpelanggan` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dateaddpelanggan` datetime(0) DEFAULT NULL,
  `dateupdpelanggan` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`kodepelanggan`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_pelanggan
-- ----------------------------
INSERT INTO `tbl_pelanggan` VALUES ('PEL001', 'yana', 'eyJpdiI6IkZhYVpqdnY4MTNONFl6YWdqSE96RHc9PSIsInZhbHVlIjoiUDVyWUxqbDJvMVYwRUVIVE05WGp4dz09IiwibWFjIjoiMTYwNmNiZTM2OTYyMzYwMTdmYzE2YmI3MmU3YWE4MmY4NzFhYTcwMWNjZDRhYjAxNzI4MDc3MWU3ZDE5NDM1MiJ9', 'Suariyana Ketut', 'saputrastyawan.d@gmail.com', 'Jalan Batanghari GG Batubara No 90', '0882779392', '2020-11-17 13:45:00', '2020-11-17 14:05:00');
INSERT INTO `tbl_pelanggan` VALUES ('PEL002', 'asas', 'eyJpdiI6ImFxTDU0WFBJZ3VLRkRrRmRVOFJxeEE9PSIsInZhbHVlIjoiNXYrMWN2SUhnMndjNkJJU3dMMEtWUT09IiwibWFjIjoiYmFmMGJlMzY2YWEzODJlMmU4ZjcxYjE2NWM3ZWZlZWYzOTQxODU0N2EzZjI5NGRhNTRmMTc1NTgxMzE2NjdmMSJ9', 'asas', 'asas', 'asas', 'asas', '2020-11-18 17:02:00', '2020-11-18 17:02:00');
INSERT INTO `tbl_pelanggan` VALUES ('PEL003', 'asdasd', 'eyJpdiI6Ii92aWVOOXFOTDI3WDBlYzZFWVBod0E9PSIsInZhbHVlIjoiQ2Z1emdLbGJwOXFBSVRyMnMrdTBtZz09IiwibWFjIjoiMGQ5N2Y2M2Q2NzBmNDZiMzZjY2FhOTQxMGUzZWFkNzExNjA0NDEyMTFmMzVjY2JmMjZhZjQ4MTY0MzkxMjIyMiJ9', 'asdasd', 'asdasd', 'asdasd', 'asd', '2020-11-18 17:06:00', '2020-11-18 17:06:00');
INSERT INTO `tbl_pelanggan` VALUES ('PEL004', 'asdasdaaa', 'eyJpdiI6Ijl5OWZuSWo1LzJiSnFjNWZncktqcnc9PSIsInZhbHVlIjoiY25DVWdzbkVVU2duK0dhTm4zUnBhZz09IiwibWFjIjoiNTJlMjFiZDUwZDBmOWNlMjBhNTEwYjE2NmI5Y2U2N2UwZGE3MWEwMmU1YzI3MjMzZmI1NGQxMTllMTAzMmFhYSJ9', 'asdasd', 'asdasd', 'asdasd', 'asd', '2020-11-18 17:08:00', '2020-11-18 17:08:00');
INSERT INTO `tbl_pelanggan` VALUES ('PEL005', 'iwan', 'eyJpdiI6ImMvd2VjcFFPQTVrWDBaRUhlVVBENnc9PSIsInZhbHVlIjoiZ0RWVjJhQmw5QkN1bEVQbXpsRXFoZz09IiwibWFjIjoiN2M0OTE4NWVjNDg5MTEyMTA2ZmNkODU2MGQ1NTYyNGVmNWIwOWRiNTljYTkxYjQ3ZjJkZTk3MDExN2UwZThiZSJ9', 'Wayan Styawan Saputra', 'saputrastyawan.d@gmail.com', 'Jalan Kebudayaan No 167 BC', '0882779392', '2020-11-18 17:09:00', '2020-11-18 17:09:00');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `kodeuser` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `namauser` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `akses` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dateadduser` datetime(0) DEFAULT NULL,
  `dateupduser` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`kodeuser`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('USER001', 'admin', 'eyJpdiI6InpiaEplWThJbmxFYWEwMkgvQWttUGc9PSIsInZhbHVlIjoiNVhxTE9VVEswNTJFcDVWU2M2WG5JUT09IiwibWFjIjoiZmYyZTU0YWVjZmMxNGYwNTI2MDQxOGNmZTI0MGE1MmEzMTYyN2Y1ZTRjYzc0ODQ4NTg3MDUyYTcyOThhOTMyNCJ9', 'Admin Master', 'ADMIN', '2020-11-17 12:20:00', '2020-11-17 12:20:00');

SET FOREIGN_KEY_CHECKS = 1;
