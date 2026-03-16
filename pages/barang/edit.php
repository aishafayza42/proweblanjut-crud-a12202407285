<?php 
include '../../config/koneksi.php';
include '../../includes/header.php';

$kode_barang_url = $_GET['id'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM barang WHERE kode_barang = ?");
$stmt->execute([$kode_barang_url]);
$b = $stmt->fetch();

if (!$b) { 
    echo "<script>alert('Data tidak ditemukan!'); location='index.php';</script>"; 
    exit; 
}

$kategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori")->fetchAll();
$satuan = $pdo->query("SELECT * FROM satuan ORDER BY nama_satuan")->fetchAll();

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: #f374be;">Edit Barang</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Data Barang</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="index.php" class="btn btn-outline-secondary shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 fw-bold" style="color: #f374be;">
            <i class="fas fa-edit me-2"></i>Form Perubahan Barang
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Kode Barang</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-tag text-muted"></i></span>
                        <input type="hidden" name="kode_barang" value="<?= htmlspecialchars($b['kode_barang']) ?>">
                        <input type="text" class="form-control bg-light border-start-0 font-monospace" value="<?= htmlspecialchars($b['kode_barang']) ?>" readonly>
                    </div>
                    <div class="form-text text-warning small">* Kode barang tidak dapat diubah.</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control shadow-none" value="<?= htmlspecialchars($b['nama_barang']) ?>" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold text-muted small uppercase">Foto Barang</label>
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <?php if (!empty($b['foto'])): ?>
                                <img src="../../assets/img/barang/<?= $b['foto'] ?>" id="img-preview" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #f374be;">
                            <?php else: ?>
                                <div id="no-photo-text" class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 80px; height: 80px; border-radius: 10px; border: 1px dashed #ccc;">
                                    <small style="font-size: 10px;">No Photo</small>
                                </div>
                                <img id="img-preview" class="img-thumbnail" style="display:none; width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #f374be;">
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <input type="file" name="foto" class="form-control shadow-none" accept="image/*" onchange="previewImage(this)">
                            <div class="form-text small text-pink">* Pilih file jika ingin mengganti foto.</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Kategori</label>
                    <select name="id_kategori" class="form-select shadow-none" required>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $b['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Satuan</label>
                    <select name="id_satuan" class="form-select shadow-none" required>
                        <?php foreach($satuan as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $b['id_satuan'] == $s['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nama_satuan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small uppercase">Harga Beli (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">Rp</span>
                        <input type="number" name="harga_beli" class="form-control border-start-0" value="<?= $b['harga_beli'] ?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small uppercase">Harga Jual (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">Rp</span>
                        <input type="number" name="harga_jual" class="form-control border-start-0 fw-bold" style="color: #f374be;" value="<?= $b['harga_jual'] ?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small uppercase">Jumlah Stok</label>
                    <div class="input-group">
                        <input type="number" name="stok" class="form-control" value="<?= $b['stok'] ?>" required>
                        <span class="input-group-text bg-light">Unit</span>
                    </div>
                </div>

                <div class="col-12 mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" name="update" class="btn btn-primary px-5 shadow-sm rounded-pill">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const noPhotoText = document.getElementById('no-photo-text');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if(noPhotoText) noPhotoText.style.display = 'none';
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../../includes/footer.php'; ?>