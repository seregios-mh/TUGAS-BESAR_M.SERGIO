<?php

require_once __DIR__ . "/../navbar/koneksi.php";


//session (dalam konteks teknologi web, session adalah mekanisme untuk menyimpan data pengguna di server agar dapat digunakan di beberapa halaman web) 
// digunakan untuk menyimpan data login pengguna setelah berhasil login. Dengan menggunakan session, pengguna tidak perlu login kembali setiap kali mengakses halaman yang memerlukan autentikasi.

session_start();//memulai session untuk menyimpan data login pengguna

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT users.*, COALESCE(siswa.nama, guru.nama, users.username) AS nama, siswa.kelas
FROM users
LEFT JOIN siswa ON users.id = siswa.user_id
LEFT JOIN guru ON users.id = guru.user_id
WHERE users.username = '$username'
";

$query = mysqli_query($koneksi, $sql);

$user = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {
    //membuat variabel session
    //membuat session untuk menyimpan data login pengguna
    $_SESSION['id'] = $user['id'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['kelas'] = $user['kelas'];
    $_SESSION['login'] = true;

    //berhasil login, maka akan diarahkan ke halaman index.php
    header("Location: ../index.php");
    exit;
} else {
    echo "<script>alert('Username atau password salah.'); window.location.href = 'login.php';</script>";
}