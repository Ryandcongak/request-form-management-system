<?php
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
if (isset($_POST["send"])) {
    if (requestForm($_POST) > 0) {
        echo "<script>
        alert('Request form berhasil dikirim');
        document.location.href='staff_dashboard.php';
        </script>";
        include("mail.php");
    } else {
        echo "<script>
        alert('Request form gagal terkirim');
        document.location.href='staff_form.php';
        </script>";  
        // echo mysqli_error($conn);
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

    <title>Request Form</title>

    <!-- Style -->
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

                <!-- Topbar -->
                <?php require "staff/nav-staff.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Form Request</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <input type="text" name="status" id="status" value="0" hidden>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="date needed" class="form-label">Date Needed by :</label>
                                                        <input type="date" class="form-control" name="date_needed" id="date_needed">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="checkbox" class="from-label "> Type of Request (Choose all that apply)</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="hardware" id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                Hardware (Computer, Printer, etc)
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="networking" id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                Networking
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="windows login" id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                Windows Login
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="email" id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                Email
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="server access" id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                Server Access
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="cs software" id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                CS Software (Set up, login user, ect)
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="requests_choose[]" value="file sharing" id="flexCheckIndeterminate" onclick="myFunction()">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                File Sharing
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3" id="divSharing">
                                                        <label for="exampleFormControlTextarea1" class="form-label">Please note folder/file need to share</label>
                                                        <textarea class="form-control" name="notes_sharing" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlTextarea1" class="form-label">Other Notes :</label>
                                                        <textarea class="form-control" name="notes_others" id="notes_other" rows="3" placeholder="IInput your other notes"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="requestor name" class="form-label">Requestor's Name</label>
                                                        <input type="text" class="form-control" name="requestors_name" placeholder="Name Request">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depart" class="form-label">Departement</label>
                                                        <input type="text" class="form-control" placeholder="<?= $_SESSION['users_depart']; ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="today date" class="form-label">Today's Date</label>
                                                        <input type="date" class="form-control"  value="<?php $today = date("Y-m-d"); echo $today; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="submit" name="send" class="btn btn-primary">Send</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                </div>
                            </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Indolinen 2021</span>
                    </div>
                </div>
            </footer>
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

    <!-- script -->
        <?php require "../assets/style/scripts.php"; ?>
    <!-- end script -->
    <script>
        function myFunction() {
        var i = document.getElementById("divSharing");
        if(i.style.display === "block"){
            i.style.display = "none";
        }else
        {
            i.style.display= "block";
        }
    }
</script>
</body>

</html>