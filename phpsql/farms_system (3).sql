
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `tb_farm` (
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_user` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผู้ใช้',
  `name_farm` varchar(100) NOT NULL COMMENT 'ชื่อฟาร์ม',
  `location` varchar(200) NOT NULL COMMENT 'ที่ตั้ง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `tb_fertilizationdate` (
  `id_fertilizationDate` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสวันให้ปุ๋ย',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `fertilizationDate` date NOT NULL COMMENT 'วันที่ให้ปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE `tb_fertilizer` (
  `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสปุ๋ย',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `fertilizer_name` varchar(50) NOT NULL COMMENT 'ชื่อปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




CREATE TABLE `tb_greenhouse` (
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `name_greenhouse` varchar(50) NOT NULL COMMENT 'ชื่อฟาร์ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE `tb_harvest` (
  `id_harvest` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสเก็บเกี่ยว',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก',
  `harvestdate` date NOT NULL COMMENT 'วันที่เก็บเกี่ยว',
  `vegetable_amount` int(4) NOT NULL COMMENT 'จำนวนผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE `tb_planting` (
  `id_planting` int(7) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการปลูก',
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีแปลง',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก',
  `vegetable_amount` int(4) NOT NULL COMMENT 'จำนวนผัก',
  `planting_date` date NOT NULL COMMENT 'วันที่ปลูก',
  `fertilizing_everyDays` int(2) NOT NULL COMMENT 'ลูปการให้ปุ๋ย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `tb_plot` (
  `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `plot_name` varchar(50) NOT NULL COMMENT 'ชื่อแปลง',
  `row` int(5) NOT NULL COMMENT 'จำนวนแถว',
  `column` varchar(5) NOT NULL COMMENT 'จำนวนคอลัมน์',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `tb_plot_nursery` (
  `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลงอนุบาล',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `plotnursery_name` varchar(50) NOT NULL COMMENT 'ชื่อแปลงอนุบาล',
  `row` int(5) NOT NULL COMMENT 'จำนวนแถว',
  `column` int(5) NOT NULL COMMENT 'จำนวนคอลัมน์',
  `status_plot` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `tb_seed_germination` (
  `id_seed_germination` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสอนุบาล',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก',
  `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโรงเรือน',
  `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสขนาดเพาะ',
  `Amount_trays` int(5) NOT NULL COMMENT 'จำนวนถาดที่เพาะเมล็ด',
  `germination_amount` int(5) NOT NULL,
  `germination_date` date NOT NULL COMMENT 'วันที่เพาะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `tb_traysize` (
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสขนาดอนุบาล',
  `size_name` varchar(50) NOT NULL COMMENT 'ชื่อไซต์',
  `row_tray` int(4) NOT NULL COMMENT 'แถวถาดเพาะ',
  `column_tray` int(4) NOT NULL COMMENT 'คอลัมน์ถาดเพาะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `tb_user` (
  `id_user` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผู้ใช้',
  `f_name` varchar(100) NOT NULL COMMENT 'ชื่อ',
  `l_name` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `user_name` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(50) NOT NULL COMMENT 'รหัสผ่าน',
  `photo_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




CREATE TABLE `tb_vegetable` (
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก',
  `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสปุ๋ย',
  `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสฟาร์ม',
  `vegetable_name` varchar(50) NOT NULL COMMENT 'ชื่อผัก',
  `vegetable_age` int(3) NOT NULL COMMENT 'อายุผัก',
  `img_name` varchar(200) NOT NULL COMMENT 'ชื่อรูปผัก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;





CREATE TABLE `tb_vegetableprice` (
  `id_vegetableprice` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสราคาผัก',
  `vegetablepricedate` date NOT NULL COMMENT 'ราคาผักวันที่',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก',
  `price` int(4) NOT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




CREATE TABLE `tb_vegetableweight` (
  `id_vegetableweight` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสน้ำหนักผัก',
  `vegetableweightdate` date NOT NULL COMMENT 'วันที่บันทึกน้ำหนัก',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสผัก',
  `amount_tree` int(3) NOT NULL COMMENT 'จำนวนต้น',
  `vegetableweight` int(5) NOT NULL COMMENT 'น้ำหนักผักทั้งหมด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `tb_vegetable_nursery` (
  `id_nursery` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสอนุบาล',
  `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสแปลง',
  `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ไอดีผัก',
  `nursery_amount` int(4) NOT NULL COMMENT 'จำนวนผัก',
  `nursery_date` date NOT NULL COMMENT 'วันที่อนุบาล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  ADD KEY `id_vegetable` (`id_vegetable`);

ALTER TABLE `tb_planting`
  ADD PRIMARY KEY (`id_planting`),
  ADD KEY `id_plot` (`id_plot`),
  ADD KEY `id_vegetable` (`id_vegetable`);

ALTER TABLE `tb_plot`
  ADD PRIMARY KEY (`id_plot`),
  ADD KEY `id_greenhouse` (`id_greenhouse`);

ALTER TABLE `tb_plot_nursery`
  ADD PRIMARY KEY (`id_plotnursery`),
  ADD KEY `id_greenhouse` (`id_greenhouse`);

ALTER TABLE `tb_seed_germination`
  ADD PRIMARY KEY (`id_seed_germination`),
  ADD KEY `id_greenhouse` (`id_greenhouse`),
  ADD KEY `id_vegetable` (`id_vegetable`),
  ADD KEY `id_traysize` (`id_traysize`);

ALTER TABLE `tb_traysize`
  ADD PRIMARY KEY (`id_traysize`),
  ADD KEY `id_farm` (`id_farm`);

ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `tb_vegetable`
  ADD PRIMARY KEY (`id_vegetable`),
  ADD KEY `id_fertilizer` (`id_fertilizer`),
  ADD KEY `id_farm` (`id_farm`);

ALTER TABLE `tb_vegetableprice`
  ADD PRIMARY KEY (`id_vegetableprice`,`vegetablepricedate`),
  ADD KEY `id_vegetable` (`id_vegetable`);

ALTER TABLE `tb_vegetableweight`
  ADD PRIMARY KEY (`id_vegetableweight`,`vegetableweightdate`),
  ADD KEY `id_vegetable` (`id_vegetable`);

ALTER TABLE `tb_vegetable_nursery`
  ADD PRIMARY KEY (`id_nursery`),
  ADD KEY `id_plotnursery` (`id_plotnursery`),
  ADD KEY `id_vegetable` (`id_vegetable`);

ALTER TABLE `tb_farm`
  MODIFY `id_farm` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสฟาร์ม', AUTO_INCREMENT=1001;

ALTER TABLE `tb_fertilizationdate`
  MODIFY `id_fertilizationDate` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสวันให้ปุ๋ย', AUTO_INCREMENT=73;

ALTER TABLE `tb_fertilizer`
  MODIFY `id_fertilizer` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสปุ๋ย', AUTO_INCREMENT=111;

ALTER TABLE `tb_greenhouse`
  MODIFY `id_greenhouse` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสโรงเรือน', AUTO_INCREMENT=4;

ALTER TABLE `tb_harvest`
  MODIFY `id_harvest` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสเก็บเกี่ยว', AUTO_INCREMENT=123;

ALTER TABLE `tb_planting`
  MODIFY `id_planting` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการปลูก', AUTO_INCREMENT=93;

ALTER TABLE `tb_plot`
  MODIFY `id_plot` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสแปลง', AUTO_INCREMENT=14;

ALTER TABLE `tb_plot_nursery`
  MODIFY `id_plotnursery` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสแปลงอนุบาล', AUTO_INCREMENT=19;

ALTER TABLE `tb_seed_germination`
  MODIFY `id_seed_germination` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสอนุบาล', AUTO_INCREMENT=20;

ALTER TABLE `tb_traysize`
  MODIFY `id_traysize` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสขนาดอนุบาล', AUTO_INCREMENT=2;

ALTER TABLE `tb_user`
  MODIFY `id_user` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้', AUTO_INCREMENT=2;

ALTER TABLE `tb_vegetable`
  MODIFY `id_vegetable` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสผัก', AUTO_INCREMENT=112;

ALTER TABLE `tb_vegetableprice`
  MODIFY `id_vegetableprice` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสราคาผัก', AUTO_INCREMENT=4;

ALTER TABLE `tb_vegetableweight`
  MODIFY `id_vegetableweight` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสน้ำหนักผัก', AUTO_INCREMENT=4;

ALTER TABLE `tb_vegetable_nursery`
  MODIFY `id_nursery` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสอนุบาล', AUTO_INCREMENT=37;


ALTER TABLE `tb_farm`
  ADD CONSTRAINT `farm_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`);

ALTER TABLE `tb_fertilizationdate`
  ADD CONSTRAINT `fertilizationDate_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`);

ALTER TABLE `tb_fertilizer`
  ADD CONSTRAINT `tb_fertilizer1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

ALTER TABLE `tb_traysize`
  ADD CONSTRAINT `tb_traysize1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

ALTER TABLE `tb_greenhouse`
  ADD CONSTRAINT `greenhouse_1` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

ALTER TABLE `tb_harvest`
  ADD CONSTRAINT `harvest_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`),
  ADD CONSTRAINT `harvest_2` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`);

ALTER TABLE `tb_planting`
  ADD CONSTRAINT `tb_planting_ibfk_1` FOREIGN KEY (`id_plot`) REFERENCES `tb_plot` (`id_plot`),
  ADD CONSTRAINT `tb_planting_ibfk_2` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`);

ALTER TABLE `tb_plot`
  ADD CONSTRAINT `plot_1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`);

ALTER TABLE `tb_plot_nursery`
  ADD CONSTRAINT `plot_nursery1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`);

ALTER TABLE `tb_seed_germination`
  ADD CONSTRAINT `tb_germination_1` FOREIGN KEY (`id_greenhouse`) REFERENCES `tb_greenhouse` (`id_greenhouse`),
  ADD CONSTRAINT `tb_germination_2` FOREIGN KEY (`id_traysize`) REFERENCES `tb_traysize` (`id_traysize`),
  ADD CONSTRAINT `tb_germination_3` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`);

ALTER TABLE `tb_vegetable`
  ADD CONSTRAINT `vegetable_1` FOREIGN KEY (`id_fertilizer`) REFERENCES `tb_fertilizer` (`id_fertilizer`),
  ADD CONSTRAINT `vegetable_2` FOREIGN KEY (`id_farm`) REFERENCES `tb_farm` (`id_farm`);

ALTER TABLE `tb_vegetableprice`
  ADD CONSTRAINT `vegetableprice_1` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`);

ALTER TABLE `tb_vegetableweight`
  ADD CONSTRAINT `vegetableweight_1` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`);

ALTER TABLE `tb_vegetable_nursery`
  ADD CONSTRAINT `tb_Vegetable_nursery_ibfk_1` FOREIGN KEY (`id_plotnursery`) REFERENCES `tb_plot_nursery` (`id_plotnursery`),
  ADD CONSTRAINT `tb_Vegetable_nursery_ibfk_2` FOREIGN KEY (`id_vegetable`) REFERENCES `tb_vegetable` (`id_vegetable`);
COMMIT;

