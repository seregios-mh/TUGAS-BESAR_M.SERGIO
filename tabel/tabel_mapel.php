<?php
session_start();
require_once __DIR__ . '/../navbar/koneksi.php';
require_once __DIR__ . '/../navbar/navbar.php';

$successMessage = $_SESSION['mapel_updated'] ?? '';
unset($_SESSION['mapel_updated']);

$query = mysqli_query($koneksi, "SELECT mapel.*, guru.nama AS nama_guru FROM mapel LEFT JOIN guru ON mapel.guru_id = guru.id ORDER BY mapel.id ASC");
?>

<div class="container">
    <div class="container center">
        <h1 class="fw-normal display-4">Data Mata Pelajaran</h1>
        <hr class="border border-dark border-2 opacity-100">

        <?php if ($successMessage !== '') : ?>
            <div class="alert alert-success" role="alert"><?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <div class="row align-items-center"></div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col">ID</th>
                        <th scope="col">Kode Mapel</th>
                        <th scope="col">Nama Mapel</th>
                        <th scope="col">Nama Guru</th>
                        <th scope="col" style="width: 18%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($mapel = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <th scope="row"><?= $no++; ?></th>
                                <td><?= htmlspecialchars($mapel['id']); ?></td>
                                <td><?= htmlspecialchars($mapel['kode_mapel']); ?></td>
                                <td><?= htmlspecialchars($mapel['nama_mapel']); ?></td>
                                <td><?= htmlspecialchars($mapel['nama_guru'] ?? '-'); ?></td>
                                <td class="text-center">
                                    <a href="../edit/edit_mapel.php?id=<?= $mapel['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="../aksi/hapus_mapel.php?id=<?= $mapel['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mapel ini?')">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data mapel.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../navbar/footer.php'; ?>