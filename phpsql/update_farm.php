<?php 
include '../Connect/conn.php';

$id_farm = $_POST['id_farm_edit'];
$namefarm = $_POST['farm_name_edit'];
$location = $_POST['location_edit'];

$sql = "UPDATE `tb_farm` SET `name_farm`='$namefarm',`location`='$location' WHERE id_farm = '$id_farm'";
mysqli_query($conn,$sql);

echo "<script> alert('*เพิ่มโรงเรือนสำเร็จ*'); </script>";
// echo $_SESSION["farm_name"];
echo "<script> window.location='../php/ShowFarm.php'</script>";
?>