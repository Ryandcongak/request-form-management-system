<?php
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

$id = $_GET["id"];

if (delete_form($id) > 0) {
    echo "<script>
    alert ('Request Form Berhasil terhapus');
    document.location.href='admin_dashboard.php';
    </script>";
    header("Request:0");
} else {
    echo "<script>
    alert ('Request Form Belum terhapus');
    document.location.href='admin_dashboard.php';
    </script>";
    header("Request:0");
}
