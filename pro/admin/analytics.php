    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>    
    <div class="container-fluid">
        <!-- Page Heading -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
            <div class="col-xl-8 col-md-8 mb-4" style="margin-left:130px;">
                <div class="card border-left-dark shadow h-100 py-2" style="position: relative;width:auto;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Most Type of Report</div>
                            <div class="col-auto">
                                <!-- /.container-fluid -->
                                <?php foreach ($analytics as $i)
                                    $typeIn[] = $i['type'];
                                ?>
                                <?           ?>
                                <?php foreach ($analytics as $i)
                                    $typecount[] = $i['tcount'];
                                ?>
                                <div class="chart-container" style="position: relative; height:40vh; width:40vw">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            chart.canvas.parentNode.style.height = '18px';
            chart.canvas.parentNode.style.width = '18px';
        </script>


        <script>
            //Most type of report
            const data = {
                labels: <?php echo json_encode($typeIn) ?>,
                datasets: [{
                    label: 'Type of Reports',
                    borderWidth: 1,
                    backgroundColor: ['rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: ['rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],

                    data: <?php echo json_encode($typecount) ?>,
                }],
            };

            const config = {
                type: 'bar',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
            //Most Monthh reportt            

        </script>

    <style>
        canvas {
            border: 1px dotted red;
        }
    </style>