<?php
session_start();
require_once __DIR__ . "/navbar/koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login%20dkk/login.php");
    exit;
}

$role = $_SESSION['role'] ?? '';

//cek role user kemudia arahkan ke halaman yang sesuai dengan role yang login
switch ($role) {
    case 'admin':
        header("Location: tabel/tabel_user.php");
        exit;

    case 'guru':
        header("Location: tabel/daftar_guru.php");
        exit;

    case 'siswa':
        header("Location: tabel/daftar_siswa.php");
        exit;
        
    default:
        //menghapus session jika role tidak valid dan arahkan ke halaman login
        session_destroy();
        header("Location: login%20dkk/login.php");
        exit;
}
?>