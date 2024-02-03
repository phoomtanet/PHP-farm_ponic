<?php
include '../php/conn.php';
$sql = "SELECT * FROM tb_vegetable AS d INNER JOIN tb_fertilizer AS c  ON  d.id_fertilizer  = c.id_fertilizer ";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- เรียกใช้ ฺBootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bootstrap 5</title>
  </head>

  <body>
  <?php include '../navbar/navbar.php'; ?>
    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
      <ul class="nav nav-pills flex-column mb-auto pt-5 side_nav_menu"></ul>
    </div>
    <!-- เนื้อหาหลัก -->
    <div class="pt-5 main-content-div" style=" text-align: center;">
    
    <div class="container" style="margin-top: 20px;">
<table class="table table-striped table-bordered">
    <caption class="caption-top">ตารางแสดงข้อมูลผัก</caption>
  
  
    <thead>
                <th style="border: none;"  >
                <a href="index.php?">กลับ</a>
                </th>
                <th style="border: none;"></th>
                <th style="border: none;"></th>
                <th style="border: none;"></th>
                <th style="border: none;"></th>
              
                <th style="border: none;">
                <a href="AddVegettable.php">เพิ่มข้อมูล</a>
                </th>
                </thead>


    <thead class="table-dark">
        <tr>
            <th>รหัสผัก</th>
            <th>ชื่อผัก</th>
            <th>ปุ๋ยที่ใช้</th>
            <th>อายุผัก</th>
            <th>ลบข้อมูล</th>
            <th>แก้ไขข้อมูล</th>
        </tr>
    </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?= $row["id_vegetable"] ?></td>
                    <td><?= $row["vegetable_name"] ?></td>
                    <td><?= $row["fertilizer_name"] ?></td>
                    <td><?= $row["vegetable_age"] ?></td>
               
                    
                    <td style="border: none;">
                    <a href="#" >ลบ</a>
                    </td>
                    <td style="border: none;">
                    <a href="#" >แก้ไข</a>
                    </td>
                </tr>
            <?php
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
    </div>
    <script src="../navbar/navbar.js"></script>
  </body>
</html>















