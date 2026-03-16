<?php
include '../../config/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id) {
    try {

        $stmt = $pdo->prepare("SELECT foto FROM barang WHERE kode_barang = ?");
        $stmt->execute([$id]);
        $foto = $stmt->fetchColumn();

        if ($foto && file_exists("../../assets/img/barang/" . $foto)) {
            unlink("../../assets/img/barang/" . $foto);
        }

        $stmt_del = $pdo->prepare("DELETE FROM barang WHERE kode_barang = ?");
        $stmt_del->execute([$id]);

        header("Location: index.php?status=deleted");
        exit();

    } catch (PDOException $e) {
        die("Gagal menghapus data: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}