<?php


// โดนัท นับจำนวนการปลูก
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


?>


<script>
console.log(<?php echo json_encode($data_n_veg); ?>);

var xValues = <?php echo json_encode($data_n_veg); ?>;
var yValues = <?php echo json_encode($data_c_veg); ?>;
var barColors = ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145"];

new Chart("dChart_plan", {
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
