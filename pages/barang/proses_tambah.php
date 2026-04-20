<?php
session_start();
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

    $foto_name = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    $foto_size = $_FILES['foto']['size'];
    $foto_err  = $_FILES['foto']['error'];
    $fotobaru  = NULL; 
 
    if ($foto_err === 0) { 
        if ($foto_size < 2000000) {  
            $ekstensi = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION)); 
            $allowed  = ['jpg', 'jpeg', 'png'];

            if (in_array($ekstensi, $allowed)) { 
                $fotobaru = date('YmdHis') . '_' . ($kode_barang ?: 'ITEM') . '.' . $ekstensi; 
                $path = "../../assets/img/barang/" . $fotobaru;
                move_uploaded_file($foto_tmp, $path); 
            }
        }
    }

    if (empty($nama_barang) || empty($harga_jual) || empty($stok)) {
        $_SESSION['error'] = "Semua form wajib diisi!";
        header("Location: tambah.php"); 
        exit();
    }

    if (!is_numeric($harga_beli) || !is_numeric($harga_jual) || !is_numeric($stok)) {
        $_SESSION['error'] = "Harga dan Stok harus berupa angka!";
        header("Location: tambah.php");
        exit();
    }

    try {
        $pdo->beginTransaction();
  
       if ($id_kategori == 'baru' && !empty($_POST['kategori_baru'])) {
            $new_kat = trim($_POST['kategori_baru']);

            $stmt_ins = $pdo->prepare("INSERT IGNORE INTO kategori (nama_kategori) VALUES (?)");
            $stmt_ins->execute([$new_kat]);
 
            $stmt_get = $pdo->prepare("SELECT id FROM kategori WHERE nama_kategori = ?");
            $stmt_get->execute([$new_kat]);
            $id_kategori = $pdo->lastInsertId() ?: $stmt_get->fetchColumn();
        }
  
       if ($id_satuan == 'baru' && !empty($_POST['satuan_baru'])) {
            $new_sat = trim($_POST['satuan_baru']);
            
            $stmt_ins_sat = $pdo->prepare("INSERT IGNORE INTO satuan (nama_satuan) VALUES (?)");
            $stmt_ins_sat->execute([$new_sat]);
            
            $stmt_get_sat = $pdo->prepare("SELECT id FROM satuan WHERE nama_satuan = ?");
            $stmt_get_sat->execute([$new_sat]);
            $id_satuan = $pdo->lastInsertId() ?: $stmt_get_sat->fetchColumn();
        }
 
        if (empty($kode_barang)) {
            $prefix = "BRG";
            $stmt_max = $pdo->prepare("SELECT MAX(SUBSTRING(kode_barang, 4)) as max_code FROM barang");
            $stmt_max->execute();
            $row_max = $stmt_max->fetch(PDO::FETCH_ASSOC);
            $next_num = ($row_max['max_code'] ?? 0) + 1;
            $kode_barang = $prefix . str_pad($next_num, 3, '0', STR_PAD_LEFT);
        }
 
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
        if ($fotobaru && file_exists("../../assets/img/barang/" . $fotobaru)) {
            unlink("../../assets/img/barang/" . $fotobaru);
        }
        die("Gagal menyimpan data: " . $e->getMessage());
    }
}