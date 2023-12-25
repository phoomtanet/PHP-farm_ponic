<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

if (!isset($_SESSION['user'])) {
  header('Location: loginform.php');
  exit(); // ให้แน่ใจว่าไม่มีโค้ดเพิ่มเติมที่ทำงานหลัง header
}

$sql_plot = "SELECT *
FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_planting as e on a.id_plot = e.id_plot
LEFT JOIN tb_vegetable as f on f.id_vegetable = e.id_vegetable   
LEFT JOIN tb_fertilizationdate as g on e.id_planting = a.id_plot
WHERE d.user_name = '$user' AND c.name_farm = '$farm_name' AND b.name_greenhouse = '$greenhouse_name'
ORDER BY LENGTH(a.plot_name), a.plot_name";




$result_plot = mysqli_query($conn, $sql_plot);

$perpage = 10; // Set the number of items per page

if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1; // Default to page 1
}
$start = ($page - 1) * $perpage;

$total_records_query = "SELECT COUNT(*) as total_records 
FROM `tb_plot` as a 
LEFT JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
LEFT JOIN tb_farm as c on b.id_farm = c.id_farm 
LEFT JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_planting as e on e.id_plot = a.id_plot 
LEFT JOIN tb_vegetable as f on f.id_vegetable = e.id_vegetable 
WHERE b.name_greenhouse = '$greenhouse_name';";

