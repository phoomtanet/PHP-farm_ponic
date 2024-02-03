<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";



$sql_plot = "SELECT *
FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
WHERE d.user_name = '$user' AND c.name_farm = '$farm_name' AND b.name_greenhouse = '$greenhouse_name'
ORDER BY LENGTH(a.plot_name), a.plot_name";
$result_plot = mysqli_query($conn, $sql_plot);


$perpage = 10; // Set the number of items per page

if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
$start = ($page - 1) * $perpage;

$total_records_query = "SELECT COUNT(*) as total_records 
FROM `tb_plot` as a 
LEFT JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
LEFT JOIN tb_farm as c on b.id_farm = c.id_farm 
LEFT JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_planting as e on e.id_plot = a.id_plot 
LEFT JOIN tb_veg_farm as vf on vf.id_veg_farm = e.id_veg_farm   

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
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

          <div class="mx-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_plot" title="เพิ่มแปลงปลูก">
              <i class="fas fa-plus"> </i>
              <i class="fas fa-inbox"> </i>

            </button>
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
          <?php foreach ($result_plot as $col) {
            $sql_vegetable_amount = "SELECT SUM(vegetable_amount) AS total_vegetable_amount FROM tb_planting WHERE id_plot = " . $col['id_plot'];
            $result = $conn->query($sql_vegetable_amount);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $total_vegetable_amount = $row['total_vegetable_amount'];
            }
          ?>

            <?php if ($col['status'] == 0) { ?>

              <div class="m-2 border flex-column p-1  bg-secondary border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; ">
                <div class="inline-flex border m-1 px-4 bg-white " style="width: 240px; height: 190px; display: flex; justify-content: center; align-items: start;">
                  <table style="text-align: left;">
                    <tr>
                      <th scope="row">แปลง : </th>
                      <td>
                        <b> <?php echo  ' '  . $col['plot_name']  ?></b>
                      </td>
                    </tr>
                    <tr style="text-align: center;">
                      <th scope="row">ช่องว่าง: </th>
                      <td>
                        <b class="text-danger"> <?php echo  ' ' . $col['row'] * $col['column'] - $total_vegetable_amount;   ?>
                      </td></b>
                    </tr>
         <td  style="padding-top:100px; "> </td>
                    <tr>
                      <td scope="col">
                      <i class=" edit_plot btn fas fa-edit text-warning  " style='font-size:20px' data-bs-toggle="modal" data-bs-target="#edit_plot" title="แก้ไขแปลงปลูก" 
                       data-edit_plot_name="<?= $col['plot_name'] ?>"    data-edit_plot_col="<?= $col['column'] ?>"  data-edit_plot_row="<?= $col['row'] ?>" data-id_edit_plot="<?= $col['id_plot'] ?>"> </i>

                      </td>
                      <td scope="col">
                      <a class="btn fa-regular fa-trash-alt text-danger " style='font-size:20px'  href="../phpsql/insert_plot.php?id_plot_del=<?= $col['id_plot'] ?>"onclick="Del(this.href);return false;"> </a>

                      </td>
                    </tr>
                  </table>
                </div>
                <table class=" bg-white ">
                  <tr>

                    <td style="border-right: 1px solid #000">
                      <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">

                        <img src="../img/emp.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                    </td>
                    </a>
                    <td style="border-right: 1px solid #000">
                      <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">

                        <img src="../img/emp.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; "> </a>
                    </td>
                    <td>
                      <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">

                        <img src="../img/emp.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; "> </a>
                    </td>
                  </tr>
                </table>
              </div>
              </a>
            <?php } ?>
            <?php if ($col['status'] == 1) {
              $escapedPlotName = mysqli_real_escape_string($conn, $col['plot_name']); // Escape the value to prevent SQL injection
              $sql_plan = "SELECT *FROM `tb_plot` as a 
        INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
        INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
        INNER JOIN tb_user as d on c.id_user = d.id_user 
        LEFT JOIN tb_planting as e on a.id_plot = e.id_plot
        LEFT JOIN tb_veg_farm as vf on vf.id_veg_farm = e.id_veg_farm   
        LEFT JOIN tb_vegetable  as v on v.id_vegetable  = vf.id_vegetable    
        LEFT JOIN tb_fertilizationdate as g on   g.id_plot = e.id_plot
        WHERE b.id_greenhouse = '$id_greenhouse_session' AND a.plot_name = '$escapedPlotName'
        GROUP BY e.id_planting";
              $result_plan = mysqli_query($conn, $sql_plan);
            ?>
              <?php

              foreach ($result_plan as $row) {
                $fertilizing_everyDays = $row['fertilizing_everyDays'];
                if (isset($row['fertilizationDate'])) {
                  $fertilization_date_str = $row['fertilizationDate']; // วันที่ให้ปุ่ยล่าสุดในรูปแบบสตริง
                  $fertilization_date = new DateTime($fertilization_date_str); // สร้าง DateTime จากสตริง

                  $today = new DateTime(); // วันที่ปัจจุบัน
                  $interval = $today->diff($fertilization_date);
                  $days_difference = $interval->days; // วันที่ผ่านมา จากวันให้ปุ๋ยล่าสุด
                  $fertilization_date_formatted = $fertilization_date->format('Y-m-d'); //วันที่ให้ปุ๋ยล่าสุด
                  //  echo "วันที่ให้ปุ๋ยล่าสุด: {$fertilization_date_formatted}";
                  //  echo "ผ่านมาทั้งหมด {$days_difference} วัน";
                } else {
                  $days_difference = 0;
                }
              }
              ?>
              <?php if ($days_difference >= $fertilizing_everyDays) {   ?>
                <div data-bs-toggle="modal" data-bs-target="#add_fertilizer" data-id_fertilizationDate="<?= $row["id_fertilizationDate"] ?>" data-plot_name2="<?= $col["plot_name"] ?>" class="add_fertilizer  m-2 border flex-column p-1  border border-3 border-dark Small shadow d-flex justify-content-center align-items-center " style="border-radius: 5px; background-color: #049ced; ">

                <?php  } else { ?>
                  <div class="m-2 border flex-column p-1 bg-success border border-3 border-dark Small shadow d-flex justify-content-center align-items-center" style="border-radius: 5px; ">


                  <?php  } ?>

                  <div class="inline-flex border m-1 px-4 bg-white" style=" width: 245px; height: 190px; display: flex; justify-content: center; align-items: start;">
                    <table style="text-align: left;">
                      <tr style="text-align: center;">
                        <th scope="row">แปลง :<?php echo  ' ' . $col['plot_name']  ?> </th>
                        <td>
                          <b> </b>
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td style="text-align: center;"><small> (ชื่อผัก / อายุ / จำนวนผัก) </small> </td>
                      </tr>
                      <td>
                        <?php
                        $count = 1;
                        foreach ($result_plan as $row) {
                          $nurseryDate = new DateTime($row['planting_date']);
                          $currentDate = new DateTime(); // วันที่ปัจจุบัน
                          $diff = $nurseryDate->diff($currentDate);
                          $age = $diff->format('%a');
                        ?>
                          <tr class="border-bottom">
                            <td colspan="3"><?php echo '<b>' . $count . ". " . $row['vegetable_name'] .  '</b> / ' . $age . ' / '  . $row['vegetable_amount']  ?></td>
                          </tr>
                        <?php
                          $count++;
                        }  ?>
                        <tr>
                          <?php if ($col['row'] * $col['column'] - $total_vegetable_amount > 0) { ?>
                            <td style="text-align: center;">
                              <b>ช่องว่าง: <span class="text-danger"> <?php echo    '' . $col['row'] * $col['column'] - $total_vegetable_amount  ?></b></span>
                            </td>
                          <?php  } else { ?>
                            <th style="text-align: center;">
                              ช่องว่าง: <span class="text-success "> <b>เต็ม</b></span>
                            </th>
                          <?php   } ?>
                        </tr>
                        <tr>
                          <th style="text-align: center;" scope="col">ข้อมูล :
                            <span class="text-success"> <a href="../php/information_plot.php?id_plot_data=<?= $col['id_plot'] ?>&plot_name=<?= $col['plot_name'] ?>">เพิ่มเติม</a></span>
                          </th>

                        </tr>
                    </table>
                  </div>
                  <table class="bg-white">
                    <tr>
                      <?php
                      $rowCount = 0;
                      foreach ($result_plan as $row1) {
                        $rowCount++;
                      }
                      if (!empty($result_plan)) {
                        foreach ($result_plan as $row1) {
                          if ($rowCount > 0) {
                            $nurseryDate1 = new DateTime($row1['planting_date']);
                            $currentDate1 = new DateTime();
                            $diff1 = $nurseryDate1->diff($currentDate1);
                            $age1 = $diff1->format('%a');

                            if ($row1['vegetable_age'] <=   $age1) {
                      ?>
                              <!-- เก็บเกี่ยว -->
                              <td data-bs-toggle="modal" data-bs-target="#add_harvest" data-vegetable_amount="<?= $row1["vegetable_amount"] ?>" data-vegetable_name="<?= $row1["vegetable_name"] ?>" data-plot_name="<?= $row1["plot_name"] ?>" data-id_plot="<?= $row1["id_plot"] ?>" data-id_vegetable="<?= $row1["id_veg_farm"] ?>" data-id_plan="<?= $row1["id_planting"] ?>" class="bg-warning  add-harvest" style="border-right: 1px solid #000;">
                                <img src="../img/<?php echo $row1['img_name']  ?>" class="m-1 " style="width: 70px;     border-radius: 50px; ">
                              </td>
                            <?php       } else { ?>
                              <td style="border-right: 1px solid #000;"><img src="../img/<?php echo $row1['img_name']  ?>" class="m-1 " style="width: 70px;     border-radius: 50px; "></td>

                      <?php   }
                          }
                        }
                      } else {
                        // ไม่มีข้อมูลใน $result_plan ดังนั้นคุณสามารถเพิ่มโค้ดที่คุณต้องการแสดงเมื่อไม่มีข้อมูลที่นี่
                        echo "ไม่มีข้อมูล";
                      }
                      ?>
                      <?php if ($rowCount == 1 &&  $col['row'] * $col['column'] - $total_vegetable_amount > 0) {  ?>
                        <td style="border-right: 1px solid #000">
                          <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">
                            <img src="../img/emp.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                          </a>
                        </td>
                        <td>
                          <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">

                            <img src="../img/emp.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                          </a>
                        </td>
                      <?php } else if ($rowCount == 1) { ?>
                        <td style="border-right: 1px solid #000">
                          <img src="../img/full.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                        </td>
                        <td>
                          <img src="../img/full.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                        </td>
                      <?php } ?>
                      <?php
                      if ($rowCount == 2 &&  $col['row'] * $col['column'] - $total_vegetable_amount > 0) {  ?>
                        <td>
                          <a href="../php/move_planting.php?plot_name=<?php echo $col['plot_name']; ?>&id_plot=<?php echo $col['id_plot']; ?>&total_slots=<?php echo $col['row'] * $col['column'] - $total_vegetable_amount; ?>" style="text-decoration: none; color: #333;">

                            <img src="../img/emp.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                          </a>
                        </td>
                      <?php } else if ($rowCount == 2) { ?>
                        <td style="border-right: 1px solid #000">
                          <img src="../img/full.jpg" class="m-1 " style="width: 70px;   border-radius: 50px; ">
                        </td>
                      <?php } ?>
                    </tr>
                  </table>
                  </div>
                <?php } ?>
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
<div class="modal fade" id="add_plot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">เพิ่มแปลง</h5>
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="nameplot"   class="form-control" placeholder="ป้อนชื่อแปลง.." onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">แถว(ด้านยาว) :</label>
          <input type="number" name="row" class="form-control" placeholder="ป้อนตัวเลข'ด้านยาว' ...">
          <label style="text-align: left; display: block;">คอลัมน์(ด้านกว้าง) :</label>
          <input type="number" name="columne" class="form-control" placeholder="ป้อนตัวเลข'ด้านกว้าง' ..." required>
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
<!-- ฟอร์ม แก้ไชแปลง -->

