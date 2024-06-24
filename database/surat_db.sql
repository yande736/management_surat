-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 24 Jun 2024 pada 08.58
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `division`
--

INSERT INTO `division` (`id`, `name`) VALUES
(1, 'HR'),
(2, 'Finance'),
(3, 'IT'),
(4, 'Marketing'),
(5, 'Sales');

-- --------------------------------------------------------

--
-- Struktur dari tabel `letters`
--

CREATE TABLE `letters` (
  `id` int(11) NOT NULL,
  `division_id` int(11) DEFAULT NULL,
  `letter_number` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved') DEFAULT 'pending',
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `letters`
--

INSERT INTO `letters` (`id`, `division_id`, `letter_number`, `date_created`, `status`, `file_name`) VALUES
(1, 2, '001/D2/06/2024', '2024-06-16 15:44:50', 'approved', 'IMG_0629.JPG'),
(2, 3, '001/D3/06/2024', '2024-06-16 15:51:38', 'approved', 'Analisis_Perusahaan_Pada_PT_Unilever.pdf'),
(4, 5, '001/D5/06/2024', '2024-06-16 16:14:01', 'approved', 'Tugas_PM_pertemuan_X.pdf'),
(5, 4, '001/Div4/06/2024', '2024-06-16 16:17:44', 'approved', 'assignmnet 9-bhs_asing_II.pdf'),
(7, 1, '002/HR/06/2024', '2024-06-16 16:24:39', 'approved', 'pertemuan11_230030069_bhs_asing_II.pdf'),
(8, 5, '002/Div5/06/2024', '2024-06-17 08:48:09', 'approved', 'pertemuan11_230030069_bhs_asing_II.pdf'),
(20, 3, '003/IT/06/2024/', '2024-06-23 14:43:59', 'approved', '2e40b42264b296aeab558cb71c965841e5a3.pdf'),
(21, 3, '004/IT/06/2024/', '2024-06-23 15:15:53', 'approved', 'logo_stikom-removebg-preview.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `division_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `division_id`) VALUES
(11, 'admin', '$2y$10$v04kr7qU3dEZxwprbtROyec.QhSpmb9wz57XvryZ6w2q7dG5LjUAi', 'admin', 3),
(12, 'karyawanFinace', '$2y$10$0qEsf8C0XWdXp1wd0LVsjO9Sm6xwYfRZNKHOIeDE0onk7ASo7W02G', 'user', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `letters`
--
ALTER TABLE `letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `division_id` (`division_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `letters`
--
ALTER TABLE `letters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `letters`
--
ALTER TABLE `letters`
  ADD CONSTRAINT `letters_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
