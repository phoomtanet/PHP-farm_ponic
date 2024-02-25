<?php
session_start();

include '../Connect/session.php';
include '../Connect/conn.php';

$sql = "SELECT * FROM `tb_seed_germination` AS a 
INNER JOIN `tb_greenhouse` AS c ON c.id_greenhouse = a.id_greenhouse
INNER JOIN tb_farm as d ON  d.id_farm = c.id_farm
INNER JOIN tb_user as e on e.id_user = d.id_user
INNER JOIN tb_traysize AS f ON f.id_traysize = a.id_traysize
INNER JOIN  tb_veg_farm as g on g.id_veg_farm = a.id_veg_farm
INNER JOIN  tb_vegetable  as v on v.id_vegetable = g.id_vegetable
WHERE    c.id_greenhouse = '$id_greenhouse_session'
 ORDER BY c.id_greenhouse  , a.id_seed_germination   ASC";
$result = mysqli_query($conn, $sql);

$name_vegettable  = "SELECT a.vegetable_name , vf.id_veg_farm
FROM `tb_vegetable` as a 
INNER JOIN tb_veg_farm as vf ON vf.id_vegetable = a.id_vegetable
INNER JOIN  tb_farm as b  ON b.id_farm = vf.id_farm
INNER JOIN tb_user as c   ON b.id_user = c.id_user
WHERE   b.id_farm = '$id_farm_session'";
$result_vegettable = mysqli_query($conn, $name_vegettable);


$name_greenhouse = "SELECT a.id_greenhouse , a.name_greenhouse FROM `tb_greenhouse` as a 
INNER JOIN tb_farm as b  on a.id_farm = b.id_farm 
WHERE   b.id_farm = '$id_farm_session'";
$result_greenhouse = mysqli_query($conn, $name_greenhouse);

$name_traysize = "SELECT * FROM tb_traysize as a 
INNER JOIN tb_farm  as d on d.id_farm = a.id_farm
WHERE a.id_farm = '$id_farm_session'";
$result_traysize = mysqli_query($conn, $name_traysize);
?>

<!doctype html>
<html lang="en">
<style>

