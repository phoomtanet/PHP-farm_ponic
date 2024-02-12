<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql = "SELECT * FROM `tb_user` WHERE user_name = '$user'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>ShowUser</title>
</head>

<body>
    <div class="container mt-5">
        <form action="../phpsql/update_register.php" method="post" enctype="multipart/form-data">

            <div class="alert alert-dark text-center h2" role="alert">
                ข้อมูลผู้จัดการฟาร์ม
            </div>

            <div class="form-group" id="checkusername">
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <input type="text" name="iduser_edit" id="iduser_edit" class="form-control mb-2" value="<?= $row['id_user'] ?>" hidden>

                    <label> Username : </label><span id="user-availability-status"></span>
                    <input type="text" name="username_edit" id="username_edit" class="form-control mb-2"  oninput="checkAvailabilityUser()" value="<?php echo $_SESSION["user"] ?>" placeholder="ป้อนชื่อบัญชีมากกว่า 6 ตัวออักษร..." oninput="" onkeyup='check_char(this)'>

                    <div class="form-group">
                        <label> Password : </label>
                        <input type="password" name="password_edit" id="password_edit" class="form-control" value="<?= $row['password'] ?>" minlength="6" required placeholder="ป้อนรหัสผ่านมากกว่า 6 ตัวอักษร...">
                    </div>

                    <div class="row mt-2 mb-2">
                        <div class="col">
                            <div class="form-group">
                                <label> ชื่อ : </label>
                                <input type="text" name="firstname_edit" id="firstname_edit" class="form-control" value="<?= $row['f_name'] ?>" required placeholder="ป้อนชื่อ...">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label> นามสกุล : </label>
                                <input type="text" name="lastname_edit" id="lastname_edit" class="form-control" value="<?= $row['l_name'] ?>" required placeholder="ป้อนนามสกุล...">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>รูปภาพโปรไฟล์: </label><br>
                        <input class="mb-4 form-control" type="file" name="photo_edit" id="photo_edit" required>
                        <div class="text-center mb-2">
                            <img style="object-fit: cover; border-radius: 100px" width="200px" height="200px" id="previewImg_edit" src="../img/<?= $row['photo_name'] ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <a href="../php/index.php" type="button" class="btn btn-secondary">กลับ</a>
                <button type="submit" name="edit1" id="edit1" class="btn btn-warning">แก้ไขข้อมูล</button>

        </form>
    </div>
</body>

<script type="text/javascript">
     function checkAvailabilityUser() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability_vet.php",
      cache: false,
      data: {
        type: 'tb_user',
        input_name: $("#username_edit").val(),
        where: 'user_name',
      },
      success: function(data) {
        $("#user-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#edit1").prop("disabled", true);

        } else {
          $("#edit1").prop("disabled", false);
        }
      }
    });
  }
    
    
    
    
    
    function check_char(elm) {
        if (!elm.value.match(/^[a-z0-9]+$/i) && elm.value.length > 0) {
            alert('ไม่สามารถใช้ตัวอักษรพิเศษและภาษาไทยได้');
            elm.value = '';
            // } else if (elm.value.length > 0) {
            //   alert('Username ต้องมีมากกว่า 6 ตัวอักษร');
            //   elm.value = '';
        }
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
</script>

</html>