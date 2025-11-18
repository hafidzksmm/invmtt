-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251026.88b7dfd0f0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2025 at 06:32 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mtt`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset_jual`
--

CREATE TABLE `asset_jual` (
  `id` int NOT NULL,
  `pn` varchar(100) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dimensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` text NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `sn` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `asset_jual`
--

INSERT INTO `asset_jual` (`id`, `pn`, `nama_barang`, `jenis`, `merk`, `tipe`, `ukuran`, `dimensi`, `qty`, `lokasi`, `sn`, `created_at`, `updated_at`) VALUES
(265, '', 'Kabel listrik', 'Serabut', NULL, NULL, '24,6M', '3 x 6mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(266, '', 'Kabel listrik', 'Serabut', NULL, NULL, '5M', '3 x 6mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(267, '', 'Kabel listrik', 'Serabut', NULL, NULL, '2M (4Pcs)', '3 x 6mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(268, '', 'Kabel listrik', 'Tunggal', NULL, NULL, '2M ', '3 x 2,5 mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(269, '', 'Kabel listrik', 'Tunggal', NULL, NULL, '2,5M', '3 x 2,5 mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(270, '', 'Kabel listrik', 'Tunggal', NULL, NULL, '3M', '3 x 2,5 mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(271, '', 'Kabel listrik', 'Tunggal', NULL, NULL, '5M', '3 x 6 mm', '1', 'power', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(272, '', 'kabel patchcord', 'Kabel utp', NULL, NULL, '1M', NULL, '82', 'management', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(273, '', 'kabel patchcord', 'Kabel utp', NULL, NULL, '1,5M', NULL, '2', 'management', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(274, '', 'kabel patchcord', 'Kabel utp', NULL, NULL, '2,5M', NULL, '1', 'management', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(275, '', 'kabel patchcord', 'Kabel utp', NULL, NULL, '3M', NULL, '10', 'management', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(276, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '1M', NULL, '45', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(277, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '1,5M', NULL, '34', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(278, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '3M', NULL, '187', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(279, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '5M', NULL, '4', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(280, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '10M', NULL, '16', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(281, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '30M', NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(282, '', 'kabel patchcord', 'lc to lc', NULL, NULL, '50M', NULL, '2', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(283, '', 'Modul\n(Transceiver)', 'SFP', 'Dell', '1G', NULL, NULL, '6', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(284, '', 'Modul\n(Transceiver)', 'SFP', 'FINISAR', NULL, NULL, NULL, '2', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(285, '', 'Modul\n(Transceiver)', 'SFP+', 'Dell', '10G', NULL, NULL, '4', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(286, '', 'Modul\n(Transceiver)', 'SFP+', 'D-Link', NULL, NULL, NULL, '42', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(287, '', 'Modul\n(Transceiver)', 'SFP+', 'Edge-Core', NULL, NULL, NULL, '6', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(288, '', 'Modul\n(Transceiver)', 'SFP+', 'Huawei', NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(289, '', 'Modul\n(Transceiver)', 'SFP+', 'Lenovo', NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(290, '', 'Modul\n(Transceiver)', 'SFP+', 'Dell', '25G', NULL, NULL, '9', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(291, '', 'Modul\n(Transceiver)', 'Konverter \nSFP to RJ45', 'Copper', '1G', NULL, NULL, '2', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(292, '', 'Modul\n(Transceiver)', 'Konverter \nSFP to RJ46', 'Nokia', NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(293, '', 'Modul\n(Transceiver)', 'Konverter \nSFP to RJ47', 'Avago', NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(294, '', 'Modul\n(Transceiver)', 'Konverter \nSFP to RJ48', 'Linktel', NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(295, '', 'Modul\n(Transceiver)', 'Konverter \nSFP to RJ49', 'NETLINE', '10 G', NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(296, '', 'Modul\n(Transceiver)', 'QSFP', 'Dell', '100G', NULL, NULL, '10', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(297, '', 'Modul\n(Transceiver)', 'MPO', 'Dell', '100G', NULL, NULL, '4', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(298, '', 'Konverter\nVGA', 'Mini DP to VGA', NULL, NULL, NULL, NULL, '48', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(299, '', 'Konverter\nVGA', 'Mini DP to VGA', NULL, NULL, NULL, NULL, '33', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(300, '', 'RAM', '16GB', NULL, NULL, NULL, NULL, '316', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(301, '', 'RAM', '4GB', NULL, NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(302, '', 'Kabel\nKVM', 'Digital', NULL, NULL, NULL, NULL, '5', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(303, '', 'Kabel\nKVM', 'IP', NULL, NULL, NULL, NULL, '5', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(304, '', 'Kabel\nKVM', 'Analog', NULL, NULL, NULL, NULL, '123', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(305, '', 'Kabel\nKVM', 'PS/2', NULL, NULL, NULL, NULL, '5', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(306, '', 'Kabel\nKVM', 'DAC', NULL, NULL, NULL, NULL, '1', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38'),
(307, '', 'Hard disk', 'SAS 2.5 inc', NULL, NULL, NULL, NULL, '2', 'data', '', '2025-10-22 22:45:38', '2025-10-22 22:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int NOT NULL,
  `pn` varchar(100) NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dimensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sn` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `pn`, `nama_barang`, `merk`, `deskripsi`, `dimensi`, `qty`, `satuan`, `lokasi`, `sn`, `created_at`, `updated_at`) VALUES
