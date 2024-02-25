<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';
$thaiDate_front = '';
$thaiDate_back = '';


if (!isset($_GET['frontDate']) && !isset($_GET['backDate'])) {
    $frontDate = '';
    $backDate =  '';
    $sql_harvest = "
    SELECT p.plot_name, v.vegetable_name, v.img_name, h.harvestdate, h.harvest_amount, f.name_farm
    FROM `tb_harvest` AS h  
    INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
    INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm
    INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
    INNER JOIN tb_farm AS f ON f.id_farm = vf.id_farm
    INNER JOIN tb_greenhouse as g ON g.id_greenhouse = p.id_greenhouse
    WHERE g.id_greenhouse = $id_greenhouse_session
    ORDER BY h.harvestdate DESC;";

    $result_harvest = mysqli_query($conn, $sql_harvest);
    $sql_harvest = "SELECT v.vegetable_name, SUM(h.harvest_amount) AS total_amount
FROM tb_harvest AS h
INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
INNER JOIN tb_farm AS f ON f.id_farm = g.id_farm
INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm
INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
WHERE g.id_greenhouse = '$id_greenhouse_session'
GROUP BY v.vegetable_name";



    $rs_h_veg = mysqli_query($conn, $sql_harvest);
    $data_nh_veg = array();
    $data_ch_veg = array();

    while ($row_h_veg = $rs_h_veg->fetch_assoc()) {
        $data_nh_veg[] = $row_h_veg['total_amount'];
        $data_ch_veg[] = $row_h_veg['vegetable_name'];
    }
} else {
    // $frontDate = '2024-02-08';
    // $backDate = '2024-02-16';

    $frontDate = $_GET['frontDate'];
    $backDate = $_GET['backDate'];

    $sql_harvest = "
    SELECT p.plot_name, v.vegetable_name, v.img_name, h.harvestdate, h.harvest_amount, f.name_farm
    FROM `tb_harvest` AS h  
    INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
    INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm
    INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
    INNER JOIN tb_farm AS f ON f.id_farm = vf.id_farm
    INNER JOIN tb_greenhouse as g ON g.id_greenhouse = p.id_greenhouse
    WHERE g.id_greenhouse = $id_greenhouse_session
        AND h.harvestdate BETWEEN '$frontDate' AND '$backDate'
    ORDER BY h.harvestdate DESC;";


    $result_harvest = mysqli_query($conn, $sql_harvest);
    $sql_harvest = "SELECT v.vegetable_name, SUM(h.harvest_amount) AS total_amount
FROM tb_harvest AS h
INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
INNER JOIN tb_farm AS f ON f.id_farm = g.id_farm
INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm
INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
WHERE g.id_greenhouse = '$id_greenhouse_session' AND h.harvestdate BETWEEN  '$frontDate' AND '$backDate'
GROUP BY v.vegetable_name";



    $rs_h_veg = mysqli_query($conn, $sql_harvest);
    $data_nh_veg = array();
    $data_ch_veg = array();

    while ($row_h_veg = $rs_h_veg->fetch_assoc()) {
        $data_nh_veg[] = $row_h_veg['total_amount'];
        $data_ch_veg[] = $row_h_veg['vegetable_name'];
    }

    $thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $thaiDate_front = ' วันที่ ' . date('d', strtotime($frontDate)) . ' ' . $thaimonth[date('n', strtotime($frontDate)) - 1] . ' ' . date('Y', strtotime($frontDate)) . ' ถึง ';
    $thaiDate_back = date('d', strtotime($backDate)) . ' ' . $thaimonth[date('n', strtotime($backDate)) - 1] . ' ' . date('Y', strtotime($backDate));
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .table-header-center th {
        text-align: center;
    }
</style>

<body>
    <?php include '../navbar/navbar.php'; ?>
    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-4 mt-1 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">


        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu">

    </div>
    <div class="pt-5  main-content-div  pt-5 mt-3 justify-content-center " style=" text-align: center;">


        <div class="d-flex justify-content-center mx-5 my-2 ">
            <div id="dChart_har" style="width: 400px; height: 250px;"> </div>
        </div>
        <div class="mt-5  mb-2">

            <form action="../php/ShowHarvest.php" method="GET" class="d-flex justify-content-center align-items-center">
                <span>การเก็บเกี่ยววันที่</span>
                <input type="date" id="frontDate" name="frontDate" style="width: 130px; height: 32px;" class="mx-2 " value="<?= $frontDate ?>" max="<?php echo date('Y-m-d') ?>"> <span>ถึง</span>
                <input type="date" id="backDate" name="backDate" style="width: 130px; height: 32px;" class="mx-2" value="<?= $backDate ?>" max="<?php echo date('Y-m-d') ?>">
                <!-- <input type="submit" class="glyphicon glyphicon-search " value="ค้นหา"> -->
                <span><button id="bt_date" class="btn btn btn-outline-dark btn-sm"> <i class="fas fa-search "></i></button></span>

            </form>
        </div>
        <div><span id="err"></span></div>
    </div>
    <div class="container mt-1">
        <table class="table table-striped table-bordered">
            <caption class="caption-top">ตารางแสดงข้อมูลการเก็บเกี่ยว <b><?= $thaiDate_front . '' . $thaiDate_back ?></b> </caption>
            <thead>
                <th colspan="3" style="border: none;  text-align: left;">
                    <p class="h5"> โรงเรือน <?php echo "$greenhouse_name" ?> </p>
                </th>

                <th style="border: none;"></th>
                <th style="border: none; text-align: right;"></th>

                </th>
            </thead>
            <thead class="table-dark table-header-center">
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
                foreach ($result_harvest  as $row) {

                    $thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

                    $thaiDate_har = date('d', strtotime($row['harvestdate'])) . ' ' . $thaimonth[date('n', strtotime($row['harvestdate'])) - 1] . ' ' . date('Y', strtotime($row['harvestdate']));




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
                        <td><?= $thaiDate_har  ?></td>



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


    <script>
        window.onload = function() {

           var f_date = document.getElementById("frontDate").value;
           var b_date = document.getElementById("backDate").value;
            var myButton = document.getElementById("bt_date");
            console.log(f_date);
            console.log(b_date);
            if(f_date == '' && b_date == ''){
                myButton.disabled = true;

            }else{
                myButton.disabled = false;
            }

        };



        document.addEventListener('DOMContentLoaded', function() {
            var frontDateInput = document.getElementById('frontDate');
            var backDateInput = document.getElementById('backDate');
            var errSpan = document.getElementById("err");
            var myButton = document.getElementById("bt_date");
            frontDateInput.addEventListener('input', function() {
                if (frontDateInput.value > backDateInput.value && frontDateInput.value > 0) {
                    errSpan.innerHTML = "โปรดป้อน วันที่เริ่มต้นให้น้อยกว่าวันที่สิ้นสุด";
                    errSpan.style.color = 'red';
                    myButton.disabled = true;
                } else {
                    myButton.disabled = false;
                    errSpan.innerHTML = '';
                }
            });
            backDateInput.addEventListener('input', function() {
                if (frontDateInput.value > backDateInput.value) {
                    errSpan.innerHTML = "โปรดป้อน วันที่เริ่มต้นให้น้อยกว่าวันที่สิ้นสุด";
                    errSpan.style.color = 'red';
                    myButton.disabled = true;

                    
                } else {
                    myButton.disabled = false;
                    errSpan.innerHTML = '';
                }
            });

        });

        function toggleChart() {
            var chartDivhar = document.getElementById('dChart_har');
            if (chartDivhar.style.visibility === 'hidden') {
                chartDivhar.style.visibility = 'visible';
            } else {
                chartDivhar.style.visibility = 'hidden';
            }
        }
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart_har);

        function drawChart_har() {
            // Create a two-dimensional array from PHP data
            var chartData_har = [
                ['Vegetable Name', 'Total Amount']
            ];
            <?php
            for ($i = 0; $i < count($data_ch_veg); $i++) {
                echo "chartData_har.push(['" . $data_ch_veg[$i] . "', " .  $data_nh_veg[$i] . "]);\n";
            }
            ?>

            const data_har = google.visualization.arrayToDataTable(chartData_har);

            const options = {
                title: 'กราฟแสดงจำนวนผักที่เก็บเกี่ยวย้อนหลัง',
                pieHole: 0.3,
                titleTextStyle: {
                    color: 'black', // สีของตัวหนังสือ
                    // fontSize: 18, // ขนาดตัวหนังสือ
                    bold: true, // ตัวหนังสือหนา
                    italic: false, // ตัวหนังสือเอียง
                    textAlign: 'center' // การจัดวางข้อความ (center, start, end)
                },
                backgroundColor: 'transparent',
                width: 500, // ปรับขนาดความกว้างตามที่คุณต้องการ
                height: 300, // ปรับขนาดความสูงตามที่คุณต้องการ
                // legend: { position: 'none' }
                slices: {
                    0: {
                        color: '#b91d47'
                    }, // red
                    1: {
                        color: '#00aba9'
                    }, // teal
                    2: {
                        color: '#2b5797'
                    }, // blue
                    3: {
                        color: '#e8c3b9'
                    }, // light brown
                    4: {
                        color: '#1e7145'
                    }, // green
                    5: {
                        color: '#ff6666'
                    }, // light red
                    6: {
                        color: '#006666'
                    }, // dark teal
                    7: {
                        color: '#4d4dff'
                    }, // indigo
                    8: {
                        color: '#ff9933'
                    }, // orange
                    9: {
                        color: '#339966'
                    }, // dark green

                },
            };


            const chart = new google.visualization.PieChart(document.getElementById('dChart_har'));
            chart.draw(data_har, options);
        }
    </script>
</body>

</html>