<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql = "SELECT * FROM `tb_farm`
INNER JOIN `tb_user` ON tb_farm.id_user = tb_user.id_user
WHERE tb_user.id_user = '$id_user_session'";
$result = mysqli_query($conn, $sql);

;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap JS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <title>ShowFarm</title>
</head>
<style>
  .modal-header {
    background-color: #050f16;
    color: #ffffff;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .modal-content {
    border-radius: 15px;
    box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.5);
  }

  .alert {
    margin-bottom: 0;
    padding: 0.5rem 0.5rem;
  }
</style>

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
        <caption class="caption-top">ตารางแสดงข้อมูลฟาร์ม</caption>


        <thead>
        
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;">
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_data_Modal">+ เพิ่มข้อมูล</a>
          </th>
        </thead>


        <thead class="table-dark">
          <tr>
            <!-- <th>รหัสฟาร์ม</th> -->
            <!-- <th>รหัสผู้ใช้</th> -->
            <th>ชื่อฟาร์ม</th>
            <th>ที่ตั้ง</th>
      
            <th>แก้ไขข้อมูล</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = mysqli_fetch_array($result)) {
          ?>
            <tr>
              <!-- <td><?= $row["id_farm"] ?></td> -->
              <!-- <td><?= $row["id_user"] ?></td> -->
              <td><?= $row["name_farm"] ?></td>
              <td><?= $row["location"] ?></td>


            
              <td style="border: none;">
                <a type="button" class="edit-button" style="color: orange; cursor: pointer;" 
                data-bs-toggle="modal" 
                data-bs-target="#update_data_Modal" 
                data-farm_name="<?= $row["name_farm"] ?>"
                data-id_farm="<?= $row["id_farm"] ?>"
                data-location="<?= $row["location"] ?>"
                ><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="../navbar/navbar.js"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">เพิ่มฟาร์ม</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body" id="info_update5">

        <form name="farmfirst" method="post" id="insertdata" action="../phpsql/insert_farm.php" enctype="multipart/form-data">
          <label class="mb-2">บัญชี : </label>
          <div class="alert alert-secondary" role="alert">
            <?php
            echo $_SESSION["user"];
            // unset($_SESSION["user"]);
            ?>
          </div>
          <input type="text" name="id_user" id="id_user" class="form-control" value="<?= $re['id_user'] ?>" hidden>
          <label class="mb-2">ชื่อฟาร์ม : </label><span id="user-availability-status"></span>
          <input type="text" name="farm_name" id="farm_name" class="form-control" required oninput="checkAvailability()">
          <label class="mb-2">ที่อยู่ฟาร์ม : </label><br>
          <input type="text" name="location" id="location" class="form-control" required>
          <label class="mb-2">โรงเรือนในฟาร์ม : </label><br><span id="user-availability-statusGreen"></span>
          <input type="text" name="greenhouse" id="greenhouse" class="form-control" required>
          <input type="num" name="check_insert" value="1" hidden >
          <br>
          <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" id="savefarm"  class="btn btn-success">บันทึก</button>
        </form>

      </div>
    </div>

  </div>
</div>
<!-- End Modal -->

<!-- Modal update-->
<div class="modal fade" id="update_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">แก้ไขข้อมูฟาร์ม</h5>
      </div>
      <div class="modal-body" id="info_update5">

      <form method="post" action="../phpsql/insert_farm.php" enctype="multipart/form-data">
          <label class="mb-2">บัญชี : </label>
          <div class="alert alert-secondary" role="alert">
            <?php
            echo $_SESSION["user"];
            // unset($_SESSION["user"]);
            ?>
          </div>
          <input type="text" name="id_user" id="id_user" class="form-control" value="<?= $re['id_user'] ?>" hidden>
          <input type="text" name="id_farm_edit" id="id_farm_edit" class="form-control" hidden>
          <label class="mb-2">ชื่อฟาร์ม : </label><span id="user-availability-statusEdit"></span>
          <input type="text" name="farm_name_edit" id="farm_name_edit" class="form-control" required oninput="checkAvailabilityedit()">
          <label class="mb-2">ที่อยู่ฟาร์ม : </label><br>
          
          <input type="text" name="location_edit" id="location_edit" class="form-control" required>
          <input type="num" name="check_edit" value="1" hidden >
          <br>

          <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" id="save_edit" class="btn btn-warning">แก้ไข</button>
        </form>

      </div>
    </div>
  </div>
</div>
<!-- End Modal update -->

<script type="text/javascript">
  function checkAvailability() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability.php",
      cache: false,
      data: {
        type: 'tb_farm',
        input_name: $("#farm_name").val(),
        where: 'name_farm',
      },
      success: function(data) {
        $("#user-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#savefarm").prop("disabled", true);          
        } else {
          $("#savefarm").prop("disabled",false);          

        }
      }
    });
  }

  function checkAvailabilityedit() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability.php",
      cache: false,
      data: {
        type: 'tb_farm',
        input_name: $("#farm_name_edit").val(),
        where: 'name_farm',
      },
      success: function(data) {
        $("#user-availability-statusEdit").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#save_edit").prop("disabled", true);         
           
        } else {
          $("#save_edit").prop("disabled",false);          

        }
      }
    });
  }
 
  function Del(mypage) {
    var agree = confirm("คุณต้องการลบข้อมูลหรือไม่");
    if (agree) {
      window.location = mypage;
    }
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get all elements with the class "move-button"
    const moveButtons = document.querySelectorAll('.edit-button');
    // Add a click event listener to each button
    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        // Get the values from the data attributes
        const farm_name = button.getAttribute('data-farm_name');
        const id_farm = button.getAttribute('data-id_farm');
        const location = button.getAttribute('data-location');
        // Set the values in the input fields
        const farm_nameField = document.getElementById('farm_name_edit'); // You may need to use a different ID if necessary
        farm_nameField.value = farm_name;
        const id_farmField = document.getElementById('id_farm_edit'); // You may need to use a different ID if necessary
        id_farmField.value = id_farm;
        const locationField = document.getElementById('location_edit'); // You may need to use a different ID if necessary
        locationField.value = location;
      });
    });
  });

  function cancel() {
      window.location.reload();
    }
</script>

</html>