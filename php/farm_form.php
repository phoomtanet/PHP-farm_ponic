<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql_id = "SELECT id_user FROM `tb_user` WHERE user_name = '$user'";
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
  <title>Insert Farm First Time</title>
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
      เพิ่มฟาร์ม
    </div>
    <form name="farmfirst" method="post" action="../phpsql/insert_farm_first.php" enctype="multipart/form-data">
      <label class="mb-2">บัญชี : </label>
      <div class="alert alert-secondary" role="alert">
        <?php
        echo $_SESSION["user"];
        // unset($_SESSION["user"]);
        ?>
      </div>
      <input type="text" name="id_user" id="id_user" class="form-control" value="<?=$re['id_user']?>" hidden>
      <br>
      <label class="mb-2">ชื่อฟาร์ม : </label>
      <input type="text" name="farm_name" id="farm_name" class="form-control" required >
      <br> 
      <label class="mb-2">ที่อยู่ฟาร์ม : </label><br>
      <input type="text" name="location" id="location" class="form-control" required >
      <br>
      <p style="color: red; font-size: 13px;">*เนื่องจากคุณไม่มีโรงเรียนในระบบ กด 'ต่อไป' เพื่อเพิ่มโรงเรือน*</p>
      
      <button type="submit" class="btn btn-success">ต่อไป</button>
      <!-- <input class="btn btn-outline-warning" type="reset" value="Reset"> -->
      <!-- <a type="submit" class="btn btn-outline-danger" href="greenhouse_form.php" role="button">ต่อไป</a> -->
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