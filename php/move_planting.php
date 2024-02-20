<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';


$sql = "SELECT *
FROM `tb_plot_nursery` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
 LEFT JOIN tb_vegetable_nursery as e on a.id_plotnursery = e.id_plotnursery 
LEFT JOIN tb_veg_farm as vf on vf.id_veg_farm = e.id_veg_farm   

LEFT JOIN tb_vegetable as f on f.id_vegetable = vf.id_vegetable   
WHERE d.user_name = '$user' AND c.name_farm = '$farm_name' 
ORDER BY LENGTH(a.plotnursery_name) ,b.name_greenhouse , a.plotnursery_name ";

$result_plot__nursery = mysqli_query($conn, $sql);


$namePlot = $_GET['plot_name'];
$idPlot = $_GET['id_plot'];
$total_slots = $_GET['total_slots'];


// echo $namePlot ;
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


  <!-- เมนูด้านข้าง ( Side Menu ) -->
  <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
    <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
  </div>
  <!-- เนื้อหาหลัก -->
  <div class=" main-content-div" style=" text-align: center;">





    <div class="container" style="margin-top: 20px;">
      <table class="table table-hover table-bordered ">
     
      <caption class="caption-top">ย้ายการอนุบาลไปยังแปลง <?php echo "$namePlot" ?></caption>

      <thead>

                    <th style="border: none;">
                        <a href="index.php">กลับ</a>
                    </th>
                <th style="border: none;">

                <th style="border: none;">
                <th style="border: none;">
                <th style="border: none;">
                <th style="border: none;">

                    <th style="border: none;">
                    <th style="border: none;">  </th>
              
                </thead>

        <thead class="table-dark">
          <tr>

            <th>ชื่อแปลงอนุบาล</th>
            <th colspan="2">ผักอนุบาล</th>
            <th>วันที่เพาะ</th>
            <th>อายุผัก</th>
            <th>จำนวนการเพาะ</th>
            <th>โรงเรือน</th>
            <th>ย้าย</th>



          </tr>
        </thead>

        <tbody>
          <?php
          $currentPlotName = null;
          foreach ($result_plot__nursery as $col) {

            // เช็คว่าชื่อแปลงเปลี่ยนแปลงหรือยัง
            if ($col['plotnursery_name'] !== $currentPlotName) {

              for ($j = 0; $j < 2; $j++) {
              echo '<tr style="border: none;>';
              for ($i = 0; $i < 8; $i++) {
                echo '<th style="border: none;" ></th>';
              }
              echo ' </tr>';
            }
              // แสดงชื่อแปลงใหม่
              $currentPlotName = $col['plotnursery_name'];
              echo '<tr class="table-light"" >';
              echo '<td >                               
                                <a " style="text-decoration: none; color: black;">
                                <i class="fa fa-plus">   <b> '   . $currentPlotName . '</b></i> 
                         
                                </a>       
                                </td>';
              if ($col['img_name']) {
                echo '<td ><img src="../img/' . $col['img_name'] . '" style="width: 40px; border-radius: 50px;"></td>';

                echo '<td>' . $col['vegetable_name'] . '</td>';
                echo '<td>' . $col['nursery_date'] . '</td>';

                $nurseryDate = new DateTime($col['nursery_date']);
                $currentDate = new DateTime(); // วันที่ปัจจุบัน
                $diff = $nurseryDate->diff($currentDate);
                $age = $diff->format('%a'); // คำนวณอายุเป็นจำนวนวัน


                echo '<td>' . $age . ' วัน</td>';

                echo '<td>' . $col['nursery_amount'] . '</td>';
                echo '<td>' . $col['name_greenhouse'] . '</td>';

                echo '<td >
                                <button type="button" class="btn btn-primary move-button" 
                                data-bs-toggle="modal" data-bs-target="#add_data_Modal" 
                                data-nursery-amount="' . $col["nursery_amount"] . '" data-id-nursery="' . $col["id_nursery"] . '" 
                                data-id-vegetable="' . $col["id_veg_farm"] . '"  data-name-vegetable="' . $col["vegetable_name"] . '" data-date="' . $col["nursery_date"] . '"  >
                                ย้าย</button>
                                </td>';
              } else {
                echo '<td  colspan="7" >ไม่การอนุบาล</th>';


                echo '</tr>';
              }

              echo '</tr>';
            } else {
              echo '<tr class="table-light"">';
              echo '<td></td>';
              echo '<td><img src="../img/' . $col['img_name'] . '" style="width: 40px; border-radius: 50px;"></td>';

              echo '<td>' . $col['vegetable_name'] . '</td>';
              echo '<td>' . $col['nursery_date'] . '</td>';
              $nurseryDate = new DateTime($col['nursery_date']);
              $currentDate = new DateTime(); // วันที่ปัจจุบัน
              $diff = $nurseryDate->diff($currentDate);
              $age = $diff->format('%a'); // คำนวณอายุเป็นจำนวนวัน
              echo '<td>' .   $age . ' วัน</td>';
              echo '<td>' . $col['nursery_amount'] . '</td>';
              echo '<td>' . $col['name_greenhouse'] . '</td>';
              echo '<td >
              <button type="button" class="btn btn-primary move-button" 
              data-bs-toggle="modal" data-bs-target="#add_data_Modal" 
              data-nursery-amount="' . $col["nursery_amount"] . '" data-id-nursery="' . $col["id_nursery"] . '" 
              data-id-vegetable="' . $col["id_veg_farm"] . '"  data-name-vegetable="' . $col["vegetable_name"] . '" data-date="' . $col["nursery_date"] . '"  >ย้าย</button>
              </td>';

              echo '</tr>';
            }
          }
          ?>
        </tbody>
      </table>
    </div>



  </div>

  <script src="../navbar/navbar.js"></script>
