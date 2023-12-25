google.charts.load('current', {
    'packages': ['corechart']
  });

  google.charts.setOnLoadCallback(function() {
    fetchData_veg_c();
    fetchData_veg_ch();
    fetchData_veg_c_nur();
  });

  function fetchData_veg_c() {
    fetch('data_count_veg.php')
      .then(response => response.json())
      .then(data_veg_count => {
        drawChart(data_veg_count.data_n_veg,data_veg_count.data_c_veg);
      });
  }




  function fetchData_veg_ch() {
    fetch('data_harvest.php')
      .then(response2 => response2.json())
      .then(data_vegh_count => {
        drawChart_h(data_vegh_count.data_nh_veg, data_vegh_count.data_ch_veg);
      });
  }

  function fetchData_veg_c_nur() {
    fetch('data_count_veg_nur.php')
      .then(response3 => response3.json())
      .then(data_veg_count_nur=> {
        drawChart_nur(data_veg_count_nur.data_n_veg_nur, data_veg_count_nur.data_c_veg_nur);
      });
  }
  function drawChart_nur(data_n_veg_nur, data_c_veg_nur) {
    var chartData_nur = new google.visualization.DataTable();
    chartData_nur.addColumn('string', 'Category');
    chartData_nur.addColumn('number', 'Value');

    for (var i = 0; i < data_c_veg_nur.length; i++) {
      // แปลงค่าเป็น number ก่อนเพิ่มลงใน DataTable


      var value2 = parseInt(data_n_veg_nur[i]); // หรือ parseFloat ตามที่เหมาะสม

      chartData_nur.addRow([data_c_veg_nur[i], value2]);
    }

    var options = {
      title: 'จำนวนผักที่อนุบาล ',
      titleTextStyle: {
        color: 'black', // สีของตัวหนังสือ
        fontSize: 18, // ขนาดตัวหนังสือ
        bold: true, // ตัวหนังสือหนา
        italic: false, // ตัวหนังสือเอียง
        textAlign: 'center' // การจัดวางข้อความ (center, start, end)
      },
      pieHole: 0.4,
      backgroundColor: 'transparent',
      width: 400, // ปรับขนาดความกว้างตามที่คุณต้องการ
      height: 300, // ปรับขนาดความสูงตามที่คุณต้องการ
      // legend: { position: 'none' }
      slices: {
        0: { color: 'blue'}, 
        1: {color: 'green' },
        2: { color: 'orange' },
        3: {color: 'red'},
       4: { color: getRandomColor()}, 
       5: {color: getRandomColor()  }, 
       6: { color: getRandomColor()},
       7: {color: getRandomColor() },
      }
    };

    var chart3 = new google.visualization.PieChart(document.getElementById('Count-veg_nur'));
    chart3.draw(chartData_nur, options);
  }


  ////////////////////////////////////////////////////////////////////
  function drawChart(data_n_veg, data_c_veg) {
    var chartData = new google.visualization.DataTable();
    chartData.addColumn('string', 'Category');
    chartData.addColumn('number', 'Value');

    for (var i = 0; i < data_c_veg.length; i++) {
      // แปลงค่าเป็น number ก่อนเพิ่มลงใน DataTable


      var value = parseInt(data_n_veg[i]); // หรือ parseFloat ตามที่เหมาะสม

      chartData.addRow([data_c_veg[i], value]);
    }

    var options = {
      title: 'จำนวนผักที่ปลูก ',
      titleTextStyle: {
        color: 'black', // สีของตัวหนังสือ
        fontSize: 18, // ขนาดตัวหนังสือ
        bold: true, // ตัวหนังสือหนา
        italic: false, // ตัวหนังสือเอียง
        textAlign: 'center' // การจัดวางข้อความ (center, start, end)
      },
      pieHole: 0.4,
      backgroundColor: 'transparent',
      width: 400, // ปรับขนาดความกว้างตามที่คุณต้องการ
      height: 300, // ปรับขนาดความสูงตามที่คุณต้องการ
      // legend: { position: 'none' }
      slices: {
        0: { color: 'blue'}, 
        1: {color: 'green' },
        2: { color: 'orange' },
        3: {color: 'red'},
       4: { color: getRandomColor()}, 
       5: {color: getRandomColor()  }, 
       6: { color: getRandomColor()},
       7: {color: getRandomColor() },
      }
    };

    var chart = new google.visualization.PieChart(document.getElementById('Count-veg'));
    chart.draw(chartData, options);
  }



////////////////////////////////////////////////////////////////////////////
  function drawChart_h(data_nh_veg, data_ch_veg) {
    var chartData_h = new google.visualization.DataTable();
    chartData_h.addColumn('string', 'Category');
    chartData_h.addColumn('number', 'Value');

    for (var i = 0; i < data_ch_veg.length; i++) {
      // แปลงค่าเป็น number ก่อนเพิ่มลงใน DataTable


      var value = parseInt(data_nh_veg[i]); // หรือ parseFloat ตามที่เหมาะสม

      chartData_h.addRow([data_ch_veg[i], value]);
    }

    var options = {
      title: 'จำนวนผักเก็บเกี่ยวย้อนหลัง 30 วัน',
      titleTextStyle: {
        color: 'black', // สีของตัวหนังสือ
        fontSize: 18, // ขนาดตัวหนังสือ
        bold: true, // ตัวหนังสือหนา
        italic: false, // ตัวหนังสือเอียง
        textAlign: 'center' // การจัดวางข้อความ (center, start, end)
      },
      pieHole: 0.4,
      backgroundColor: 'transparent',
      width: 400, // ปรับขนาดความกว้างตามที่คุณต้องการ
      height: 300, // ปรับขนาดความสูงตามที่คุณต้องการ
      // legend: { position: 'none' }
      slices: {
        0: { color: 'blue'}, 
        1: {color: 'green' },
        2: { color: 'orange' },
        3: {color: 'red'},
       4: {color: getRandomColor()},
       5: {color: getRandomColor()},
       6: { color: getRandomColor() },
       7: {color: getRandomColor()},
      }
    };

    var chart_h = new google.visualization.PieChart(document.getElementById('Count-vegh'));
    chart_h.draw(chartData_h, options);
  }

  function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}