


<?php 
$sql_sg = "SELECT v.vegetable_name ,IFNULL(SUM(sg.germination_amount), 0) AS total_sg 
FROM `tb_seed_germination` as sg
INNER JOIN tb_greenhouse as g on sg.id_greenhouse = g.id_greenhouse
INNER JOIN tb_veg_farm as vf on vf.id_veg_farm = sg.id_veg_farm
INNER JOIN tb_vegetable as v on v.id_vegetable = vf.id_vegetable
WHERE g.id_greenhouse = '$id_greenhouse_session'
GROUP BY v.id_vegetable";




$rs_sg_veg = mysqli_query($conn, $sql_sg);
$data_sg_veg = array();
$data_csg_veg = array();

while ($row_sg_veg = $rs_sg_veg->fetch_assoc()) {
    $data_sg_veg[] = $row_sg_veg['total_sg'];
    $data_csg_veg[] = $row_sg_veg['vegetable_name'];
}

?>


<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart_sg);

function drawChart_sg() {
    // Create a two-dimensional array from PHP data
    var chartData_sg = [['Vegetable Name', 'Total Amount']];
    <?php
    for ($i = 0; $i < count($data_csg_veg); $i++) {
        echo "chartData_sg.push(['" . $data_csg_veg[$i] . "', " .  $data_sg_veg[$i] . "]);\n";
    }
    ?>

    const data_har = google.visualization.arrayToDataTable(chartData_sg);

    const options = {
    title: 'กราฟแสดงจำนวนผักที่เพาะเมล็ด',
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
    

    const chart = new google.visualization.PieChart(document.getElementById('dChart_sg'));
    chart.draw(data_har, options);
}
</script>