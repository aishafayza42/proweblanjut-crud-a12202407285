<?php
session_start();
include '../../config/koneksi.php'; 

$query_kode = $pdo->prepare("SELECT kode_barang FROM barang ORDER BY kode_barang DESC LIMIT 1");
$query_kode->execute();
$last_kode = $query_kode->fetch(PDO::FETCH_ASSOC);
if ($last_kode) {
    $no = (int) substr($last_kode['kode_barang'], 3) + 1;
    $new_kode = "BRG" . str_pad($no, 3, "0", STR_PAD_LEFT);
} else {
    $new_kode = "BRG001";
}

$stmt_kat = $pdo->prepare("SELECT * FROM kategori ORDER BY nama_kategori");
$stmt_kat->execute(); 
$kategori = $stmt_kat->fetchAll();

$stmt_sat = $pdo->prepare("SELECT * FROM satuan ORDER BY nama_satuan");
$stmt_sat->execute(); 
$satuan = $stmt_sat->fetchAll();

include '../../includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: #000000;">Tambah Barang</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Data Barang</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
    <a href="index.php" class="btn btn-outline-pink shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-pink">
                <i class="fas fa-plus-circle me-2"></i> Form Input Barang
            </h5>
        </div>
        <div class="card-body p-4">

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
               <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control bg-light fw-bold" value="<?= $new_kode ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control shadow-none" placeholder="Contoh: Pupuk Organik Cair" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Kategori</label>
                        <select name="id_kategori" class="form-select shadow-none" onchange="toggleInput(this, 'kat_baru_input')" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                            <option value="baru" class="text-pink fw-bold">+ Tambah Kategori Baru</option>
                        </select>
                        <input type="text" id="kat_baru_input" name="kategori_baru" class="form-control mt-2" style="display:none;" placeholder="Nama kategori baru...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Satuan</label>
                        <select name="id_satuan" class="form-select shadow-none" onchange="toggleInput(this, 'sat_baru_input')" required>
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($satuan as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama_satuan']) ?></option>
                            <?php endforeach; ?>
                            <option value="baru" class="text-pink fw-bold">+ Tambah Satuan Baru</option>
                        </select>
                        <input type="text" id="sat_baru_input" name="satuan_baru" class="form-control mt-2" style="display:none;" placeholder="Nama satuan baru...">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">Rp</span>
                            <input type="number" name="harga_beli" class="form-control border-start-0 shadow-none" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">Rp</span>
                            <input type="number" name="harga_jual" class="form-control border-start-0 shadow-none fw-bold text-pink" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Stok Awal</label>
                        <input type="number" name="stok" class="form-control shadow-none" value="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control shadow-none" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted text-uppercase">Foto Barang</label>
                        <div class="d-flex align-items-start gap-4 p-3 border rounded-3 bg-light">
                            <div class="flex-grow-1">
                                <input type="file" name="foto" class="form-control shadow-none bg-white" accept="image/*" onchange="previewImage(this)">
                                <div class="form-text text-pink small mt-1"><i class="fas fa-info-circle me-1"></i> Maksimal 2MB (JPG, PNG, JPEG)</div>
                            </div>
                            <div id="preview-container">
                                <img id="img-preview" class="img-thumbnail" style="display:none; width: 120px; height: 120px; object-fit: cover; border: 2px solid #f374be; border-radius: 12px;">
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-12 mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light border px-4" onclick="resetForm()">
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

function resetForm() {
    const preview = document.getElementById('img-preview');
    preview.src = '';
    preview.style.display = 'none';

    document.getElementById('kat_baru_input').style.display = 'none';
    document.getElementById('sat_baru_input').style.display = 'none';
}
</script>

<?php include '../../includes/footer.php'; ?>