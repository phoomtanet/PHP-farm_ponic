<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
 
</head>
<body>
    <!-- ฟอร์ม เพิ่มแปลง -->
<div class="modal fade" id="add_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-dark ">
      <div class="modal-header text-center" style="background-color: #212529;">
        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">เพิ่มแปลง</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
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
        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="nameplot" id="username2" class="form-control" placeholder="ป้อนชื่อแปลง.." onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">แถว :</label>
          <input type="number" name="row" id="password2" class="form-control" placeholder="ป้อนตัวเลข'ด้านยาว' ...">
          <label style="text-align: left; display: block;">คอลัมน์:</label>
          <input type="number" name="columne" id="firstname" class="form-control" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
          <!-- Other form fields -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save" id="save1" class="btn btn-primary" value="ยืนยัน"></input>
      </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>