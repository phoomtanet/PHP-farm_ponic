<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

$itemsPerPage = 4;

$currentpage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($currentpage - 1) * $itemsPerPage;

$sql_plot = "SELECT *
FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
INNER JOIN tb_fertilizer as f on f.id_fertilizer = a.id_fertilizer
WHERE a.id_greenhouse = $id_greenhouse_session
ORDER BY LENGTH(a.plot_name), a.plot_name
LIMIT $itemsPerPage OFFSET $offset";
$result_plot = mysqli_query($conn, $sql_plot);



$totalRows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_plot WHERE id_greenhouse = $id_greenhouse_session"));
$totalPages = ceil($totalRows / $itemsPerPage);


?>
<!doctype html>


<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/index.css">
  <title>Bootstrap 5</title>
</head>


<body style=" background: #e5e5e7;">
  <?php include '../navbar/navbar.php'; ?>
  <script src="../script/check.js"></script>
  <!-- เมนูด้านข้าง ( Side Menu ) -->
  <div class="d-flex flex-column p-4 mt-1 text-white  bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
    <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
  </div>
  <!-- เนื้อหาหลัก -->

  <div class=" main-content-div  p-1 px-5 pt-5 mt-3" style="  text-align: center;  height: 100%;">
    <!-- <img src="../img/hidro.jpg" alt="รูปผัก" style="max-width: 100%; height: auto;"> -->
    <div class="main-content-div ">

      <div class=" d-flex flex-nowrap justify-content-between text-center mx-5 mt-4 ">
      <div >
      <img src="../img/barcoler.png" alt="" width="360px">
        </div> 
      <div>
          <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#add_plot" title="เพิ่มแปลงปลูก">
            <i class=" text-white fas fa-plus"> </i>
            <i class="text-white fas fa-inbox"> </i>
          </button>
        </div>
     
      </div>


      <?php include '../php/gui_plot.php'; ?>

    </div>
    <div class=" mt-5 d-flex justify-content-center ">      
      <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                <li class="page-item <?php echo ($currentpage == $page) ? 'active' : ''; ?>">
                  <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
    </div>

  </div>

  <script src="../navbar/navbar.js"></script>

  <?php
  function calculateNextharvestDate($planting_date, $vegetable_age)
  {
    // แปลงวันที่เพาะเป็นวัตถุ DateTime
    $plantingDateTime = new DateTime($planting_date);

    // คำนวณวันที่เก็บผักครั้งถัดไปโดยเพิ่มอายุของผักในวัน
    $harvestDateTime = clone $plantingDateTime;
    $harvestDateTime->modify("+$vegetable_age days");

    // คืนค่าวันที่เก็บผักในรูปแบบ d M y
    return $harvestDateTime->format('d M y');
  } ?>
</body>


<!-- ฟอร์ม เพิ่มแปลง -->
<?php
$sql_fer = "SELECT * FROM `tb_fertilizer` as a 
INNER JOIN tb_farm as b ON b.id_farm = a.id_farm 
INNER JOIN tb_user as c ON c.id_user = b.id_user 
WHERE b.id_farm=$id_farm_session";
$result_sql_fer = mysqli_query($conn, $sql_fer);
?>
<div class="modal fade" id="add_plot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light">เพิ่มแปลง</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <label style="text-align: left; display: block;">ชื่อแปลง:<span id="ets_plot"></span></label>
          <input type="text" name="nameplot" id="nameplot" class="form-control" required placeholder="ข้อมูลไม่เกิน 10 ตัวอักษร" oninput="checkname() " onkeyup="checkInput(this)">
          <label style="text-align: left; display: block;">ปุ๋ยที่ใช้ในแปลง :</label>
          <select class="form-select mb-2" name="fertilizer" id="fertilizer" required>
            <option value=""> -- เลือกปุ๋ย ▼ -- </option>
            <?php foreach ($result_sql_fer as $fer) {
              echo '<option value="' . $fer['id_fertilizer'] . '"   >' . $fer['fertilizer_name'] . '</option>';
            } ?>
          </select>
          <small class="text-muted ">* ต้องมีข้อมูลปุ๋ยก่อน.</small>

          <label style="text-align: left; display: block;">แถว(ด้านกว้าง) :</label>
          <input type="number" name="row" min="1" max="9999" class="form-control" placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
          <label style="text-align: left; display: block;">คอลัมน์(ด้านยาว) :</label>
          <input type="number" name="columne" class="form-control" min="1" max="9999" placeholder="ป้อนตัวเลข'ด้านยาว' ..." required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save" id="save1" class="btn btn-success" value="บันทึก"></input>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- ฟอร์ม แก้ไชแปลง -->

