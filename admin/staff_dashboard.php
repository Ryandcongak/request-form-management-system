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
$total = count(query("SELECT * FROM tb_requests WHERE id_users = $id_author"));
$staffs = query("SELECT * FROM tb_requests WHERE id_users = $id_author");


$succes = query("SELECT SUM(it_team) AS success FROM tb_requests WHERE id_users = $id_author");
$t = array_sum($succes[0]);
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
                                                Total Forms</div>
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
                                                Form Pending</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php $p=$total-$t; echo $p; ?></div>
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
                                                Form Success</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $t; ?></div>
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
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="10%">No. ID Request</th>
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
                                        <tr>
                                            <td><?= $staff['id']; ?></td>
                                            <td><?= $staff['requests_choose']; ?></td>
                                            <td><?= $staff['today_date']; ?></td>
                                            <td><?= $staff['date_needed']; ?></td>
                                            <!-- <td></td> -->
                                            <td><?php echo ($staff['director']==0) ?"<span class='bg-warning'>Pending</span>" : "<span class='bg-success' style='color:#fff'>Approved</span>"; ?></td>
                                            <td><?php echo ($staff['it_team']==0) ?"<span class='bg-warning'>Pending</span>" : "<span class='bg-success' style='color:#fff'>Approved</span>"; ?></td>
                                            <td><?php echo ($staff['status']==0) ?"<span class='bg-warning'>Dalam Proses</span>" : "<span class='bg-success' style='color:#fff'>DONE</span>";?></td>
                                            <td class="text-center">
                                                <a href="staff_form_review.php?id=<?= $staff['id']; ?>" class="m-4">Review Details</a></td>
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