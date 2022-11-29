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
                                    $id = $fetch['id'];


                                ?>

                                <tr>
                                    <td>
                                        <?php echo ++$sn; ?>
                                    </td>
                                    <td><b>
                                        <?php echo $fetch['entry']; ?>
                                    </td></b>
                                    <td>
                                        <?php echo $fetch['description'] == NULL ? '-- No Response Yet --' : $fetch['description']; ?>
                                    </td>
                                    <td>                                        
                                        <form method="POST">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#edit<?php echo $id ?>">
                                                    Edit
                                                </button> -
                                                </form>  
                                                <form method="POST">                                      
                                                <input type="hidden" class="form-control" name="del_policy"
                                                    value="<?php echo $id ?>" required id="">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure about this?')">
                                                    Delete
                                                </button>
                                            </form>                                            
                                    </td>
                                </tr>

                                <div class="modal fade" id="edit<?php echo $id ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Editing</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <input type="hidden" class="form-control" name="id"
                                                            value="<?php echo $id ?>" required id="">
                                                    <p>Policy : <input type="text" class="form-control" name="entry"
                                                            value="<?php echo $fetch['entry'] ?>" required
                                                            minlength="3" id=""></p>
                                                    <p>Description : <input type="text" class="form-control" name="description"
                                                            value="<?php echo $fetch['description'] ?>" required
                                                            minlength="3" id=""></p>


                                                    <p>

                                                        <input class="btn btn-info" type="submit" value="Edit Policy"
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
                <h4 class="modal-title">Add New Policy</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-outline">
                                Name Of Policy : 
                                <textarea name="entry" id="pentry" required minlength="2" id="" cols="5" rows="5"
                                    class="form-control"></textarea>
                                <label class="form-label" for="pentry">Message</label>

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

    $policy = $_POST['entry'];
    $desc = $_POST['description'];
    $send = sendUpdatePolicy($policy, $desc);
    echo $send;
    if ($send) {
        alert('New policy has been added(The updated Policy will be seen in costumer homepage)');
    } else {
        alert('Fails to add a new policy');
    }
}

if (isset($_POST['edit'])) {

    $policy = $_POST['entry'];
    $description = $_POST['description'];
    $id = $_POST['id'];
    if (!isset($policy, $description, $id )) {
        alert("Fill Form Properly!");
    }
     else {
        $conn = connect();
        $ins = $conn->prepare("UPDATE policy SET entry = ?, description = ? WHERE id = ?");
        $ins->bind_param("ssi", $policy, $description, $id);
        $ins->execute();
        alert("policy updated");
        load($_SERVER['PHP_SELF'] . "$me");
    }
}

if (isset($_POST['del_policy'])) {
    $con = connect();
    $conn = $con->query("DELETE FROM policy WHERE id = '" . $_POST['del_policy'] . "'");
    if ($con->affected_rows < 1) {
        alert("Policy Could Not Be Deleted. This Policy Has Been Tied To Another Data!");
        load($_SERVER['PHP_SELF'] . "$me");
    } else {
        alert("Policy Deleted!");
        load($_SERVER['PHP_SELF'] . "$me");
    }
}

?>