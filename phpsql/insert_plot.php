<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';


if (isset($_POST['save'])) {
    $nameplot = $_POST['nameplot'];
    $rowplot  = $_POST['row'];
    $columneplot  = $_POST['columne'];
    $sql_check_duplicate = "SELECT COUNT(*) AS count FROM `tb_plot` WHERE `id_greenhouse` = (
    SELECT `id_greenhouse` FROM `tb_greenhouse` WHERE `name_greenhouse` = '$greenhouse_name'
) AND `plot_name` = '$nameplot'";

    $result = mysqli_query($conn, $sql_check_duplicate);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        if ($count > 0) {
            echo "<script>alert('ชื่อแปลง $nameplot มีอยู่แล้ว กรุณากรอกชื่อแปลงที่ไม่ซ้ำ');</script>";
            echo "<script>window.location='../php/index.php'</script>";
        } else {
            // Insert the record since it doesn't exist in the database
           $sql_insert = "INSERT INTO `tb_plot`(`id_greenhouse`, `plot_name`, `row`, `column`, `status`)
               VALUES ((SELECT `id_greenhouse` FROM `tb_greenhouse` WHERE `name_greenhouse` = '$greenhouse_name'), '$nameplot', '$rowplot ', '$columneplot ', 0)";


            if (mysqli_query($conn, $sql_insert)) {
                echo "<script>alert('*เพิ่มแปลงสำเร็จ*');</script>";
                echo "<script>window.location='../php/index.php'</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


if (isset($_POST['editplot'])) {
    $nameplot = $_POST['edit_nameplot'];
    $rowplot  = $_POST['edit_row'];
    $columnplot  = $_POST['edit_col'];
    $id_plot =  $_POST['id_edit_plot'];

    $sql_edit_plot = "UPDATE `tb_plot`
     SET`plot_name`= '$nameplot' ,`row`=$rowplot,`column`='$columnplot' WHERE id_plot = $id_plot ";

    if (mysqli_query($conn, $sql_edit_plot)) {

        echo "<script>alert('*แก้ไขแปลงสำเร็จ*');</script>";
        echo "<script>window.location='../php/index.php'</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_GET['id_plot_del'])) {
    $id = $_GET['id_plot_del'];

    $sql_del_plot = "DELETE FROM `tb_plot` WHERE id_plot = '$id'";
    $sql_del_harvest = "DELETE FROM `tb_harvest` WHERE id_plot = '$id'";
   if( mysqli_query($conn, $sql_del_harvest)){
    if (mysqli_query($conn, $sql_del_plot)) {

        mysqli_query($conn, $sql_del_harvest);
        echo "<script>alert('*ลบข้อมูลสำเร็จ*');</script>";
        echo "<script>window.location='../php/index.php'</script>";

    } else {
       
        echo "<script>alert('*ไม่สามารถลบข้อมูลได้ เนื่องจากมีข้อมูลบันทึกการเก็บเกี่ยวในแปลง*');</script>";
        echo "<script>window.location='../php/index.php'</script>";

     
    }
}
} else {
    echo "<script>alert('*ไม่มีข้อมูล*');</script>";
}
