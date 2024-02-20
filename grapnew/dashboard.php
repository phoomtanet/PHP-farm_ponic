<?php

session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql_all_price = "SELECT   
IFNULL(ROUND(SUM((pt.vegetable_amount * (vw.vegetableweight / vw.amount_tree)) / 1000 * vp.price)),0) AS allprice_veg
FROM tb_plot AS p 
LEFT JOIN tb_planting AS pt ON pt.id_plot = p.id_plot 
INNER JOIN tb_veg_farm AS vf ON pt.id_veg_farm = vf.id_veg_farm 
INNER JOIN tb_vegetable AS v ON vf.id_vegetable = v.id_vegetable 
LEFT JOIN tb_vegetableprice AS vp ON vp.id_veg_farm  = vf.id_veg_farm 
LEFT JOIN tb_vegetableweight AS vw ON vw.id_veg_farm  = vf.id_veg_farm 
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
WHERE   g.id_greenhouse = '$id_greenhouse_session'
ORDER BY p.id_plot ASC";
$result_all_price = $conn->query($sql_all_price);
$row_all_price  = $result_all_price->fetch_assoc();
$allprice = $row_all_price['allprice_veg'];
$formattedPrice = number_format($allprice);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Include this in your HTML file -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>


</head>
<style>
    @media (max-width: 1000px) {

        /* ปรับขนาดตัวหนังสือในแถบข้างลง */
        .side_nav_menu a {
            font-size: 14px;
            /* ปรับขนาดตามที่คุณต้องการ */
        }

        .main-content-div h2 {
            font-size: 24px;
            /* ปรับขนาดตามที่คุณต้องการ */
        }
    }

    #statusChart {
        width: 500px;
        height: 1000px;
    }

    #result {
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 10%, rgba(0, 212, 255, 1) 100%);
        text-align: center;
        color: #fff;
    }

    .material-icons {
        font-size: 3rem;
        /* You may need to adjust the size based on your design */

    }
</style>

<body>
    <!-- สร้าง Top เมนู -->
    <?php   include '../navbar/navbar.php'; 
            include '../grapnew/chart_plot_price.php';
            include '../grapnew/dchart_har.php';
            include '../grapnew/dchart_c_veg.php';
            include '../grapnew/dchar_c_nur.php';
            include '../grapnew/chart_plot_slot.php';
    ?>

    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu">
    </div>
    <!-- เนื้อหาหลัก -->
    <div class="pt-5 main-content-div  pt-5 mt-3" style="text-align: center;">
        <div class="d-flex justify-content-around  m-2">
            <div class="text-center py-2  px-4" style="text-align: center;" id="result">
                <table>
                    <tr>
                        <td> <i class="material-icons">attach_money</i></td>
                        <td>
                            รายได้จากแปลงปลูก<br>
                            <?php echo "$formattedPrice  บาท" ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-center text-center ">
            <div class="border px-1 mx-1">
                <div id="dChart_plan" style="width: 400px; height: 250px;"> </div>
            </div>
            <div class="border px-1 mx-1">
                <div id="dChart_nur" style="width: 400px; height: 250px;"> </div>
            </div>
            <div class="border px-1 mx-1">
                <div id="dChart_har" style="width: 400px; height: 250px;"> </div>
            </div>
        </div>

        <div class="pt-3 main-content-div" style="text-align: center;">
            <div class="d-flex flex-wrap justify-content-center text-center ">
                <div class="border px-4 mx-3">
                <canvas id="Chart_num_slot" width="400" height="300"></canvas>

                </div>
                <div class="border px-4 mx-3">
                    <canvas id="priceChart" width="400" height="300"></canvas>


                </div>


            </div>
      
</body>


<script src="../navbar/navbar.js"></script>

<script>
  function toggleChart() {
    var chartDiv = document.getElementById('dChart_plan');
    var chartDivh = document.getElementById('dChart_nur');
    var chartDivnur = document.getElementById('dChart_har');

    // ใช้ style.visibility เพื่อเปลี่ยนสถานะการแสดงผล
    if (chartDiv.style.visibility === 'hidden') {
      // แสดงกราฟ
      chartDiv.style.visibility = 'visible';
      chartDivh.style.visibility = 'visible';
      chartDivnur.style.visibility = 'visible';


      // แสดงข้อมูลในกราฟ (ตัวอย่าง: แสดง alert)
    } else {
      // ซ่อนกราฟ
      chartDiv.style.visibility = 'hidden';
      chartDivh.style.visibility = 'hidden';
      chartDivnur.style.visibility = 'hidden';


      // ปิดข้อมูลในกราฟ (ตัวอย่าง: แสดง alert)
    }
  }
</script>
</html>