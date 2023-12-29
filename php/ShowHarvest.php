<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: loginform.php');
    exit(); // ให้แน่ใจว่าไม่มีโค้ดเพิ่มเติมที่ทำงานหลัง header
}

include '../Connect/conn.php';
include '../Connect/session.php';

$sql_harvest = "SELECT p.plot_name, v.vegetable_name,v.img_name ,h.harvestdate, h.harvest_amount , f.name_farm
FROM `tb_harvest` AS h  
INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm
INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
INNER JOIN tb_farm AS f ON f.id_farm = vf.id_farm
INNER JOIN tb_greenhouse as g on g.id_greenhouse = p.id_greenhouse
WHERE g.id_greenhouse = $id_greenhouse_session
  AND h.harvestdate BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE();";
$result_harvest = mysqli_query($conn, $sql_harvest);



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>
    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">


        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu">

    </div>
    <div class="pt-5 main-content-div" style=" text-align: center;">
        <div class="container" style="margin-top: 20px;">
            <table class="table table-striped table-bordered">
                <caption class="caption-top">ตารางแสดงข้อมูลการเก็บเกี่ยวย้อนหลัง 30 วัน </caption>
                <thead>
                    <th colspan="3" style="border: none;  text-align: left;">
                        <p class="h5"> โรงเรือน <?php echo "$greenhouse_name" ?> </p>
                    </th>
                    </th>
                    <th style="border: none;">
                    <th style="border: none; text-align: right;">
                       
                    </th>
                </thead>
                <thead class="table-dark">
                    <tr>
                        <th>แปลง</th>
                        <th colspan="2">ชื่อผัก</th>
                        <th>จำนวน</th>
                        <th>วันที่เก็บเกี่ยว</th>
                 
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result_harvest as $row) {
                     
                    ?>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                      
                        <tr class="text-center">

                            <td class="text-center"><?= $row["plot_name"] ?></td>

                            <td class="text-center">
                                <img src="../img/<?php echo $row['img_name'] ?>" style="width: 50px; border-radius: 50px;">
                            </td>


                            <td class="text-center"><?= $row["vegetable_name"] ?></td>
                            <td><?= $row["harvest_amount"] ?></td>
                            <td><?= date('d / m', strtotime($row["harvestdate"])) ?></td>



                        </tr>
                    <?php
                    }
                    // mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../navbar/navbar.js"></script>


</body>

</html>