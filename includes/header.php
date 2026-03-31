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

<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm" style="background-color: white; border-bottom: 2px solid var(--primary-color);">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="text-white p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" 
                 style="width: 35px; height: 35px; background-color: var(--primary-color);">
                <i class="fas fa-boxes"></i>
            </div>
            <span class="logo-text fw-bold" style="color: var(--primary-color);">MyInventaris</span>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="me-3 d-none d-md-block text-end">
                <small class="text-muted d-block" style="font-size: 11px;">Hari ini</small>
                <span class="fw-semibold small"><?= date('l, d M Y'); ?></span>
            </div>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--primary-color);">
                    <div class="bg-pink-light p-2 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </div>
                    <span class="fw-bold small d-none d-sm-inline"><?= $_SESSION['nama']; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="dropdownUser">
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger small fw-bold" href="../../logout.php">
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