<?php
require_once __DIR__ . '/../navbar/koneksi.php';

// Pastikan parameter id ada di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Mengambil data ID
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Perbaikan: gunakan satu tanda $ (bukan $$sql)
    $sql = "DELETE users, siswa, guru 
            FROM users 
            LEFT JOIN siswa ON siswa.user_id = users.id 
            LEFT JOIN guru ON guru.user_id = users.id 
            WHERE users.id = $id";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('user berhasil di hapus'); window.location.href='../tabel/tabel.php';</script>";
    } else {
        echo "<script>alert('gagal untuk menghapus data user'); window.location.href='../tabel/tabel.php';</script>";
    }

} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='../tabel/tabel.php';</script>";
}
?>