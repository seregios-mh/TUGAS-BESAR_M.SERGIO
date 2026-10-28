<?php
session_start();
require_once __DIR__ . '/../navbar/koneksi.php';
require_once __DIR__ . '/../navbar/navbar.php';

// Hanya guru yang boleh membuka halaman ini.
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'guru') {
    header('Location: ../login dkk/login.php');
    exit;
}

// Mengambil semua baris hasil query untuk ditampilkan di tabel.
function get_rows($koneksi, $query, $types = '', $params = [])
{
    $statement = mysqli_prepare($koneksi, $query);
    if (!$statement) {
        return [];
    }

    if ($params) {
        mysqli_stmt_bind_param($statement, $types, ...$params);
    }

    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($statement);

    return $rows;
}

function escape_value($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$userId = (int) $_SESSION['user_id'];
$guru = get_rows($koneksi, 'SELECT id FROM guru WHERE user_id = ? LIMIT 1', 'i', [$userId])[0] ?? null;
$guruId = (int) ($guru['id'] ?? 0);
$selectedClass = trim((string) ($_GET['kelas'] ?? ''));
$classes = [];
$students = [];

if ($guruId > 0) {
    $classes = get_rows($koneksi, '
        SELECT DISTINCT s.kelas, mp.nama_mapel, mp.kode_mapel, COUNT(DISTINCT s.id) AS jumlah_siswa
        FROM mengajar m
        JOIN siswa s ON s.id = m.siswa_id
        JOIN mapel mp ON mp.id = m.mapel_id
        JOIN guru g ON g.id = mp.guru_id
        WHERE g.id = ?
        GROUP BY s.kelas, mp.nama_mapel, mp.kode_mapel
        ORDER BY s.kelas, mp.nama_mapel
    ', 'i', [$guruId]);

    if ($selectedClass !== '') {
        $students = get_rows($koneksi, '
            SELECT DISTINCT s.id, s.nis, s.nama, s.kelas
            FROM mengajar m
            JOIN siswa s ON s.id = m.siswa_id
            JOIN mapel mp ON mp.id = m.mapel_id
            WHERE mp.guru_id = ? AND s.kelas = ?
            ORDER BY s.nama
        ', 'is', [$guruId, $selectedClass]);
    }
}
?>

<div class="container">
    <h1 class="fw-normal display-4">Daftar Nilai</h1>
    <hr class="border border-dark border-2 opacity-100">

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Kelas</th>
                    <th>Nama Mata Pelajaran</th>
                    <th>Kode Mata Pelajaran</th>
                    <th>Jumlah Siswa</th>
                    <th class="text-center" style="width: 12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($classes): ?>
                    <?php foreach ($classes as $number => $row): ?>
                        <tr>
                            <th><?= $number + 1 ?></th>
                            <td><?= escape_value($row['kelas']) ?></td>
                            <td><?= escape_value($row['nama_mapel']) ?></td>
                            <td><?= escape_value($row['kode_mapel']) ?></td>
                            <td><?= escape_value($row['jumlah_siswa']) ?></td>
                            <td class="text-center">
                                <a class="btn btn-primary btn-sm" href="?kelas=<?= urlencode($row['kelas']) ?>">Lihat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">Belum ada kelas yang diajar oleh guru ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($selectedClass !== ''): ?>
        <div class="mt-4">
            <h3 class="fw-bold">Siswa di Kelas <?= escape_value($selectedClass) ?></h3>

            <?php if ($students): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead><tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th></tr></thead>
                        <tbody>
                            <?php foreach ($students as $number => $student): ?>
                                <tr>
                                    <td><?= $number + 1 ?></td>
                                    <td><?= escape_value($student['nis']) ?></td>
                                    <td><?= escape_value($student['nama']) ?></td>
                                    <td><?= escape_value($student['kelas']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">Tidak ada siswa yang ditemukan pada kelas tersebut.</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../navbar/footer.php'; ?>
