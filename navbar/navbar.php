<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$name = $_SESSION['nama'] ?? 'Admin';
$role = $_SESSION['role'] ?? '';

$menus = [
    'admin' => [
        'User' => [
            ['Tabel 1', 'tabel.php'],
            ['Tabel 2', 'tabel_user.php'],
            ['Form Admin', '../form/form_admin.php'],
        ],
        'Guru' => [
            ['Daftar Guru', 'daftar_guru.php'],
            ['Form Guru', '../form/form_guru.php'],
        ],
        'Siswa' => [
            ['Daftar Siswa', 'daftar_siswa.php'],
            ['Form Siswa', '../form/form_siswa.php'],
        ],
        'Mata Pelajaran' => [
            ['Tabel Mapel', 'tabel_mapel.php'],
            ['Form Mapel', '../form/form_mapel.php'],
        ],
        'Mengajar' => [
            ['Tabel Mengajar', 'tabel_mengajar.php'],
            ['Form Mengajar', '../form/form_mengajar.php'],
        ],
    ],
    'guru' => [
        'links' => [
            ['Home', '../tabel/daftar_guru.php'],
            ['Nilai Siswa', '../tabel/daftar_nilai.php'],
        ],
    ],
    'siswa' => [
        'Tabel' => [
            ['Tabel 1', 'tabel.php'],
            ['Tabel 2', 'tabel_user.php'],
            ['Tabel Mapel', 'tabel_mapel.php'],
        ],
        'Nilai Siswa' => [
            ['Form Admin', '../form/form_admin.php'],
            ['Form Siswa', '../form/form_siswa.php'],
            ['Form Role', '../form/form_role.php'],
            ['Form Mapel', '../form/form_mapel.php'],
        ],
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: #fffae8;" href="../index.php">Navbar</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav">
                <?php foreach ($menus[$role] ?? [] as $label => $items): ?>
                    <?php if ($label === 'links'): ?>
                        <?php foreach ($items as [$text, $url]): ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?= htmlspecialchars($url) ?>"><?= htmlspecialchars($text) ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= htmlspecialchars($label) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-light">
                                <?php foreach ($items as $index => [$text, $url]): ?>
                                    <?php if ($role === 'admin' && $index === count($items) - 1): ?>
                                        <li><hr class="dropdown-divider"></li>
                                    <?php endif; ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= htmlspecialchars($url) ?>"><?= htmlspecialchars($text) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <?php if ($role): ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($role) ?>)
                        </button>
                        <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end">
                            <li><a class="dropdown-item" href="../navbar/profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="../edit/edit_user.php?from=profile">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="../login%20dkk/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
