<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_smk");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role     = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Simpan ke users
    $query = mysqli_query($koneksi, "
        INSERT INTO users (username, password, role)
        VALUES ('$username', '$password', '$role')
    ");

    if ($query) {

        $user_id = mysqli_insert_id($koneksi);

        // DATA SISWA
        if ($role == "siswa") {

            $nis      = $_POST['nis'];
            $nama    = $_POST['nama'];
            $kelas    = $_POST['kelas'];
            $jenis_kelamin = $_POST['jenis_kelamin'];


            mysqli_query($koneksi, "
                INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id)
                VALUES ('$nis', '$nama', '$kelas', '$jenis_kelamin', '$user_id')
            ");
        }

        // DATA GURU
        elseif ($role == "guru") {

            $nama     = $_POST['nama'];
            $nip      = $_POST['nip'];
            $jenis_kelamin = $_POST['jenis_kelamin'];

            mysqli_query($koneksi, "
                INSERT INTO guru (user_id, nama, nip, jenis_kelamin)
                VALUES ('$user_id', '$nama', '$nip', '$jenis_kelamin')
            ");
        }

        echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location.href='../tabel/tabel.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah User</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0 form-shell">

                <div class="card-body p-4">

                    <h3 class="form-title">
                        Tambah User
                    </h3>

                    <p class="text-muted form-description">
                        Pilih role untuk mengisi data pengguna
                    </p>


                    <form action="" method="POST">

                        <!-- ROLE -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Role
                            </label>

                            <select
                                name="role"
                                id="role"
                                class="form-select"
                                onchange="ubahForm()"
                                required
                            >

                                <option value="">
                                    -- Pilih Role --
                                </option>

                                <option value="admin">
                                    Admin
                                </option>

                                <option value="siswa">
                                    Siswa
                                </option>

                                <option value="guru">
                                    Guru
                                </option>

                            </select>

                        </div>


                        <!-- DATA USER -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Masukkan username"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >

                        </div>

                        <!-- FORM SISWA -->

                        <div id="formSiswa" style="display:none;">

                            <hr>

                            <h5 class="fw-bold mb-3">
                                Data Siswa
                            </h5>


                            <div class="mb-3">

                                <label class="form-label">
                                    NIS
                                </label>

                                <input
                                    type="text"
                                    name="nis"
                                    class="form-control"
                                    placeholder="Masukkan NIS"
                                >

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Nama Siswa
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control"
                                    placeholder="Masukkan nama siswa"
                                >

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Kelas
                                </label>

                                <input
                                    type="text"
                                    name="kelas"
                                    class="form-control"
                                    placeholder="Contoh: XI RPL 1"
                                >

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Jenis Kelamin
                                </label>

                                <select name="jenis_kelamin" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
 
                        </div>

                        <!-- FORM GURU -->

                        <div id="formGuru" style="display:none;">

                            <hr>

                            <h5 class="fw-bold mb-3">
                                Data Guru
                            </h5>

                            <div class="mb-3">

                                <label class="form-label">
                                    Nama Guru
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control"
                                    placeholder="Masukkan nama guru"
                                >

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    NIP
                                </label>

                                <input
                                    type="text"
                                    name="nip"
                                    class="form-control"
                                    placeholder="Masukkan NIP"
                                >

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Jenis Kelamin
                                </label>

                                <select name="jenis_kelamin" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>

                            </div>

                        </div>


                        <!-- FORM ADMIN -->

                        <div id="formAdmin" style="display:none;">

                            <hr>

                            <div class="alert alert-info">

                                <strong>Admin</strong> tidak membutuhkan
                                data tambahan.

                            </div>

                        </div>


                        <!-- BUTTON -->

                        <button
                            type="submit"
                            class="btn btn-primary w-100 mt-3"
                        >
                            Simpan Data
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>




<script>

function ubahForm() {

    let role = document.getElementById("role").value;

    // Sembunyikan semuanya
    document.getElementById("formSiswa").style.display = "none";
    document.getElementById("formGuru").style.display = "none";
    document.getElementById("formAdmin").style.display = "none";


    // Tampilkan sesuai role
    if (role === "siswa") {

        document.getElementById("formSiswa").style.display = "block";

    }

    else if (role === "guru") {

        document.getElementById("formGuru").style.display = "block";

    }

    else if (role === "admin") {

        document.getElementById("formAdmin").style.display = "block";

    }

}

</script>

</body>

</html>