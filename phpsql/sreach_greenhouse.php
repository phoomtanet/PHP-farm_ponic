<?php
session_start();
ob_start();
include '../Connect/conn.php';
include '../Connect/session.php';


$namegreenhouse  = $_POST['greenhouse_name'];
$referer = $_SERVER['HTTP_REFERER'];

if (isset($_POST['greenhouse_name'])) {
    $sql_greenhouse = "SELECT a.name_greenhouse 
FROM `tb_greenhouse` as a
INNER JOIN `tb_farm` AS b ON a.id_farm  = b.id_farm 
INNER JOIN `tb_user` AS c ON b.id_user = c.id_user
WHERE c.user_name = '$user' AND b.name_farm = '$farm_name';";

$result_greenhouse = mysqli_query($conn, $sql_greenhouse);
$row_greenhouse = mysqli_fetch_array($result_greenhouse);
if ($row_greenhouse  > 0) {
    echo "<script>window.location = '$referer';</script>";
    $_SESSION["greenhouse_name"] = $namegreenhouse;
    exit();
}
      mysqli_close($conn);
}
ob_end_flush();
?> 