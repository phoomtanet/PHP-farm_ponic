<?php

session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$id_user = $_POST['id_user'];
$namefarm = $_POST['farm_name'];
$location = $_POST['location'];

$sql = "INSERT INTO `tb_farm`(`id_user`, `name_farm`, `location`) 
VALUES ('$id_user','$namefarm','$location')";
mysqli_query($conn,$sql);

// if ($namefarm) {
  $_SESSION["farm_name"] = $namefarm;
// }

echo "<script> alert('*เพิ่มฟาร์มสำเร็จ*'); </script>";
// echo $_SESSION["farm_name"];
echo "<script> window.location='../php/greenhouse_form.php'</script>";
