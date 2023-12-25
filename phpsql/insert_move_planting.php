<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

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


$currentDate = date("Y-m-d"); // รับวันที่ปัจจุบันในรูปแบบ ปี-เดือน-วัน

// Assuming $user, $greenhouse_name, and $farm_name are defined in your included session.php

echo "$name_plot";
echo " รหัสการอนุบาล . $id_nursery ";
echo " ชื่อผัก $vegetable_name";
echo '<br>';
echo " จำนวนที่อนุบาล $num_nursery";
echo " จำนวนที่ย้ายได้สูงสุด $num_max";
echo " จำนวนที่ย้าย $num_planting";
echo " รอบการให้ปุ๋ย $num_fertilizing";
echo " รอบการให้ปุ๋ย $date";


echo "รหัสแปลง $id_plot";


$sql_count_planting = "SELECT b.id_planting FROM tb_planting as b WHERE b.id_plot = '$id_plot'";
$result_count_planting = $conn->query($sql_count_planting);
$count_planting = mysqli_num_rows($result_count_planting);// นับจำนวนแถวที่ได้จาก query
// เมื่อยังไม่มีการปลูกในแปลง ให้ เพิ่มเวลาให้ปุ๋ย
echo "แถว $count_planting";
if($count_planting == 0){
    $fertilizationdate = "INSERT INTO `tb_fertilizationdate`(`id_fertilizationDate`, `id_plot`, `fertilizationDate`) 
    VALUES ('','$id_plot','$currentDate')";
mysqli_query($conn, $fertilizationdate);

}


$update_status = "UPDATE `tb_plot` SET `status` = 1 WHERE `id_plot` = $id_plot";
$result_update_status = mysqli_query($conn, $update_status);
$nursery_amount =  "UPDATE `tb_vegetable_nursery` SET `nursery_amount`= $num_nursery -$num_planting WHERE id_nursery = $id_nursery";
mysqli_query($conn, $nursery_amount);


if ($num_nursery - $num_planting == 0) {
    $delete_nursery = "DELETE FROM `tb_vegetable_nursery` WHERE id_nursery = $id_nursery ";
    echo "<script> alert('*ลบข้อมูลการอนุบาล เนื่องจากไม่มีจำนวนการอนุบาลแล้ว*'); </script>";
    mysqli_query($conn, $delete_nursery);
}


$sql_insert = "INSERT INTO `tb_planting`(`id_plot`, `id_veg_farm`, `vegetable_amount`, `planting_date`, `fertilizing_everyDays` ) 
    VALUES ('$id_plot', '$id_veg_farm', '$num_planting', '$date', '$num_fertilizing'  )";
$result_sql_insert = mysqli_query($conn, $sql_insert);


echo "<script>window.location = '../php/index.php'</script>";


// Close the database connection if needed
mysqli_close($conn);
