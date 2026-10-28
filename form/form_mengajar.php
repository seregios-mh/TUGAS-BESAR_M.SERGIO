<?php
require_once __DIR__ . '/../navbar/koneksi.php';

if (!$koneksi) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

$queryKelas = mysqli_query($koneksi, "SELECT DISTINCT kelas FROM siswa ORDER BY kelas ASC");
$queryMapel = mysqli_query($koneksi, "
    SELECT m.id, m.kode_mapel, m.nama_mapel, g.nama AS nama_guru
    FROM mapel m
    LEFT JOIN guru g ON g.id = m.guru_id
    ORDER BY g.nama ASC, m.nama_mapel ASC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas = trim((string) ($_POST['kelas'] ?? ''));
    $mapelId = filter_input(INPUT_POST, 'mapel_id', FILTER_VALIDATE_INT);

    if ($kelas === '' || !$mapelId || $mapelId < 1) {
        echo "<script>alert('Pilih kelas dan mata pelajaran terlebih dahulu.');</script>";
    } else {
        $siswaList = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$kelas'");

        if (mysqli_num_rows($siswaList) === 0) {
            echo "<script>alert('Tidak ada siswa pada kelas tersebut.');</script>";
        } else {
            $berhasil = true;
            while ($siswa = mysqli_fetch_assoc($siswaList)) {
                $siswaId = (int) $siswa['id'];
                $cek = mysqli_prepare($koneksi, 'SELECT id FROM mengajar WHERE siswa_id = ? AND mapel_id = ?');
                mysqli_stmt_bind_param($cek, 'ii', $siswaId, $mapelId);
                mysqli_stmt_execute($cek);
                $result = mysqli_stmt_get_result($cek);

                if (mysqli_num_rows($result) === 0) {
                    $insert = mysqli_prepare($koneksi, 'INSERT INTO mengajar (siswa_id, mapel_id) VALUES (?, ?)');
                    mysqli_stmt_bind_param($insert, 'ii', $siswaId, $mapelId);
                    if (!mysqli_stmt_execute($insert)) {
                        $berhasil = false;
                    }
                    mysqli_stmt_close($insert);
                }

                mysqli_stmt_close($cek);
            }

            if ($berhasil) {
                echo "<script>
                        alert('Data mengajar berhasil ditambahkan untuk semua siswa di kelas ini!');
                        window.location.href = '../tabel/tabel_mengajar.php';
                      </script>";
            } else {
                echo "<script>alert('Gagal menyimpan beberapa data mengajar.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mengajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 form-shell">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1">Tambah Data Mengajar</h3>
                    <p class="text-muted mb-4">Pilih kelas dan mata pelajaran untuk menambah data mengajar.</p>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="kelas" class="form-label fw-semibold">Pilih Kelas</label>
                            <select name="kelas" id="kelas" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php while ($kelasRow = mysqli_fetch_assoc($queryKelas)) : ?>
                                    <option value="<?= htmlspecialchars($kelasRow['kelas'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars($kelasRow['kelas'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mapel_id" class="form-label fw-semibold">Pilih Mata Pelajaran</label>
                            <select name="mapel_id" id="mapel_id" class="form-select" required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                <?php while ($mapel = mysqli_fetch_assoc($queryMapel)) : ?>
                                    <option value="<?= (int) $mapel['id']; ?>">
                                        <?= htmlspecialchars($mapel['nama_mapel'], ENT_QUOTES, 'UTF-8'); ?>
                                        (<?= htmlspecialchars($mapel['kode_mapel'], ENT_QUOTES, 'UTF-8'); ?>)
                                        - <?= htmlspecialchars($mapel['nama_guru'] ?? 'Guru belum ada', ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="../tabel/tabel_mengajar.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
