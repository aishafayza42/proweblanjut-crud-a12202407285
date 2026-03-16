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

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="text-white p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" 
                 style="width: 35px; height: 35px; background-color: var(--primary-color);">
                <i class="fas fa-boxes"></i>
            </div>
            <span class="logo-text">MyInventaris</span>
        </div>
        
        <div class="ms-auto d-flex align-items-center">
            <div class="me-3 d-none d-md-block text-end">
                <small class="text-muted d-block" style="font-size: 11px;">Hari ini</small>
                <span class="fw-semibold small"><?= date('l, d M Y'); ?></span>
            </div>
        </div>
    </div>
</nav>

<div class="d-flex">
    <aside class="sidebar">
        <div class="d-flex flex-column h-100">
            <ul class="nav flex-column mb-auto">
                <?php $uri = $_SERVER['REQUEST_URI']; ?>
                <li class="nav-item">
                    <a href="/manajemen-inventaris/index.php" class="nav-link <?= (strpos($uri, 'index.php') !== false && !strpos($uri, 'pages')) ? 'active' : '' ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/manajemen-inventaris/pages/barang/index.php" class="nav-link <?= (strpos($uri, 'barang/') !== false) ? 'active' : '' ?>">
                        <i class="fas fa-box"></i> Data Barang
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="main-wrapper w-100 d-flex flex-column min-vh-100">
        <main class="flex-grow-1 p-4">