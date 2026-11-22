-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2026 at 06:27 PM
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
-- Database: `db_simba`
--

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `id_beasiswa` int NOT NULL,
  `nama_beasiswa` varchar(150) NOT NULL,
  `penyelenggara` varchar(150) DEFAULT 'SIMBA Foundation',
  `deskripsi` text NOT NULL,
  `jenjang` varchar(50) DEFAULT 'S1 / D3',
  `jurusan` varchar(100) DEFAULT 'Semua Jurusan',
  `kuota` int NOT NULL,
  `deadline` date DEFAULT NULL,
  `batas_waktu` date DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Aktif',
  `is_unggulan` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`id_beasiswa`, `nama_beasiswa`, `penyelenggara`, `deskripsi`, `jenjang`, `jurusan`, `kuota`, `deadline`, `batas_waktu`, `status`, `is_unggulan`, `created_at`) VALUES
(1, 'Beasiswa Prestasi', 'SIMBA Foundation', 'Ditujukan bagi mahasiswa dengan rekam jejak akademik gemilang (IPK minimal 3.50) maupun juara kompetisi tingkat regional, nasional, dan internasional. Bebas UKT hingga 100% + tunjangan buku & riset.', 'S1 / D3', 'Semua Jurusan', 50, '2026-12-19', NULL, 'Aktif', 1, '2026-11-22 17:44:05'),
(2, 'Beasiswa Peduli Pendidikan (Tidak Mampu)', 'SIMBA Foundation', 'Program bantuan biaya pendidikan penuh (UKT 100% + uang saku bulanan) bagi pelajar berpotensi tinggi pemegang KIP / SKTM resmi yang memiliki keterbatasan ekonomi keluarga.', 'S1 / D3', 'Semua Jurusan', 100, '2026-12-19', NULL, 'Aktif', 0, '2026-11-22 17:45:47'),
(3, 'Beasiswa Talenta Digital & Kepemimpinan', 'SIMBA Foundation', 'Dikhususkan bagi aktivis organisasi kemahasiswaan, penggerak komunitas sosial, serta kreator inovasi teknologi. Subsidi UKT 75% + dana inkubasi dan mentoring praktisi industri.', 'S1 / D3', 'Semua Jurusan', 40, '2026-12-19', NULL, 'Aktif', 0, '2026-11-22 17:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `id_user` int NOT NULL,
  `id_beasiswa` int NOT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `alasan_mendaftar` text,
  `file_ktm` varchar(255) DEFAULT NULL,
  `file_transkrip` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','revisi','diterima','ditolak') DEFAULT 'menunggu',
  `catatan_admin` text,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_user`, `id_beasiswa`, `ipk`, `alasan_mendaftar`, `file_ktm`, `file_transkrip`, `status`, `catatan_admin`, `tanggal_daftar`) VALUES
(1, 1, 3, '3.45', NULL, NULL, NULL, 'menunggu', NULL, '2026-11-22 18:03:58'),
(2, 1, 2, '3.45', NULL, NULL, NULL, 'ditolak', NULL, '2026-11-22 18:13:56'),
(3, 1, 1, '3.45', NULL, NULL, NULL, 'menunggu', NULL, '2026-11-22 18:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pendaftar','admin') DEFAULT 'pendaftar',
  `nim` varchar(30) DEFAULT NULL,
  `jenjang` varchar(20) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `email`, `password`, `role`, `nim`, `jenjang`, `jurusan`, `ipk`, `created_at`) VALUES
(1, 'Grace Josephine', 'gracejo@gmail.com', '$2y$10$gaJuK/cjqvUA.pJaRaxFy.le8B0AvN6Q6BmiOGt332cWEoEPAnjda', 'pendaftar', NULL, NULL, NULL, NULL, '2026-11-22 17:03:31'),
(2, 'Admin SIMBA', 'admin@simba.com', '$2y$10$abbgpx/j.yTyubiT9gcr/.G9t0yofF3Dxr2qYabo7DAhybvLeUkkK', 'admin', NULL, NULL, NULL, NULL, '2026-11-22 17:26:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`id_beasiswa`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_beasiswa` (`id_beasiswa`);

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
-- AUTO_INCREMENT for table `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `id_beasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`id_beasiswa`) REFERENCES `beasiswa` (`id_beasiswa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
