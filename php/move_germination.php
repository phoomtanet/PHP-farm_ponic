<?php
session_start();

include '../Connect/session.php';
include '../Connect/conn.php';

if (isset($_GET['greenhouse'])) {
  // ดึงค่า ID ที่ถูกส่งมา
  $selectedGreenhouseId = $_GET['greenhouse'];
} else {
  $selectedGreenhouseId = $id_greenhouse_session;
}

$sql = "SELECT * FROM `tb_seed_germination` AS a 
INNER JOIN `tb_greenhouse` AS c ON c.id_greenhouse = a.id_greenhouse
INNER JOIN tb_farm as d ON  d.id_farm = c.id_farm
INNER JOIN tb_user as e on e.id_user = d.id_user
INNER JOIN tb_traysize AS f ON f.id_traysize = a.id_traysize
INNER JOIN  tb_veg_farm as g on g.id_veg_farm = a.id_veg_farm
INNER JOIN  tb_vegetable as v on v.id_vegetable = g.id_vegetable
WHERE c.id_greenhouse = '$selectedGreenhouseId'
 ORDER BY c.id_greenhouse  , a.id_seed_germination   ASC";
$result = mysqli_query($conn, $sql); //ตารางการเพาะ


$plotnursery_name = $_GET['plotnursery_name'];
$space = $_GET['emp_slot']; // จำนวนช่องช่องที่ว่าง  อนุบาล

$sql_green = "SELECT *
FROM tb_greenhouse as b 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
WHERE c.id_farm = '$id_farm_session' 
GROUP BY b.id_greenhouse ";
$result_green = mysqli_query($conn, $sql_green);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- เรียกใช้ ฺBootstrap 5 -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/plot_nur.css">

  <title>Bootstrap 5</title>
</head>
<style>


</style>

<body>
  <!-- เมนูด้านข้าง ( Side Menu ) -->
  <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
    <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
  </div>
  <!-- เนื้อหาหลัก -->
  <div class=" main-content-div" style=" text-align: center;">
    <div class="container " >

      <div >

        <div class="d-flex justify-content-between mt-5">
          <div>
            <a href="../php/plot_nursery.php" id="back" class="back">
              <i class="fas fa-arrow-left me-2"></i> กลับ
            </a>
          </div>
          <div class="d-flex justify-content-evenly">
            <div>
              <form method="GET" action="move_germination.php">
                <select class=" mb-2" style="padding: 4px;" name="greenhouse" id="greenhouse" required>
                  <option value="">เลือกโรงเรือน</option>
                  <?php foreach ($result_green as $row) {
                    
                    echo '<option  value="' . $row['id_greenhouse'] . '">' . $row['name_greenhouse'] . '</option>';
                  } ?>
                  <input hidden type="text" value="<?= $plotnursery_name  ?>" name="plotnursery_name">
                  <input hidden type="text" value="<?= $space   ?>" name="emp_slot">

                </select>
            </div>
            <div> <button type="submit" id="bt_date" style="padding: 4px;" class="btn btn-outline-dark px-2  mx-2">
                <i class="fas fa-search"></i>
              </button>
            </div>

            </form>
          </div>
        </div>
      </div>







    <table class=" ">
      <caption class="caption-top"><b> ย้ายไปแปลง อนุบาล <?= $plotnursery_name ?></b></caption>

      <thead class="table-dark">
        <tr>
          <th colspan="2">ชื่อผัก</th>
          <th>ขนาดถาดเพาะ</th>
          <th>จำนวนถาด</th>
          <th>วันที่เพาะ</th>
          <th>อายุผัก</th>
          <th>จำนวนที่เพาะ</th>
          <th>โรงเรือน</th>
          <th>ย้าย</th>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($result as $row) {
          $germination_dateDate = strtotime($row["germination_date"]);
          $currentDate = strtotime(date("Y-m-d"));
          $dateDifference = date_diff(date_create(date("Y-m-d", $germination_dateDate)), date_create(date("Y-m-d", $currentDate)));
          $daysDifference = $dateDifference->days;    //คำนวนอายุผัก


          $thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
          $thai_sg = date('d', strtotime($row["germination_date"])) . ' ' . $thaimonth[date('n', strtotime($row["germination_date"])) - 1] . ' ' .  date('Y', strtotime($row["germination_date"]));
       
       
        ?>

          <tr>
            <td class="border">
              <img src="../img/<?php echo $row['img_name']  ?>" style="width: 50px; border-radius: 50px;">
            </td>
            </td>
            <td class="border"><?= $row["vegetable_name"] ?></td>
            <td class="border"><?= $row["size_name"] ?></td>
            <td class="border"><?= $row["Amount_trays"] ?></td>
            <td class="border"><?= $thai_sg  ?></td>
            <td class="border"><?= $daysDifference  . ' วัน' ?></td>
            <td class="border"><?= $row["germination_amount"] ?></td>
            <td class="border"> <?= $row["name_greenhouse"] ?></td>
            <td class="border" style="border: none;">
              <button type="button" class="btn  move-button" data-bs-toggle="modal" data-bs-target="#move_to_nursery" id-veg_farm="<?= $row["id_veg_farm"] ?>" id-plot_nursery="<?= $id_plotnursery ?>" data-name-vegetable="<?= $row["vegetable_name"] ?>" data-date="<?= $row["germination_date"] ?>" data-germination-amount="<?= $row["germination_amount"]  ?>" data-id_seed_germination="<?= $row["id_seed_germination"] ?>">
                <i class="fas fa-sign-out-alt"></i> </button>
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
  </div>
  </div>

  <script src="../navbar/navbar.js"></script>
</body>


<div class="modal fade" id="move_to_nursery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">ย้ายแปลงเพาะ -> แปลงอนุบาล</h5>
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_move_tonursery.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <input type="hidden" name="id_seed_germination" id="id_seed_germination" class="form-control" readonly>
          <input type="hidden" name="date" id="date" class="form-control" readonly>
          <input type="text" name="id_veg_farm" id="id_veg_farm" class="form-control" readonly>

          <label style="text-align: left; display: block; ">แปลงที่จะย้ายไป </label><span id="user-availability-status"></span>
          <input type="text" name="name_plot" id="username2" class="form-control" value="<?php echo $plotnursery_name; ?>" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block; ">ชื่อผัก </label><span id="user-availability-status"></span>
          <input type="text" name="vegetable_name" id="vegetable_name" class="form-control" readonly>
          <label style="text-align: left; display: block;">จำนวนในแปลงเพาะ</label>
          <input type="number" name="germination_amount" id="germination_amount" class="form-control" readonly>
          <label style="text-align: left; display: block;">ช่องว่างในแปลงอนุบาล</label>

          <input type="text" name="space" id="space" class="form-control" value="<?php echo $space ?>" readonly>
          <label id="label_num_nursery" class="text-dark" style="text-align: left; display: block;">จำนวนที่ย้าย <span id="warning-message"></span></label>
          <input type="number" name="num_nursery" id="num_nursery" class="form-control" required placeholder="จำนวนที่ย้าย" oninput="checkPlanting()" onclick="clearValue()">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="cancelAndReload()" data-bs-dismiss="modal">ยกเลิก</button>
            <input type="submit" name="save" id="save1" class="btn btn-primary" value="ยืนยัน">
          </div>
        </form>
      </div>
    </div>
  </div>





</html>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.move-button');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {

          var space = parseInt(document.getElementById('space').value); //ช่องว่าง

          const id_veg_farm = button.getAttribute('id-veg_farm');
          const id_veg_Field = document.getElementById('id_veg_farm');
          id_veg_Field.value = id_veg_farm;

          const id_seed_germination = button.getAttribute('data-id_seed_germination');
          const id_seed_germination_Field = document.getElementById('id_seed_germination');
          id_seed_germination_Field.value = id_seed_germination;

          const vegetable_name = button.getAttribute('data-name-vegetable');
          const vegetable_name_Field = document.getElementById('vegetable_name');
          vegetable_name_Field.value = vegetable_name;

          const germination_amount = button.getAttribute('data-germination-amount');
          const germination_amount_Field = document.getElementById('germination_amount');
          germination_amount_Field.value = germination_amount;

          const date = button.getAttribute('data-date');
          const date_Field = document.getElementById('date');
          date_Field.value = date;

          const num_nursery = document.getElementById('num_nursery');
          //  document.write("<p>" + space  + "</p>");

          if (space > germination_amount_Field.value && space > 0) {
            num_nursery.value = germination_amount;
          } else if (space < germination_amount_Field.value && space > 0) {
            num_nursery.value = space;

          }
        }


      );
    });
  });
