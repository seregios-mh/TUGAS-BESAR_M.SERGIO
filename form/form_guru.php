<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 form-shell">
                <div class="card-body p-4">
                    <h1 class="form-title">Tambah Guru</h1>
                    <p class="text-muted form-description">Isi data profil dan akun guru.</p>

                    <form action="../aksi/aksi_tambah.php" method="POST">
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" id="nip" name="nip" class="form-control" placeholder="Masukkan NIP" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih jenis kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <hr>
                        <h2 class="h5 fw-bold mb-3">Akun Guru</h2>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Buat username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Buat password" required>
                        </div>

                        <input type="hidden" name="role" value="guru">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Simpan Guru</button>
                            <a href="../tabel/daftar_guru.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
