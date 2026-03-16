<?php 
include '../../config/koneksi.php';

// Query diperbarui untuk mengambil kolom tanggal_masuk
$sql = "SELECT barang.*, kategori.nama_kategori, satuan.nama_satuan 
        FROM barang 
        LEFT JOIN kategori ON barang.id_kategori = kategori.id 
        LEFT JOIN satuan ON barang.id_satuan = satuan.id
        ORDER BY barang.tanggal_masuk DESC, barang.nama_barang ASC"; // Urutkan dari yang terbaru masuk

try {
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ada kesalahan saat mengambil data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen Inventaris</h2>
            <p class="text-muted small mb-0">Daftar barang berdasarkan tanggal masuk terbaru.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-pink shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
            <a href="tambah.php" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-plus me-2"></i> Tambah Barang
            </a>
        </div>
    </div>

    <div class="card card-custom shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold text-pink">Tabel Barang</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="tableSearch" class="form-control bg-light border-start-0" placeholder="Cari barang...">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-custom">
                    <thead class="bg-pink-light text-muted small uppercase">
                        <tr>
                            <th class="ps-4" style="width: 110px;">KODE</th>
                            <th style="width: 220px;">NAMA BARANG</th>
                            <th style="width: 80px;">FOTO</th>
                            <th style="width: 130px;">TGL MASUK</th> <th style="width: 140px;">HARGA JUAL</th>
                            <th style="width: 100px;">STOK</th>
                            <th class="text-center pe-4" style="width: 140px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data) > 0): ?>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td class="ps-4 font-monospace">
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <?= htmlspecialchars($row['kode_barang']) ?>
                                    </span>
                                </td>

                                <td class="col-nama">
                                    <div class="text-dark"><?= htmlspecialchars($row['nama_barang']) ?></div>
                                    <small class="badge bg-light text-muted fw-normal border"><?= htmlspecialchars($row['nama_kategori'] ?? 'Umum') ?></small>
                                </td>

                                <td>
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="../../assets/img/barang/<?= $row['foto'] ?>" class="img-thumbnail-custom">
                                    <?php else: ?>
                                        <div class="no-photo"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                </td>

                                <td class="small text-muted">
                                    <i class="far fa-calendar-alt me-1 text-pink"></i>
                                    <?= date('d M Y', strtotime($row['tanggal_masuk'])) ?>
                                </td>

                                <td>
                                    <span class="fw-bold text-dark">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></span>
                                </td>

                                <td>
                                    <?php 
                                        $stok = $row['stok'];
                                        $badgeClass = ($stok <= 5) ? 'bg-danger' : (($stok <= 15) ? 'bg-warning text-dark' : 'bg-success');
                                    ?>
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3">
                                        <?= $stok ?> <?= htmlspecialchars($row['nama_satuan'] ?? '') ?>
                                    </span>
                                </td>

                                <td class="text-center pe-4">
                                    <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                        <a href="edit.php?id=<?= $row['kode_barang'] ?>" class="btn btn-white btn-sm border" title="Edit">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <a href="hapus.php?id=<?= $row['kode_barang'] ?>" 
                                           class="btn btn-white btn-sm border" 
                                           title="Hapus" 
                                           onclick="return confirm('Hapus [<?= $row['nama_barang'] ?>]?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-5 text-center text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
                                    <p>Belum ada data barang.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('tableSearch').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>
</body>
</html>