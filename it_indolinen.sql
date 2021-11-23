-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2021 at 07:34 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

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

-- --------------------------------------------------------

--
-- Table structure for table `tb_requests`
--

CREATE TABLE `tb_requests` (
  `id` int(11) NOT NULL,
  `requestors_name` varchar(255) NOT NULL,
  `today_date` date NOT NULL,
  `date_needed` date NOT NULL,
  `requests_choose` varchar(255) NOT NULL,
  `notes_sharing` text NOT NULL,
  `notes_others` text NOT NULL,
  `director` int(11) NOT NULL,
  `it_team` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `done_by` varchar(255) NOT NULL,
  `cancelation` int(2) NOT NULL DEFAULT 0,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_requests`
--

INSERT INTO `tb_requests` (`id`, `requestors_name`, `today_date`, `date_needed`, `requests_choose`, `notes_sharing`, `notes_others`, `director`, `it_team`, `status`, `done_by`, `cancelation`, `id_users`) VALUES
(16, 'Shop Mertanadi', '2021-11-19', '2021-11-22', 'hardware,cs software', '', '1. POS CS Mertanadi tidak bisa edit alamat dan no. HP Customer yang telah disimpan.\r\n2. Perbaikan CCTV Mertanadi, ada 1 Channel yang blank.', 1, 1, 1, 'Agus', 0, 45),
(17, 'Christine', '2021-11-20', '2021-12-15', 'other', '', 'Mohon untuk membuat design baru homepage dan product page website Indolinen pada indolinen.co.id agar bisa segera direview oleh management.', 1, 1, 0, '', 0, 44),
(18, 'Christine', '2021-11-20', '2021-11-27', 'hardware', '', 'Mohon untuk memasukkan kamera Nikon marketing untuk dijual di OLX Indolinen. Dibantu cek spesifikasi dan kondisi kamera serta harga pasarnya.', 1, 1, 0, '', 0, 44),
(19, 'Christine', '2021-11-20', '2021-11-24', 'cs software', '', 'Mohon follow up kendala hilangnya fitur nama salesman di toko pada sistem CS. Apabila memang tidak bisa diisi mohon dibantu info solusinya untuk mengetahui transaksi per toko', 1, 1, 1, 'Oka', 0, 44),
(20, 'Christine', '2021-11-20', '2021-11-25', 'hardware', '', 'HP Marketing OPPO yang hitam memorinya selalu penuh dan sering crash. Mohon dibantu untuk diformat ulang atau pengajuan pergantian dan upgrade handphone untuk kelancaran customer support', 1, 1, 0, '', 0, 44),
(21, 'Christine', '2021-11-20', '2021-11-27', 'hardware', '', 'Mohon untuk pemindahan 1 line telepon ke meja customer support karena saat ini ada 3 customer support namun hanya ada 1 telepon. Telepon di sisi meja admin dan digital marketing bisa dipindah karena saat ini ada 2 line telepon dan mereka hanya perlu 1 telepon karena aktivitas telepon tidak terlalu banyak', 1, 1, 0, '', 0, 44),
(22, 'Christine', '2021-11-20', '2021-11-23', 'file sharing', '192.168.1.3/marketing/staff/inactive', 'request permission untuk membuka data customer staff marketing lama yang sudah resign pada 192.168.1.3/marketing/staff/inactive untuk recall database customer lama sebagai bahan follow up dan CRM', 1, 1, 1, 'Agus', 0, 44),
(23, 'Mila', '2021-11-20', '2021-11-20', 'cs software', '', 'Penambahan Otorisasi Adjustment stock di CS ERP', 1, 1, 1, 'Oka', 0, 43),
(24, 'Nia', '2021-11-20', '2021-11-20', 'email,cs software', '', '1. Penambahan email\r\n2. Penambahan akses fitur Banks pada software accounting\r\n', 1, 1, 0, '', 0, 43),
(25, 'Adi Saputra', '2021-11-22', '2021-11-26', 'other', '', 'Mengganti No. Telepon yang ada di Header Struk belanja Kasir.\r\nMohon dapat di ganti sesuai dengan no. telepon di masing - masing Store Indolinen.\r\n\r\nMertanadi - 0811-3810-4119\r\nMahendradata - 0811-3810-5119\r\nPengosekan - 0811-3810-8119\r\nSanur - 0811-3810-6119\r\n\r\nTerimakasih atas kerjsamanya ', 1, 1, 1, 'Oka', 0, 45),
(26, 'All Shop IndoLinen', '2021-11-22', '2021-11-22', 'cs software', '', 'Sync harga Towel di CS, ada kenaikan harga per Tgl 22 November 2021', 1, 1, 1, 'Oka', 0, 45),
(27, 'Shop Pengosekan', '2021-11-22', '2021-11-25', 'hardware', '', 'Pengecekan dan Perbaikan CCTV toko Pengosekan, 4 Kamera Mati', 1, 1, 0, '', 0, 45),
(28, 'Adi Saputra', '2021-11-22', '2021-11-26', 'other', '', 'Penambahan tulisan pada bagian bawah Struk belanja\r\n\r\nNo Exchange on Sale Item\r\n\r\ntulisan tersebut dapat di sisipkan pada point no. 2 setelah point no. 1, dan untuk point no. 2 yang lama bisa di ganti menjadi point No. 3', 1, 1, 1, 'Oka', 0, 45),
(29, 'All Shop IndoLinen', '2021-11-22', '2021-11-22', 'cs software,other', '', '1. Sistem Stock Request perlu perbaikan/update karena ada item yang di Deskripsi barangnya muncul tulisan &quot;False&quot; sehingga SR tersebut tidak masuk di Sistem Warehouse.\r\n2. Sync Stock di Server CS', 1, 1, 1, 'Oka', 0, 45),
(30, 'desi', '2021-11-22', '2021-11-23', 'cs software', '', 'pada saat buat DO untuk kirim barang secara partial tidak muncul pilihan kirim barang', 1, 0, 0, '', 0, 47),
(31, 'Neva Riosa', '2021-11-23', '2021-11-30', 'hardware', '', 'HandPhone untuk Neva digunakan sebagai HP follow up customer dan sales, spesifikasi HP bisa di diskusikan terlebih dulu sesuai dengan Budget dari Perusahaan.', 1, 0, 0, '', 0, 45),
(32, 'Ima', '2021-11-23', '2021-11-23', 'file sharing', 'Folder sharing (Template tanda terima, kwitansi, SPK, label bantex)', 'Penambahan folder sharing untuk all accounting', 1, 0, 0, '', 0, 43),
(33, 'Mila', '2021-11-23', '2021-11-23', 'cs software', '', 'Penambahan akses &quot;Statistic storage movement details&quot; untuk membantu proses validasi Stok Opname', 1, 1, 1, 'Oka', 0, 43);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `depart` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `depart`, `level`) VALUES
(31, 'it', 'e10adc3949ba59abbe56e057f20f883e', 'it', 'it'),
(41, 'director', '87f4731eea1d2fead88ed88c7d893fc1', 'director', 'director'),
(42, 'hrd', '1428c7d16d5741a24008ee3610f06ac9', 'hrd', 'staff'),
(43, 'accounting', '6bc495d58d11f63b72887ac7f465934a', 'accounting', 'staff'),
(44, 'marketing', '2d4aff21971fa7634e056b777e30c853', 'marketing', 'staff'),
(45, 'shop', '68a63712706582c7e483bf58bb3b59ab', 'shop', 'staff'),
(46, 'warehouse', '8a11f6615742a41c3388843b0a0526b7', 'warehouse', 'staff'),
(47, 'production', '91cad34de612ad8335346af05f6afe39', 'production', 'staff'),
(52, 'coba', '202cb962ac59075b964b07152d234b70', 'marketing', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_requests`
--
ALTER TABLE `tb_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_requests`
--
ALTER TABLE `tb_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_requests`
--
ALTER TABLE `tb_requests`
  ADD CONSTRAINT `tb_requests_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
