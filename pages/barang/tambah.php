<?php
include '../../config/koneksi.php'; 

$query_kode = $pdo->query("SELECT kode_barang FROM barang ORDER BY kode_barang DESC LIMIT 1");
$last_kode = $query_kode->fetch();
if ($last_kode) {
    $no = (int) substr($last_kode['kode_barang'], 3) + 1;
    $new_kode = "BRG" . str_pad($no, 3, "0", STR_PAD_LEFT);
} else {
    $new_kode = "BRG001";
}

$kategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori")->fetchAll();
$satuan = $pdo->query("SELECT * FROM satuan ORDER BY nama_satuan")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Barang</h2>
            <p class="text-muted small mb-0">Lengkapi form di bawah untuk menambah stok barang baru.</p>
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
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control bg-light fw-bold" value="<?= $new_kode ?>" readonly>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control shadow-none" placeholder="Contoh: Pupuk Organik Cair" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Kategori</label>
                        <select name="id_kategori" class="form-select shadow-none" onchange="toggleInput(this, 'kat_baru_input')" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                            <option value="baru" class="text-pink fw-bold">+ Tambah Kategori Baru</option>
                        </select>
                        <input type="text" id="kat_baru_input" name="kategori_baru" class="form-control mt-2" style="display:none;" placeholder="Masukkan kategori baru...">
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
                        <input type="text" id="sat_baru_input" name="satuan_baru" class="form-control mt-2" style="display:none;" placeholder="Masukkan satuan baru (Kg, Liter, Pcs)...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">Rp</span>
                            <input type="number" name="harga_beli" class="form-control border-start-0 shadow-none" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">Rp</span>
                            <input type="number" name="harga_jual" class="form-control border-start-0 shadow-none fw-bold text-pink" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Stok Awal</label>
                        <input type="number" name="stok" class="form-control shadow-none" value="0" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control shadow-none" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted text-uppercase">Foto Barang</label>
                        <input type="file" name="foto" class="form-control shadow-none" accept="image/*" onchange="previewImage(this)">
                        <div class="form-text text-pink small mt-1">* Maksimal 2MB (JPG, PNG, JPEG)</div>
                        <div class="mt-3">
                            <img id="img-preview" class="img-thumbnail" style="display:none; width: 150px; height: 150px; object-fit: cover; border: 2px solid #f374be; border-radius: 12px;">
                        </div>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light border px-4">
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
</script>

</body>
</html>