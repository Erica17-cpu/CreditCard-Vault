-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 10, 2025 at 05:01 PM
-- Server version: 8.0.39
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `creditcardvault2`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','merchant','support','auditor') NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`, `email`, `created_at`) VALUES
(1, 'admin1', 'e4abae53cc1cebe5fe89ea93882c699a5e71ab0bbf42a83b7d833975b61c4a41', 'admin', 'admin@vault.com', '2025-04-10 12:53:20'),
(2, 'merchant1', '91f4c727b0a6167935601c2b3c439f99df6dd0ebd90f8e3fe50c70d99671286e', 'merchant', 'merchant@vault.com', '2025-04-10 12:53:20'),
(3, 'support1', '3770303cb11062ba38e468b24b80a6b710e600ae5ed0f9ae7b8cdcb8c7acde21', 'support', 'support@vault.com', '2025-04-10 12:53:20'),
(4, 'auditor1', '62900630451f1d842bfac4f5f1e08fa1d17118f8daba473a8cbd06eabc0335fa', 'auditor', 'auditor@vault.com', '2025-04-10 12:53:20'),
(5, 'merchant', '$2y$10$UHAaJ4.KviXafUwJ9FxlbuTRlLclbCWwVPUdjczWIUfpEnCl7YJwy', 'merchant', 'merchant@example.com', '2025-04-10 19:43:52'),
(6, 'admin', '$2y$10$aKwh9YGdzsVZJJGSd.yAQeVy6ANaHdZdTUIxTvxciLWmg4Yb33DS2', 'admin', 'admin@example.com', '2025-04-10 19:43:52'),
(7, 'support', '$2y$10$FqhkeJeN7fNz.TXrxiiNSup0ztznsgBHUaWfF2CL89RjFkd00FHoK', 'support', 'support@example.com', '2025-04-10 19:43:52'),
(8, 'auditor', '$2y$10$oWU5uLcafPSvZOEm9Wm4yO2TR4eml50R5N59Lk2Het4ErDO6QYNQe', 'auditor', 'auditor@example.com', '2025-04-10 19:43:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
