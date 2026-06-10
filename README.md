# Aplikasi Manajemen Inventaris Barang (RESTful API & Secure Auth)

Proyek ini dikembangkan sebagai pemenuhan portofolio tugas mata kuliah Pemrograman Web. Aplikasi ini dirancang untuk mengelola data stok barang secara digital dengan arsitektur **Model-View-Controller (MVC)** yang bersih, interaktif, serta dilengkapi dengan fitur keamanan lanjutan dan integrasi layanan API independen.

---

## Fitur Utama Sistem

* **Autentikasi Aman & Hashing Password (Tugas 6):** Gerbang masuk sistem dilengkapi enkripsi mutakhir menggunakan fungsi bawaan PHP `password_hash()` berbasis algoritma Bcrypt (awalan `$2y$`) dan verifikasi ketat melalui `password_verify()`. Dilengkapi juga fitur kuki (*Cookie*) "Remember Me".
* **Arsitektur RESTful API Independen (Tugas 5):** Menyediakan *endpoint* API mandiri di dalam direktori `api/` (`create.php`, `read.php`, `update.php`, `delete.php`) dengan keluaran berformat standar JSON yang valid untuk dikonsumsi platform eksternal.
* **Auto-Generate Kode Produk:** Penomoran otomatis kode barang secara dinamis (Format: `BRG001`, `BRG002`, dst) di latar belakang sistem untuk menjamin integritas data.
* **Manajemen Data Terintegrasi (CRUD):** Fasilitas penuh *Create, Read, Update,* dan *Delete* untuk data barang, kategori, serta satuan ukuran produk.
* **Pengelolaan File Multi-Media:** Fitur unggah foto produk yang dilengkapi sistem validasi tipe file dan pembatasan ukuran file pada server lokal.
* **Desain Antarmuka Responsif (Tugas 4):** Tampilan visual yang adaptif di berbagai ukuran layar berkat integrasi framework CSS Bootstrap 5 dan penanganan pesan interaktif (*automatic alert dismissal*).

---

## Teknologi dan Spesifikasi Sistem

* **Bahasa Pemrograman:** PHP 8.x (Menggunakan pendekatan **PDO - PHP Data Objects dengan Prepared Statements** untuk proteksi mutlak dari celah keamanan *SQL Injection*).
* **Basis Data:** MySQL / MariaDB (Mendukung relasi tabel antar entitas).
* **API Client Testing:** Postman / Insomnia Client.
* **Library & Desain:** Bootstrap 5, FontAwesome 6 Icons, dan Google Fonts Inter.

---

## Arsitektur Data & Struktur Tabel

Sistem ini menerapkan prinsip normalisasi basis data relasional yang terbagi ke dalam 4 entitas utama:
1.  **`users`**: Menyimpan kredensial akun administrator (Id, Username, Nama, dan Password terenkripsi Hash 255 karakter).
2.  **`barang`**: Menyimpan detail produk (Kode Barang, Nama, Id Kategori, Id Satuan, Harga Beli, Harga Jual, Stok, Nama File Foto, dan Tanggal Input).
3.  **`kategori`**: Menyimpan klasifikasi kelompok jenis barang.
4.  **`satuan`**: Menyimpan daftar satuan ukuran kuantitas produk (Pcs, Box, Pack, dll).

---

## Folder Version Control Cleanliness

Proyek ini telah dikonfigurasi menggunakan berkas `.gitignore` untuk menyaring dan memastikan file sampah sistem operasi (`Thumbs.db`, `desktop.ini`), direktori konfigurasi IDE (`.vscode/`), serta file gambar sementara hasil testing tidak mengotori riwayat komit publik pada repositori.

---
**✨ Disusun Oleh:**
* **Nama:** Aisha Fayza
* **NIM:** A12.2024.07285
* **Program Studi:** Sistem Informasi
* **Instansi:** Universitas Dian Nuswantoro (UDINUS)