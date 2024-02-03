<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

date_default_timezone_set('asia/bangkok');
$datenow = date("Y-m-d");



$sql_fer = "SELECT * FROM `tb_fertilizer` as a 
INNER JOIN tb_farm as b ON b.id_farm = a.id_farm 
INNER JOIN tb_user as c ON c.id_user = b.id_user 
WHERE b.name_farm = '$farm_name' AND c.user_name = '$user';";
$result_sql_fer = mysqli_query($conn, $sql_fer);

$sql_veg = "SELECT * FROM `tb_vegetable` AS v
INNER JOIN  tb_veg_farm AS vf on v.id_vegetable = vf.id_vegetable
INNER JOIN tb_farm AS f on f.id_farm = vf.id_farm
INNER JOIN  tb_vegetableweight AS vw ON vw.id_veg_farm = vf.id_veg_farm
INNER JOIN  tb_vegetableprice AS vp  ON vp.id_veg_farm = vf.id_veg_farm
INNER JOIN tb_fertilizer as fl on fl.id_fertilizer = v.id_fertilizer
WHERE f.id_farm = $id_farm_session";
$rs_vet = mysqli_query($conn, $sql_veg );

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
  <title>ShowVegetable</title>
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
    <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
  </div>

  <!-- ตารางผัก -->
  <div class="pt-5 main-content-div" style=" text-align: center;">

    <div class="container" style="margin-top: 20px;">
      <table class="table table-striped table-bordered">
        <caption class="caption-top">ตารางแสดงข้อมูลผัก</caption>
        <thead>
          <th style="border: none;">
            <!-- <a class="btn btn-primary" href="../php/ShowPrice.php">จัดการข้อมูลราคาผัก</a> -->
          </th>
          <th style="border: none;">
            <!-- <a class="btn btn-primary" href="../php/ShowWeight.php">จัดการข้อมูลน้ำหนักผัก</a> -->
          </th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <!-- <th style="border: none;"></th> -->
          <!-- <th style="border: none;"></th> -->
          <th style="border: none; text-align: right;">
            <button class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#add_data_Modal">
              <i class="fas fa-plus"></i><i class="fas fa-seedling"></i>
            </button>
          </th>
        </thead>
        <thead class="table-dark">
          <tr>
            <!-- <th>รหัสผัก</th> -->
            <th colspan="2">ชื่อผัก</th>
            <th>ปุ๋ย</th>
            <th>อายุ</th>
            <th>ราคา</th>
            <th  class="text-nowrap">น้ำหนักเฉลี่ย</th>
            <!-- <th>น้ำหนัก</th> -->
            <!-- <th>วันที่บันทึก</th> -->
            <th>ลบ</th>
            <th>แก้ไข</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($rs_vet)) {
          
          ?>
            <tr>

              <td><img src="../img/<?= $row['img_name'] ?>" style="width: 50px; border-radius: 50px;"></td>

              <td><?= $row["vegetable_name"] ?></td>
              <td><?= $row["fertilizer_name"] ?></td>
              <td class="text-nowrap"><?= $row["vegetable_age"] ?> วัน</td>

                <td class="text-nowrap"><?= $row["price"] ?> บ.</td>

                <td class="text-nowrap"><?= number_format($row["vegetableweight"] / $row["amount_tree"], 1) ?>  กรัม</td>
                <!-- <td><?= $row["vegetableweight"] ?> กก.</td> -->
                <!-- <td><?= $row["vegetableweightdate"] ?></td> -->

              <?php
              //แก้
              $idvegetable = $row["id_veg_farm"];
              // $del1 = "SELECT id_vegetable FROM tb_planting WHERE id_vegetable = '$idvegetable'";
              // $nodel1 = mysqli_query($conn, $del1);
              // $fet_nodel1 = mysqli_fetch_array($nodel1);

              $del2 = "SELECT id_veg_farm FROM tb_seed_germination WHERE id_veg_farm = '$idvegetable'";
              $nodel2 = mysqli_query($conn, $del2);
              $fet_nodel2 = mysqli_fetch_array($nodel2);

              $new = "SELECT v.vegetable_name , pt.id_planting , vn.id_nursery  , sg.id_seed_germination
              FROM `tb_veg_farm`  AS vf 
              INNER JOIN tb_farm as f on vf.id_farm =  f.id_farm
              INNER JOIN tb_vegetable AS v on v.id_vegetable = vf.id_veg_farm
              RIGHT JOIN tb_planting as pt ON pt.id_veg_farm = vf.id_veg_farm
              RIGHT JOIN tb_vegetable_nursery as vn ON vn.id_veg_farm = vf.id_veg_farm
              RIGHT JOIN tb_seed_germination as sg ON sg.id_veg_farm = vf.id_veg_farm
              WHERE f.id_farm = 1001";// แก้


              if ((isset($fet_nodel2['id_vegetable']))) {
              ?>
                <td style="border: none;">
                  <a class="disabled" style="color: gray;"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                </td>
                <td style="border: none;">
                  <a class="update_data" style="color: orange; cursor: pointer;" id="<?= $row['id_vegetable']; ?>" id_veg_farm="<?= $row['id_veg_farm']; ?>" data-bs-toggle="modal" data-bs-target="#update_data_Modal"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                </td>
              <?php } else { ?>
                <td style="border: none;">
                  <a class="" style="color: red;" href="../phpsql/delete_vegetable.php?id=<?= $row['id_vegetable'] ?> && id_veg_farm=<?= $row['id_veg_farm'] ?> " onclick="Del(this.href);return false;"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                </td>
                <td style="border: none;">
                  <a class="update_data" style="color: orange; cursor: pointer;" id="<?= $row['id_vegetable']; ?>" id_veg_farm="<?= $row['id_veg_farm']; ?>" data-bs-toggle="modal" data-bs-target="#update_data_Modal"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- ตารางผัก end -->

  <!-- ตารางปุ๋ย -->
  <div class="main-content-div" style=" text-align: center;">

    <div class="container" style="margin-top: 20px;">
      <table class="table table-striped table-bordered">
        <caption class="caption-top">ตารางแสดงข้อมูลปุ่ย</caption>
        <thead>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none; text-align: right;">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_fertilizer_Modal">
              <i class="fas fa-plus"></i><i class="fas fa-tint"></i>
            </button>
          </th>
        </thead>
        <thead class="table-dark">
          <tr>
            <th>ชื่อปุ๋ย</th>
            <th>ลบข้อมูล</th>
            <th>แก้ไขข้อมูล</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row_fer = mysqli_fetch_array($result_sql_fer)) { ?>
            <tr>

              <td><?= $row_fer["fertilizer_name"] ?></td>

              <?php
              $idfertilizer = $row_fer["id_fertilizer"];
              $del_fer = "SELECT id_fertilizer FROM tb_vegetable WHERE id_fertilizer = '$idfertilizer'";
              $del_fer = mysqli_query($conn, $del_fer);
              $fet_del_fer = mysqli_fetch_array($del_fer);
              if (isset($fet_del_fer['id_fertilizer'])) {
              ?>
                <td style="border: none;">
                  <a class="disabled" style="color: gray;"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                </td>
                <td style="border: none;">
                  <a class="edit-button" style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#update_fertilizer_Modal" data-fertilizer_name="<?= $row_fer["fertilizer_name"] ?>" data-id_fertilizer="<?= $row_fer["id_fertilizer"] ?>">
                    <i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                </td>
              <?php } else { ?>
                <td style="border: none;">
                  <a class="" style="color: red;" href="../phpsql/delete_data.php?id=<?= $row_fer["id_fertilizer"] ?>&tb=tb_fertilizer&idtb=id_fertilizer&location=../php/ShowVegetable.php" onclick="Del(this.href);return false;"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                </td>
                <td style="border: none;">
                  <a class="edit-button" style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#update_fertilizer_Modal" data-fertilizer_name="<?= $row_fer["fertilizer_name"] ?>" data-id_fertilizer="<?= $row_fer["id_fertilizer"] ?>">
                    <i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- ตารางปุ๋ย end -->

  <script src="../navbar/navbar.js"></script>

</body>

<!-- Modal insert vegetable-->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">เพิ่มข้อมูลผัก</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">

        <form method="post" action="../phpsql/insert_vegatable.php" enctype="multipart/form-data">
          <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?= $id_farm_session ?>" hidden>
          <div class="row mt-2 mb-2">
            <div class="col">
              <label>ชื่อผัก : </label><span id="user-availability-status"></span>
              <input type="text" name="vegetable_name" id="vegetable_name" class="form-control" required oninput="checkAvailability()" placeholder="ป้อนชื่อผัก...">
            </div>
            <div class="col">
              <label>อายุผัก : </label>
              <input type="number" name="age_vegatable" id="age_vegatable" class="form-control" required min="0" placeholder="ป้อนจำนวนวัน...">
            </div>
          </div>
          <label>ปุ๋ย : </label>
          <select class="form-select mb-2" name="fertilizer" id="fertilizer" required>
            <option value=""> -- เลือกปุ๋ย ▼ -- </option>
            <?php foreach ($result_sql_fer as $fer) {
              echo '<option value="' . $fer['id_fertilizer'] . '"   >' . $fer['fertilizer_name'] . '</option>';
            } ?>
          </select>
          <div class="row mt-2 mb-2">
            <div class="col">
              <label>ราคาผัก :</label>
              <input type="number" name="vegetable_price" id="vegetable_price" class="form-control" required placeholder="ป้อนราคาผัก...">
            </div>
            <div class="col">
              <label>วันที่บันทึก : </label>
              <input type="date" name="date" id="date" class="form-control" value="<?php echo $datenow ?>" min="<?php echo $datenow ?>" required readonly placeholder="ป้อนวันที่...">
            </div>
          </div>
          <div class="row mt-2 mb-2">
            <div class="col">
              <label>จำนวนต้นต่อน้ำหนัก : </label><span id="user-availability-status"></span>
              <input type="number" name="amount_tree" id="amount_tree" class="form-control" required min="0" placeholder="ป้อนจำนวนต่อน้ำหนัก...">
            </div>
            <div class="col">
              <label>น้ำหนักผัก : กก. </label>
              <input type="number" step="any" name="vegetableweight" id="vegetableweight" class="form-control" required min="0" placeholder="ป้อนน้ำหนัก...">
            </div>
          </div>
          <label class="mb-2">รูปภาพผัก : </label><br>
          <input class="mb-2 form-control" type="file" name="photo" id="photo" required>
          <div class="text-center">
            <img style="object-fit: cover; border-radius: 100px" width="200px" height="200px" id="previewImg" src="../img/emp.jpg">
          </div>
          <button type="button" class="mt-2 btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" name="save1" id="save1" class="mt-2 btn btn-success">บันทึก</button>
        </form>


      </div>
    </div>
  </div>
</div>
<!-- End Modal insert vegetable-->

<!-- Modal insert fertilizer-->
<div class="modal fade" id="add_fertilizer_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">เพิ่มข้อมูลปุ๋ย</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">

        <form method="post" action="../phpsql/insert_fertilizer.php" enctype="multipart/form-data">
          <label class="mb-2">ชื่อฟาร์ม: </label>
          <input type="text" name="id_farm_fer" id="id_farm_fer" class="form-control mb-2" value="<?php echo $id_farm_session; ?>" readonly hidden>
          <input type="text" class="form-control mb-2" value="<?php echo $_SESSION["farm_name"]; ?>" readonly hidden>
          <label class="mb-2">ชื่อปุ๋ย: </label><span id="fertilizer-availability-status"></span>
          <input type="text" name="fertilizer_name" id="fertilizer_name" class="form-control" required placeholder="ป้อนชื่อปุ๋ย...">
          <button type="button" class="mt-2 btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" name="save2" id="save2" class="mt-2 btn btn-success">บันทึก</button>
        </form>


      </div>
    </div>
  </div>
</div>
<!-- End Modal insert fertilizer-->

<!-- Modal update vegetable-->
<div class="modal fade" id="update_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">แก้ไขข้อมูลผัก</h5>
      </div>
      <div class="modal-body" id="info_update5">

        <? include '../phpsql/select_vegeta_edit.php' ?>

      </div>
    </div>
  </div>
</div>
<!-- End Modal update vegetable-->

<!-- Modal update fertilizer-->
<div class="modal fade" id="update_fertilizer_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">เพิ่มข้อมูลปุ๋ย</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">

        <form method="post" action="../phpsql/update_fertilizer.php" enctype="multipart/form-data">
          <input type="text" name="id_fertilizeredit" id="id_fertilizeredit" class="form-control" hidden>
          <label class="mb-2">ชื่อฟาร์ม: </label>
          <input type="text" name="id_farm" id="id_farm" class="form-control mb-2" value="<?php echo $_SESSION["farm_name"]; ?>" readonly>
          <label class="mb-2">ชื่อปุ๋ย: </label>
          <input type="text" name="fertilizer_name_edit" id="fertilizer_name_edit" class="form-control" required>
          <button type="button" class="mt-2 btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" name="save2" id="save2" class="mt-2 btn btn-success">บันทึก</button>
        </form>


      </div>
    </div>
  </div>
</div>
<!-- End Modal update fertilizer-->

<script type="text/javascript">
  function checkAvailability() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability.php",
      cache: false,
      data: {
        type: 'tb_vegetable',
        input_name: $("#vegetable_name").val(),
        where: 'vegetable_name',
      },
      success: function(data) {
        $("#user-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#save1").css("display", 'none');
        } else {
          $("#save1").css({
            "display": 'block',
            "float": "right",
            "margin-right": "310px",
          });
        }
      }
    });
  }

  function checkFertilizername() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability.php",
      cache: false,
      data: {
        type: 'tb_fertilizer',
        input_name: $("#fertilizer_name").val(),
        where: 'fertilizer_name',
      },
      success: function(data) {
        $("#fertilizer-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#save2").css("display", 'none');
        } else {
          $("#save2").css({
            "display": 'block',
            "float": "right",
            "margin-right": "330px",
          });
        }
      }
    });
  }

  let photo = document.getElementById('photo');
  let previewImg = document.getElementById('previewImg');

  photo.onchange = evt => {
    const [file] = photo.files;
    if (file) {
      previewImg.src = URL.createObjectURL(file);
    } else {
      alert("อัพโหลดรูป");
    }
  }

  function cancel() {
    window.location.reload();
  }

  $(document).ready(function() {
    $(document).on('click', '.update_data', function() {
      var id = $(this).attr("id");
      var id_veg_farm = $(this).attr("id_veg_farm");

      $.ajax({
        url: "../phpsql/select_vegeta_edit.php",
        type: "POST",
        cache: false,
        data: {
          id: id,
          id_veg_farm: id_veg_farm // Corrected syntax here
        },
        success: function(data) {
          $('#info_update5').html(data);
          // $('#editData5').modal('show');
        }
      });
    });
  });


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
        const fertilizer_name = button.getAttribute('data-fertilizer_name');
        const id_fertilizeredit = button.getAttribute('data-id_fertilizer');

        // Set the values in the input fields
        const fertilizer_nameField = document.getElementById('fertilizer_name_edit'); // You may need to use a different ID if necessary
        fertilizer_nameField.value = fertilizer_name;
        const id_fertilizereditField = document.getElementById('id_fertilizeredit'); // You may need to use a different ID if necessary
        id_fertilizereditField.value = id_fertilizeredit;

      });
    });
  });
</script>


</html>