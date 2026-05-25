<?php 
class BarangController {
    private $model;

    public function __construct($barangModel) {
        $this->model = $barangModel;
    }

    // ini benampilkan halaman utama (index.php)
    public function index() {
        $data = $this->model->getAll();
        include '../app/views/barang/index.php';
    }

    // ini buat menampilkan halaman form tambah (tambah.php)
    public function tambah() {
        $row_max = $this->model->ambilMaksimalUrutan();
        $next_num = ($row_max['max_code'] ?? 0) + 1;
        $new_kode = "BRG" . str_pad($next_num, 3, '0', STR_PAD_LEFT);

        $kategori = $this->model->ambilKategori();
        $satuan = $this->model->ambilSatuan();
        
        include '../app/views/barang/tambah.php';
    }

    // ini buat memproses penyimpanan data dari form tambah.php
    public function simpan() {
        if (isset($_POST['simpan'])) {
            $kode_barang    = $_POST['kode_barang']; 
            $nama_barang    = $_POST['nama_barang'];
            $id_kategori    = $_POST['id_kategori'];
            $id_satuan      = $_POST['id_satuan'];
            $harga_beli     = $_POST['harga_beli'];
            $harga_jual     = $_POST['harga_jual'];
            $stok           = $_POST['stok'];
            $tanggal_masuk  = $_POST['tanggal_masuk'];

            $fotobaru = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $foto_nama = $_FILES['foto']['name'];
                $foto_tmp  = $_FILES['foto']['tmp_name'];
                $ekstensi  = pathinfo($foto_nama, PATHINFO_EXTENSION);
                
                $fotobaru = date('YmdHis') . '_' . $kode_barang . '.' . $ekstensi;
                move_uploaded_file($foto_tmp, "assets/img/barang/" . $fotobaru);
            }

            $payload = [
                'kode'  => $kode_barang,
                'nama'  => $nama_barang,
                'kat'   => $id_kategori,
                'sat'   => $id_satuan,
                'hbeli' => $harga_beli,
                'hjual' => $harga_jual,
                'stok'  => $stok,
                'tgl'   => $tanggal_masuk,
                'foto'  => $fotobaru
            ];

            $this->model->save($payload);
            $_SESSION['sukses'] = "Data barang baru berhasil ditambahkan!";
            header("Location: index.php?page=barang");
            exit();
        }
    }

    // ini buat menampilkan halaman form edit (edit.php)
    public function edit() {
        $id = $_GET['id'] ?? '';
        $barang = $this->model->getById($id);

        if (!$barang) {
            header("Location: index.php?page=barang");
            exit();
        }

        $kategori = $this->model->ambilKategori();
        $satuan = $this->model->ambilSatuan();

        include '../app/views/barang/edit.php';
    }

    // ini buat memproses perubahan data dari form edit.php
    public function update() {
        if (isset($_POST['update'])) {
            $kode_barang    = $_POST['kode_barang']; 
            $nama_barang    = $_POST['nama_barang'];
            $id_kategori    = $_POST['id_kategori'];
            $id_satuan      = $_POST['id_satuan'];
            $harga_beli     = $_POST['harga_beli'];
            $harga_jual     = $_POST['harga_jual'];
            $stok           = $_POST['stok'];

            // 1. AMBIL DATA LAMA DULU (Ini yang kemarin ketinggalan!)
            $barang_lama = $this->model->getById($kode_barang);
            
            // Default pakai foto lama jika user tidak upload foto baru
            $fotobaru = $barang_lama['foto'] ?? null; 

            // 2. CEK APAKAH USER UPLOAD FOTO BARU
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $foto_nama = $_FILES['foto']['name'];
                $foto_tmp  = $_FILES['foto']['tmp_name'];
                $ekstensi  = pathinfo($foto_nama, PATHINFO_EXTENSION);
                
                // Beri nama foto baru unik
                $fotobaru = date('YmdHis') . '_' . $kode_barang . '.' . $ekstensi;
                
                // Upload foto baru ke folder assets
                if (move_uploaded_file($foto_tmp, "assets/img/barang/" . $fotobaru)) {
                    // 3. HAPUS FOTO LAMA (Sekarang variabel $barang_lama sudah ada isinya!)
                    if (!empty($barang_lama['foto']) && file_exists("assets/img/barang/" . $barang_lama['foto'])) {
                        unlink("assets/img/barang/" . $barang_lama['foto']);
                    }
                }
            }

            $payload = [
                'nama'  => $nama_barang,
                'kat'   => $id_kategori,
                'sat'   => $id_satuan,
                'hbeli' => $harga_beli,
                'hjual' => $harga_jual,
                'stok'  => $stok,
                'foto'  => $fotobaru,
                'kode'  => $kode_barang
            ];

            // 4. Kirim ke Model untuk update database
            $this->model->update($payload);
            $_SESSION['sukses'] = "Perubahan data barang berhasil disimpan!";
            header("Location: index.php?page=barang");
            exit();
        }
    }

    // ini buat memproses penghapusan data barang
    public function hapus() {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $barang = $this->model->getById($id);
            if ($barang && $barang['foto'] && file_exists("assets/img/barang/" . $barang['foto'])) {
                unlink("assets/img/barang/" . $barang['foto']);
            }
            $this->model->delete($id);
        }
        header("Location: index.php?page=barang");
        exit();
    }
}