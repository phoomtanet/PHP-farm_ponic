// chart_slot.js
document.addEventListener('DOMContentLoaded', function () {
    fetchDataForChart();
});

function fetchDataForChart() {
    fetch('data_plotslot.php')
        .then(response => response.json())
        .then($data_slot => {
            createBarChart($data_slot.data_name_plot, $data_slot.data_slot);
        });
}

function createBarChart(xData, yData) {
    var ctx = document.getElementById('scatterPlot').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: xData,
            datasets: [{
                label: 'จำนวนต้น',
                data: yData,
                backgroundColor: 'rgba(56, 166, 245, 1)',
                barThickness: 15 // เพิ่ม property barThickness เพื่อกำหนดขนาดของแท่ง
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
                    text: 'จำนวนต้นในแต่ละแปลง',
                    font: {
                        size: 16, // Set the font size
                    },
                },
            },
        }
        
    });
}

