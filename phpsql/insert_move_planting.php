<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

if(isset($_POST['id_nursery']) && isset($_POST['id_veg_farm'])){


$id_nursery = $_POST['id_nursery']; //รหัสการอนุบาล 
$id_plot = $_POST['id_plot']; //รหัสการอนุบาล 

$name_plot = $_POST['name_plot']; //
$num_nursery = $_POST['num_nursery']; //จำนวนที่อนุบาล
$num_planting = $_POST['num_planting']; //จำนวนที่ย้าย
$num_max = $_POST['num_max']; // จำนวนที่ย้ายได้สูงสุด  **ไม่ใช้
$vegetable_name = $_POST['vegetable_name']; //ชื่อผัก
$num_fertilizing = $_POST['num_fertilizing']; //
$date = $_POST['date']; //
$id_veg_farm = $_POST['id_veg_farm'];

$_SESSION["num_fertilizing"] = $num_fertilizing;
$currentDate = date("Y-m-d"); // Get the current date in the format YYYY-MM-DD

$sql_count_planting = "SELECT b.id_planting FROM tb_planting as b WHERE b.id_plot = '$id_plot'";
$result_count_planting = $conn->query($sql_count_planting);
$count_planting = mysqli_num_rows($result_count_planting); // Count the rows returned by the query

if ($count_planting == 0) {
    $fertilizationdate = "INSERT INTO `tb_fertilizationdate` (`id_plot`, `fertilizationDate`) 
    VALUES ('$id_plot', '$currentDate')"; // Enclose the date value in single quotes

    mysqli_query($conn, $fertilizationdate);
}


$update_status = "UPDATE `tb_plot` SET `status` = 1 WHERE `id_plot` = $id_plot";
$result_update_status = mysqli_query($conn, $update_status);
$nursery_amount =  "UPDATE `tb_vegetable_nursery` SET `nursery_amount`= $num_nursery -$num_planting WHERE id_nursery = $id_nursery";
mysqli_query($conn, $nursery_amount);


if ($num_nursery - $num_planting == 0) {
    $delete_nursery = "DELETE FROM `tb_vegetable_nursery` WHERE id_nursery = $id_nursery ";
    mysqli_query($conn, $delete_nursery);
}


$sql_insert = "INSERT INTO `tb_planting`(`id_plot`, `id_veg_farm`, `vegetable_amount`, `planting_date`, `fertilizing_everyDays` ) 
    VALUES ('$id_plot', '$id_veg_farm', '$num_planting', '$date', '$num_fertilizing'  )";
$result_sql_insert = mysqli_query($conn, $sql_insert);

echo "<script> alert('*ย้ายการอนุบาล มาแปลงปลูก $name_plot สำเร็จ*'); </script>";

echo "<script>window.location = '../php/index.php'</script>";


// Close the database connection if needed
mysqli_close($conn);
}else{
    echo "<script> alert('*การเข้าถึงไม่ถูกต้อง*'); </script>";

    echo "<script>window.location = '../php/index.php'</script>";
}
?>