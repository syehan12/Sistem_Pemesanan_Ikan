-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2025 at 04:25 PM
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
-- Database: `si_pemesanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kd_barang` char(5) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `harga_jual` int NOT NULL,
  `stok` int NOT NULL,
  `keterangan` text NOT NULL,
  `file_gambar` varchar(100) NOT NULL,
  `kd_kategori` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `nm_barang`, `harga_jual`, `stok`, `keterangan`, `file_gambar`, `kd_kategori`) VALUES
('B0001', 'Tetra Kongo Albino (rayakan)', 800, 6798, 'Rayakan Tetra Kongo Albino dengan ukuran 2-3 cm', 'B0001.rayakalbino.jpeg', 'K001'),
('B0002', 'Blitz Its', 10000, 633, 'Obat ini berfungsi untuk mengobati dan mencegah penyakit ikan yang disebabkan oleh infeksi jamur atau fungus, infeksi sporozoa/trypanosoma, dan white spot (Ichthyopthirius) pada ikan ', 'B0002.blitich.jpg', 'K002'),
('B0003', 'Sterbai (rayakan)', 700, 2999, 'Rayakan Sterbai dengan ukuran 2-3 cm', 'B0003.sterba2i (1).jpeg', 'K001'),
('B0006', 'Sterbai (dewasa)', 10000, 200, ' Corydoras sterbai, adalah ikan hias air tawar yang populer, dikenal dengan penampilan unik dan perilaku sosialnya. Ikan ini memiliki ukuran sekitar 7-8 cm dengan tubuh berwarna abu-abu antrasit dan bintik-bintik keperakan yang tersebar di sekujur tubuh. Ciri khas lainnya adalah sirip perut dan dada berwarna oranye terang, serta dua pasang sungut (barbels) yang membantunya mencari makan di dasar akuarium.\r\nUkuran: Mencapai panjang sekitar 7-8 cm. \r\nWarna: Tubuh abu-abu antrasit dengan bintik-bintik keperakan. Sirip perut dan dada berwarna oranye terang. \r\nBentuk tubuh: Memiliki dua pasang sungut (barbels) di sekitar mulut. \r\nPerilaku: Ikan yang senang bergerombol, damai, dan aktif di dasar akuarium. \r\nHabitat: Ditemukan di perairan tropis Amerika Selatan, khususnya di Brasil dan Bolivia. \r\nPakan: Omnivora, memakan cacing, krustasea, serangga, dan bahan tanaman. \r\nKebutuhan lingkungan: pH air 6.0-8.0, kesadahan air 2-25 dGH, suhu 24-28°C. ', 'B0006.sterbai.jpg', 'K001'),
('B0004', 'Artemia Supreme Plus 425 Gr', 850000, 20, 'Artemia Supreme Plus adalah pakan alami untuk ikan dan udang yang kaya nutrisi dan mudah ditetaskan. Artemia ini memiliki kandungan protein tinggi dan dapat meningkatkan pertumbuhan serta warna ikan dan udang. Berbagai sumber mengatakan produk ini juga membantu meningkatkan daya tahan ikan terhadap stres dan penyakit. \r\nDeskripsi Artemia Supreme Plus:\r\nJenis Pakan: Pakan alami berupa zooplankton yang sangat kecil, cocok untuk larva ikan dan udang. \r\nKandungan Nutrisi: Protein tinggi, lemak, serta nutrisi penting lainnya untuk pertumbuhan. \r\nAsal: Artemia Supreme Plus banyak berasal dari Great Salt Lake, Amerika. \r\nKemudahan Penggunaan: Mudah ditetaskan dan diberikan sebagai pakan. \r\nManfaat Artemia Supreme Plus:\r\nPertumbuhan Cepat: Mempercepat pertumbuhan ikan dan udang, terutama pada fase larva. \r\nPeningkatan Warna: Meningkatkan kecerahan dan variasi warna pada ikan hias. \r\nKesehatan Ikan: Meningkatkan daya tahan tubuh ikan terhadap stres dan penyakit. \r\nNutrisi Lengkap: Memberikan nutrisi yang dibutuhkan larva ikan dan udang untuk perkembangan optimal. \r\nMudah Ditetaskan: Proses penetasan yang sederhana memudahkan peternak dalam menyediakan pakan. ', 'B0004.arthemia.jpeg', 'K002'),
('B0005', 'Garam Ikan 500 Gr', 4000, 100, 'Garam ikan adalah garam yang dikhususkan untuk budidaya ikan, baik ikan hias maupun ikan konsumsi, karena kandungan NaCl-nya yang murni. Garam ikan berfungsi sebagai antiseptik alami untuk mencegah dan mengatasi berbagai penyakit pada ikan yang disebabkan oleh bakteri, jamur, dan parasit. Selain itu, garam ikan juga bermanfaat untuk menormalkan pH air, mengurangi stres pada ikan, serta membersihkan kotoran yang menempel pada insang. \r\nDeskripsi Garam Ikan:\r\nKandungan:\r\nGaram ikan mengandung NaCl (Natrium Klorida) murni tanpa tambahan mineral lain yang biasa ditemukan pada garam dapur. \r\nTekstur:\r\nGaram ikan memiliki tekstur yang lebih kasar dan kristalnya lebih besar dibandingkan garam dapur. \r\nPenggunaan:\r\nGaram ikan digunakan untuk budidaya ikan, baik dalam akuarium maupun kolam. \r\nManfaat Garam Ikan:\r\nMengatasi Infeksi:\r\nGaram ikan efektif dalam memberantas parasit, jamur, dan bakteri yang dapat menyebabkan penyakit pada ikan. \r\nMenormalkan pH Air:\r\nGaram ikan dapat membantu menstabilkan pH air, mencegah kondisi asam yang dapat membuat ikan stres. \r\nMengurangi Stres Ikan:\r\nGaram dapat membantu ikan beradaptasi dengan perubahan lingkungan, seperti saat pemindahan atau pergantian air, sehingga mengurangi stres. \r\nMembersihkan Insang:\r\nGaram ikan membantu melepaskan partikel kotoran yang menempel pada insang, menjaga kesehatan insang. \r\nMencegah Pertumbuhan Lumut:\r\nGaram ikan dapat menghambat pertumbuhan lumut pada kolam atau akuarium. \r\nMeningkatkan Kualitas Air:\r\nGaram membantu menjaga kualitas air dengan menstabilkan kadar nitrit, yang beracun bagi ikan. \r\nMeningkatkan Nafsu Makan:\r\nPenggunaan garam ikan secara tepat dapat meningkatkan nafsu makan ikan dan mendukung pertumbuhan optimal. \r\nPenting untuk diperhatikan:\r\nGunakan garam ikan dengan dosis yang tepat sesuai kebutuhan, karena penggunaan yang berlebihan dapat merusak kualitas air dan membahayakan ikan. \r\nPahami jenis ikan yang akan dipelihara, karena tidak semua ikan tahan terhadap garam. \r\nGunakan garam ikan yang berkualitas baik dan pastikan tidak ada tambahan mineral lain selain NaCl. ', 'B0005.grm.jpg', 'K002'),
('B0007', 'Tetra Kongo (dewasa)', 10000, 200, 'Ikan tetra kongo (Phenacogrammus interruptus) adalah ikan air tawar yang berasal dari perairan Afrika, khususnya daerah Sungai Kongo. Ikan ini dikenal karena keindahan warna-warni tubuhnya yang berkilauan, terutama pada ikan jantan, dan siripnya yang panjang dan berumbai. Ikan tetra kongo adalah ikan yang populer di kalangan penghobi akuarium karena keindahan', 'B0007.p11.jpg', 'K001'),
('B0008', 'Tetra Kongo (rayakan)', 700, 10000, 'Ikan tetra kongo rayakan ukuran 2-3cm adalah ikan air tawar yang berasal dari perairan Afrika, khususnya daerah Sungai Kongo. Ikan ini dikenal karena keindahan warna-warni tubuhnya yang berkilauan, terutama pada ikan jantan, dan siripnya yang panjang dan berumbai. Ikan tetra kongo adalah ikan yang populer di kalangan penghobi akuarium karena keindahan', 'B0008.maxresdefault.jpg', 'K001'),
('B0009', 'Tetra Kongo Albino (dewasa)', 12000, 200, 'ikan tetra kongo albino merupakan varian dari ikan tetra kongo yang mengalami mutasi genetik sehingga tidak memiliki pigmen warna, menghasilkan warna putih atau krem yang unik. Ikan ini memiliki ciri khas seperti ikan tetra pada umumnya, yaitu tubuh yang berbentuk pipih memanjang dan sisik yang agak besar.', 'B0009.sterba2i-(2).jpg', 'K001');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` char(10) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K001', 'Jenis Ikan'),
('K002', 'Perlengkapan Aquarium');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kd_pelanggan` char(6) NOT NULL,
  `nm_pelanggan` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat_lengkap` varchar(500) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tgl_daftar` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`kd_pelanggan`, `nm_pelanggan`, `email`, `no_telepon`, `alamat_lengkap`, `username`, `password`, `tgl_daftar`) VALUES
