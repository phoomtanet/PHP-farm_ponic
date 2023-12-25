<?php  

session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

$sql_price = "SELECT   p.plot_name,
IFNULL(ROUND(SUM(pt.vegetable_amount * (vw.vegetableweight / vw.amount_tree / 1000) * vp.price)),0) AS allprice
FROM tb_plot AS p 
LEFT JOIN tb_planting AS pt ON pt.id_plot = p.id_plot 
INNER JOIN tb_veg_farm AS vf ON pt.id_veg_farm = vf.id_veg_farm 
INNER JOIN tb_vegetable AS v ON vf.id_vegetable = v.id_vegetable 
LEFT JOIN tb_vegetableprice AS vp ON vp.id_veg_farm = vf.id_veg_farm
LEFT JOIN tb_vegetableweight AS vw ON vw.id_veg_farm = vf.id_veg_farm
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
WHERE   g.id_greenhouse = '$id_greenhouse_session'
GROUP BY p.plot_name 
ORDER BY p.id_plot ASC";



$result_price = $conn->query($sql_price);

$data_price = array();
$data_name_plot_price = array();

while ($row_price = $result_price->fetch_assoc()) {
    $data_price[] = (int) $row_price['allprice'];
    
    $data_name_plot_price[]= $row_price['plot_name'];
}

$data_price = array(
    'data_slot' => $data_price,
    'data_name_plot' => $data_name_plot_price,
);
// คืนค่าข้อมูลในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($data_price);