<div class="modal fade" id="edit_plot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">แก้ไขแปลง</h5>
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
        <input hidden type="text" name="id_edit_plot" id="id_edit_plot" class="form-control">
     
        <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="edit_nameplot" id="edit_nameplot" class="form-control" onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">แถว(ด้านยาว) :</label>
          <input type="number" name="edit_row" id="edit_row" class="form-control"  required>
          <label style="text-align: left; display: block;">คอลัมน์(ด้านกว้าง) :</label>
          <input type="number" name="edit_col" id="edit_col" class="form-control"  required>
          <!-- Other form fields -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="editplot"  class="btn btn-primary" value="ยืนยัน"></input>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- ฟอร์ม เก็บเกี่ยว -->
<div class="modal fade" id="add_harvest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">บันทึกการเก็บเกี่ยว</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_harvest.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <input type="hidden" name="id_plot_harvest" id="id_plot_harvest" class="form-control" required readonly>
          <input type="hidden" name="id_veg" id="id_veg" class="form-control" required readonly>
          <input type="hidden" name="id_planting" id="id_planting" class="form-control" required readonly>

          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="plot_harvest" id="plot_harvest" class="form-control" placeholder="ป้อนชื่อแปลง.." readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">ชื่อผัก :</label>
          <input type="text" name="veg_harvest" id="veg_harvest" class="form-control" placeholder="ป้อนตัวเลข'ด้านยาว' ..." readonly>

          <label style="text-align: left; display: block;">จำนวนผักที่ปลูก:</label>
          <input type="number" name="veg_planting_amont" id="veg_planting_amont" class="form-control" required readonly>

          <label id="label_num_harvest" style="text-align: left; display: block;">จำนวนผักที่เก็บเกี่ยว:</label>
          <input type="number" name="harvest_amount" id="harvest_amount" class="form-control" required oninput="checkValue()">
          <label style="text-align: left; display: block;">วันที่เก็บเกี่ยว:</label>
          <input type="date" name="harvest_date" id="harvest_date" class="form-control" required placeholder="วันที่เพาะเมล็ด" max="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save_harvest" id="save_harvest" class="btn btn-primary" value="ยืนยัน"></input>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- ให้ปุ๋ย -->
