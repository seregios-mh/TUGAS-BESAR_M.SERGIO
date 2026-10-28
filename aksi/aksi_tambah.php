<?php
// Aktifkan laporan error PHP untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Matikan exception otomatis MySQLi agar tidak memicu HTTP 500
mysqli_report(MYSQLI_REPORT_OFF);

require_once __DIR__ . '/../navbar/koneksi.php';

// Ambil data dari form
$nis           = $_POST['nis'] ?? '';
$nip           = $_POST['nip'] ?? '';
$nama          = $_POST['nama'] ?? '';
$nama     = $_POST['nama'] ?? '';
$kelas         = $_POST['kelas'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$uss           = $_POST['username'] ?? '';
$pw            = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$role          = $_POST['role'] ?? 'siswa';

// 1. Simpan ke tabel users
$sql_usr = "INSERT INTO users (username, password, role, created_at) VALUES ('$uss', '$pw', '$role', NOW())";
$query_usr = mysqli_query($koneksi, $sql_usr);

if ($query_usr) {
    $id_terakhir = mysqli_insert_id($koneksi);

    // 2. Simpan data spesifik berdasarkan role
    if ($role === 'siswa') {
        $sql_siswa = "INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES ('$nis', '$nama', '$kelas', '$jenis_kelamin', '$id_terakhir')";
        $query_siswa = mysqli_query($koneksi, $sql_siswa);

        if ($query_siswa) {
            echo "<script>alert('Data siswa berhasil disimpan'); window.location.href='../tabel/daftar_siswa.php';</script>";
        } else {
            echo "<script>alert('Gagal simpan ke tabel siswa: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='../form/form_siswa.php';</script>";
        }

    } elseif ($role === 'guru') {
        $sql_guru = "INSERT INTO guru (nip, nama, jenis_kelamin, user_id) VALUES ('$nip', '$nama', '$jenis_kelamin', '$id_terakhir')";
        $query_guru = mysqli_query($koneksi, $sql_guru);

        if ($query_guru) {
            echo "<script>alert('Data guru berhasil disimpan'); window.location.href='../tabel/daftar_guru.php';</script>";
        } else {
            echo "<script>alert('Gagal simpan ke tabel guru: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='../form/form_guru.php';</script>";
        }

    } else {
        // Untuk role admin (hanya masuk ke tabel users)
        echo "<script>alert('Data admin berhasil disimpan'); window.location.href='../tabel/tabel.php';</script>";
    }

} else {
    echo "<script>alert('Gagal simpan ke tabel users: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='../form/form_role.php';</script>";
}
?>