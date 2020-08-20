-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 20, 2020 at 08:21 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbperpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbuku`
--

CREATE TABLE `tblbuku` (
  `kode` varchar(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `jumlah` char(5) NOT NULL,
  `jenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbuku`
--

INSERT INTO `tblbuku` (`kode`, `judul`, `penerbit`, `jumlah`, `jenis`) VALUES
('P0001', 'Tes tambah buku', 'ntahlah', '6', 'Hiburan');

-- --------------------------------------------------------

--
-- Table structure for table `tblpesan`
--

CREATE TABLE `tblpesan` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `pengirim` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `penerima` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpesan`
--

INSERT INTO `tblpesan` (`id`, `judul`, `isi`, `pengirim`, `username`, `penerima`) VALUES
(16, 'ada', 'afa', 'indra', 'indra', 'admin'),
(17, 'ok', 'berhasil', 'Admin', 'admin', 'indra');

-- --------------------------------------------------------

--
-- Table structure for table `tblpinjam`
--

CREATE TABLE `tblpinjam` (
  `kode` varchar(5) NOT NULL,
  `buku` varchar(6) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Dibaca','Pending','Diterima') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `tblpinjam`
--
DELIMITER $$
CREATE TRIGGER `hapusPinjaman` AFTER UPDATE ON `tblpinjam` FOR EACH ROW BEGIN
	IF(new.status = 'Diterima')
    THEN 
		UPDATE tblbuku SET tblbuku.jumlah = 		tblbuku.jumlah + 1 WHERE 				tblbuku.kode = new.buku;
     END IF;
 END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pinjamBuku` AFTER INSERT ON `tblpinjam` FOR EACH ROW BEGIN
UPDATE tblbuku SET tblbuku.jumlah = tblbuku.jumlah - 1 WHERE tblbuku.kode = new.buku;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblrequestkembali`
--

CREATE TABLE `tblrequestkembali` (
  `kode` char(6) NOT NULL,
  `pinjaman` varchar(5) NOT NULL,
  `tanggalkembalikan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` char(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lvl` enum('Admin','User') NOT NULL,
  `pict` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `status` enum('Active','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `nama`, `username`, `password`, `email`, `lvl`, `pict`, `jenis_kelamin`, `status`) VALUES
(8, 'Admin', 'admin', '$2y$10$5/3GF5Ud5eYjWHjysO5ZPOyvkWPZTdiveVkH6KJxmGkYqzUi0pLC2', 'admin@yahoo.com', 'Admin', '5efd179bb2602.jpg', 'Laki-Laki', 'Active'),
(12, 'ramadya', 'ramadya', '$2y$10$..GqjXkHYvZoDQRTlDV8muVO2RjAPdhAQSCTDeqXGmi341dTgY8aW', 'ramadya', 'User', 'default.png', 'Laki-Laki', 'Active'),
(13, 'nita', 'nita', '$2y$10$xOCRAFeGaoc8.FentH9oQe5vhBgtBxOS1AxbnHV2ilSg0A4iYCQxS', 'nita@gmail.com', 'Admin', 'defaultwoman.png', 'Perempuan', 'Active'),
(15, 'elang timore', 'timore', '$2y$10$JbArowPVitrfbaSvdXr.p.Gta8pd2Vxvjz2v6YwemgKgyu.rRWqSm', 'to@gmail.com', 'User', 'default.png', 'Laki-Laki', 'Active'),
(17, 'indra', 'indra', '$2y$10$DsGKir12wisyGrq6UM.eHOwl8/zd.zNJ3SsX/lg8WBYbg4owpe7T.', 'indra@gmail.com', 'User', 'default.png', 'Laki-Laki', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbuku`
--
ALTER TABLE `tblbuku`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `tblpesan`
--
ALTER TABLE `tblpesan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpinjam`
--
ALTER TABLE `tblpinjam`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `buku` (`buku`);

--
-- Indexes for table `tblrequestkembali`
--
ALTER TABLE `tblrequestkembali`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `pinjaman` (`pinjaman`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblpesan`
--
ALTER TABLE `tblpesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblpinjam`
--
ALTER TABLE `tblpinjam`
  ADD CONSTRAINT `tblpinjam_ibfk_1` FOREIGN KEY (`buku`) REFERENCES `tblbuku` (`kode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
