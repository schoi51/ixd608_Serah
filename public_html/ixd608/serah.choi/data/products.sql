-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2026 at 11:13 AM
-- Server version: 10.11.19-MariaDB-cll-lve
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keserahserah95`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(32) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modify` datetime NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(128) NOT NULL,
  `images` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `date_create`, `date_modify`, `description`, `thumbnail`, `images`) VALUES
(3, 'Modern Wooden Chair', 140.00, 'chair', '2026-10-31 11:02:12', '2026-10-31 11:02:12', 'A basic dining chair with a warm wooden emotional feel.', 'chair1_thumb.jpg', 'chair1_1.jpg, chair1_2.jpg'),
(4, 'Minimal Lounge Chair', 280.00, 'chair', '2026-10-31 11:04:36', '2026-10-31 11:04:36', 'A cozy and comfortable lounge chair great for the living room.', 'chair2_thumb.jpg', 'chair2_1.jpg, chair2_2.jpg'),
(5, 'Velvet Dining Chair', 165.00, 'chair', '2026-10-31 11:05:16', '2026-10-31 11:05:16', 'Creates a luxurious atmosphere with soft velvet material.', 'chair3_thumb.jpg', 'chair3_1.jpg'),
(6, 'Steel Frame Bar Stool', 95.00, 'stool', '2026-10-31 11:05:52', '2026-10-31 11:05:52', 'A modern stool suitable for kitchen islands or home bars.', 'stool1_thumb.jpg', 'stool1_1.jpg'),
(7, 'Fabric Ottoman', 80.00, 'accessory', '2026-10-31 11:06:25', '2026-10-31 11:06:25', 'A versatile multi-purpose ottoman used as a footrest or auxiliary seat.', 'ottoman1_thumb.jpg', 'ottoman1_1.jpg'),
(8, 'Walnut Side Table', 120.00, 'table', '2026-10-31 11:06:57', '2026-10-31 11:06:57', 'A compact side table great to place next to a bed or sofa.', 'table1_thumb.jpg', 'table1_1.jpg'),
(9, 'Curved Coffee Table', 220.00, 'table', '2026-10-31 11:07:34', '2026-10-31 11:07:34', 'A center living room table highlighted by smooth curved lines.', 'table2_thumb.jpg', 'table2_1.jpg,table2_2.jpg'),
(10, 'Minimal Desk', 250.00, 'desk', '2026-10-31 11:08:18', '2026-10-31 11:08:18', 'A clean, clutter-free desk optimized for working or studying.', 'desk1_thumb.jpg', 'desk1_1.jpg'),
(11, 'Linen Armchair', 310.00, 'chair', '2026-10-31 11:08:49', '2026-10-31 11:08:49', 'A cozy armchair crafted with breathable linen fabric.', 'chair4_thumb.jpg', 'chair4_1.jpg'),
(12, 'Nordic Console Table', 175.00, 'table', '2026-10-31 11:09:19', '2026-10-31 11:09:19', 'A slim console table that adds an interior design touch to entryways or hallways.', 'table3_thumb.jpg', 'table3_1.jpg'),
(13, 'Rustic Wooden Bench', 150.00, 'bench', '2026-10-31 11:09:47', '2026-10-31 11:09:47', 'A wooden bench versatile enough to use as dining seating or multi-purpose use.', 'bench1_thumb.jpg', 'bench1_1.jpg'),
(14, 'Compact Bookshelf', 210.00, 'storage', '2026-10-31 11:10:17', '2026-10-31 11:10:17', 'A shelving unit offering great storage capacity without taking up too much space.', 'shelf1_thumb.jpg', 'shelf1_1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
