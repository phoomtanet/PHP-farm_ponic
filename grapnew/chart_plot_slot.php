<?php


$sql_plot_slot ="SELECT a.plot_name, IFNULL(SUM(pt.vegetable_amount), 0) AS total_vegetable_amount   
FROM `tb_plot` AS a
LEFT JOIN tb_planting AS pt ON a.id_plot = pt.id_plot
INNER JOIN tb_greenhouse AS b ON a.id_greenhouse = b.id_greenhouse
INNER JOIN tb_farm AS c ON c.id_farm = b.id_farm
WHERE b.id_greenhouse = '$id_greenhouse_session'
GROUP BY a.plot_name
ORDER BY LENGTH(a.plot_name), a.plot_name";


$result_slot = $conn->query($sql_plot_slot);

$data_slot = array();
$data_name_plot = array();

while ($row_slot = $result_slot->fetch_assoc()) {
    $data_slot[] = (int) $row_slot['total_vegetable_amount'];
    
    $data_name_plot[]= $row_slot['plot_name'];
}



?>


<script>

console.log(<?php echo json_encode($data_name_plot); ?>);

document.addEventListener('DOMContentLoaded', function() {
    // Get the canvas element
    var ctx = document.getElementById('Chart_num_slot').getContext('2d');

    // Create the chart
    var priceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($data_name_plot); ?>,

            datasets: [{
                label: 'จำนวนผัก',
                data: <?php echo json_encode($data_slot); ?>,
                backgroundColor: '#00aba9', // Adjust as needed

                borderColor: 'black', // Adjust as needed
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'category', // เปลี่ยน type เป็น 'category' สำหรับแกน x
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'จำนวนผักในแต่ละแปลงปลูก',
                    font: {
                        size: 16, // Set the font size
                    },
                },
            },
        }
    });
});
</script>