<?php

session_start();
include "function.php";
$username = $_POST['username'];
$password = md5($_POST['password']);
$login = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
	if($data['level']=="director"){
		$_SESSION['users_id'] = $data['id'];
		$_SESSION['users_depart'] = $data['depart'];
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "director";
		header("location: admin/director_dashboard.php");
	}else if($data['level']=="staff"){
		$_SESSION['users_id'] = $data['id'];
		$_SESSION['users_depart'] = $data['depart'];
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "staff";
		header("location: admin/staff_form.php");
  }else if($data['level']=="it"){	
		$_SESSION['users_id'] = $data['id'];
		$_SESSION['users_depart'] = $data['depart'];
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "it";	
		header("location: admin/admin_dashboard.php");
	}else{
		header("location: index.php");
	}	
}else{
	header("location: index.php");
}
?>