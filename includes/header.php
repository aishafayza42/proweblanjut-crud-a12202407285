<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyInventaris - Modern Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/manajemen-inventaris/assets/css/style.css">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm" style="background-color: white; border-bottom: 2px solid var(--primary-color);">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="text-white p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" 
                 style="width: 35px; height: 35px; background-color: var(--primary-color);">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="me-4">
                <span class="logo-text fw-bold d-block" style="color: var(--primary-color); line-height: 1.5;">MyInventaris</span>
                <small class="text-muted" style="font-size: 10px;"><?= date('l, d M Y'); ?></small>
            </div>
        </div>

        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--primary-color);">
                    <div class="bg-pink-light p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border: 1px solid var(--primary-light);">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2" aria-labelledby="dropdownUser" style="border-radius: 12px;">
                    <li class="px-3 py-2">
                        <small class="text-muted d-block">Login sebagai:</small>
                        <span class="fw-bold text-dark"><?= $_SESSION['nama']; ?></span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger small fw-bold rounded-3" href="../../logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="main-wrapper w-100 d-flex flex-column min-vh-100">
    <main class="flex-grow-1 p-4">