<?php
session_start();

include '../Connect/conn.php';
include '../Connect/session.php';


if (isset($_POST["save_harvest"])) {

    $plot_harvest = $_POST["plot_harvest"]; //ชื่อแปลง
    $veg_harvest = $_POST["veg_harvest"]; //ชือ่่ผัก
    $veg_planting_amont = $_POST["veg_planting_amont"]; //จำนวนผักที่ปลูก
    $harvest_amount = $_POST["harvest_amount"]; //จำนวนเก็บเกี่ยว

    $id_plot_harvest = $_POST["id_plot_harvest"];
    $id_veg = $_POST["id_veg"];
    $harvest_date = $_POST["harvest_date"];
    $id_plan = $_POST["id_planting"];


    // echo  $id_plot_harvest;

    $sql_harvest = "INSERT INTO  `tb_harvest`
( `id_plot`, `id_veg_farm`, `harvestdate`, `harvest_amount`) 
 VALUES ($id_plot_harvest,$id_veg,'$harvest_date',$harvest_amount)";
    mysqli_query($conn, $sql_harvest);

    if ($veg_planting_amont - $harvest_amount > 0  && $harvest_amount < $veg_planting_amont) {
        $sql_update_planting  = "UPDATE tb_planting SET  `vegetable_amount`=$veg_planting_amont- $harvest_amount  WHERE id_planting = '$id_plan' ";
        mysqli_query($conn,  $sql_update_planting);
        echo "<script> alert('*บันทึกการเก็บเกี่ยวสำเร็จ'); </script>";
    } else if ($harvest_amount > $veg_planting_amont) {
        echo "<script> alert('*บันทึกไม่สำเร็จ จำนวนการเก็บเกี่ยว มากกว่าการปลูก'); </script>";
    } else if ($harvest_amount - $veg_planting_amont <= 0) {

        $sql_del_plan = "DELETE FROM `tb_planting` WHERE id_planting = '$id_plan'";
        $re = mysqli_query($conn, $sql_del_plan);
        if ($re) {
            echo "<script> alert('*บันทึกสำเร็จ  ลบการปลูก'); </script>";
        }
    }

    $chack_row_plan = "SELECT COUNT(*) AS row_count FROM tb_planting WHERE id_plot='$id_plot_harvest'";
    $result_row_plan = mysqli_query($conn, $chack_row_plan);
    $row = mysqli_fetch_assoc($result_row_plan);
    $row_count = $row['row_count'];
    echo "$id_plan";

    if ($row_count == 0) {
        $update = "UPDATE `tb_plot` SET `status`=0 WHERE id_plot ='$id_plot_harvest'";
        mysqli_query($conn, $update);
        $sql_del_fert = "DELETE FROM `tb_fertilizationdate` WHERE id_plot = '$id_plot_harvest'";
        mysqli_query($conn, $sql_del_fert);
    }


    echo "<script>window.location = '../php/index.php'</script>";
}

if (isset($_POST["edit_fertilizationdate"])) {
    $id_fertilizationDate = $_POST["id_fertilizationDate"];
    $fertilizationdate = $_POST["fertilizationdate"];

    $sql_update_fer = "UPDATE `tb_fertilizationdate` SET `fertilizationDate`= '$fertilizationdate' WHERE  id_fertilizationDate = $id_fertilizationDate";
    mysqli_query($conn, $sql_update_fer);
    echo "<script>window.location = '../php/index.php'</script>";
}