<div class="modal fade" id="add_fertilizer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">บันทึกการให้ปุ๋ย</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_harvest.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <input type="hidden" name="id_fertilizationDate" id="id_fertilizationDate" class="form-control" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="plot_fertilization" id="plot_fertilization" class="form-control" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">วันที่ให้ปุ๋ย:</label>
          <input type="date" name="fertilizationdate" id="fertilizationdate" class="form-control" required placeholder="วันที่เพาะเมล็ด" max="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="edit_fertilizationdate" id="edit_fertilizationdate" class="btn btn-primary" value="ยืนยัน"></input>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  //วันที่ปัจจุบันในช่อง input
  let today = new Date().toISOString().slice(0, 10);
  let germinationDateInput = document.getElementById("harvest_date");
  germinationDateInput.value = today;
  let fertilizationdateInput = document.getElementById("fertilizationdate");
  fertilizationdate.value = today;
  // รีเฟรชหน้า
  function cancelAndReload() {
    window.location.reload();
  }
</script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.edit_plot');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {

        const data_edit_plot_name = button.getAttribute('data-edit_plot_name');
        const edit_plot_name = document.getElementById('edit_nameplot');
        edit_plot_name.value = data_edit_plot_name;

        const data_edit_plot_row = button.getAttribute('data-edit_plot_row');
        const edit_plot_row = document.getElementById('edit_row');
        edit_plot_row.value = data_edit_plot_row;

        
        const data_edit_plot_col = button.getAttribute('data-edit_plot_col');
        const edit_plot_col = document.getElementById('edit_col');
        edit_plot_col.value = data_edit_plot_col;

        const data_id_edit_plot = button.getAttribute('data-id_edit_plot');
        const id_edit_plot = document.getElementById('id_edit_plot');
        id_edit_plot.value = data_id_edit_plot;




      });
    });
  });


  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.add_fertilizer');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {

        const data_plot_name2 = button.getAttribute('data-plot_name2');
        const plot_name2 = document.getElementById('plot_fertilization');
        plot_name2.value = data_plot_name2;

        const data_id_fertilizationDate = button.getAttribute('data-id_fertilizationDate');
        const id_fertilizationDate = document.getElementById('id_fertilizationDate');
        id_fertilizationDate.value = data_id_fertilizationDate;
      });
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.add-harvest');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        const data_plot_name = button.getAttribute('data-plot_name');
        const plot_nameField = document.getElementById('plot_harvest');
        plot_nameField.value = data_plot_name;

        const data_vegetable_name = button.getAttribute('data-vegetable_name');
        const vegetable_nameField = document.getElementById('veg_harvest');
        vegetable_nameField.value = data_vegetable_name;


        const data_vegetable_amount = button.getAttribute('data-vegetable_amount');
        const vegetable_amountField = document.getElementById('harvest_amount');
        vegetable_amountField.value = data_vegetable_amount;

        const data_planting_amount = button.getAttribute('data-vegetable_amount');
        const data_planting_amountField = document.getElementById('veg_planting_amont');
        data_planting_amountField.value = data_planting_amount;


        const data_id_plot = button.getAttribute('data-id_plot');
        const id_plotField = document.getElementById('id_plot_harvest');
        id_plotField.value = data_id_plot;

        const data_id_vegetable = button.getAttribute('data-id_vegetable');
        const id_vegetableield = document.getElementById('id_veg');
        id_vegetableield.value = data_id_vegetable;


        const data_id_plan = button.getAttribute('data-id_plan');
        const id_plan = document.getElementById('id_planting');
        id_plan.value = data_id_plan;
      });
    });
  });
</script>
<script>
  function checkValue() {


    var label = document.getElementById('label_num_harvest');
    var veg_planting_amont = parseInt(document.getElementById('veg_planting_amont').value);
    var num_harvest_amount = parseInt(document.getElementById('harvest_amount').value);

    if (veg_planting_amont < num_harvest_amount) {
      label.innerHTML = '<label class="text-danger" style="text-align: left; display: block;">จำนวนผักที่เก็บเกี่ยว มากกว่าที่ปลูก!!</label>';
      document.getElementById('save_harvest').style.display = 'none';
      if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default form submission
      }

    } else {
      label.innerHTML = '<label style="text-align: left; display: block;">จำนวนผักที่เก็บเกี่ยว:</label>';
      document.getElementById('save_harvest').style.display = 'block';

    }

  }

  function Del(mypage) {
        var agree = confirm("ข้อมูลประวัติการเก็บเกี่ยวของแปลงจะถูกลบไปด้วย คุณต้องการลบข้อมูลหรือไม่");
        if (agree) {
            window.location = mypage;
        }
    }
</script>

</html>