$total_records_result = mysqli_query($conn, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['total_records'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $perpage);



?>
<!doctype html>


<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Bootstrap 5</title>


</head>
<style type="text/css">


</style>

<body style=" background: #e5e5e7;">
  <?php include '../navbar/navbar.php'; ?>
  <!-- เมนูด้านข้าง ( Side Menu ) -->
  <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
    <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
  </div>
  <!-- เนื้อหาหลัก -->

  <div class=" main-content-div  p-1 " style="  text-align: center;  height: 100%;">
    <!-- <img src="../img/hidro.jpg" alt="รูปผัก" style="max-width: 100%; height: auto;"> -->
    <div class="pt-5 main-content-div" style="text-align: center; align-items: center;  ">
      <div class="d-flex flex-nowrap justify-content-between text-center px-5  ">

        <div class="d-flex flex-nowrap justify-content-between text-center  ">
          <div>
            <button type="button" class="btn btn-primary">จัดการข้อมูลแปลงผัก</button>
          </div>
          <div class="mx-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_data_Modal">+ เพิ่มแปลง</button>
          </div>
        </div>
        <div>
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="../php/index.php?page=1 " aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
              <li class="page-item"><a class="page-link" href="../php/index.php?page=<?= $i ?>"><?= $i ?></a></li>
            <?php } ?>
            <li class="page-item">
              <a class="page-link" href="../php/index.php?page=<?= $total_pages ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </div>
      </div>


      <div class="d-inline-flex justify-content-center ">
        <div class="d-inline-flex justify-content-around flex-wrap ">
          <!-- <div class=" border p-3"> -->
          <?php foreach ($result_plot as $col) { ?>

            <?php if ($col['status'] == 0) { ?>
              <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&total_slots=<?php echo $col['row'] * $col['column']; ?>" style="text-decoration: none; color: #333;">

                
                <div class="m-2 border flex-column p-1  bg-secondary border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; ">    
                <div class="inline-flex border m-1 px-4 bg-white " style=" width: 220px; height: 160px; display: flex; justify-content: center; align-items: center;">

                    <table style="text-align: left;">
                      <tr>
                        <th scope="row">แปลง : </th>
                        <td>
                          <?php echo  ' ' . $col['plot_name']  ?></td>
                      </tr>
                      <tr>
                        <th scope="row">ชื่อผัก : </th>
                        <td> ว่าง </td>
                      </tr>
                      <tr>
                        <th scope="col">วันที่เพาะ : </th>
                        <td class="text-danger"> dd/mm/yy</td>
                      </tr>
                      <tr>
                        <th scope="row">เก็บเกี่ยว : </th>
                        <td class="text-danger"> -- </td>
                      </tr>
                      <tr>
                        <th scope="row">อายุผัก : </th>
                        <td class="text-danger"> -- </td>
                      </tr>
                      <tr>
                        <th scope="col">ข้อมูล : </th>
                        <td class="text-success"> <a href="">เพิ่มเติม</a> </td>
                      </tr>
                    </table>
                  </div>
                  <table class=" bg-white ">
                    <tr>
                      <td style="border-right: 1px solid #000"><img src="../img/emp.jpg" class="m-1 " style="width: 63px;   border-radius: 50px; "></td>
                      <td style="border-right: 1px solid #000"><img src="../img/emp.jpg" class="m-1 " style="width: 63px;   border-radius: 50px; "></td>
                      <td ><img src="../img/emp.jpg" class="m-1 " style="width: 63px;   border-radius: 50px; "></td>
                    </tr>
                  </table>
                </div>
              </a>
            <?php } ?>


            <?php if ($col['status'] == 1) {


              $planting_date = $col['planting_date']; // วันที่เพาะ
              $vegetable_age = $col['vegetable_age']; // อายุของผักในวัน

              $formattedDate = date('d M \ y', strtotime($planting_date));
              $next_harvest_date = calculateNextharvestDate($planting_date, $vegetable_age);
              $today = new DateTime(); // วันที่ปัจจุบัน

              $diff = $today->diff(new DateTime($planting_date));
              $daysSincePlanting = $diff->days;  //อายุผัก
              //ให้ปุ่ย
              $fertilizing_everyDays = $col['fertilizing_everyDays'];
              if (isset($col['fertilizationDate'])) {
                $fertilization_date_str = $col['fertilizationDate']; // วันที่ให้ปุ่ยล่าสุดในรูปแบบสตริง

                $fertilization_date = new DateTime($fertilization_date_str); // สร้าง DateTime จากสตริง

                $today = new DateTime(); // วันที่ปัจจุบัน

                $interval = $today->diff($fertilization_date);
                $days_difference = $interval->days;

                // แปลง DateTime เป็นสตริงในรูปแบบที่ต้องการ
                $fertilization_date_formatted = $fertilization_date->format('Y-m-d');

                // echo "วันที่ให้ปุ๋ยล่าสุด: {$fertilization_date_formatted}";
                // echo "ผ่านมาทั้งหมด {$days_difference} วัน";


              } else {
                $days_difference = 0;
              }
            ?>
              <?php

              if ($daysSincePlanting < $vegetable_age && $days_difference <  $fertilizing_everyDays) {
              ?>
                <div class="m-2 border flex-column p-1  bg-success border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; ">    
                
                
                
                <div class="inline-flex border m-1 px-4 bg-white" style=" width: 220px; height: 160px; display: flex; justify-content: center; align-items: center;">
                    <table style="text-align: left;">
                      <tr>
                        <th scope="row">แปลง : </th>
                        <td>
                          <?php echo  ' ' . $col['plot_name']  ?></td>

                      </tr>
                      <tr>
                        <th scope="row">ชื่อผัก : </th>
                        <td> <?php echo  ' ' . $col['vegetable_name']  ?></td>
                      </tr>
                      <tr>
                        <th scope="col">วันที่เพาะ : </th>
                        <td class="text-success"> <?php echo  ' ' . $formattedDate; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">เก็บเกี่ยว : </th>
                        <td class="text-primary"> <?php echo  ' ' .   $next_harvest_date; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">อายุผัก </th>
                        <td class="text-primary"> <?php echo  ' ' .     $daysSincePlanting . 'วัน'; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">ข้อมูล : </th>
                        <td class="text-success"> <a href="">เพิ่มเติม</a> </td>
                      </tr>
                    </table>

                  </div>

                  <table class=" bg-white"  >
                    <tr>
                      <td style="border-right: 1px solid #000;"><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;     border-radius: 50px; "></td>
                      <td style="border-right: 1px solid #000"><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;    border-radius: 50px; "></td>
                      <td ><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;    border-radius: 50px; "></td>
                    </tr>
                  </table>

                </div>
                <!-- เก็บเกี่ยว -->
              <?php } else if ($daysSincePlanting >= $vegetable_age && $days_difference <  $fertilizing_everyDays) { ?>

                <div class="m-2 border flex-column p-1  border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; background:  rgba(236, 180, 65, 0.8)">
                                   <div class="inline-flex border m-1 px-4 bg-white" style=" width: 220px; height: 160px; display: flex; justify-content: center; align-items: center;">

                    <table style="text-align: left;">
                      <tr>
                        <th scope="row">แปลง : </th>
                        <td>
                          <?php echo  ' ' . $col['plot_name']  ?></td>

                      </tr>
                      <tr>
                        <th scope="row">ชื่อผัก : </th>
                        <td> <?php echo  ' ' . $col['vegetable_name']  ?></td>
                      </tr>
                      <tr>
                        <th scope="col">วันที่เพาะ : </th>
                        <td class="text-success"> <?php echo  ' ' . $formattedDate; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">เก็บเกี่ยว : </th>
                        <td class="text-primary"> <?php echo  ' ' .   $next_harvest_date; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">อายุผัก </th>
                        <td class="text-primary"> <?php echo  ' ' .    $daysSincePlanting . 'วัน'; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">ข้อมูล : </th>
                        <td class="text-success"> <a href="">เพิ่มเติม</a> </td>
                      </tr>
                    </table>

                  </div>

                  <table class=" bg-white " >
                    <tr>
                      <td style="border-right: 1px solid #000;"><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;     border-radius: 50px; "></td>
                      <td style="border-right: 1px solid #000"><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;    border-radius: 50px; "></td>
                      <td ><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;    border-radius: 50px; "></td>

                    </tr>

                  </table>

                </div>
                <!-- ให้ปุ่ย -->
              <?php } else if ($days_difference >=  $fertilizing_everyDays) { ?>

                <div class="m-2 border flex-column p-1  border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; background: rgba(112, 169, 210, 0.8)">
                                   <div class="inline-flex border m-1 px-4 bg-white" style=" width: 220px; height: 160px; display: flex; justify-content: center; align-items: center;">

                    <table style="text-align: left;">
                      <tr>
                        <th scope="row">แปลง : </th>
                        <td>
                          <?php echo  ' ' . $col['plot_name']  ?></td>

                      </tr>
                      <tr>
                        <th scope="row">ชื่อผัก : </th>
                        <td> <?php echo  ' ' . $col['vegetable_name']  ?></td>
                      </tr>
                      <tr>
                        <th scope="col">วันที่เพาะ : </th>
                        <td class="text-success"> <?php echo  ' ' . $formattedDate; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">เก็บเกี่ยว : </th>
                        <td class="text-primary"> <?php echo  ' ' .   $next_harvest_date; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">อายุผัก </th>
                        <td class="text-primary"> <?php echo  ' ' .    $daysSincePlanting . 'วัน'; ?> </td>
                      </tr>
                      <tr>
                        <th scope="col">ข้อมูล : </th>
                        <td class="text-success"> <a href="">เพิ่มเติม</a> </td>
                      </tr>
                    </table>

                  </div>

                  <table class=" bg-white " >
                    <tr>
                      <td style="border-right: 1px solid #000;"><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;     border-radius: 50px; "></td>
                      <td style="border-right: 1px solid #000"><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;    border-radius: 50px; "></td>
                      <td ><img src="../img/<?php echo $col['img_name']  ?>" class="m-1 " style="width: 63px;    border-radius: 50px; "></td>
                    </tr>
                  </table>

                </div>


              <?php }    ?>
            <?php }    ?>
          <?php } ?>
        </div>
        <!-- </div> -->
      </div>

    </div>


    <script src="../navbar/navbar.js"></script>

    <?php
    function calculateNextharvestDate($planting_date, $vegetable_age)
    {
      // แปลงวันที่เพาะเป็นวัตถุ DateTime
      $plantingDateTime = new DateTime($planting_date);

      // คำนวณวันที่เก็บผักครั้งถัดไปโดยเพิ่มอายุของผักในวัน
      $harvestDateTime = clone $plantingDateTime;
      $harvestDateTime->modify("+$vegetable_age days");

      // คืนค่าวันที่เก็บผักในรูปแบบ d M y
      return $harvestDateTime->format('d M y');
    } ?>
