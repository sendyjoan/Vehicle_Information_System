<?php 
  $validation = true;
  if (isset($_POST['register'])) {
    include_once("config.php");
    var_dump($_POST);
    if ($_POST['password'] === $_POST['repassword']) {
      $email = $_POST['email'];
      $result = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE email = '$email'");
      if (mysqli_fetch_assoc($result)) {
        echo "<script>
         alert('Proses Registrasi Gagal! Email Sudah Digunakan! Silahkan Isi Kembali Email Anda')
           </script>";
        $validation = false;
      }elseif( registrasi($_POST) > 0){
        echo "<script>
            alert('Selamat anda telah terdaftar! Silahkan melakukan Login!')
            document.location.href = 'login.php';
            </script>";
      }else{
        echo "<script>
            alert('Proses Registrasi Gagal!')
            </script>";
      }
    }else{
      echo '<script> alert("Proses Registrasi Gagal! Password Tidak Sesuai! Silahkan Isi Kembali Password Anda"); </script>';
      $validation = false;
    }
  }else{
    session_start();
    if (isset($_SESSION['iduser'])) {
      echo "<script>
            document.location.href = 'index.php';
              </script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="public/img/favicon.png" type="">
  <title>SIKKB | Register </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    body{
      background-image: url('public/img/bg-mobil.png');
      background-repeat: no-repeat;
      background-position: left bottom;
      background-size: auto 50%;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a class="h1"><b>Portal SIKKB</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new account</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="fullname" placeholder="Full name" required value="<?php if (!$validation) { echo $_POST['fullname']; } ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required value="<?php if (!$validation) { echo $_POST['email']; } ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="repassword" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login.php" class="text-center">I already have a account</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
