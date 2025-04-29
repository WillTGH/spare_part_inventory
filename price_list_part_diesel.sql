-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 10:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `price_list_part_diesel`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

CREATE TABLE `category_table` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`id`, `category`, `created_on`, `updated_on`) VALUES
(1, 'Nozzle', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Valve', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Repair Kit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Pelengkap', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `logger`
--

CREATE TABLE `logger` (
  `id` int(11) NOT NULL,
  `part_name` text NOT NULL,
  `category` text NOT NULL,
  `logging` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `issued_by` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logger`
--

INSERT INTO `logger` (`id`, `part_name`, `category`, `logging`, `quantity`, `issued_by`, `created_on`, `updated_on`) VALUES
(36, '0445 1109 27', 'Repair Kit', 'In', 2, 'w', '2025-02-07 07:14:37', '2025-02-07 07:14:37'),
(37, 'Washer 1mm', 'Pelengkap', 'Out', 3, 'w', '2025-02-07 07:27:09', '2025-02-07 07:27:09'),
(38, 'DLLA145 P870 (Shumatt)', 'Nozzle', 'Out', 10, 'w', '2025-02-10 03:37:01', '2025-02-10 03:37:01'),
(39, 'DLLA145 P870 (Shumatt)', 'Nozzle', 'Out', 1, 'w', '2025-02-10 03:37:27', '2025-02-10 03:37:27'),
(40, '0445 1109 27', 'Repair Kit', 'In', 2, 'w', '2025-02-10 07:34:31', '2025-02-10 07:34:31'),
(41, '10#', 'Valve', 'In', 3, 'b', '2025-02-10 07:34:47', '2025-02-10 07:34:47'),
(42, 'DLLA145 P870 (Shumatt)', 'Nozzle', 'In', 8, 'b', '2025-02-10 07:34:57', '2025-02-10 07:34:57'),
(43, 'DLLA145 P870 (Xingwei)', 'Nozzle', 'In', 10, 'w', '2025-02-10 07:35:08', '2025-02-10 07:35:08'),
(44, 'DLLA145 P870 (Xingwei)', 'Nozzle', 'Out', 1, 'b', '2025-02-10 07:35:18', '2025-02-10 07:35:18'),
(45, 'DLLA145 P870 (Xingwei)', 'Nozzle', 'In', 10, 'w', '2025-02-10 12:53:40', '2025-02-10 12:53:40'),
(46, 'DLLA145 P870 (Xingwei)', 'Nozzle', 'In', 0, '', '2025-02-10 12:53:59', '2025-02-10 12:53:59'),
(47, '0445 1109 27', 'Repair Kit', 'In', 0, '', '2025-02-10 12:54:20', '2025-02-10 12:54:20'),
(48, '10#', 'Valve', 'Out', 8, 'gm', '2025-02-12 08:02:04', '2025-02-12 08:02:04'),
(49, 'DLLA145 P870 (Shumatt)', 'Nozzle', 'Out', 3, 'gm', '2025-02-12 08:03:15', '2025-02-12 08:03:15'),
(50, 'DLLA145 P870 (Shumatt)', 'Nozzle', 'Out', 10, 'admin', '2025-02-13 11:01:35', '2025-02-13 11:01:35'),
(51, '0445 1109 27', 'Repair Kit', 'Out', 4, 'gm', '2025-02-18 08:23:57', '2025-02-18 08:23:57'),
(52, '10#', 'Valve', 'In', 2, 'gm', '2025-02-18 08:24:50', '2025-02-18 08:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_diesel`
--

CREATE TABLE `spare_part_diesel` (
  `id` int(11) NOT NULL,
  `part_name` text NOT NULL,
  `category` int(11) NOT NULL,
  `erikc` int(11) NOT NULL,
  `perfet` int(11) NOT NULL,
  `rec` text NOT NULL,
  `note` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spare_part_diesel`
--

INSERT INTO `spare_part_diesel` (`id`, `part_name`, `category`, `erikc`, `perfet`, `rec`, `note`, `quantity`, `created_on`, `updated_on`) VALUES
(8, 'DLLA145 P870 (Shumatt)', 1, 13, 7, 'p', 'test', 3, '2025-02-05 07:04:29', '2025-02-05 07:04:29'),
(11, '10#', 2, 0, 8, 'p', '', 13, '2025-02-06 07:10:18', '2025-02-06 07:10:18'),
(12, '0445 1109 27', 3, 5, 8, 'p', '', 14, '2025-02-06 07:10:43', '2025-02-06 07:10:43'),
(13, 'Washer 1mm', 4, 0, 0, 'p', 'washer pencuci', 16, '2025-02-07 06:04:18', '2025-02-07 06:04:18'),
(14, 'DLLA145 P870 (Xingwei)', 1, 13, 7, 'p', 'ring', 8, '2025-02-10 03:35:35', '2025-02-10 03:35:35'),
(15, 'F00ZC01315', 2, 0, 0, '', '', 30, '2025-02-10 08:48:05', '2025-02-10 08:48:05'),
(18, 'G4S060', 1, 0, 0, '', 'test', 12, '2025-02-11 05:15:14', '2025-02-11 05:15:14'),
(19, 'Ring return 16mm', 4, 0, 0, '', 'ring return', 11, '2025-02-11 05:15:14', '2025-02-11 05:15:14'),
(20, '507#', 2, 0, 0, '', '', 3, '2025-02-11 05:15:14', '2025-02-11 05:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `pass` text NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `permission`) VALUES
(4, 'gm', '$2y$10$x.VMc14vnZk3fLD.BJHgPOuUpBO.FlFaF/ASv40Z418bbm5UiFHHq', '-1'),
(5, 'admin', '$2y$10$YyykEjvMEiq8zabxpnDIGe4N0nGQyli7r3OnJ1iEl4t360XHHEu5G', '0'),
(6, 'worker', '$2y$10$uhClw7sbNjZhgL23wjddE.HxnX6vGgV2.BmqWH52jKqaBGogBe8oe', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_table`
--
ALTER TABLE `category_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logger`
--
ALTER TABLE `logger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spare_part_diesel`
--
ALTER TABLE `spare_part_diesel`
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
-- AUTO_INCREMENT for table `category_table`
--
ALTER TABLE `category_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logger`
--
ALTER TABLE `logger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `spare_part_diesel`
--
ALTER TABLE `spare_part_diesel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