</body>


<!-- ฟอร์ม เพิ่มแปลง -->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">เพิ่มแปลง</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <?php if (isset($_SESSION['error_user'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error_user'];
            unset($_SESSION['error_user']);
            ?>
          </div>
        <?php } ?>
        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="nameplot" id="username2" class="form-control" placeholder="ป้อนชื่อแปลง.." onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">แถว :</label>
          <input type="number" name="row" id="password2" class="form-control" placeholder="ป้อนตัวเลข'ด้านยาว' ...">
          <label style="text-align: left; display: block;">คอลัมน์:</label>
          <input type="number" name="columne" id="firstname" class="form-control" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
          <!-- Other form fields -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save" id="save1" class="btn btn-primary" value="ยืนยัน"></input>
      </div>
      </form>
    </div>
  </div>
</div>


<!--   การเก็บเกี่ยว 
<div class="modal fade" id="harvest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">บันทึกการเก็บเกี่ยว</h5>
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert/insert_harvest.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="nameplot" id="username2" class="form-control" placeholder="ป้อนชื่อแปลง.." onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">แถว :</label>
          <input type="number" name="row" id="password2" class="form-control" placeholder="ป้อนตัวเลข'ด้านยาว' ...">
          <label style="text-align: left; display: block;">คอลัมน์:</label>
          <input type="number" name="columne" id="firstname" class="form-control" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save" id="save1" class="btn btn-primary" value="ยืนยัน"></input>
      </div>
      </form>
    </div>
  </div>
</div> -->










</html>


