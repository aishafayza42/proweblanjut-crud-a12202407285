<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../config/koneksi.php';
require_once '../app/models/BarangModel.php';

$model = new BarangModel($pdo);

// Membaca input data (baik format JSON body maupun form-urlencoded)
$input = json_decode(file_get_contents("php://input"), true);

$nama_barang = $input['nama_barang'] ?? ($_POST['nama_barang'] ?? null);
$id_kategori = $input['id_kategori'] ?? ($_POST['id_kategori'] ?? null);
$id_satuan   = $input['id_satuan']   ?? ($_POST['id_satuan']   ?? null);
$harga_beli  = $input['harga_beli']  ?? ($_POST['harga_beli']  ?? 0);
$harga_jual  = $input['harga_jual']  ?? ($_POST['harga_jual']  ?? 0);
$stok        = $input['stok']        ?? ($_POST['stok']        ?? 0);
$foto        = $input['foto']        ?? ($_POST['foto']        ?? 'no-image.png');

// Validasi input data minimal wajib ada
if (!empty($nama_barang) && !empty($id_kategori) && !empty($id_satuan)) {
    
    // 1. Ambil kode urutan terbesar otomatis dari database kamu
    $maxCodeData = $model->ambilMaksimalUrutan();
    $nextUrutan = 1;
    if ($maxCodeData && $maxCodeData['max_code']) {
        $nextUrutan = (int)$maxCodeData['max_code'] + 1;
    }
    $kode_barang = "BRG" . str_pad($nextUrutan, 3, "0", STR_PAD_LEFT);
    
    // 2. STABILISASI PAYLOAD: Nama KEY harus sama persis dengan placeholder di BarangModel.php!
    $payload = [
        'kode'  => $kode_barang,
        'nama'  => $nama_barang,
        'kat'   => $id_kategori,
        'sat'   => $id_satuan,
        'hbeli' => $harga_beli,
        'hjual' => $harga_jual,
        'stok'  => $stok,
        'tgl'   => date('Y-m-d'),
        'foto'  => $foto
    ];
    
    // 3. Eksekusi ke database dan cek hasilnya secara ketat
    if ($model->save($payload)) {
        http_response_code(201); // Status Created
        echo json_encode([
            "status" => "success",
            "message" => "Barang baru berhasil ditambahkan ke database lewat Postman!",
            "data" => [
                "kode_barang" => $kode_barang,
                "nama_barang" => $nama_barang,
                "stok" => $stok
            ]
        ]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menyimpan data. Terjadi kesalahan pada query database."
        ]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menambah data. Parameter nama_barang, id_kategori, dan id_satuan wajib diisi!"
    ]);
}