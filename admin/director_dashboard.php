<?php

use function PHPSTORM_META\map;
session_start();
if (!isset($_SESSION['level'])) {
  header('location: ../index.php');
  exit;
}
if($_SESSION['level'] != "director")
{
    header('location: ../index.php');
    exit;
}
require "../function.php";
$total = count(query("SELECT * FROM tb_requests"));
$datas = query("SELECT * FROM tb_requests ORDER BY today_date DESC");
$succes = query("SELECT SUM(director) AS success FROM tb_requests");
$t = array_sum($succes[0]);

$selects = query("SELECT u.depart, i.id, i.requestors_name, i.today_date, i.date_needed, i.notes_sharing,i.notes_others,i.director, i.it_team, i.status, i.done_by FROM users AS u INNER JOIN tb_requests AS i ON u.id = i.id_users WHERE i.cancelation =0 ORDER BY i.today_date DESC")

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard DIRECTOR</title>
    <!-- style -->
    <?php require "../assets/style/style.php"; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require "director/sidebar-director.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php require "director/nav-director.php"; ?>

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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php $p = $total-$t; echo $p; ?></div>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= $t; ?></div>
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
                                            <th style="width: 5%;">No. ID Request</th>
                                            <th>Requestor Name</th>
                                            <th>Departement</th>
                                            <th>Details</th>
                                            <th>request date</th>
                                            <th>Needed date</th>
                                            <th>Director</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($selects as $data): ?>
                                        <tr>
                                            <td><?= $data['id']; ?></td>
                                            <td><?= $data['requestors_name']; ?></td>
                                            <td><?= $data['depart']; ?></td>
                                            <td><a href="director_view_request.php?id=<?= $data['id'];?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik Untuk Lihat Detail Request">View Details</a></td>
                                            <td><?= $data['today_date']; ?></td>
                                            <td><?= $data['date_needed']; ?></td>
                                            <td><?php echo ($data['director']==0) ?"<span class='bg-warning'>Pending</span>" : "<span class='bg-success fw-bold' style='color : #ffffff'>Approved</span>"; ?></td>
                                            <td><?php $by = $data['done_by']; echo ($data['status']==0) ?"Dalam Proses" : "<span class='bg-success fw-bold' style='color : #ffffff'>DONE by $by </span>"; ?></td>
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