<?php
include('koneksicovid.php');
$data = mysqli_query($koneksi, "select * from data_covid");
while ($row = mysqli_fetch_array($data)) {
    $country[] = $row['country'];
    $total_cases[] = $row['total_cases'];

}
?>
<!doctype html>
<html>

<head>
    <title>Pie Chart</title>
    <script type="text/javascript" src="Chart.js"></script>
</head>

<body>
    <div id="canvas-holder" style="width:45%">
        <canvas id="chart-area"></canvas>
    </div>
    <script>
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: <?php echo json_encode($total_cases);

                    ?>,

                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgb(29, 139, 139)',
                        'rgba(210, 38, 30, 0.3)',
                        'rgba(95, 150, 198, 0.2)',
                        'rgb(205, 92, 92)',
                        'rgba(0, 15, 255, 0.5)',
                        'rgba(229, 82, 42, 0.75)',
                        'rgb(225, 248, 220)',
                        'rgb(176, 196, 222)',
                        'rgb(119, 136, 153)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(210, 38, 30, 0.4)',
                        'rgba(95, 150, 198, 1)',
                        'rgb(189, 183, 107)',
                        'rgb(233, 150, 122)',
                        'rgba(229, 82, 42, 1)',
                        'rgb(75, 0, 130)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(6, 224, 251, 1)'
                    ],
                    label: 'Presentase covid'
                }],
                labels: <?php echo json_encode($country); ?>
            },
            options: {
                responsive: true
            }
        };
        window.onload = function () {

            var ctx = document.getElementById('chart-area').getContext('2d');

            window.myPie = new Chart(ctx, config);
        };
        document.getElementById('randomizeData').addEventListener('click',
            function () {

                config.data.datasets.forEach(function (dataset) {
                    dataset.data = dataset.data.map(function () {
                        return randomScalingFactor();
                    });
                });
                window.myPie.update();
            });
        var colorNames = Object.keys(window.chartColors);
        document.getElementById('addDataset').addEventListener('click',

            function () {

                var newDataset = {
                    backgroundColor: [],
                    data: [],
                    label: 'New dataset ' +

                        config.data.datasets.length,

                };
                for (var index = 0; index < config.data.labels.length;

                    ++index) {

                    newDataset.data.push(randomScalingFactor());
                    var colorName = colorNames[index %

                        colorNames.length];

                    var newColor = window.chartColors[colorName];
                    newDataset.backgroundColor.push(newColor);
                }
                config.data.datasets.push(newDataset);
                window.myPie.update();
            });
        document.getElementById('removeDataset').addEventListener('click',
            function () {

                config.data.datasets.splice(0, 1);
                window.myPie.update();
            });
    </script>
</body>

</html>
