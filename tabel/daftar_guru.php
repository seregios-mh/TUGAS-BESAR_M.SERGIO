<?php
require_once __DIR__ . "/../navbar/navbar.php";
require_once __DIR__ . "/../navbar/koneksi.php";

$hasil = mysqli_query($koneksi, "SELECT nip, nama, jenis_kelamin FROM guru ORDER BY nama ASC");
?>

<main class="container py-4">
	<h1 class="h2">Data Guru</h1>
	<div class="table-responsive">
		<table class="table table-bordered table-striped align-middle">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">NIP</th>
					<th scope="col">Nama</th>
					<th scope="col">Jenis Kelamin</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($hasil && mysqli_num_rows($hasil) > 0): ?>
					<?php $nomor = 1; ?>
					<?php while ($guru = mysqli_fetch_assoc($hasil)): ?>
						<tr>
							<th scope="row"><?= $nomor++; ?></th>
							<td><?= htmlspecialchars($guru['nip']); ?></td>
							<td><?= htmlspecialchars($guru['nama']); ?></td>
							<td><?= $guru['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
						</tr>
					<?php endwhile; ?>
				<?php else: ?>
					<tr>
						<td colspan="4" class="text-center">Belum ada data guru.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</main>

<?php require_once __DIR__ . "/../navbar/footer.php"; ?>