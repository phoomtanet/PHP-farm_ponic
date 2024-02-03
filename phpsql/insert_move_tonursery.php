<?php 
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$name_plot = $_POST["name_plot"]; // ชื่อแปลงที่จะย้าย
$vegetable_name =$_POST["vegetable_name"];//ผัก
$germination_amount =$_POST["germination_amount"];// จำนวนในการเพาะ
$num_nuesery = $_POST["num_nursery"]; //จำนวนที่ย้ายไปการอนุบาล
$id_seed_germination = $_POST["id_seed_germination"]; 
$id_vegetable = $_POST["id_veg_farm"]; 
$date =$_POST["date"];



$sql_id_plot_nursery = "SELECT a.id_plotnursery 
FROM `tb_plot_nursery` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
WHERE d.user_name = '$user' AND c.name_farm = '$farm_name' 
AND b.name_greenhouse = '$greenhouse_name'
AND  a.plotnursery_name = '$name_plot'";
$id_plot_nursery_result = mysqli_query($conn, $sql_id_plot_nursery);
$id_plot_nursery_row = mysqli_fetch_assoc($id_plot_nursery_result);
$id_plotnursery = $id_plot_nursery_row['id_plotnursery'];



$sql_nursery = "INSERT INTO `tb_vegetable_nursery`
(`id_plotnursery`, `id_veg_farm`, `nursery_amount`, `nursery_date`) 
VALUES ('$id_plotnursery','$id_vegetable','$num_nuesery','$date')";
   mysqli_query($conn, $sql_nursery);

  
  $update_germination_amount ="UPDATE `tb_seed_germination` SET `germination_amount`=$germination_amount-$num_nuesery WHERE id_seed_germination  ='$id_seed_germination'";
  mysqli_query($conn, $update_germination_amount);

if($germination_amount-$num_nuesery == 0){
 
  $delete_id_germination = "DELETE FROM `tb_seed_germination` WHERE id_seed_germination = '$id_seed_germination'";
mysqli_query($conn, $delete_id_germination);
 
  echo "<script> alert('*ลบข้อมูลการเพาะ เนื่องจากไม่มีจำนวนการเพาะแล้ว*'); </script>";

}

  
  echo "<script>window.location='../php/plot_nursery.php'</script>";

?>