<div class="modal fade" id="edit_plot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light">แก้ไขแปลง</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <input hidden type="text" name="id_edit_plot" id="id_edit_plot" class="form-control">

          <label style="text-align: left; display: block;">ชื่อแปลง(ไม่เกิน 10 ตัวอักษร):<span id="ets_plotEdit"></span></label>
          <input type="text" name="edit_nameplot" width="100px" id="edit_nameplot" required class="form-control" oninput="checknameEdit()" onkeyup="checkInput(this)">
          <label style="text-align: left; display: block;">ปุ๋ยที่ใช้ในแปลง :</label>
          <select class="form-select mb-2" name="edit_fer" id="edit_fer" required>
            <?php foreach ($result_sql_fer as $fer) {
              echo '<option value="' . $fer['id_fertilizer'] . '">' . $fer['fertilizer_name'] . '</option>';
            } ?>
          </select>
          <label style="text-align: left; display: block;">แถว(ด้านยาว) :</label>
          <input type="number" name="edit_row" id="edit_row" min="1" max="999" class="form-control" required>
          <label style="text-align: left; display: block;">คอลัมน์(ด้านกว้าง) :</label>
          <input type="number" name="edit_col" id="edit_col" min="1" max="999" class="form-control" required>
          <!-- Other form fields -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="editplot" id="editplot" class="btn btn-warning" value="แก้ไข"></input>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- ฟอร์ม เก็บเกี่ยว -->
<div class="modal fade" id="add_harvest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light">บันทึกการเก็บเกี่ยว</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="../phpsql/insert_harvest.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <input type="hidden" name="id_plot_harvest" id="id_plot_harvest" class="form-control" required readonly>
          <input type="hidden" name="id_veg" id="id_veg" class="form-control" required readonly>
          <input type="hidden" name="id_planting" id="id_planting" class="form-control" required readonly>

          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="plot_harvest" id="plot_harvest" class="form-control" placeholder="ป้อนชื่อแปลง.." readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">ชื่อผัก :</label>
          <input type="text" name="veg_harvest" id="veg_harvest" class="form-control" placeholder="ป้อนตัวเลข'ด้านยาว' ..." readonly>

          <label style="text-align: left; display: block;">จำนวนผักที่ปลูก:</label>
          <input type="number" name="veg_planting_amont" id="veg_planting_amont" class="form-control" required readonly>

          <label id="label_num_harvest" style="text-align: left; display: block;">จำนวนผักที่เก็บเกี่ยว:</label>
          <input type="number" name="harvest_amount" id="harvest_amount" class="form-control" required oninput="checkValue()">
          <label style="text-align: left; display: block;">วันที่เก็บเกี่ยว:</label>
          <input type="date" name="harvest_date" id="harvest_date" class="form-control" required placeholder="วันที่เพาะเมล็ด" max="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="save_harvest" id="save_harvest" class="btn btn-success" value="บันทึก"></input>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- ให้ปุ๋ย -->
<div class="modal fade" id="add_fertilizer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light">บันทึกการให้ปุ่ย</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="../phpsql/insert_harvest.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
          <input type="hidden" name="id_fertilizationDate" id="id_fertilizationDate" class="form-control" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
          <input type="text" name="plot_fertilization" id="plot_fertilization" class="form-control" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
          <label style="text-align: left; display: block;">ปุ๋ยที่ให้:</label>
          <input type="text" name="name_fer" id="name_fer" class="form-control" readonly onBlur="checkAvailability()" onkeyup="check_char(this)">
      
          <label style="text-align: left; display: block;">วันที่ให้ปุ๋ย:</label>
          <input type="date" name="fertilizationdate" id="fertilizationdate" class="form-control" required placeholder="วันที่เพาะเมล็ด" max="<?php echo date('Y-m-d'); ?>">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
        <input type="submit" name="edit_fertilizationdate" id="edit_fertilizationdate" class="btn btn-success" value="บันทึก"></input>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  //วันที่ปัจจุบันในช่อง input
  let today = new Date().toISOString().slice(0, 10);
  let germinationDateInput = document.getElementById("harvest_date");
  germinationDateInput.value = today;
  let fertilizationdateInput = document.getElementById("fertilizationdate");
  fertilizationdate.value = today;
  // รีเฟรชหน้า
  function cancel() {
    window.location.reload();
  }
