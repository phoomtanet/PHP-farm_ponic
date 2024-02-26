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
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart_har);

function drawChart_har() {
    // Create a two-dimensional array from PHP data
    var chartData_har = [['Vegetable Name', 'Total Amount']];
    <?php
    for ($i = 0; $i < count($data_ch_veg); $i++) {
        echo "chartData_har.push(['" . $data_ch_veg[$i] . "', " .  $data_nh_veg[$i] . "]);\n";
    }
    ?>

    const data_har = google.visualization.arrayToDataTable(chartData_har);

    const options = {
    title: 'กราฟแสดงจำนวนผักที่เก็บเกี่ยวย้อนหลัง 30 วัน',
    pieHole: 0.3,
    titleTextStyle: {
        color: 'black', // สีของตัวหนังสือ
        fontSize: 13, // ขนาดตัวหนังสือ
        bold: true, // ตัวหนังสือหนา
        italic: false, // ตัวหนังสือเอียง
        textAlign: 'center' // การจัดวางข้อความ (center, start, end)
      },
      backgroundColor: 'transparent',
      width: 500, // ปรับขนาดความกว้างตามที่คุณต้องการ
      height: 300, // ปรับขนาดความสูงตามที่คุณต้องการ
      // legend: { position: 'none' }
    slices: {
        0: { color: '#b91d47' },   // red
        1: { color: '#00aba9' },   // teal
        2: { color: '#2b5797' },   // blue
        3: { color: '#ff9933' },   // light brown
        4: { color: '#1e7145' },   // green
        5: { color: '#ff6666' },   // light red
        6: { color: '#006666' },   // dark teal
        7: { color: '#4d4dff' },   // indigo
        8: { color: '#ff9933' },   // orange
        9: { color: '#339966' },   // dark green

    },
};
    

    const chart = new google.visualization.PieChart(document.getElementById('dChart_har'));
    chart.draw(data_har, options);
}
</script>