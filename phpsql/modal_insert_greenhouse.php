


<?php
include '../Connect/conn.php';
include '../Connect/session.php';
//sdd
// if (isset($_GET[''])) {
//   $iduser = $_GET[''];
// }

$sql_id = "SELECT id_farm FROM `tb_farm` WHERE name_farm = '$farm_name'";
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
<form name="farmfirst" method="post" id="insertdata" action="../phpsql/insert_greenhouse.php" enctype="multipart/form-data">
      <label class="mb-2">ชื่อฟาร์ม: </label>
      <div class="alert alert-secondary" role="alert">
        <?php
        echo $_SESSION["farm_name"];
        // unset($_SESSION["user"]);
        ?>
      </div>
      <input type="text" name="id_farm" id="id_farm" class="form-control" value="<?=$re['id_farm']?>" hidden>
      <br>
      <label class="mb-2">ชื่อโรงเรือน : </label><span id="user-availability-status"></span>
      <input type="text" name="greenhouse_name" id="greenhouse_name" class="form-control" required oninput="checkAvailability()">
      <br>      
      <button type="submit" id="save1" class="btn btn-success">บันทึก</button>
      <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
    </form>
<!-- End Modal From -->

<script type="text/javascript">
  function checkAvailability() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_greenhouse_name.php",
      cache: false,
      data: {
        type: 1,
        greenhouse_name: $("#greenhouse_name").val(),
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