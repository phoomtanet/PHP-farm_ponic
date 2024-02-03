<?php
//เมื่อเพิ่มการอนุบาล  ให้เช็คว่าเต็มไหม  ถ้าเต็มให้เปลี่ยนสถานะ ********

session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

if (!isset($_SESSION['user'])) {
    header('Location: loginform.php');
    exit(); // ให้แน่ใจว่าไม่มีโค้ดเพิ่มเติมที่ทำงานหลัง header
}

$sql_plot_nursery = "SELECT a.id_plotnursery  ,a.plotnursery_name ,
 a.row  , a.column   , f.img_name ,f.vegetable_name , e.nursery_date ,e.nursery_amount ,e.id_nursery
 FROM `tb_plot_nursery` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_vegetable_nursery as e on a.id_plotnursery = e.id_plotnursery 
LEFT JOIN tb_veg_farm as vt on vt.id_veg_farm = e.id_veg_farm   
LEFT JOIN tb_vegetable as f on f.id_vegetable = vt.id_vegetable   

WHERE d.user_name = '$user' AND c.name_farm = '$farm_name' AND b.name_greenhouse = '$greenhouse_name'
ORDER BY LENGTH(a.plotnursery_name), a.plotnursery_name";

$result_plot__nursery = mysqli_query($conn, $sql_plot_nursery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Plot Nursery</title>
</head>

<body style=" background: #e5e5e7;">
    <?php include '../navbar/navbar.php'; ?>
    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
    </div>
    <!-- เนื้อหาหลัก -->
    <div class=" main-content-div  p-1 " style="  text-align: center;  height: 100%;">
        <div class="pt-5 main-content-div" style="text-align: center; align-items: center;  ">
            <div class="d-flex flex-nowrap justify-content-around text-center  ">
                <div>
                </div>
            </div>

            <div class="container" style="margin-top: 20px;">
                <table class="table table-hover table-bordered ">
                    <caption class="caption-top">ตารางแสดงข้อมูลการอนุบาล</caption>
                    <thead>
                        <th style="border: none;"> </th>
                        <th style="border: none;"> </th>
                        <th style="border: none;"> </th>
                        <th style="border: none;"> </th>
                        <th style="border: none;"> </th>
                        <th style="border: none;">
                        </th>
                        <th style="border: none; text-align: right;">

                            <button type="button" class="btn btn-primary" title="เพิ่มแปลงอนุบาล" data-bs-toggle="modal" data-bs-target="#add_plot_nursury">
                                <i class="fas fa-plus"></i> <i class="fas fa-inbox "></i>
                            </button>

                        </th>
                    </thead>
                    <thead class="table-dark">
                        <tr>
                            <th>ชื่อแปลง</th>
                            <th colspan="2">ผักอนุบาล</th>
                            <th>วันที่เพาะ</th>
                            <th>อายุผัก</th>
                            <th>จำนวนต้น</th>
                            <th class="text-nowrap">แก้ไข / ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currentPlotName = null;
                        foreach ($result_plot__nursery as $col) {

                            // แสดงชื่อแปลง แถวแรก
                            if ($col['plotnursery_name'] !== $currentPlotName) {
                                echo '<tr >';
                                echo '<th style="border: none;" ></th>';
                                echo '<th style="border: none;"></th>';
                                echo '<th style="border: none;"></th>';
                                echo '<th style="border: none;"></th>';
                                echo '<th style="border: none;"></th>';
                                echo '<th style="border: none;"></th>';
                                echo '<th style="border: none;"></th>';
                                echo ' </tr>';
                                // แสดงชื่อแปลงใหม่
                                $currentPlotName = $col['plotnursery_name'];

                                $nursery_amount_query = "SELECT SUM(a.nursery_amount) as total_nursery_amount
                                FROM `tb_vegetable_nursery` as a 
                                INNER JOIN tb_plot_nursery as b ON a.id_plotnursery = b.id_plotnursery
                                INNER JOIN tb_greenhouse as c on b.id_greenhouse = c.id_greenhouse 
                                INNER JOIN tb_farm as d on c.id_farm = d.id_farm 
                                INNER JOIN tb_user as f on d.id_user = f.id_user 
                                WHERE  f.user_name = '$user' AND d.id_farm = '$id_farm_session' 
                                AND c.id_greenhouse = '$id_greenhouse_session'  
                                AND  b.plotnursery_name = '$currentPlotName'";
                                $result_nursery_amount_query = mysqli_query($conn, $nursery_amount_query);
                                if ($result_nursery_amount_query) {
                                    $row_amount = mysqli_fetch_assoc($result_nursery_amount_query);
                                    $total_nursery_amount = $row_amount['total_nursery_amount'];  // จำนวนต้น ในแปลงอนุบาล
                                } else {
                                    $total_nursery_amount = 0; // ถ้าไม่มีผลลัพธ์หรือมีข้อผิดพลาดใน query
                                }
                                //จำนวนช่องที่ว่าง
                                $emp_slot = ($col['row'] * $col['column']) - $total_nursery_amount;

                                echo '<tr class="table-light"" >';
                                if ($emp_slot > 0) {
                                    echo '<td style="border: none;">
                                <a href="../php/move_germination.php?id_plotnursery=' . $col['id_plotnursery'] . '&emp_slot=' . $emp_slot  . '&plotnursery_name=' . $col['plotnursery_name'] . '" style="text-decoration: none; color: green;">
                                <button class="btn btn-success btn-sm">
                                <i class="text-nowrap">   <b>+'   . $currentPlotName  . '</button>
                                <br>
                                </a>
                         <span class="text-success" style="font-size: 13px;">' .  $emp_slot . 'ช่อง</span ></b></i> 
                                </td>';
                                } else {
                                    echo '<td ><button class="btn btn-danger btn-sm">
                                    <i class="text-nowrap">   <b>'   . $currentPlotName . '</button>
                                    <br>
                                    <span class="text-danger" style="font-size: 13px;">ช่องเต็ม</span ></b></i> 
                                    </td>';
                                }
                                if ($col['img_name']) {
                                    echo '<td ><img src="../img/' . $col['img_name'] . '" style="width: 40px; border-radius: 50px;"></td>';
                                    echo '<td>' . $col['vegetable_name'] . '</td>';
                                    echo '<td>' . date('d/m', strtotime($col['nursery_date'])) . '</td>';
                                    $nurseryDate = new DateTime($col['nursery_date']);
                                    $currentDate = new DateTime(); // วันที่ปัจจุบัน
                                    $diff = $nurseryDate->diff($currentDate);
                                    $age = $diff->format('%a'); // คำนวณอายุเป็นจำนวนวัน
                                    echo '<td>' . $age . ' วัน</td>';
                                    echo '<td>' . $col['nursery_amount'] . '</td>';

                                    echo '<td class="text-nowrap">';
                                echo'<i class="btn fas fa-edit edit-button2 text-warning" data-bs-toggle="modal" data-bs-target="#edit_nursery" 
                                data-id_nursery="' . $col['id_nursery'] . '"
                                data-vegetable_name="' . $col['vegetable_name'] . '"
                                data-nursery_date="' . $col['nursery_date'] . '"
                                data-nursery_amount="' . $col['nursery_amount'] . '"
                                data-emp_slot="' . $emp_slot+ $col['nursery_amount'] . '" >
                                </i>';

                                    echo '<a class="btn fa-regular fa-trash-alt text-danger " name="del_plotnursery" id="del_plotnursery" href="../phpsql/insert_plotnursery.php?id_nur=' . $col['id_nursery'] . '" onclick="Del(this.href); return false;"></a>                                 ';

                                    echo '</td>';
                                } else {
                                    
                                    echo '<td style="border: none; colspan="2" ">

                                     <i  class=" btn fas fa-edit  text-warning edit-button1 text-nowrap" data-bs-toggle="modal" data-bs-target="#edit_plot_nursery" 
                                    data-id_plotnursery="' . $col['id_plotnursery'] . '"
                                    data-plotnursery_name="' . $col['plotnursery_name'] . '"
                                    data-row="' . $col['row'] . '"
                                    data-column="' . $col['column'] . '">
                                    </i>
                                    <a class="btn fa-regular fa-trash-alt text-danger" name="del_plotnursery" id="del_plotnursery" href="../phpsql/insert_plotnursery.php?id_plot_nur=' . $col['id_plotnursery'] . '" onclick="Del(this.href); return false;"></a>
                                
                                    </td>';
                                    
                                    echo '<td  colspan="5" style="border: none;">ไม่มีการอนุบาล</th>';
                                    
                                    
                                    echo '</tr>';
                                }

                                echo '</tr>';
                            } else {
                                echo '<tr class="table-light"">';
                                echo '<td></td>';
                                echo '<td><img src="../img/' . $col['img_name'] . '" style="width: 40px; border-radius: 50px;"></td>';
                                echo '<td>' . $col['vegetable_name'] . '</td>';
                                echo '<td>' . date('d/m', strtotime($col['nursery_date'])) . '</td>';
                                $nurseryDate = new DateTime($col['nursery_date']);
                                $currentDate = new DateTime(); // วันที่ปัจจุบัน
                                $diff = $nurseryDate->diff($currentDate);
                                $age = $diff->format('%a'); // คำนวณอายุเป็นจำนวนวัน

                                echo '<td>' .   $age . ' วัน</td>';

                                echo '<td>' . $col['nursery_amount'] . '</td>';

                                echo '<td>';
                                
                              
                                echo'<i class="btn fas fa-edit edit-button2 text-warning" data-bs-toggle="modal" data-bs-target="#edit_nursery" 
                                data-id_nursery="' . $col['id_nursery'] . '"
                                data-vegetable_name="' . $col['vegetable_name'] . '"
                                data-nursery_date="' . $col['nursery_date'] . '"
                                data-nursery_amount="' . $col['nursery_amount'] . '"
                                data-emp_slot="' . $emp_slot+ $col['nursery_amount'] . '"
                                ></i>';

                                 echo '<a class="btn fa-regular fa-trash-alt text-danger" name="del_plotnursery" id="del_plotnursery" href="../phpsql/insert_plotnursery.php?id_nur=' . $col['id_nursery'] . '" onclick="Del(this.href); return false;"></a>                                 ';
                                echo '</td>';

                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="../navbar/navbar.js"></script>

</body>

<!-- modal add_plot_nursury -->
<div class="modal fade" id="add_plot_nursury" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-dark ">
            <div class="modal-header text-center" style="background-color: #212529;">
                <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">เพิ่มแปลงอนุบาล</h5>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_plotnursery.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                    <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
                    <input type="text" name="plotnursery_name" id="plotnursery_name" oninput="checkname()" required placeholder="ป้อนชื่อแแปลง" class="form-control">
                    <label style="text-align: left; display: block;">จำนวนแถว:</label>
                    <input type="text" name="row" id="row" class="form-control" required placeholder="แถว">
                    <label style="text-align: left; display: block;">จำนวนคอลัมน์:</label>
                    <input type="text" name="column" id="column" class="form-control" required placeholder="คอลัมน์">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="insert_plotnursery" id="insert_plotnursery" class="btn btn-primary" value="ยืนยัน"></input>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- modal add_plot_nursury -->

<!-- modal edit_plot_nursury -->
<div class="modal fade" id="edit_plot_nursery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-dark ">
            <div class="modal-header text-center" style="background-color: #212529;">
                <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">แก้ไขแปลงอนุบาล</h5>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_plotnursery.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                    <input type="hidden" name="id_plotnursery2" id="id_plotnursery2" required class="form-control">
                    <label style="text-align: left; display: block;">ชื่อแปลง:</label><span id="user-availability-status"></span>
                    <input type="text" name="plotnursery_name2" id="plotnursery_name2" required placeholder="ป้อนชื่อแแปลง" class="form-control">
                    <label style="text-align: left; display: block;">จำนวนแถว:</label>
                    <input type="text" name="row2" id="row2" class="form-control" required placeholder="แถว">
                    <label style="text-align: left; display: block;">จำนวนคอลัมน์:</label>
                    <input type="text" name="column2" id="column2" class="form-control" required placeholder="คอลัมน์">
            </div>
            <div class="modal-footer">
                <!-- <input type="submit" name="del_plotnursery" id="del_plotnursery" class="btn btn-danger" value="ลบแปลง"></input> -->

                <button type="button" class="btn btn-secondary" onclick="cancel()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="update_plotnursery" id="update_plotnursery" class="btn btn-primary" value="ยืนยัน"></input>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_nursery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-dark ">
            <div class="modal-header text-center" style="background-color: #212529;">
                <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">แก้ไขแปลงอนุบาล</h5>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_plotnursery.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                   
                <input type="hidden" name="id_nursery" id="id_nursery" required class="form-control">
                    <label style="text-align: left; display: block;">ชื่อผัก:</label><span id="user-availability-status"></span>
                  <input type="text" name="veg_name" id="veg_name"  readonly class="form-control">
                  <label style="text-align: left; display: block;">จำนวนช่องว่าง:</label>             
                  <input type="text" name="emp_slot" id="emp_slot" required readonly class="form-control">
                  <label  name="label_nursery_amount" id="label_nursery_amount" style="text-align: left; display: block;">จำนวนต้น:<span id="warning-message"></label>
                    <input type="number" name="nursery_amount" id="nursery_amount" oninput="check_amount()" class="form-control" required placeholder="จำนวนต้น">
  
                    <label style="text-align: left; display: block;">วันที่:</label>
                    <input type="date" name="nursery_date" id="nursery_date" class="form-control" requiredmax="<?php echo date('Y-m-d'); ?>">

                             </div>
                 <div class="modal-footer">
                <!-- <input type="submit" name="del_plotnursery" id="del_plotnursery" class="btn btn-danger" value="ลบแปลง"></input> -->

                <button type="button" class="btn btn-secondary" onclick="cancelAndReload()()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="update_nursery" id="update_nursery" class="btn btn-primary" value="ยืนยัน"></input>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- modal edit_plot_nursury -->

<script>
    //วันที่ปัจจุบันในช่อง input
    let today = new Date().toISOString().slice(0, 10);
    let germinationDateInput = document.getElementById("germination_date");
    germinationDateInput.value = today;

    // รีเฟรชหน้า
    function cancelAndReload() {
        window.location.reload();
    }

    function Del(mypage) {
        var agree = confirm("คุณต้องการลบข้อมูลหรือไม่");
        if (agree) {
            window.location = mypage;
        }
    }

    function checkname() {
        $.ajax({
            type: "POST",
            url: "../phpsql/check_availability.php",
            cache: false,
            data: {
                type: 'tb_plot_nursery',
                input_name: $("#plotnursery_name").val(),
                where: 'plotnursery_name',
            },
            success: function(data) {
                $("#user-availability-status").html(data);
                if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
                    $("#save2").css("display", 'none');
                } else {
                    $("#save2").css({
                        "display": 'block',
                        "float": "right",
                        "margin-right": "330px",
                    });
                }
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all elements with the class "move-button"
        const moveButtons = document.querySelectorAll('.edit-button1');
        // Add a click event listener to each button
        moveButtons.forEach(function(button) {
            button.addEventListener('click', function() {



                const id_plotnursery = button.getAttribute('data-id_plotnursery');
                const id_plotnurseryField = document.getElementById('id_plotnursery2'); 
                id_plotnurseryField.value = id_plotnursery;

                const plotnursery_name = button.getAttribute('data-plotnursery_name');
                const plotnursery_nameField = document.getElementById('plotnursery_name2'); 
                plotnursery_nameField.value = plotnursery_name;

                const row = button.getAttribute('data-row');
                const rowField = document.getElementById('row2'); 
                rowField.value = row;

                const column = button.getAttribute('data-column');
                const columnField = document.getElementById('column2'); 
                columnField.value = column;
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const moveButtons = document.querySelectorAll('.edit-button2');
        moveButtons.forEach(function(button) {
            button.addEventListener('click', function() {

                const veg_name = button.getAttribute('data-vegetable_name');
                const veg_nameField = document.getElementById('veg_name'); 
                veg_nameField.value = veg_name;

                const id_nursery = button.getAttribute('data-id_nursery');
                const id_nurseryField = document.getElementById('id_nursery'); 
                id_nurseryField.value = id_nursery;

                const nursery_date = button.getAttribute('data-nursery_date');
                const nursery_dateField = document.getElementById('nursery_date'); 
                nursery_dateField.value = nursery_date ;


                const nursery_amount = button.getAttribute('data-nursery_amount');
                const nursery_amountField = document.getElementById('nursery_amount'); 
                nursery_amountField.value = nursery_amount ;

                const emp_slot = button.getAttribute('data-emp_slot');
                const emp_slotField = document.getElementById('emp_slot'); 
                emp_slotField.value = emp_slot ;
             
            });
        });
    });


    function check_amount() {
 
    var nursery_amount = parseInt(document.getElementById('nursery_amount').value);
    var space = parseInt(document.getElementById('emp_slot').value);
    var warningMessage = document.getElementById('warning-message');
    var label = document.getElementById('label_nursery_amount');


    if (nursery_amount > space) {
      label.innerHTML = '<label id="label_nursery_amount" class="text-danger" style="text-align: left; display: block;">"จำนวนที่แก้ไขเกินจำนวนช่องว่าง!!!" </label';
      document.getElementById('update_nursery').style.display = 'none';
      // ซ่อนปุ่ม submit
    } else if(nursery_amount <= 0){
        label.innerHTML = '<label id="label_nursery_amount" class="text-danger" style="text-align: left; display: block;">"ข้อมูลไม่ถูกต้อง!!!" </label';
      document.getElementById('update_nursery').style.display = 'none';
 
    }
    else {
      document.getElementById('update_nursery').style.display = 'block'; // แสดงปุ่ม submit
      label.innerHTML = '<label  name="label_nursery_amount" id="label_nursery_amount" style="text-align: left; display: block;">จำนวนต้น:<span id="warning-message"></label>';
    }
  }
</script>

</html>