</style>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- เรียกใช้ ฺBootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <title>Show Germination</title>
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>
    <script src="../script/check.js"></script>

    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-4 mt-1 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu"></ul>
    </div>
    <!-- ตารางแปลงเพาะ -->
    <div class="pt-3 main-content-div  pt-5 mt-3" style=" text-align: center;">
        <div class="container" style="margin-top: 20px;">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-sl" data-bs-toggle="modal" data-bs-target="#add_germination" title="เพิ่มการเพาะเมล็ด">
                    <i class="fas fa-plus"> </i> <i class="fas fa-seedling"></i>
                </button>
            </div>
            <table class="table table-striped table-bordered">
                <caption class="caption-top">ตารางแสดงข้อมูลแปลงผักเพาะเม็ด </caption>
                <thead>
                    <th colspan="3" style="border: none;  text-align: left;">
                    </th>
                    </th>
                    <th style="border: none;">
                    <th style="border: none;">
                    <th style="border: none;">
                    <th style="border: none;">
                    <th style="border: none; text-align: right;">

                    </th>
                </thead>
                <thead class="table-dark">
                    <tr>
                        <th colspan="2">ชื่อผัก</th>
                        <th>ขนาดถาด</th>
                        <th>จำนวนถาด</th>
                        <th>วันที่เพาะ</th>
                        <th>อายุผัก</th>
                        <th>จำนวน</th>
                        <th>แก้ไข/ลบ</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $row) {
                        $germination_dateDate = strtotime($row["germination_date"]);
                        $currentDate = strtotime(date("Y-m-d"));
                        $dateDifference = date_diff(date_create(date("Y-m-d", $germination_dateDate)), date_create(date("Y-m-d", $currentDate)));
                        $daysDifference = $dateDifference->days;

                        $thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                        $thaiDate_get = date('d', strtotime($row['germination_date'])) . ' ' . $thaimonth[date('n', strtotime($row['germination_date'])) - 1] . ' ' . date('Y', strtotime($row['germination_date']));


                    ?>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <tr class="text-center">
                            <td class="text-center text-nowrap">
                                <img src="../img/<?php echo $row['img_name'] ?>" style="width: 50px; border-radius: 50px;">
                            </td>
                            <td class="text-center"><?= $row["vegetable_name"] ?></td>

                            <td class="text-center"><?= $row["size_name"] ?></td>
                            <td><?= $row["Amount_trays"] ?></td>
                            <td class="text-nowrap"><?= $thaiDate_get ?></td>
                            <td class="text-nowrap"><?= $daysDifference  . ' วัน' ?></td>
                            <td><?= $row["germination_amount"] ?></td>
                            <td class="text-nowrap">
                                <i class="btn fas fa-edit text-warning edit-button" data-bs-toggle="modal" data-bs-target="#edit_germination" data-id_seed_germination="<?= $row["id_seed_germination"] ?>" data-name_vegetable="<?= $row["vegetable_name"] ?>" data-id_veg_farm="<?= $row["id_veg_farm"] ?>" data-name_greenhouse="<?= $row['id_greenhouse'] ?>" data-Amount_germ="<?= $row["germination_amount"] ?>" data-germination_date="<?= $row["germination_date"] ?>" data-name_traysize="<?= $row["size_name"] ?>" data-id_traysize="<?= $row["id_traysize"] ?>"></i>
                                <a class="btn fa-regular fa-trash-alt text-danger" href="../phpsql/delete_data.php?id=<?= $row["id_seed_germination"] ?>&tb=tb_seed_germination&idtb=id_seed_germination&location=../php/show_germination.php" onclick="Del(this.href);return false;"></a>
                            </td>
                        </tr>
                    <?php
                    }
                    // mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- ตารางแปลงเพาะ -->

    <!-- ตารางถาดเพาะ -->
    <div class=" main-content-div" style=" text-align: center;">
        <div class="container" style="margin-top: 50px;">
            <div class="d-flex justify-content-end mt-5">

                <button type="button" class="btn btn-primary btn-sl" data-bs-toggle="modal" data-bs-target="#add_traysize" title="เพิ่มถาดเพาะ">
                    <i class="fas fa-plus"></i> <i class="fas fa-inbox"></i>
                </button>
            </div>
            <table class="table table-striped table-bordered">
                <caption class="caption-top">ตารางแสดงข้อมูลถาดเพาะ </caption>
                <thead>
                    <th colspan="3" style="border: none;  text-align: left;">
                    </th>

                    <th style="border: none; text-align: right;">

                    </th>
                </thead>
                <thead class="table-dark">
                    <tr>

                        <th>ชื่อไซต์</th>
                        <th>แถวถาดเพาะ</th>
                        <th>คอลัมน์ถาดเพาะ</th>
                        <th>แก้ไข/ลบ</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result_traysize as $row) {
                    ?>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <tr>

                            <td><?= $row["size_name"] ?></td>
                            <td><?= $row["row_tray"] ?></td>
                            <td><?= $row["column_tray"] ?></td>
                            <td class="text-nowrap">
                                <i class="btn fas fa-edit text-warning edit-button_tray" data-bs-toggle="modal" data-id_traysize="<?= $row['id_traysize'] ?>" data-size_name="<?= $row['size_name'] ?>" data-row_tray="<?= $row['row_tray'] ?>" data-column_tray="<?= $row['column_tray'] ?>" data-bs-target="#edit_traysize"></i>
                                <?php
                                $sql_del_tray = "SELECT * FROM `tb_traysize` as ts 
                                INNER JOIN tb_farm as f on f.id_farm = ts.id_farm
                                INNER JOIN tb_seed_germination as sg on sg.id_traysize = ts.id_traysize
                                WHERE f.id_farm = '$id_farm_session' AND ts.size_name = '" . $row["size_name"] . "'";
                                $result_check_tray = mysqli_query($conn,  $sql_del_tray);
                                $numColumns = mysqli_num_rows($result_check_tray);
                                if (($numColumns > 0)) {
                                ?>
                                    <a class="btn disabled fa-regular fa-trash-alt " style="color: gray;"></a>
                                <?php } else { ?>
                                    <a class="btn fa-regular fa-trash-alt text-danger" href="../phpsql/delete_data.php?id=<?= $row["id_traysize"] ?>&tb=tb_traysize&idtb=id_traysize&location=../php/show_germination.php" onclick="Del(this.href);return false;"></a>
                                <?php  } ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- ตารางถาดเพาะ -->

    <script src="../navbar/navbar.js"></script>

</body>


<div class="modal fade" id="add_germination" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-light">เพิ่มการเพาะเมล็ด</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_germination.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                    <label style="text-align: left; display: block;">ชื่อโรงเรือน:</label>

                    <input value="<?php echo htmlspecialchars($greenhouse_name, ENT_QUOTES, 'UTF-8'); ?>" type="text" name="name_greenhouse" readonly id="name_greenhouse" class="form-control" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
                    <label style="text-align: left; display: block;">ชื่อผัก:</label>
                    <select name="name_vegetable" id="name_vegetable" class="form-control" required>

                        <option value="" disabled selected> -- เลือกผัก -- ▼</option>
                        <?php foreach ($result_vegettable as $col) {
                            echo '<option value="' . $col['id_veg_farm'] . '"   >' . $col['vegetable_name'] . '</option>';
                        } ?>
                    </select>
                    <label style="text-align: left; display: block;">ขนาดถาดเพาะ:</label>
                    <select name="name_traysize" id="name_traysize" class="form-control" required>
                        <option value="" disabled selected> -- เลือกขนาดถาดเพาะ -- ▼</option>
                        <?php foreach ($result_traysize as $col_traysize) {
                            echo '<option value="' . $col_traysize['id_traysize'] . '"   >' . $col_traysize['size_name'] . '</option>';
                        } ?>
                    </select>
                    <small class="text-muted">* เพิ่มข้อมูลถาดเพาะก่อน.</small>

                    <label style="text-align: left; display: block;">จำนวนถาดเพาะ:</label>
                    <input type="number" name="Amount_trays" id="Amount_trays" class="form-control" min="1" max="9999" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
                    <label style="text-align: left; display: block;">วันที่เพาะเมล็ด:</label>
                    <input type="date" name="germination_date" id="germination_date" class="form-control" required placeholder="วันที่เพาะเมล็ด" max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cancelAndReload()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="save" id="save" class="btn btn-success" value="ยืนยัน"></input>
            </div>
            </form>
        </div>
    </div>
</div>
</div>







<!-- insert traysize -->
<div class="modal fade" id="add_traysize" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-light">เพิ่มถาดเพาะ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_germination.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                    <input type="text" name="id_farm1" id="id_farm1" class="form-control" value="<?php echo $id_farm_session ?>" hidden>
                    <label style="text-align: left; display: block;">ชื่อโรงเรือน:</label>

                    <input value="<?php echo htmlspecialchars($greenhouse_name, ENT_QUOTES, 'UTF-8'); ?>" type="text" name="" readonly id="" class="form-control" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
                    <label style="text-align: left; display: block;">ชื่อไซร์ถาด:</label><span id="traysize-availability-status"></span>
                    <input type="text" name="size_name" id="size_name" class="form-control" onkeyup="checkInputTray(this)" oninput="checkname()" required placeholder="ป้อนชื่อไซร์ถาด...">
                    <label style="text-align: left; display: block;">แถวถาดเพาะ:</label>
                    <input type="number" name="amount_row" id="amount_row" class="form-control" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
                    <label style="text-align: left; display: block;">คอลัมน์เพาะเมล็ด:</label>
                    <input type="number" name="amount_column" id="amount_column" class="form-control" required placeholder="ป้อนตัวเลข'ด้านยาว' ...">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cancelAndReload()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="save2" id="save2" class="btn btn-success" value="ยืนยัน"></input>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- insert traysize -->



<!-- edit germination -->
<div class="modal fade" id="edit_germination" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-light">แก้ไขการเพาะเมล็ด</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_germination.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="id_seed_germination" id="id_seed_germination" class="form-control" hidden>
                    <label style="text-align: left; display: block;">ชื่อโรงเรือน:</label>
                    <input value="<?php echo htmlspecialchars($greenhouse_name, ENT_QUOTES, 'UTF-8'); ?>" type="text" name="" id="" readonly class="form-control" required placeholder="<? echo $greenhouse_name ?>">
                    <input value="<?php echo htmlspecialchars($greenhouse_name, ENT_QUOTES, 'UTF-8'); ?>" type="text" name="name_greenhouse2" id="name_greenhouse2" readonly class="form-control" required hidden>
                    <label style="text-align: left; display: block;">ชื่อผัก:</label>
                    <select name="name_vegetable2" id="name_vegetable2" class="form-control" required>
                        <?php foreach ($result_vegettable as $col) {
                            echo '<option value="' . $col['id_veg_farm'] . '"   >' . $col['vegetable_name'] . '</option>';
                        } ?>

                    </select>

                    <label style="text-align: left; display: block;">จำนวนการเพาะ:</label>
                    <input type="number" name="am_germ" id="am_germ" min="1" max="999999" class="form-control" required placeholder="จำนวนการเพาะเมล็ด">

                    <label style="text-align: left; display: block;">วันที่เพาะเมล็ด:</label>
                    <input type="date" name="germination_date2" id="germination_date2" class="form-control" required placeholder="วันที่เพาะเมล็ด" max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cancelAndReload()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="edit" id="edit" class="btn btn-primary" value="แก้ไข"></input>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit germination -->

<!-- edit traysize -->
<div class="modal fade" id="edit_traysize" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-dark ">
            <div class="modal-header text-center" style="background-color: #212529;">
                <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">เพิ่มถาดเพาะ</h5>
            </div>
            <div class="modal-body">
                <form action="../phpsql/insert_germination.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                    <input type="text" name="id_farm2" id="id_farm2" class="form-control" value="<?php echo $id_farm_session ?>" hidden>
                    <input type="text" name="id_name_size" id="id_name_size" class="form-control" hidden>
                    <label style="text-align: left; display: block;">ชื่อโรงเรือน:</label>

                    <input value="<?php echo htmlspecialchars($greenhouse_name, ENT_QUOTES, 'UTF-8'); ?>" type="text" name="" readonly id="" class="form-control" required>
                    <label style="text-align: left; display: block;">ชื่อไซร์ถาด:</label><span id="span_edit"></span>
                    <input type="text" name="name_size2" id="name_size2" onkeyup="checkInputTray(this)" class="form-control" required placeholder="ป้อนชื่อไซร์ถาด..." oninput="checknameeEdit()">
                    <label style="text-align: left; display: block;">แถวถาดเพาะ:</label>
                    <input type="number" name="amount_row2" id="amount_row2" class="form-control" min="1" max="99999" required placeholder="ป้อนตัวเลข'ด้านกว้าง' ...">
                    <label style="text-align: left; display: block;">คอลัมน์เพาะเมล็ด:</label>
                    <input type="number" name="amount_column2" id="amount_column2" class="form-control" min="1" max="99999" required placeholder="ป้อนตัวเลข'ด้านยาว' ...">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cancelAndReload()" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" name="edit2" id="edit2" class="btn btn-primary" value="แก้ไข"></input>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit traysize -->



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
        console.log("por");
        $.ajax({
            type: "POST",
            url: "../phpsql/check_availability_vet.php",
            cache: false,
            data: {
                type: 'tb_traysize',
                input_name: $("#size_name").val(),
                where: 'size_name',
            },
            success: function(data) {
                $("#traysize-availability-status").html(data);
                if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
                    $("#save2").prop("disabled", true);

                } else {
                    $("#save2").prop("disabled", false);

                }
            }
        });
    }

    function checknameeEdit() {
        $.ajax({
            type: "POST",
            url: "../phpsql/check_availability_vet.php",
            cache: false,
            data: {
                type: 'tb_traysize',
                input_name: $("#name_size2").val(),
                where: 'size_name',
            },
            success: function(data) {
                $("#span_edit").html(data);
                if (data.indexOf("ถูกใช้ไปแล้ว") !== -1) {
                    $("#edit2").prop("disabled", true);

                } else {
                    $("#edit2").prop("disabled", false);

                }
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const moveButtons = document.querySelectorAll('.edit-button');
        moveButtons.forEach(function(button) {
            button.addEventListener('click', function() {


                const name_greenhouse = button.getAttribute('data-name_greenhouse');
                const name_greenhouseField = document.getElementById('name_greenhouse2');
                name_greenhouseField.value = name_greenhouse;

                const name_vegetable = button.getAttribute('data-name_vegetable');
                const id_veg_farm = button.getAttribute('data-id_veg_farm');
                const name_vegetableField = document.getElementById('name_vegetable2');

                for (let i = 0; i < name_vegetableField.options.length; i++) {
                    if (name_vegetableField.options[i].value === id_veg_farm) {
                        name_vegetableField.selectedIndex = i;
                        break;
                    }
                }
                const data_Amount_germ = button.getAttribute('data-Amount_germ');
                const am_germ_Field = document.getElementById('am_germ');
                am_germ_Field.value = data_Amount_germ;

                const id_seed_germination = button.getAttribute('data-id_seed_germination');
                const id_seed_germinationField = document.getElementById('id_seed_germination');
                id_seed_germinationField.value = id_seed_germination;


                const germination_date = button.getAttribute('data-germination_date');
                const germination_dateField = document.getElementById('germination_date2');
                germination_dateField.value = germination_date;
                console.log("วันที่");


            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const moveButtons = document.querySelectorAll('.edit-button_tray');
        moveButtons.forEach(function(button) {
            button.addEventListener('click', function() {

                const id_traysize2 = button.getAttribute('data-id_traysize');
                const id_name_sizeField = document.getElementById('id_name_size');
                id_name_sizeField.value = id_traysize2;

                const size_name = button.getAttribute('data-size_name');
                const size_nameField = document.getElementById('name_size2');
                size_nameField.value = size_name;

                const row_tray = button.getAttribute('data-row_tray');
                const row_trayField = document.getElementById('amount_row2');
                row_trayField.value = row_tray;

                const column_tray = button.getAttribute('data-column_tray');
                const column_trayField = document.getElementById('amount_column2');
                column_trayField.value = row_tray;
            });
        });
    });
</script>

</html>