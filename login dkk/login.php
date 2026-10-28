<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi SMK</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/theme.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center min-vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card shadow-sm border-0 rounded-3 form-shell">
                <div class="card-body p-4">

                    <!-- HEADER LOGO / JUDUL -->
                    <div class="text-center mb-4">
                        <h3 class="form-title text-primary">SIPN SMK</h3>
                        <p class="text-muted small form-description">Silakan masuk ke akun Anda</p>
                    </div>

                    <!-- FORM LOGIN (TAMPILAN) -->
                    <form action="aksi_login.php" method="POST">

                        <!-- USERNAME -->
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
                                autocomplete="off"
                            >
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-4">
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

                        <!-- BUTTON LOGIN -->
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            Masuk
                        </button>

                        <center><a href="register.php">Belum punya akun? Register</a></center>

                    </form>

                </div>
            </div>

            <!-- FOOTER DOKUMENTASI -->
            <div class="text-center mt-3">

            </div>

        </div>
    </div>
</div>

</body>
</html>