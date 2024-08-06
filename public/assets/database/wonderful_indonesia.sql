-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 05:12 PM
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
-- Database: `wonderful_indonesia`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$kzBOrOvauQ4A.mLd4M0ZmeUO.8ARUyXPAWgcSHUEOjz92Hv9wZWqm');

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `id` int(11) NOT NULL,
  `destination_name` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `destination_price` bigint(20) NOT NULL,
  `min_day` int(11) NOT NULL,
  `max_day` int(11) NOT NULL,
  `transport_price` bigint(20) NOT NULL,
  `food_price` bigint(20) NOT NULL,
  `destination_location` varchar(255) NOT NULL,
  `best_seller` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`id`, `destination_name`, `slug`, `destination_price`, `min_day`, `max_day`, `transport_price`, `food_price`, `destination_location`, `best_seller`) VALUES
(29, 'Lake Toba', 'EhVaEvDg', 4520000, 1, 4, 690000, 345000, 'Medan', 0),
(30, 'Labuan Bajo', 'NuGQvQpC', 4100000, 1, 5, 300000, 100000, 'Nusa Tenggara Timur', 1),
(31, 'Jakarta', 'ydIVAdUG', 1820000, 1, 7, 500000, 300000, 'Jakarta', 0),
(32, 'Borobudur', 'F86e1rWE', 2142000, 1, 5, 310000, 195000, 'Yogyakarta', 1);

-- --------------------------------------------------------

--
-- Table structure for table `destination_images`
--

CREATE TABLE `destination_images` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destination_images`
--

INSERT INTO `destination_images` (`id`, `destination_id`, `images`) VALUES
(86, 29, 'N6i1fy2XynE0.jpg'),
(87, 29, 'hxwFrpLu9Bcv.jpg'),
(88, 29, 'BKLWuBOluPRO.jpg'),
(89, 29, 'q9IZb0lABEvV.jpg'),
(90, 29, 'TLn5acT4WWo1.jpg'),
(91, 29, 'YQA1TgQfj8Vg.jpg'),
(92, 29, 'D0C3mjdMnU05.jpg'),
(93, 30, 'VOs7UYWMtiFm.jpg'),
(94, 30, 'Kd5AaD2m9317.jpg'),
(95, 30, 'cl5sOYHnlNVr.jpg'),
(96, 30, 'kQpj1veVBxmw.jpg'),
(97, 30, 'xavurH1Bjrsv.jpg'),
(98, 31, 'FKo5Xe9AW2O8.jpeg'),
(99, 31, 'MSwquINb7Ohd.jpg'),
(100, 31, 'BtwZBXmx5oqR.jpg'),
(101, 31, 'gAtGshYOGlf0.jpg'),
(102, 31, 'FzWe50wQWT6S.jpg'),
(103, 32, 'aX8gm6DTDu99.jpg'),
(104, 32, 'AbnmIqbgwaF1.jpg'),
(105, 32, 'JsUbI3vPokh1.jpg'),
(106, 32, 'Cu1977v2klN1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(20) NOT NULL,
  `invoice_id` int(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `booking_date` date NOT NULL,
  `guest` int(20) NOT NULL,
  `days` int(20) NOT NULL,
  `transport` int(1) NOT NULL,
  `food` int(1) NOT NULL,
  `departure_date` date NOT NULL,
  `destination_id` int(11) NOT NULL,
  `paid` int(1) NOT NULL,
  `total` bigint(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `transfer_amount` bigint(20) NOT NULL,
  `transfer_purpose` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `destination_images`
--
ALTER TABLE `destination_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD CONSTRAINT `destination_images_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
