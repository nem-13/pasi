-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2023 at 09:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dummy_data_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(30) NOT NULL,
  `price` decimal(30,0) NOT NULL,
  `item_code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `quantity` int(30) NOT NULL,
  `brand` varchar(250) NOT NULL,
  `variety` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `price`, `item_code`, `name`, `quantity`, `brand`, `variety`) VALUES
(1, '13', '123123', 'Coke', 20023, 'Coca Cola', '5 Liter'),
(5, '60', '321321', 'Snow Bear', 22, 'Candy Man', '2 Kg'),
(7, '50', '6789', 'Piattos', 155, 'Jack n Jill', '50g'),
(8, '270', '9876', 'Chicken', 21, 'Magnolia', '1kg'),
(9, '6', '9999', 'Knorr Cubes', 277, 'Maggi', '1 piece');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(30) NOT NULL,
  `item_code` varchar(250) NOT NULL,
  `quantity_reduced` int(30) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `item_code`, `quantity_reduced`, `date`) VALUES
(13, '321321', 12, '2023-04-22'),
(14, '321321', 12, '2023-04-22'),
(15, '321321', 7, '2023-04-22'),
(16, '321321', 1, '2023-04-22'),
(17, '123123', 2, '2023-04-22'),
(18, '123123', 1, '2023-04-22'),
(19, '123123', 1, '2023-04-22'),
(20, '123123', 64, '2023-04-22'),
(21, '123123', 64, '2023-04-22'),
(22, '123123', 23, '2023-04-22'),
(23, '123123', 21, '2023-04-22'),
(24, '123123', 92, '2023-04-22'),
(25, '321321', 68, '2023-04-22'),
(31, '123123', 21, '2023-04-22'),
(32, '6789', 12, '2023-04-22'),
(33, '6789', 32, '2023-04-22'),
(34, '6789', 23, '2023-04-22'),
(35, '6789', 100, '2023-04-22'),
(36, '9876', 2, '2023-04-22'),
(37, '123123', 588, '2023-04-22'),
(38, '9999', 23, '2023-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`) VALUES
(1, 'gian', 'b316e256ea477cfeeb849f6fd5c1150f', 'Gian Troi Peralta');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
