<?php
// create session for login and other page
// session start
session_start();
// koneksi database
require "function.php";
// cek cookie
if (isset($_COOKIE['en']) && isset($_COOKIE['key'])) {
    $en = $_COOKIE['en'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $en");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

// session
if (isset($_SESSION["login"])) {
    header('Location: admin/index.php');
    exit;
}

// jika isset atau diset login
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek username di database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND level='4'");
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION["users_id"] = $row["id"];
            // cek remember me
            if (isset($_POST["remember"])) {
                // set cookie
                // setcookie('login', 'true', time() + 280);
                setcookie('en', $row['id'], time() + 140);
                setcookie('key', hash('sha256', $row['username']), time() + 140);
            }
            // masuk ke index jika password di verifikasi ada
            $_SESSION['username'] = $username;
            header('Location: admin/index.php');
            exit;
        }
    }
    $error = true;
}

if (isset($_SESSION["login"])) {
    header('Location: admin/staff_form.php');
    exit;
}
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek username di database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND level='3'");
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION["users_id"] = $row["id"];
            // cek remember me
            if (isset($_POST["remember"])) {
                // set cookie
                // setcookie('login', 'true', time() + 280);
                setcookie('en', $row['id'], time() + 140);
                setcookie('key', hash('sha256', $row['username']), time() + 140);
            }
            // masuk ke index jika password di verifikasi ada
            $_SESSION['username'] = $username;
            header('Location: admin/staff_form.php');
            exit;
        }
    }
    $error = true;
}

if (isset($_SESSION["login"])) {
  header('Location: admin/departement-head.php');
  exit;
}
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // cek username di database
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND level='1'");
  if (mysqli_num_rows($result) === 1) {

      // cek password
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {
          // set session
          $_SESSION["login"] = true;
          $_SESSION["users_id"] = $row["id"];
          // cek remember me
          if (isset($_POST["remember"])) {
              // set cookie
              // setcookie('login', 'true', time() + 280);
              setcookie('en', $row['id'], time() + 140);
              setcookie('key', hash('sha256', $row['username']), time() + 140);
          }
          // masuk ke index jika password di verifikasi ada
          $_SESSION['username'] = $username;
          header('Location: admin/departement-head.php');
          exit;
      }
  }
  $error = true;
}

if (isset($_SESSION["login"])) {
  header('Location: admin/director.php');
  exit;
}
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // cek username di database
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND level='2'");
  if (mysqli_num_rows($result) === 1) {

      // cek password
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {
          // set session
          $_SESSION["login"] = true;
          $_SESSION["users_id"] = $row["id"];
          // cek remember me
          if (isset($_POST["remember"])) {
              // set cookie
              // setcookie('login', 'true', time() + 280);
              setcookie('en', $row['id'], time() + 140);
              setcookie('key', hash('sha256', $row['username']), time() + 140);
          }
          // masuk ke index jika password di verifikasi ada
          $_SESSION['username'] = $username;
          header('Location: admin/director.php');
          exit;
      }
  }
  $error = true;
}

if (isset($_SESSION["login"])) {
  header('Location: admin/staff.php');
  exit;
}
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // cek username di database
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND level='3'");
  if (mysqli_num_rows($result) === 1) {

      // cek password
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {
          // set session
          $_SESSION["login"] = true;
          $_SESSION["users_id"] = $row["id"];
          // cek remember me
          if (isset($_POST["remember"])) {
              // set cookie
              // setcookie('login', 'true', time() + 280);
              setcookie('en', $row['id'], time() + 140);
              setcookie('key', hash('sha256', $row['username']), time() + 140);
          }
          // masuk ke index jika password di verifikasi ada
          $_SESSION['username'] = $username;
          header('Location: admin/staff.php');
          exit;
      }
  }
  $error = true;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Login</title>
  </head>
  <body>
  

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
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
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
    
    

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>