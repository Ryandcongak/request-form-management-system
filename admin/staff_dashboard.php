<?php

use function PHPSTORM_META\map;
session_start();
if (!isset($_SESSION['level'])) {
  header('location: ../index.php');
  exit;
}
if($_SESSION['level'] != "staff")
{
    header('location: ../index.php');
    exit;
}
require "../function.php";
$id_author =$_SESSION['users_id'];
$staffs = query("SELECT * FROM tb_requests WHERE id_users = $id_author");
$total = count($staffs);

$succes = query("SELECT COUNT(id) AS success FROM tb_requests WHERE id_users = $id_author AND it_team = 0");
$t = count($succes);

function checkTotal($code, $id){
    return selectConditionQuery("SELECT COUNT(id) AS total FROM tb_requests WHERE id_users = $id AND status = $code", "total");
}

$total_rejects = checkTotal(2, $id_author);
$total_done = checkTotal(1, $id_author);

$no = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard <?= $_SESSION['users_depart']; ?></title>

    <!-- style -->
    <?php require "../assets/style/style.php"; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require "staff/sidebar-staff.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php require "staff/nav-staff.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Request -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Request Created</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total; ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Pending -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            TOTAL REQUEST WAITING FOR IT APPROVAL</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $t; ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Success -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            TOTAL REQUEST REJECTED</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_rejects; ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Form Success -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            TOTAL REQUEST DONE</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                             <?= $total_done ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Request</h6>
                            <a href="excel_export_staff.php" class="btn btn-success"><i class="bi bi-download"></i> Export to Excel</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th>Type Request</th>
                                            <th>request date</th>
                                            <th>Needed date</th>
                                            <th>Director</th>
                                            <th>IT</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($staffs as $staff): ?>
                                        <?php $no++; ?>
                                        <?php 
                                            // kome to array
                                            $types = $staff['requests_choose'];
                                            $types_array = explode(',', $types);
                                        ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>
                                                <?php 
                                                    for($i = 0; $i < count($types_array); $i++){
                                                        ?>
                                                            <span class='badge badge-primary'><?= $types_array[$i]; ?></span>
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                            <td><?= date("D, d F Y", strtotime($staff['today_date'])); ?></td>
                                            <td><?= date("D, d F Y", strtotime($staff['date_needed'])); ?></td>
                                            <td><?php echo ($staff['director']==0) ? "<span class='badge badge-warning'>Pending</span>" : "<span class='badge badge-success'>Approved</span>"; ?></td>
                                            <td><?php echo ($staff['it_team']==0) ?"<span class='badge badge-warning'>Pending</span>" : "<span class='badge badge-success'>Approved</span>"; ?></td>
                                            <td>
                                                <?php 
                                                    switch($staff['status']){
                                                        case 0 :
                                                            ?>
                                                                <span class='badge badge-warning'>In Progress</span>
                                                            <?php
                                                        break;

                                                        case 1 :
                                                            ?>
                                                                <span class='badge badge-success'>Done</span>
                                                            <?php
                                                        break;

                                                        case 2 :
                                                            ?>
                                                                <span class='badge badge-danger'>Rejected</span>
                                                            <?php
                                                        break;
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center form-inline">
                                                <a href="staff_form_review.php?id=<?= $staff['id']; ?>" class="btn btn-primary btn-sm my-1" style="margin-right: 5px;">Review Details</a>

                                                <form class="" action="" method="post">
                                                    <input type="text" name="id" value="<?= $staff['id']; ?>" hidden>
                                                    <input type="text" name="cancelation" value="1" hidden>
                                                    <button type="submit" name="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Cancel</button>
                                                </form>
                                                <?php
                                                if(isset($_POST['submit'])){
                                                    if (statusCancel($_POST) > 0) {
                                                        echo "<script>
                                                        document.location.href='staff_dashboard.php';
                                                        </script>";
                                                        header('Refresh:0');
                                                    } else {
                                                        echo "<script>
                                                        alert('Request tidak berhasil di cancel');
                                                        document.location.href='staff_dashboard.php';
                                                        </script>";
                                                        header('Refresh:0');
                                                    }   
                                                } 
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require "footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <?php require "../assets/style/scripts.php"; ?>

</body>

</html>