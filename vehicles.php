<?php
  session_start();
  include_once("config.php");
  if (!isset($_SESSION['iduser'])) {
    echo "<script>
          document.location.href = 'login.php';
            </script>";
  }else{
    if (isset($_GET['delid'])) {
      $id = $_GET['delid'];
      mysqli_query($mysqli, "DELETE FROM tb_kendaraan WHERE id='$id'");
      echo "<script>
            alert('Proses Delete Berhasil!')
            document.location.href = 'vehicles.php';
              </script>";
    }elseif (isset($_POST['add'])) {
      if( addkendaraan($_POST) > 0 ) {
          echo "
            <script>
              alert('Kendaraan Berhasil Ditambahkan!');
              document.location.href = 'vehicles.php';
            </script>
          ";
      } else {
          echo "
            <script>
              alert('Kendaraan Gagal Ditambahkan!');
              document.location.href = 'vehicles.php';
            </script>
          ";
      }
    }elseif (isset($_POST['edit'])) {
      if( editkendaraan($_POST) > 0 ) {
        echo "
          <script>
            alert('Kendaraan Berhasil Diedit!');
            document.location.href = 'vehicles.php';
          </script>
        ";
    } else {
        echo "
          <script>
            alert('Kendaraan Gagal Diedit!');
            document.location.href = 'vehicles.php';
          </script>
        ";
    }
    }elseif (isset($_POST['verifikasi'])) {
      $idkendaraan = $_POST['idkendaraan'];
      mysqli_query($mysqli, "UPDATE tb_kendaraan SET isKir = '1' WHERE id = '$idkendaraan'");
      echo "
          <script>
            alert('Kendaraan Berhasil Verifikasi KIR!');
            document.location.href = 'vehicles.php';
          </script>
        ";
    }elseif (isset($_POST['tolak'])) {
      $idkendaraan = $_POST['idkendaraan'];
      mysqli_query($mysqli, "UPDATE tb_kendaraan SET isKir = '4' WHERE id = '$idkendaraan'");
      echo "
          <script>
            alert('Kendaraan Ditolak Verifikasi KIR!');
            document.location.href = 'vehicles.php';
          </script>
        ";
    }elseif (isset($_POST['upkir'])) {
      $idkendaraan = $_POST['idkendaraan'];

      $namaFile = $_FILES['gambar']['name'];
      $error = $_FILES['gambar']['error'];
      $tmpName = $_FILES['gambar']['tmp_name'];

      // cek apakah tidak ada gambar yang diupload
      if( $error === 4 ) {
        echo "<script>
            alert('Pilih gambar terlebih dahulu!');
            document.location.href = 'vehicles.php';
            </script>";
      }

      // cek apakah yang diupload adalah gambar
      $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
      $ekstensiGambar = explode('.', $namaFile);
      $ekstensiGambar = strtolower(end($ekstensiGambar));

      if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
            alert('yang anda upload bukan gambar!');
            document.location.href = 'vehicles.php';
            </script>";
        return false;
      }

      $namaFileBaru = uniqid();
      $namaFileBaru .= '.';
      $namaFileBaru .= $ekstensiGambar;

      move_uploaded_file($tmpName, 'public/img/ujikir/' . $namaFileBaru);

      mysqli_query($mysqli, "UPDATE tb_kendaraan SET kir_dokumen = '$namaFileBaru' WHERE id = '$idkendaraan'");
      $return = mysqli_affected_rows($mysqli);

      if ($return == 1) {
        mysqli_query($mysqli, "UPDATE tb_kendaraan SET isKir = 2 WHERE id = '$idkendaraan'");
        echo "<script>
            alert('Uji KIR Akan Ditinjau!');
            document.location.href = 'vehicles.php';
            </script>";
      }else{
        echo "<script>
            alert('Data Uji KIR Gagal Diunggah');
            document.location.href = 'vehicles.php';
            </script>";
      }

    }
    // Mengambil Data User
    $id = $_SESSION['iduser'];
    $user = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE id = '$id'");
    $user = mysqli_fetch_array($user);
    if ($_SESSION['isAdmin'] == 1) {
      $kendaraan = mysqli_query($mysqli, "SELECT * FROM tb_kendaraan");
      $modalkendaraan = mysqli_query($mysqli, "SELECT tb_kendaraan.id as id, nopol, tahunpembuatan, isisilinder, norangka, nomesin, warna, merk, nama, kir_dokumen FROM tb_kendaraan INNER JOIN tb_users ON tb_kendaraan.id_user = tb_users.id");
    }elseif ($_SESSION['isAdmin'] == 0) {
      $kendaraan = mysqli_query($mysqli, "SELECT * FROM tb_kendaraan WHERE id_user = '$id'");
      $modalkendaraan = mysqli_query($mysqli, "SELECT * FROM tb_kendaraan WHERE id_user = '$id'");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="public/img/favicon.png" type="">
  <title>SIKKB | Data Kendaraan</title>

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
            <a href="./index.php" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if ($_SESSION['isAdmin'] == 1) { ?>
          <li class="nav-item menu-open">
            <a href="./users.php" class="nav-link">
              <i class="nav-icon fas fa-solid fa-users"></i>
              <p>
                Data Pengguna
              </p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item menu-open">
            <a href="./vehicles.php" class="nav-link active">
              <i class="nav-icon fas fa-solid fa-car"></i>
              <p>
                Data Kendaraan
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="./logout.php" class="nav-link">
              <i class="nav-icon fas fa-solid fa-power-off"></i>
              <p>
                Logout
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
            <h1 class="m-0">Data Kendaraan Dalam Sistem Informasi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index.html">Home</a></li>
              <li class="breadcrumb-item active">Data Kendaraan</li>
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
              <h3 class="card-title">Daftar Kendaraan Dalam Sistem</h3>
                  
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>

              <?php if ($_SESSION['isAdmin'] == 0) {?>
              <div class="create text-right">
                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-create">
                  <i class="fas fa-pencil-alt">
                  </i>
                  Tambah
                </a>
              </div>
            </div>
            <?php } ?>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                  <thead>
                      <tr>
                          <th style="width: 16%">
                              Nomor Polisi
                          </th>
                          <th style="width: 16%">
                              Merk
                          </th>
                          <th style="width: 10%">
                              Warna
                          </th>
                          <th style="width: 6%" class="text-center">
                              Isi Silinder
                          </th>
                          <th style="width: 16%">
                              Tahun Pembuatan
                          </th>
                          <th style="width: 10%;">
                              Status KIR
                          </th>
                          <th style="width: 22%">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($isi = mysqli_fetch_array($kendaraan)) { ?>
                      <tr>
                          <td>
                              <a>
                                  <?php echo $isi['nopol']; ?>
                              </a>
                          </td>
                          <td>
                              <a>
                                  <?php echo $isi['merk']; ?>
                              </a>
                          </td>
                          <td>
                              <a>
                                  <?php echo $isi['warna']; ?>
                              </a>
                          </td>
                          <td class="text-center">
                              <?php echo $isi['isisilinder']; ?>cc
                          </td>
                          <td>
                              <a>
                                  <?php echo $isi['tahunpembuatan']; ?>
                              </a>
                          </td>
                          <td class="project-state">
                            <?php
                              if ($isi['isKir'] == 1) {
                                echo '<span class="badge badge-success">Terverifikasi</span>';
                              } elseif ($isi['isKir'] == 2) {
                                echo '<span class="badge badge-info">Proses Verifikasi</span>';
                              }elseif ($isi['isKir'] == 3){
                                echo '<span class="badge badge-danger">Belum Terverifikasi</span>';
                              }else{
                                echo '<span class="badge badge-danger">Gagal Verifikasi</span>';
                              }
                            ?>
                          </td>
                          <td class="project-actions text-left">
                              <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default-<?php echo $isi['id'] ?>">
                                  <i class="fas fa-folder">
                                  </i>
                                  View
                              </a>
                              <?php if ($_SESSION['isAdmin'] == 0) {?>
                                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit-<?php echo $isi['id'] ?>">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                                  Edit
                                </a>
                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-danger-<?php echo $isi['id'] ?>">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>
                                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-kir-<?php echo $isi['id'] ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                  Upload KIR
                                  </a>
                              <?php } 
                                if ($_SESSION['isAdmin'] == 1) {
                                  ?>
                                  <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-verifikasi-<?php echo $isi['id'] ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                  Verifikasi KIR
                                  </a>
                                  <?php
                                }
                              ?>
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
          <?php while($isimodal = mysqli_fetch_array($modalkendaraan)) { ?>
          <div class="modal fade" id="modal-default-<?php echo $isimodal['id'] ?>">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Detail Kendaraan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h4 style="text-align: center;"><?php echo $isimodal['nopol'] ?></h4>
                  <p> Merk : <?php echo $isimodal['merk'] ?></p>
                  <p> Isi Silinder : <?php echo $isimodal['isisilinder'] ?></p>
                  <p> Warna : <?php echo $isimodal['warna'] ?> </p>
                  <p> Tahun Pembuatan : <?php echo $isimodal['tahunpembuatan'] ?> </p>
                  <p> No Rangka : <?php echo $isimodal['norangka'] ?> </p>
                  <p> No Mesin : <?php echo $isimodal['nomesin'] ?> </p>
                  <?php if ($_SESSION['isAdmin'] == 1) {
                    echo "<p> Pemiilik : " . $isimodal['nama'] . " </p>";
                  } ?>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <!-- modal delete -->
          <div class="modal fade" id="modal-edit-<?php echo $isimodal['id'] ?>">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Kendaraan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <h5 style="text-align: center;">Silahkan Memasukkan Data</h5>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">No. Polisi</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="nopol" value="<?php echo $isimodal['nopol'] ?>" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Merk</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"name="merk" value="<?php echo $isimodal['merk'] ?>" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Warna</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="warna" value="<?php echo $isimodal['warna'] ?>" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Isi Silinder</span>
                      </div>
                      <input type="number" min="100" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="isisilinder" value="<?php echo $isimodal['isisilinder'] ?>" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Tahun Pembuatan</span>
                      </div>
                      <input type="number" min="2000" max="3000" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="tahunpembuatan" value="<?php echo $isimodal['tahunpembuatan'] ?>" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">No. Rangka</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="norangka" value="<?php echo $isimodal['norangka'] ?>" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">No. Mesin</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="nomesin" value="<?php echo $isimodal['nomesin'] ?>" required>
                    </div>
                      <input type="hidden" name="idkendaraan" value="<?php echo $isimodal['id'] ?>">
                      <button type="submit" name="edit" class="btn btn-primary float-right">Submit</button>
                    </div>
                  </form>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <!-- modal delete -->
          <div class="modal fade" id="modal-verifikasi-<?php echo $isimodal['id'] ?>">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Verifikasi KIR Kendaraan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <h5 style="text-align: center;">Verifikasi KIR</h5>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Bukti KIR</span>
                      </div>
                      <img class="rounded" width="700px;" height="500px;" src="public/img/ujikir/<?php echo $isimodal['kir_dokumen'] ?>" alt="">
                    </div>
                    
                      <input type="hidden" name="idkendaraan" value="<?php echo $isimodal['id'] ?>">
                      <button type="submit" name="verifikasi" class="btn btn-primary float-right">Verifikasi</button>
                      <button type="submit" name="tolak" class="btn btn-danger float-right">Tolak</button>
                    </div>
                  </form>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <!-- modal delete -->
          <div class="modal fade" id="modal-kir-<?php echo $isimodal['id'] ?>">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Upload Dokumen KIR</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" enctype='multipart/form-data'>
                    <h5 style="text-align: center;">Upload Dokumen KIR</h5>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Bukti KIR</span>
                      </div>
                      <input type="file" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="gambar" required>
                    </div>
                    <!-- Tempat Picture -->
                      <input type="hidden" name="idkendaraan" value="<?php echo $isimodal['id'] ?>">
                      <button type="submit" name="upkir" class="btn btn-primary float-right">Upload Bukti</button>
                    </div>
                  </form>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <!-- modal delete -->
          <div class="modal fade" id="modal-danger-<?php echo $isimodal['id'] ?>">
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
                  <a href="vehicles.php?delid=<?php echo $isimodal['id']; ?>" class="btn btn-outline-light" role="button">Hapus</a>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
          <?php } ?>
    
          <!-- Modal Create -->
          <div class="modal fade" id="modal-create">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Kendaraan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <h5 style="text-align: center;">Silahkan Memasukkan Data</h5>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">No. Polisi</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="nopol" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Merk</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"name="merk" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Warna</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="warna" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Isi Silinder</span>
                      </div>
                      <input type="number" min="100" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="isisilinder" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Tahun Pembuatan</span>
                      </div>
                      <input type="number" min="2000" max="3000" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="tahunpembuatan" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">No. Rangka</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="norangka" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">No. Mesin</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="nomesin" required>
                    </div>
                      <button type="submit" name="add" class="btn btn-primary float-right">Submit</button>
                    </div>
                  </form>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
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
