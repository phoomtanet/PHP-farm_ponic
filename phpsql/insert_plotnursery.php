<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

if (isset($_POST['insert_plotnursery'])) {

    $name_plot = $_POST['plotnursery_name']; //ชื่อแปลง
    $column = $_POST['column'];
    $row = $_POST['row'];


    $sql_greenhouse = "SELECT COUNT(a.plotnursery_name) AS count
    FROM `tb_plot_nursery` as a
    WHERE a.id_greenhouse = '$id_greenhouse_session' AND a.plotnursery_name = '$name_plot' ";
    $result_greenhouse = mysqli_query($conn, $sql_greenhouse);
    $row_greenhouse = mysqli_fetch_assoc($result_greenhouse);
    $count = $row_greenhouse['count'];


    if ($count == 0) {
        $is_plot_nur = "INSERT INTO `tb_plot_nursery` 
        (`id_greenhouse`, `plotnursery_name`, `row`, `column`, `status_plot`) 
        VALUES ('$id_greenhouse_session', '$name_plot', '$row', '$column', '0')";
         mysqli_query($conn, $is_plot_nur);


        echo "<script> alert('*เพิ่มแปลงอนุบาลสำเร็จ*'); </script>";
        echo "<script> window.location='../php/plot_nursery.php'</script>";
    } else {
        echo "<script> alert('*ชื่อแปลงซ้ำ เพิ่มแปลงอนุบาลไม่สำเร็จ *'); </script>";
        echo "<script> window.location='../php/plot_nursery.php'</script>";
    }
}

if (isset($_GET['id_plot_nur'])) {
    $id_plotnursery2 = $_GET['id_plot_nur'];

$sql_del_nur="DELETE FROM `tb_plot_nursery` WHERE id_plotnursery = '$id_plotnursery2'";
$rs_del_ner =   mysqli_query($conn, $sql_del_nur);
if($rs_del_ner) {   
 echo "<script> alert('*ลบแปลงสำเร็จ *'); </script>";
echo "<script> window.location='../php/plot_nursery.php'</script>";
}
}

if (isset($_POST['update_plotnursery'])) {
    $id_plotnursery2 = $_POST['id_plotnursery2'];
    $column = $_POST['column2'];
    $row = $_POST['row2'];
$plotnursery_name = $_POST['plotnursery_name2'];
$sql_up_plot="UPDATE `tb_plot_nursery` SET `plotnursery_name`='$plotnursery_name',`row`='$row',`column`='$column' WHERE  id_plotnursery = '$id_plotnursery2'";
$rs_update =  mysqli_query($conn, $sql_up_plot);
    if($rs_update){
echo "<script> alert('*แก้ไขข้อมูลแปลงสำเร็จ *'); </script>";
echo "<script> window.location='../php/plot_nursery.php'</script>";
}
}


if (isset($_GET['id_nur'])) {
    $id_nursery2 = $_GET['id_nur'];

$sql_del_nur="DELETE FROM `tb_vegetable_nursery` WHERE id_nursery = '$id_nursery2'";
$rs_del_ner =   mysqli_query($conn, $sql_del_nur);
if($rs_del_ner) {   
 echo "<script> alert('*ลบการอนุบาลสำเร็จ *'); </script>";
echo "<script> window.location='../php/plot_nursery.php'</script>";
}
}

if (isset($_POST['update_nursery'])) {

    $id_nursery = $_POST['id_nursery'];
    $nursery_date = $_POST['nursery_date'];
    $nursery_amount = $_POST['nursery_amount'];


$sql_up_nur="UPDATE `tb_vegetable_nursery` SET `nursery_date`='$nursery_date',`nursery_amount`='$nursery_amount' WHERE  id_nursery = '$id_nursery'";
$rs_update_nur =  mysqli_query($conn, $sql_up_nur);
    if($rs_update_nur){
echo "<script> alert('*แก้ไขข้อมูลแปลงสำเร็จ *'); </script>";
echo "<script> window.location='../php/plot_nursery.php'</script>";
}
}
?>