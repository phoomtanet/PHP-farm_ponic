<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';


if (isset($_POST['save2'])) {
    $fertilizer_name = $_POST['fertilizer_name'];

    $sql = "INSERT INTO `tb_fertilizer`(`id_farm`, `fertilizer_name`) 
VALUES ('$id_farm_session','$fertilizer_name')";
    mysqli_query($conn, $sql);

    echo "<script> alert('*เพิ่มข้อมูลปุ๋ยเรียบร้อย*'); </script>";
    echo "<script> window.location='../php/ShowVegetable.php'</script>";
}

if (isset($_POST['edit2'])) {

    $fertilizer_id = $_POST['id_fertilizeredit'];
    $fertilizer_name_edit = $_POST['fertilizer_name_edit'];

    $sql_edit = "UPDATE `tb_fertilizer` SET `fertilizer_name`='$fertilizer_name_edit' WHERE id_fertilizer =   '$fertilizer_id'";
    mysqli_query($conn, $sql_edit);
    echo "<script> alert('*แก้ข้อมูลปุ๋ยเรียบร้อย*'); </script>";
    
    echo "<script> window.location='../php/ShowVegetable.php'</script>";

}