('P0001', 'jamir', 'mumun@gmail.com', '12333', 'asd', 'jamir', 'c6f2088059e98c3da5e0f1529e915d09', '2025-06-12'),
('P0002', 'samsur', 'filterindobandung@gmail.com', '213', 'xasd', 'samsur', '65d3a10d1a233b3f0e428e9cfe1b40ef', '2025-06-16'),
('P0003', 'Acong', 'acong@gmail.com', '087819982266', 'Jalan raya kebalen kota bekasi', 'acongzema', '2d3882a87182aeb9cba3b1a7c2d55603', '2025-06-17'),
('P0004', 'syehan', 'syehan@gmail.com', '088213773422', 'Kota Bekasi', 'syehan', 'eda752907cee78d9fc1d3caef302d1ed', '2025-07-01'),
('P0005', 'Gatot', 'gatot@gmail.com', '09982173232', 'Jalan mekarsari kota bekasi, jawa barat', 'gatot', 'bb474dec2b2526c82e22c987722bbd7e', '2025-07-08');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `no_pemesanan` char(8) NOT NULL,
  `kd_pelanggan` char(6) NOT NULL,
  `tgl_pemesanan` date NOT NULL,
  `waktu_pemesanan` time NOT NULL,
  `nama_penerima` varchar(60) NOT NULL,
  `alamat_lengkap` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `status_bayar` enum('Belum Lunas','Lunas') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_pesanan` enum('Menunggu','Diproses','Dikirim','Terkirim') NOT NULL DEFAULT 'Menunggu',
  `metode_pembayaran` varchar(500) NOT NULL,
  `bank` varchar(500) NOT NULL,
  `norek` varchar(100) NOT NULL,
  `bukti_bayar` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`no_pemesanan`, `kd_pelanggan`, `tgl_pemesanan`, `waktu_pemesanan`, `nama_penerima`, `alamat_lengkap`, `no_telepon`, `status_bayar`, `status_pesanan`, `metode_pembayaran`, `bank`, `norek`, `bukti_bayar`) VALUES
('PS0001', 'P0004', '2025-07-09', '20:35:56', 'Syehan', 'Kota Bekasi', '3333232322', 'Belum Lunas', 'Dikirim', 'cod', '-', '-', ''),
('PS0002', 'P0001', '2025-07-09', '20:43:53', 'jamir', 'asd', '08772622113888', 'Lunas', 'Menunggu', 'transfer', 'bri', '-222222', 'bukti_20250709204353_809.jpg'),
('PS0003', 'P0004', '2025-07-09', '21:22:05', 'syehan', 'Kota Bekasi', '12312', 'Lunas', 'Menunggu', 'transfer', 'bni', '-088888', 'bukti_20250709212205_701.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_item`
--

