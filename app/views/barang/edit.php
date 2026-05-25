<div class="container-fluid" style="font-family: 'Inter', sans-serif;">
    <div class="mb-4 pt-2">
        <h2 class="fw-bold text-dark">Edit Barang</h2>
        <p class="text-muted small">Perbarui informasi detail mengenai barang inventaris.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="index.php?page=barang&action=update" method="POST" enctype="multipart/form-data">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Kode Barang</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-tag"></i></span>
                            <input type="hidden" name="kode_barang" value="<?= htmlspecialchars($barang['kode_barang']) ?>">
                            <input type="text" class="form-control bg-light border-start-0" value="<?= htmlspecialchars($barang['kode_barang']) ?>" disabled>
                        </div>
                        <small class="text-warning small d-block mt-1">* Kode barang tidak dapat diubah.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($barang['nama_barang']) ?>" required placeholder="Masukkan nama barang">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $kat): ?>
                                <option value="<?= $kat['id'] ?>" <?= ($kat['id'] == $barang['id_kategori']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($kat['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Satuan</label>
                        <select name="id_satuan" class="form-select" required>
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach ($satuan as $sat): ?>
                                <option value="<?= $sat['id'] ?>" <?= ($sat['id'] == $barang['id_satuan']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($sat['nama_satuan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">Harga Beli (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" name="harga_beli" class="form-control" value="<?= htmlspecialchars($barang['harga_beli']) ?>" required placeholder="0">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">Harga Jual (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" name="harga_jual" class="form-control" value="<?= htmlspecialchars($barang['harga_jual']) ?>" required placeholder="0">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($barang['stok']) ?>" required placeholder="0">
                    </div>

                    <div class="col-12 mt-4">
                        <label class="form-label fw-bold text-secondary small d-block">Foto Barang</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="border rounded d-flex align-items-center justify-content-center overflow-hidden bg-light shadow-sm" style="width: 80px; height: 80px;">
                                <?php if (!empty($barang['foto']) && file_exists("assets/img/barang/" . $barang['foto'])): ?>
                                    <img src="assets/img/barang/<?= $barang['foto'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div class="text-center text-muted small px-1"><i class="fas fa-image fa-lg d-block mb-1"></i>No Photo</div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="foto" class="form-control">
                                <small class="text-pink small d-block mt-1">* Pilih file baru jika ingin mengganti foto lama.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="index.php?page=barang" class="btn btn-light px-4 border shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                    <button type="submit" name="update" class="btn btn-primary px-4 shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>