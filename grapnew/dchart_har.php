<?php 
$sql_harvest = "SELECT v.vegetable_name, SUM(h.harvest_amount) AS total_amount
FROM tb_harvest AS h
INNER JOIN tb_plot AS p ON p.id_plot = h.id_plot
INNER JOIN tb_greenhouse AS g ON p.id_greenhouse = g.id_greenhouse
INNER JOIN tb_farm AS f ON f.id_farm = g.id_farm
INNER JOIN tb_veg_farm AS vf ON vf.id_veg_farm = h.id_veg_farm
INNER JOIN tb_vegetable AS v ON v.id_vegetable = vf.id_vegetable
WHERE g.id_greenhouse = '$id_greenhouse_session' AND h.harvestdate >= CURDATE() - INTERVAL 30 DAY
GROUP BY v.vegetable_name";



$rs_h_veg = mysqli_query($conn, $sql_harvest);
$data_nh_veg = array();
$data_ch_veg = array();

while ($row_h_veg = $rs_h_veg->fetch_assoc()) {
    $data_nh_veg[] = $row_h_veg['total_amount'];
    $data_ch_veg[] = $row_h_veg['vegetable_name'];
}

?>


<script>
console.log(<?php echo json_encode($data_nh_veg); ?>);

var xValues = <?php echo json_encode($data_nh_veg); ?>;
var yValues = <?php echo json_encode($data_ch_veg); ?>;
var barColors = ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145"];

new Chart("dChart_har", {
    type: "doughnut",
    data: {
        labels: yValues, // Use vegetable names as labels
        datasets: [{
            backgroundColor: barColors,
            data: xValues // Use total amounts as data
        }]
    },
    options: {
        title: {
            display: true,
            text: "Vegetable Production Chart" // Customize the title as needed
        }
    }
});
</script>