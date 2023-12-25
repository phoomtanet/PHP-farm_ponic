// Fetch data from PHP script
fetch('data_harvestMonth.php')
    .then(response => response.json())
    .then(data => {
        // Get canvas element and context
        var canvas = document.getElementById('lineChart');
        var ctx = canvas.getContext('2d');

        // Create a line chart
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.data_name_month,
                datasets: [{
                    label: 'จำนวนการเก็บเกี่ยวแต่ละเดือน',
                    data: data.data_total_amountVeg,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        type: 'category',
                        labels: data.data_name_month,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Amount'
                        }
                    }]
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    });
