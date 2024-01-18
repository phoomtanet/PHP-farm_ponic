<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";

// Calculate the date 12 months ago from the current date
$dateTwelveMonthsAgo = date('Y-m-d', strtotime('-12 months'));

$sql_harvest_month = "SELECT
    SUM(h.harvest_amount) AS total_amount,
    EXTRACT(YEAR_MONTH FROM h.harvestdate) AS harvest_month
FROM tb_harvest AS h
INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
INNER JOIN tb_farm AS f ON f.id_farm = g.id_farm
WHERE   g.id_greenhouse = '$id_greenhouse_session'
    AND h.harvestdate >= '$dateTwelveMonthsAgo'
GROUP BY harvest_month;";

$result_harvest_month  = $conn->query($sql_harvest_month);

$data_total_amountVeg  = array();
$data_name_month = array();

while ($row_month = $result_harvest_month->fetch_assoc()) {
    $data_total_amountVeg[] = (int) $row_month['total_amount'];

    // Format the month and year
    $monthYear = date("m / Y", strtotime($row_month['harvest_month'] . '01'));
    $data_name_month[] = $monthYear;
}

$data_harvest_month = array(
    'data_total_amountVeg' => $data_total_amountVeg,
    'data_name_month' => $data_name_month,
);

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($data_harvest_month);
?>
