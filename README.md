# Sistem Manajemen Inventaris Sederhana

Proyek ini dikembangkan sebagai pemenuhan tugas mata kuliah Pemrograman Web Lanjut. Aplikasi ini dirancang untuk mengelola data stok barang secara digital dengan antarmuka yang modern, sistematis, dan responsif.

## Fitur Utama
- **Auto-Generate Kode**: Penomoran kode barang secara otomatis (Format: BRG001, BRG002, dst) untuk menjamin keunikan data.
- **Manajemen Data (CRUD)**: Fasilitas Create, Read, Update, dan Delete untuk data barang, kategori, serta satuan.
- **Pengelolaan Gambar**: Fitur unggah foto produk dengan sistem validasi format file dan ukuran penyimpanan pada server.
- **Desain Responsif**: Antarmuka yang optimal di berbagai perangkat menggunakan Bootstrap 5 dan kustomisasi CSS.

## Teknologi yang Digunakan
- **Bahasa Pemrograman**: PHP 8.x (Menggunakan PDO Extension untuk keamanan transaksi database).
- **Database**: MySQL / MariaDB.
- **Library & Framework**: Bootstrap 5 (Styling), FontAwesome 6 (Ikonografi), dan Google Fonts Inter.

## Struktur Database
Sistem menggunakan prinsip normalisasi data dengan membagi informasi ke dalam 3 tabel utama:
1. **barang**: Menyimpan data detail item (kode, nama, harga, stok, foto, tanggal).
2. **kategori**: Menyimpan daftar pengelompokan jenis barang.
3. **satuan**: Menyimpan daftar satuan ukuran produk.

---
**Disusun Oleh:** Aisha Fayza - Program Studi Sistem Informasi
