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
$mpdf = new \Mpdf\Mpdf();
?>
<h1><?= $_SESSION['username']; ?></h1>
<?php 
$html = ob_get_contents();
$mpdf->WriteHTML(utf8_decode($html));
$mpdf->Output("Print Request Form.pdf","I");
exit;

?>