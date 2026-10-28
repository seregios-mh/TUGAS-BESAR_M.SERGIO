<?php require_once __DIR__ . "/../navbar/navbar.php";
require_once __DIR__ . "/../navbar/koneksi.php"; //memanggil file koneksi

// Query untuk mengambil data dari tabel users
$sql = "SELECT id, username, password, role, created_at FROM users ORDER BY id ASC";

//untuk menjalankan perintah atau sql juga query diatasnya
$hasil = mysqli_query($koneksi ,$sql);

//mysqli_num_rows digunakn untk menghitung jmlh baris dri hasil query.
if (mysqli_num_rows($hasil) > 0){
//jika hsl query memiliki baris atau data, maka lakukan pengulangan untk mengambil setiap datanya, dan ubah datanya menjadi array asosiatif
  while ($row = mysqli_fetch_assoc($hasil)){
// $data[] berfungsi untk menampung data dari hasil while atau pengulangan diatas, yang akan digunakn atau diimplementasikan
    $data[] = $row;
  }
} else{
  $data = []; // Inisialisasi array kosong jika tidak ada data
}
?>

<div class="container">
  <!-- awal -->

  <div class="container center">
        <h1 class="fw-normal display-4">Data User</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center">
        </div>
        <div class="table-responsive">
         <table class="table table-bordered table-striped align-middle">
  <thead>
    <tr>
      <th scope="col" style="width:5%;">No</th>
      <th scope="col">Username</th>
      <th scope="col">Password</th>
      <th scope="col">Role</th>
      <th scope="col">Created At</th>
      <th scope="col" style="width:15%; text-align:center;">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (!empty($data)) {
        $no = 1;
        foreach ($data as $user) {
    ?>
    <tr>
      <th scope="row"><?php echo $no++; ?></th>
      <td><?php echo htmlspecialchars($user['username']); ?></td>
      <td><?php echo htmlspecialchars($user['password']); ?></td>
      <td><?php echo htmlspecialchars($user['role']); ?></td>
      <td><?php echo htmlspecialchars($user['created_at']); ?></td>
      <td class="text-center">
          <a href="../edit/edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
          <a href="../aksi/aksi_hapus.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
      </td>
    </tr>
    <?php 
        } 
    } else {
    ?>
    <tr>
      <td colspan="6" class="text-center">Tidak ada data</td>
    </tr>
    <?php } ?>
  </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . "/../navbar/footer.php"; ?>