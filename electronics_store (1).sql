-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 03:34 PM
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
-- Database: `electronics_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_data`
--

CREATE TABLE `admin_data` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `Lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_data`
--

INSERT INTO `admin_data` (`id`, `FirstName`, `Lastname`, `email`, `password`, `status`) VALUES
(1, 'Prajwal', 'Bhattarai', 'prajwalbhattarai80@gmail.com', '5a79ec1fe60b6aa37eac39424b170f11', 0),
(2, 'prajwal', 'bhattarai', 'admin@gmail.com', '967454173c7637d071a8bd30224407e3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `price` varchar(200) NOT NULL,
  `quantity` bigint(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `product_name`, `thumb`, `price`, `quantity`, `user_id`) VALUES
(212, 20, 'airpod  pro lastest', '661b9553d037d_new.jpeg', '60000', 0, 64),
(213, 21, 'Asta WOLF Howl | Wired Out-Ear Earphones | Clear Sound and Ultra Deep Bass | 3.5mm Jack | 14.5mm Large Drivers | Metallic Magnetic Earphones | Volume Control ||', '662f905823248_Annotation 2024-04-29 180329.png', '630', 0, 64),
(214, 21, 'Asta WOLF Howl | Wired Out-Ear Earphones | Clear Sound and Ultra Deep Bass | 3.5mm Jack | 14.5mm Large Drivers | Metallic Magnetic Earphones | Volume Control ||', '662f905823248_Annotation 2024-04-29 180329.png', '630', 0, 64),
(240, 22, 'samsung j7', '6635c707086f4_samsung-galaxy-j7-j700f.jpg', '8000', 0, 71),
(241, 23, 'JBL', '66456c752774f_1_JBL_FLIP6_HERO_TEAL_29399_x1.webp', '120000', 0, 0),
(242, 23, 'JBL', '66456c752774f_1_JBL_FLIP6_HERO_TEAL_29399_x1.webp', '120000', 0, 71),
(243, 21, 'Asta WOLF Howl | Wired Out-Ear Earphones', '662f905823248_Annotation 2024-04-29 180329.png', '630', 0, 71);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `logo`) VALUES
(1, 'Mobile Phones', ''),
(2, 'Headphones', ''),
(3, 'Bluetooth Speakers', ''),
(4, 'Accessories', ''),
(7, 'Laptops & Macbooks', ''),
(11, 'Airpods/Earbuds', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `quantity` bigint(50) NOT NULL,
  `delivery_method` varchar(500) NOT NULL,
  `order_date` date NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_name`, `quantity`, `delivery_method`, `order_date`, `status`) VALUES
(1, 71, '', 0, 'Cash On Delivery', '2024-05-01', 1),
(2, 71, '', 0, 'Cash On Delivery', '2024-05-01', 1),
(3, 71, '', 0, 'Cash On Delivery', '2024-05-01', 2),
(4, 71, 'airpod ', 0, 'Cash On Delivery', '2024-05-01', 2),
(5, 71, '', 0, 'Cash On Delivery', '2024-05-01', 3),
(6, 71, 'airpod ', 0, 'Cash On Delivery', '2024-05-01', 1),
(8, 71, 'Asta', 0, 'Cash On Delivery', '2024-05-02', 2),
(9, 64, 'Asta', 0, 'Cash On Delivery', '2024-05-02', 2),
(10, 64, 'airpod ', 0, 'Cash On Delivery', '2024-05-15', 1),
(11, 71, 'airpod ', 0, 'Cash On Delivery', '2024-05-17', 0),
(12, 71, 'airpod  pro lastest', 0, 'Cash On Delivery', '2024-05-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `brand` varchar(500) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `price` bigint(200) NOT NULL,
  `quantity` int(255) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `brand`, `cat_id`, `price`, `quantity`, `thumb`, `description`) VALUES
(17, 'Apple Macbook Air Apple M1', 'Apple', 7, 200000, 10, '6638e038df7ba_6631db027a14a_661b94b1b87b6_apple-macbook-pro-2020-m1-1627883712.jpg', 'null'),
(18, 'airpod ', 'Apple', 11, 40000, 0, '661b94fe8db07_airpods.jpeg', 'bass good'),
(20, 'airpod  pro lastest', 'Apple', 11, 60000, 0, '661b9553d037d_new.jpeg', 'bass good'),
(21, 'Asta WOLF Howl | Wired Out-Ear Earphones', 'Asta Wolf', 11, 630, 20, '662f905823248_Annotation 2024-04-29 180329.png', 'Product details of Asta WOLF Howl | Wired Out-Ear Earphones | Clear Sound and Ultra Deep Bass | 3.5mm Jack | 14.5mm Large Drivers | Metallic Magnetic Earphones | Volume Control ||      Pin: 3.5mm     '),
(22, 'samsung j7', '', 1, 8000, 0, '6635c707086f4_samsung-galaxy-j7-j700f.jpg', 'Babbal'),
(23, 'JBL Flip 6', 'JBL', 3, 120000, 0, '66456c752774f_1_JBL_FLIP6_HERO_TEAL_29399_x1.webp', 'Your adventure. Your soundtrack. The bold JBL Flip 6 delivers powerful JBL Original Pro Sound with exceptional clarity thanks to its 2-way speaker system consisting of an optimized racetrack-shaped driver, separate tweeter, and dual pumping bass radiators.');

-- --------------------------------------------------------

--
-- Table structure for table `users_data`
--

CREATE TABLE `users_data` (
  `thumb` varchar(500) NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` bigint(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_data`
--

INSERT INTO `users_data` (`thumb`, `id`, `name`, `email`, `password`, `phone`, `address`, `city`) VALUES
('', 64, 'nabin thapa', 'nabinthapa@yahoo.com', 'nabin', 98254585448, 'jawalakhel', 'lalitpur\r\n'),
('', 65, 'Ramesh Chaulagain', 'ramesh@gmail.com', 'ramesh', 9765245782, 'Thasikel', 'Lalitpur'),
('', 66, 'Ramesh Chaulagain', 'ramesh@gmail.com', 'ramesh', 9765245789, 'Thasikel', 'Lalitpur'),
('', 67, 'hari shankar', 'harishankar12@gmail.com', 'hellohari', 97542458465, 'Sundhara', 'kathmandu'),
('', 68, 'Karishma manandhar', 'karishma24@gmail.com', 'kathmandu', 9645215485, 'NewRoad', 'Kathmandu'),
('', 69, 'Karishma rai', 'karishma245@gmail.com', 'kathmandu', 8548455471, 'balkot', 'bhaktapur'),
('662a54ee7c2e8_S0WyG.jpg', 71, 'Hania Amir', 'hania@gmail.com', 'hania', 9854585999, 'ltr', 'lte');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_data`
--
ALTER TABLE `admin_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_data`
--
ALTER TABLE `admin_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_data`
--
ALTER TABLE `users_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
