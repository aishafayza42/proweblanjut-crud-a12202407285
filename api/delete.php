<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE");

require_once '../config/koneksi.php';
require_once '../app/models/BarangModel.php';

$model = new BarangModel($pdo);

// Membaca data mentah JSON dari body request (wajib untuk metode DELETE / POST JSON)
$input = json_decode(file_get_contents("php://input"), true);

// Mengambil nilai string kode_barang saja
$kode_barang = $input['kode_barang'] ?? null;

if (!empty($kode_barang)) {
    // 1. Cek dulu apakah barangnya memang ada di database sebelum dihapus
    $barang = $model->getById($kode_barang);
    
    if ($barang) {
        // 2. Eksekusi fungsi delete() dengan mengirimkan string $kode_barang langsung
        if ($model->delete($kode_barang)) {
            http_response_code(200); // Status OK
            echo json_encode([
                "status" => "success",
                "message" => "Barang dengan kode [ $kode_barang ] berhasil dihapus permanen lewat API Postman!"
            ]);
        } else {
            http_response_code(500); // Server Error
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menghapus data. Terjadi kesalahan pada server database."
            ]);
        }
    } else {
        http_response_code(404); // Not Found
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menghapus. Barang dengan kode $kode_barang tidak ditemukan di database."
        ]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menghapus data. Parameter 'kode_barang' wajib dicantumkan dalam body JSON!"
    ]);
}