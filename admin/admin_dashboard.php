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

$total = count(query("SELECT * FROM tb_requests"));
$datas = query("SELECT * FROM tb_requests ORDER BY today_date DESC");

$succes = query("SELECT id AS success FROM tb_requests WHERE it_team = 0");
$t = count($succes);

function checkTotal($code){
    return selectConditionQuery("SELECT COUNT(id) AS total FROM tb_requests WHERE status = $code", "total");
}

$total_rejects = checkTotal(2);
$total_done = checkTotal(1);

// $jmlperHalaman = 3;
// $jmlHalaman = ceil($total / $jmlperHalaman);
// $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
// $awalData = ($jmlperHalaman * $halamanAktif) - $jmlperHalaman;

$sql = query("SELECT u.depart, i.id, i.rq_code, i.requestors_name, i.today_date, i.date_needed, i.notes_sharing,i.notes_others,i.director, i.it_team, i.status,i.note, i.cancelation, i.done_by FROM users AS u INNER JOIN tb_requests AS i ON u.id = i.id_users WHERE i.cancelation = 0 ORDER BY i.today_date DESC");



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title class="text-uppercase">Dashboard </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
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
                                                Total Request Waiting For IT Approval</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $t;?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Reject -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Request Rejected</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_rejects; ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Done -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Request Done</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_done; ?></div>
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
                                    <a href="excel_export_admin.php" class="btn btn-success"><i class="bi bi-download"></i> Export to Excel</a>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        if(isset($_GET['del'])){
                                            ?>
                                                <div id="alert-hapus" class="alert alert-danger" role="alert">
                                                    <strong>Data telah berhasil dihapus</strong>
                                                </div>
                                            <?php
                                        }
                                    ?>                            
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">No</th>
                                                    <th>ID request</th>
                                                    <th>Requestor Name</th>
                                                    <th>Department</th>
                                                    <th>Details</th>
                                                    <th>Request date</th>
                                                    <th>Needed date</th>
                                                    <th>Director</th>
                                                    <th>IT</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $no = 0;
                                                ?>
                                                <?php foreach($sql as $data): ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?php 
                                                        $show = $data['rq_code'];
                                                        if($show == ""){
                                                            echo "-";
                                                        }else{
                                                            echo $show;
                                                        } ?>
                                                    </td>
                                                    <td><?= $data['requestors_name']; ?>
                                                    <?php
                                                        $showNote = $data['note'];
                                                        $showApprove = $data['it_team'];

                                                        if(empty($showNote) AND $showApprove=="")
                                                        {
                                                            echo "";
                                                        }
                                                        elseif(!empty($showNote) AND $showApprove==0){
                                                            echo "<span class='badge bg-warning text-white'>Note</span>";
                                                        }
                                                        elseif(!empty($showNote) AND $showApprove==1){
                                                            echo "<span class='badge bg-success text-white'>Note</span>";
                                                        }
                                                        elseif(!empty($showNote) AND $showApprove==2){
                                                            echo "<span class='badge bg-danger text-white'>Note</span>";
                                                        }
                                                    ?>
                                                    </td>
                                                    <td><?= $data['depart'];?></td>
                                                    <td>
                                                        <button type="button" onclick="openModalDetails(<?= $data['id'];?>)" class="btn btn-primary btn-sm">View Detail</button>
                                                    </td>
                                                    <td><?= date("D, d F Y", strtotime($data['today_date'])); ?></td>
                                                    <td><?= date("D, d F Y", strtotime($data['date_needed'])); ?></td>
                                                    <td>
                                                    <?php 
                                                        switch($data['director']){
                                                            case 0 :
                                                                ?>
                                                                    <span class='badge badge-warning'>Pending</span>
                                                                <?php
                                                            break;

                                                            case 1 :
                                                                ?>
                                                                    <span class='badge badge-success'>Approved</span>
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
                                                    <td>
                                                        <?php 
                                                            switch($data['it_team']){
                                                                case 0 :
                                                                    ?>
                                                                        <span class='badge badge-warning'>Pending</span>
                                                                    <?php
                                                                break;

                                                                case 1 :
                                                                    ?>
                                                                        <span class='badge badge-success'>Approved</span>
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
                                                    <td>
                                                        <?php 
                                                            switch($data['status']){
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
                                                    <td>
                                                        <a href="#" onclick="deleteThis(<?=$data['id'];?>)" class="btn btn-danger btn-sm">
                                                            Delete
                                                        </a>
                                                        <a href="staff_form_status.php?id=<?=$data['id'];?>" class="btn btn-warning btn-sm">
                                                            Edit
                                                        </a>
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
    
    <!-- Modal -->
    <div class="modal fade" id="modal_details" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <input type="hidden" id="id_modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Detail Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modal_contents" class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="printOut()"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-primary" onclick="changeStatus('it_team', 1)"><i class="fa fa-pencil-alt"></i> Approve</button>
                    <button type="button" class="btn btn-danger" onclick="changeStatus('it_team', 2)"><i class="fa fa-times"></i> Rejected</button>
                    <button type="button" class="btn btn-warning" onclick="changeStatus('it_team', 0)"><i class="fa fa-search"></i> Pending</button>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Script -->
    <?php require "../assets/style/scripts.php"; ?>
    <script>
        function deleteThis(id){
            if(confirm("Are you sure?")){
                $.ajax({
                    type: "GET",
                    url: "admin_delete_request.php?id="+id ,
                    success: function (response) {
                        window.open("http://localhost/it-request-form/admin/admin_dashboard.php?del=1","_self");
                    }
                });
            }
        } 

        function openModalDetails(id){
            var modal = new bootstrap.Modal(document.getElementById('modal_details'));

            $("#modal_contents").load("ajax/admin_view.php?id="+id);
            $("#id_modal").val(id);

            modal.show();
        }

        function changeStatus(kolom, status){
            if(confirm("Are you sure?")){
                $.ajax({
                    type: "POST",
                    url: "ajax/admin_controller.php?mode=update",
                    data: {
                        "kolom":kolom,
                        "status":status,
                        "id":$("#id_modal").val()
                    },
                    success: function (response) {
                        if(response == 1){
                            window.location.reload();
                        } else {
                            alert("Failed, Ask IT");
                        }
                    }
                });
            }
        }

        function printOut(){
            id = $("#id_modal").val();
            window.open("print.php?id="+id, "_blank");
        } 
    </script>

</body>

</html>