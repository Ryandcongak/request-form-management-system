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
include "../vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
?>
<link rel="stylesheet" href="mpdf_bootstrap.css">
<div class="container">
  <div class="row">
    <div class="col-xs-4 header-kiri">
      <img src="../assets/images/logo.jpg" width="50%" alt="">
    </div>
    <div class="col-xs-8 header-kanan">
      <h2>INDOLINEN IT Departement</h2>
            <h5>CV. BALI RATU MANDIRI</h5>
            <p>Jalan Mahendradata No.107 Denpasar, Bali 8011 Indonesia <br>
            Telp. 0361 488429 Fax. 0361 488752 Website: www.indolinen.com</p>
    </div>
  </div>
  <div class="row">
    <hr id="line">
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
                <label for="" class="text-capitalize">Request"s Name : <b class="underline"><?= $datas["requestors_name"]; ?></b></label>
            </div>
            <div class="mb-3">
                <label for="" class="text-uppercase">Departement : <span class="underline"><?= $_SESSION["users_depart"]; ?></span></label>
            </div>
            <br><br>
            <div class="mb-3">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" checked>
                    <label class="form-check-label" for="exampleCheck1"><?= $datas["requests_choose"]; ?></label>
                  </div>
            </div>
            <div class="mb-3">
                <label for="">File Sharing : <br>
                <span class="underlinen"><?= $datas["notes_sharing"]; ?></span>
                </label>
            </div>
            <br><br>
            <div class="mb-3">
                <label for="">Other : <span class="underline"><?= $datas["notes_others"]; ?></span></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <label for="">Today"s Date : <span class="underline"><?= $datas["today_date"]; ?></span></label>
            </div>
            <div class="mb-3">
                <label for="">Date Needed by : <span class="underline"></span></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 text-center">
            <h5 class="underline">Departement Head Approve</h5>
            <h3><?php echo ($datas["head"]==0) ?"" : "<span class="fw-bold">
            <img src="../assets/ttd/qrcode.png" width="20%"><br>Approved</span>"; ?></h3>
        </div>
        <div class="col-sm-4 text-center">
            <h5 class="underline">Knowledge By Director</h5>
            <h3><?php echo ($datas["director"]==0) ?"" : "<span class="fw-bold">
            <img src="../assets/ttd/qrcode.png" width="20%"><br>Approved</span>"; ?></h3>
        </div>
        <div class="col-sm-4 text-center">
            <h5 class="underline">IT Approve</h5>
            <h3><?php echo ($datas["it_team"]==0) ?"" : "<span class="fw-bold">
            <img src="../assets/ttd/qrcode.png" width="20%"><br>Approved</span>"; ?></h3>
        </div>
    </div>
</div>
<?php 
$html = ob_get_contents();
$mpdf->WriteHTML(utf8_decode($html));
$mpdf->Output("Print Request Form.pdf","I");
exit;

?>