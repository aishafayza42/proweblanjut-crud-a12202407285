<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - MyInventaris</title> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
            <a href="index.php?page=auth&action=register" class="btn-outline-white">DAFTAR DI SINI</a>
        </div>

    </div>
</div>

</body>
</html>