<?php
// mengaktifkan session pada php
session_start();
 
// menghubungkan php dengan koneksi database
include "function.php";
 
// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = md5($_POST['password']);
 
 
// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
 
	// cek jika user login sebagai admin
	if($data['level']=="head"){
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "head";
		// alihkan ke halaman dashboard admin
		header("location: admin/departement-head.php");
 
	// cek jika user login sebagai pegawai
	}else if($data['level']=="director"){
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "director";
		// alihkan ke halaman dashboard pegawai
		header("location: admin/director_dashboard.php");
 
	// cek jika user login sebagai pengurus
	}else if($data['level']=="staff"){
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "staff";
		// alihkan ke halaman dashboard pengurus
		header("location: admin/staff_form.php");
 
  }else if($data['level']=="admin"){
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "admin";
		// alihkan ke halaman dashboard pengurus
		header("location: admin/admin_dashboard.php");

	}else{
 
		// alihkan ke halaman login kembali
		header("location: index.php");
	}	
}else{
	header("location: index.php");
}
 
?>