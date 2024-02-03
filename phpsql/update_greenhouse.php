<?php
include '../Connect/conn.php';

$id_greenhouseedit = $_POST['id_greenhouseedit'];
$name_greenhouse = $_POST['greenhouse_name_edit'];

$sql_up = "UPDATE `tb_greenhouse` SET `name_greenhouse`= '$name_greenhouse' WHERE id_greenhouse = '$id_greenhouseedit'";

mysqli_query($conn, $sql_up);

echo "<script> alert('*แก้ไขโรงเรือน*'); </script>";
echo "<script> window.location='../php/ShowGreenhouse.php'</script>";


?>