<?php

require_once __DIR__ . "/../navbar/koneksi.php";

if (($_GET['from'] ?? '') === 'profile') {
    session_start();

    $sessionId = (int) ($_SESSION['user_id'] ?? 0);
    $postedId = $_POST['id'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_numeric($postedId) || $sessionId < 1 || (int) $postedId !== $sessionId) {
        header("Location: ../navbar/profile.php");
        exit;
    }

    $id = $sessionId;
    $editUrl = "edit_user.php?from=profile&error=save";
    $usernameValue = $_POST['username'] ?? '';
    $passwordValue = $_POST['password'] ?? '';
    $username = is_string($usernameValue) ? trim($usernameValue) : '';
    $password = is_string($passwordValue) ? $passwordValue : '';

    $statement = mysqli_prepare($koneksi, "SELECT role FROM users WHERE id = ?");
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $account = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
    mysqli_stmt_close($statement);

    if (!$account || $username === '') {
        header("Location: $editUrl");
        exit;
    }

    $role = $account['role'];
    $gender = $_POST['jenis_kelamin'] ?? '';
    if (in_array($role, ['siswa', 'guru'], true) && !in_array($gender, ['L', 'P'], true)) {
        header("Location: $editUrl");
        exit;
    }

    try {
        mysqli_begin_transaction($koneksi);

        if ($password !== '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $statement = mysqli_prepare($koneksi, "UPDATE users SET username = ?, password = ? WHERE id = ?");
            mysqli_stmt_bind_param($statement, "ssi", $username, $passwordHash, $id);
        } else {
            $statement = mysqli_prepare($koneksi, "UPDATE users SET username = ? WHERE id = ?");
            mysqli_stmt_bind_param($statement, "si", $username, $id);
        }
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        if ($role === 'siswa') {
            $nis = trim((string) ($_POST['nis'] ?? ''));
            $name = trim((string) ($_POST['nama'] ?? ''));
            $class = trim((string) ($_POST['kelas'] ?? ''));
            if ($nis === '' || $name === '' || $class === '') {
                throw new RuntimeException('Data siswa tidak lengkap.');
            }
            $statement = mysqli_prepare($koneksi, "UPDATE siswa SET nis = ?, nama = ?, kelas = ?, jenis_kelamin = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($statement, "ssssi", $nis, $name, $class, $gender, $id);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
        } elseif ($role === 'guru') {
            $nip = trim((string) ($_POST['nip'] ?? ''));
            $name = trim((string) ($_POST['nama'] ?? ''));
            if ($nip === '' || $name === '') {
                throw new RuntimeException('Data guru tidak lengkap.');
            }
            $statement = mysqli_prepare($koneksi, "UPDATE guru SET nip = ?, nama = ?, jenis_kelamin = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($statement, "sssi", $nip, $name, $gender, $id);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
        }

        mysqli_commit($koneksi);
        $_SESSION['username'] = $username;
        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            $_SESSION['user']['username'] = $username;
        }
        header("Location: ../navbar/profile.php");
        exit;
    } catch (Throwable $error) {
        mysqli_rollback($koneksi);
        header("Location: $editUrl");
        exit;
    }
}

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../tabel/tabel.php");
    exit;
}

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'] ?? '';


// AMBIL DATA USER

$queryUser = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE id='$id'"
);

if (!$queryUser) {
    die("Query user gagal: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($queryUser) == 0) {
    die("User tidak ditemukan.");
}

$user = mysqli_fetch_assoc($queryUser);
$role = $user['role'];

// EDIT USERNAME + PASSWORD

if (!empty($password)) {

    $passwordHash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $query = mysqli_query(
        $koneksi,
        "UPDATE users SET
            username='$username',
            password='$passwordHash'
         WHERE id='$id'"
    );

} else {

    $query = mysqli_query(
        $koneksi,
        "UPDATE users SET
            username='$username'
         WHERE id='$id'"
    );
}


// CEK UPDATE USERS
if (!$query) {
    die("Gagal update username: " . mysqli_error($koneksi));
}

// EDIT SISWA

if ($role == 'siswa') {

    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $query = mysqli_query(
        $koneksi,
        "UPDATE siswa SET
            nis='$nis',
            nama='$nama',
            kelas='$kelas',
            jenis_kelamin='$jenis_kelamin'
         WHERE user_id='$id'"
    );

    if (!$query) {
        die("Gagal update siswa: " . mysqli_error($koneksi));
    }
}


// EDIT GURU

elseif ($role == 'guru') {

    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $query = mysqli_query(
        $koneksi,
        "UPDATE guru SET
            nip='$nip',
            nama='$nama',
            jenis_kelamin='$jenis_kelamin'
         WHERE user_id='$id'"
    );

    if (!$query) {
        die("Gagal update guru: " . mysqli_error($koneksi));
    }
}

header("Location: ../tabel/tabel.php");
exit;

?>