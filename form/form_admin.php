<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<!-- awal container -->
<div class="container">

    <!-- awal column -->
    <div class="container text-left">
        <div class="row align-items-center">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <!-- awal card-->
                <div class="card shadow-sm form-shell">
                    <div class="card-body">
                        <h3 class="form-title">Tambah Admin</h3>
                        <p class="text-muted form-description">Buat akun kredensial untuk admin.</p>
                        <form action="../aksi/aksi_tambah.php" method="POST">
                        <!-- awal form -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control"
                                    placeholder="Contoh: SERGIO" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Masukkan password" required>
                            </div>
                            <input type="hidden" name="role" value="admin">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="../tabel/tabel.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>

                        <!-- akhir form -->
                    </div>
                </div>
                <!-- akhir card -->
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
    <!-- akhir column-->

</div>
<!-- akhir container -->

<?php if(isset($_POST['kirim'])): ?>
<h1><center>Output dari FORM</center></h1>
<?php

$nisn       =   $_POST['nisn'];
$nama       =   $_POST['nama'];
$kelas      =   $_POST['kelas'];
$jenis_kelamin         =   $_POST['jenis_kelamin'];
$username   =   $_POST['username'];
$password   =   password_hash($_POST['password'], PASSWORD_DEFAULT);
$role       =   $_POST['role'];

echo "NISN : " . $nisn . "<br>";
echo "Nama : " . $nama . "<br>";
echo "Kelas : " . $kelas . "<br>";
echo "Jenis Kelamin : " . $jenis_kelamin . "<br>";
echo "Username : " . $username . "<br>";
echo "Password : " . $password . "<br>";
echo "Role : " . $role . "<br><br><br>";

?>

<?php endif; ?>
<?php require __DIR__ . '/../navbar/footer.php' ?>