-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 01:13 PM
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
-- Database: `telyuvoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `feeback`
--

CREATE TABLE `feeback` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `feedback` text DEFAULT NULL,
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeback`
--

INSERT INTO `feeback` (`id`, `nama`, `fakultas`, `prodi`, `feedback`, `reply`) VALUES
(1, 'jakah1', 'FIT', 'Rekayasa Perangkat Lunak Aplikasi ', 'tes 1 dari username: jakah1\r\nilmu terapan, rpla, 123456', NULL),
(2, 'jakah1', 'FIT', 'Rekayasa Perangkat Lunak Aplikasi ', 'feedback tes setelah ganti sintaks', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_replies`
--

CREATE TABLE `feedback_replies` (
  `id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username_replier` varchar(50) NOT NULL,
  `role_replier` varchar(50) NOT NULL,
  `reply_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_replies`
--

INSERT INTO `feedback_replies` (`id`, `feedback_id`, `user_id`, `username_replier`, `role_replier`, `reply_text`, `created_at`) VALUES
(1, 2, 1, 'jakah', 'operator', 'tes1', '2025-06-16 10:49:01'),
(2, 2, 1, 'jakah', 'operator', 'tes1', '2025-06-16 10:49:39'),
(3, 1, 1, 'jakah', 'operator', 'tes1', '2025-06-16 10:51:13'),
(4, 2, 1, 'jakah', 'operator', 'tes2', '2025-06-16 10:51:45'),
(5, 2, 1, 'jakah', 'operator', 'tes3', '2025-06-16 10:52:07'),
(6, 1, 1, 'jakah', 'operator', 'tes2', '2025-06-16 11:01:20'),
(7, 2, 1, 'jakah', 'operator', 'tes4', '2025-06-16 11:02:15'),
(8, 1, 1, 'jakah', 'operator', 'tes3', '2025-06-16 11:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `keluhan`
--

CREATE TABLE `keluhan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `fakultas` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluhan`
--

INSERT INTO `keluhan` (`id`, `user_id`, `username`, `fakultas`, `kategori`, `deskripsi`, `status`, `created_at`) VALUES
(1, 2, 'jakah1', 'FIT', 'lingkungan', 'edit sempurna!!!', 'Ditolak', '2025-06-16 08:43:01'),
(8, 2, 'jakah1', 'FIT', 'fasilitas', 'fasilitas', 'Selesai', '2025-06-16 08:49:17'),
(9, 2, 'jakah1', 'FIT', 'lingkungan', 'lingkungan', 'Diproses', '2025-06-16 08:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `fakultas`, `prodi`, `username`, `password`, `role`) VALUES
(1, 'jak', 'FIT', 'Rekayasa Perangkat Lunak Aplikasi ', 'jakah', '$2y$10$2jXcXnCSxW17.9Hweal44ucjAT5gZy6GCRLtGKthcWJXeyhHerd9O', 'operator'),
(2, 'jakah1', 'FIT', 'Rekayasa Perangkat Lunak Aplikasi ', 'jakah1', '$2y$10$VZgApB4KD4uG/hhXHhU19.UkjXZHWdpaz9oVQeKbeZV9Wz02xQqJy', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feeback`
--
ALTER TABLE `feeback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_replies`
--
ALTER TABLE `feedback_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_id` (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feeback`
--
ALTER TABLE `feeback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback_replies`
--
ALTER TABLE `feedback_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `keluhan`
--
ALTER TABLE `keluhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback_replies`
--
ALTER TABLE `feedback_replies`
  ADD CONSTRAINT `fk_reply_feedback` FOREIGN KEY (`feedback_id`) REFERENCES `feeback` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reply_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD CONSTRAINT `fk_keluhan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
