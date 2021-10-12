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

$id = $_GET["id"];

if (delete_userss($id) > 0) {
    echo "<script>
    alert ('User Berhasil terhapus');
    document.location.href='admin_users.php';
    </script>";
} else {
    echo "<script>
    alert ('User gagal terhapus');
    document.location.href='admin_users.php';
    </script>";
}
