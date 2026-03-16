<?php
include '../../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $kode_barang    = $_POST['kode_barang']; 
    $nama_barang    = $_POST['nama_barang'];
    $id_kategori    = $_POST['id_kategori'];
    $id_satuan      = $_POST['id_satuan'];
    $harga_beli     = $_POST['harga_beli'];
    $harga_jual     = $_POST['harga_jual'];
    $stok           = $_POST['stok'];
    $tanggal_masuk  = $_POST['tanggal_masuk'];

    // --- LOGIKA FOTO ---
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    $foto_size = $_FILES['foto']['size'];
    $foto_err  = $_FILES['foto']['error'];
    $fotobaru  = NULL; 

    if ($foto_err === 0) {
        if ($foto_size < 2000000) { // Max 2MB
            $ekstensi = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
            $allowed  = ['jpg', 'jpeg', 'png'];

            if (in_array($ekstensi, $allowed)) {
                // Penamaan foto: YmdHis_BRG001.jpg
                $fotobaru = date('YmdHis') . '_' . ($kode_barang ?: 'ITEM') . '.' . $ekstensi;
                $path = "../../assets/img/barang/" . $fotobaru;
                move_uploaded_file($foto_tmp, $path);
            }
        }
    }

    try {
        $pdo->beginTransaction();

        // --- 1. HANDLE KATEGORI BARU ---
        if ($id_kategori == 'baru' && !empty($_POST['kategori_baru'])) {
            $new_kat = trim($_POST['kategori_baru']);
            $stmt = $pdo->prepare("INSERT IGNORE INTO kategori (nama_kategori) VALUES (?)");
            $stmt->execute([$new_kat]);
            
            // Ambil ID-nya (entah yang baru diinsert atau yang sudah ada)
            $id_kategori = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM kategori WHERE nama_kategori='$new_kat'")->fetchColumn();
        }

        // --- 2. HANDLE SATUAN BARU ---
        if ($id_satuan == 'baru' && !empty($_POST['satuan_baru'])) {
            $new_sat = trim($_POST['satuan_baru']);
            $stmt = $pdo->prepare("INSERT IGNORE INTO satuan (nama_satuan) VALUES (?)");
            $stmt->execute([$new_sat]);
            
            $id_satuan = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM satuan WHERE nama_satuan='$new_sat'")->fetchColumn();
        }

        // --- 3. DOUBLE CHECK KODE BARANG (Safety Net) ---
        if (empty($kode_barang)) {
            $prefix = "BRG";
            $stmt_max = $pdo->query("SELECT MAX(SUBSTRING(kode_barang, 4)) as max_code FROM barang");
            $row_max = $stmt_max->fetch(PDO::FETCH_ASSOC);
            $next_num = ($row_max['max_code'] ?? 0) + 1;
            $kode_barang = $prefix . str_pad($next_num, 3, '0', STR_PAD_LEFT);
        }

        // --- 4. INSERT DATA BARANG ---
        $sql = "INSERT INTO barang (kode_barang, nama_barang, id_kategori, id_satuan, harga_beli, harga_jual, stok, tanggal_masuk, foto) 
                VALUES (:kode, :nama, :kat, :sat, :hbeli, :hjual, :stok, :tgl, :foto)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'kode'  => $kode_barang, 
            'nama'  => $nama_barang, 
            'kat'   => $id_kategori,
            'sat'   => $id_satuan, 
            'hbeli' => $harga_beli, 
            'hjual' => $harga_jual,
            'stok'  => $stok, 
            'tgl'   => $tanggal_masuk,
            'foto'  => $fotobaru 
        ]);

        $pdo->commit();
        echo "<script>alert('Barang berhasil ditambahkan!'); window.location='index.php';</script>";
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        // Hapus foto jika database gagal (biar ga nyampah di folder)
        if ($fotobaru && file_exists("../../assets/img/barang/" . $fotobaru)) {
            unlink("../../assets/img/barang/" . $fotobaru);
        }
        die("Gagal menyimpan data: " . $e->getMessage());
    }
}