<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];
}


if (isset($_POST['id_veg_farm'])) {
  $id_veg_farm = $_POST['id_veg_farm'];
}

date_default_timezone_set('asia/bangkok');
$datenow = date("Y-m-d");

$sql1 = "SELECT * FROM tb_vegetable 
INNER JOIN tb_fertilizer ON tb_vegetable.id_fertilizer = tb_fertilizer.id_fertilizer 
WHERE id_vegetable = '$id' ";
$result1 = mysqli_query($conn, $sql1);
$rs1 = mysqli_fetch_array($result1);

$sql2 = "SELECT * FROM `tb_vegetableprice` as vp
INNER JOIN `tb_veg_farm`  as vf ON vf.id_veg_farm = vp.id_veg_farm 
INNER JOIN `tb_vegetable`as v on v.id_vegetable = vf.id_vegetable
WHERE v.id_vegetable = '$id' ";
$result2 = mysqli_query($conn, $sql2);
$rs2 = mysqli_fetch_array($result2);

$sql3 = "SELECT * FROM `tb_vegetableweight` as vw
INNER JOIN `tb_veg_farm`  as vf ON vf.id_veg_farm = vw.id_veg_farm 
INNER JOIN `tb_vegetable`as v on v.id_vegetable = vf.id_vegetable
WHERE v.id_vegetable = '$id' ";
$result3 = mysqli_query($conn, $sql3);
$rs3 = mysqli_fetch_array($result3);
?>

<form method="post" action="../phpsql/update_vegetable.php" enctype="multipart/form-data">
  <!-- <label class="mb-2">ชื่อฟาร์ม: </label>
          <div class="alert alert-secondary" role="alert">
            <?php echo $_SESSION["farm_name"]; ?>
          </div> -->
  <!-- <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?= $re['id_farm'] ?>" hidden> -->
  <input type="text" name="id_vegetable_edit" id="id_vegetable_edit" class="form-control" value="<?= $rs1['id_vegetable'] ?>" hidden>
  <input type="text" name="id_veg_farm" id="id_veg_farm" class="form-control" value="<?=  $id_veg_farm ?>" hidden>


  <div class="row mt-2 mb-2">
    <div class="col">
      <label>ชื่อผัก : </label><span id="vegeta-availability-status"></span>
      <input type="text" name="vegetable_name" id="vegetable_name" class="form-control" value="<?= $rs1['vegetable_name'] ?>" required oninput="checkDuplicate()" placeholder="ป้อนชื่อผัก...">
    </div>
    <div class="col">
      <label>อายุผัก : </label>
      <input type="number" name="age_vegatable_edit" id="age_vegatable_edit" class="form-control" value="<?= $rs1['vegetable_age'] ?>" required min="0" placeholder="ป้อนจำนวนวัน...">
    </div>
  </div>
  <label>ปุ๋ย : </label>
  <select class="form-select mb-2" name="fertilizer_edit" id="fertilizer_edit" required>
    <option value="<?= $rs1['id_fertilizer'] ?>"><?= $rs1['fertilizer_name'] ?></option>
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
      <input type="number" name="vegetable_price_edit" id="vegetable_price_edit" class="form-control" value="<?= $rs2['price'] ?>" required placeholder="ป้อนราคาผัก...">
    </div>
    <div class="col">
      <label>วันที่บันทึก : </label>
      <input type="date" name="date_edit" id="date_edit" class="form-control" value="<?php echo $datenow ?>" min="<?php echo $datenow ?>" required readonly placeholder="ป้อนวันที่...">
    </div>
  </div>
  <div class="row mt-2 mb-2">
    <div class="col">
      <label>จำนวนต้นต่อน้ำหนัก : </label><span id="user-availability-status"></span>
      <input type="number" name="amount_tree_edit" id="amount_tree_edit" class="form-control" value="<?= $rs3['amount_tree'] ?>" required min="0" placeholder="ป้อนจำนวนต่อน้ำหนัก...">
    </div>
    <div class="col">
      <label>น้ำหนักผัก : กก. </label>
      <input type="number" step="any" name="vegetableweight_edit" id="vegetableweight_edit" class="form-control" value="<?= $rs3['vegetableweight'] ?>" required min="0" placeholder="ป้อนน้ำหนัก...">
    </div>
  </div>
  <label class="mb-2">รูปภาพผัก : </label><br>
  <input class="mb-2 form-control" type="file" name="photo_edit" id="photo_edit" required>
  <div class="text-center">
    <img style="object-fit: cover; border-radius: 100px" width="200px" height="200px" name="previewImg_edit" id="previewImg_edit" src="../img/<?= $rs1['img_name'] ?>">
  </div>
  <button type="button" class="mt-2 btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
  <button type="submit" name="edit1" id="edit1" class="mt-2 btn btn-success">บันทึก</button>
</form>

<!-- Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script type="text/javascript">
  function checkDuplicate() {
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
        $("#vegeta-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#edit1").css("display", 'none');
        } else {
          $("#edit1").css({
            "display": 'block',
            "float": "right",
            "margin-right": "330px",
          });
        }
      }
    });
  }

  let photo_edit = document.getElementById('photo_edit');
  let previewImg_edit = document.getElementById('previewImg_edit');

  photo_edit.onchange = evt => {
    const [file] = photo_edit.files;
    if (file) {
      previewImg_edit.src = URL.createObjectURL(file);
    } else {
      alert("อัพโหลดรูป");
    }
  }

  function cancel() {
    window.location.reload();
  }
</script>