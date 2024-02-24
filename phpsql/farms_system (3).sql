

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `tb_farm` (
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_user` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผู้ใช้',
  `name_farm` varchar(100) NOT NULL COMMENT 'ชื่อฟาร์ม',
  `location` varchar(200) NOT NULL COMMENT 'ที่ตั้ง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_farm` (`id_farm`, `id_user`, `name_farm`, `location`) VALUES
(1000, 0001, 'F_demo1', 'surin'),
(1001, 0001, 'F_demo2', 'surin');



CREATE TABLE `tb_fertilizationdate` (
  `id_fertilizationDate` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสวันให้ปุ๋ย',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `fertilizationDate` date NOT NULL COMMENT 'วันที่ให้ปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `tb_fertilizationdate` (`id_fertilizationDate`, `id_plot`, `fertilizationDate`) VALUES
(00002, 000003, '2024-02-21'),
(00003, 000007, '2024-02-24'),
(00007, 000002, '2024-02-24'),
(00008, 000004, '2024-02-24'),
(00009, 000005, '2024-02-24');



CREATE TABLE `tb_fertilizer` (
  `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสปุ๋ย',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `fertilizer_name` varchar(50) NOT NULL COMMENT 'ชื่อปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `tb_fertilizer` (`id_fertilizer`, `id_farm`, `fertilizer_name`) VALUES
(100, 1000, 'AB'),
(101, 1000, 'ABC'),
(102, 1001, 'AB'),
(103, 1000, 'ABD'),
(104, 1001, 'ABD');



CREATE TABLE `tb_greenhouse` (
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `name_greenhouse` varchar(50) NOT NULL COMMENT 'ชื่อฟาร์ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_greenhouse` (`id_greenhouse`, `id_farm`, `name_greenhouse`) VALUES
(00001, 1000, 'G_demo1'),
(00002, 1000, 'G_demo2'),
(00003, 1000, 'G_demo3'),
(00004, 1001, 'G_demo2'),
(00005, 1001, 'G_demo1');



CREATE TABLE `tb_harvest` (
  `id_harvest` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสเก็บเกี่ยว',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก_ฟาร์ม',
  `harvestdate` date NOT NULL COMMENT 'วันที่เก็บเกี่ยว',
  `harvest_amount` int(4) NOT NULL COMMENT 'จำนวนผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_harvest` (`id_harvest`, `id_plot`, `id_veg_farm`, `harvestdate`, `harvest_amount`) VALUES
(00001, 000002, 001, '2024-02-23', 270);


CREATE TABLE `tb_planting` (
  `id_planting` int(7) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการปลูก',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีแปลง',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก_ฟาร์ม',
  `vegetable_amount` int(4) NOT NULL COMMENT 'จำนวนผัก',
  `planting_date` date NOT NULL COMMENT 'วันที่ปลูก',
  `fertilizing_everyDays` int(2) NOT NULL COMMENT 'ลูปการให้ปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tb_planting` (`id_planting`, `id_plot`, `id_veg_farm`, `vegetable_amount`, `planting_date`, `fertilizing_everyDays`) VALUES
(0000002, 000003, 001, 100, '2024-01-10', 3),
(0000003, 000003, 001, 100, '2024-02-23', 3),
(0000004, 000003, 001, 70, '2024-02-23', 3),
(0000005, 000007, 001, 270, '2024-02-23', 3),
(0000009, 000002, 001, 270, '2024-02-23', 3),
(0000010, 000004, 001, 70, '2024-02-23', 3),
(0000012, 000005, 001, 110, '2024-02-23', 3),
(0000013, 000005, 001, 100, '2024-02-23', 3),
(0000014, 000004, 003, 200, '2024-02-23', 3);


CREATE TABLE `tb_plot` (
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสปุ๋ย',
  `plot_name` varchar(50) NOT NULL COMMENT 'ชื่อแปลง',
  `row` int(5) NOT NULL COMMENT 'จำนวนแถว',
  `column` int(5) NOT NULL COMMENT 'จำนวนคอลัมน์',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `tb_plot` (`id_plot`, `id_greenhouse`, `id_fertilizer`, `plot_name`, `row`, `column`, `status`) VALUES
(000002, 00001, 101, 'P1', 30, 9, 1),
(000003, 00001, 100, 'P2', 30, 9, 1),
(000004, 00001, 101, 'P3', 9, 30, 1),
(000005, 00001, 100, 'P4', 30, 9, 1),
(000006, 00001, 100, 'P5', 9, 30, 0),
(000007, 00002, 100, 'P1', 9, 30, 1),
(000008, 00002, 101, 'P2', 30, 9, 0),
(000009, 00001, 100, 'P6', 30, 9, 0),
(000010, 00004, 102, 'P1', 9, 30, 0),
(000012, 00001, 100, 'P7', 9, 30, 0),
(000013, 00001, 100, 'P8', 100, 30, 0);



CREATE TABLE `tb_plot_nursery` (
  `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลงอนุบาล',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `plotnursery_name` varchar(50) NOT NULL COMMENT 'ชื่อแปลงอนุบาล',
  `row` int(5) NOT NULL COMMENT 'จำนวนแถว',
  `column` int(5) NOT NULL COMMENT 'จำนวนคอลัมน์',
  `status_plot` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_plot_nursery` (`id_plotnursery`, `id_greenhouse`, `plotnursery_name`, `row`, `column`, `status_plot`) VALUES
(00001, 00001, 'N1', 100, 30, 0),
(00002, 00001, 'N2', 100, 30, 0),
(00003, 00002, 'N1-1', 100, 30, 0),
(00004, 00001, 'N3', 10, 100, 0),
(00005, 00004, 'N1', 9, 30, 0);



CREATE TABLE `tb_seed_germination` (
  `id_seed_germination` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสอนุบาล',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก๘ฟาร์ม',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสขนาดเพาะ',
  `Amount_trays` int(5) NOT NULL COMMENT 'จำนวนถาดที่เพาะเมล็ด',
  `germination_amount` int(5) NOT NULL,
  `germination_date` date NOT NULL COMMENT 'วันที่เพาะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_seed_germination` (`id_seed_germination`, `id_veg_farm`, `id_greenhouse`, `id_traysize`, `Amount_trays`, `germination_amount`, `germination_date`) VALUES
(000004, 004, 00001, 001, 5, 1000, '2024-02-23'),
(000005, 008, 00002, 002, 2, 288, '2024-02-24'),
(000006, 008, 00002, 002, 2, 288, '2024-02-24'),
(000008, 007, 00002, 002, 10, 1440, '2024-02-24'),
(000009, 007, 00002, 002, 5, 720, '2024-02-24'),
(000010, 008, 00004, 002, 2, 288, '2024-02-24'),
(000011, 007, 00004, 002, 10, 1440, '2024-02-24'),
(000013, 004, 00001, 001, 2, 400, '2024-02-24');



CREATE TABLE `tb_traysize` (
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสขนาดอนุบาล',
  `size_name` varchar(50) NOT NULL COMMENT 'ชื่อไซต์',
  `row_tray` int(4) NOT NULL COMMENT 'แถวถาดเพาะ',
  `column_tray` int(4) NOT NULL COMMENT 'คอลัมน์ถาดเพาะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_traysize` (`id_farm`, `id_traysize`, `size_name`, `row_tray`, `column_tray`) VALUES
(1000, 001, '20x20', 20, 20),
(1001, 002, '12*12', 12, 12),
(1000, 003, '12x12', 12, 12),
(1000, 005, '5x5', 5, 5);


CREATE TABLE `tb_user` (
  `id_user` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผู้ใช้',
  `f_name` varchar(100) NOT NULL COMMENT 'ชื่อ',
  `l_name` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `user_name` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(50) NOT NULL COMMENT 'รหัสผ่าน',
  `photo_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `tb_user` (`id_user`, `f_name`, `l_name`, `user_name`, `password`, `photo_name`) VALUES
(0001, 'Phoomtanet', 'Intayung', 'prosche', 'prosche', 'photo_65d8b2648ba68.jpg');



CREATE TABLE `tb_vegetable` (
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก',
  `vegetable_name` varchar(50) NOT NULL COMMENT 'ชื่อผัก',
  `vegetable_age` int(3) NOT NULL COMMENT 'อายุผัก',
  `img_name` varchar(200) NOT NULL COMMENT 'ชื่อรูปผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_vegetable` (`id_vegetable`, `vegetable_name`, `vegetable_age`, `img_name`) VALUES
(001, 'green oak', 40, 'photo_65d8d44466e97.jpg'),
(003, 'betterhead', 40, 'photo_65d8d420492b9.jpg'),
(004, 'cos', 40, 'photo_65d8d2216ed48.jpg'),
(007, 'green oak', 40, 'photo_65d9f254bd29d.jpg'),
(008, 'red oak', 40, 'photo_65d9f2958a4f7.jpg');



CREATE TABLE `tb_vegetableprice` (
  `id_vegetableprice` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสราคาผัก',
  `vegetablepricedate` date NOT NULL COMMENT 'ราคาผักวันที่',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก๘ฟาร์ม',
  `price` int(4) NOT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `tb_vegetableprice` (`id_vegetableprice`, `vegetablepricedate`, `id_veg_farm`, `price`) VALUES
(00001, '2024-02-24', 001, 100),
(00003, '2024-02-24', 003, 100),
(00004, '0000-00-00', 004, 100),
(00007, '2024-02-24', 007, 100),
(00008, '2024-02-24', 008, 100);



CREATE TABLE `tb_vegetableweight` (
  `id_vegetableweight` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสน้ำหนักผัก',
  `vegetableweightdate` date NOT NULL COMMENT 'วันที่บันทึกน้ำหนัก',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก๘ฟาร์ม',
  `amount_tree` int(3) NOT NULL COMMENT 'จำนวนต้น',
  `vegetableweight` int(5) NOT NULL COMMENT 'น้ำหนักผักทั้งหมด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `tb_vegetableweight` (`id_vegetableweight`, `vegetableweightdate`, `id_veg_farm`, `amount_tree`, `vegetableweight`) VALUES
(00001, '2024-02-24', 001, 13, 1200),
(00003, '2024-02-24', 003, 10, 1120),
(00004, '0000-00-00', 004, 100, 1000),
(00007, '2024-02-24', 007, 10, 1000),
(00008, '2024-02-24', 008, 12, 12305);



CREATE TABLE `tb_vegetable_nursery` (
  `id_nursery` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสอนุบาล',
  `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_veg_farm` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก_ฟาร์ม',
  `nursery_amount` int(4) NOT NULL COMMENT 'จำนวนผัก',
  `nursery_date` date NOT NULL COMMENT 'วันที่อนุบาล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `tb_vegetable_nursery` (`id_nursery`, `id_plotnursery`, `id_veg_farm`, `nursery_amount`, `nursery_date`) VALUES
(000002, 00001, 003, 600, '2024-02-23'),
(000004, 00002, 004, 100, '2024-02-23'),
(000005, 00002, 001, 200, '2024-02-23'),
(000006, 00003, 001, 2730, '2024-02-23'),
(000007, 00002, 001, 700, '2024-02-23'),
(000008, 00001, 004, 1280, '2024-02-23');



CREATE TABLE `tb_veg_farm` (
  `id_veg_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก_farm',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `tb_veg_farm` (`id_veg_farm`, `id_farm`, `id_vegetable`) VALUES
(0001, 1000, 001),
(0003, 1000, 003),
(0004, 1000, 004),
(0007, 1001, 007),
(0008, 1001, 008);


ALTER TABLE `tb_farm`
  ADD PRIMARY KEY (`id_farm`),
  ADD KEY `id_user` (`id_user`);


ALTER TABLE `tb_fertilizationdate`
  ADD PRIMARY KEY (`id_fertilizationDate`),
  ADD KEY `id_plot` (`id_plot`);


ALTER TABLE `tb_fertilizer`
  ADD PRIMARY KEY (`id_fertilizer`),
  ADD KEY `id_farm` (`id_farm`);


ALTER TABLE `tb_greenhouse`
  ADD PRIMARY KEY (`id_greenhouse`),
  ADD KEY `id_farm` (`id_farm`);

ALTER TABLE `tb_harvest`
  ADD PRIMARY KEY (`id_harvest`),
  ADD KEY `id_plot` (`id_plot`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_planting`
  ADD PRIMARY KEY (`id_planting`),
  ADD KEY `id_plot` (`id_plot`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_plot`
  ADD PRIMARY KEY (`id_plot`),
  ADD KEY `id_greenhouse` (`id_greenhouse`),
  ADD KEY `id_fertilizer` (`id_fertilizer`);


ALTER TABLE `tb_plot_nursery`
  ADD PRIMARY KEY (`id_plotnursery`),
  ADD KEY `id_greenhouse` (`id_greenhouse`);


ALTER TABLE `tb_seed_germination`
  ADD PRIMARY KEY (`id_seed_germination`),
  ADD KEY `id_greenhouse` (`id_greenhouse`),
  ADD KEY `id_veg_farm` (`id_veg_farm`),
  ADD KEY `id_traysize` (`id_traysize`);


ALTER TABLE `tb_traysize`
  ADD PRIMARY KEY (`id_traysize`),
  ADD KEY `id_farm` (`id_farm`);


ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `tb_vegetable`
  ADD PRIMARY KEY (`id_vegetable`);


ALTER TABLE `tb_vegetableprice`
  ADD PRIMARY KEY (`id_vegetableprice`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_vegetableweight`
  ADD PRIMARY KEY (`id_vegetableweight`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_vegetable_nursery`
  ADD PRIMARY KEY (`id_nursery`),
  ADD KEY `id_plotnursery` (`id_plotnursery`),
  ADD KEY `id_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_veg_farm`
  ADD PRIMARY KEY (`id_veg_farm`),
  ADD KEY `id_farm` (`id_farm`),
  ADD KEY `id_vegetable` (`id_vegetable`);




ALTER TABLE `tb_farm`
  MODIFY `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสฟาร์ม', AUTO_INCREMENT=1002;

ALTER TABLE `tb_fertilizationdate`
  MODIFY `id_fertilizationDate` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสวันให้ปุ๋ย', AUTO_INCREMENT=10;


ALTER TABLE `tb_fertilizer`
  MODIFY `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสปุ๋ย', AUTO_INCREMENT=105;


ALTER TABLE `tb_greenhouse`
  MODIFY `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสโรงเรือน', AUTO_INCREMENT=6;


ALTER TABLE `tb_harvest`
  MODIFY `id_harvest` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสเก็บเกี่ยว', AUTO_INCREMENT=2;


ALTER TABLE `tb_planting`
  MODIFY `id_planting` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการปลูก', AUTO_INCREMENT=15;


ALTER TABLE `tb_plot`
  MODIFY `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสแปลง', AUTO_INCREMENT=14;


ALTER TABLE `tb_plot_nursery`
  MODIFY `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสแปลงอนุบาล', AUTO_INCREMENT=6;


ALTER TABLE `tb_seed_germination`
  MODIFY `id_seed_germination` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสอนุบาล', AUTO_INCREMENT=14;


ALTER TABLE `tb_traysize`
  MODIFY `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสขนาดอนุบาล', AUTO_INCREMENT=6;


ALTER TABLE `tb_user`
  MODIFY `id_user` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้', AUTO_INCREMENT=2;


ALTER TABLE `tb_vegetable`
  MODIFY `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผัก', AUTO_INCREMENT=13;


ALTER TABLE `tb_vegetableprice`
  MODIFY `id_vegetableprice` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสราคาผัก', AUTO_INCREMENT=13;


ALTER TABLE `tb_vegetableweight`
  MODIFY `id_vegetableweight` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสน้ำหนักผัก', AUTO_INCREMENT=13;


ALTER TABLE `tb_vegetable_nursery`
  MODIFY `id_nursery` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสอนุบาล', AUTO_INCREMENT=9;


ALTER TABLE `tb_veg_farm`
  MODIFY `id_veg_farm` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผัก_farm', AUTO_INCREMENT=13;


ALTER TABLE `tb_farm`
  ADD CONSTRAINT `farm_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`);


ALTER TABLE `tb_fertilizationdate`
  ADD CONSTRAINT `fertilizationDate_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`);


ALTER TABLE `tb_fertilizer`
  ADD CONSTRAINT `tb_fertilizer1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);



ALTER TABLE `tb_greenhouse`
  ADD CONSTRAINT `greenhouse_1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);


ALTER TABLE `tb_harvest`
  ADD CONSTRAINT `harvest_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`),
  ADD CONSTRAINT `harvest_2` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_planting`
  ADD CONSTRAINT `tb_planting_ibfk_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`),
  ADD CONSTRAINT `tb_planting_ibfk_2` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_plot`
  ADD CONSTRAINT `plot_fer1` FOREIGN KEY (`id_fertilizer`) REFERENCES `tb_fertilizer` (`id_fertilizer`),
  ADD CONSTRAINT `plot_green` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`);


ALTER TABLE `tb_plot_nursery`
  ADD CONSTRAINT `plot_nursery1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`);


ALTER TABLE `tb_seed_germination`
  ADD CONSTRAINT `tb_germination_1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`),
  ADD CONSTRAINT `tb_germination_2` FOREIGN KEY (`id_traysize`) REFERENCES `tb_traysize` (`id_traysize`),
  ADD CONSTRAINT `tb_germination_3` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_traysize`
  ADD CONSTRAINT `tb_traysize1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);


ALTER TABLE `tb_vegetableprice`
  ADD CONSTRAINT `vegetableprice_1` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_vegetableweight`
  ADD CONSTRAINT `vegetableweight_1` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_vegetable_nursery`
  ADD CONSTRAINT `tb_Vegetable_nursery_ibfk_1` FOREIGN KEY (`id_plotnursery`) REFERENCES `tb_plot_nursery` (`id_plotnursery`),
  ADD CONSTRAINT `tb_Vegetable_nursery_ibfk_2` FOREIGN KEY (`id_veg_farm`) REFERENCES `tb_veg_farm` (`id_veg_farm`);


ALTER TABLE `tb_veg_farm`
  ADD CONSTRAINT `farm_vegetable_1` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`),
  ADD CONSTRAINT `farm_vegetable_2` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);
COMMIT;

