<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql_id = "SELECT id_farm FROM `tb_farm` WHERE name_farm  = '$farm_name'";
$result_sql_id = mysqli_query($conn, $sql_id);
$re = mysqli_fetch_array($result_sql_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/login.css">
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <title>Insert Greenhouse First Time</title>
</head>
<style>
  body {
    background: #9198e5;
  }

  .container {
    background: whitesmoke;
    border-radius: 15px;
    padding: 1px 20px 20px 20px;
  }

  .alert {
    margin-bottom: 0;
    padding: 0.5rem 0.5rem;
  }
</style>

<body>
  <div class="container mt-5">
    <div class="alert alert-primary h4 text-center mb-4 mt-4 " role="alert">
      เพิ่มโรงเรือน
    </div>
    <form name="farmfirst" method="post" action="../phpsql/insert_greenhouse_first.php" enctype="multipart/form-data">
      <label class="mb-2">ชื่อฟาร์ม : </label>
      <div class="alert alert-secondary" role="alert">
       <?php
        echo $farm_name;
        // unset($_SESSION["farm_name"]);
        ?>
      </div>
      <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?= $re['id_farm'] ?>" hidden>
      <br>
      <label class="mb-2">ชื่อโรงเรือน : </label>
      <input type="text" name="greenhoues_name" id="greenhoues_name" class="form-control" required>
      <br>
      <button type="submit" class="btn btn-success">บันทึก</button>
      <!-- <input class="btn btn-outline-warning" type="reset" value="Reset"> -->
      <!-- <a class="btn btn-outline-danger" href="greenhouse_form.php" role="button">ต่อไป</a> -->
    </form>
  </div>
</body>

<script type='text/javascript'>
  //คำสั่งห้ามป้อนอักษรพิเศษ
  function check_char(elm) {
    if (!elm.value.match(/^[ก-ฮa-z0-9]+$/i) && elm.value.length > 0) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
    }
  }
</script>

<script type='text/javascript'>
  //คำสั่งห้ามป้อนอักษรพิเศษ
  function check_number(elm) {
    if (!elm.value.match(/^[0-9]+$/i) && elm.value.length > 0) {
      //alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
    }
  }
  
</script>

</html>