<?php
session_start();
require_once __DIR__ . '/../navbar/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: ../tabel/tabel_mapel.php');
    exit;
}

$mapelStatement = mysqli_prepare($koneksi, 'SELECT id, kode_mapel, nama_mapel, guru_id FROM mapel WHERE id = ?');
if (!$mapelStatement) {
    die('Gagal menyiapkan query mapel: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($mapelStatement, 'i', $id);
mysqli_stmt_execute($mapelStatement);
$mapelResult = mysqli_stmt_get_result($mapelStatement);
$mapel = mysqli_fetch_assoc($mapelResult);
mysqli_stmt_close($mapelStatement);

if (!$mapel) {
    header('Location: ../tabel/tabel_mapel.php');
    exit;
}

$error = $_SESSION['edit_mapel_error'] ?? '';
unset($_SESSION['edit_mapel_error']);

$oldInput = $_SESSION['edit_mapel_old'] ?? [];
unset($_SESSION['edit_mapel_old']);
$mapel['kode_mapel'] = $oldInput['kode_mapel'] ?? $mapel['kode_mapel'];
$mapel['nama_mapel'] = $oldInput['nama_mapel'] ?? $mapel['nama_mapel'];
$mapel['guru_id'] = $oldInput['guru_id'] ?? $mapel['guru_id'];

$guruList = mysqli_query($koneksi, 'SELECT id, nama FROM guru ORDER BY nama ASC');
if (!$guruList) {
    die('Gagal memuat daftar guru: ' . htmlspecialchars(mysqli_error($koneksi)));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once __DIR__ . '/../navbar/navbar.php'; ?>

<div class="container py-5">
    <div class="card shadow-sm border-0 form-shell mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-3 text-center">Edit Mata Pelajaran</h3>

            <?php if ($error !== ''): ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form action="aksi_edit_mapel.php" method="POST">
                <input type="hidden" name="id" value="<?= (int) $id; ?>">

                <div class="mb-3">
                    <label for="kode_mapel" class="form-label fw-semibold">Kode Mata Pelajaran</label>
                    <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" maxlength="10" value="<?= htmlspecialchars($mapel['kode_mapel'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nama_mapel" class="form-label fw-semibold">Nama Mata Pelajaran</label>
                    <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" maxlength="100" value="<?= htmlspecialchars($mapel['nama_mapel'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="guru_id" class="form-label fw-semibold">Pilih Guru</label>
                    <select class="form-select" id="guru_id" name="guru_id" required>
                        <option value="">-- Pilih Guru --</option>
                        <?php while ($guru = mysqli_fetch_assoc($guruList)): ?>
                            <option value="<?= (int) $guru['id']; ?>" <?= (int) $mapel['guru_id'] === (int) $guru['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($guru['nama'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="../tabel/tabel_mapel.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../navbar/footer.php'; ?>
</body>
</html>
