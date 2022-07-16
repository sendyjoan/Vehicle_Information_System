-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jul 2022 pada 23.24
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sikkb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `tahunpembuatan` int(11) NOT NULL,
  `isisilinder` int(11) NOT NULL,
  `norangka` varchar(15) NOT NULL,
  `nomesin` varchar(15) NOT NULL,
  `warna` varchar(10) NOT NULL,
  `merk` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bahanbakar`
--

CREATE TABLE `tb_bahanbakar` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_bahanbakar`
--

INSERT INTO `tb_bahanbakar` (`id`, `nama`) VALUES
(1, 'Premium'),
(2, 'Pertalite'),
(3, 'Pertamax');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jeniskendaraan`
--

CREATE TABLE `tb_jeniskendaraan` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_jeniskendaraan`
--

INSERT INTO `tb_jeniskendaraan` (`id`, `nama`) VALUES
(1, 'Motor'),
(2, 'Mobil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(150) NOT NULL,
  `isAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `nama`, `email`, `password`, `isAdmin`) VALUES
(5, 'Sendy Joan Kevin', 'sendyjoan5@gmail.com', '$2y$10$YQ4SEKEITxLOHOtB9AASs.LHkMBkwnMQOSxAZHNnjoc0z64Lye6SK', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_bahanbakar`
--
ALTER TABLE `tb_bahanbakar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_jeniskendaraan`
--
ALTER TABLE `tb_jeniskendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_bahanbakar`
--
ALTER TABLE `tb_bahanbakar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_jeniskendaraan`
--
ALTER TABLE `tb_jeniskendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
