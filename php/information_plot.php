<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";
    $id_plot_data = $_GET['id_plot_data'];
    $name_plot = $_GET['plot_name'];
    $slot = $_GET['slot'];
$sql_plot_plan = "SELECT * FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_planting as e on a.id_plot = e.id_plot
LEFT JOIN tb_veg_farm as vf on vf.id_veg_farm = e.id_veg_farm   
LEFT JOIN tb_vegetable as f on f.id_vegetable = vf.id_vegetable   
LEFT JOIN tb_fertilizationdate as g on   g.id_plot = e.id_plot
WHERE a.id_plot = '$id_plot_data' GROUP BY e.id_planting";
$result_plan = mysqli_query($conn, $sql_plot_plan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu">
    </div>
    <div class="pt-5 main-content-div" style=" text-align: center;">

        <br>
        <div class="container">

            <div class="d-flex  flex-wrap justify-content-evenly">
                <?php foreach ($result_plan as $row) {
                    $thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                    $thaiMonth = $thaimonth[date('n', strtotime($row["planting_date"])) - 1];

                    $Date = new DateTime($row['planting_date']);
                    $currentDate = new DateTime(); // วันที่ปัจจุบัน
                    $diff = $Date->diff($currentDate);
                    $age = $diff->format('%a');

                    $planting_date = new DateTime($row['planting_date']);
                    $vegetable_age = new DateInterval('P' . $row['vegetable_age'] . 'D');
                    $date_harvest = $planting_date->add($vegetable_age)->format('Y-m-d');


                    $thaiMonth_harvest  = $thaimonth[date('n', strtotime($date_harvest)) - 1];
                    $thaiMonth_fer  = $thaimonth[date('n', strtotime($row["planting_date"])) - 1];

                    $fertilizationDate = $row['fertilizationDate'];

                    // แปลงวันที่เป็นวันที่แบบไทย
                    $thaiDate_fer =date('d', strtotime($fertilizationDate)) . ' ' . $thaimonth[date('n', strtotime($fertilizationDate)) - 1];

                ?>

                    <div class="  mx-5 secondary mb-2 ">
                        <table class="border">
                            <tr>
                                <th class="bg-secondary rounded-start">
                                    <div class="d-flex justify-content-start mx-3 my-2 text-light">
                                        <?= $row["vegetable_name"] ?>
                                    </div>
                                </th>
                                <th class="bg-secondary rounded-end">
                                    <div class="d-flex justify-content-end">
                                        <a class="mx-2" style="color: red;" href="../phpsql/sql_planting.php?id_plan=<?= $row['id_planting'] ?>&id_plot=<?= $row['id_plot'] ?>&plot_name=<?= $name_plot ?>&slot=<?= $slot ?>" onclick="Del(this.href);return false;">
                                            <i class="fa-regular fa-trash-can fa-xl"></i>
                                        </a>
                                        <a class="mx-2 edit-button" type="button" style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#update_data_Modal" data-vet_name="<?= $row["vegetable_name"] ?>" data-slot="<?= $slot ?> " data-amount="<?= $row["vegetable_amount"] ?>" data-date="<?= $row["planting_date"] ?> " data-date_fer="<?= $row["fertilizationDate"] ?> "><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                                    </div>
                                </th>

                            </tr>
                            <tr>
                                <td class="mt-3 " style="text-align: left;">
                                    <img src="../img/<?= $row['img_name'] ?>" class="rounded-bottom" style="width: 150px; ">
                                </td>
                                <td style="text-align: left; ">
                                    <p class="px-4 text-nowrap">
                                        อายุ <?= $age ?> วัน <br>
                                        จำนวน <?= $row['vegetable_amount'] ?> ต้น <br>
                                        วันที่เพาะ <?= date('d ', strtotime($row["planting_date"])) ?><?= $thaiMonth ?> <br>
                                        ให้ปุ๋ยล่าสุด <?= $thaiDate_fer  ?><br>
                                        วันเก็บเกี่ยว <?= date('d ', strtotime($date_harvest)) ?><?= $thaiMonth_harvest ?>
                                    </p>
                                </td>
                            </tr>


                        </table>
                    </div>
                <?php } ?>


            </div>
        </div>

        <div class="d-flex  justify-content-start mx-5">
            <a href="../php/index.php  " class="mx-5">กลับ</a>
        </div>
        <div class="modal fade" id="update_data_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border border-dark ">
                    <div class="modal-header text-center" style="background-color: #212529;">
                        <h5 class="modal-title mx-auto text-white" style="text-align: center;" id="staticBackdropLabel">แก้ไขการปลูก</h5>
                    </div>
                    <div class="modal-body">
                        <form action="../phpsql/insert_plot.php" method="post" id="insertregister" name="insertregister" enctype="multipart/form-data">
                            <label style="text-align: left; display: block;">ชื่อผัก:</label>
                            <input type="text" id="vet_name" name="vet_name" readonly class="form-control">

                            <label style="text-align: left; display: block;">จำนวนช่องว่าง:</label>
                            <input type="text" readonly id="amount_vet_emp" name="amount_vet_emp" class="form-control">

                            <label style="text-align: left; display: block;">จำนวนต้น:</label>
                            <input type="text" id="amount_vet" name="amount_vet" class="form-control" oninput="checkslot()">

                            <label style="text-align: left; display: block;">วันที่เพาะ:</label>
                            <input type="date" id="date_vet" name="date_vet" class="form-control" max="<?php echo date('Y-m-d'); ?>">

                            <label style="text-align: left; display: block;">วันที่ให้ปุ๋ย:</label>
                            <input type="date" name="date_fer" id="date_fer" class="form-control" required max="<?php echo date('Y-m-d'); ?>">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const moveButtons = document.querySelectorAll('.edit-button');

        moveButtons.forEach(function(button) {
            button.addEventListener('click', function() {

                const vet_name = button.getAttribute('data-vet_name');
                const edit_vet_name = document.getElementById('vet_name');
                edit_vet_name.value = vet_name;


                const slot = button.getAttribute('data-slot');
                const slot_var = document.getElementById('amount_vet_emp');
                slot_var.value = slot

                const vet_date = button.getAttribute('data-date');
                const edit_vet_date = document.getElementById('date_vet');
                const trimmed_date = vet_date.trim();
                edit_vet_date.value = trimmed_date;

                const vet_date_fer = button.getAttribute('data-date_fer');
                const edit_date_fer = document.getElementById('date_fer');
                const trimmed_date_fer = vet_date_fer.trim();
                edit_date_fer.value = trimmed_date_fer;


                console.log(vet_date);
                const vet_amount = button.getAttribute('data-amount');
                const edit_vet_amount = document.getElementById('amount_vet');
                edit_vet_amount.value = vet_amount;

                function checkslot() {


                }



            });
        });
    });


    function Del(mypage) {
        var agree = confirm("คุณต้องการลบข้อมูลหรือไม่");
        if (agree) {
            window.location = mypage;
        }
    }
</script>