<?php
/**
 * using mysqli_connect for database connection
 */
 
$databaseHost = 'localhost';
$databaseName = 'db_sikkb';
$databaseUsername = 'root';
$databasePassword = '';
 
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

if (!$mysqli) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Function untuk Registrasi User
function registrasi($data){
    global $mysqli;

    $nama = $data['fullname'];
    $email = $data['email'];
    $password = $data['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($mysqli, "INSERT INTO tb_users (nama, email, password, isAdmin) VALUES('$nama', '$email', '$password', 0)");
    $affect = mysqli_affected_rows($mysqli);

    return $affect;
}

//Login
//Validate Email
function validateEmail($data){
    global $mysqli;

    $email = $data['email'];
    $email = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE email = '$email'");
    $email = mysqli_num_rows($email);

    if ($email === 0) {
        return true;
    } else {
        return false;
    }
    
}

//Validate Password
function validatePass($data){
    global $mysqli;

    $email = $data['email'];
    $password = $data['password'];
    $cek = mysqli_query($mysqli, "SELECT * FROM tb_users WHERE email = '$email'");
    
    if( mysqli_num_rows($cek) === 1 ) {
        $row = mysqli_fetch_assoc($cek);
        if( password_verify($password, $row["password"]) ) {
            return false;
        }else{
            return true;
        }
    }

    return false;
}

//ADD KENDARAAN
function addkendaraan($data){
    global $mysqli;

    $nopol = $data['nopol'];
    $merk = $data['merk'];
    $warna = $data['warna'];
    $isisilinder = $data['isisilinder'];
    $tahunpembuatan = $data['tahunpembuatan'];
    $norangka = $data['norangka'];
    $nomesin = $data['nomesin'];

    $iduser = $_SESSION['iduser'];

    mysqli_query($mysqli, "INSERT INTO tb_kendaraan (nopol, tahunpembuatan, isisilinder, norangka, nomesin, warna, merk, id_user) VALUES ('$nopol', '$tahunpembuatan', '$isisilinder', '$norangka', '$nomesin', '$warna', '$merk', '$iduser')");
    $status = mysqli_affected_rows($mysqli);
    return $status;
}

// EDIT KENDARAAN
function editkendaraan($data){
    global $mysqli;

    $nopol = $data['nopol'];
    $merk = $data['merk'];
    $warna = $data['warna'];
    $isisilinder = $data['isisilinder'];
    $tahunpembuatan = $data['tahunpembuatan'];
    $norangka = $data['norangka'];
    $nomesin = $data['nomesin'];
    $idkendaraan = $data['idkendaraan'];

    $query = "UPDATE tb_kendaraan SET nopol = '$nopol', merk = '$merk', warna = '$warna', isisilinder = '$isisilinder', tahunpembuatan = '$tahunpembuatan', norangka = '$norangka', nomesin = '$nomesin' WHERE id = '$idkendaraan'";
    mysqli_query($mysqli, $query);
    
    $status = mysqli_affected_rows($mysqli);
    return $status;
}
?>