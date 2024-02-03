<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$sql_harvest = "SELECT v.vegetable_name, SUM(h.harvest_amount) AS total_amount
FROM tb_harvest AS h
INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
INNER JOIN tb_farm AS f ON f.id_farm = g.id_farm
INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm

INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
WHERE   g.id_greenhouse = '$id_greenhouse_session' AND h.harvestdate >= CURDATE() - INTERVAL 30 DAY
GROUP BY  v.vegetable_name";



$rs_h_veg = mysqli_query($conn, $sql_harvest);
$data_nh_veg = array();
$data_ch_veg = array();

while ($row_h_veg = $rs_h_veg->fetch_assoc()) {
    $data_nh_veg[] = $row_h_veg['total_amount'];
    $data_ch_veg[] = $row_h_veg['vegetable_name'];
}

$data_vegh_count = array(
    'data_nh_veg' => $data_nh_veg,
    'data_ch_veg' => $data_ch_veg,
);

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($data_vegh_count);