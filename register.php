<?php
include 'config/koneksi.php';

// --- 1. LOGIKA PROSES REGISTRASI ---
if (isset($_POST['register'])) {
    $nama = $_POST['nama_lengkap'];
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Enkripsi password (Sesuai kriteria RTM)
    $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // Prepared Statement untuk keamanan
        $sql = "INSERT INTO users (username, password, nama_lengkap) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user, $pass_hashed, $nama]);

        // Redirect ke login jika berhasil
        header("Location: login.php?pesan=registrasi_berhasil");
        exit();

    } catch (PDOException $e) {
        $error = "Username sudah digunakan, silakan pilih yang lain.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - MyInventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 0;">
    <div class="container">
        <div class="card card-custom mx-auto" style="max-width: 450px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-pink">Registrasi</h3>
                    <p class="text-muted small">Buat akun untuk masuk ke sistem</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger small p-2"><?= $error ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA LENGKAP</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">USERNAME</label>
                        <input type="text" name="username" class="form-control" placeholder="Pilih username" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="Buat password" required>
                    </div>

                    <button type="submit" name="register" class="btn btn-primary w-100 fw-bold shadow-sm">
                        DAFTAR SEKARANG
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Sudah punya akun? 
                            <a href="login.php" class="text-pink text-decoration-none fw-bold">Login di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>