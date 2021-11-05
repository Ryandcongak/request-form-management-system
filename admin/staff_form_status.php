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

if (isset($_POST["submit"])) {
    if (statusOK($_POST) > 0) {
        echo "<script>
        alert('Request Terselesaikan');
        document.location.href='admin_dashboard.php';
        </script>";
    } else {
        echo "<script>
        alert('error');
        document.location.href='admin_dashboard.php';
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
                        
                        <div class="col-sm-12 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-4">
                                    <h6 class="m-0 font-weight-bold text-primary">Status</h6>
                                </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="id" value="<?= $datas['id']; ?>" hidden>
                                            <div class="mb-3">
                                            <select class="form-select form-select-lg mb-3 form-control" name="status" aria-label=".form-select-lg example">
                                                <option selected><?= ($datas['status']==0)?"Dalam Proses":"Terselesaikan"; ?></option>
                                                <option value="0"> Dalam Proses</option>
                                                <option value="1">Terselesaikan</option>
                                                
                                            </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" name="submit" class="btn btn-success"><h4>Save</h4></button>
                                                <a href="admin_dashboard.php" class="btn btn-warning">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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