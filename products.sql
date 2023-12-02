-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 10:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ewd`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `name` varchar(100) NOT NULL,
  `quantity` int(1) NOT NULL,
  `price` int(1) NOT NULL,
  `fruit` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`name`, `quantity`, `price`, `fruit`) VALUES
('afine', 100, 30, 1),
('ananas', 100, 10, 1),
('ardei gras', 100, 10, 0),
('ardei iute', 100, 4, 0),
('ardei kapia', 100, 7, 0),
('banane', 100, 7, 1),
('broccoli', 100, 12, 0),
('capsuni', 100, 32, 1),
('cartofi', 100, 4, 0),
('castraveti', 100, 6, 0),
('ceapa', 100, 4, 0),
('ceapa rosie', 100, 4, 0),
('ceapa verde', 100, 10, 0),
('ciuperci champignon', 100, 8, 0),
('coacaze', 100, 25, 1),
('conopida', 100, 5, 0),
('dovlecel', 100, 6, 0),
('fasole verde', 100, 10, 0),
('fructul pasiunii', 100, 15, 1),
('grapefruit', 100, 6, 1),
('guava', 100, 15, 1),
('gutuie', 100, 12, 1),
('kiwano', 100, 20, 1),
('kiwi', 100, 15, 1),
('lamaie', 100, 6, 1),
('lime', 100, 8, 1),
('lychee', 100, 30, 1),
('mango', 100, 15, 1),
('mango verde', 100, 18, 1),
('mazare', 100, 7, 0),
('mere', 100, 5, 1),
('morcovi', 100, 4, 0),
('nectarine', 100, 12, 1),
('papaya', 100, 10, 1),
('pepene galben', 100, 12, 1),
('pepene verde', 100, 4, 1),
('piersici', 100, 10, 1),
('pomelo', 100, 10, 1),
('portocale', 100, 6, 1),
('prune', 100, 8, 1),
('prune uscate', 100, 30, 1),
('rodie', 100, 15, 1),
('rosii', 100, 6, 0),
('salata iceberg', 100, 4, 0),
('smochine', 100, 12, 1),
('spanac', 100, 6, 0),
('telina', 100, 3, 0),
('usturoi', 100, 12, 0),
('varza', 100, 5, 0),
('varza rosie', 100, 6, 0),
('vinete', 100, 6, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
