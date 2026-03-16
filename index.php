<?php 
include 'config/koneksi.php';
include 'includes/header.php'; 

$totalBarang = $pdo->query("SELECT COUNT(*) FROM barang")->fetchColumn() ?: 0;
$stokRendah  = $pdo->query("SELECT COUNT(*) FROM barang WHERE stok < 10")->fetchColumn() ?: 0;
$totalStok   = $pdo->query("SELECT SUM(stok) FROM barang")->fetchColumn() ?: 0;
?>

<div class="mb-4">
    <h2 class="fw-bold text-dark">Dashboard Overview</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="fas fa-layer-group fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Jenis Barang</h6>
                        <h3 class="fw-bold mb-0"><?= number_format($totalBarang) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 text-info p-3 rounded-3">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Stok Unit</h6>
                        <h3 class="fw-bold mb-0"><?= number_format($totalStok) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 <?= ($stokRendah > 0) ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= ($stokRendah > 0) ? 'text-danger' : 'text-success' ?> p-3 rounded-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Stok Kritis (< 10)</h6>
                        <h3 class="fw-bold mb-0"><?= number_format($stokRendah) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                   <i class="fas fa-check-circle fa-5x opacity-25" style="color: #f374be;"></i>
                </div>
                <h3 class="fw-bold">Selamat Datang di MyInventaris</h3>
                <p class="text-muted mx-auto" style="max-width: 500px;">
                    Sistem inventaris Anda sudah siap digunakan. Anda dapat memantau stok, menambah data barang baru, atau mencetak laporan melalui menu navigasi di sebelah kiri.
                </p>
                <div class="mt-4">
                    <a href="/manajemen-inventaris/pages/barang/index.php" class="btn btn-primary px-4 py-2 rounded-pill me-2">
                        <i class="fas fa-box me-2"></i> Kelola Barang
                    </a>
                    
                    <a href="/manajemen-inventaris/pages/barang/tambah.php" class="btn btn-outline-pink px-4 py-2 rounded-pill">
                        <i class="fas fa-plus me-2"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>