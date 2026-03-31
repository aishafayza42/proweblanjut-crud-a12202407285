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
        $_SESSION['nama'] = $data_user['nama_lengkap'];
        header("Location: pages/barang/index.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - MyInventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container-login">
    <div class="card-custom" style="max-width: 400px; padding: 40px; width: 100%;">
        <div class="text-center" style="margin-bottom: 30px;">
            <div class="bg-pink-light text-pink" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%; display: inline-block; margin-bottom: 15px;">
                <i class="fas fa-boxes fa-2x"></i>
            </div>
            <h2 class="fw-bold" style="margin: 0; color: #1e293b;">Login</h2>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Masuk ke sistem inventaris</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="input-custom" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="input-custom" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn-primary w-full fw-bold" style="cursor: pointer;">
                MASUK SEKARANG
            </button>
            
            <div class="text-center mt-4">
                <p class="small" style="color: #64748b;">Belum punya akun? 
                    <a href="register.php" class="text-pink fw-bold" style="text-decoration: none;">Daftar di sini</a>
                </p>
            </div>
        </form>
    </div>
</div>

</body>
</html>