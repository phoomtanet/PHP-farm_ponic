


<?php
include '../Connect/conn.php';
include '../Connect/session.php';
//sdd
// if (isset($_GET[''])) {
//   $iduser = $_GET[''];
// }

$sql_id = "SELECT id_user FROM `tb_user` WHERE user_name = '$user'";
$result_sql_id = mysqli_query($conn, $sql_id);
$re = mysqli_fetch_array($result_sql_id);
?>
<style>
  .alert {
    margin-bottom: 0;
    padding: 0.5rem 0.5rem;
  }
</style>
<!-- Modal Form -->
<form name="farmfirst" method="post" id="insertdata" action="../phpsql/insert_farm.php" enctype="multipart/form-data">
      <label class="mb-2">บัญชี : </label>
      <div class="alert alert-secondary" role="alert">
        <?php
        echo $_SESSION["user"];
        // unset($_SESSION["user"]);
        ?>
      </div>
      <input type="text" name="id_user" id="id_user" class="form-control" value="<?=$re['id_user']?>" hidden>
      <br>
      <label class="mb-2">ชื่อฟาร์ม : </label><span id="user-availability-status"></span>
      <input type="text" name="farm_name" id="farm_name" class="form-control" required oninput="checkAvailability()">
      <br> 
      <label class="mb-2">ที่อยู่ฟาร์ม : </label><br>
      <input type="text" name="location" id="location" class="form-control" required >
      <br>      
      <button type="submit" id="save1" class="btn btn-success">บันทึก</button>
      <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
    </form>
<!-- End Modal From -->

<script type="text/javascript">
  function checkAvailability() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_farm_name.php",
      cache: false,
      data: {
        type: 1,
        farm_name: $("#farm_name").val(),
      },
      success: function(data) {
        $("#user-availability-status").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
            $("#save1").prop("disabled", true);
            $("#save1").css("background-color", "gray");
            $("#save1").css("border-color", "gray");
          } else {
            $("#save1").prop("disabled", false);
            $("#save1").css("background-color", "blue");
            $("#save1").css("border-color", "blue");
          }
      }
    });
  }

  function cancel() {
    $('#insertdata')[0].reset();
    $('#add_data_Modal').modal('hide');
  }
</script>