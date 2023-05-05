-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 05:27 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20654951_semicolonix`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `a_firstName` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `a_lastName` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `a_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_email`, `a_firstName`, `a_lastName`, `a_password`) VALUES
('admin1@semicolonix.com', 'John', 'Chin', '$2y$10$Bk5rhkKj.lG54Sp0wPmfieAb29wP4pLbRi7.hjlLkta431ngjjQX6');

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE `adminlog` (
  `id` int(10) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` text NOT NULL,
  `detail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `u_email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `total` float(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `date`, `u_email`, `total`) VALUES
(1, '2023-04-12', 'cynthia@gmail.com', 15.55),
(2, '2023-04-28', 'michelle@gmail.com', 10.55);

-- --------------------------------------------------------

--
-- Table structure for table `billdetail`
--

CREATE TABLE `billdetail` (
  `bill_id` int(11) NOT NULL,
  `prod_id` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `billdetail`
--

INSERT INTO `billdetail` (`bill_id`, `prod_id`) VALUES
(1, 'dh2'),
(2, 'vps2');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `prod_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `prod_title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `prod_subtitle` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `prod_category` enum('Shared','VPS','Dedicated','') COLLATE utf8_unicode_ci NOT NULL,
  `prod_price` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_title`, `prod_subtitle`, `prod_category`, `prod_price`) VALUES
('dh1', 'Dedicated Hosting (Basic)', 'Basic', 'Best for rookies ', 'Dedicated', 9.55),
('dh2', 'Dedicated Hosting (Popular)', 'Popular', 'Intermediate user', 'Dedicated', 15.55),
('dh3', 'Dedicated Hosting (Premium)', 'Premium', 'The pros', 'Dedicated', 33.55),
('sh1', 'Shared Hosting (Basic)', 'Basic', 'Best for rookies', 'Shared', 1.55),
('sh2', 'Shared Hosting (Popular)', 'Popular', 'Intermediate user', 'Shared', 2.55),
('sh3', 'Shared Hosting (Premium)', 'Premium', 'The pros', 'Shared', 3.55),
('vps1', 'VPS (Basic)', 'Basic', 'Best for rookies ', 'VPS', 3.55),
('vps2', 'VPS (Popular)', 'Popular', 'Intermediate user', 'VPS', 10.55),
('vps3', 'VPS (Premium)', 'Premium', 'The pros', 'VPS', 57.55);

-- --------------------------------------------------------

--
-- Table structure for table `productdetail`
--

CREATE TABLE `productdetail` (
  `auto_num` int(11) NOT NULL,
  `prod_id` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `feature` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `productdetail`
--

INSERT INTO `productdetail` (`auto_num`, `prod_id`, `feature`, `status`) VALUES
(1, 'sh1', '1 Website', 1),
(2, 'sh1', '2 Subdomains per account', 1),
(3, 'sh1', '100GB Bandwidth', 1),
(4, 'sh1', '5 MySQL Databases', 1),
(5, 'sh1', '1 CPU Core', 1),
(6, 'sh1', '512GB RAM', 1),
(7, 'sh1', '50GB SSD Storage', 1),
(8, 'sh1', 'Unlimited Free SSL Certificates', 1),
(9, 'sh1', 'Daily Backup', 0),
(10, 'sh1', '99.9% Uptime Guarantee', 1),
(11, 'sh1', '24/7 Support', 1),
(12, 'sh1', 'Powerful Control Panel (cPanel)', 1),
(13, 'sh1', 'DNS management', 1),
(14, 'sh1', '10 Entry Processes', 1),
(15, 'sh1', '20 Active Processes', 1),
(16, 'sh2', '100 Website', 1),
(17, 'sh2', '100 Subdomains per account', 1),
(18, 'sh2', 'Unlimited Bandwidth', 1),
(19, 'sh2', 'Unlimited MySQL Databases', 1),
(20, 'sh2', '1 CPU Core', 1),
(21, 'sh2', '1024GB RAM', 1),
(22, 'sh2', '100GB SSD Storage', 1),
(23, 'sh2', 'Unlimited Free SSL Certificates', 1),
(24, 'sh2', 'Daily Backup', 0),
(25, 'sh2', '99.9% Uptime Guarantee', 1),
(26, 'sh2', '24/7 Support', 1),
(27, 'sh2', 'Powerful Control Panel (cPanel)', 1),
(28, 'sh2', 'DNS management', 1),
(29, 'sh2', '20 Entry Processes', 1),
(30, 'sh2', '45 Active Processes', 1),
(31, 'sh3', '150 Website', 1),
(32, 'sh3', '100 Subdomains per account', 1),
(33, 'sh3', 'Unlimited Bandwidth', 1),
(34, 'sh3', 'Unlimited MySQL Databases', 1),
(35, 'sh3', '2 CPU Core', 1),
(36, 'sh3', '1536GB RAM', 1),
(37, 'sh3', '300GB SSD Storage', 1),
(38, 'sh3', 'Unlimited Free SSL Certificates', 1),
(39, 'sh3', 'Daily Backup', 1),
(40, 'sh3', '99.9% Uptime Guarantee', 1),
(41, 'sh3', '24/7 Support', 1),
(42, 'sh3', 'Powerful Control Panel (cPanel)', 1),
(43, 'sh3', 'DNS management', 1),
(44, 'sh3', '35 Entry Processes', 1),
(45, 'sh3', '70 Active Processes', 1),
(46, 'vps1', '1 vCPU core', 1),
(47, 'vps1', '1GB RAM', 1),
(48, 'vps1', '25GB SSD Storage', 1),
(49, 'vps1', '1TB Bandwidth', 1),
(50, 'vps1', '100Mbps Network', 1),
(51, 'vps1', 'Weekly Backups', 1),
(52, 'vps1', 'Full Root Access', 1),
(53, 'vps1', 'Dedicated IP', 1),
(54, 'vps1', '24/7 Support', 1),
(55, 'vps2', '4 vCPU core', 1),
(56, 'vps2', '4GB RAM', 1),
(57, 'vps2', '85GB SSD Storage', 1),
(58, 'vps2', '3TB Bandwidth', 1),
(59, 'vps2', '200Mbps Network', 1),
(60, 'vps2', 'Weekly Backups', 1),
(61, 'vps2', 'Full Root Access', 1),
(62, 'vps2', 'Dedicated IP', 1),
(63, 'vps2', '24/7 Support', 1),
(64, 'vps3', '8 vCPU core', 1),
(65, 'vps3', '12GB RAM', 1),
(66, 'vps3', '250GB SSD Storage', 1),
(67, 'vps3', '6TB Bandwidth', 1),
(68, 'vps3', '300Mbps Network', 1),
(69, 'vps3', 'Weekly Backups', 1),
(70, 'vps3', 'Full Root Access', 1),
(71, 'vps3', 'Dedicated IP', 1),
(72, 'vps3', '24/7 Support', 1),
(73, 'dh1', 'Friendly Website Builder', 1),
(74, 'dh1', '2 vCPU core', 1),
(75, 'dh1', '3GB RAM', 1),
(76, 'dh1', '200GB SSD Storage', 1),
(77, 'dh1', '8GB Database Size', 1),
(78, 'dh1', 'Unlimited Bandwidth', 1),
(79, 'dh1', 'Access Manager', 1),
(80, 'dh1', 'PHP Support', 1),
(81, 'dh1', 'Isolated Resources', 1),
(82, 'dh1', 'Free SSL Certificates', 1),
(83, 'dh1', '99.9% Uptime Guarantee', 1),
(84, 'dh1', '24/7 Support', 1),
(85, 'dh2', 'Friendly Website Builder', 1),
(86, 'dh2', '4 vCPU core', 1),
(87, 'dh2', '6GB RAM', 1),
(88, 'dh2', '250GB SSD Storage', 1),
(89, 'dh2', '8GB Database Size', 1),
(90, 'dh2', 'Unlimited Bandwidth', 1),
(91, 'dh2', 'Access Manager', 1),
(92, 'dh2', 'PHP Support', 1),
(93, 'dh2', 'Isolated Resources', 1),
(94, 'dh2', 'Free SSL Certificates', 1),
(95, 'dh2', '99.9% Uptime Guarantee', 1),
(96, 'dh2', '24/7 Support', 1),
(97, 'dh3', 'Friendly Website Builder', 1),
(98, 'dh3', '8 vCPU core', 1),
(99, 'dh3', '12GB RAM', 1),
(100, 'dh3', '300GB SSD Storage', 1),
(101, 'dh3', '8GB Database Size', 1),
(102, 'dh3', 'Unlimited Bandwidth', 1),
(103, 'dh3', 'Access Manager', 1),
(104, 'dh3', 'PHP Support', 1),
(105, 'dh3', 'Isolated Resources', 1),
(106, 'dh3', 'Free SSL Certificates', 1),
(107, 'dh3', '99.9% Uptime Guarantee', 1),
(108, 'dh3', '24/7 Support', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `u_firstName` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `u_lastName` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `u_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `signupDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_email`, `u_firstName`, `u_lastName`, `u_password`, `signupDate`) VALUES
('cynthia@gmail.com', 'Cynthia', 'Kim', '$2y$10$ac2hDcbtxiZ/Cus3eOBMmesFBvvWjXcDqXHI9fQ0.qG4/.36nuNve', '2023-05-01 08:06:54'),
('michelle@gmail.com', 'Michelle', 'Chan', 'Michelle@12', '2023-05-02 08:06:54'),
('name1@gmail.com', 'Name 1', 'Testing', '$2y$10$7gUExs92yWTFyWs5cyE1kuYI61bTOOE.vHY2Iq2sa9n2VcWnQaIGq', '2023-05-02 16:00:00'),
('name2@gmail.com', 'Name 2', 'Testing', '$2y$10$L0h3sGaJwkXyyLjNjoSqiex.KiJqedwvp.uokO3jtGvmnQrHUMzcq', '2023-05-04 08:07:30'),
('name3@gmail.com', 'Name 3', 'Testing', '$2y$10$jD326liszmITGRmtwQMjK.yTkrVGQe9zExgdoAHRLZwxUxSj6BI5C', '2023-05-02 08:09:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_email`);

--
-- Indexes for table `adminlog`
--
ALTER TABLE `adminlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `u_email` (`u_email`);

--
-- Indexes for table `billdetail`
--
ALTER TABLE `billdetail`
  ADD PRIMARY KEY (`bill_id`,`prod_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `productdetail`
--
ALTER TABLE `productdetail`
  ADD PRIMARY KEY (`auto_num`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlog`
--
ALTER TABLE `adminlog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `billdetail`
--
ALTER TABLE `billdetail`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productdetail`
--
ALTER TABLE `productdetail`
  MODIFY `auto_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`u_email`) REFERENCES `user` (`u_email`);

--
-- Constraints for table `billdetail`
--
ALTER TABLE `billdetail`
  ADD CONSTRAINT `billDetail_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_id`),
  ADD CONSTRAINT `billDetail_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`);

--
-- Constraints for table `productdetail`
--
ALTER TABLE `productdetail`
  ADD CONSTRAINT `productDetail_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
