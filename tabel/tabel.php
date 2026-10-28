<?php 
require_once __DIR__ . '/../navbar/navbar.php';
require_once __DIR__ . '/../navbar/koneksi.php';

$sql = "SELECT users.*,
        COALESCE(siswa.nama, guru.nama) AS nama
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        ORDER BY users.id DESC"
        ;

//untuk menjalankan perintah atau sql atau query di atas
$hasil = mysqli_query($koneksi, $sql);

// untuk menghitung jumlah baris dari query
if (mysqli_num_rows($hasil) > 0) {
  // jika hasil query memiliki baris atau data, maka lakukan pengulangan
   //untuk mengambil data, dan ubah data menjadi array asosiatif 
    while ($row = mysqli_fetch_assoc($hasil)) {
      // $data[] berfungsi untuk menampung data hasil dari while atau pengulangan di atas,
      //yang akan digunakan atau diimplementasi pada html -->
        $data[] = $row;
    }
} else {
    echo "<tr><td colspan='5'>Tidak ada data.</td></tr>";
}

?>

<!-- awal container -->
<div class="container">

    <!-- awal -->
    <div class="container center">
        <h1 class="fw-normal display-4">Data User</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center">
    </div>

    <div class="table-responsive">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Username</th>
      <th scope="col">Role</th>
      <th scope="col">Nama</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1; // Variabel untuk nomor urut
    foreach ($data as $user) {
      ?>
      <tr>
        <th scope="row"><?php echo $no++; ?></th>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['role']; ?></td> 
        <td><?php echo $user['nama']; ?></td>
        <td>
          <a href="../edit/edit_user.php?id=<?= $user['id']; ?>&role=<?= $user['role']?> ?>" 
          class="btn btn-warning btn-sm">Edit</a>
          <a href="../aksi/aksi_hapus.php?id=<?= $user['id']; ?>" 
          class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
          Delete</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
  </div>
<?php require_once __DIR__ . '/../navbar/footer.php'; ?>