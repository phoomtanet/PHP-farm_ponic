<?php 
include '../Connect/conn.php';

$id_user = $_POST['id_user'];
$namefarm = $_POST['farm_name'];
$location = $_POST['location'];

$sql = "INSERT INTO `tb_farm`(`id_user`, `name_farm`, `location`) 
VALUES ('$id_user','$namefarm','$location')";
mysqli_query($conn,$sql);

echo "<script> alert('*เพิ่มโรงเรือนสำเร็จ*'); </script>";
// echo $_SESSION["farm_name"];
echo "<script> window.location='../php/ShowFarm.php'</script>";
?>