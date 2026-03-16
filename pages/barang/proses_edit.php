<?php
include '../../config/koneksi.php';

if (isset($_POST['update'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama        = $_POST['nama_barang']; 
    $harga_beli  = $_POST['harga_beli'];
    $harga_jual  = $_POST['harga_jual'];
    $stok        = $_POST['stok'];
    $id_kat      = $_POST['id_kategori'];
    $id_sat      = $_POST['id_satuan'];

    $foto_name = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];

    $stmt_old = $pdo->prepare("SELECT foto FROM barang WHERE kode_barang = ?");
    $stmt_old->execute([$kode_barang]);
    $row_old = $stmt_old->fetch();
    $foto_lama = $row_old['foto'];

    if (!empty($foto_name)) {
        $ekstensi = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png'];

        if (in_array($ekstensi, $allowed)) {

            $fotobaru = date('YmdHis') . '_' . $kode_barang . '.' . $ekstensi;
            $path = "../../assets/img/barang/" . $fotobaru;

            if (move_uploaded_file($foto_tmp, $path)) {
                if ($foto_lama && file_exists("../../assets/img/barang/" . $foto_lama)) {
                    unlink("../../assets/img/barang/" . $foto_lama);
                }
            }
        } else {
            die("Format file tidak didukung. <a href='edit.php?id=$kode_barang'>Kembali</a>");
        }
    } else {
        $fotobaru = $foto_lama;
    }

    try {
        $sql = "UPDATE barang SET 
                nama_barang = ?, 
                id_kategori = ?, 
                id_satuan   = ?, 
                harga_beli  = ?, 
                harga_jual  = ?, 
                stok        = ?,
                foto        = ? 
                WHERE kode_barang = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nama, $id_kat, $id_sat, $harga_beli, $harga_jual, $stok, $fotobaru, $kode_barang]);
        
        header("Location: index.php?status=updated");
        exit();
        
    } catch (PDOException $e) {
        die("Error saat memperbarui data: " . $e->getMessage() . "<br><a href='edit.php?id=$kode_barang'>Kembali</a>");
    }
}