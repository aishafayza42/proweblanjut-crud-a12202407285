<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT");

require_once '../config/koneksi.php';
require_once '../app/models/BarangModel.php';

$model = new BarangModel($pdo);

// Membaca data mentah JSON dari body request
$input = json_decode(file_get_contents("php://input"), true);

// Mengambil kode_barang sebagai pengunci data yang akan diubah
$kode_barang = $input['kode_barang'] ?? null;

if (!empty($kode_barang)) {
    // 1. Cek dulu apakah barang tersebut beneran ada di database
    $barangLama = $model->getById($kode_barang);
    
    if ($barangLama) {
        // 2. Ambil data input baru dari JSON. Jika input kosong, gunakan data lama di DB agar tidak terhapus sengaja
        $nama_barang = $input['nama_barang'] ?? $barangLama['nama_barang'];
        $id_kategori = $input['id_kategori'] ?? $barangLama['id_kategori'];
        $id_satuan   = $input['id_satuan']   ?? $barangLama['id_satuan'];
        $harga_beli  = $input['harga_beli']  ?? $barangLama['harga_beli'];
        $harga_jual  = $input['harga_jual']  ?? $barangLama['harga_jual'];
        $stok        = $input['stok']        ?? $barangLama['stok'];
        $foto        = $input['foto']        ?? $barangLama['foto'];
        
        // 3. STABILISASI PAYLOAD
        $payload = [
            'nama'  => $nama_barang,
            'kat'   => $id_kategori,
            'sat'   => $id_satuan,
            'hbeli' => $harga_beli,
            'hjual' => $harga_jual,
            'stok'  => $stok,
            'foto'  => $foto,
            'kode'  => $kode_barang 
        ];
        
        // 4. Eksekusi update dan cek hasilnya secara ketat
        if ($model->update($payload)) {
            http_response_code(200); // Status OK
            echo json_encode([
                "status" => "success",
                "message" => "Data barang [ $kode_barang ] berhasil diperbarui lewat API Postman!",
                "data_diperbarui" => [
                    "nama_barang" => $nama_barang,
                    "stok" => $stok
                ]
            ]);
        } else {
            http_response_code(500); // Server Error
            echo json_encode([
                "status" => "error",
                "message" => "Gagal memperbarui data. Terjadi kesalahan pada query database."
            ]);
        }
    } else {
        http_response_code(404); // Not Found
        echo json_encode([
            "status" => "error",
            "message" => "Barang dengan kode $kode_barang tidak ditemukan di database."
        ]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => "error",
        "message" => "Gagal memperbarui data. Parameter 'kode_barang' wajib disertakan dalam body JSON!"
    ]);
}