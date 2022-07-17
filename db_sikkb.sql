-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2022 at 06:16 PM
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
-- Table structure for table `tb_bahanbakar`
--

CREATE TABLE `tb_bahanbakar` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_bahanbakar`
--

INSERT INTO `tb_bahanbakar` (`id`, `nama`) VALUES
(1, 'Premium'),
(2, 'Pertalite'),
(3, 'Pertamax');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jeniskendaraan`
--

CREATE TABLE `tb_jeniskendaraan` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_jeniskendaraan`
--

INSERT INTO `tb_jeniskendaraan` (`id`, `nama`) VALUES
(1, 'Motor'),
(2, 'Mobil');

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
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id`, `nopol`, `tahunpembuatan`, `isisilinder`, `norangka`, `nomesin`, `warna`, `merk`, `id_user`) VALUES
(8, 'RI 1', 2018, 1200, 'KFHTIE345', 'MOB234FG', 'Hitam', 'Mercedes B', 12);

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
(12, 'Pengguna Aplikasi', 'pengguna@email.com', '$2y$10$UhRcsSF1hTAKuBQleCxxquw2pI4GO6fodfiKat1t8pKpL.qN.hBYK', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bahanbakar`
--
ALTER TABLE `tb_bahanbakar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jeniskendaraan`
--
ALTER TABLE `tb_jeniskendaraan`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tb_bahanbakar`
--
ALTER TABLE `tb_bahanbakar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_jeniskendaraan`
--
ALTER TABLE `tb_jeniskendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
