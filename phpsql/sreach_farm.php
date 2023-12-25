<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$namefarm = $_POST['farm_name'];


//http ของหน้าที่ส่งข้อมูลมา
$referer = $_SERVER['HTTP_REFERER'];


if (isset($_POST['farm_name'])) {
    //$namefarm = mysqli_real_escape_string($conn, $_POST['farm_name']); // ทำการ escape ข้อมูล

    $sql_name_farm = "SELECT * FROM `tb_farm` as a INNER JOIN `tb_user` AS b ON a.id_user = b.id_user
    WHERE b.user_name = '$user';";

    $result_farm_name = mysqli_query($conn, $sql_name_farm);
    $row_farm_name = mysqli_fetch_array($result_farm_name);

  
    if ($row_farm_name > 0) {
        $_SESSION["farm_name"] = $namefarm;
        header("Location: $referer");

        $greenhouse_first = "SELECT a.name_greenhouse as first_greenhouse
        FROM `tb_greenhouse` as a
        INNER JOIN `tb_farm` AS b ON a.id_farm  = b.id_farm 
        INNER JOIN `tb_user` AS c ON b.id_user = c.id_user
        WHERE c.user_name = '$user' AND b.name_farm = '$namefarm' 
        LIMIT 1;";
$_SESSION["greenhouse_name"] = $row_greenhouse['first_greenhouse'];

        $result_greenhouse  = $conn->query($greenhouse_first);
        if ($result_greenhouse) {
            $row_greenhouse = $result_greenhouse->fetch_assoc();
            if ($row_greenhouse) {
                $_SESSION["greenhouse_name"] = $row_greenhouse['first_greenhouse'];

                // อาจจะมี popup แจ้งเตือนให้กดยืนยันก่อนเปลี่ยนฟาร์ม
                echo $_SESSION["greenhouse_name"];
            } else {
                echo "<script>window.location = '../php/greenhouse_form.php'; </script>";
            }
            $result_greenhouse->free();
        }

        exit();
    } else {
        echo '<a href="../php/index.php">กลับ</a>';
    }
    mysqli_close($conn);
}

