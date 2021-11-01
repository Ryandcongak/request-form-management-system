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
            '',
            '$status',
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
function approveRequestFormHead($data)
{
    global $conn;

    $id = $data["id"];
    $head = $data["head"];

    $query = "UPDATE `tb_requests` SET `head` = '$head' WHERE `tb_requests`.`id` = '$id'; ";
    mysqli_query($conn, $query);

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


function search($keyword)
{
    $query = "SELECT*FROM tb_requests WHERE requestors_name LIKE '%$keyword%' OR today_date LIKE '%$keyword%' OR date_needed LIKE '%$keyword%'";
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