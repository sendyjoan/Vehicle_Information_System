<?php
  $validation = true;
  if (isset($_POST['signin'])) {
    include_once("config.php");
    if (validateEmail($_POST)) {
      echo "<script>
         alert('Proses Login Gagal! Email Tidak Terdaftar! Silahkan Isi Kembali Email Anda')
           </script>";
    }elseif (validatePass($_POST)) {
      echo "<script>
         alert('Proses Login Gagal! Password Salah! Silahkan Isi Kembali Password Anda')
           </script>";
    }else{
      $email = $_POST['email'];
      $password = $_POST['password'];
      $cek = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE email = '$email'");
      
      if( mysqli_num_rows($cek) === 1 ) {
          $row = mysqli_fetch_assoc($cek);
          if( password_verify($password, $row["password"]) ) {
            session_start();
            $_SESSION['iduser'] = $row['id'];
            $_SESSION['isAdmin'] = $row['isAdmin'];
            echo "<script>
            alert('Proses Login Berhasil!')
            document.location.href = 'index.php';
              </script>";
          }
      }
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
  <title>SIKKB | Log in </title>

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
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a class="h1"><b>Portal SIKKB</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Username atau Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="signin" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new account</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
