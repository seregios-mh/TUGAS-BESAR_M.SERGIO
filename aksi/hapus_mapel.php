<?php
require_once __DIR__ . '/../navbar/koneksi.php';

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// cek id
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 3. QUERY HAPUS DATA BERDASARKAN ID
    $hapus = mysqli_query($koneksi, "DELETE FROM mapel WHERE id = '$id'");

    if ($hapus) {
        echo "<script>
                alert('Data mapel berhasil dihapus!');
                window.location.href='../tabel/tabel_mapel.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location.href='../tabel/tabel_mapel.php';
              </script>";
    }
} else {
    // Jika tidak ada ID di URL, kembalikan ke halaman tabel
    header("Location: ../tabel/tabel_mapel.php");
    exit();
}
?>