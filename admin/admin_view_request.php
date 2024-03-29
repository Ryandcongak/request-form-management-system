<?php

use function PHPSTORM_META\map;
session_start();
if (!isset($_SESSION['level'])) {
  header('location: ../index.php');
  exit;
}
if($_SESSION['level'] != "it")
{
    header('location: ../index.php');
    exit;
}
require "../function.php";
$id = $_GET['id'];
$datas = query("SELECT * FROM tb_requests WHERE id = $id")[0];

if (isset($_POST["approve"])) {
    $test = approveRequestForm($_POST);
    if ($test > 0) {
        echo "<script>
            alert('Approve Successfully');
            document.location.href='admin_dashboard.php';
            </script>";
    } else {
        echo "<script>
            alert('Approve No Successfully');
            console.log('".$test."')
            </script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin View Request</title>

    <!-- style -->
    <?php require "../assets/style/style.php"; ?>

</head>
<body id="page-top" class="example-screen">
    
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require "admin/sidebar-admin.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php require "admin/nav-admin.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <div class="row">
                    <div class="col-sm-12">
                        <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Details Form</h1>
                        <a href="print.php?id=<?= $datas['id'];?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_BLANK"><i
                                class="fas fa-download fa-sm text-white-50"></i> Print Review</a>
                    </div>
                    </div>
                </div>

                    <div class="row">
                        
                        <div class="col-sm-12 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-4">
                                    <h6 class="m-0 font-weight-bold text-primary">Details and Approve</h6>
                                </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="date needed" class="form-label">Date Needed by :</label>
                                                <input type="text" class="form-control" name="date_needed" id="date_needed" placeholder="<?= $datas['today_date']; ?> " disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Request Choose : </label>
                                                <textarea class="form-control" name="notes_sharing" id="exampleFormControlTextarea1" rows="3" placeholder="<?= $datas['requests_choose']; ?>" disabled></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Note folder/file need to share : </label>
                                                <textarea class="form-control" name="notes_sharing" id="exampleFormControlTextarea1" rows="3" placeholder="<?= $datas['notes_sharing']; ?>" disabled></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Other Notes :</label>
                                                <textarea class="form-control" name="notes_others" id="notes_other" rows="3" placeholder="<?= $datas['notes_others']; ?>" disabled></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="rq_code" class="form-label">Request Code</label>
                                                <input type="text" class="form-control" placeholder="<?= $datas['rq_code']; ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="requestor name" class="form-label">Requestor's Name</label>
                                                <input type="text" class="form-control" placeholder="<?= $datas['requestors_name']; ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="requestor name" class="form-label">Departement</label>
                                                <input type="text" class="form-control text-uppercase" placeholder=" <?= $_SESSION['users_depart']; ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="today date" class="form-label">Edit</label>
                                                <input type="text" class="form-control"  placeholder="<?= $datas['today_date']; ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <form action="" method="post">
                                                    <input type="text" name="id" value="<?= $datas['id']; ?>" hidden>
                                                    <input type="text" name="it_team" value="1" hidden>
                                                    <button type="submit" name="approve" class="btn btn-success"><h4> Approve</h4></button>
                                                </form>
                                                <form action="" method="post">
                                                    <input type="text" name="id" value="<?= $datas['id']; ?>" hidden>
                                                    <input type="text" name="it_team" value="2" hidden>
                                                    <button type="submit" name="rejected" class="btn btn-danger"><h4> Reject</h4></button>
                                                </form>
                                                <a href="admin_dashboard.php" class="btn btn-warning"> Back to Dashboard </a>
                                            </div>
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