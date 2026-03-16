<?php
include '../../config/koneksi.php'; 

$kategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori")->fetchAll();
$satuan = $pdo->query("SELECT * FROM satuan ORDER BY nama_satuan")->fetchAll();

include '../../includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Tambah Barang</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="../../index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Data Barang</a></li>
                <li class="breadcrumb-item active">Tambah</li>
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
            <i class="fas fa-plus-circle me-2"></i> Form Input Barang Baru
        </h5>
    </div>
    <div class="card-body p-4">
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control bg-light" placeholder="Otomatis (Contoh: BRG001)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control shadow-none" placeholder="Masukkan nama barang" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold text-muted small uppercase">Foto Barang</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-camera text-muted"></i></span>
                        <input type="file" name="foto" class="form-control shadow-none border-start-0" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <div class="form-text small text-pink">* Format: JPG, PNG, atau JPEG (Maks. 2MB)</div>
                    
                    <div class="mt-2">
                        <img id="img-preview" class="img-thumbnail" style="display:none; width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 2px solid #f374be;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Kategori</label>
                    <select name="id_kategori" class="form-select shadow-none" onchange="toggleInput(this, 'kat_baru_input')" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                        <option value="baru" class="fw-bold" style="color: #f374be;">+ Tambah Kategori Baru</option>
                    </select>
                    <input type="text" id="kat_baru_input" name="kategori_baru" class="form-control mt-2" style="display:none;" placeholder="Nama kategori baru...">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small uppercase">Satuan</label>
                    <select name="id_satuan" class="form-select shadow-none" onchange="toggleInput(this, 'sat_baru_input')" required>
                        <option value="">-- Pilih Satuan --</option>
                        <?php foreach($satuan as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama_satuan']) ?></option>
                        <?php endforeach; ?>
                        <option value="baru" class="fw-bold"  style="color: #f374be;">+ Tambah Satuan Baru</option>
                    </select>
                    <input type="text" id="sat_baru_input" name="satuan_baru" class="form-control mt-2" style="display:none;" placeholder="Nama satuan baru...">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small uppercase">Harga Beli (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">Rp</span>
                        <input type="number" name="harga_beli" class="form-control border-start-0" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small uppercase">Harga Jual (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">Rp</span>
                        <input type="number" name="harga_jual" class="form-control border-start-0 fw-bold" style="color: #f374be;" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small uppercase">Stok Awal</label>
                    <input type="number" name="stok" class="form-control shadow-none" value="0" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small uppercase">Tanggal</label>
                    <input type="date" name="tanggal_masuk" class="form-control shadow-none" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-12 mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light border px-4 text-muted">
                            <i class="fas fa-undo me-2"></i> Reset
                        </button>
                        <button type="submit" name="simpan" class="btn btn-primary px-5 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Barang
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function toggleInput(select, inputId) {
    var inputField = document.getElementById(inputId);
    inputField.style.display = (select.value === 'baru') ? 'block' : 'none';
    if(select.value === 'baru') inputField.focus();
}

function previewImage(input) {
    const preview = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}
</script>

<?php include '../../includes/footer.php'; ?>