<?php
session_start();
include "function.php";
if(isset($_POST['login'])){
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
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <!-- style -->
    <?php require "assets/login-style/style.php"; ?>

    <title>Login</title>
  </head>
  <body>
  <?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan']=="gagal"){
			echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
		}
	}
	?>

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('assets/images/login.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>IT Request Form</strong></h3>
            <p class="mb-4">What you want what you get</p>
            <form action="" method="post">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Your Usename" name="username" id="username">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Your Password" id="password" name="password">
              </div>

              <input type="submit" name="login" value="Log In" class="btn btn-block btn-primary">

            </form>
          </div>
        </div>
      </div>
    </div>
    <?php if (isset($error)) : ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>
                                    Username / Password is wrong 
                                </div>
                            </div>
                        <?php endif; ?>

    
  </div>
    <!-- script -->
    <?php require "assets/login-style/script.php"; ?>
  </body>
</html>