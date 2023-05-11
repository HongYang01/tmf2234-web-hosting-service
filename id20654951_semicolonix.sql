-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2023 at 04:20 PM
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
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `u_email` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `date`, `u_email`) VALUES
(1, '2023-04-12', 'cynthia@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `billdetail`
--

CREATE TABLE `billdetail` (
  `bill_id` int(11) NOT NULL,
  `prod_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `billdetail`
--

INSERT INTO `billdetail` (`bill_id`, `prod_id`) VALUES
(1, 1),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(10) NOT NULL,
  `prod_title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `prod_subtitle` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `prod_category` enum('Shared','VPS','Dedicated','') COLLATE utf8_unicode_ci NOT NULL,
  `prod_price` float(5,2) NOT NULL,
  `prod_status` enum('Active','Disabled') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_title`, `prod_subtitle`, `prod_category`, `prod_price`, `prod_status`) VALUES
(1, 'Basic', 'Best for rookies ', 'Dedicated', 9.55, 'Disabled'),
(2, 'Popular', 'Intermediate user', 'Dedicated', 15.55, 'Active'),
(3, 'Premium', 'The pros', 'Dedicated', 33.55, 'Active'),
(4, 'Basic', 'Best for rookies', 'Shared', 1.55, 'Active'),
(5, 'Popular', 'Intermediate user', 'Shared', 2.55, 'Active'),
(6, 'Premium', 'The pros', 'Shared', 3.55, 'Active'),
(7, 'Basic', 'Best for rookies ', 'VPS', 3.55, 'Active'),
(8, 'Popular', 'Intermediate user', 'VPS', 10.55, 'Active'),
(9, 'Premium', 'The pros', 'VPS', 57.55, 'Active'),
(10, 'Testing Edited', 'Good for testing Edited', 'VPS', 1.12, 'Active'),
(11, 'Testing Title 2', 'Testing Subtitle 2', 'Shared', 12.50, 'Active');

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `prod_add` AFTER INSERT ON `product` FOR EACH ROW INSERT INTO productlog 
VALUES(
    null,
    NOW(), 
    'INSERT',
    NEW.prod_id,
    NEW.prod_title, 
    NEW.prod_subtitle, 
    NEW.prod_category, 
    NEW.prod_price)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `prod_del` BEFORE DELETE ON `product` FOR EACH ROW INSERT INTO productlog
VALUES(
    null,
    NOW(), 
    'DELETE',    
    OLD.prod_id,
    OLD.prod_title, 
    OLD.prod_subtitle, 
    OLD.prod_category, 
    OLD.prod_price)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `prod_edit` BEFORE UPDATE ON `product` FOR EACH ROW INSERT INTO productlog
VALUES(
    null,
    NOW(), 
    'UPDATE',    
    OLD.prod_id,
    OLD.prod_title, 
    OLD.prod_subtitle, 
    OLD.prod_category, 
    OLD.prod_price)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `productdetail`
--

CREATE TABLE `productdetail` (
  `auto_num` int(11) NOT NULL,
  `prod_id` int(10) NOT NULL,
  `feature` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `productdetail`
--

INSERT INTO `productdetail` (`auto_num`, `prod_id`, `feature`, `status`) VALUES
(1, 4, '1 Website', 1),
(2, 4, '2 Subdomains per account', 1),
(3, 4, '100GB Bandwidth', 1),
(4, 4, '5 MySQL Databases', 1),
(5, 4, '1 CPU Core', 1),
(6, 4, '512GB RAM', 1),
(7, 4, '50GB SSD Storage', 1),
(8, 4, 'Unlimited Free SSL Certificates', 1),
(9, 4, 'Daily Backup', 0),
(10, 4, '99.9% Uptime Guarantee', 1),
(11, 4, '24/7 Support', 1),
(12, 4, 'Powerful Control Panel (cPanel)', 1),
(13, 4, 'DNS management', 1),
(14, 4, '10 Entry Processes', 1),
(15, 4, '20 Active Processes', 1),
(16, 5, '100 Website', 1),
(17, 5, '100 Subdomains per account', 1),
(18, 5, 'Unlimited Bandwidth', 1),
(19, 5, 'Unlimited MySQL Databases', 1),
(20, 5, '1 CPU Core', 1),
(21, 5, '1024GB RAM', 1),
(22, 5, '100GB SSD Storage', 1),
(23, 5, 'Unlimited Free SSL Certificates', 1),
(24, 5, 'Daily Backup', 0),
(25, 5, '99.9% Uptime Guarantee', 1),
(26, 5, '24/7 Support', 1),
(27, 5, 'Powerful Control Panel (cPanel)', 1),
(28, 5, 'DNS management', 1),
(29, 5, '20 Entry Processes', 1),
(30, 5, '45 Active Processes', 1),
(31, 6, '150 Website', 1),
(32, 6, '100 Subdomains per account', 1),
(33, 6, 'Unlimited Bandwidth', 1),
(34, 6, 'Unlimited MySQL Databases', 1),
(35, 6, '2 CPU Core', 1),
(36, 6, '1536GB RAM', 1),
(37, 6, '300GB SSD Storage', 1),
(38, 6, 'Unlimited Free SSL Certificates', 1),
(39, 6, 'Daily Backup', 1),
(40, 6, '99.9% Uptime Guarantee', 1),
(41, 6, '24/7 Support', 1),
(42, 6, 'Powerful Control Panel (cPanel)', 1),
(43, 6, 'DNS management', 1),
(44, 6, '35 Entry Processes', 1),
(45, 6, '70 Active Processes', 1),
(46, 7, '1 vCPU core', 1),
(47, 7, '1GB RAM', 1),
(48, 7, '25GB SSD Storage', 1),
(49, 7, '1TB Bandwidth', 1),
(50, 7, '100Mbps Network', 1),
(51, 7, 'Weekly Backups', 1),
(52, 7, 'Full Root Access', 1),
(53, 7, 'Dedicated IP', 1),
(54, 7, '24/7 Support', 1),
(55, 8, '4 vCPU core', 1),
(56, 8, '4GB RAM', 1),
(57, 8, '85GB SSD Storage', 1),
(58, 8, '3TB Bandwidth', 1),
(59, 8, '200Mbps Network', 1),
(60, 8, 'Weekly Backups', 1),
(61, 8, 'Full Root Access', 1),
(62, 8, 'Dedicated IP', 1),
(63, 8, '24/7 Support', 1),
(64, 9, '8 vCPU core', 1),
(65, 9, '12GB RAM', 1),
(66, 9, '250GB SSD Storage', 1),
(67, 9, '6TB Bandwidth', 1),
(68, 9, '300Mbps Network', 1),
(69, 9, 'Weekly Backups', 1),
(70, 9, 'Full Root Access', 1),
(71, 9, 'Dedicated IP', 1),
(72, 9, '24/7 Support', 1),
(73, 1, 'Friendly Website Builder', 1),
(74, 1, '2 vCPU core', 1),
(75, 1, '3GB RAM', 1),
(76, 1, '200GB SSD Storage', 1),
(77, 1, '8GB Database Size', 1),
(78, 1, 'Unlimited Bandwidth', 1),
(79, 1, 'Access Manager', 1),
(80, 1, 'PHP Support', 1),
(81, 1, 'Isolated Resources', 1),
(82, 1, 'Free SSL Certificates', 1),
(83, 1, '99.9% Uptime Guarantee', 1),
(84, 1, '24/7 Support', 1),
(85, 2, 'Friendly Website Builder', 1),
(86, 2, '4 vCPU core', 1),
(87, 2, '6GB RAM', 1),
(88, 2, '250GB SSD Storage', 1),
(89, 2, '8GB Database Size', 1),
(90, 2, 'Unlimited Bandwidth', 1),
(91, 2, 'Access Manager', 1),
(92, 2, 'PHP Support', 1),
(93, 2, 'Isolated Resources', 1),
(94, 2, 'Free SSL Certificates', 1),
(95, 2, '99.9% Uptime Guarantee', 1),
(96, 2, '24/7 Support', 1),
(97, 3, 'Friendly Website Builder', 1),
(98, 3, '8 vCPU core', 1),
(99, 3, '12GB RAM', 1),
(100, 3, '300GB SSD Storage', 1),
(101, 3, '8GB Database Size', 1),
(102, 3, 'Unlimited Bandwidth', 1),
(103, 3, 'Access Manager', 1),
(104, 3, 'PHP Support', 1),
(105, 3, 'Isolated Resources', 1),
(106, 3, 'Free SSL Certificates', 1),
(107, 3, '99.9% Uptime Guarantee', 1),
(108, 3, '24/7 Support', 1),
(109, 10, 'Feature included Edited', 0),
(110, 10, 'Feature excluded Edited', 1),
(111, 11, 'Feature 2.1', 1),
(112, 11, 'Feature 2.2', 0),
(113, 11, 'Feature 2.3', 1),
(114, 10, 'Add New Product Feature', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productlog`
--

CREATE TABLE `productlog` (
  `id` int(10) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` text NOT NULL,
  `prod_id` int(10) NOT NULL,
  `prod_title` varchar(255) NOT NULL,
  `prod_subtitle` varchar(255) NOT NULL,
  `prod_category` varchar(255) NOT NULL,
  `prod_price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('hongyanglim01@gmail.com', 'Hong Yang', 'Lim', '$2y$10$74kuckngGtyaqnVU6jhAJOOQAStp9OQF8i1aLla2Iv3roTyP/xDfe', '2023-05-10 14:58:15'),
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
-- Indexes for table `productlog`
--
ALTER TABLE `productlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `productdetail`
--
ALTER TABLE `productdetail`
  MODIFY `auto_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `productlog`
--
ALTER TABLE `productlog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
  ADD CONSTRAINT `billDetail_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `billDetail_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`) ON UPDATE CASCADE;

--
-- Constraints for table `productdetail`
--
ALTER TABLE `productdetail`
  ADD CONSTRAINT `productdetail_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
