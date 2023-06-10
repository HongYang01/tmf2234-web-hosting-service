-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2023 at 07:52 AM
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

DROP TABLE IF EXISTS `admin`;
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
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
CREATE TABLE `plan` (
  `plan_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prod_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plan_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `plan_desc` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `plan_price` float(5,2) NOT NULL,
  `plan_status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`plan_id`, `prod_id`, `plan_name`, `plan_desc`, `plan_price`, `plan_status`) VALUES
('P-0GM50921FC832453RMR2XKDY', 'PROD0002', 'Basic', 'Best for rookies ', 3.55, 'ACTIVE'),
('P-0T4500702B9280615MR2XMDQ', 'PROD0003', 'Basic', 'Best for rookies ', 9.55, 'ACTIVE'),
('P-11H60556R0411082MMR2L2FI', 'PROD0001', 'Premium', 'The pros', 3.55, 'ACTIVE'),
('P-5UL64606MW856531PMR2XMUA', 'PROD0003', 'Premium', 'The pros', 33.55, 'ACTIVE'),
('P-7HU86870CB6342615MR2LZNA', 'PROD0001', 'Popular', 'Intermediate user', 2.55, 'ACTIVE'),
('P-8BN527251F239152TMR2XMMA', 'PROD0003', 'Popular', 'Intermediate user', 15.55, 'ACTIVE'),
('P-8SM252323T120453TMR2K4SQ', 'PROD0001', 'Basic', 'Best for rookies', 1.55, 'ACTIVE'),
('P-9M811001A39121528MR2XKYA', 'PROD0002', 'Premium', 'The pros', 57.55, 'ACTIVE'),
('P-9PP23621SW0121423MR2XKPQ', 'PROD0002', 'Popular', 'Intermediate user', 10.55, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `plandetail`
--

DROP TABLE IF EXISTS `plandetail`;
CREATE TABLE `plandetail` (
  `auto_num` int(11) NOT NULL,
  `plan_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `feature` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plandetail`
--

INSERT INTO `plandetail` (`auto_num`, `plan_id`, `feature`, `status`) VALUES
(1, 'P-8SM252323T120453TMR2K4SQ', '1 Website', 1),
(2, 'P-8SM252323T120453TMR2K4SQ', '2 Subdomains per account', 1),
(3, 'P-8SM252323T120453TMR2K4SQ', '100GB Bandwidth', 1),
(4, 'P-8SM252323T120453TMR2K4SQ', '5 MySQL Databases', 1),
(5, 'P-8SM252323T120453TMR2K4SQ', '1 CPU Core', 1),
(6, 'P-8SM252323T120453TMR2K4SQ', '512GB RAM', 1),
(7, 'P-8SM252323T120453TMR2K4SQ', '50GB SSD Storage', 1),
(8, 'P-8SM252323T120453TMR2K4SQ', 'Unlimited Free SSL Certificates', 1),
(9, 'P-8SM252323T120453TMR2K4SQ', 'Daily Backup', 0),
(10, 'P-8SM252323T120453TMR2K4SQ', '99.9% Uptime Guarantee', 1),
(11, 'P-8SM252323T120453TMR2K4SQ', '24/7 Support', 1),
(12, 'P-8SM252323T120453TMR2K4SQ', 'Powerful Control Panel (cPanel)', 1),
(13, 'P-8SM252323T120453TMR2K4SQ', 'DNS management', 1),
(14, 'P-8SM252323T120453TMR2K4SQ', '10 Entry Processes', 1),
(15, 'P-8SM252323T120453TMR2K4SQ', '20 Active Processes', 1),
(16, 'P-7HU86870CB6342615MR2LZNA', '100 Website', 1),
(17, 'P-7HU86870CB6342615MR2LZNA', '100 Subdomains per account', 1),
(18, 'P-7HU86870CB6342615MR2LZNA', 'Unlimited Bandwidth', 1),
(19, 'P-7HU86870CB6342615MR2LZNA', 'Unlimited MySQL Databases', 1),
(20, 'P-7HU86870CB6342615MR2LZNA', '1 CPU Core', 1),
(21, 'P-7HU86870CB6342615MR2LZNA', '1024GB RAM', 1),
(22, 'P-7HU86870CB6342615MR2LZNA', '100GB SSD Storage', 1),
(23, 'P-7HU86870CB6342615MR2LZNA', 'Unlimited Free SSL Certificates', 1),
(24, 'P-7HU86870CB6342615MR2LZNA', 'Daily Backup', 0),
(25, 'P-7HU86870CB6342615MR2LZNA', '99.9% Uptime Guarantee', 1),
(26, 'P-7HU86870CB6342615MR2LZNA', '24/7 Support', 1),
(27, 'P-7HU86870CB6342615MR2LZNA', 'Powerful Control Panel (cPanel)', 1),
(28, 'P-7HU86870CB6342615MR2LZNA', 'DNS management', 1),
(29, 'P-7HU86870CB6342615MR2LZNA', '20 Entry Processes', 1),
(30, 'P-7HU86870CB6342615MR2LZNA', '45 Active Processes', 1),
(31, 'P-11H60556R0411082MMR2L2FI', '150 Website', 1),
(32, 'P-11H60556R0411082MMR2L2FI', '100 Subdomains per account', 1),
(33, 'P-11H60556R0411082MMR2L2FI', 'Unlimited Bandwidth', 1),
(34, 'P-11H60556R0411082MMR2L2FI', 'Unlimited MySQL Databases', 1),
(35, 'P-11H60556R0411082MMR2L2FI', '2 CPU Core', 1),
(36, 'P-11H60556R0411082MMR2L2FI', '1536GB RAM', 1),
(37, 'P-11H60556R0411082MMR2L2FI', '300GB SSD Storage', 1),
(38, 'P-11H60556R0411082MMR2L2FI', 'Unlimited Free SSL Certificates', 1),
(39, 'P-11H60556R0411082MMR2L2FI', 'Daily Backup', 1),
(40, 'P-11H60556R0411082MMR2L2FI', '99.9% Uptime Guarantee', 1),
(41, 'P-11H60556R0411082MMR2L2FI', '24/7 Support', 1),
(42, 'P-11H60556R0411082MMR2L2FI', 'Powerful Control Panel (cPanel)', 1),
(43, 'P-11H60556R0411082MMR2L2FI', 'DNS management', 1),
(44, 'P-11H60556R0411082MMR2L2FI', '35 Entry Processes', 1),
(45, 'P-11H60556R0411082MMR2L2FI', '70 Active Processes', 1),
(46, 'P-0GM50921FC832453RMR2XKDY', '1 vCPU core', 1),
(47, 'P-0GM50921FC832453RMR2XKDY', '1GB RAM', 1),
(48, 'P-0GM50921FC832453RMR2XKDY', '25GB SSD Storage', 1),
(49, 'P-0GM50921FC832453RMR2XKDY', '1TB Bandwidth', 1),
(50, 'P-0GM50921FC832453RMR2XKDY', '100Mbps Network', 1),
(51, 'P-0GM50921FC832453RMR2XKDY', 'Weekly Backups', 1),
(52, 'P-0GM50921FC832453RMR2XKDY', 'Full Root Access', 1),
(53, 'P-0GM50921FC832453RMR2XKDY', 'Dedicated IP', 1),
(54, 'P-0GM50921FC832453RMR2XKDY', '24/7 Support', 1),
(55, 'P-9PP23621SW0121423MR2XKPQ', '4 vCPU core', 1),
(56, 'P-9PP23621SW0121423MR2XKPQ', '4GB RAM', 1),
(57, 'P-9PP23621SW0121423MR2XKPQ', '85GB SSD Storage', 1),
(58, 'P-9PP23621SW0121423MR2XKPQ', '3TB Bandwidth', 1),
(59, 'P-9PP23621SW0121423MR2XKPQ', '200Mbps Network', 1),
(60, 'P-9PP23621SW0121423MR2XKPQ', 'Weekly Backups', 1),
(61, 'P-9PP23621SW0121423MR2XKPQ', 'Full Root Access', 1),
(62, 'P-9PP23621SW0121423MR2XKPQ', 'Dedicated IP', 1),
(63, 'P-9PP23621SW0121423MR2XKPQ', '24/7 Support', 1),
(64, 'P-9M811001A39121528MR2XKYA', '8 vCPU core', 1),
(65, 'P-9M811001A39121528MR2XKYA', '12GB RAM', 1),
(66, 'P-9M811001A39121528MR2XKYA', '250GB SSD Storage', 1),
(67, 'P-9M811001A39121528MR2XKYA', '6TB Bandwidth', 1),
(68, 'P-9M811001A39121528MR2XKYA', '300Mbps Network', 1),
(69, 'P-9M811001A39121528MR2XKYA', 'Weekly Backups', 1),
(70, 'P-9M811001A39121528MR2XKYA', 'Full Root Access', 1),
(71, 'P-9M811001A39121528MR2XKYA', 'Dedicated IP', 1),
(72, 'P-9M811001A39121528MR2XKYA', '24/7 Support', 1),
(73, 'P-0T4500702B9280615MR2XMDQ', 'Friendly Website Builder', 1),
(74, 'P-0T4500702B9280615MR2XMDQ', '2 vCPU core', 1),
(75, 'P-0T4500702B9280615MR2XMDQ', '3GB RAM', 1),
(76, 'P-0T4500702B9280615MR2XMDQ', '200GB SSD Storage', 1),
(77, 'P-0T4500702B9280615MR2XMDQ', '8GB Database Size', 1),
(78, 'P-0T4500702B9280615MR2XMDQ', 'Unlimited Bandwidth', 1),
(79, 'P-0T4500702B9280615MR2XMDQ', 'Access Manager', 1),
(80, 'P-0T4500702B9280615MR2XMDQ', 'PHP Support', 1),
(81, 'P-0T4500702B9280615MR2XMDQ', 'Isolated Resources', 1),
(82, 'P-0T4500702B9280615MR2XMDQ', 'Free SSL Certificates', 1),
(83, 'P-0T4500702B9280615MR2XMDQ', '99.9% Uptime Guarantee', 1),
(84, 'P-0T4500702B9280615MR2XMDQ', '24/7 Support', 1),
(85, 'P-8BN527251F239152TMR2XMMA', 'Friendly Website Builder', 1),
(86, 'P-8BN527251F239152TMR2XMMA', '4 vCPU core', 1),
(87, 'P-8BN527251F239152TMR2XMMA', '6GB RAM', 1),
(88, 'P-8BN527251F239152TMR2XMMA', '250GB SSD Storage', 1),
(89, 'P-8BN527251F239152TMR2XMMA', '8GB Database Size', 1),
(90, 'P-8BN527251F239152TMR2XMMA', 'Unlimited Bandwidth', 1),
(91, 'P-8BN527251F239152TMR2XMMA', 'Access Manager', 1),
(92, 'P-8BN527251F239152TMR2XMMA', 'PHP Support', 1),
(93, 'P-8BN527251F239152TMR2XMMA', 'Isolated Resources', 1),
(94, 'P-8BN527251F239152TMR2XMMA', 'Free SSL Certificates', 1),
(95, 'P-8BN527251F239152TMR2XMMA', '99.9% Uptime Guarantee', 1),
(96, 'P-8BN527251F239152TMR2XMMA', '24/7 Support', 1),
(97, 'P-5UL64606MW856531PMR2XMUA', 'Friendly Website Builder', 1),
(98, 'P-5UL64606MW856531PMR2XMUA', '8 vCPU core', 1),
(99, 'P-5UL64606MW856531PMR2XMUA', '12GB RAM', 1),
(100, 'P-5UL64606MW856531PMR2XMUA', '300GB SSD Storage', 1),
(101, 'P-5UL64606MW856531PMR2XMUA', '8GB Database Size', 1),
(102, 'P-5UL64606MW856531PMR2XMUA', 'Unlimited Bandwidth', 1),
(103, 'P-5UL64606MW856531PMR2XMUA', 'Access Manager', 1),
(104, 'P-5UL64606MW856531PMR2XMUA', 'PHP Support', 1),
(105, 'P-5UL64606MW856531PMR2XMUA', 'Isolated Resources', 1),
(106, 'P-5UL64606MW856531PMR2XMUA', 'Free SSL Certificates', 1),
(107, 'P-5UL64606MW856531PMR2XMUA', '99.9% Uptime Guarantee', 1),
(108, 'P-5UL64606MW856531PMR2XMUA', '24/7 Support', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `prod_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prod_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prod_status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_status`) VALUES
('PROD0001', 'Shared', 'ACTIVE'),
('PROD0002', 'VPS', 'ACTIVE'),
('PROD0003', 'Dedicated', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `productlog`
--

DROP TABLE IF EXISTS `productlog`;
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
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `sub_status` text COLLATE utf8_unicode_ci NOT NULL,
  `sub_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plan_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payer_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currency_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bill_date` datetime NOT NULL,
  `next_bill_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`sub_status`, `sub_id`, `plan_id`, `u_email`, `paypal_email`, `paypal_name`, `payer_id`, `amount`, `currency_code`, `bill_date`, `next_bill_date`) VALUES
('ACTIVE', 'I-D3ETYG0AC8M9', 'P-8SM252323T120453TMR2K4SQ', 'name3@gmail.com', 'sb-tehix25986425@personal.example.com', 'John Doe', '9LB2QJM6L9ZSU', 1.55, 'USD', '2023-06-10 04:37:05', '2023-07-09 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `trans_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_sub_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_currency_code` text COLLATE utf8_unicode_ci NOT NULL,
  `trans_gross_amount` double(10,2) NOT NULL,
  `trans_fee_amount` double(10,2) NOT NULL,
  `trans_net_amount` double(10,2) NOT NULL,
  `trans_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`trans_id`, `trans_sub_id`, `trans_status`, `trans_currency_code`, `trans_gross_amount`, `trans_fee_amount`, `trans_net_amount`, `trans_datetime`) VALUES
('71L13637TT2390441', 'I-D3ETYG0AC8M9', 'COMPLETED', 'USD', 1.55, 0.54, 1.01, '2023-06-10 04:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
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
('alex@gmail.com', 'Alex', 'Anderson', '$2y$10$ngNaOIuWtZuOiQSGsuWTz.uQha2NON3dBR6TbXuZR7GzdtOsvX0AO', '2023-04-30 23:45:30'),
('alice@outlook.com', 'Alice', 'Williams', '$2y$10$KHvOaXOpRxVIOoiT27uv8u2wDz2RajT.RfSsX6AMlAnAe/A/O1/l6', '2023-01-24 18:39:44'),
('bob@hotmail.com', 'Bob', 'Johnson', '$2y$10$nypN9i0pjX2vXVjRhUYjsO9q1Iete/xYKN6xDZ8P8zBYmA.iUBI1m', '2023-03-29 23:38:45'),
('cynthia@gmail.com', 'Cynthia', 'Kim', '$2y$10$ac2hDcbtxiZ/Cus3eOBMmesFBvvWjXcDqXHI9fQ0.qG4/.36nuNve', '2023-05-01 08:06:54'),
('emily@hotmail.com', 'Emily', 'Wilson', '$2y$10$P6DMtHQchFdkQZMkI/FAhem5T6XpKqve7Nbn/uxvcpgJlAqo/wIlG', '2023-03-10 19:42:44'),
('james@gmail.com', 'James', 'Brown', '$2y$10$1Fvi5M4Kx44bjABj8zq6bOrEEhheFbe2uTv07vgA8fwpaaArvpRuK', '2023-01-19 21:40:43'),
('jane@yahoo.com', 'Jane', 'Smith', '$2y$10$VhkmYJyeU5JsmWcqD/Pxz.ky2e8dn3UWTBQ2ZvN4Si3QkzK7inPem', '2023-02-14 22:37:17'),
('john@gmail.com', 'John', 'Doe', '$2y$10$.qDSH0Kt5i6jmZgOziFJPe.c6qKyF4NCObigVyjZffEZ4ede.cckK', '2023-03-31 23:36:42'),
('laura@gamil.com', 'Laura', 'Taylor', '$2y$10$2PnQULtHBaBmxR.FMTaCaerSmugPPaAqPXEuH9YScKyJK1TwakrhC', '2023-02-15 01:45:37'),
('michael@yahoo.com', 'Michael', 'Smith', '$2y$10$hgjOSuB3.AxjFsFSnS/Qzuudo5qvPGsHVmzrI8ywHPZwJb0uBVfhK', '2023-03-14 20:42:15'),
('michelle@gmail.com', 'Michelle', 'Chan', 'Michelle@12', '2023-05-02 00:06:54'),
('name1@gmail.com', 'Name 1', 'Testing', '$2y$10$7gUExs92yWTFyWs5cyE1kuYI61bTOOE.vHY2Iq2sa9n2VcWnQaIGq', '2023-05-02 16:00:00'),
('name2@gmail.com', 'Name 2', 'Testing', '$2y$10$L0h3sGaJwkXyyLjNjoSqiex.KiJqedwvp.uokO3jtGvmnQrHUMzcq', '2023-05-04 08:07:30'),
('name3@gmail.com', 'Name 3', 'Testing', '$2y$10$jD326liszmITGRmtwQMjK.yTkrVGQe9zExgdoAHRLZwxUxSj6BI5C', '2023-05-02 08:09:00'),
('sarah@gmail.com', 'Sarah', 'Johnson', '$2y$10$GTBA0UJBW9rQgfBs4/.DUeq29MPMLztXBQ0cl0XqAmmI1MpPM9ydC', '2023-04-05 03:41:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_email`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `plandetail`
--
ALTER TABLE `plandetail`
  ADD PRIMARY KEY (`auto_num`),
  ADD KEY `prod_id` (`plan_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `productlog`
--
ALTER TABLE `productlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `u_email` (`u_email`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `trans_sub_id` (`trans_sub_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `plandetail`
--
ALTER TABLE `plandetail`
  MODIFY `auto_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `productlog`
--
ALTER TABLE `productlog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `plan_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`);

--
-- Constraints for table `plandetail`
--
ALTER TABLE `plandetail`
  ADD CONSTRAINT `plandetail_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`),
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`u_email`) REFERENCES `user` (`u_email`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`trans_sub_id`) REFERENCES `subscription` (`sub_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
