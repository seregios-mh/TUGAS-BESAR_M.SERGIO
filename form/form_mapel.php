<?php
require_once __DIR__ . '/../navbar/koneksi.php';

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. AMBIL DATA GURU UNTUK DROPDOWN
$query_guru = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama ASC");

// 3. PROSES SIMPAN DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];
    $guru_id    = $_POST['guru_id'];

    $simpan = "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id) 
               VALUES ('$kode_mapel', '$nama_mapel', '$guru_id')";

    if (mysqli_query($koneksi, $simpan)) {
        echo "<script>
                alert('Data mapel berhasil ditambahkan!');
                window.location.href='../tabel/tabel_mapel.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Pelajaran</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 form-shell">
                <div class="card-body p-4">

                    <h3 class="fw-bold mb-1">
                        Tambah Mapel
                    </h3>
                    <p class="text-muted mb-4">
                        Isi formulir berikut untuk menambahkan mata pelajaran baru
                    </p>

                    <form action="" method="POST">

                        <!-- KODE MAPEL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Kode Mapel
                            </label>
                            <input 
                                type="text" 
                                name="kode_mapel" 
                                class="form-control" 
                                placeholder="Contoh: 06" 
                                required
                            >
                        </div>

                        <!-- NAMA MAPEL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Mapel
                            </label>
                            <input 
                                type="text" 
                                name="nama_mapel" 
                                class="form-control" 
                                placeholder="Masukkan nama mata pelajaran" 
                                required
                            >
                        </div>

                        <!-- PILIH GURU -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Guru Pengampu
                            </label>
                            <select name="guru_id" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php while ($guru = mysqli_fetch_assoc($query_guru)) : ?>
                                    <option value="<?= $guru['id']; ?>">
                                        <?= $guru['nama']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Simpan Mapel
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>