<?php
include '../Connect/conn.php';

$id = $_GET['id'];

$id_veg_farm = $_GET['id_veg_farm'];


$sql_del_harvest = "DELETE FROM `tb_harvest` WHERE `id_veg_farm` = '$id_veg_farm' ";
$result_harvest = mysqli_query($conn, $sql_del_harvest);
$sql_del_weight = "DELETE FROM `tb_vegetableweight` WHERE `id_veg_farm` = '$id_veg_farm'";
$result1 = mysqli_query($conn, $sql_del_weight);
$sql_del_price = "DELETE FROM `tb_vegetableprice` WHERE `id_veg_farm` = '$id_veg_farm'";
$result2 = mysqli_query($conn, $sql_del_price);

$sql_dal_veg = "DELETE FROM `tb_veg_farm` WHERE `id_veg_farm` = '$id_veg_farm'";
$result3 = mysqli_query($conn, $sql_dal_veg);

$sql_del_vegFarm = "DELETE FROM `tb_vegetable` WHERE `id_vegetable` = '$id'";
$result_del_vegFarm = mysqli_query($conn, $sql_del_vegFarm);



if ($result1 && $result2 && $result3 &&$result_del_vegFarm && $result_harvest  ) {
  echo "<script> alert('ลบข้อมูลเรียบร้อย'); </script>";
 echo "<script> window.location='../php/ShowVegetable.php'</script>";
} else {
  echo "<script> alert('ไม่สามารถลบข้อมูล'); </script>";
 echo "<script> window.location='../php/ShowVegetable.php'</script>";

}