</body>
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">เพิ่มแปลง</h5>
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_move_planting.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <!-- #region --> <input type="hidden" name="id_nursery" id="id_nursery" class="form-control" readonly>
          <input type="hidden" name="date" id="date" class="form-control" readonly>
          <input type="hidden" name="id_plot" id="id_plot" value="<?= $idPlot ?>" class="form-control" >

          <input type="hidden" name="id_veg_farm" id="id_veg_farm"  class="form-control" >




          <label style="text-align: left; display: block; ">แปลงที่จะย้ายไป </label><span id="user-availability-status"></span>
          <input type="text" name="name_plot" id="name_plot" class="form-control" value="<?php echo $namePlot ?>" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">

          <label style="text-align: left; display: block; ">ชื่อผัก </label><span id="user-availability-status"></span>
          <input type="text" name="vegetable_name" id="vegetable_name" class="form-control" readonly>


          <label style="text-align: left; display: block;">จำนวนที่มีในแปลงอนุบาล</label>

          <input type="number" name="num_nursery" id="num_have" class="form-control" readonly>

          <label style="text-align: left; display: block;">จำนวนช่องว่างในแปลงปลูก</label>

          <input type="number" name="num_max" id="num_max" class="form-control" value="<?php echo $total_slots ?>" readonly>

          <label id="label_num_planting" class="text-dark" style="text-align: left; display: block;">จำนวนที่ย้าย <span id="warning-message"></span></label>
          <input type="number" name="num_planting" id="num_planting" class="form-control" required placeholder="จำนวนที่ย้าย" oninput="checkPlanting()" >
          <label style="text-align: left; display: block;">รอบการให้ปุ่ย</label>
          <select name="num_fertilizing" id="num_fertilizing" class="form-control" required>

            <?php if (isset($_SESSION["num_fertilizing"])) {

              echo "<option value='$num_fertilizing'>$num_fertilizing ▼</option>";
            } else {

              echo '<option value="" disabled selected> -- เลือกรอบวันให้ปุ่ย -- ▼</option>';
            }
            ?>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
          <!-- Other form fields -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancelAndReload()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save" id="save1" class="btn btn-primary" value="ยืนยัน">
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get all elements with the class "move-button"
    const moveButtons = document.querySelectorAll('.move-button');

    // Add a click event listener to each button
    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {
          // Get the values from the data attributes
          const nurseryAmount = button.getAttribute('data-nursery-amount');
          const idNursery = button.getAttribute('data-id-nursery');
          const vegetable_name = button.getAttribute('data-name-vegetable');
          const id_vegetable = button.getAttribute('data-id-vegetable');
          const date = button.getAttribute('data-date');
          var num_max = parseInt(document.getElementById('num_max').value);

          // Set the values in the input fields
          const inputField = document.getElementById('num_have'); // You may need to use a different ID if necessary
          inputField.value = nurseryAmount;

          // Set the id_nursery in the form's hidden field
          const idvegetableField = document.getElementById('id_veg_farm');
          idvegetableField.value =id_vegetable;

          const idNurseryField = document.getElementById('id_nursery');
          idNurseryField.value = idNursery;

          const vegetable_name_Field = document.getElementById('vegetable_name');
          vegetable_name_Field.value = vegetable_name;

          const date_Field = document.getElementById('date');
          date_Field.value = date;

          const num_planting = document.getElementById('num_planting');
          //  document.write("<p>" + num_max  + "</p>");

          if (num_max > inputField.value) {
            num_planting.value = inputField.value;
          } else {
            num_planting.value = num_max;

          }
        }


      );
    });
  });
</script>

<script>
  //กดที่ช่อง จำนวนที่ย้าย  ให้ลบ ข้อมูลเก่า
  // function clearValue() {
  //   document.getElementById('num_planting').value = ''; // ลบค่าที่อยู่ในช่อง input
  // }
  //กด cancel รีเฟรชหน้า
  function cancelAndReload() {
    // รีเฟรชหน้า
    window.location.reload();
  }

  function checkPlanting() {
    var num_have = parseInt(document.getElementById('num_have').value);
    var numPlanting = parseInt(document.getElementById('num_planting').value);
    var num_max = parseInt(document.getElementById('num_max').value);
    var warningMessage = document.getElementById('warning-message');
    var label = document.getElementById('label_num_planting');



    if (numPlanting > num_have) {
      label.innerHTML = '<label id="label_num_planting" class="text-danger" style="text-align: left; display: block;">"จำนวนที่ย้าย จำนวนที่มีในแปลงอนุบาล!!!" </label';
      document.getElementById('save1').style.display = 'none';
      // ซ่อนปุ่ม submit
    } else if (numPlanting > num_max) {
      label.innerHTML = '<label id="label_num_planting" class="text-danger" style="text-align: left; display: block;">"จำนวนที่ย้าย มากกว่าจำนวนสูงสุด!!!" </label';
      document.getElementById('save1').style.display = 'none';
      // ซ่อนปุ่ม submit
    } else {
      document.getElementById('save1').style.display = 'block'; // แสดงปุ่ม submit
      label.innerHTML = '<label id="label_num_planting" class="text-dark" style="text-align: left; display: block;">จำนวนที่ย้าย  </label>';
    }
  }
</script>








</html>