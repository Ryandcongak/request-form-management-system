<?php
require "function.php";
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

    <title>Register</title>
  </head>
  <body>
  <?php
        if (isset($_POST["register"])) {
            if (registrasi($_POST) > 0) {
                echo "<div class='alert alert-success' role='alert'>
                <h4 class='alert-heading'>Register Berhasil!</h4>
              </div>";
            } else {
                echo mysqli_error($conn);
            }
        }
        ?>

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('assets/images/register.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Register to <strong>IT Request Form</strong></h3>
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

              <div class="form-group last mb-3">
                <label for="re-password">Re-Password</label>
                <input type="password" class="form-control" placeholder="Your Re-Password" id="re-password" name="password2">
              </div>

              <div class="form-group last mb-3">
                <label for="level">level</label>
                <select class="form-control" aria-label="Default select example" name="level">
                  <option selected>-- Pilih level employee --</option>
                  <option value="1">Departemen Head</option>
                  <option value="2">Director</option>
                  <option value="3">Staff</option>
                  <option value="4"></option>
                </select>
              </div>
              
              <button type="submit" name="register" class="btn btn-block btn-primary">Register</button>

            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>