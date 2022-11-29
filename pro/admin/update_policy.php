<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'update_policy';
$me = "?page=$source";
?>


<!-- Content Header (Page header) -->
<!-- <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Feedback</h1>
            </div>

        </div>
    </div>
</section> -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">




                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="card-title"><b>List of all Policies</b></h5>
                        <div class='float-right'>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
                                Add Policy
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id='example1'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Policy</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 0;
                                $query = getUpdatedPolicy();
                                while ($row = $query->fetch_assoc()) {
                                    $sn++;
                                    echo "<tr>
                                    <td>$sn</td>
                                    <td>" . $row['description'] . "</td>
                                    <td>" . ($row['policy'] == NULL ? '-- No Response Yet --' : $row['policy']) . "</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>


                    </div>

                    <br />
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <h4 class="modal-title">Send New Feedback </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                Name Of Policy : <textarea name="policy" required minlength="2" id="" cols="5"
                                    rows="10" class="form-control"></textarea>
                            </div>
                            
                            <div class="form-group">
                                Policy Description : <textarea name="description" required minlength="10" id="" cols="30"
                                    rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                        


                        <hr>
                        <input type="submit" name="sendpolicy" class="btn btn-success" value="Send"></p>
                </form>


            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php

if (isset($_POST['sendpolicy'])) {

    $policy = $_POST['policy'];
    $desc = $_POST['description'];
    $send = sendUpdatePolicy($policy, $desc);
    echo $send;
    if ($send) {
        alert('Policy Has been Updated(The updated Policy will be seen in costumer homepage)');
    } else {
        alert('Policy Has not been Updated ');
    }
}
?>