CREATE TABLE `pemesanan_item` (
  `id` int NOT NULL,
  `no_pemesanan` char(8) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan_item`
--

INSERT INTO `pemesanan_item` (`id`, `no_pemesanan`, `kd_barang`, `harga`, `jumlah`) VALUES
(94, 'PS0003', 'B0001', 800, 1),
(93, 'PS0002', 'B0002', 10000, 55),
(92, 'PS0001', 'B0001', 800, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kurir`
--

CREATE TABLE `tb_kurir` (
  `id_kurir` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `email` varchar(50) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kurir`
--

INSERT INTO `tb_kurir` (`id_kurir`, `nama`, `kelamin`, `email`, `nohp`, `username`, `password`) VALUES
(1, 'Doris Sikas', 'L', 'dorisikas@gmail.com', '08767283212', 'doris', '1bec52f7fccc9524493d8fae117a0bc8');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_keranjang`
--

CREATE TABLE `tmp_keranjang` (
  `id` int NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL DEFAULT '0000-00-00',
  `kd_pelanggan` char(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_keranjang`
--

INSERT INTO `tmp_keranjang` (`id`, `kd_barang`, `harga`, `jumlah`, `tanggal`, `kd_pelanggan`) VALUES
(336, 'B0003', 700, 1, '2025-07-09', 'P0004');

--
-- Triggers `tmp_keranjang`
--
DELIMITER $$
CREATE TRIGGER `kurangbaranguser` AFTER INSERT ON `tmp_keranjang` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok-new.jumlah WHERE kd_barang = new.kd_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `total_bayar`
--

CREATE TABLE `total_bayar` (
  `id_total_bayar` int NOT NULL,
  `kd_pelanggan` varchar(10) NOT NULL,
  `total` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kd_pelanggan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`no_pemesanan`);

--
-- Indexes for table `pemesanan_item`
--
ALTER TABLE `pemesanan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kurir`
--
ALTER TABLE `tb_kurir`
  ADD PRIMARY KEY (`id_kurir`);

--
-- Indexes for table `tmp_keranjang`
--
ALTER TABLE `tmp_keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_bayar`
--
ALTER TABLE `total_bayar`
  ADD PRIMARY KEY (`id_total_bayar`),
  ADD UNIQUE KEY `kd_pelanggan` (`kd_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pemesanan_item`
--
ALTER TABLE `pemesanan_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tb_kurir`
--
ALTER TABLE `tb_kurir`
  MODIFY `id_kurir` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tmp_keranjang`
--
ALTER TABLE `tmp_keranjang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT for table `total_bayar`
--
ALTER TABLE `total_bayar`
  MODIFY `id_total_bayar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
