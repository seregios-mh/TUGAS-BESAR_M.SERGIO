<?php
session_start();
require_once 'koneksi.php';

// Mengubah data menjadi teks aman untuk ditampilkan di HTML.
function escape_profile_value($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Mengambil satu baris data dari query dan parameter SQL.
function find_one($koneksi, $query, $types = '', $values = [])
{
    $statement = mysqli_prepare($koneksi, $query);
    if (!$statement) {
        return null;
    }

    if ($values) {
        mysqli_stmt_bind_param($statement, $types, ...$values);
    }

    mysqli_stmt_execute($statement);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
    mysqli_stmt_close($statement);

    return $row ?: null;
}

$sessionUser = $_SESSION['user'] ?? [];
$sessionUser = is_array($sessionUser) ? $sessionUser : [];
$userId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? $sessionUser['id'] ?? null;
$username = $_SESSION['username'] ?? $sessionUser['username'] ?? null;

// Cari akun berdasarkan ID; jika tidak ada, cari berdasarkan username.
if (is_numeric($userId)) {
    $user = find_one($koneksi, 'SELECT id, username, role, created_at FROM users WHERE id = ?', 'i', [(int) $userId]);
} elseif ($username !== null && $username !== '') {
    $user = find_one($koneksi, 'SELECT id, username, role, created_at FROM users WHERE username = ?', 's', [$username]);
} else {
    $user = null;
}

$profile = [];
if ($user && in_array($user['role'], ['guru', 'siswa'], true)) {
    $profileTable = $user['role'] === 'siswa' ? 'siswa' : 'guru';
    $profileFields = $user['role'] === 'siswa'
        ? 'nis, nama, kelas, jenis_kelamin'
        : 'nip, nama, jenis_kelamin';
    $profile = find_one(
        $koneksi,
        "SELECT $profileFields FROM $profileTable WHERE user_id = ?",
        'i',
        [$user['id']]
    ) ?: [];
}

$displayName = $profile['nama'] ?? $user['username'] ?? 'Pengguna';
$initial = strtoupper(substr($displayName, 0, 1));
$gender = ['L' => 'Laki-laki', 'P' => 'Perempuan'][$profile['jenis_kelamin'] ?? ''] ?? '';
$profileLabels = ['nis' => 'NIS', 'nip' => 'NIP', 'nama' => 'Nama', 'kelas' => 'Kelas', 'jenis_kelamin' => 'Jenis kelamin'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | SIPN SMK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
    <style>
        .profile-wrap { max-width: 760px; }
        .avatar {
            display: grid; width: 76px; height: 76px; place-items: center;
            border-radius: 50%; color: #fff; background: var(--bs-primary);
            font-size: 1.8rem; font-weight: 700;
        }
        .profile-data dt { color: #6c757d; font-size: .8rem; font-weight: 600; text-transform: uppercase; }
        .detail-row { border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
    <main class="container py-4">
        <div class="profile-wrap mx-auto">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold text-primary mb-1">SIPN SMK</h1>
                <p class="text-muted small mb-0">Profil akun pengguna</p>
            </div>

            <?php if ($user): ?>
                <section class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center">
                            <div class="avatar mx-auto mb-3" aria-hidden="true"><?= escape_profile_value($initial) ?></div>
                            <h2 class="h4 fw-bold mb-2"><?= escape_profile_value($displayName) ?></h2>
                            <span class="badge rounded-pill text-primary bg-primary-subtle">
                                <?= escape_profile_value(ucfirst($user['role'])) ?>
                            </span>
                        </div>

                        <hr class="my-4">
                        <h3 class="h6 fw-bold mb-3">Informasi akun</h3>
                        <dl class="profile-data row gy-3 mb-0">
                            <div class="col-sm-6"><dt>Username</dt><dd><?= escape_profile_value($user['username']) ?></dd></div>
                            <div class="col-sm-6"><dt>Peran</dt><dd><?= escape_profile_value(ucfirst($user['role'])) ?></dd></div>
                            <?php if (!empty($user['created_at'])): ?>
                                <div class="col-sm-6"><dt>Terdaftar sejak</dt><dd><?= escape_profile_value(date('d-m-Y', strtotime($user['created_at']))) ?></dd></div>
                            <?php endif; ?>
                        </dl>

                        <?php if ($profile): ?>
                            <hr class="my-4">
                            <h3 class="h6 fw-bold mb-2">Data pribadi</h3>
                            <dl class="profile-data mb-0">
                                <?php foreach ($profile as $key => $value): ?>
                                    <?php
                                    $label = $profileLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));
                                    $value = $key === 'jenis_kelamin' ? $gender : $value;
                                    ?>
                                    <div class="detail-row row py-3">
                                        <dt class="col-sm-4"><?= escape_profile_value($label) ?></dt>
                                        <dd class="col-sm-8 mb-0"><?= escape_profile_value($value) ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                        <?php endif; ?>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="btn btn-primary" href="../edit/edit_user.php?from=profile">Edit profil</a>
                            <a class="btn btn-outline-secondary" href="../tabel/tabel.php">Kembali</a>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <section class="card shadow-sm border-0 rounded-3 text-center">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h4 fw-bold">Akun belum terhubung</h2>
                        <p class="text-muted mb-4">Silakan masuk terlebih dahulu untuk melihat informasi profil Anda.</p>
                        <a class="btn btn-primary" href="../login%20dkk/login.php">Masuk ke akun</a>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
