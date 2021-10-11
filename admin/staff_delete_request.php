<?php
// seesion start
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
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