</script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.edit_plot');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {

        const data_edit_plot_name = button.getAttribute('data-edit_plot_name');
        const edit_plot_name = document.getElementById('edit_nameplot');
        edit_plot_name.value = data_edit_plot_name;

        const data_edit_plot_row = button.getAttribute('data-edit_plot_row');
        const edit_plot_row = document.getElementById('edit_row');
        edit_plot_row.value = data_edit_plot_row;


        const data_edit_plot_col = button.getAttribute('data-edit_plot_col');
        const edit_plot_col = document.getElementById('edit_col');
        edit_plot_col.value = data_edit_plot_col;

        const data_id_edit_plot = button.getAttribute('data-id_edit_plot');
        const id_edit_plot = document.getElementById('id_edit_plot');
        id_edit_plot.value = data_id_edit_plot;

        const data_id_edit_fer = button.getAttribute('data-id_edit_fer');
        const data_name_edit_fer = button.getAttribute('data-name_edit_fer');

        const editFerSelect = document.getElementById('edit_fer');


        for (let i = 0; i < editFerSelect.options.length; i++) {
          if (editFerSelect.options[i].value === data_id_edit_fer) {
            editFerSelect.selectedIndex = i;
            break;
          }
        }
        console.log(data_id_edit_fer + 'ชื่อ' + data_name_edit_fer);

      });
    });
  });


  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.add_fertilizer');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {

        const data_plot_name2 = button.getAttribute('data-plot_name2');
        const plot_name2 = document.getElementById('plot_fertilization');
        plot_name2.value = data_plot_name2;

        const data_id_fertilizationDate = button.getAttribute('data-id_fertilizationDate');
        const id_fertilizationDate = document.getElementById('id_fertilizationDate');
        id_fertilizationDate.value = data_id_fertilizationDate;
       
        const  data_name_fer= button.getAttribute('data-name_fer');
        const name_fer = document.getElementById('name_fer');
        name_fer.value = data_name_fer;
       

      });
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    const moveButtons = document.querySelectorAll('.add-harvest');

    moveButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        const data_plot_name = button.getAttribute('data-plot_name');
        const plot_nameField = document.getElementById('plot_harvest');
        plot_nameField.value = data_plot_name;

        const data_vegetable_name = button.getAttribute('data-vegetable_name');
        const vegetable_nameField = document.getElementById('veg_harvest');
        vegetable_nameField.value = data_vegetable_name;


        const data_vegetable_amount = button.getAttribute('data-vegetable_amount');
        const vegetable_amountField = document.getElementById('harvest_amount');
        vegetable_amountField.value = data_vegetable_amount;

        const data_planting_amount = button.getAttribute('data-vegetable_amount');
        const data_planting_amountField = document.getElementById('veg_planting_amont');
        data_planting_amountField.value = data_planting_amount;


        const data_id_plot = button.getAttribute('data-id_plot');
        const id_plotField = document.getElementById('id_plot_harvest');
        id_plotField.value = data_id_plot;

        const data_id_vegetable = button.getAttribute('data-id_vegetable');
        const id_vegetableield = document.getElementById('id_veg');
        id_vegetableield.value = data_id_vegetable;


        const data_id_plan = button.getAttribute('data-id_plan');
        const id_plan = document.getElementById('id_planting');
        id_plan.value = data_id_plan;
      });
    });
  });
</script>
<script>
  function checkValue() {


    var label = document.getElementById('label_num_harvest');
    var veg_planting_amont = parseInt(document.getElementById('veg_planting_amont').value);
    var num_harvest_amount = parseInt(document.getElementById('harvest_amount').value);

    if (veg_planting_amont < num_harvest_amount) {
      label.innerHTML = '<label class="text-danger" style="text-align: left; display: block;">จำนวนผักที่เก็บเกี่ยว มากกว่าที่ปลูก!!</label>';
      document.getElementById('save_harvest').style.display = 'none';
      if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default form submission
      }

    } else {
      label.innerHTML = '<label style="text-align: left; display: block;">จำนวนผักที่เก็บเกี่ยว:</label>';
      document.getElementById('save_harvest').style.display = 'block';

    }

  }

  function Del(mypage) {
    var agree = confirm("ข้อมูลประวัติการเก็บเกี่ยวของแปลงจะถูกลบไปด้วย คุณต้องการลบข้อมูลหรือไม่");
    if (agree) {
      window.location = mypage;
    }
  }



  function checkname() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability_vet.php",
      cache: false,
      data: {
        type: 'tb_plot',
        input_name: $("#nameplot").val(),
        where: 'plot_name',
      },
      success: function(data) {
        $("#ets_plot").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#save1").prop("disabled", true);
        } else {
          $("#save1").prop("disabled", false);

        }
      }
    });
  }

  function checknameEdit() {
    $.ajax({
      type: "POST",
      url: "../phpsql/check_availability_vet.php",
      cache: false,
      data: {
        type: 'tb_plot',
        input_name: $("#edit_nameplot").val(),
        where: 'plot_name',
      },
      success: function(data) {
        $("#ets_plotEdit").html(data);
        if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
          $("#editplot").prop("disabled", true);
        } else {
          $("#editplot").prop("disabled", false);

        }
      }
    });
  }
</script>

</html>