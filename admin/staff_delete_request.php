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

$id = $_GET["id"];

if (delete_form($id) > 0) {
    echo "<script>
    alert ('Request Form Berhasil terhapus');
    document.location.href='staff_dashboard.php';
    </script>";
} else {
    echo "<script>
    alert ('Request Form Belum terhapus');
    document.location.href='staff_dashboard.php';
    </script>";
}
