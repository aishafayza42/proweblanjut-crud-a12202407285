<div class="container-fluid" style="font-family: 'Inter', sans-serif;">
    <div class="mb-4 pt-2">
        <h2 class="text-dark">
            <span class="fw-normal text-muted">Selamat datang kembali,</span> 
            <span class="fw-bold"><?= $_SESSION['nama']; ?>! >⩊<</span>
        </h2>
    </div>
</div>

<?php if (isset($_SESSION['sukses'])): ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
        <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['sukses']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php unset($_SESSION['sukses']); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertNode = document.getElementById('success-alert');
        if (alertNode) {
            setTimeout(function() {
                alertNode.classList.remove('show');

                setTimeout(function() {
                    alertNode.remove();
                }, 150); 
            }, 3000);
        }
    });
    </script>
<?php endif; ?>

<div class="container-fluid" style="font-family: 'Inter', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen Inventaris</h2>
            <p class="text-muted small mb-0">Daftar barang berdasarkan tanggal masuk terbaru.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-pink shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
            <a href="index.php?page=barang&action=tambah" class="btn btn-primary px-4 shadow-sm">
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
                            <th class="ps-4" style="width: 110px; vertical-align: middle;">KODE</th>
                            <th style="width: 220px; vertical-align: middle;">NAMA BARANG</th>
                            <th style="width: 130px; text-align: center; vertical-align: middle;">FOTO</th>
                            <th style="width: 150px; vertical-align: middle;">TGL MASUK</th> 
                            <th style="width: 150px; vertical-align: middle;">HARGA JUAL</th>
                            <th style="width: 120px; text-align: center; vertical-align: middle;">STOK</th>
                            <th class="text-center pe-4" style="width: 120px; vertical-align: middle;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td class="ps-4" style="vertical-align: middle;">
                                    <span class="badge bg-light text-dark border px-2 py-1 font-monospace fw-normal">
                                        <?= htmlspecialchars($row['kode_barang']) ?>
                                    </span>
                                </td>
                                
                                <td style="vertical-align: middle;">
                                    <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">
                                        <?= htmlspecialchars($row['nama_barang']) ?>
                                    </div>
                                    <span class="badge bg-light text-muted fw-normal border px-2 py-1" style="font-size: 0.75rem;">
                                        <?= htmlspecialchars($row['nama_kategori'] ?? 'Umum') ?>
                                    </span>
                                </td>
                                
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="assets/img/barang/<?= $row['foto'] ?>" class="rounded shadow-sm border" style="width: 45px; height: 45px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-inline-flex align-items-center justify-content-center text-muted small border" style="width: 45px; height: 45px;"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-secondary" style="vertical-align: middle; font-size: 0.9rem;">
                                    <i class="far fa-calendar-alt me-1 text-pink"></i>
                                    <?= date('d M Y', strtotime($row['tanggal_masuk'])) ?>
                                </td>
                                
                                <td class="fw-normal text-dark" style="vertical-align: middle; font-size: 0.95rem;">
                                    Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?>
                                </td>
                                
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php 
                                        $stok = $row['stok'];
                                        $badgeClass = ($stok <= 5) ? 'bg-danger text-white' : (($stok <= 15) ? 'bg-warning text-dark' : 'bg-success text-white');
                                    ?>
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1.5 fw-normal d-inline-block text-center" style="min-width: 75px; font-size: 0.85rem;">
                                        <?= $stok ?> <?= htmlspecialchars($row['nama_satuan'] ?? '') ?>
                                    </span>
                                </td>
                                
                                <td class="text-center pe-4" style="vertical-align: middle;">
                                    <div class="btn-group gap-1">
                                        <a href="index.php?page=barang&action=edit&id=<?= $row['kode_barang'] ?>" class="btn btn-white btn-sm border" title="Edit"><i class="fas fa-edit text-primary"></i></a>
                                        <a href="index.php?page=barang&action=hapus&id=<?= $row['kode_barang'] ?>" 
                                            class="btn btn-white btn-sm border" 
                                            title="Hapus" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus barang [<?= htmlspecialchars($row['nama_barang']) ?>]?');">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-5 text-center text-muted" style="vertical-align: middle;">
                                    <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
                                    <p class="mb-0">Belum ada data barang.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('tableSearch').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>