<?php

$sql_c_veg_nur = "SELECT  v.vegetable_name , SUM(vn.nursery_amount) as  total_amount_nur
FROM tb_plot_nursery as pn 
INNER JOIN tb_vegetable_nursery as vn on vn.id_plotnursery = pn.id_plotnursery

INNER JOIN tb_veg_farm AS vf on vf.id_veg_farm = vn.id_veg_farm


INNER JOIN tb_vegetable AS v on v.id_vegetable = vf.id_vegetable
INNER JOIN tb_greenhouse as g on g.id_greenhouse = pn.id_greenhouse
WHERE g.id_greenhouse = '$id_greenhouse_session'
GROUP BY v.vegetable_name";
$rs_c_veg_nur = mysqli_query($conn , $sql_c_veg_nur);

$data_n_veg_nur = array();
$data_c_veg_nur = array();

while ($row_c_veg_nur = $rs_c_veg_nur->fetch_assoc()) {
    $data_n_veg_nur[] = $row_c_veg_nur['total_amount_nur'];
    $data_c_veg_nur [] =$row_c_veg_nur['vegetable_name'];
}







?>
<script>

var xValues = <?php echo json_encode($data_n_veg_nur); ?>;
var yValues = <?php echo json_encode($data_c_veg_nur); ?>;
var barColors = ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145"];

new Chart("dChart_nur", {
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