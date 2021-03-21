-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Mar 2021 pada 15.46
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sig_ktp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `peta_kecamatan`
--

CREATE TABLE `peta_kecamatan` (
  `id_kecamatan` int(11) NOT NULL,
  `kode_kecamatan` varchar(20) NOT NULL,
  `nama_kecamatan` varchar(250) NOT NULL,
  `lokasi_kecamatan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peta_kecamatan`
--

INSERT INTO `peta_kecamatan` (`id_kecamatan`, `kode_kecamatan`, `nama_kecamatan`, `lokasi_kecamatan`) VALUES
(1, '32.04.05', 'Cileunyi', 'cileunyi.geojson'),
(2, '32.04.06', 'Cimenyan', 'cimenyan.geojson'),
(3, '32.04.07', 'Cilengkrang', 'cilengkrang.geojson'),
(4, '32.04.08', 'Bojongsoang', 'bojongsoang.geojson'),
(5, '32.04.09', 'Margahayu', 'margahayu.geojson'),
(6, '32.04.10', 'Margaasih', 'margaasih.geojson'),
(7, '32.04.11', 'Katapang', 'katapang.geojson'),
(8, '32.04.12', 'Dayeuhkolot', 'dayeuhkolot.geojson'),
(9, '32.04.13', 'Banjaran', 'banjaran.geojson'),
(10, '32.04.14', 'Pameungpeuk', 'pameungpeuk.geojson'),
(11, '32.04.15', 'Pangalengan', 'pangalengan.geojson'),
(12, '32.04.16', 'Arjasari', 'arjasari.geojson'),
(13, '32.04.17', 'Cimaung', 'cimaung.geojson'),
(14, '32.04.25', 'Cicalengka', 'cicalengka.geojson'),
(15, '32.04.26', 'Nagreg', 'nagreg.geojson'),
(16, '32.04.27', 'Cikancung', 'cikancung.geojson'),
(17, '32.04.28', 'Rancaekek', 'rancaekek.geojson'),
(18, '32.04.29', 'Ciparay', 'ciparay.geojson'),
(19, '32.04.30', 'Pacet', 'pacet.geojson'),
(20, '32.04.31', 'Kertasari', 'kertasari.geojson'),
(21, '32.04.32', 'Baleendah', 'baleendah.geojson'),
(22, '32.04.33', 'Majalaya', 'majalaya.geojson'),
(23, '32.04.34', 'Solokanjeruk', 'solokanjeruk.geojson'),
(24, '32.04.35', 'Paseh', 'paseh.geojson'),
(25, '32.04.36', 'Ibun', 'ibun.geojson'),
(26, '32.04.37', 'Soreang', 'soreang'),
(27, '32.04.38', 'Pasirjambu', 'pasirjambu.geojson'),
(28, '32.04.39', 'Ciwidey', 'ciwidey.geojson'),
(29, '32.04.40', 'Rancabali', 'rancabali.geojson'),
(30, '32.04.44', 'Cangkuang', 'cangkuang.geojson'),
(31, '32.04.46', 'Kutawaringin', 'kutawaringin.geojson');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `peta_kecamatan`
--
ALTER TABLE `peta_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `peta_kecamatan`
--
ALTER TABLE `peta_kecamatan`
  MODIFY `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
