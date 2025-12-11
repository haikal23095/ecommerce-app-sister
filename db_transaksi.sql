users-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 09 Des 2025 pada 00.18
-- Versi server: 8.0.44-0ubuntu0.22.04.1
-- Versi PHP: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_transaksi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_produk`, `jumlah`, `harga_satuan`) VALUES
(1, 1, 1, 1, 55000.00),
(2, 2, 3, 1, 30000.00),
(3, 3, 4, 2, 32000.00),
(4, 4, 5, 3, 26000.00),
(5, 5, 6, 1, 42000.00),
(6, 6, 7, 2, 48000.00),
(7, 7, 8, 1, 70000.00),
(8, 8, 9, 1, 60000.00),
(9, 9, 10, 1, 85000.00),
(10, 10, 11, 2, 30000.00),
(11, 11, 12, 1, 65000.00),
(12, 12, 13, 1, 35000.00),
(13, 13, 14, 2, 50000.00),
(14, 14, 15, 1, 41000.00),
(15, 15, 2, 1, 45000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `metode_bayar` enum('tunai','transfer','qris') NOT NULL,
  `tanggal_bayar` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_transaksi`, `jumlah_bayar`, `metode_bayar`, `tanggal_bayar`) VALUES
(1, 1, 85000.00, 'qris', '2025-12-08 16:19:27'),
(2, 2, 30000.00, 'tunai', '2025-12-08 16:19:27'),
(3, 3, 65000.00, 'transfer', '2025-12-08 16:19:27'),
(4, 4, 120000.00, 'qris', '2025-12-08 16:19:27'),
(5, 5, 45000.00, 'tunai', '2025-12-08 16:19:27'),
(6, 6, 98000.00, 'transfer', '2025-12-08 16:19:27'),
(7, 7, 56000.00, 'qris', '2025-12-08 16:19:27'),
(8, 8, 74000.00, 'tunai', '2025-12-08 16:19:27'),
(9, 9, 30000.00, 'transfer', '2025-12-08 16:19:27'),
(10, 10, 150000.00, 'qris', '2025-12-08 16:19:27'),
(11, 11, 42000.00, 'tunai', '2025-12-08 16:19:27'),
(12, 12, 99000.00, 'transfer', '2025-12-08 16:19:27'),
(13, 13, 62000.00, 'qris', '2025-12-08 16:19:27'),
(14, 14, 88000.00, 'tunai', '2025-12-08 16:19:27'),
(15, 15, 55000.00, 'transfer', '2025-12-08 16:19:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum('admin','pelanggan') NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `kata_sandi`, `peran`, `dibuat_pada`) VALUES
(1, 'Admin Sistem', 'admin', 'admin123', 'admin', '2025-12-08 16:18:33'),
(2, 'Budi Santoso', 'budi', 'budi123', 'pelanggan', '2025-12-08 16:18:33'),
(3, 'Siti Aminah', 'siti', 'siti123', 'pelanggan', '2025-12-08 16:18:33'),
(4, 'Dewi Lestari', 'dewi', 'dewi123', 'pelanggan', '2025-12-08 16:18:33'),
(5, 'Andi Pratama', 'andi', 'andi123', 'pelanggan', '2025-12-08 16:18:33'),
(6, 'Rina Kurnia', 'rina', 'rina123', 'pelanggan', '2025-12-08 16:18:33'),
(7, 'Fajar Hidayat', 'fajar', 'fajar123', 'pelanggan', '2025-12-08 16:18:33'),
(8, 'Leo Prakoso', 'leo', 'leo123', 'pelanggan', '2025-12-08 16:18:33'),
(9, 'Nur Aini', 'nur', 'nur123', 'pelanggan', '2025-12-08 16:18:33'),
(10, 'Hendra Wijaya', 'hendra', 'hendra123', 'pelanggan', '2025-12-08 16:18:33'),
(11, 'Wulan Sari', 'wulan', 'wulan123', 'pelanggan', '2025-12-08 16:18:33'),
(12, 'Samsul Arif', 'samsul', 'samsul123', 'pelanggan', '2025-12-08 16:18:33'),
(13, 'Maya Putri', 'maya', 'maya123', 'pelanggan', '2025-12-08 16:18:33'),
(14, 'Rendy Saputra', 'rendy', 'rendy123', 'pelanggan', '2025-12-08 16:18:33'),
(15, 'Citra Dewanti', 'citra', 'citra123', 'pelanggan', '2025-12-08 16:18:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`, `stok`, `dibuat_pada`) VALUES
(1, 'Kopi Arabica 250g', 55000.00, 20, '2025-12-08 16:18:46'),
(2, 'Kopi Robusta 250g', 45000.00, 25, '2025-12-08 16:18:46'),
(3, 'Teh Hijau Premium', 30000.00, 40, '2025-12-08 16:18:46'),
(4, 'Teh Hitam Premium', 32000.00, 35, '2025-12-08 16:18:46'),
(5, 'Gula Organik 1Kg', 26000.00, 50, '2025-12-08 16:18:46'),
(6, 'Susu Almond 1L', 42000.00, 15, '2025-12-08 16:18:46'),
(7, 'Coklat Bubuk 500g', 48000.00, 22, '2025-12-08 16:18:46'),
(8, 'Madu Hutan 250ml', 70000.00, 18, '2025-12-08 16:18:46'),
(9, 'Minyak Zaitun 250ml', 60000.00, 20, '2025-12-08 16:18:46'),
(10, 'Kacang Almond 500g', 85000.00, 12, '2025-12-08 16:18:46'),
(11, 'Kopi Luwak Sachet', 30000.00, 40, '2025-12-08 16:18:46'),
(12, 'Sirup Maple 250ml', 65000.00, 10, '2025-12-08 16:18:46'),
(13, 'Sereal Gandum 500g', 35000.00, 30, '2025-12-08 16:18:46'),
(14, 'Granola Premium 500g', 50000.00, 25, '2025-12-08 16:18:46'),
(15, 'Susu Oat 1L', 41000.00, 14, '2025-12-08 16:18:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status` enum('menunggu','dibayar','dibatalkan') DEFAULT 'menunggu',
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_pelanggan`, `total_harga`, `status`, `dibuat_pada`) VALUES
(1, 2, 85000.00, 'dibayar', '2025-12-08 16:19:00'),
(2, 3, 30000.00, 'menunggu', '2025-12-08 16:19:00'),
(3, 4, 65000.00, 'dibayar', '2025-12-08 16:19:00'),
(4, 5, 120000.00, 'dibayar', '2025-12-08 16:19:00'),
(5, 6, 45000.00, 'menunggu', '2025-12-08 16:19:00'),
(6, 7, 98000.00, 'dibayar', '2025-12-08 16:19:00'),
(7, 8, 56000.00, 'dibatalkan', '2025-12-08 16:19:00'),
(8, 9, 74000.00, 'dibayar', '2025-12-08 16:19:00'),
(9, 10, 30000.00, 'menunggu', '2025-12-08 16:19:00'),
(10, 11, 150000.00, 'dibayar', '2025-12-08 16:19:00'),
(11, 12, 42000.00, 'dibayar', '2025-12-08 16:19:00'),
(12, 13, 99000.00, 'menunggu', '2025-12-08 16:19:00'),
(13, 14, 62000.00, 'dibayar', '2025-12-08 16:19:00'),
(14, 15, 88000.00, 'dibayar', '2025-12-08 16:19:00'),
(15, 2, 55000.00, 'dibayar', '2025-12-08 16:19:00');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pengguna` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
