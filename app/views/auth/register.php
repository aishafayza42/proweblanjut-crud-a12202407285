<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - MyInventaris</title> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<div class="container-main container-register">
    <div class="card-sliding">
        
        <div class="panel">
            <div class="text-center mb-30">
                <div class="icon-box bg-pink-light text-pink">
                    <i class="fas fa-user-plus fa-2x"></i>
                </div>
                <h2 class="fw-bold m-0">Daftar Akun</h2>
                <p class="small text-muted mt-1">Lengkapi data diri Anda</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="input-custom" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="input-custom" placeholder="Pilih username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="input-custom" placeholder="Buat password" required>
                </div>

                <button type="submit" name="register" class="btn-primary w-full fw-bold">
                    DAFTAR SEKARANG
                </button>
            </form>
        </div>

        <div class="panel panel-side">
            <h1 class="text-white">Welcome Back!</h1>
            <p class="text-white">Sudah memiliki akun? Silakan login untuk kembali mengelola inventaris Anda.</p>
            <a href="index.php?page=auth&action=login" class="btn-outline-white">LOGIN DI SINI</a>
        </div>

    </div>
</div>

</body>
</html>