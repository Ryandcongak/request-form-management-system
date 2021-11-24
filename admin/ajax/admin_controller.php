<?php 
    require "../../function.php";

    $mode = $_GET['mode'];

    switch($mode){
        case "update":
            changeStatus();
        break;
    }

    function changeStatus(){
        $status = $_POST['status']; 
        $kolom = $_POST['kolom'];
        $id = $_POST['id'];

        $query = "UPDATE tb_requests SET $kolom=$status WHERE id = $id";
        $res = updateTable($query);

        echo $res;
    }
?>