<?php
if (!isset($file_access))
    die("Direct File Access Denied");
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 0;
                                $query = connect()->query("SELECT * FROM policy");

                                while ($fetch = $query->fetch_assoc()) {
                                    $id = $fetch['p_id'];


                                ?>

                                <tr>
                                    <td>
                                        <?php echo ++$sn; ?>
                                    </td>
                                    <td>
                                        <?php echo $fetch['description']; ?>
                                    </td>
                                    <td>
                                        <?php echo $fetch['policy'] == NULL ? '-- No Response Yet --' : $fetch['policy']; ?>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#edit<?php echo $fetch['p_id']; ?>">
                                                Edit
                                            </button> -

                                            <input type="hidden" class="form-control" name="del_train"
                                                value="<?php echo $fetch['id'] ?>" required id="">
                                            <button type="submit" onclick="return confirm('Are you sure about this?')"
                                                class="btn btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="edit<?php echo $fetch['p_id'] ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Editing
                                                    <?php echo $fetch['description'];


                                                    ?>
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <input type="hidden" class="form-control" name="id"
                                                        value="<?php echo $id ?>" required id="">
                                                    <p>Policy : <input type="text" class="form-control"
                                                            name="policy" value="<?php echo $fetch['description'] ?>"
                                                            required minlength="3" id=""></p>
                                                    <p>Description : <input type="text" class="form-control" name="name"
                                                            value="<?php echo $fetch['policy'] ?>" required
                                                            minlength="3" id=""></p>


                                                    <p>

                                                        <input class="btn btn-info" type="submit" value="Edit Train"
                                                            name='edit'>
                                                    </p>
                                                </form>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
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
                                Name Of Policy : <textarea name="policy" required minlength="2" id="" cols="5" rows="10"
                                    class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                Policy Description : <textarea name="description" required minlength="10" id=""
                                    cols="30" rows="10" class="form-control"></textarea>
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
if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $first_seat = $_POST['first_seat'];
    $second_seat = $_POST['second_seat'];
    $id = $_POST['id'];
    if (!isset($name, $first_seat, $second_seat)) {
        alert("Fill Form Properly!");
    } else {
        $conn = connect();
        //Check if train exists
        $check = $conn->query("SELECT * FROM train WHERE name = '$name' ")->num_rows;
        if ($check == 2) {
            alert("Train name exists");
        } else {
            $ins = $conn->prepare("UPDATE train SET name = ?, first_seat = ?, second_seat = ? WHERE id = ?");
            $ins->bind_param("sssi", $name, $first_seat, $second_seat, $id);
            $ins->execute();
            alert("Train Modified!");
            load($_SERVER['PHP_SELF'] . "$me");
        }
    }
}
if (isset($_POST['del_policy'])) {
    $con = connect();
    $conn = $con->query("DELETE FROM train WHERE id = '" . $_POST['del_train'] . "'");
    if ($con->affected_rows < 1) {
        alert("Train Could Not Be Deleted. This Train Has Been Tied To Another Data!");
        load($_SERVER['PHP_SELF'] . "$me");
    } else {
        alert("Train Deleted!");
        load($_SERVER['PHP_SELF'] . "$me");
    }
}
?>