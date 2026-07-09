-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Mar 2023 pada 04.02
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `viewcashier`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jenis` bigint(20) UNSIGNED DEFAULT NULL,
  `stok` double(12,5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cetak_laporan`
--

CREATE TABLE `cetak_laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_resi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_member` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kasir` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jenis_laporan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_cetak` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_piutang`
--

CREATE TABLE `detail_piutang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kasir_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uang` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` double(8,2) NOT NULL,
  `satuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `diskon` double(8,2) DEFAULT NULL,
  `is_return` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jenis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `kode_member` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_anggota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_mmt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_member` enum('customer','supplier') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `telepon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`kode_member`, `no_anggota`, `kode_mmt`, `jenis_member`, `nama`, `unit`, `telepon`, `alamat`, `created_at`, `updated_at`, `deleted_at`) VALUES
('U-00-01', NULL, NULL, 'customer', 'general-customer', 0, NULL, NULL, '2023-03-01 02:51:40', '2023-03-01 02:51:40', NULL),
('U-00-02', NULL, NULL, 'supplier', 'general-supplier', 0, NULL, NULL, '2023-03-01 02:51:40', '2023-03-01 02:51:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_01_13_013144_create_barangs_table', 1),
(5, '2021_01_13_013207_create_satuan_barangs_table', 1),
(6, '2021_01_13_013224_create_members_table', 1),
(7, '2021_01_13_013244_create_transaksis_table', 1),
(8, '2021_01_13_013312_create_detail_transaksis_table', 1),
(9, '2021_01_13_021339_create_user_levels_table', 1),
(10, '2021_01_13_022206_add_column_level_in_users_table', 1),
(11, '2021_01_20_021132_add_column_lunas_in_transaksi_table', 1),
(12, '2021_01_26_021948_add_column_no_hp_in_user_table', 1),
(13, '2021_02_01_021842_create_detail_piutang_table', 1),
(14, '2021_02_09_015147_add_column_unit_in_member_table', 1),
(15, '2021_02_09_015436_add_column_diskon_in_detail_transaksi_table', 1),
(16, '2021_03_01_140356_add_column_image_in_users_table', 1),
(17, '2021_03_17_135405_add_column_harga_supplier_in_satuan_barang_table', 1),
(18, '2021_03_18_135610_create_table_cetak_laporan', 1),
(19, '2021_03_19_100734_add_column_dpb_in_transaksi_table', 1),
(20, '2021_03_25_120212_create_jenis_barang_table', 1),
(21, '2021_03_25_120513_add_jenis_barang_in_barang_table', 1),
(22, '2021_03_31_085136_add_column_donasi_in_transaksi', 1),
(23, '2021_04_06_090600_add_no_anggota_in_member', 1),
(24, '2021_04_14_082113_add_is_print_in_transaksi', 1),
(25, '2021_04_19_103937_add_kode_mmt_in_member', 1),
(26, '2021_04_19_105035_add_is_return_in_detail', 1),
(27, '2021_04_21_093515_add_column_jenis_mmt_in_transaksi', 1),
(28, '2021_04_22_085525_create_table_mutasi_utang', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_utang`
--

CREATE TABLE `mutasi_utang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_member` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_utang` enum('piutang','hutang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo_awal` double(12,8) NOT NULL,
  `penambahan` double(12,8) NOT NULL,
  `pembayaran` double(12,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan_barang`
--

CREATE TABLE `satuan_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_satuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rasio` double(8,2) NOT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_supl` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `no_resi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_dpb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jenis_transaksi` enum('pembelian','penjualan','pengiriman') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_mmt` enum('mmt-reguler','mmt-area') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kasir_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int(11) NOT NULL,
  `diskon` double(8,2) DEFAULT NULL,
  `uang` double(12,2) DEFAULT NULL,
  `donasi` double(12,2) DEFAULT NULL,
  `is_lunas` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lunas` timestamp NULL DEFAULT NULL,
  `is_print` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `level`, `name`, `email`, `image`, `no_hp`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
('U-210114001', 1, 'superadmin', 'superadmin@mail.com', NULL, NULL, '2023-03-01 02:51:37', '$2y$10$vIjyYzWn/35voRzuFuYzw.jQIkohZQ9gUic4PkQtD5DEId7pdQLl2', 'XGVY8jezr7', '2023-03-01 02:51:38', '2023-03-01 02:51:38', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level`
--

CREATE TABLE `user_level` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_level`
--

INSERT INTO `user_level` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super administrator', '2023-03-01 02:51:35', '2023-03-01 02:51:35', NULL),
(2, 'accounting', '2023-03-01 02:51:36', '2023-03-01 02:51:36', NULL),
(3, 'admin-piutang', '2023-03-01 02:51:36', '2023-03-01 02:51:36', NULL),
(4, 'admin-pembelian', '2023-03-01 02:51:36', '2023-03-01 02:51:36', NULL),
(5, 'kasir', '2023-03-01 02:51:37', '2023-03-01 02:51:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `barang_id_jenis_index` (`id_jenis`);

--
-- Indeks untuk tabel `cetak_laporan`
--
ALTER TABLE `cetak_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_piutang`
--
ALTER TABLE `detail_piutang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksi_transaksi_id_index` (`transaksi_id`),
  ADD KEY `detail_transaksi_kode_barang_index` (`kode_barang`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`kode_member`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mutasi_utang`
--
ALTER TABLE `mutasi_utang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mutasi_utang_kode_member_index` (`kode_member`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuan_barang_kode_barang_index` (`kode_barang`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`no_resi`),
  ADD KEY `transaksi_kasir_id_index` (`kasir_id`),
  ADD KEY `transaksi_member_id_index` (`member_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_level_index` (`level`);

--
-- Indeks untuk tabel `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cetak_laporan`
--
ALTER TABLE `cetak_laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_piutang`
--
ALTER TABLE `detail_piutang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `mutasi_utang`
--
ALTER TABLE `mutasi_utang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `satuan_barang`
--
ALTER TABLE `satuan_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_kode_barang_foreign` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`no_resi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mutasi_utang`
--
ALTER TABLE `mutasi_utang`
  ADD CONSTRAINT `mutasi_utang_kode_member_foreign` FOREIGN KEY (`kode_member`) REFERENCES `member` (`kode_member`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD CONSTRAINT `satuan_barang_kode_barang_foreign` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_kasir_id_foreign` FOREIGN KEY (`kasir_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `member` (`kode_member`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_level_foreign` FOREIGN KEY (`level`) REFERENCES `user_level` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
