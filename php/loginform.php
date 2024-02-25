<?php
session_start();
include '../Connect/conn.php';

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/login.css">
  <title>Login</title>
  <link href="login.css" rel="stylesheet">
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
</style>

<body>
<script src="../script/check.js"></script>
 
<div class="d-flex flex-wrap justify-content-center text-center  align-self-center  vh-100 p-3">
    <main class="form-signin">
      <form method="post" action="../phpsql/login_check.php" onsubmit="return login()">
        <img class="mb-4" src="../img/salad.jpg" alt="" height="400px">

        <div class="form-floating">
          <input name="user" type="text" class="form-control" id="username" required placeholder="name@example.com">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input name="pass" type="password" class="form-control" id="password" required placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
          <p style="color: red;">
            <?php
            if (isset($_SESSION["Error"])) {
              echo $_SESSION["Error"];
              unset($_SESSION["Error"]);
            }
            ?>
          </p>
        </div>
        <button name="Add" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Login</button>
        <div class="text-center mt-2">
          ถ้าคุณต้องการเป็นสมาชิก <a style="color: blue; cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#add_data_Modal">สมัครสมาชิก</a>?
        </div>
        <p class="mt-2 mb-3 text-muted"></p><a href="mailto:phoomtanet.in@rmuti.ac.th">หากพบปัญหาในการเข้าสู่ระบบ ติดต่อ email คลิกที่นี้!!! </a></p>
      </form>
    </main>
  </div>
</body>

<!-- Modal insert Username -->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-dark border-4">
      <div class="modal-header text-center">
        <h5 class="modal-title mx-auto" style="text-align: center;" id="staticBackdropLabel">การสมัครสมาชิก</h5>
      </div>
      <div class="modal-body">
        <?php if (isset($_SESSION['error_user'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error_user'];
            unset($_SESSION['error_user']);
            ?>
          </div>
        <?php } ?>
        <form action="../phpsql/insert_register.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">

          <div class="form-group" id="checkusername">
            <label> Username : </label><span id="user-availability-status"></span>
            <input type="text" name="username2" id="username2" class="form-control" onkeyup="checkInputUser(this)" minlength="6" required placeholder="ป้อนชื่อบัญชีมากกว่า 6 ตัวออักษร..." oninput="checkAvailability()" onkeyup='check_char(this)' </div>

            <div class="form-group">
              <label> Password : </label>
              <input type="password" name="password2" id="password2" class="form-control" onkeyup="checkInputUser(this)" minlength="6" required placeholder="ป้อนรหัสผ่านมากกว่า 6 ตัวอักษร...">
            </div>

            <div class="row mt-2 mb-2">
              <div class="col">
                <div class="form-group">
                  <label> ชื่อ : </label>
                  <input type="text" name="firstname" id="firstname" onkeyup="checkInputvet(this)" class="form-control" required placeholder="ป้อนชื่อ...">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label> นามสกุล : </label>
                  <input type="text" name="lastname" id="lastname" onkeyup="checkInputvet(this)" class="form-control" required placeholder="ป้อนนามสกุล...">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>รูปภาพโปรไฟล์: </label><br>
              <input class="mb-2 form-control" type="file" name="photo" id="photo" required>
              <div class="text-center mb-2">
                <img style="object-fit: cover; border-radius: 100px" width="200px" height="200px" id="previewImg" src="../img/emp.jpg">
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
            <input type="submit" name="save1" id="save1" class="btn btn-success" value="ยืนยันการสมัคร"></input>

        </form>
      </div>
    </div>
  </div>
  <!-- End Modal insert Username -->

  <script type="text/javascript">
    function checkAvailability() {
      $.ajax({
        type: "POST",
        url: "../phpsql/check_availability.php",
        cache: false,
        data: {
          type: 'tb_user',
          input_name: $("#username2").val(),
          where: 'user_name',
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
  </script>

</html>