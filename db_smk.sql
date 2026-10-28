-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2026 at 08:19 AM
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
-- Database: `db_smk`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `jenis_kelamin`, `user_id`) VALUES
(1, '9991', 'fandi', 'L', 2),
(2, '9911', 'asep', 'L', 3),
(3, '9111', 'adi', 'L', 4),
(4, '9992', 'saom', 'L', 5),
(5, '9922', 'dadan', 'L', 6);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `guru_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `kode_mapel`, `nama_mapel`, `guru_id`) VALUES
(1, '01', 'matematika', 1),
(2, '02', 'database', 2),
(3, '03', 'pjok', 3),
(4, '04', 'inggris', 4),
(5, '05', 'indonesia', 5),
(10, '06', 'spain', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mengajar`
--

CREATE TABLE `mengajar` (
  `id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nilai_rapor`
--

CREATE TABLE `nilai_rapor` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `nilai_kkm` int(11) NOT NULL,
  `nilai_pengetahuan` int(11) NOT NULL,
  `nilai_keterampilan` int(11) NOT NULL,
  `keterampilan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jenis_kelamin`, `user_id`) VALUES
(1, '1112', 'daffa', 'XI RPL 1', 'L', 7),
(2, '1122', 'hanif', 'XI RPL 1', 'L', 8),
(3, '1222', 'luthfi', 'XI RPL 1', 'L', 9),
(4, '2222', 'fadil', 'XI RPL 1', 'L', 10),
(5, '2221', 'sergio', 'XI RPL 1', 'L', 11),
(25, '2223', 'sirgio', 'XI RPL 1', 'L', 32),
(26, '12345', 'Sir V', 'XII RPL 2', 'L', 33),
(27, '0987', 'ace hiken', 'XI RPL 1', 'L', 35);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin-hengker', 'admin123', 'admin', '2026-09-20 09:05:07'),
(2, 'g-fandi', 'guru123', 'guru', '2026-09-13 06:04:57'),
(3, 'g-asep', 'guru123', 'guru', '2026-09-13 06:04:57'),
(4, 'g-adi', 'guru123', 'guru', '2026-09-13 06:04:57'),
(5, 'g-saom', 'guru123', 'guru', '2026-09-13 06:04:57'),
(6, 'g-dadang', 'guru123', 'guru', '2026-09-29 01:32:25'),
(7, 'daffadaf', 'siswa123', 'siswa', '2026-09-13 06:04:57'),
(8, 'hanifnif', 'siswa123', 'siswa', '2026-09-13 06:04:57'),
(9, 'luthfifi', 'siswa123', 'siswa', '2026-09-13 06:04:57'),
(10, 'fadildil', 'siswa123', 'siswa', '2026-09-13 06:04:57'),
(11, 'sergioio', 'siswa123', 'siswa', '2026-09-13 06:04:57'),
(32, 'sirgeo', '$2y$10$92Vm.kASnZqOWvgigMTmmuDRBkVte4eW/yhgkSHkNiifAnDJWlF.K', 'siswa', '2026-09-15 00:42:30'),
(33, 'v123', '$2y$10$AESPS7Soh1PpgzqczaVslOfH0EdHujLD2V4Cg/jp80zF/LNGbkvYG', 'siswa', '2026-09-15 00:44:22'),
(34, 'peteeee', '$2y$10$hj8BBuUXu8qB.fZVEZM7iuqATbWMFDriO53ikrLsXOWIN6p5cWNQi', 'admin', '2026-09-29 01:32:17'),
(35, 'hiken no ace', '$2y$10$OxtgrpTsu1nucxlhO5yyxOUQUUL2KC9nYhbk94zKTaoCEM5sqxfla', 'siswa', '2026-09-20 09:02:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
