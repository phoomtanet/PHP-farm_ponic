<?php  
// ทำการเชื่อมต่อฐานข้อมูล (แทนที่ <connection_string> ด้วยข้อมูลที่ถูกต้อง)
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

$sql_plot_slot ="SELECT a.plot_name, IFNULL(SUM(pt.vegetable_amount), 0) AS total_vegetable_amount   
-- ,  (a.row*a.column - IFNULL(SUM(pt.vegetable_amount), 0) )  as sumN
FROM `tb_plot` AS a
LEFT JOIN tb_planting AS pt ON a.id_plot = pt.id_plot
INNER JOIN tb_greenhouse AS b ON a.id_greenhouse = b.id_greenhouse
INNER JOIN tb_farm AS c ON c.id_farm = b.id_farm
WHERE b.id_greenhouse = '$id_greenhouse_session' AND c.id_farm = '$id_farm_session'
GROUP BY a.plot_name
ORDER BY LENGTH(a.plot_name), a.plot_name";

// SELECT  p.plot_name ,  v.vegetable_name  ,vw.amount_tree,vw.vegetableweight , vp.price FROM tb_plot AS p 
// LEFT JOIN tb_planting AS pt ON pt.id_plot = p.id_plot 
// INNER JOIN tb_vegetable AS v ON pt.id_vegetable = v.id_vegetable 
// LEFT JOIN tb_vegetableprice as vp on vp.id_vegetable = v.id_vegetable
// LEFT JOIN tb_vegetableweight as vw on vw.id_vegetable = v.id_vegetable
// INNER JOIN tb_greenhouse as g ON p.id_greenhouse =g.id_greenhouse
// WHERE g.id_greenhouse = '000001'
// ORDER BY p.id_plot ASC



// แปลง/ราคา
// $sql_plot_slot ="SELECT 
//     p.plot_name,
//      IFNULL(ROUND(SUM(pt.vegetable_amount * (vw.vegetableweight / vw.amount_tree / 1000) * vp.price)),0) AS allprice
// FROM 
//     tb_plot AS p 
// LEFT JOIN 
//     tb_planting AS pt ON pt.id_plot = p.id_plot 
// INNER JOIN 
//     tb_vegetable AS v ON pt.id_vegetable = v.id_vegetable 
// LEFT JOIN 
//     tb_vegetableprice AS vp ON vp.id_vegetable = v.id_vegetable
// LEFT JOIN 
//     tb_vegetableweight AS vw ON vw.id_vegetable = v.id_vegetable
// INNER JOIN 
//     tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
// WHERE 
//     g.id_greenhouse = '000001'
// GROUP BY 
//     p.plot_name 
// ORDER BY 
//     p.id_plot ASC";


//COUNT veg
// SELECT v.vegetable_name, COUNT(*) as vegetable_count
// FROM `tb_planting` as pt
// INNER JOIN tb_vegetable AS v ON v.id_vegetable = pt.id_vegetable
// INNER JOIN tb_plot AS p ON p.id_plot = pt.id_plot 
// INNER JOIN tb_greenhouse as g ON g.id_greenhouse = p.id_greenhouse
// INNER JOIN tb_farm as f ON f.id_farm = g.id_farm
// WHERE f.id_farm = '000001'
// GROUP BY v.vegetable_name
// ORDER BY LENGTH(p.plot_name), p.plot_name;


$result_slot = $conn->query($sql_plot_slot);

$data_slot = array();
$data_name_plot = array();

while ($row_slot = $result_slot->fetch_assoc()) {
    $data_slot[] = (int) $row_slot['total_vegetable_amount'];
    
    $data_name_plot[]= $row_slot['plot_name'];
}

$data_slot = array(
    'data_slot' => $data_slot,
    'data_name_plot' => $data_name_plot,
);

// คืนค่าข้อมูลในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($data_slot);



?>