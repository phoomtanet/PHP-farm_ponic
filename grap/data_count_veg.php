<?php
// Your PHP code to fetch and process data
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql_c_veg = "SELECT v.vegetable_name, SUM(pt.vegetable_amount) AS total_amount
    FROM
        `tb_planting` AS pt
        INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = pt.id_veg_farm

        INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
        INNER JOIN tb_plot AS p ON p.id_plot = pt.id_plot
        INNER JOIN tb_greenhouse AS g ON g.id_greenhouse = p.id_greenhouse
        INNER JOIN tb_farm AS f ON f.id_farm = g.id_farm
        WHERE   g.id_greenhouse = '$id_greenhouse_session' and f.id_farm = '$id_farm_session'
    GROUP BY
        v.vegetable_name;";


$rs_c_veg = mysqli_query($conn, $sql_c_veg);
$data_n_veg = array();
$data_c_veg = array();

while ($row_c_veg = $rs_c_veg->fetch_assoc()) {
    $data_n_veg[] = $row_c_veg['total_amount'];
    $data_c_veg[] = $row_c_veg['vegetable_name'];
}




$data_veg_count = array(
    'data_n_veg' => $data_n_veg,
    'data_c_veg' => $data_c_veg,
);

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($data_veg_count);
?>
