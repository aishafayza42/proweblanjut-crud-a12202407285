<?php
class BarangModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // ini untuk mengambil semua data barang untuk halaman index
    public function getAll() {
        $sql = "SELECT barang.*, kategori.nama_kategori, satuan.nama_satuan 
                FROM barang 
                LEFT JOIN kategori ON barang.id_kategori = kategori.id 
                LEFT JOIN satuan ON barang.id_satuan = satuan.id
                ORDER BY barang.kode_barang ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ini untuk mengambil detail satu barang berdasarkan kode (untuk Edit/Hapus)
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM barang WHERE kode_barang = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ini untuk menyimpan barang baru dari form tambah
    public function save($data) {
        $sql = "INSERT INTO barang (kode_barang, nama_barang, id_kategori, id_satuan, harga_beli, harga_jual, stok, tanggal_masuk, foto) 
                VALUES (:kode, :nama, :kat, :sat, :hbeli, :hjual, :stok, :tgl, :foto)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // ini untuk mengupdate data barang dari form edit
    public function update($data) {
        $sql = "UPDATE barang SET 
                nama_barang = :nama, 
                id_kategori = :kat, 
                id_satuan   = :sat, 
                harga_beli  = :hbeli, 
                harga_jual  = :hjual, 
                stok        = :stok,
                foto        = :foto 
                WHERE kode_barang = :kode";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // ini untuk menghapus data barang dari database
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM barang WHERE kode_barang = ?");
        return $stmt->execute([$id]);
    }

    // ini fungsi pembantu bawaanmu
    public function ambilMaksimalUrutan() {
        $stmt = $this->db->prepare("SELECT MAX(SUBSTRING(kode_barang, 4)) as max_code FROM barang");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ambilKategori() {
        $stmt = $this->db->prepare("SELECT * FROM kategori ORDER BY nama_kategori");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ambilSatuan() {
        $stmt = $this->db->prepare("SELECT * FROM satuan ORDER BY nama_satuan");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}