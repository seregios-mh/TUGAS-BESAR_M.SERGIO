<?php
require_once __DIR__ . "/../navbar/navbar.php";
require_once __DIR__ . "/../navbar/koneksi.php";

$hasil = mysqli_query($koneksi, "SELECT nis, nama, kelas, jenis_kelamin FROM siswa ORDER BY nama ASC");
?>

<main class="container py-4">
	<h1 class="h2">Data Siswa</h1>
	<div class="table-responsive">
		<table class="table table-bordered table-striped align-middle">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">NIS</th>
					<th scope="col">Nama</th>
					<th scope="col">Kelas</th>
					<th scope="col">Jenis Kelamin</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($hasil && mysqli_num_rows($hasil) > 0): ?>
					<?php $nomor = 1; ?>
					<?php while ($siswa = mysqli_fetch_assoc($hasil)): ?>
						<tr>
							<th scope="row"><?= $nomor++; ?></th>
							<td><?= htmlspecialchars($siswa['nis']); ?></td>
							<td><?= htmlspecialchars($siswa['nama']); ?></td>
							<td><?= htmlspecialchars($siswa['kelas']); ?></td>
							<td><?= $siswa['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
						</tr>
					<?php endwhile; ?>
				<?php else: ?>
					<tr>
						<td colspan="5" class="text-center">Belum ada data siswa.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</main>

<?php require_once __DIR__ . "/../navbar/footer.php"; ?>