</script>


<script>
  //วันที่ปัจจุบันในช่อง input
  let today = new Date().toISOString().slice(0, 10);
  let germinationDateInput = document.getElementById("germination_date");
  germinationDateInput.value = today;
  // รีเฟรชหน้า
  function cancelAndReload() {
    window.location.reload();

  }

  function clearValue() {
    document.getElementById('num_nursery').value = ''; // ลบค่าที่อยู่ในช่อง input
  }

  function checkPlanting() {
    var num_have = parseInt(document.getElementById('germination_amount').value);
    var numNuesery = parseInt(document.getElementById('num_nursery').value);
    var space = parseInt(document.getElementById('space').value);
    var warningMessage = document.getElementById('warning-message');
    var label = document.getElementById('label_num_nursery');


    if (space == 0) {
      label.innerHTML = '<label id="label_num_nursery" class="text-danger" style="text-align: left; display: block;">"แปลงเพาะเต็ม!!!" </label';
      document.getElementById('save1').disabled = true;
      // ซ่อนปุ่ม submit
    } else if (numNuesery > num_have) {
      label.innerHTML = '<label id="label_num_nursery" class="text-danger" style="text-align: left; display: block;">"จำนวนที่ย้าย จำนวนที่มีในแปลงเพาะ!!!" </label';
      document.getElementById('save1').disabled = true;
      // ซ่อนปุ่ม submit
    } else if (numNuesery > space) {
      label.innerHTML = '<label id="label_num_nursery" class="text-danger" style="text-align: left; display: block;">"จำนวนที่ย้าย มากกว่าจำนวนสูงสุด!!!" </label';
      document.getElementById('save1').disabled = true;
      // ซ่อนปุ่ม submit
    } else {
      document.getElementById('save1').disabled = false;
      label.innerHTML = '<label id="label_num_nursery" class="text-dark" style="text-align: left; display: block;">จำนวนที่ย้าย  </label>';
    }
  }
</script>