-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2022 at 12:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id` int(11) NOT NULL,
  `nopol` varchar(15) NOT NULL,
  `tahunpembuatan` int(11) NOT NULL,
  `isisilinder` int(11) NOT NULL,
  `norangka` varchar(15) NOT NULL,
  `nomesin` varchar(15) NOT NULL,
  `warna` varchar(10) NOT NULL,
  `merk` varchar(10) NOT NULL,
  `isKir` int(11) NOT NULL DEFAULT 3,
  `kir_dokumen` varchar(225) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id`, `nopol`, `tahunpembuatan`, `isisilinder`, `norangka`, `nomesin`, `warna`, `merk`, `isKir`, `kir_dokumen`, `id_user`) VALUES
(8, 'AG 3445 YBF', 2020, 150, 'RANGKA', 'MESIN', 'Hitam', 'Honda', 1, '62db22cde9708.png', 12),
(11, 'N 1234 TF', 2021, 1200, 'NO.RANGKA', 'NO.MESIN', 'Putih', 'Honda', 1, '62db237e91b3d.png', 12);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(150) NOT NULL,
  `isAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `nama`, `email`, `password`, `isAdmin`) VALUES
(11, 'Administrator Aplikasi', 'administrator@email.com', '$2y$10$feul4NgiDIJ3BkXhh8Sxg./M.5DYPmaQKBWjH4fWM5qF5MxLmRo0C', 1),
(12, 'Pengguna Aplikasi', 'pengguna@email.com', '$2y$10$UhRcsSF1hTAKuBQleCxxquw2pI4GO6fodfiKat1t8pKpL.qN.hBYK', 0),
(13, 'Johansen', 'johan@email.com', '$2y$10$nbN4IpGVrHDtdUSJC4LjHuXS/YH/4Wk63ue5X1oMbHWDzWC9hsyf6', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD CONSTRAINT `tb_kendaraan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
