-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2025 at 06:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_listrikpasca`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPelangganDaya900` ()   BEGIN
    SELECT 
        p.id_pelanggan,
        p.nama_pelanggan,
        p.alamat,
        p.nomor_kwh,
        t.daya
    FROM 
        pelanggan p
    JOIN 
        tarif t ON p.id_tarif = t.id_tarif
    WHERE 
        t.daya = 900;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitungTotalPenggunaan` (`p_id_pelanggan` CHAR(6), `p_bulan` INT, `p_tahun` INT) RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE total_penggunaan INT;

    SELECT 
        SUM(meter_akhir - meter_awal)
    INTO 
        total_penggunaan
    FROM 
        penggunaan
    WHERE 
        id_pelanggan = p_id_pelanggan
        AND bulan = p_bulan
        AND tahun = p_tahun;

    RETURN IFNULL(total_penggunaan, 0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` char(10) NOT NULL,
  `nama_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
('LVL001', 'Admin'),
('LVL002', 'Petugas');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` char(10) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_kwh` varchar(128) NOT NULL,
  `nama_pelanggan` varchar(128) NOT NULL,
  `alamat` text DEFAULT NULL,
  `id_tarif` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `nomor_kwh`, `nama_pelanggan`, `alamat`, `id_tarif`) VALUES
('PLG001', 'Susilo', '$2y$10$C39iEjBY5dZ5U7jq1aO43OmhhiIZo3UgW66eRBxFq9VLuRyOpHl0G', '123456789013', 'susilo', 'jl.special', 'TRF002');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` char(10) NOT NULL,
  `id_tagihan` char(10) NOT NULL,
  `id_pelanggan` char(10) NOT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `bulan_bayar` int(11) DEFAULT NULL,
  `biaya_admin` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` char(10) NOT NULL,
  `id_pelanggan` char(10) NOT NULL,
  `bulan` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `meter_awal` int(11) DEFAULT NULL,
  `meter_akhir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`) VALUES
('PGN001', 'PLG001', 10, 2025, 400, 1000);

--
-- Triggers `penggunaan`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_tagihan` AFTER INSERT ON `penggunaan` FOR EACH ROW BEGIN
    DECLARE jumlah_meter INT;
    DECLARE nomor_urut INT;
    DECLARE id_baru VARCHAR(10);

    -- Hitung jumlah meter
    SET jumlah_meter = NEW.meter_akhir - NEW.meter_awal;

    -- Ambil nomor terakhir dari id_tagihan
    SELECT IFNULL(MAX(CAST(SUBSTRING(id_tagihan, 4) AS UNSIGNED)), 0) + 1
    INTO nomor_urut
    FROM tagihan;

    -- Buat id_tagihan baru dengan format TGH###
    SET id_baru = CONCAT('TGH', LPAD(nomor_urut, 3, '0'));

    -- Insert ke tabel tagihan
    INSERT INTO tagihan (
        id_tagihan,
        id_penggunaan,
        id_pelanggan,
        bulan,
        tahun,
        jumlah_meter,
        status
    ) VALUES (
        id_baru,
        NEW.id_penggunaan,
        NEW.id_pelanggan,
        NEW.bulan,
        NEW.tahun,
        jumlah_meter,
        'UNPAID'
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` char(10) NOT NULL,
  `id_penggunaan` char(10) NOT NULL,
  `id_pelanggan` char(10) NOT NULL,
  `bulan` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `jumlah_meter` int(11) DEFAULT NULL,
  `status` enum('PAID','UNPAID','PROCESS') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `status`) VALUES
('TGH001', 'PGN001', 'PLG001', 10, 2025, 600, 'UNPAID');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` char(10) NOT NULL,
  `daya` varchar(25) NOT NULL,
  `tarifperkwh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `daya`, `tarifperkwh`) VALUES
('TRF002', '1100', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` char(10) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(128) NOT NULL,
  `id_level` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_admin`, `id_level`) VALUES
('USR000', 'Belum Dikonfirmasi', 'Belum Dikonfirmasi', 'Belum Dikonfirmasi', 'LVL001'),
('USR001', 'Admin', '$2y$10$7TohkallkDPXyqq.ufn6d.CJSzu5JOgwz23D0QWiQ.hoQMQckhKpK', 'Tono', 'LVL001'),
('USR002', 'Joko', '$2y$10$beitHifupBHEzbRL6XzBQuKNz.Sw5EKci1zaDBhxnN20eKON7S0P2', 'joko123', 'LVL002');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_penggunaan_listrik`
-- (See below for the actual view)
--
CREATE TABLE `view_penggunaan_listrik` (
`id_penggunaan` char(10)
,`id_pelanggan` char(10)
,`bulan` int(11)
,`tahun` int(11)
,`meter_awal` int(11)
,`meter_akhir` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_total_bayar`
-- (See below for the actual view)
--
CREATE TABLE `view_total_bayar` (
`id_pelanggan` char(10)
,`nama_pelanggan` varchar(128)
,`nomor_kwh` varchar(128)
,`daya` varchar(25)
,`tarifperkwh` int(11)
,`id_penggunaan` char(10)
,`bulan` int(11)
,`tahun` int(11)
,`meter_awal` int(11)
,`meter_akhir` int(11)
,`id_tagihan` char(10)
,`jumlah_meter` bigint(12)
,`total_bayar` bigint(23)
,`status_tagihan` enum('PAID','UNPAID','PROCESS')
);

-- --------------------------------------------------------

--
-- Structure for view `view_penggunaan_listrik`
--
DROP TABLE IF EXISTS `view_penggunaan_listrik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_penggunaan_listrik`  AS SELECT `penggunaan`.`id_penggunaan` AS `id_penggunaan`, `penggunaan`.`id_pelanggan` AS `id_pelanggan`, `penggunaan`.`bulan` AS `bulan`, `penggunaan`.`tahun` AS `tahun`, `penggunaan`.`meter_awal` AS `meter_awal`, `penggunaan`.`meter_akhir` AS `meter_akhir` FROM `penggunaan` ;

-- --------------------------------------------------------

--
-- Structure for view `view_total_bayar`
--
DROP TABLE IF EXISTS `view_total_bayar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_total_bayar`  AS SELECT `pl`.`id_pelanggan` AS `id_pelanggan`, `pl`.`nama_pelanggan` AS `nama_pelanggan`, `pl`.`nomor_kwh` AS `nomor_kwh`, `t`.`daya` AS `daya`, `t`.`tarifperkwh` AS `tarifperkwh`, `pg`.`id_penggunaan` AS `id_penggunaan`, `pg`.`bulan` AS `bulan`, `pg`.`tahun` AS `tahun`, `pg`.`meter_awal` AS `meter_awal`, `pg`.`meter_akhir` AS `meter_akhir`, `tg`.`id_tagihan` AS `id_tagihan`, `pg`.`meter_akhir`- `pg`.`meter_awal` AS `jumlah_meter`, (`pg`.`meter_akhir` - `pg`.`meter_awal`) * `t`.`tarifperkwh` + 2500 AS `total_bayar`, `tg`.`status` AS `status_tagihan` FROM (((`penggunaan` `pg` join `pelanggan` `pl` on(`pg`.`id_pelanggan` = `pl`.`id_pelanggan`)) join `tarif` `t` on(`pl`.`id_tarif` = `t`.`id_tarif`)) join `tagihan` `tg` on(`tg`.`id_penggunaan` = `pg`.`id_penggunaan`)) ORDER BY `pg`.`tahun` ASC, `pg`.`bulan` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `idx_nmrkwh_unik` (`nomor_kwh`),
  ADD KEY `pelanggan_ibfk_1` (`id_tarif`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `pembayaran_ibfk_1` (`id_tagihan`),
  ADD KEY `pembayaran_ibfk_2` (`id_pelanggan`),
  ADD KEY `pembayaran_ibfk_3` (`id_user`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `penggunaan_ibfk_1` (`id_pelanggan`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `tagihan_ibfk_1` (`id_penggunaan`),
  ADD KEY `tagihan_ibfk_2` (`id_pelanggan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `user_ibfk_1` (`id_level`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
