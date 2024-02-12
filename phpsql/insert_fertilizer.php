<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$fertilizer_name = $_POST['fertilizer_name'];

$sql = "INSERT INTO `tb_fertilizer`(`id_farm`, `fertilizer_name`) 
VALUES ('$id_farm_session','$fertilizer_name')";
mysqli_query($conn,$sql);

echo "<script> alert('*เพิ่มข้อมูลปุ๋ยเรียบร้อย*'); </script>";
echo "<script> window.location='../php/ShowVegetable.php'</script>";


