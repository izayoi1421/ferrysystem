<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<?php

$me = $_SESSION['user_id'];

?>

<div class="content">



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><b>Book Ferry Tickets</b></h3>
                </div>
                <div class="card-body">

                    <table id="example1" style="align-items: stretch;"
                        class="table table-hover w-100 table-bordered table-striped<?php //
                                                                                                                                    ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Route</th>
                                <th>Status</th>
                                <th>Date/Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $row = querySchedule('future');
                            if ($row->num_rows < 1) echo "<div class='alert alert-danger' role='alert'>
                            Sorry, There are no schedules at the moment! Please visit after some time.
                          </div>";
                            $sn = 0;
                            while ($fetch = $row->fetch_assoc()) {
                                //Check if the current date is same with Database scheduled date
                                $db_date = $fetch['date'];
                                if ($db_date == date('d-m-Y')) {
                                    //Oh yes, so what should happen?
                                    //Check for the time. If there is still about an hour left, proceed else, skip this data
                                    $db_time = $fetch['time'];
                                    $current_time = date('H:i');
                                    if ($current_time >= $db_time) {
                                        continue;
                                    }
                                }
                                
                                $id = $fetch['id']; ?><tr>
                                <td><?php echo ++$sn; ?></td>
                                <td><?php echo $fullname =  getRoutePath($fetch['route_id']);
                                        ?></td>
                                <td><?php $array = getTotalBookByType($id);
                                        echo ($max_first = ($array['first'] - $array['first_booked'])), " Seat(s) Available";
                                        ?></td>
                                <td><?php echo $fetch['date'], " / ", formatTime($fetch['time']); ?></td>
                                <td>
                                <?php                                 
                                    $mcap_check = connect()->query("SELECT train.first_seat as first FROM schedule INNER JOIN train ON train.id = schedule.train_id WHERE schedule.id = '$id'")->fetch_assoc();
                                    $ncap_check =  connect()->query("SELECT SUM(no) as no FROM `booked` WHERE schedule_id = '$id' AND class = 'first'")->fetch_assoc();
                                    $maxcap = $mcap_check['first'];
                                    $occupied_seat = $ncap_check['no'];
                                    echo $max_first,$array['first_booked'],$array['first'];                                    
                                    if($maxcap > $occupied_seat){                                             
                                ?>

                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#book<?php echo $id ?>">
                                        Book
                                    </button>
                                
                                <?php }else{ ?>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#book<?php echo $id ?> disable">
                                        Full
                                    </button>
                                <?php } ?>
                                </td>
                            </tr>

                            <div class="modal fade" id="book<?php echo $id ?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Book For <?php echo $fullname;


                                                                                    ?> &#9972;</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">


                                            <form action="<?php echo $_SERVER['PHP_SELF'] . "?loc=$id" ?>"
                                                method="post">
                                                <input type="hidden" class="form-control" name="id"
                                                    value="<?php echo $id ?>" required id="">

                                                <p>Number of Tickets (If you are the only one, leave as it is) :
                                                    <input type="number" min='1' value="1"
                                                        max='<?php $tempval=0; echo $max_first !=  $tempval ? $max_first : $tempval ?>'
                                                        name="number" class="form-control" id="">
                                                        <?php echo $max_first,$array['first_booked']; ?>
                                                </p>
                                                <p>
                                                    Type of Discount : <select name="classification" required class="form-control" id="">
                                                        <option value="0">Regular</option>
                                                        <option value=".20">Person With Disability (20%)</option>
                                                        <option value=".05">Senior Citizen (5%)</option>
                                                    </select>
                                                </p>
                                                <p>
                                                    Available Seat : <input type="text" value="<?php echo 'Seat(s) Available: '.($max_first); ?>" class="form-control" id="" readonly disabled>
                                                    <select name="class" required class="hide" id="" readonly>
                                                        <option value="first">First Class (₱
                                                            <?php echo ($fetch['first_fee']); ?>)</option>

                                                    </select>
                                                </p>
                                                <input type="submit" name="submit" class="btn btn-success"
                                                    value="Proceed">

                                            </form>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                <?php
                            }
                                ?>

                        </tbody>
                        
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    </form>

</div>
<style>
.hide {
  display:none;
}
</style>