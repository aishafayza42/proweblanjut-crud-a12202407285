<?php 
include '../../config/koneksi.php';
include '../../includes/header.php'; 

$sql = "SELECT barang.*, kategori.nama_kategori, satuan.nama_satuan 
        FROM barang 
        LEFT JOIN kategori ON barang.id_kategori = kategori.id 
        LEFT JOIN satuan ON barang.id_satuan = satuan.id
        ORDER BY barang.nama_barang ASC";

try {
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ada kesalahan saat mengambil data: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Manajemen Inventaris</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Barang</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary shadow-sm" onclick="window.print()">
            <i class="fas fa-print me-2"></i> Cetak
        </button>
        <a href="tambah.php" class="btn btn-primary shadow-sm px-4">
            <i class="fas fa-plus me-2"></i> Tambah Barang
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 fw-bold">Daftar Barang</h5>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="tableSearch" class="form-control bg-light border-start-0" placeholder="Cari nama atau kode...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-custom">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4" style="width: 100px;">KODE</th>
                        <th style="width: 200px;">NAMA BARANG</th>
                        <th style="width: 80px;">FOTO</th>
                        <th style="width: 120px;">KATEGORI</th>
                        <th style="width: 150px;">HARGA</th>
                        <th style="width: 100px;">STOK</th>
                        <th class="text-center pe-4" style="width: 120px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($data) > 0): ?>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border px-2 py-1 font-monospace">
                                    <?= htmlspecialchars($row['kode_barang']) ?>
                                </span>
                            </td>

                            <td class="col-nama">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama_barang']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($row['nama_satuan'] ?? 'Unit') ?></small>
                            </td>

                            <td>
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="../../assets/img/barang/<?= $row['foto'] ?>" class="img-thumbnail-custom">
                                <?php else: ?>
                                    <div class="no-photo">
                                        <i class="fas fa-camera text-muted" style="font-size: 14px;"></i>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="badge bg-pink-light text-pink rounded-pill px-3">
                                    <?= htmlspecialchars($row['nama_kategori'] ?? 'Umum') ?>
                                </span>
                            </td>

                            <td>
                                <div class="small">
                                    <span class="text-muted">Beli:</span> Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?><br>
                                    <span class="fw-bold text-dark">Jual: Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></span>
                                </div>
                            </td>

                            <td>
                                <?php 
                                    $stok = $row['stok'];
                                    $badgeClass = 'bg-success';
                                    if ($stok <= 5) $badgeClass = 'bg-danger';
                                    elseif ($stok <= 15) $badgeClass = 'bg-warning text-dark';
                                ?>
                                <span class="badge <?= $badgeClass ?> rounded-pill px-3">
                                    <?= $stok ?>
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
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus [<?= $row['nama_barang'] ?>]? Foto barang juga akan terhapus.')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-5 text-center">
                                <i class="fas fa-box-open fa-4x text-light mb-3"></i>
                                <h5 class="text-muted">Belum ada data barang</h5>
                                <a href="tambah.php" class="btn btn-sm btn-primary mt-2">Tambah Sekarang</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Fungsi Cari Barang (Sederhana)
document.getElementById('tableSearch').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

<?php include '../../includes/footer.php'; ?>