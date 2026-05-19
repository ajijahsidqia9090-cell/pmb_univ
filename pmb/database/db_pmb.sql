-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2026 at 06:26 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pmb`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_ulang`
--

CREATE TABLE `daftar_ulang` (
  `id_daftar_ulang` int NOT NULL,
  `id_pendaftaran` int DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `alamat` text,
  `tanggal` date DEFAULT NULL,
  `status` enum('belum','proses','selesai') DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daftar_ulang`
--

INSERT INTO `daftar_ulang` (`id_daftar_ulang`, `id_pendaftaran`, `nama_lengkap`, `jurusan`, `alamat`, `tanggal`, `status`) VALUES
(1, 1, '', 'Informatika', '', '2026-05-19', 'proses'),
(2, 1, 'jeno', 'Informatika', 'adaqd', '2026-05-19', 'proses'),
(3, 2, 'Na Jemin', 'Bisnis Digital', 'neo city', '2026-05-19', 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `id_dokumen` int NOT NULL,
  `id_pendaftaran` int DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_ijazah` varchar(255) DEFAULT NULL,
  `file_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`id_dokumen`, `id_pendaftaran`, `file_ktp`, `file_ijazah`, `file_foto`) VALUES
(1, 1, '1779157157_ktp_Cuplikan layar 2026-05-16 124429.png', '1779157157_ijazah_Cuplikan layar 2026-05-18 205931.png', '1779157157_foto_Cuplikan layar 2026-05-18 213309.png'),
(2, 2, '1779171702_ktp_1779157157_foto_Cuplikan layar 2026-05-18 213309.png', '1779171702_ijazah_1779157157_ktp_Cuplikan layar 2026-05-16 124429.png', '1779171702_foto_Cuplikan layar 2026-05-18 205931.png');

-- --------------------------------------------------------

--
-- Table structure for table `ospek`
--

CREATE TABLE `ospek` (
  `id_ospek` int NOT NULL,
  `judul_kegiatan` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ospek`
--

INSERT INTO `ospek` (`id_ospek`, `judul_kegiatan`, `tanggal`, `lokasi`, `deskripsi`) VALUES
(1, 'pengenalan', '2026-05-19', 'lapangan', 'kjhgfg'),
(3, 'ayo', '2026-05-31', 'kampus', 'ini bersifat wajib');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_pendaftaran` int DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('pending','lunas','ditolak') DEFAULT NULL,
  `id_daftar_ulang` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pendaftaran`, `tanggal_bayar`, `jumlah`, `bukti_pembayaran`, `status_verifikasi`, `id_daftar_ulang`) VALUES
(2, 1, '2026-05-19', '100000.00', '1779160517_bayar_1779157157_foto_Cuplikan layar 2026-05-18 213309.png', 'lunas', 1),
(3, 2, '2026-05-19', '4000000.00', '1779171830_bayar_Cuplikan layar 2026-05-19 062822.png', 'lunas', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `jurusan_pilihan` varchar(100) DEFAULT NULL,
  `status_berkas` enum('pending','valid','ditolak') DEFAULT 'pending',
  `hasil_seleksi` enum('belum','lulus','tidak lulus') DEFAULT 'belum',
  `status_daftar_ulang` enum('belum','proses','sudah') DEFAULT 'belum',
  `nama_lengkap` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_user`, `nik`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `asal_sekolah`, `jurusan_pilihan`, `status_berkas`, `hasil_seleksi`, `status_daftar_ulang`, `nama_lengkap`) VALUES
(1, 6, '3243', 'sjhj', '2026-05-19', 'hdagdg', 'jadgj', 'Informatika', 'valid', 'lulus', 'sudah', 'gsyfgcua'),
(2, 7, '6688990077', 'Busan', '2000-12-08', 'busan 123', 'neo city', 'Bisnis Digital', 'valid', 'lulus', 'belum', 'Na Jaemin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','mahasiswa') DEFAULT 'mahasiswa',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(5, 'Admin', 'admin@gmail.com', '$2y$10$OT5goMr4DzVMrYk795n0Ou.wKz7cTXI.ezNNC6PhbsHy37S7MY/KS', 'admin', '2026-05-19 01:21:42'),
(6, 'jeno', 'jn@gmail.com', '$2y$10$t.nqf/2HtqcLEv2sfYgfmeJ4QF90RiiIuxyWhSzEb/kRLTyuSYow2', 'mahasiswa', '2026-05-19 01:41:02'),
(7, 'Jaemin ', 'jm@gmail.com', '$2y$10$MRm4yewEd4p.ttpsjs9kmOHnXi8ENeuz184.AGyInrlEJmvlq2IRu', 'mahasiswa', '2026-05-19 06:19:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  ADD PRIMARY KEY (`id_daftar_ulang`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id_dokumen`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indexes for table `ospek`
--
ALTER TABLE `ospek`
  ADD PRIMARY KEY (`id_ospek`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  MODIFY `id_daftar_ulang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id_dokumen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ospek`
--
ALTER TABLE `ospek`
  MODIFY `id_ospek` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
