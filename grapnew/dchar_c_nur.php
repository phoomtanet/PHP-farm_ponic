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
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart_nur);

function drawChart_nur() {
    // Create a two-dimensional array from PHP data
    var chartData_nur = [['Vegetable Name', 'Total Amount']];
    <?php
    for ($i = 0; $i < count($data_c_veg_nur); $i++) {
        echo "chartData_nur.push(['" . $data_c_veg_nur[$i] . "', " .  $data_n_veg_nur[$i] . "]);\n";
    }
    ?>

    const data_nur = google.visualization.arrayToDataTable(chartData_nur);

    const options = {
    title: 'กราฟแสดงจำนวนผักในแปลงอนุบาล',
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
        3: { color: '#ff9933' },   // light brown
        4: { color: '#1e7145' },   // green
        5: { color: '#ff6666' },   // light red
        6: { color: '#006666' },   // dark teal
        7: { color: '#4d4dff' },   // indigo
        8: { color: '#ff9933' },   // orange
        9: { color: '#339966' },   // dark green

    },
};
    

    const chart = new google.visualization.PieChart(document.getElementById('dChart_nur'));
    chart.draw(data_nur, options);
}
</script>