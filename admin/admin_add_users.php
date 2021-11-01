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
$users = query("SELECT * FROM users");
$total_users = count(query("SELECT * FROM users"));

// Jika register di click
if (isset($_POST["submit"])) {
  if (registrasi($_POST) > 0) {
      echo "<script>
      alert('Selamat! Data anda sudah teregistrasi');
      document.location.href='admin_users.php';
      </script>";
  } else {
      echo mysqli_error($conn);
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

    <title>Add User</title>

    <!-- style -->
    <?php require "../assets/style/style.php"; ?>

</head>

<body id="page-top">

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

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="" method="post">
                                    <div class="mb-3">
                                      <label for="username" class="form-label">Username</label>
                                      <input type="text" class="form-control" name="username" id="username" placeholder="Username..">
                                    </div>
                                    <div class="mb-3">
                                      <label for="password" class="form-label">Password</label>
                                      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    </div>
                                    <div class="mb-3">
                                    <label for="depart" class="form-label">Departement :</label>
                                    <select class="form-control" name="depart" aria-label="Default select example">
                                        
                                        <option value="hrd">HRD</option>
                                        <option value="marketing">Marketing</option>
                                        <option value="accounting">Accounting</option>
                                        <option value="it">IT</option>
                                        <option value="shop">Shop</option>
                                        <option value="warehouse">Warehouse</option>
                                    </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lavel" class="form-label"> Level User</label>
                                    <select class="form-control" name="level" aria-label="Default select example">
                                        <option value="staff">Staff</option>
                                        <option value="director">Director</option>
                                        <option value="it">IT</option>
                                    </select>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                    <a href="admin_users.php" class="btn btn-secondary">Cancel</a>
                                </form>
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