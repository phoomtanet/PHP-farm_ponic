<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

if (isset($_GET['id_plot_data'])) {
    $id_plot_data = $_GET['id_plot_data'];
}
$sql_plot_plan = "SELECT *FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_planting as e on a.id_plot = e.id_plot
LEFT JOIN tb_vegetable as f on f.id_vegetable = e.id_vegetable   
LEFT JOIN tb_fertilizationdate as g on   g.id_plot = e.id_plot
WHERE a.id_plot = '$id_plot_data'";
      $result_plan = mysqli_query($conn, $sql_plot_plan);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?=     $id_plot_data   ?>
</body>
</html>