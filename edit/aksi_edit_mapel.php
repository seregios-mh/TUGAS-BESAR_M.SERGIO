<?php
session_start();
require_once __DIR__ . '/../navbar/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../tabel/tabel_mapel.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$kodeMapel = trim((string) ($_POST['kode_mapel'] ?? ''));
$namaMapel = trim((string) ($_POST['nama_mapel'] ?? ''));
$guruId = filter_input(INPUT_POST, 'guru_id', FILTER_VALIDATE_INT);

if (!$id || $id < 1 || $kodeMapel === '' || $namaMapel === '' || !$guruId || $guruId < 1) {
    $_SESSION['edit_mapel_error'] = 'Data mapel tidak valid.';
    $_SESSION['edit_mapel_old'] = [
        'kode_mapel' => $kodeMapel,
        'nama_mapel' => $namaMapel,
        'guru_id' => $guruId ?? '',
    ];
    header('Location: edit_mapel.php?id=' . urlencode((string) $id));
    exit;
}

$checkMapel = mysqli_prepare($koneksi, 'SELECT id FROM mapel WHERE id = ?');
if (!$checkMapel) {
    die('Gagal mengecek data mapel: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($checkMapel, 'i', $id);
mysqli_stmt_execute($checkMapel);
$exists = mysqli_stmt_get_result($checkMapel);
if (mysqli_num_rows($exists) === 0) {
    mysqli_stmt_close($checkMapel);
    header('Location: ../tabel/tabel_mapel.php');
    exit;
}
mysqli_stmt_close($checkMapel);

$checkGuru = mysqli_prepare($koneksi, 'SELECT id FROM guru WHERE id = ?');
if (!$checkGuru) {
    die('Gagal mengecek data guru: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($checkGuru, 'i', $guruId);
mysqli_stmt_execute($checkGuru);
$guruExists = mysqli_stmt_get_result($checkGuru);
if (mysqli_num_rows($guruExists) === 0) {
    mysqli_stmt_close($checkGuru);
    $_SESSION['edit_mapel_error'] = 'Guru yang dipilih tidak valid.';
    header('Location: edit_mapel.php?id=' . urlencode((string) $id));
    exit;
}
mysqli_stmt_close($checkGuru);

$statement = mysqli_prepare($koneksi, 'UPDATE mapel SET kode_mapel = ?, nama_mapel = ?, guru_id = ? WHERE id = ?');
if (!$statement) {
    die('Gagal menyiapkan query update: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($statement, 'ssii', $kodeMapel, $namaMapel, $guruId, $id);
if (!mysqli_stmt_execute($statement)) {
    $_SESSION['edit_mapel_error'] = 'Gagal menyimpan perubahan data mapel.';
    $_SESSION['edit_mapel_old'] = [
        'kode_mapel' => $kodeMapel,
        'nama_mapel' => $namaMapel,
        'guru_id' => $guruId,
    ];
    mysqli_stmt_close($statement);
    header('Location: edit_mapel.php?id=' . urlencode((string) $id));
    exit;
}

mysqli_stmt_close($statement);
$_SESSION['mapel_updated'] = 'Data mata pelajaran berhasil diperbarui.';
header('Location: ../tabel/tabel_mapel.php');
exit;
