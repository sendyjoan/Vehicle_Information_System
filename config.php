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

?>