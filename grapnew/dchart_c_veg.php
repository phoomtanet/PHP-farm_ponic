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
$rs_c_veg = mysqli_query($conn, $sql_c_veg);
$data_n_veg = array();
$data_c_veg = array();

while ($row_c_veg = $rs_c_veg->fetch_assoc()) {
    $data_n_veg[] = $row_c_veg['total_amount'];
    $data_c_veg[] = $row_c_veg['vegetable_name'];
}
?>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    // Create a two-dimensional array from PHP data
    var chartData = [['Vegetable Name', 'Total Amount']];
    <?php
    for ($i = 0; $i < count($data_c_veg); $i++) {
        echo "chartData.push(['" . $data_c_veg[$i] . "', " . $data_n_veg[$i] . "]);\n";
    }
    ?>

    const data = google.visualization.arrayToDataTable(chartData);

    const options = {
    title: 'กราฟแสดงจำนวนผักในแปลงปลูก',
    pieHole: 0.3,
    titleTextStyle: {
        color: 'black', // สีของตัวหนังสือ
        // fontSize: 18, // ขนาดตัวหนังสือ
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
        3: { color: '#e8c3b9' },   // light brown
        4: { color: '#1e7145' },   // green
        5: { color: '#ff6666' },   // light red
        6: { color: '#006666' },   // dark teal
        7: { color: '#4d4dff' },   // indigo
        8: { color: '#ff9933' },   // orange
        9: { color: '#339966' },   // dark green

    },
};
    

    const chart = new google.visualization.PieChart(document.getElementById('dChart_plan'));
    chart.draw(data, options);
}
</script>