(1470, '', 'Mobil', 'Mitsubishi Xpander Ultimate', 'Transmisi Matic 1500cc, 7 seats', '459x175x175cm', 1, 'unit', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1471, '', 'Mobil', 'Mitsubisi Xpander Exceed', 'Transmisi Matic 1500cc, 7 seats', '459x175x175cm', 1, 'unit', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1472, '', 'Motor', 'Honda Beat deluxe keyless', '110cc', '187x67x108cm', 1, 'unit', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1473, '', 'Layar Interaktif', 'Acer Model Acer ALTOS IWB86', 'OS: Android 13 ram 4gb storage 32gb, Windows 11 homesl, RAM 8GB, Storage 256GB, Processor Intel i7-1185G7', '196x25x117cm', 1, 'unit ', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1474, '', 'Bracket', 'Acer', 'Bracket besi Acer', '107x66x150cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1475, '', 'Laptop', 'Macbook', 'Processor Apple M3, RAM 16GB, SSD 512GB', '31 x 21 x 2 cm', 2, 'unit', 'Ruang Staff (Andy, Ridhon)', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1476, '', ' Laptop', 'Lenovo model V14G3iAP', ' Intel® Core™ i3-1215U, Ram 8GB DDR4, 256GB SSD', '32 x 21 x 20cm', 3, 'unit', 'Ruang Teknis (Bayu, Andika, Yosep)', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1477, '', ' Laptop', 'Acer Aspire One 722', 'CPU :AMD Dual-Core c60. 2GB/ 320GB', '29x20x4cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1478, '', ' Laptop', 'Lenovo model V14G3iAP', ' Intel® Core™ i3-1215U, Ram 8GB DDR4, 256GB SSD', '32 x 21 x 20cm', 2, 'unit', 'Ruang Admin (Rani dan Aida)', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1479, '', ' Laptop', 'Lenovo model V14G3iAP', ' Intel® Core™ i3-1215U, Ram 8GB DDR4, 256GB SSD', '32 x 21 x 20cm', 1, 'unit', 'Ruang Resepsionis (Angky)', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1480, '', 'Mini PC', 'Intel NUC7i7BNH', 'Windows 10, RAM 16GB, Storage 512GB, Processor Intel i7-7567U', '10x10x5cm', 1, 'unit ', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1481, '', ' Monitor', 'Weyon WY-A24', ' HD 1680x1050, HDMI, VGA, RF, AV, USB, Remote', '74x8x44cm', 1, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1482, '', ' Monitor', 'Xiaomi', 'Dolby Audio, HDMI, VGA 50W', '72x42cm', 2, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1483, '', ' Monitor', '  Tagvision', 'Respone Time 5ms, Wide, 1920x1080 FULL HD', '56x5x34cm', 2, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1484, '', 'Monitor ', '  LG LED 19EN33', '18.5inch, 1366*768, Aspect Ratio 16:9', '44x3x27cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1485, '', 'AC', '  Daikin FTK025UVM4', '1 PK, 9000 BTU/h, 810 Watt', '77x22x23cm', 1, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1486, '', 'AC', '  Gree', 'Standard 1 PK', '74x22x23cm', 1, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1487, '', 'AC', '  Daikin FTKQ50UVMA', '2 PK, 17.100 BTU/h, 1800W', '77x22x23cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1488, '', 'AC', '  Daikin FTKQ25UVM4', '1 PK, 9000 BTU/h, 810 Watt', '77x22x23cm', 1, 'unit', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1489, '', 'AC', '  Daikin FTKQ15UVM4', '1/2 PK, 5.100 BTU/h, 420W', '28 x 77 x 22cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1490, '', ' Firewall', 'Shopos XGS 136', 'RAM & Storage: 8 GB RAM, 64 GB SSD, Ports: 10x GbE, 2x 2.5GbE (PoE), 2x SFP (fiber), VPN IPsec: 6.3 Gbps, 30-60W', '32x22x5cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1491, '', 'Router WiFi', '  Tenda AC7', 'WiFi dual-band AC1200 (WiFi 5), 1xWAN, 3xLAN', '22x15x4cm', 1, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1492, '', 'Router WiFi', '  Dlink dir 612  N300', '5 MODE, kecepatan hingga 300Mbps ', '18x15x 3cm', 2, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1493, '', 'Router WiFi', '  Totolink AC 1200 Wireless', 'Dual-band, Kecepatan 300Mbps', ' 11 x 6 x 7 cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1494, '', 'Router WiFi', '  Dlink DIR-615', '1 WAN, 4 LAN', '18x13x3cm', 1, 'unit', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1495, '', 'Router WiFi', '  Dlink DIR-822 AC 1200', 'High speeds of up to 867Mbps (5GHz) and 300Mbps (2.4GHz)', '44x25x15cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1496, '', 'Router', 'Mikrotik HUBLite RB941-2nD', 'RAM 32MB, Flash 16MB, 4 × RJ-45 10/100 Mbps, 5V, 3W', '12x9x3cm', 2, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1497, '', 'Router', 'Mikrotik Model RB4011', 'RAM 1GB, Flash MB NAND, 10 × Gigabit RJ-45 ports, 1 port SFP+ (10 Gbps)', '23x12x3cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1498, '', ' Printer', 'EPSON L3250', 'Print, Scan & Copy, 5760 x 1440 dpi, 12/0.7 Watt', '37x34x18cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1499, '', ' NVR', 'NVR1108HS-W-S2', '8 Record Channel, Storage 8TB', '26x5x23cm', 1, 'unit ', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1500, '', 'CCTV', 'V380 Y33', '2MP, Full HD, Night Vision, Motion Detect', '8.6 x 8.5 x 11 cm', 1, 'unit', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1501, '', 'CCTV', 'V380 Y33', '2MP, Resolusi 1080p,Night Vision, Motion Detect', '8.6 x 8.5 x 11 cm', 2, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1502, '', 'CCTV', 'V380 Y33', '2MP, Full HD, Night Vision, Motion Detect', '8.6 x 8.5 x 11 cm', 3, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1503, '', 'CCTV', 'Imou', 'Night Vision, Motion Detect', '8.6 x 8.5 x 11 cm', 2, 'unit', 'Balkon Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1504, '', 'Modem Starlink', 'VTR-211', 'Wi-Fi Technology 802.11ac Dual Band, Teknologi Wi-Fi Standar IEEE 802.11a/b/g/n/ac, Wi-Fi 5, WPA2', '19x6x26cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1505, '', 'Dish Starlink', 'Strarlink', 'IP54, 50-75 W, Bidang Pandang 110°, Orientasi Mandiri dengan Motor', '31x51x45cm', 1, 'unit', 'Balkon Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1506, '', 'Paper Shredder', 'Deli ET101SC', 'Kapasitas Tabung : 10 Liter,  Kapasitas Penghancuran 6 lembar A4 70 gsm', '31x11x37cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1507, '', 'Smartlock', 'Taffhome model XR24-Black', 'Unlock with PIN, Card, and Fingerprint', '17x7x37cm', 1, 'unit', 'Gudang', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1508, '', 'Power Supply', '60-12', 'model out=12v ihp =185-240v AC 50hz', '8x11x4cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1509, '', 'Power Supply', 'PSU S120 12', 'AC Input 110/220V, DC Output 12V 10A', '8x11x4cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1510, '', 'Bor Battery', '  Gtools GT04', '3 mode drill (sekrup, besi , beton / impact palu), dinamo racing brushless high rpm 2200', '21x17x6cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1511, '', 'Access Door', 'Hikvision DS-K1T320MFK', '2.4-inch LCD Display Fingerprint Access Control Terminal, Built-in Mifare card reading module, Communication: TCP/IP，EHome; 1000 users, 1000 fingerprints, 1000 card and Max. 100,000 event records;', '13x14x5cm', 1, 'unit', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1512, '', 'Dispenser', 'Toshiba RWF-W1917TN(K)', '3 Tempereatur Setting, Child Safety Lock, 2 Liter', '31x36x100cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1513, '', 'Dispenser', 'Arasi model ABD04C-Black', 'Hot water and Cool Water', '40x36x109cm', 1, 'pcs', 'Gudang', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1514, '', 'Kipas', 'Sanex SF-1208B', 'Besi alumunium, 45W, 220V', '44x44x140cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1515, '', 'Kipas', 'Cosmos 16XDC', '3 mode kecepatan', '44x44x100cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1516, '', 'Sofa', '-', 'Warna abu-abu, bahan kayu, busa dan kain', '183x37x85cm', 1, 'set', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1517, '', 'Extend sofa', '-', 'Warna abu-abu, bahan kayu, busa dan kain', '70x95x43cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1518, '', 'Kursi', 'Informa', 'Kuris putar 360 derajat, Roda anti selip', '60x60x95cm', 4, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1519, '', 'Kursi Kerja', 'Informa', 'Kuris putar 360 derajat, Roda anti selip', '60x50x94cm', 2, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1520, '', 'Kursi kerja', 'Informa', 'Kuris putar 360 derajat, Roda anti selip', '61x50x97cm', 3, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1521, '', 'Kursi Tamu', 'Informa', 'bahan besi, busa dan kayu, dilenkai dengan senderan', '53x53x76cm', 2, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1522, '', 'Kursi Meeting', 'Informa', 'Kursi lipat, bahan besi', '45x95cm', 6, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1523, '', 'Kursi Resepsionis', 'Informa', 'bahan besi dan busa', '36x36x47cm', 2, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1524, '', 'Meja', '-', 'Bahan Kayu dengam 4 Laci  ', '160x80x75cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1525, '', 'Meja', '-', 'Bahan Kayu dengam 4 Laci  ', '160x85x76cm', 2, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1526, '', 'Meja', '-', 'Bahan kaca, kayu dan kain', '70x40x41cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1527, '', 'Meja kerja', 'Informa', 'Bahan HPL', '120x60x76cm', 2, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1528, '', 'Meja Kerja', 'Informa', 'Bahan HPL', ' 120x60x76cm', 2, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1529, '', 'Meja Kerja', 'Informa', 'Bahan HPL', ' 140x74x76cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1530, '', 'Meja Tamu', 'Informa', 'Kaca dengan 3 kaki', ' 42x42x53cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1531, '', 'Meja Meeting ', 'Informa', 'Bahan kayu dan besi, bisa di bongkar  ', '220x120x75cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1532, '', 'Lemari Plastik', 'TABITHA', '8 pintu, bisa di rakit', '50x42x144cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1533, '', 'Lemari Plastik', 'TABITHA', '6 pintu, bisa di rakit', '50x52x112cm', 2, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1534, '', 'Lemari Besi', 'Informa', '5 Pintu, bahan besi dan kaca', '120x40x185cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1535, '', 'Lemari Besi', 'Informa', 'Dapat di bongkar, tatakan bahan hpl, 4 tingkat', '80x40x180cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1536, '', 'Lemari Plastik', 'TABITHA', '8 pintu, bisa di rakit', '50x43x144cm', 2, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1537, '', 'Lemari Besi', 'Informa', 'Bahan besi dan kaca, 4 pintu', ' 80x40x180cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1538, '', 'Lemari Besi Kecil', 'Informa', 'Bahan besi, 2 Pintu', ' 91x45x75cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1539, '', 'Rak Besi', '-', ' Bisa di rakit, bahan besi dan stainless, dengan 4 roda', '71x34x125cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1540, '', 'Rak Besi', '-', 'Bahan full besi, bisa di bongkar, 5 tingkatan', '100x50x201cm', 2, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1541, '', 'Rak Besi', '-', 'Dapat di bongkar, tatakan bahan hpl, 4 tingkat', '119x40x197cm', 2, 'pcs', 'Gudang', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1542, '', 'Rak Kecil', '-', 'Rangka besi dan tatakan bahan HPL', '50x25x97cm', 1, 'pcs', 'Gudang', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1543, '', 'Rak piring', '-', 'bahan stainless', '39x24x31cm', 1, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1544, '', 'Rak Sepatu Kecil', 'Calista', 'Bahan Plastik', '56x26x41cm', 1, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1545, '', 'Rak Sepatu besar', '-', 'Bahan Plastik', '63x27x65cm', 2, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1546, '', 'Rak Barang', '-', 'Bahan besi dan plastik', '35x20x87cm', 1, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1547, '', 'Rak Sepatu besar', '-', 'bahan besi dan kan, bisa di rakit', '56x27x123cm', 1, 'pcs', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1548, '', 'Rak sepatu kecil', 'Calista', 'bahan plastik bisa di rakit', '58x22x47cm', 1, 'pcs', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1549, '', 'Tas Toolkit Kecil', 'Taffware', 'Material kain', '36x21x21cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1550, '', 'Tas Toolkit Besar', 'Taffware', 'Material kan, dengan 8 kantong di bagian samping', '52x27x30cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1551, '', 'White Board Besar', '-', 'Papan tulis putih Dinding', '245x123cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1552, '', 'White Board Kecil', '-', 'Papan tulis putih Dinding', '61x41cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1553, '', 'White Board', '-', 'Papan tulis putih Dinding', '245x123cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1554, '', 'Box S', 'AKAKO Karbon Box', 'Bahan Plastik, dengan kuncian di tutupnya', '38x24x22cm', 4, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1555, '', 'Box M', 'AKAKO Karbon Box', 'Bahan Plastik, dengan kuncian di tutupnya', '44x30x27cm', 3, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1556, '', 'Box L', 'AKAKO Karbon Box', 'Bahan Plastik, dengan kuncian di tutupnya', '60x39x36cm', 4, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1557, '', 'Box XL', 'AKAKO Karbon Box', 'Bahan Plastik, dengan kuncian di tutupnya', '65x50x45cm', 3, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1558, '', 'Tempat Sampah', 'Komet Star', 'Bahan Plastik', '27x27x53cm', 1, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1559, '', 'Tempat Sampah', 'Yutaka', 'Bahan Plastik', '23x31x65cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1560, '', 'Tempat Sampah', 'Yutaka', 'Bahan Plastik', '33x37x69cm', 1, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1561, '', 'Tempat Sampah', 'Yutaka', 'Bahan Plastik, diameter 100cm', '54x42x85cm', 1, 'pcs', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1562, '', 'Box Tissue', '-', 'Bahan plastik dengan design minimalis', '22x13x10cm', 2, 'pcs', 'Ruang Staff', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1563, '', 'Box Tissue', '-', 'Bahan plastik dengan design minimalis', '22x13x10cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1564, '', 'Troli', '-', 'Bahan besi, Roda 4', '90x45x25cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1565, '', 'Tangga portable', 'MLHY', 'Dapat di atur ketinggiannya, portabel', '69x18x89cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1566, '', 'Vacum Cleaner', 'Model YCQ-2022S', '1800W, 220V 50Hz, Stainless steel  18L', '33x33x42cm', 1, 'unit', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1567, '', 'Pengharum Ruangan', '  Stella', 'Stella Matic, timer otomatis', '11x9x21cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1568, '', 'Pengharum Ruangan', '  Stella', 'Stella Matic, timer otomatis', '11x9x21cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1569, '', 'Bell', 'OEM RB-C847 ', '3 mode pilihan suara, bahan plastik, 4 tingkatan volume suara', '6x4x3cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1570, '', 'Obeng kit', 'Jakemy Tools', 'Lengkap dengan macam- macam jenis mata obeng', '23x6x17cm', 1, 'set', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1571, '', 'Ordner', 'Benex', 'foldable, system pengunci H-lock', '7x28x35cm', 8, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1572, '', 'Ordner', 'Bantex', 'foldable, system pengunci H-lock', '10x27x35cm', 3, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1573, '', 'Pembolong Kertas', '  Joyko PHJ-30XL', ' Pembolong Kertas Kecil No 30 XL - 2 Lubang', '10.2x4.6x6cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1574, '', 'Pembolong Kertas', '  Kenko', 'Material baja, 2 lubang, 7mm', '11x16x8cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1575, '', 'Gunting', 'Joyko SC 838 ', 'Stainless Steel', '16x6cm', 1, 'pcs', 'Ruang Teknis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1576, '', 'Gunting', 'Joyko', 'Stainless Steel', '16x6cm', 2, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1577, '', 'Streppless', 'Kenko', 'Bahan Stainless Steel', '44 x 9.5 x 26 cm', 2, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1578, '', 'Cutter', 'ReType L-500', 'High Quality auto lock', '16x4cm', 2, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1579, '', 'Ruller', 'Butterfly ', 'Penggaris 30cm material Acrylic', '30cm', 2, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1580, '', 'Stempel', 'INK Stamp', 'Stempel logo Media Touch Technology K17', '4,1x7,6cm', 1, 'pcs', 'Ruang Admin', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1581, '', 'Dekorasi MTT Besar', '-', 'Dilengkapi dengan lampu hiasan', '56x27x123cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1582, '', 'Dekorasi MTT Kecil', '-', 'Dilengkapi dengan lampu hiasan', '58x22x47cm', 1, 'pcs', 'Ruang Resepsionis', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1583, '', 'Sapu', '2 macan', 'Sapu ijuk', 'panjang 110cm', 1, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1584, '', 'Sapu', '2 macan', 'Sapu ijuk', 'panjang 118cm', 3, 'pcs', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1585, '', 'Pengki', 'Apolo', 'bahan plastik', 'panjang 100cm', 1, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1586, '', 'Pel', '-', 'bahan serat kain', 'panjang 150cm', 3, 'pcs', 'Teras Depan', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1587, '', 'Galon', 'Galon Cleo', '15L', '40x10x50cm', 5, 'pcs', 'Dapur', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27'),
(1588, '', 'Jemuran', '-', 'bahan stainless, bisa di bongkar pasang', '177x12x120cm', 1, 'pcs', 'Balkon Belakang', '', '2025-10-23 21:25:27', '2025-10-23 21:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `inventaryprojek`
--

CREATE TABLE `inventaryprojek` (
  `id` int NOT NULL,
  `pn` varchar(100) NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sn` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventaryprojek`
--

INSERT INTO `inventaryprojek` (`id`, `pn`, `nama_barang`, `jenis`, `tipe`, `merk`, `ukuran`, `jumlah`, `lokasi`, `sn`, `created_at`, `updated_at`) VALUES
(187, '', 'Kabel Listrik', 'Serabut', '3 x 6mm', NULL, '24,6M', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(188, '', 'Kabel Listrik', 'Serabut', '3 x 6mm', NULL, '5M', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(189, '', 'Kabel Listrik', 'Serabut', '3 x 6mm', NULL, '2M (4Pcs)', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(190, '', 'Kabel Listrik', 'Tunggal', '3 x 2,5mm', NULL, '2M ', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(191, '', 'Kabel Listrik', 'Tunggal', '3 x 2,5mm', NULL, '2,5M', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(192, '', 'Kabel Listrik', 'Tunggal', '3 x 2,5mm', NULL, '3M', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(193, '', 'Kabel Listrik', 'Tunggal', '3 x 6mm', NULL, '5M', 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(194, '', 'Kabel Power', 'C13', NULL, NULL, NULL, 78, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(195, '', 'Kabel Power', 'C13 to C14', NULL, NULL, NULL, 33, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(196, '', 'Kabel Power', 'C19 to C20', NULL, NULL, NULL, 9, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(197, '', 'Industrial\nSocket', 'Male', NULL, NULL, NULL, 3, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(198, '', 'Industrial\nSocket', 'Female', NULL, NULL, NULL, 0, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(199, '', 'Industrial\nSocket', '1 Set', NULL, NULL, NULL, 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(200, '', 'Konektor', 'C14', NULL, NULL, NULL, 23, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(201, '', 'Konektor', 'C20', NULL, NULL, NULL, 1, 'POWER', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(202, '', 'Kabel\nUTP', 'Pabrikan', 'Abu-Abu', NULL, '1M', 84, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(203, '', 'Kabel\nUTP', 'Pabrikan', 'Biru', NULL, '3M', 9, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(204, '', 'Kabel\nUTP', 'Crafting', 'Potongan\nMentah', NULL, '1M', 3, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(205, '', 'Kabel\nUTP', 'Crafting', 'Potongan\nMentah', NULL, '2M', 2, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(206, '', 'Kabel\nUTP', 'Crafting', 'Potongan\nMentah', NULL, '3M', 7, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(207, '', 'Kabel\nUTP', 'Crafting', 'Potongan\nMentah', NULL, '5M', 3, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(208, '', 'Kabel\nUTP', 'Crafting', 'Potongan\nMentah', NULL, '6,5M', 1, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(209, '', 'Kabel\nUTP', 'Crafting', 'Potongan\nMentah', NULL, '7,5M', 1, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(210, '', 'Kabel\nUTP', 'Crafting', 'Non \nPlugboots', NULL, '1M', 0, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(211, '', 'Kabel\nUTP', 'Crafting', 'Non \nPlugboots', NULL, '2M', 12, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(212, '', 'Kabel\nUTP', 'Crafting', 'Non \nPlugboots', NULL, '3M', 1, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(213, '', 'Kabel\nUTP', 'Crafting', 'Non \nPlugboots', NULL, '4M', 4, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(214, '', 'Kabel\nUTP', 'Crafting', 'Non \nPlugboots', NULL, '8M', 0, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(215, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '1M', 0, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(216, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '2M', 12, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(217, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '3M', 0, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(218, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '4M', 20, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(219, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '5M', 13, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(220, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '5,5M', 1, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(221, '', 'Kabel\nUTP', 'Crafting', 'Plugboots\n+\nKonektor', NULL, '7,5M', 1, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(222, '', 'Konektor', 'RJ45', NULL, NULL, NULL, 1450, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(223, '', 'Kabel UTP', 'Dus', NULL, NULL, NULL, 2, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(224, '', 'Plugboots', NULL, 'Hitam', NULL, NULL, 300, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(225, '', 'Plugboots', NULL, 'Abu-Abu', NULL, NULL, 200, 'MANAGEMENT', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(226, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '1M', 43, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(227, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '1,5M', 35, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(228, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '3M', 199, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(229, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '5M', 4, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(230, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '10M', 14, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(231, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '30M', 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(232, '', 'Kabel\nPatchcord', 'LC to LC', NULL, NULL, '50M', 2, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(233, '', 'Modul\n(Transceiver)', 'SFP+', '1G', 'Dell', NULL, 6, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(234, '', 'Modul\n(Transceiver)', 'SFP+', '1G', 'FINISAR', NULL, 2, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(235, '', 'Modul\n(Transceiver)', 'SFP+', '10G', 'Dell', NULL, 4, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(236, '', 'Modul\n(Transceiver)', 'SFP+', '10G', 'D-Link', NULL, 17, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(237, '', 'Modul\n(Transceiver)', 'SFP+', '10G', 'Edge-Core', NULL, 3, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(238, '', 'Modul\n(Transceiver)', 'SFP+', '10G', 'Huawei', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(239, '', 'Modul\n(Transceiver)', 'SFP+', '10G', 'Lenovo', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(240, '', 'Modul\n(Transceiver)', 'SFP+', '25G', 'Dell', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(241, '', 'Modul\n(Transceiver)', 'RJ45', '1G', 'Copper', NULL, 4, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(242, '', 'Modul\n(Transceiver)', 'RJ45', '1G', 'Nokia', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(243, '', 'Modul\n(Transceiver)', 'RJ45', '1G', 'Avago', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(244, '', 'Modul\n(Transceiver)', 'RJ45', '1G', 'Linktel', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(245, '', 'Modul\n(Transceiver)', 'RJ45', '10 G', 'NETLINE', NULL, 1, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(246, '', 'Modul\n(Transceiver)', 'QSFP', '100G', 'Dell', NULL, 10, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(247, '', 'Modul\n(Transceiver)', 'MPO', '100G', 'Dell', NULL, 4, 'DATA', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(248, '', 'Konverter\nVGA', 'Mini DP to VGA', 'Hitam', NULL, NULL, 48, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(249, '', 'Konverter\nVGA', NULL, 'Putih', NULL, NULL, 33, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(250, '', 'RAM', '16GB', NULL, NULL, NULL, 310, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(251, '', 'RAM', '4GB', NULL, NULL, NULL, 1, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(252, '', 'Kabel\nKVM', 'Digital', NULL, NULL, NULL, 4, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(253, '', 'Kabel\nKVM', 'IP', NULL, NULL, NULL, 5, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(254, '', 'Kabel\nKVM', 'Analog', NULL, NULL, NULL, 107, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(255, '', 'Kabel\nKVM', 'PS/2', NULL, NULL, NULL, 5, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(256, '', 'Kabel\nKVM', 'DAC', NULL, NULL, NULL, 1, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(257, '', 'Kabel Ties', NULL, 'Kecil', NULL, '3,6 x 150', 8, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(258, '', 'Kabel Ties', NULL, 'Sedang', NULL, '7,6 x 300', 4, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(259, '', 'Kabel Ties', NULL, 'Besar', NULL, '7,6 x 500', 11, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17'),
(260, '', 'Hard disk', NULL, 'HGST', NULL, '1,2 TB', 2, 'DLL', '', '2025-10-23 21:35:17', '2025-10-23 21:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$10$PAZv6uMkzIUl/WBwofTNTuTWou4k/uga1LENHGZAhXcaKrhPcYw56', NULL, '2025-10-23 19:10:40', '2025-10-23 19:10:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset_jual`
--
ALTER TABLE `asset_jual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventaryprojek`
--
ALTER TABLE `inventaryprojek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_jual`
--
ALTER TABLE `asset_jual`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1590;

--
-- AUTO_INCREMENT for table `inventaryprojek`
--
ALTER TABLE `inventaryprojek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
