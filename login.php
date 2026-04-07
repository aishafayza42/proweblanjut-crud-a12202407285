<?php
session_start();
include 'config/koneksi.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row && $key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $row['nama_lengkap'];
    }
}

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

        if (isset($_POST['remember'])) {
            setcookie('id', $data_user['id'], time() + 30, '/');
            setcookie('key', hash('sha256', $data_user['username']), time() + 30, '/');
        }

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/manajemen-inventaris/assets/css/style.css">
</head>
<body>

<div class="container-main">
    <div class="card-sliding">
        
        <div class="panel">
            <div class="text-center mb-30">
                <div class="icon-box bg-pink-light text-pink">
                    <i class="fas fa-boxes fa-2x"></i>
                </div>
                <h2 class="fw-bold m-0">Login</h2>
                <p class="small text-muted mt-1">Masuk ke sistem inventaris</p>
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

                <div class="remember-wrap">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>

                <button type="submit" name="login" class="btn-primary w-full fw-bold">
                    MASUK SEKARANG
                </button>
            </form>
        </div>

        <div class="panel panel-side">
            <h1>Hello, Friend!</h1>
            <p>Daftarkan diri kamu untuk menggunakan semua fitur sistem inventaris kami.</p>
            <a href="register.php" class="btn-outline-white">DAFTAR DI SINI</a>
        </div>

    </div>
</div>

</body>
</html>