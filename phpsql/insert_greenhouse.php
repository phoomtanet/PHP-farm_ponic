<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$id_farm = $_POST['id_farm'];
$name_greenhouse = $_POST['greenhouse_name'];

$sql = "INSERT INTO `tb_greenhouse`(`id_farm`, `name_greenhouse`) 
VALUES ('$id_farm','$name_greenhouse')";



if (mysqli_query($conn, $sql)) {
    $sql_id_greenhouse_session = "SELECT a.id_greenhouse 
   FROM `tb_greenhouse` as a
   WHERE a.name_greenhouse ='$name_greenhouse' AND a.id_farm ='$id_farm_session';";
    $resultd_greenhouse_session = mysqli_query($conn, $sql_id_greenhouse_session);
    if ($resultd_greenhouse_session) {
        $row_greenhouse_session = mysqli_fetch_assoc($resultd_greenhouse_session);
        $id_greenhouse_session  = $row_greenhouse_session['id_greenhouse'];
        $_SESSION["greenhouse_name"] = $name_greenhouse;
    }
}
echo "<script> alert('*เพิ่มโรงเรือนสำเร็จ*'); </script>";
echo "<script> window.location='../php/ShowGreenhouse.php'</script>";
