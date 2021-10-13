<?php 
session_start();
if (!isset($_SESSION['level'])) {
  header('location: ../index.php');
  exit;
}
if($_SESSION['level'] != "admin")
{
    header('location: ../index.php');
    exit;
}

require "../function.php";
$id = $_GET['id'];
$datas = query("SELECT * FROM tb_requests WHERE id = $id")[0];
?>
<style>
    .underline{
    text-decoration: underline;
  }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-2">
            <img src="../assets/images/logo.jpg" width="80%" class="rounded mx-auto d-block" alt="">
        </div>
        <div class="col-sm-10 text-center">
            <h2 class="mt-1">INDOLINEN IT Departement</h2>
            <h5>CV. BALI RATU MANDIRI</h5>
            <p>Jalan Mahendradata No.107 Denpasar, Bali 8011 Indonesia <br>
            Telp. 0361 488429 Fax. 0361 488752 Website: www.indolinen.com</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <hr>
            <h4 class="underline">Request Form</p></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-1">
            <div class="mb-3">
                <label for="" class="text-capitalize">Request's Name : <b class="underline"><?= $datas['requestors_name']; ?></b></label>
            </div>
            <div class="mb-3">
                <label for="" class="text-uppercase">Departement : <span class="underline"><?= $_SESSION['users_depart']; ?></span></label>
            </div>
            <br><br>
            <div class="mb-3">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" checked>
                    <label class="form-check-label" for="exampleCheck1"><?= $datas['requests_choose']; ?></label>
                  </div>
            </div>
            <div class="mb-3">
                <label for="">File Sharing : <br>
                <span class="underlinen"><?= $datas['notes_sharing']; ?></span>
                </label>
            </div>
            <br><br>
            <div class="mb-3">
                <label for="">Other : <span class="underline"><?= $datas['notes_others']; ?></span></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <label for="">Today's Date : <span class="underline"><?= $datas['today_date']; ?></span></label>
            </div>
            <div class="mb-3">
                <label for="">Date Needed by : <span class="underline"><?= $datas['date_needed']; ?></span></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 text-center">
            <h5 class="underline">Departement Head Approve</h5>
            <h3><?php echo ($datas['head']==0) ?"" : "<span class='fw-bold'>
            <img src='../assets/ttd/qrcode.png' width='20%'><br>Approved</span>"; ?></h3>
        </div>
        <div class="col-sm-4 text-center">
            <h5 class="underline">Knowledge By Director</h5>
            <h3><?php echo ($datas['director']==0) ?"" : "<span class='fw-bold'>
            <img src='../assets/ttd/qrcode.png' width='20%'><br>Approved</span>"; ?></h3>
        </div>
        <div class="col-sm-4 text-center">
            <h5 class="underline">IT Approve</h5>
            <h3><?php echo ($datas['it_team']==0) ?"" : "<span class='fw-bold'>
            <img src='../assets/ttd/qrcode.png' width='20%'><br>Approved</span>"; ?></h3>
        </div>
    </div>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    window.print()
</script>