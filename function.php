<?php
// Connection Database
$conn = mysqli_connect("localhost", "root", "", "it_indolinen");
// $conn = mysqli_connect("localhost", "lovewedd_ryand", "FHwKuU2znWbd", "lovewedd_");

/* ===================================================NAMA UNDANGAN FUNCTION========================================================================*/
// Nama Undangan Deelte
function delete_guest($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM guests WHERE id = $id");
    return mysqli_affected_rows($conn);
}

/* ===================================================REGISTRATION / USERS FUNCTION========================================================================*/
// Registration Create
function registrasi($data_register)
{
    global $conn;

    $username = strtolower(stripslashes($data_register['username']));
    $password = mysqli_real_escape_string($conn, $data_register['password']);
    $password2 = mysqli_real_escape_string($conn, $data_register['password2']);
    $level = strtolower(stripslashes($data_register['level']));

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = 
    '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah terdaftar, gunakan Username lain!');</script>";
        return false;
    }
    if ($password !== $password2) {
        echo "<script>alert('Re-Confirmasi password tidak sama !');</script>";
        return false;
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES ('','$username','$password','$level')");
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

/* ===================================================PROFIL PRIA FUNCTION========================================================================*/
// Profil Pria Check
function check_pria()
{
    global $conn;
    $id_author = $_SESSION["users_id"];
    $sql = mysqli_query($conn, "SELECT count(*) as jml FROM profil_pria WHERE id_users = '$id_author'");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 1) {
        return true;
    } else {
        return false;
    }
}
// Profil Pria Create
function create_pria($data_pria)
{
    global $conn;

    $nama_lengkap_pria = htmlspecialchars($data_pria["nama_lengkap"]);
    $nama_panggilan_pria = htmlspecialchars($data_pria["nama_panggilan"]);
    $facebook = htmlspecialchars($data_pria["facebook"]);
    $instagram = htmlspecialchars($data_pria["instagram"]);
    $twitter = htmlspecialchars($data_pria["twitter"]);
    $anak_ke_pria = htmlspecialchars($data_pria["anak_ke"]);
    $nama_bapak_pria =  htmlspecialchars($data_pria["nama_bapak"]);
    $nama_ibu_pria = htmlspecialchars($data_pria["nama_ibu"]);
    $id_author = $_SESSION["users_id"];


    $eksis = check_pria();
    if ($eksis) {
        echo "<script>
    alert ('Data Mempelai Profil Pria Sudah Ada!');
    document.location.href='profil.php';
    </script>";
    } else {

        // Upload Prodil Pria
        $foto_profil_pria = upload_pria();
        if (!$foto_profil_pria) {
            return false;
        }

        $query = "INSERT INTO profil_pria VALUES ('','$nama_lengkap_pria','$nama_panggilan_pria','$facebook','$instagram','$twitter','$anak_ke_pria','$nama_bapak_pria','$nama_ibu_pria','$foto_profil_pria','$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// Profil Pria Upload
function upload_pria()
{
    $namafile = $_FILES['foto_profil']['name'];
    $ukuranfile = $_FILES['foto_profil']['size'];
    $error = $_FILES['foto_profil']['error'];
    $tmpName = $_FILES['foto_profil']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert gambar terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 2000000) {
        echo "<script>alert('Ukuran gambar max 250kb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../client/images/' . $namafileBaru);
    return $namafileBaru;
}
// Profil Pria Edit
function editsimpanpria($data_pria)
{
    global $conn;

    $id = $data_pria["id"];
    $nama_lengkap_pria = htmlspecialchars($data_pria["nama_lengkap"]);
    $nama_panggilan_pria = htmlspecialchars($data_pria["nama_panggilan"]);
    $facebook = htmlspecialchars($data_pria["facebook"]);
    $instagram = htmlspecialchars($data_pria["instagram"]);
    $twitter = htmlspecialchars($data_pria["twitter"]);
    $anak_ke_pria = htmlspecialchars($data_pria["anak_ke"]);
    $nama_bapak_pria =  htmlspecialchars($data_pria["nama_bapak"]);
    $nama_ibu_pria = htmlspecialchars($data_pria["nama_ibu"]);
    $fotoProfilLama = htmlspecialchars($data_pria["fotoProfilLama"]);


    // cek apakah user pilih baru atau tidak
    if ($_FILES['foto_profil']['error'] === 4) {
        $foto_profil = $fotoProfilLama;
    } else {
        $foto_profil = upload_pria();
    }


    $query = "UPDATE `profil_pria` SET 
    `nama_lengkap` = '$nama_lengkap_pria', 
    `nama_panggilan` = '$nama_panggilan_pria',
    `facebook`=`$facebook`,
    `instagram`=`$instagram`,
    `twitter`=`$twitter`, 
    `anak_ke` = '$anak_ke_pria', 
    `nama_bapak` = '$nama_bapak_pria', 
    `nama_ibu` = '$nama_ibu_pria', 
    `foto_profil` = '$foto_profil' WHERE `profil_pria`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

/* ===================================================PROFIL WANITA FUNCTION========================================================================*/
// Profil Wanita Check
function check_wanita()
{
    global $conn;
    $id_author = $_SESSION["users_id"];
    $sql = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM profil_wanita WHERE id_users = '$id_author'");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 1) {
        return true;
    } else {
        return false;
    }
}
// Profil Wanita Create
function create_wanita($data_wanita)
{
    global $conn;

    $nama_lengkap_wanita = htmlspecialchars($data_wanita["nama_lengkap"]);
    $nama_panggilan_wanita = htmlspecialchars($data_wanita["nama_panggilan"]);
    $facebook = htmlspecialchars($data_wanita["facebook"]);
    $instagram = htmlspecialchars($data_wanita["instagram"]);
    $twitter = htmlspecialchars($data_wanita["twitter"]);
    $anak_ke_wanita = htmlspecialchars($data_wanita["anak_ke"]);
    $nama_bapak_wanita =  htmlspecialchars($data_wanita["nama_bapak"]);
    $nama_ibu_wanita = htmlspecialchars($data_wanita["nama_ibu"]);
    $id_author = $_SESSION["users_id"];

    $eksis = check_wanita();
    if ($eksis) {
        echo "<script>
    alert ('Data Profil Mempelai Wanita Sudah Ada!');
    document.location.href='profil.php';
    </script>";
    } else {
        // Upload Prodil Pria
        $foto_profil_wanita = upload_wanita();
        if (!$foto_profil_wanita) {
            return false;
        }
        $query = "INSERT INTO profil_wanita VALUES ('','$nama_lengkap_wanita','$nama_panggilan_wanita','$facebook','$instagram','$twitter','$anak_ke_wanita','$nama_bapak_wanita','$nama_ibu_wanita','$foto_profil_wanita','$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// Profil Wanita Upload
function upload_wanita()
{
    $namafile = $_FILES['foto_profil']['name'];
    $ukuranfile = $_FILES['foto_profil']['size'];
    $error = $_FILES['foto_profil']['error'];
    $tmpName = $_FILES['foto_profil']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert gambar terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 5000000) {
        echo "<script>alert('Ukuran gambar max 250kb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../client/images/' . $namafileBaru);
    return $namafileBaru;
}
// Profil Wanita Edit
function editsimpanwanita($data_wanita)
{
    global $conn;

    $id = $data_wanita["id"];
    $nama_lengkap_wanita = htmlspecialchars($data_wanita["nama_lengkap"]);
    $nama_panggilan_wanita = htmlspecialchars($data_wanita["nama_panggilan"]);
    $facebook = htmlspecialchars($data_wanita["facebook"]);
    $instagram = htmlspecialchars($data_wanita["instagram"]);
    $twitter = htmlspecialchars($data_wanita["twitter"]);
    $anak_ke_wanita = htmlspecialchars($data_wanita["anak_ke"]);
    $nama_bapak_wanita =  htmlspecialchars($data_wanita["nama_bapak"]);
    $nama_ibu_wanita = htmlspecialchars($data_wanita["nama_ibu"]);
    $fotoProfilLama_wanita = htmlspecialchars($data_wanita["fotoProfilLama_wanita"]);


    // cek apakah user pilih baru atau tidak
    if ($_FILES['foto_profil']['error'] === 4) {
        $foto_profil_wanita = $fotoProfilLama_wanita;
    } else {
        $foto_profil_wanita = upload_wanita();
    }


    $query = "UPDATE `profil_wanita` SET 
    `nama_lengkap` = '$nama_lengkap_wanita',
     `nama_panggilan` = '$nama_panggilan_wanita',
     `facebook` = `$facebook`,
     `instagram` = `$instagram`,
     `twitter` = `$twitter`,
      `anak_ke` = '$anak_ke_wanita',
       `nama_bapak` = '$nama_bapak_wanita',
        `nama_ibu` = '$nama_ibu_wanita',
         `foto_profil` = '$foto_profil_wanita' WHERE `profil_wanita`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

/* ===================================================RESEPSI FUNCTION========================================================================*/
// Resepsi Check
function check_resepsi()
{
    global $conn;
    $id_author = $_SESSION["users_id"];
    $sql = mysqli_query($conn, "SELECT COUNT(*) as jml FROM resepsi WHERE id_users = '$id_author'");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 1) {
        return true;
    } else {
        return false;
    }
}
// Resepsi Create
function create_resepsi($data_resepsi)
{
    global $conn;

    $hari = htmlspecialchars($data_resepsi["hari"]);
    $tanggal = htmlspecialchars($data_resepsi["tanggal"]);
    $bulan = htmlspecialchars($data_resepsi["bulan"]);
    $tahun = htmlspecialchars($data_resepsi["tahun"]);
    $jam = htmlspecialchars($data_resepsi["jam"]);
    $maps_link = htmlspecialchars($data_resepsi["maps_link"]);
    $maps_frame = htmlspecialchars($data_resepsi["maps_frame"]);
    $pengingat = htmlspecialchars($data_resepsi["pengingat"]);
    $tempat = htmlspecialchars($data_resepsi["tempat"]);
    $kalimat_pembuka = htmlspecialchars($data_resepsi["kalimat_pembuka"]);
    $kalimat = htmlspecialchars($data_resepsi["kalimat"]);
    $id_author = $_SESSION["users_id"];

    $eksis = check_resepsi();
    if ($eksis) {
        echo "<script>
    alert ('Data Resepsi Sudah Ada!');
    document.location.href='resepsi.php';
    </script>";
    } else {
        // Upload bg
        // $bg_awal = upload_bg_awal();
        // $bg_header = upload_bg_header();
        // $bg_footer =  upload_bg_footer();
        // $music = upload_music();
        // if (!$bg_awal && !$bg_header && !$bg_footer && !$music) {
        //     return false;
        // }
        $query = "INSERT INTO resepsi VALUES ('','$hari','$tanggal','$bulan','$tahun','$jam','$maps_link','$maps_frame','$pengingat','$tempat','$kalimat_pembuka','$kalimat','bg_awal.jpg','bg_header.jpg','bg_footer.jpg','backsound.mp3','$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// UPLOAD
// Resepsi Upload Background Modal
function upload_bg_awal()
{
    $namafile = $_FILES['bg_awal']['name'];
    $ukuranfile = $_FILES['bg_awal']['size'];
    $error = $_FILES['bg_awal']['error'];
    $tmpName = $_FILES['bg_awal']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert gambar terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 5000000) {
        echo "<script>alert('Ukuran gambar max 50Mb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../client/images/' . $namafileBaru);
    return $namafileBaru;
}
// Resepsi Upload Background Header
function upload_bg_header()
{
    $namafile = $_FILES['bg_header']['name'];
    $ukuranfile = $_FILES['bg_header']['size'];
    $error = $_FILES['bg_header']['error'];
    $tmpName = $_FILES['bg_header']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert gambar terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 5000000) {
        echo "<script>alert('Ukuran gambar max 250kb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../client/images/' . $namafileBaru);
    return $namafileBaru;
}
// Resepsi Upload Background Footer
function upload_bg_footer()
{
    $namafile = $_FILES['bg_footer']['name'];
    $ukuranfile = $_FILES['bg_footer']['size'];
    $error = $_FILES['bg_footer']['error'];
    $tmpName = $_FILES['bg_footer']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert gambar terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 5000000) {
        echo "<script>alert('Ukuran gambar max 50Mb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../client/images/' . $namafileBaru);
    return $namafileBaru;
}
// Resepsi Upload Music
function upload_music()
{
    $namafile = $_FILES['music']['name'];
    $ukuranfile = $_FILES['music']['size'];
    $error = $_FILES['music']['error'];
    $tmpName = $_FILES['music']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert music terlebih dahulu');</script>";
        return false;
    }
    $ekstensiMusicValid = ['mp3', 'MP3', 'Mp3'];
    $ekstensiMusic = explode('.', $namafile);
    $ekstensiMusic = strtolower(end($ekstensiMusic));
    if (!in_array($ekstensiMusic, $ekstensiMusicValid)) {
        echo "<script>alert('Yang anda upload bukan file Mp3!');</script>";
        return false;
    }
    if ($ukuranfile > 10000000) {
        echo "<script>alert('Ukuran file Mp3 max 5Gb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiMusic;

    move_uploaded_file($tmpName, '../client/music/' . $namafileBaru);
    return $namafileBaru;
}
// EDIT
// Resepsi Edit 
function editresepsi($data_resepsi)
{
    global $conn;

    $id = $data_resepsi["id"];
    $hari = htmlspecialchars($data_resepsi["hari"]);
    $tanggal = htmlspecialchars($data_resepsi["tanggal"]);
    $bulan = htmlspecialchars($data_resepsi["bulan"]);
    $tahun = htmlspecialchars($data_resepsi["tahun"]);
    $jam = htmlspecialchars($data_resepsi["jam"]);
    $maps_link = htmlspecialchars($data_resepsi["maps_link"]);
    $maps_frame = htmlspecialchars($data_resepsi["maps_frame"]);
    $pengingat = htmlspecialchars($data_resepsi["pengingat"]);
    $tempat = htmlspecialchars($data_resepsi["tempat"]);
    $kalimat_pembuka = htmlspecialchars($data_resepsi["kalimat_pembuka"]);
    $kalimat = htmlspecialchars($data_resepsi["kalimat"]);

    $query = "UPDATE `resepsi` SET `hari` = '$hari',`tanggal` = '$tanggal',`bulan` = '$bulan',`tahun` = '$tahun',`jam` = '$jam',`maps_link` = '$maps_link',`maps_frame` = '$maps_frame',`pengingat` = '$pengingat',`tempat` = '$tempat',`kalimat_pembuka` = '$kalimat_pembuka',`kalimat` = '$kalimat' WHERE `resepsi`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// Resepsi Edit Background Modal
function editbg_awal($data_resepsi)
{
    global $conn;

    $id = $data_resepsi["id"];
    $bg_awalLama = htmlspecialchars($data_resepsi["bg_awalLama"]);

    // cek apakah user pilih baru atau tidak
    if ($_FILES['bg_awal']['error'] === 4) {
        $bg_awal = $bg_awalLama;
    } else {
        $bg_awal = upload_bg_awal();
    }

    $query = "UPDATE `resepsi` SET `bg_awal` = '$bg_awal' WHERE `resepsi`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// Resepsi Edit Background Header
function editbg_header($data_resepsi)
{
    global $conn;

    $id = $data_resepsi["id"];
    $bg_headerLama = htmlspecialchars($data_resepsi["bg_headerLama"]);

    // cek apakah user pilih baru atau tidak
    if ($_FILES['bg_header']['error'] === 4) {
        $bg_header = $bg_headerLama;
    } else {
        $bg_header = upload_bg_header();
    }


    $query = "UPDATE `resepsi` SET `bg_header` = '$bg_header' WHERE `resepsi`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// Resepsi Edit Background Footer
function editbg_footer($data_resepsi)
{
    global $conn;

    $id = $data_resepsi["id"];
    $bg_footerLama = htmlspecialchars($data_resepsi["bg_footerLama"]);

    // cek apakah user pilih baru atau tidak
    if ($_FILES['bg_footer']['error'] === 4) {
        $bg_footer = $bg_footerLama;
    } else {
        $bg_footer = upload_bg_footer();
    }

    $query = "UPDATE `resepsi` SET `bg_footer` = '$bg_footer' WHERE `resepsi`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// Resepsi Edit Music
function edit_music($data_resepsi)
{
    global $conn;

    $id = $data_resepsi["id"];
    $musicLama = htmlspecialchars($data_resepsi["musicLama"]);

    // cek apakah user pilih baru atau tidak
    if ($_FILES['music']['error'] === 4) {
        $music = $musicLama;
    } else {
        $music = upload_music();
    }

    $query = "UPDATE `resepsi` SET `music` = '$music' WHERE `resepsi`.`id` = '$id'; ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

/* ===================================================FOTO FUNCTION========================================================================*/
// Gallery Foto Check
function check_galleries_foto()
{
    global $conn;
    $id_author = $_SESSION["users_id"];
    $sql = mysqli_query($conn, "SELECT COUNT(*) as jml FROM galleries_foto WHERE id_users = '$id_author'");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 15) {
        return true;
    } else {
        return false;
    }
}
// Gallery Foto Create
function create_galleries_foto()
{
    global $conn;

    $id_author = $_SESSION["users_id"];

    $eksis = check_galleries_foto();
    if ($eksis) {
        echo "<script>
    alert ('Gallery foto anda penuh!');
    document.location.href='galleries.php';
    </script>";
    } else {
        // Upload bg
        $galleries_foto = upload_gf();
        if (!$galleries_foto) {
            return false;
        }
        $query = "INSERT INTO galleries_foto VALUES ('','$galleries_foto','$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// Gallery Foto Upload
function upload_gf()
{

    $namafile = $_FILES['foto']['name'];
    $ukuranfile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert gambar terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 50000000) {
        echo "<script>alert('Ukuran gambar max 250kb');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../client/images/' . $namafileBaru);
    return $namafileBaru;
}
// Gallery Foto Delete
function delete_gf($id)
{
    global $conn;

    $pilih = mysqli_query($conn, "SELECT * FROM galleries_foto WHERE id=$id");
    $data = mysqli_fetch_array($pilih);
    $foto = $data['foto'];

    unlink("../client/images/" . $foto);

    mysqli_query($conn, "DELETE FROM galleries_foto WHERE id = $id");
    return mysqli_affected_rows($conn);
}

/* ===================================================VIDEO FUNCTION========================================================================*/
// Gallery Video Check
function check_galleries_video()
{
    global $conn;
    $id_author = $_SESSION["users_id"];
    $sql = mysqli_query($conn, "SELECT COUNT(*) as jml FROM galleries_video WHERE id_users = '$id_author'");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 1) {
        return true;
    } else {
        return false;
    }
}
// Gallery Video Create
function create_galleries_video()
{
    global $conn;

    $id_author = $_SESSION["users_id"];

    $eksis = check_galleries_video();
    if ($eksis) {
        echo "<script>
    alert ('Data Video Penuh!');
    document.location.href='galleries.php';
    </script>";
    } else {
        // Upload bg
        $galleries_video = upload_gv();
        if (!$galleries_video) {
            return false;
        }
        $query = "INSERT INTO galleries_video VALUES ('','$galleries_video','$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// Gallery Video Upload
function upload_gv()
{

    $namafile = $_FILES['video']['name'];
    $error = $_FILES['video']['error'];
    $tmpName = $_FILES['video']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert video terlebih dahulu');</script>";
        return false;
    }
    $ekstensiVideoValid = ['mp4', 'mkv'];
    $ekstensiVideo = explode('.', $namafile);
    $ekstensiVideo = strtolower(end($ekstensiVideo));
    if (!in_array($ekstensiVideo, $ekstensiVideoValid)) {
        echo "<script>alert('Yang anda upload bukan Video!');</script>";
        return false;
    }

    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiVideo;

    move_uploaded_file($tmpName, '../client/video/' . $namafileBaru);
    return $namafileBaru;
}
// Gallery Video Edit
function edit_video($data_gv)
{
    global $conn;

    $id = $data_gv["id"];
    $videoLama = htmlspecialchars($data_gv["videoLama"]);

    // cek apakah user pilih baru atau tidak
    if ($_FILES['video']['error'] === 4) {
        $video = $videoLama;
    } else {
        $video = upload_gv();
    }

    $query = "UPDATE `galleries_video` SET `video` = '$video' WHERE `galleries_video`.`id` = '$id'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// Gallery Video Delete
function delete_gv($id)
{
    global $conn;

    $pilih = mysqli_query($conn, "SELECT * FROM galleries_video WHERE id=$id");
    $data = mysqli_fetch_array($pilih);
    $video = $data['video'];

    unlink("../client/video/" . $video);

    mysqli_query($conn, "DELETE FROM galleries_video WHERE id = $id");
    return mysqli_affected_rows($conn);
}

/* ===================================================COMMENT FUNCTION========================================================================*/
// Cooment Create
function kirim_komentar($data)
{
    global $conn;

    $name = htmlspecialchars($data["name_comment"]);
    $komen = htmlspecialchars($data["comment"]);
    $kehadiran = htmlspecialchars($data["come_or_not"]);
    $id_author = $_SESSION["users_id"];

    $query = "INSERT INTO comments VALUES ('','$komen','$kehadiran','$id_author','$name')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

/* ===================================================TESTIMONI FUNCTION========================================================================*/
// Testimoni Check
function check_testimoni()
{
    global $conn;
    $id_author = $_SESSION["users_id"];
    $sql = mysqli_query($conn, "SELECT COUNT(*) as jml FROM testimoni WHERE id_users = '$id_author'");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 1) {
        return true;
    } else {
        return false;
    }
}
// Testimoni Fungsi
function testimoni($data)
{
    global $conn;

    $testi = htmlspecialchars($data["testi"]);
    $name = htmlspecialchars($data['name']);
    $id_author = $_SESSION["users_id"];

    $eksis = check_testimoni();
    if ($eksis) {
        echo "<script>
    alert ('Maaf testimoni anda sudah kami terima... :) ');
    document.location.href='index.php';
    </script>";
    } else {
        // Upload bg
        $foto = upload_love();
        if (!$foto) {
            return false;
        }
        $query = "INSERT INTO testimoni VALUES ('','$testi','$name','$foto','$id_author')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// Testimoni Upload
function upload_love()
{

    $namafile = $_FILES['foto']['name'];
    $ukuranfile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert foto terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 50000000) {
        echo "<script>alert('Ukuran gambar terlalu besar');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../assets/images/love/' . $namafileBaru);
    return $namafileBaru;
}

/* ===================================================BLOG FUNCTION========================================================================*/
// Blog Create
function blog_add($data)
{
    global $conn;

    $judul = htmlspecialchars($data["judul"]);
    $tgl = date("Y-n-j");
    $kategori = htmlspecialchars($data['kategori']);
    $content = htmlspecialchars($data['content']);
    // Upload image
    $image = upload_blog();
    if (!$image) {
        return false;
    }
    $query = "INSERT INTO blogs VALUES ('','$judul','$tgl','$kategori','$image','$content')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
// Blog Upload
function upload_blog()
{

    $namafile = $_FILES['img_content']['name'];
    $ukuranfile = $_FILES['img_content']['size'];
    $error = $_FILES['img_content']['error'];
    $tmpName = $_FILES['img_content']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Insert foto terlebih dahulu');</script>";
        return false;
    }
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namafile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>alert('Yang anda upload bukan foto!');</script>";
        return false;
    }
    if ($ukuranfile > 50000000) {
        echo "<script>alert('Ukuran gambar terlalu besar');</script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../assets/images/blog/' . $namafileBaru);
    return $namafileBaru;
}
// Blog Delete
function delete_blog($id)
{
    global $conn;

    $pilih = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
    $data = mysqli_fetch_array($pilih);
    $image = $data['img_content'];

    unlink("../client/video/" . $image);

    mysqli_query($conn, "DELETE FROM blogs WHERE id = $id");
    return mysqli_affected_rows($conn);
}

/* ===================================================Contoh Url========================================================================*/
// Check Contoh
function check_contoh()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT COUNT(*) as jml FROM contoh");
    $row_count = mysqli_fetch_array($sql);
    if ($row_count['jml'] >= 1) {
        return true;
    } else {
        return false;
    }
}
// Add Contoh
function add_contoh($data)
{
    global $conn;
    $contoh_url = htmlspecialchars($data['url']);

    $eksis = check_contoh();
    if ($eksis) {
        echo "<script>
    alert ('Maaf URL sudah ada :) ');
    document.location.href='contoh_undangan.php';
    </script>";
    } else {
        $query = "INSERT INTO contoh VALUES('','$contoh_url')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
}
// Edit Contoh
function edit_contoh($data)
{
    global $conn;

    $id = $data['id'];
    $url = htmlspecialchars($data['url']);

    $query = "UPDATE contoh SET
    `url` = '$url' WHERE `contoh`.`id` = '$id';";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}