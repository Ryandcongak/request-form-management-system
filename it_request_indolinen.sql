-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Okt 2021 pada 07.58
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it_indolinen`
--
CREATE DATABASE IF NOT EXISTS `it_indolinen` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `it_indolinen`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_requests`
--

CREATE TABLE `tb_requests` (
  `id` int(11) NOT NULL,
  `requestors_name` varchar(255) NOT NULL,
  `today_date` date NOT NULL,
  `date_needed` date NOT NULL,
  `requests_choose` varchar(255) NOT NULL,
  `notes_sharing` text NOT NULL,
  `notes_others` text NOT NULL,
  `head` int(11) NOT NULL,
  `director` int(11) NOT NULL,
  `it_team` int(11) NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_requests`
--

INSERT INTO `tb_requests` (`id`, `requestors_name`, `today_date`, `date_needed`, `requests_choose`, `notes_sharing`, `notes_others`, `head`, `director`, `it_team`, `id_users`) VALUES
(15, 'staff 1', '2021-10-12', '2021-10-12', 'hardware', '', 'set up printer', 0, 0, 0, 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`) VALUES
(4, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(17, 'staff 1', 'e10adc3949ba59abbe56e057f20f883e', 'staff'),
(18, 'staff', '1253208465b1efa876f982d8a9e73eef', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_requests`
--
ALTER TABLE `tb_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_requests`
--
ALTER TABLE `tb_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_requests`
--
ALTER TABLE `tb_requests`
  ADD CONSTRAINT `tb_requests_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
