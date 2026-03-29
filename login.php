<?php
session_start();
include 'config/koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: pages/barang/index.php");
    exit();
}

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $data_user = $stmt->fetch();

    if ($data_user && password_verify($pass, $data_user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data_user['id'];
        $_SESSION['nama'] = $data_user['nama_lengkap'];

        header("Location: pages/barang/index.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyInventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 0;">
    <div class="container">
        <div class="card card-custom mx-auto shadow" style="max-width: 400px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-boxes fa-3x text-pink"></i>
                    </div>
                    <h3 class="fw-bold text-pink">MyInventaris</h3>
                    <p class="text-muted small">Masukkan akun untuk kelola stok</p>
                </div>

                <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'registrasi_berhasil'): ?>
                    <div class="alert alert-success small p-2 text-center">Registrasi Berhasil! Silakan Login.</div>
                <?php endif; ?>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger small p-2 text-center"><?= $error ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">USERNAME</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="username" class="form-control border-start-0 shadow-none" placeholder="Username" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">PASSWORD</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 shadow-none" placeholder="Password" required>
                        </div>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                        MASUK
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Belum punya akun? 
                            <a href="register.php" class="text-pink text-decoration-none fw-bold">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>