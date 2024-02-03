<?php 
include '../Connect/conn.php';

$id_farm = $_POST['id_farm'];
$name_greenhouse = $_POST['greenhouse_name'];

$sql = "INSERT INTO `tb_greenhouse`(`id_farm`, `name_greenhouse`) 
VALUES ('$id_farm','$name_greenhouse')";

mysqli_query($conn,$sql);

echo "<script> alert('*เพิ่มโรงเรือนสำเร็จ*'); </script>";
echo "<script> window.location='../php/ShowGreenhouse.php'</script>";
?>