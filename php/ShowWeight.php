<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql = "SELECT * FROM `tb_vegetable`AS a
INNER JOIN `tb_farm` AS b ON a.id_farm  = b.id_farm 
INNER JOIN `tb_user` AS c ON b.id_user = c.id_user
INNER JOIN tb_fertilizer AS d  ON  a.id_fertilizer  = d.id_fertilizer 
WHERE b.name_farm = '$farm_name' AND c.user_name = '$user' ;";
$result = mysqli_query($conn, $sql);

$sql_pri = "SELECT * FROM `tb_vegetableprice` AS a
INNER JOIN `tb_vegetable` AS b ON a.id_vegetable = b.id_vegetable ";
$result_pri = mysqli_query($conn, $sql_pri);

$sql_weight = "SELECT * FROM `tb_vegetableweight` AS a
INNER JOIN `tb_vegetable` AS b ON a.id_vegetable = b.id_vegetable ";
$result_weight = mysqli_query($conn,$sql_weight);

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
  <!-- ตารางน้ำหนักผัก -->
  <div class="pt-5 main-content-div" style=" text-align: center;">

    <div class="container" style="margin-top: 20px;">
      <table class="table table-striped table-bordered">
        <caption class="caption-top">ตารางแสดงข้อมูลน้ำหนักผัก</caption>
        <thead>
          <th style="border: none;">
            <a class="btn btn-primary" href="../php/ShowPrice.php">จัดการข้อมูลราคาผัก</a>
          </th>
          <th style="border: none;">
            <a class="btn btn-primary" href="../php/ShowVegetable.php">จัดการข้อมูลผัก</a>
          </th>
          <th style="border: none;"></th>
          <!-- <th style="border: none;"></th> -->
          <!-- <th style="border: none;"></th> -->
          <!-- <th style="border: none;"></th> -->
          <!-- <th style="border: none;">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_data_Modal"> + เพิ่มข้อมูล</button>
          </th> -->
        </thead>
        <thead class="table-dark">
          <tr>
            <!-- <th>รหัสน้ำหนักผัก</th> -->
            <th>วันที่บันทึกน้ำหนัก</th>
            <th>ผัก</th>
            <th>จำนวนต้นต่อน้ำหนัก</th>
            <th>น้ำหนักผัก</th>
            <!-- <th>ลบข้อมูล</th> -->
            <!-- <th>แก้ไขข้อมูล</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row_weight = mysqli_fetch_array($result_weight)) {
          ?>
            <tr>
              <!-- <td><?= $row_weight["id_vegetableweight"] ?></td> -->
              <td><?= $row_weight["vegetableweightdate"] ?></td>
              <td><?= $row_weight["vegetable_name"] ?></td>
              <td><?= $row_weight["amount_tree"] ?></td>
              <td><?= $row_weight["vegetableweight"] ?></td>
                <!-- <td style="border: none;">
                  <a class="disabled" style="color: gray;"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                </td>
                <td style="border: none;">
                  <a class="update_data disabled" style="color: gray;"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                </td> -->
                <!-- <td style="border: none;">
                  <a class="" style="color: red;" href="../phpsql/delete_data.php?id=<?= $row_weight['id_vegetableweight'] ?>&tb=tb_vegetableweight&idtb=id_vegetableweight&location=../php/ShowWeight.php"
                  onclick="Del(this.href);return false;"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                </td> -->
                <!-- <td style="border: none;">
                  <a class="update_data" style="color: orange; cursor: pointer;" id="<?= $row['id_vegetable']; ?>" data-bs-toggle="modal" data-bs-target="#update_data_Modal"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                </td> -->
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- ตารางน้ำหนักผัก end -->



  <script src="../navbar/navbar.js"></script>

</body>

<!-- Modal insert-->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">เพิ่มผัก</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">

        <form method="post" action="../phpsql/insert_vegatable.php" enctype="multipart/form-data">
          <!-- <label class="mb-2">ชื่อฟาร์ม: </label>
          <div class="alert alert-secondary" role="alert">
            <?php echo $_SESSION["farm_name"]; ?>
          </div> -->
          <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?= $re['id_farm'] ?>" hidden>
          <div class="row mt-2 mb-2">
            <div class="col">
              <label class="mb-2">ชื่อผัก : </label><span id="user-availability-status"></span>
              <input type="text" name="vegetable_name" id="vegetable_name" class="form-control" required oninput="checkAvailability()" placeholder="ป้อนชื่อผัก...">
            </div>
            <div class="col">
              <label class="mb-2">อายุผัก : </label>
              <input type="number" name="age_vegatable" id="age_vegatable" class="form-control" required min="0" placeholder="ป้อนจำนวนวัน...">
            </div>
          </div>
          <label class="mb-2">ปุ๋ย : </label>
          <select class="form-select mb-2" name="fertilizer" id="fertilizer" required>
            <option value=""> -- เลือกปุ๋ย ▼ -- </option>
            <?php
            $sql_fer = "SELECT * FROM tb_fertilizer ORDER BY 	fertilizer_name";
            $result_fer = mysqli_query($conn, $sql_fer);
            while ($row_fer = mysqli_fetch_array($result_fer)) {
            ?>
              <option value="<?= $row_fer['id_fertilizer'] ?>"><?= $row_fer['fertilizer_name'] ?></option>
            <?php
            }
            ?>
          </select>
          <div class="row mt-2 mb-2">
            <div class="col">
              <label>ราคาผัก :</label>
              <input type="number" name="vegetable_price" id="vegetable_price" class="form-control" required placeholder="ป้อนราคาผัก...">
            </div>
            <div class="col">
              <label>วันที่บันทึกราคา : </label>
              <input type="date" name="date_price" id="date_price" class="form-control" required placeholder="ป้อนวันที่...">
            </div>
          </div>

          <label class="mb-2">รูปภาพผัก : </label><br>
          <input class="mb-2 form-control" type="file" name="photo" id="photo" required>
          <div class="text-center">
            <img style="object-fit: cover; border-radius: 100px" width="200px" height="200px" id="previewImg" src="../img/emp.jpg">
          </div>
          <button type="submit" name="save1" id="save1" class="mt-2 btn btn-success">บันทึก</button>
          <button type="button" class="mt-2 btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
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
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">แก้ไขข้อมูลผัก</h5>
      </div>
      <div class="modal-body" id="info_update5">

        <? include '../phpsql/select_data_edit.php' ?>

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
      $.ajax({
        url: "../phpsql/select_data_edit.php",
        type: "POST",
        cache: false,
        data: {
          id: id
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


</html>