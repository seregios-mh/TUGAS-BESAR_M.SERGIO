<?php
session_start();
require_once __DIR__ . "/../navbar/koneksi.php";

$isProfileEdit = ($_GET['from'] ?? '') === 'profile';
if ($isProfileEdit) {
    if (empty($_SESSION['user_id'])) {
        header("Location: ../login%20dkk/login.php");
        exit;
    }
    $id = (int) $_SESSION['user_id'];
} else {
    $id = $_GET['id'] ?? '';
}

if (!is_numeric($id)) {
    header("Location: ../navbar/profile.php");
    exit;
}

$id = (int) $id;
$statement = mysqli_prepare($koneksi, "SELECT id, username, role FROM users WHERE id = ?");
mysqli_stmt_bind_param($statement, "i", $id);
mysqli_stmt_execute($statement);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
mysqli_stmt_close($statement);

if (!$user) {
    header("Location: ../navbar/profile.php");
    exit;
}

$role = $user['role'];
$formAction = $isProfileEdit ? 'aksi_edit.php?from=profile' : 'aksi_edit.php';
$cancelUrl = $isProfileEdit ? '../navbar/profile.php' : '../tabel/tabel.php';

if ($role == 'siswa') {
    $statement = mysqli_prepare($koneksi, "SELECT nis, nama, kelas, jenis_kelamin FROM siswa WHERE user_id = ?");
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($statement)) ?: [];
    mysqli_stmt_close($statement);
} elseif ($role == 'guru') {
    $statement = mysqli_prepare($koneksi, "SELECT nip, nama, jenis_kelamin FROM guru WHERE user_id = ?");
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($statement)) ?: [];
    mysqli_stmt_close($statement);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link href="../css/theme.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm form-shell">

        <div class="card-body p-4">

            <h3 class="form-title">
                Edit Data <?= ucfirst($role) ?>
            </h3>
            <p class="text-muted form-description">Perbarui informasi akun dan data profil.</p>

            <?php if (($_GET['error'] ?? '') === 'save'): ?>
                <div class="alert alert-danger" role="alert">Data belum berhasil disimpan. Periksa kembali isian Anda.</div>
            <?php endif; ?>


            <?php if ($role == 'siswa') { ?>

            <!-- FORM SISWA -->
            <form action="<?= $formAction ?>" method="POST">

                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?= $user['username'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input
                        type="text"
                        name="nis"
                        class="form-control"
                        value="<?= $data['nis'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="<?= $data['nama'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input
                        type="text"
                        name="kelas"
                        class="form-control"
                        value="<?= $data['kelas'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>

                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L"
                            <?= $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>
                            Laki-laki
                        </option>

                        <option value="P"
                            <?= $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="<?= $cancelUrl ?>" class="btn btn-secondary">Batal</a>
                </div>

            </form>


            <?php } elseif ($role == 'guru') { ?>

            <!-- FORM GURU -->
            <form action="<?= $formAction ?>" method="POST">

                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?= $user['username'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input
                        type="text"
                        name="nip"
                        class="form-control"
                        value="<?= $data['nip'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="<?= $data['nama'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>

                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L"
                            <?= $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>
                            Laki-laki
                        </option>

                        <option value="P"
                            <?= $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="<?= $cancelUrl ?>" class="btn btn-secondary">Batal</a>
                </div>

            </form>


            <?php } elseif ($role == 'admin') { ?>

            <!-- FORM ADMIN -->
            <form action="<?= $formAction ?>" method="POST">

                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?= $user['username'] ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password.
                    </small>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="<?= $cancelUrl ?>" class="btn btn-secondary">Batal</a>
                </div>

            </form>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>