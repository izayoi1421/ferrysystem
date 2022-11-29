<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<div class="content">
    <h5 class="mt-4 mb-2">Hi, <?php echo $fullname ?></h5>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Passengers</span>
                    <span class="info-box-number"><?php
                                                    echo $reg =  $conn->query("SELECT * FROM passenger")->num_rows;
                                                    ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <?php //readonly  
                    ?>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fa fa-train"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Ferry</span>
                    <span class="info-box-number"><?php
                                                    echo $comp = $conn->query("SELECT * FROM train")->num_rows;
                                                    ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <?php //readonly  
                    ?>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-secondary">
                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Schedules</span>
                    <span class="info-box-number"><?php echo connect()->query("SELECT * FROM schedule")->num_rows ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <?php //readonly  
                    ?>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-dollar-sign"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Payments</span>
                    <span class="info-box-number"> ₱ <?php
                                                        $row = connect()->query("SELECT SUM(amount) AS amount FROM payment")->fetch_assoc();
                                                        echo $row['amount'] == null ? '0' : $row['amount'];
                                                        ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- /.col-md-6 -->
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-primary">
                <span class="info-box-icon"><i class="fa fa-route"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Routes</span>
                    <span class="info-box-number"><?php echo connect()->query("SELECT * FROM route")->num_rows ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 50%"></div>
                    </div>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fa fa-comment-dots"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Feedbacks Received</span>
                    <span class="info-box-number"><?php echo connect()->query("SELECT * FROM feedback")->num_rows ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 50%"></div>
                    </div>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <!-- /.row -->
    <br>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12 col px-md-5">
            <?php
            $sql = "SELECT COUNT(cancel) as tcount FROM booked GROUP BY cancel";
            $conn = connect()->query($sql);
            $row = $conn->fetch_assoc();
            $hakdoggi = $row; 
            foreach ($hakdoggi as $i) {

                $lcount[] = $hakdoggi;
            }

            $sql = "SELECT COUNT(cancel) as success_count FROM booked WHERE cancel = 0";
            $conn = connect()->query($sql);
            $row = $conn->fetch_assoc();
            $success= $row['success_count'];
            foreach ($row as $i) {

                $s_count[] =  $success;
            }

            $sql = "SELECT COUNT(cancel) as failed_count FROM booked WHERE cancel = 1";
            $conn = connect()->query($sql);
            $row = $conn->fetch_assoc();

            foreach ($row as $i) {

                $s_count[] = $row['failed_count'];
            }
            ?>
            <div class="chart-container" style="position: relative; height:60vh; width:70vw;">
                <canvas id="myChart"></canvas>
            </div>
            <br>
        </div>
    </div>
</div>
<style>
    canvas#myChart {
        background-color: #f9f6f2;
        border-style: solid;
    }
</style>

<script>
    chart.canvas.parentNode.style.height = '50px';
    chart.canvas.parentNode.style.width = '50px';
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Success', 'Canceled'],
            datasets: [{
                label: ['Transaction'],
                data: <?php echo json_encode($s_count) ?>,
                borderWidth: 1,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(251, 154, 144, 1)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(251, 154, 144, 1)'
                ],
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    onClick: (evt, legendItem, legend) => {
                        const index = legend.chart.data.labels.indexOf(legendItem.text);
                        legend.chart.toggleDataVisibility(index);
                        legend.chart.update();
                    },
                    labels: {
                        generateLabels: (mychart) => {
                            let visibility = [];
                            for (let i = 0; i < mychart.data.labels.length; i++) {
                                if (mychart.getDataVisibility(i) === true) {
                                    visibility.push(false)
                                } else {
                                    visibility.push(true)
                                }
                            };
                            return mychart.data.labels.map(
                                (label, index) => ({
                                    text: label,
                                    strokeStyle: mychart.data.datasets[0].borderColor[index],
                                    fillStyle: mychart.data.datasets[0].backgroundColor[index],
                                    hidden: visibility[index]
                                })
                            )
                        }
                    }
                }
            }
        }

    });
</script>

</div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- /.col -->
</div>
<!-- /.row -->

</div>