<?php
session_start();
require_once __DIR__ . '/../navbar/koneksi.php';
require_once __DIR__ . '/../navbar/navbar.php';

$query = mysqli_query($koneksi, "
    SELECT g.nama AS nama_guru, s.kelas, mp.nama_mapel, mp.kode_mapel
    FROM mengajar m
    JOIN siswa s ON s.id = m.siswa_id
    JOIN mapel mp ON mp.id = m.mapel_id
    JOIN guru g ON g.id = mp.guru_id
    GROUP BY g.nama, s.kelas, mp.nama_mapel, mp.kode_mapel
    ORDER BY s.kelas ASC, mp.nama_mapel ASC
");
?>

<div class="container">
    <div class="container center">
        <h1 class="fw-normal display-4">Data Mengajar</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center"></div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col">Nama Guru</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Nama Mata Pelajaran</th>
                        <th scope="col">Kode Mata Pelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <th scope="row"><?= $no++; ?></th>
                                <td><?= htmlspecialchars($row['nama_guru'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['kelas'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['nama_mapel'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['kode_mapel'] ?? '-'); ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data mengajar.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../navbar/footer.php'; ?>