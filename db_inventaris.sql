-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 11:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventaris`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `id_kategori`, `id_satuan`, `harga_beli`, `harga_jual`, `stok`, `foto`, `tanggal_masuk`) VALUES
('BRG001', 'Bedak Wardah', 4, 1, 12000.00, 15000.00, 5, '20260316083612_BRG001.jpg', '2026-03-08'),
('BRG002', 'Kopi Kapal Api 200gr', 2, 4, 55000.00, 58000.00, 2, '20260316083656_BRG002.jpg', '2026-03-08'),
('BRG003', 'Laptop Asus', 1, 3, 5000000.00, 5550000.00, 20, '20260316133329_BRG003.jpg', '2026-03-16'),
('BRG005', 'Sabun', 4, 1, 10000.00, 12000.00, 12, '20260420163817_BRG005.jpg', '2026-04-13'),
('BRG006', 'Motor OMOWAY', 1, 3, 12000000.00, 15000000.00, 12, '20260420164116_BRG006.jpg', '2026-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(5, 'Alat Mandi'),
(3, 'ATK'),
(1, 'Elektronik'),
(4, 'Kecantikan'),
(6, 'Perlengkapan Mandi'),
(2, 'Sembako');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES
(2, 'Kg'),
(4, 'Pack'),
(1, 'Pcs'),
(3, 'Unit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(2, 'admin', '$2y$10$w6ThDTl0tWqORndROuHfL.Wf6CRkt4x.TbYOVDqjYYkvYW0g0AiG2', 'Aisha Fayza Nur Hidayah ', '2026-03-29 11:16:32'),
(3, 'ria123', '$2y$10$m2On4upM.Ia9ARggZiXKduH2tumkK6B71hEhVf/SZHn6B5qXmj3pu', 'Victoria', '2026-03-31 14:06:10'),
(5, 'udinus', '$2y$10$bHCXO6Pt80q.7J70hdWiHet76UFvoqbJRGeLSZpXmT.2zvoNjTcy2', 'Budiyanto', '2026-04-01 00:24:12'),
(8, 'admin2', '$2y$10$NDOVmV3FnIEOFOfWthWUhetO4lT3VPPZ9haxTjkLCCumWZYKPPpma', 'Aisha Fayza Nur Hidayah ', '2026-04-07 15:52:37'),
(9, 'admin1', '$2y$10$mB3EaXclrtrGEqUx03Rx8Ocs/siqFJWOxLmu3o7TnFMP2ink31pOq', 'Aisha Fayza Nur Hidayah ', '2026-04-07 15:58:54'),
(10, 'admin11', '$2y$10$xz1RRU3HtkT3kPuANkZkve8WothuMioD6yuTE0liFE7ZNj5SFQczO', 'Aisha Fayza Nur Hidayah ', '2026-04-07 16:01:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_satuan` (`nama_satuan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
