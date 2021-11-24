<?php
// Connection Database
$conn = mysqli_connect("localhost", "root", "", "it_indolinen");

/* ===================================================READ QUERY FUNCTION========================================================================*/
// READ
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function queryAdmin($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


/* ===================================================REQUEST FORM CREATE==============================================================================*/
function requestForm($data)
{
    global $conn;

    $requestors_name =htmlspecialchars($data["requestors_name"]) ;
    $today_date = date('Y-m-d');
    $date_needed = htmlspecialchars($data["date_needed"]);
    $requests_choose = implode(',',$data['requests_choose']);
    $notes_sharing = htmlspecialchars($data["notes_sharing"]);
    $notes_others = htmlspecialchars($data['notes_others']);
    $status = htmlspecialchars($data['status']);
    $id_author = $_SESSION['users_id'];

        $query = "INSERT INTO tb_requests VALUES 
        ('',
            '$requestors_name',
            '$today_date',
            '$date_needed',
            '$requests_choose',
            '$notes_sharing',
            '$notes_others',
            '',
            '',
            '$status',
            '',
            '',
            '$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
}

function approveRequestForm($data)
{
    global $conn;

    $id = $data["id"];
    $it_team = $data["it_team"];

    $query = "UPDATE `tb_requests` SET `it_team` = '$it_team' WHERE `tb_requests`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function statusOK($data)
{
    global $conn;

    $id = $data["id"];
    $status = $data["status"];
    $done_by =$data["done_by"];

    $query = "UPDATE `tb_requests` SET `status` = '$status', `done_by`='$done_by' WHERE `tb_requests`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function statusCancel($data)
{
    global $conn;
    $id = $data['id'];
    $cancel = $data['cancelation'];

    $query = "UPDATE `tb_requests` SET `cancelation` = '$cancel' WHERE `tb_requests`.`id` = '$id';";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function approveRequestFormDirector($data)
{
    global $conn;

    $id = $data["id"];
    $director = $data["director"];

    $query = "UPDATE `tb_requests` SET `director` = '$director' WHERE `tb_requests`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function searchStaff($keyword)
{
    $id_author = $_SESSION['users_id'];
    if($keyword == ""){
        $query = "SELECT * FROM tb_requests WHERE id_users = $id_author AND cancelation = '0'";
        return query($query);
    }   
    $query = "SELECT * FROM tb_requests WHERE id LIKE '%$keyword%' OR requestors_name LIKE '%$keyword%' OR today_date LIKE '%$keyword%' OR date_needed LIKE '%$keyword%' AND cancelation =0 AND id_users = $id_author; ";
    return query($query);
}

function search($keyword)
{
    $id_author = $_SESSION['users_id'];
    if($keyword == ""){
        $query = "SELECT * FROM tb_requests WHERE id_users = $id_author AND cancelation = '0'";
        return query($query);
    }  
    $query = "SELECT u.depart, i.id, i.requestors_name, i.today_date, i.date_needed, i.notes_sharing,i.notes_others,i.director, i.it_team, i.status, i.done_by FROM users AS u INNER JOIN tb_requests AS i ON u.id = i.id_users WHERE i.id LIKE '%$keyword%' OR i.requestors_name LIKE '%$keyword%' OR i.today_date LIKE '%$keyword%' OR i.date_needed LIKE '%$keyword%'";
    return query($query);
}
function searchAdmin($keyword)
{
    $id_author = $_SESSION['users_id'];
    if($keyword == ""){
        $query = "SELECT * FROM tb_requests WHERE id_users = $id_author AND cancelation = '0'";
        return query($query);
    }  
    $query = "SELECT u.depart, i.id, i.requestors_name, i.today_date, i.date_needed, i.notes_sharing,i.notes_others,i.director, i.it_team, i.status, i.done_by FROM users AS u INNER JOIN tb_requests AS i ON u.id = i.id_users WHERE i.id LIKE '%$keyword%' OR i.requestors_name LIKE '%$keyword%' OR i.today_date LIKE '%$keyword%' OR i.date_needed LIKE '%$keyword%'";
    return query($query);
}

function delete_form($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_requests WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function delete_userss($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    return mysqli_affected_rows($conn);
}


function registrasi($data_register)
{
    global $conn;

    $username = strtolower(stripslashes($data_register['username']));
    $password = md5($data_register['password']);
    $depart = htmlspecialchars(($data_register['depart']));
    $level = htmlspecialchars($data_register['level']);

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = 
    '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah terdaftar, gunakan Username lain!');</script>";
        return false;
    }

    mysqli_query($conn, "INSERT INTO users VALUES ('','$username','$password','$depart','$level')");
    return mysqli_affected_rows($conn);
}
// Registration Upload
function upload_ss()
{
    $namafile = $_FILES['ss_transfer']['name'];
    $ukuranfile = $_FILES['ss_transfer']['size'];
    $error = $_FILES['ss_transfer']['error'];
    $tmpName = $_FILES['ss_transfer']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert Bukti Transfer terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Maaf yang anda upload bukan Jpg, Jpeg atau Png!');</script>";
        return false;
    }
    if ($ukuranfile > 2000000) {
        echo "<script>alert('Ukuran gambar max 250kb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, 'public/assets/img/bank_transfer/' . $namafileBaru);
    return $namafileBaru;
}
// Registration Delete
function delete_users($id)
{
    global $conn;

    $pilih = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $data = mysqli_fetch_array($pilih);
    $ss_transfer = $data['ss_transfer'];

    unlink("assets/img/bank_transfer/" . $ss_transfer);

    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    return mysqli_affected_rows($conn);
}
// Registration Edit
function editusers($data)
{
    global $conn;

    $id = $data["id"];
    $category = htmlspecialchars($data["tingkat"]);
    $action = htmlspecialchars($data["aksi"]);


    $query = "UPDATE `users` SET `tingkat` = '$category', `aksi` = '$action' WHERE `users`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertData($table_name, $data)
{
    global $conn;

    // convert data to array
    $key = array_keys($data);
    $val = array_values($data);
    $sql = "insert into $table_name(" . implode(', ', $key) . ") values('" . implode("','", $val) . "')";

    $status = mysqli_query($conn, $sql);

    if ($status) {
        return true;
    } else {
        printf("Errormessage: %s\n", mysqli_error($conn));
        return false;
    }
}

function selectAllCustomQuery($query)
{
    $sql = $query;
    $res = array();

    global $conn;

    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $res[] = $row;
            }
            return $res;
            mysqli_free_result($result);
        } else {
            return 0;
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}

function selectConditionQuery($query, $value)
{
    global $conn;

    $sql = $query;
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                return $row[$value];
            }

            mysqli_free_result($result);
        } else {
            return 0;
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}

function delete($table, $id)
{
    global $conn;

    // sql to delete a record
    $sql = "DELETE FROM $table WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        return 1;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}

function updateTable($query){
    global $conn;

    $sql = $query;

    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }

    mysqli_close($conn);
}