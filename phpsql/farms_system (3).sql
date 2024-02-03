-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 02:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fs_test4`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_farm`
--

CREATE TABLE `tb_farm` (
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_user` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผู้ใช้',
  `name_farm` varchar(100) NOT NULL COMMENT 'ชื่อฟาร์ม',
  `location` varchar(200) NOT NULL COMMENT 'ที่ตั้ง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_farm`
--

INSERT INTO `tb_farm` (`id_farm`, `id_user`, `name_farm`, `location`) VALUES
(1001, 0002, 'porponic farm', 'บ้านเกาะ'),
(1002, 0002, 'porponic newfarm', 'ิbbk\r\n'),
(1003, 0002, 'new', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fertilizationdate`
--

CREATE TABLE `tb_fertilizationdate` (
  `id_fertilizationDate` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสวันให้ปุ๋ย',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `fertilizationDate` date NOT NULL COMMENT 'วันที่ให้ปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_fertilizationdate`
--

INSERT INTO `tb_fertilizationdate` (`id_fertilizationDate`, `id_plot`, `fertilizationDate`) VALUES
(00073, 000014, '2024-01-18'),
(00074, 000015, '2024-01-18'),
(00075, 000016, '2024-01-18'),
(00077, 000018, '2024-01-18'),
(00078, 000019, '2024-01-18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fertilizer`
--

CREATE TABLE `tb_fertilizer` (
  `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสปุ๋ย',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `fertilizer_name` varchar(50) NOT NULL COMMENT 'ชื่อปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_fertilizer`
--

INSERT INTO `tb_fertilizer` (`id_fertilizer`, `id_farm`, `fertilizer_name`) VALUES
(111, 1001, 'AB');

-- --------------------------------------------------------

--
-- Table structure for table `tb_greenhouse`
--

CREATE TABLE `tb_greenhouse` (
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `name_greenhouse` varchar(50) NOT NULL COMMENT 'ชื่อฟาร์ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_greenhouse`
--

INSERT INTO `tb_greenhouse` (`id_greenhouse`, `id_farm`, `name_greenhouse`) VALUES
(00004, 1001, 'PG-1'),
(00005, 1001, 'PG-2'),
(00006, 1002, 'PGN-1'),
(00007, 1002, 'PGN-2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_harvest`
--

CREATE TABLE `tb_harvest` (
  `id_harvest` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสเก็บเกี่ยว',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก_ฟาร์ม',
  `harvestdate` date NOT NULL COMMENT 'วันที่เก็บเกี่ยว',
  `harvest_amount` int(4) NOT NULL COMMENT 'จำนวนผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_harvest`
--

INSERT INTO `tb_harvest` (`id_harvest`, `id_plot`, `id_veg_farm`, `harvestdate`, `harvest_amount`) VALUES
(00123, 000014, 002, '2023-11-15', 270),
(00124, 000014, 002, '2023-11-15', 270),
(00125, 000014, 001, '2023-11-15', 270),
(00126, 000014, 002, '2023-11-15', 270),
(00127, 000014, 003, '2023-11-15', 270),
(00128, 000014, 004, '2023-11-15', 270),
(00129, 000014, 004, '2023-11-15', 270),
(00130, 000014, 001, '2023-11-15', 270),
(00131, 000014, 002, '2023-11-15', 270),
(00132, 000014, 001, '2024-01-12', 270),
(00133, 000014, 001, '2024-01-12', 270),
(00134, 000014, 002, '2024-01-12', 240),
(00135, 000014, 003, '2024-01-12', 230),
(00136, 000014, 004, '2024-01-12', 270),
(00137, 000014, 001, '2024-01-12', 270),
(00138, 000014, 002, '2024-01-12', 220),
(00139, 000014, 003, '2024-01-12', 270),
(00140, 000014, 004, '2024-01-12', 250),
(00141, 000017, 004, '2024-01-15', 270);

-- --------------------------------------------------------

--
-- Table structure for table `tb_planting`
--

CREATE TABLE `tb_planting` (
  `id_planting` int(7) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการปลูก',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีแปลง',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก_ฟาร์ม',
  `vegetable_amount` int(4) NOT NULL COMMENT 'จำนวนผัก',
  `planting_date` date NOT NULL COMMENT 'วันที่ปลูก',
  `fertilizing_everyDays` int(2) NOT NULL COMMENT 'ลูปการให้ปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_planting`
--

INSERT INTO `tb_planting` (`id_planting`, `id_plot`, `id_veg_farm`, `vegetable_amount`, `planting_date`, `fertilizing_everyDays`) VALUES
(0000093, 000014, 001, 270, '2023-12-29', 3),
(0000094, 000015, 002, 100, '2024-01-12', 3),
(0000095, 000015, 001, 170, '2023-12-29', 3),
(0000096, 000016, 003, 100, '2023-12-24', 3),
(0000098, 000018, 004, 30, '2023-12-01', 3),
(0000099, 000019, 002, 100, '2023-12-10', 3),
(0000100, 000019, 001, 70, '2023-12-05', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_plot`
--

CREATE TABLE `tb_plot` (
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `plot_name` varchar(50) NOT NULL COMMENT 'ชื่อแปลง',
  `row` int(5) NOT NULL COMMENT 'จำนวนแถว',
  `column` varchar(5) NOT NULL COMMENT 'จำนวนคอลัมน์',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_plot`
--

INSERT INTO `tb_plot` (`id_plot`, `id_greenhouse`, `plot_name`, `row`, `column`, `status`) VALUES
(000014, 00004, 'P1-1', 9, '30 ', 1),
(000015, 00004, 'P1-2', 9, '30 ', 1),
(000016, 00004, 'P1-3', 9, '30 ', 1),
(000017, 00004, 'P1-4', 9, '30 ', 0),
(000018, 00004, 'P1-5', 9, '30 ', 1),
(000019, 00004, 'P1-6', 9, '30 ', 1),
(000020, 00004, 'P1-7', 9, '30 ', 0),
(000021, 00004, 'P1-8', 9, '30 ', 0),
(000022, 00004, 'P1-9', 9, '30 ', 0),
(000023, 00004, 'P1-10', 9, '30 ', 0),
(000024, 00004, 'P1-11', 9, '10 ', 0),
(000025, 00004, 'P1-12', 9, '10 ', 0),
(000026, 00005, 'P1-1', 9, '30 ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_plot_nursery`
--

CREATE TABLE `tb_plot_nursery` (
  `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลงอนุบาล',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `plotnursery_name` varchar(50) NOT NULL COMMENT 'ชื่อแปลงอนุบาล',
  `row` int(5) NOT NULL COMMENT 'จำนวนแถว',
  `column` int(5) NOT NULL COMMENT 'จำนวนคอลัมน์',
  `status_plot` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_plot_nursery`
--

INSERT INTO `tb_plot_nursery` (`id_plotnursery`, `id_greenhouse`, `plotnursery_name`, `row`, `column`, `status_plot`) VALUES
(00019, 00004, 'PN1-1', 100, 9, 0),
(00020, 00004, 'PN1-2', 9, 100, 0),
(00021, 00004, 'PN1-3', 9, 100, 0),
(00022, 00005, 'PNN-1', 100, 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_seed_germination`
--

CREATE TABLE `tb_seed_germination` (
  `id_seed_germination` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสอนุบาล',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก๘ฟาร์ม',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสขนาดเพาะ',
  `Amount_trays` int(5) NOT NULL COMMENT 'จำนวนถาดที่เพาะเมล็ด',
  `germination_amount` int(5) NOT NULL,
  `germination_date` date NOT NULL COMMENT 'วันที่เพาะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_seed_germination`
--

INSERT INTO `tb_seed_germination` (`id_seed_germination`, `id_veg_farm`, `id_greenhouse`, `id_traysize`, `Amount_trays`, `germination_amount`, `germination_date`) VALUES
(000023, 003, 00004, 002, 3, 700, '2024-01-12'),
(000024, 004, 00004, 002, 3, 800, '2024-01-12'),
(000025, 001, 00005, 002, 10, 4000, '2024-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_traysize`
--

CREATE TABLE `tb_traysize` (
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสขนาดอนุบาล',
  `size_name` varchar(50) NOT NULL COMMENT 'ชื่อไซต์',
  `row_tray` int(4) NOT NULL COMMENT 'แถวถาดเพาะ',
  `column_tray` int(4) NOT NULL COMMENT 'คอลัมน์ถาดเพาะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_traysize`
--

INSERT INTO `tb_traysize` (`id_farm`, `id_traysize`, `size_name`, `row_tray`, `column_tray`) VALUES
(1001, 002, '20*20', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผู้ใช้',
  `f_name` varchar(100) NOT NULL COMMENT 'ชื่อ',
  `l_name` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `user_name` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(50) NOT NULL COMMENT 'รหัสผ่าน',
  `photo_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `f_name`, `l_name`, `user_name`, `password`, `photo_name`) VALUES
(0002, 'ภูมิธเนศ', 'อินทุยง', 'pornam', 'pornam', 'photo_65a884c43415f.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_vegetable`
--

CREATE TABLE `tb_vegetable` (
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก',
  `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสปุ๋ย',
  `vegetable_name` varchar(50) NOT NULL COMMENT 'ชื่อผัก',
  `vegetable_age` int(3) NOT NULL COMMENT 'อายุผัก',
  `img_name` varchar(200) NOT NULL COMMENT 'ชื่อรูปผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_vegetable`
--

INSERT INTO `tb_vegetable` (`id_vegetable`, `id_fertilizer`, `vegetable_name`, `vegetable_age`, `img_name`) VALUES
(001, 111, 'green oak', 40, 'photo_65a88542a3a34.jpg'),
(002, 111, 'red oak', 40, 'photo_65a0d3dc5aea6.jpg'),
(003, 111, 'Butterhead', 40, 'photo_65a0d3f2b0add.jpg'),
(004, 111, 'Green Cos', 40, 'photo_65a0d409c73e2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_vegetableprice`
--

CREATE TABLE `tb_vegetableprice` (
  `id_vegetableprice` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสราคาผัก',
  `vegetablepricedate` date NOT NULL COMMENT 'ราคาผักวันที่',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก๘ฟาร์ม',
  `price` int(4) NOT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_vegetableprice`
--

INSERT INTO `tb_vegetableprice` (`id_vegetableprice`, `vegetablepricedate`, `id_veg_farm`, `price`) VALUES
(00004, '2024-01-18', 001, 120),
(00005, '2024-01-12', 002, 40),
(00006, '2024-01-12', 003, 100),
(00007, '2024-01-12', 004, 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_vegetableweight`
--

CREATE TABLE `tb_vegetableweight` (
  `id_vegetableweight` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสน้ำหนักผัก',
  `vegetableweightdate` date NOT NULL COMMENT 'วันที่บันทึกน้ำหนัก',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก๘ฟาร์ม',
  `amount_tree` int(3) NOT NULL COMMENT 'จำนวนต้น',
  `vegetableweight` int(5) NOT NULL COMMENT 'น้ำหนักผักทั้งหมด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_vegetableweight`
--

INSERT INTO `tb_vegetableweight` (`id_vegetableweight`, `vegetableweightdate`, `id_veg_farm`, `amount_tree`, `vegetableweight`) VALUES
(00004, '2024-01-18', 001, 10, 1000),
(00005, '2024-01-12', 002, 10, 1000),
(00006, '2024-01-12', 003, 10, 1000),
(00007, '2024-01-12', 004, 11, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_vegetable_nursery`
--

CREATE TABLE `tb_vegetable_nursery` (
  `id_nursery` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสอนุบาล',
  `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก_ฟาร์ม',
  `nursery_amount` int(4) NOT NULL COMMENT 'จำนวนผัก',
  `nursery_date` date NOT NULL COMMENT 'วันที่อนุบาล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_vegetable_nursery`
--

INSERT INTO `tb_vegetable_nursery` (`id_nursery`, `id_plotnursery`, `id_veg_farm`, `nursery_amount`, `nursery_date`) VALUES
(000037, 00019, 001, 390, '2023-12-05'),
(000038, 00020, 002, 800, '2023-12-10'),
(000039, 00021, 003, 400, '2024-01-07'),
(000043, 00019, 002, 200, '2024-01-12'),
(000044, 00020, 004, 100, '2024-01-12'),
(000045, 00022, 001, 1200, '2024-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_veg_farm`
--

CREATE TABLE `tb_veg_farm` (
  `id_veg_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก_farm',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_veg_farm`
--

INSERT INTO `tb_veg_farm` (`id_veg_farm`, `id_farm`, `id_vegetable`) VALUES
(0001, 1001, 001),
(0002, 1001, 002),
(0003, 1001, 003),
(0004, 1001, 004);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_farm`
--
ALTER TABLE `tb_farm`
  ADD PRIMARY KEY (`id_farm`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_fertilizationdate`
--
ALTER TABLE `tb_fertilizationdate`
  ADD PRIMARY KEY (`id_fertilizationDate`),
  ADD KEY `id_plot` (`id_plot`);

--
-- Indexes for table `tb_fertilizer`
--
ALTER TABLE `tb_fertilizer`
  ADD PRIMARY KEY (`id_fertilizer`),
  ADD KEY `id_farm` (`id_farm`);

--
-- Indexes for table `tb_greenhouse`
--
ALTER TABLE `tb_greenhouse`
  ADD PRIMARY KEY (`id_greenhouse`),
  ADD KEY `id_farm` (`id_farm`);

--
-- Indexes for table `tb_harvest`
--
ALTER TABLE `tb_harvest`
  ADD PRIMARY KEY (`id_harvest`),
  ADD KEY `id_plot` (`id_plot`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);

--
-- Indexes for table `tb_planting`
--
ALTER TABLE `tb_planting`
  ADD PRIMARY KEY (`id_planting`),
  ADD KEY `id_plot` (`id_plot`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);

--
-- Indexes for table `tb_plot`
--
ALTER TABLE `tb_plot`
  ADD PRIMARY KEY (`id_plot`),
  ADD KEY `id_greenhouse` (`id_greenhouse`);

--
-- Indexes for table `tb_plot_nursery`
--
ALTER TABLE `tb_plot_nursery`
  ADD PRIMARY KEY (`id_plotnursery`),
  ADD KEY `id_greenhouse` (`id_greenhouse`);

--
-- Indexes for table `tb_seed_germination`
--
ALTER TABLE `tb_seed_germination`
  ADD PRIMARY KEY (`id_seed_germination`),
  ADD KEY `id_greenhouse` (`id_greenhouse`),
  ADD KEY `id_veg_farm` (`id_veg_farm`),
  ADD KEY `id_traysize` (`id_traysize`);

--
-- Indexes for table `tb_traysize`
--
ALTER TABLE `tb_traysize`
  ADD PRIMARY KEY (`id_traysize`),
  ADD KEY `id_farm` (`id_farm`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_vegetable`
--
ALTER TABLE `tb_vegetable`
  ADD PRIMARY KEY (`id_vegetable`),
  ADD KEY `id_fertilizer` (`id_fertilizer`);

--
-- Indexes for table `tb_vegetableprice`
--
ALTER TABLE `tb_vegetableprice`
  ADD PRIMARY KEY (`id_vegetableprice`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);

--
-- Indexes for table `tb_vegetableweight`
--
ALTER TABLE `tb_vegetableweight`
  ADD PRIMARY KEY (`id_vegetableweight`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);

--
-- Indexes for table `tb_vegetable_nursery`
--
ALTER TABLE `tb_vegetable_nursery`
  ADD PRIMARY KEY (`id_nursery`),
  ADD KEY `id_plotnursery` (`id_plotnursery`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);

--
-- Indexes for table `tb_veg_farm`
--
ALTER TABLE `tb_veg_farm`
  ADD PRIMARY KEY (`id_veg_farm`),
  ADD KEY `id_farm` (`id_farm`),
  ADD KEY `id_vegetable` (`id_vegetable`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_farm`
--
ALTER TABLE `tb_farm`
  MODIFY `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสฟาร์ม', AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `tb_fertilizationdate`
--
ALTER TABLE `tb_fertilizationdate`
  MODIFY `id_fertilizationDate` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสวันให้ปุ๋ย', AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tb_fertilizer`
--
ALTER TABLE `tb_fertilizer`
  MODIFY `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสปุ๋ย', AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `tb_greenhouse`
--
ALTER TABLE `tb_greenhouse`
  MODIFY `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสโรงเรือน', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_harvest`
--
ALTER TABLE `tb_harvest`
  MODIFY `id_harvest` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสเก็บเกี่ยว', AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tb_planting`
--
ALTER TABLE `tb_planting`
  MODIFY `id_planting` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการปลูก', AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tb_plot`
--
ALTER TABLE `tb_plot`
  MODIFY `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสแปลง', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_plot_nursery`
--
ALTER TABLE `tb_plot_nursery`
  MODIFY `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสแปลงอนุบาล', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_seed_germination`
--
ALTER TABLE `tb_seed_germination`
  MODIFY `id_seed_germination` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสอนุบาล', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_traysize`
--
ALTER TABLE `tb_traysize`
  MODIFY `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสขนาดอนุบาล', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_vegetable`
--
ALTER TABLE `tb_vegetable`
  MODIFY `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผัก', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_vegetableprice`
--
ALTER TABLE `tb_vegetableprice`
  MODIFY `id_vegetableprice` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสราคาผัก', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_vegetableweight`
--
ALTER TABLE `tb_vegetableweight`
  MODIFY `id_vegetableweight` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสน้ำหนักผัก', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_vegetable_nursery`
--
ALTER TABLE `tb_vegetable_nursery`
  MODIFY `id_nursery` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสอนุบาล', AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tb_veg_farm`
--
ALTER TABLE `tb_veg_farm`
  MODIFY `id_veg_farm` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผัก_farm', AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_farm`
--
ALTER TABLE `tb_farm`
  ADD CONSTRAINT `farm_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`);

--
-- Constraints for table `tb_fertilizationdate`
--
ALTER TABLE `tb_fertilizationdate`
  ADD CONSTRAINT `fertilizationDate_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`);

--
-- Constraints for table `tb_fertilizer`
--
ALTER TABLE `tb_fertilizer`
  ADD CONSTRAINT `tb_fertilizer1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

--
-- Constraints for table `tb_greenhouse`
--
ALTER TABLE `tb_greenhouse`
  ADD CONSTRAINT `greenhouse_1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

--
-- Constraints for table `tb_harvest`
--
ALTER TABLE `tb_harvest`
  ADD CONSTRAINT `harvest_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`),
  ADD CONSTRAINT `harvest_2` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);

--
-- Constraints for table `tb_planting`
--
ALTER TABLE `tb_planting`
  ADD CONSTRAINT `tb_planting_ibfk_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`),
  ADD CONSTRAINT `tb_planting_ibfk_2` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);

--
-- Constraints for table `tb_plot`
--
ALTER TABLE `tb_plot`
  ADD CONSTRAINT `plot_1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`);

--
-- Constraints for table `tb_plot_nursery`
--
ALTER TABLE `tb_plot_nursery`
  ADD CONSTRAINT `plot_nursery1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`);

--
-- Constraints for table `tb_seed_germination`
--
ALTER TABLE `tb_seed_germination`
  ADD CONSTRAINT `tb_germination_1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`),
  ADD CONSTRAINT `tb_germination_2` FOREIGN KEY (`id_traysize`) REFERENCES `tb_traysize` (`id_traysize`),
  ADD CONSTRAINT `tb_germination_3` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);

--
-- Constraints for table `tb_traysize`
--
ALTER TABLE `tb_traysize`
  ADD CONSTRAINT `tb_traysize1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

--
-- Constraints for table `tb_vegetable`
--
ALTER TABLE `tb_vegetable`
  ADD CONSTRAINT `vegetable_1` FOREIGN KEY (`id_fertilizer`) REFERENCES `tb_fertilizer` (`id_fertilizer`);

--
-- Constraints for table `tb_vegetableprice`
--
ALTER TABLE `tb_vegetableprice`
  ADD CONSTRAINT `vegetableprice_1` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);

--
-- Constraints for table `tb_vegetableweight`
--
ALTER TABLE `tb_vegetableweight`
  ADD CONSTRAINT `vegetableweight_1` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);

--
-- Constraints for table `tb_vegetable_nursery`
--
ALTER TABLE `tb_vegetable_nursery`
  ADD CONSTRAINT `tb_Vegetable_nursery_ibfk_1` FOREIGN KEY (`id_plotnursery`) REFERENCES `tb_plot_nursery` (`id_plotnursery`),
  ADD CONSTRAINT `tb_Vegetable_nursery_ibfk_2` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);

--
-- Constraints for table `tb_veg_farm`
--
ALTER TABLE `tb_veg_farm`
  ADD CONSTRAINT `farm_vegetable_1` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`),
  ADD CONSTRAINT `farm_vegetable_2` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
