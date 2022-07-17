<?php
  include_once("config.php");
  session_start();
  if (!isset($_SESSION['iduser']) || $_SESSION['isAdmin'] == 0) {
    echo "<script>
          document.location.href = 'login.php';
            </script>";
  }else{
    if (isset($_GET['delid'])) {
      $id = $_GET['delid'];
      mysqli_query($mysqli, "DELETE FROM tb_users WHERE id='$id'");
      echo "<script>
            alert('Proses Delete Berhasil!')
            document.location.href = 'users.php';
              </script>";
    }
    //Mengambil Data User
    $id = $_SESSION['iduser'];
    $user = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE id = '$id'");
    $user = mysqli_fetch_array($user);
    //Mengambil Data Kendaraan
    $users = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE isAdmin = 0");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="public/img/favicon.png" type="">
  <title>SIKKB | Data Pengguna</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="public/img/favicon.png" alt="AdminLTELogo" height="60" width="60">
    <h3><bold>Sistem Informasi Kepemilikan Kendaraan Bermotor</bold></h3>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="public/img/favicon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Portal | SIKKB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="public/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="./profile.php" class="d-block"><?php echo $user['nama'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="./index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="./users.php" class="nav-link active">
              <i class="nav-icon fas fa-solid fa-users"></i>
              <p>
                Data Pengguna
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="./vehicles.php" class="nav-link">
              <i class="nav-icon fas fa-solid fa-car"></i>
              <p>
                Data Kendaraan
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Pengguna Sistem Informasi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index.html">Home</a></li>
              <li class="breadcrumb-item active">Data Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <section class="content">

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Daftar Pengguna Sistem</h3>
    
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                  <thead>
                      <tr>
                          <th style="width: 20%">
                              Nama Lengkap
                          </th>
                          <th style="width: 20%">
                              Email
                          </th>
                          <th style="width: 18%" class="text-center">
                              Jumlah Kepemilikan
                          </th>
                          <th style="width: 20%">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($isi = mysqli_fetch_array($users)) { ?>
                      <tr>
                          <td>
                              <a>
                                  <?php echo $isi['nama'] ?>
                              </a>
                          </td>
                          <td>
                              <a>
                                <?php echo $isi['email'] ?>
                              </a>
                          </td>
                          <td class="text-center">
                              <?php 
                                $iduser = $isi['id'];
                                $kepemilikan = mysqli_query($mysqli, "SELECT * FROM tb_kendaraan WHERE id_user = '$iduser'");
                                $kepemilikan = mysqli_num_rows($kepemilikan);
                                echo $kepemilikan;
                              ?>
                          </td>
                          <td class="project-actions text-left">
                              <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default-<?php echo $isi['id'] ?>">
                                  <i class="fas fa-folder">
                                  </i>
                                  View
                              </a>
                              <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-danger-<?php echo $isi['id'] ?>">
                                  <i class="fas fa-trash">
                                  </i>
                                  Delete
                              </a>
                          </td>
                      </tr>
                      <?php } ?>
                  </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- modal view -->
          <?php 
          $modals = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE isAdmin = 0");
          while($modal = mysqli_fetch_array($modals)) { ?>
          <div class="modal fade" id="modal-default-<?php echo $modal['id'] ?>">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Detail User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h4 style="text-align: center;"><?php echo $modal['nama'] ?></h4>
                  <p> Email : <?php echo $modal['email'] ?></p>
                  <p> Jumlah Kendaraan : 
                  <?php 
                                $miduser = $modal['id'];
                                $mkepemilikan = mysqli_query($mysqli, "SELECT id FROM tb_kendaraan WHERE id_user = '$miduser'");
                                $mkepemilikan = mysqli_num_rows($mkepemilikan);
                                echo $mkepemilikan;
                              ?>
                  </p>
                  <p> Detail Kendaraan</p>
                  <table class="table table-striped table-dark">
                    <thead>
                      <tr>
                        <th scope="col">NOPOL</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Silinder</th>
                        <th scope="col">No Rangka</th>
                        <th scope="col">No Mesin</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $kendaraan = mysqli_query($mysqli, "SELECT * FROM tb_kendaraan WHERE id_user = '$miduser'"); 
                      while ($vehicle = mysqli_fetch_array($kendaraan)) {?>
                      <tr>
                        <td><?php echo $vehicle['nopol'] ?></td>
                        <td><?php echo $vehicle['tahunpembuatan'] ?></td>
                        <td><?php echo $vehicle['isisilinder'] ?>cc</td>
                        <td><?php echo $vehicle['norangka'] ?></td>
                        <td><?php echo $vehicle['nomesin'] ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <?php } ?>
          <!-- /.modal -->

          <!-- modal delete -->
          <?php $del = mysqli_query($mysqli, "SELECT id FROM tb_users");
          while ($d = mysqli_fetch_array($del)) {?>
          <div class="modal fade" id="modal-danger-<?php echo $d['id']; ?>">
            <div class="modal-dialog">
              <div class="modal-content bg-danger">
                <div class="modal-header">
                  <h4 class="modal-title">Hapus Data</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h4 style="text-align: center;">Anda yakin ingin menghapus?</h4>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Batal</button>
                  <a href="users.php?delid=<?php echo $d['id']; ?>" class="btn btn-outline-light" role="button">Hapus</a>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <?php } ?>
          <!-- /.modal -->
    
        </section>

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
