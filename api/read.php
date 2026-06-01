<?php
// 1. Atur Header agar browser/Postman tahu ini adalah JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// 2. Hubungkan dengan koneksi database dan model yang sudah ada
require_once '../config/koneksi.php';
require_once '../app/models/BarangModel.php';

// 3. Inisialisasi Objek Model (menggunakan variabel $pdo dari koneksi.php)
$model = new BarangModel($pdo);

// 4. Jalankan fungsi mengambil semua data
$dataBarang = $model->getAll();

// 5. Kirimkan respons JSON
if (!empty($dataBarang)) {
    http_response_code(200); // Status OK
    echo json_encode([
        "status" => "success",
        "message" => "Data barang berhasil ditemukan.",
        "data" => $dataBarang
    ]);
} else {
    http_response_code(404); // Status Not Found
    echo json_encode([
        "status" => "error",
        "message" => "Data barang masih kosong.",
        "data" => []
    ]);
}