<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql = "SELECT * FROM `tb_greenhouse`
INNER JOIN `tb_farm`ON tb_greenhouse.id_farm = tb_farm.id_farm
WHERE tb_farm.name_farm = '$farm_name'";
$result = mysqli_query($conn, $sql);

$sql_id = "SELECT id_farm FROM `tb_farm` WHERE name_farm = '$farm_name'";
$result_sql_id = mysqli_query($conn, $sql_id);
$re = mysqli_fetch_array($result_sql_id);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- เรียกใช้ ฺBootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <title>ShowGreenhouse</title>
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
  <script src="../script/check.js"></script>

  <!-- เมนูด้านข้าง ( Side Menu ) -->
  <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
    <ul class="nav nav-pills flex-column mb-auto pt-5 side_nav_menu"></ul>
  </div>
  <!-- เนื้อหาหลัก -->
  <div class="pt-5 main-content-div" style=" text-align: center;">

    <div class="container mt-5 ">

      <div class="d-flex justify-content-between">
      <div >
          <a href="index.php" id="back" class="btn btn-dark ">
            <i class="fas fa-arrow-left me-2"></i> กลับ
          </a>
        </div>

    <div>        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_data_Modal">
          <i class="fas fa-plus"> </i> <i class="fa fa-database" aria-hidden="true"></i>
        </button>
</div>
      </div>
      <table class="table table-striped table-bordered">
        <caption class="caption-top">ตารางแสดงข้อมูลโรงเรือน</caption>


        <thead>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
        </thead>


        <thead class="table-dark">
          <tr>
            <th>ชื่อโรงเรือน</th>
            <th>ลบข้อมูล</th>
            <th>แก้ไขข้อมูล</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = mysqli_fetch_array($result)) {

          ?>
            <tr>

              <td><?= $row["name_greenhouse"] ?></td>


              <?php
              $sql_green = "SELECT g.name_greenhouse , p.plot_name , pn.plotnursery_name
              FROM tb_greenhouse as g 
              LEFT JOIN tb_plot as p on p.id_greenhouse = g.id_greenhouse 
              LEFT JOIN tb_plot_nursery as pn on pn.id_greenhouse = g.id_greenhouse
              LEFT JOIN tb_seed_germination as sg ON sg.id_greenhouse = g.id_greenhouse
              INNER JOIN tb_farm as f ON f.id_farm = g.id_farm 
              WHERE f.id_farm = $id_farm_session and g.name_greenhouse = '" . $row["name_greenhouse"] . "' 
              AND (p.id_plot  IS NOT NULL or pn.id_plotnursery IS NOT NULL or sg.id_seed_germination IS NOT NULL )
              ";
              $result_check_gh = mysqli_query($conn, $sql_green);
              $numColumns = mysqli_num_rows($result_check_gh);
              ?>

              <td style="border: none;">
                <?php if ($row["id_greenhouse"] == $id_greenhouse_session ||  $numColumns > 0) {  ?>
                  <a class="" style="color: gray;"><i class="fa-regular fa-trash-can fa-xl"></i></a>

                <?php
                } else { ?>
                  <a class="" style="color: red;" href="../phpsql/delete_data.php?id=<?= $row['id_greenhouse'] ?>&tb=tb_greenhouse&idtb=id_greenhouse&location=../php/ShowGreenhouse.php" onclick="Del(this.href);return false;"><i class="fa-regular fa-trash-can fa-xl"></i></a>

                <?php } ?>
              </td>
              <td style="border: none;">
                <a type="button" class="edit-button" style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#update_data_Modal" data-greenhouse_name="<?= $row["name_greenhouse"] ?>" data-id_greenhouse="<?= $row["id_greenhouse"] ?>"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
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

<!-- Modal insert-->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">เพิ่มโรงเรือน</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body" id="info_update5">

        <form method="post" action="../phpsql/insert_greenhouse.php" enctype="multipart/form-data">
          <label class="mb-2">ชื่อฟาร์ม: </label>
          <div class="alert alert-secondary" role="alert">
            <?php
            echo $_SESSION["farm_name"];
            // unset($_SESSION["user"]);
            ?>
          </div>
          <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?= $re['id_farm'] ?>" hidden>
          <br>
          <label class="mb-2">ชื่อโรงเรือน : </label><span id="user-availability-status"></span>
          <input type="text" name="greenhouse_name" id="greenhouse_name" onkeyup="checkInput(this)" class="form-control" required oninput="checkAvailability()">
          <br>
          <button type="submit" id="save1" class="btn btn-success">บันทึก</button>
          <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        </form>

      </div>
    </div>

  </div>
</div>
<!-- End Modal insert-->

<!-- Modal update-->
<div class="modal fade" id="update_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">แก้ไขข้อมูลโรงเรือน</h5>
      </div>
      <div class="modal-body" id="info_update5">

        <form method="post" action="../phpsql/update_greenhouse.php" enctype="multipart/form-data">
          <label class="mb-2">ชื่อฟาร์ม: </label>
          <div class="alert alert-secondary" role="alert">
            <?php
            echo $_SESSION["farm_name"];
            // unset($_SESSION["user"]);
            ?>
          </div>
          <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?= $re['id_farm'] ?>" hidden>
          <input type="text" name="id_greenhouseedit" id="id_greenhouseedit" class="form-control" hidden>
          <br>
          <label class="mb-2">ชื่อโรงเรือน : </label><span id="user-availability-statusEdit"></span>
          <input type="text" name="greenhouse_name_edit" id="greenhouse_name_edit" onkeyup="checkInput(this)" class="form-control" required oninput="checkAvailabilityEdit()">
          <br>
          <button type="submit" id="edit1" class="btn btn-warning">แก้ไข</button>
          <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
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
      url: "../phpsql/check_availability_vet.php",
      cache: false,
      data: {
        type: 'tb_greenhouse',
        input_name: $("#greenhouse_name").val(),
        where: 'name_greenhouse',
      },
      success: function(data) {
        $("#user-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#save1").prop("disabled", true);

        } else {
          $("#save1").prop("disabled", false);
        }
      }
    });
  }

  function checkAvailabilityEdit() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability_vet.php",
      cache: false,
      data: {
        type: 'tb_greenhouse',
        input_name: $("#greenhouse_name_edit").val(),
        where: 'name_greenhouse',
      },
      success: function(data) {
        $("#user-availability-statusEdit").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#edit1").prop("disabled", true);

        } else {
          $("#edit1").prop("disabled", false);
        }
      }
    });
  }

  function cancel() {
    window.location.reload();
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
        const greenhouse_name = button.getAttribute('data-greenhouse_name');
        const id_greenhouse = button.getAttribute('data-id_greenhouse');
        // Set the values in the input fields
        const greenhouse_nameField = document.getElementById('greenhouse_name_edit'); // You may need to use a different ID if necessary
        greenhouse_nameField.value = greenhouse_name;
        const id_greenhouseField = document.getElementById('id_greenhouseedit'); // You may need to use a different ID if necessary
        id_greenhouseField.value = id_greenhouse;

      });
    });
  });


  window.onload = function() {

   var greenDropdown = document.getElementById("greenhouseDropdown");
   greenDropdown.disabled = true;

  };
</script>


</html>