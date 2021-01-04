-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2021 at 09:50 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `fds_ctlog`
--

CREATE TABLE `fds_ctlog` (
  `ctlog_id` int(11) NOT NULL,
  `ctlog_usrdt_id` int(11) DEFAULT NULL,
  `ctlog_nme` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_prc` double DEFAULT NULL,
  `ctlog_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_shp` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_img` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_log` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fds_ctlog`
--

INSERT INTO `fds_ctlog` (`ctlog_id`, `ctlog_usrdt_id`, `ctlog_nme`, `ctlog_prc`, `ctlog_desc`, `ctlog_shp`, `ctlog_img`, `ctlog_log`) VALUES
(1, 2, 'mee goreng', 12.9, 'mee goreng dari timur tengah', 'makcik kiah', '2_mee-goreng2.jpg', '2020/12/26 22:30pm'),
(3, 2, 'nasi goreng ayam', 14.9, 'nasi goreng dari jawa tengah', 'makcik kiah', '0008019_nasi-goreng-ayam.jpeg', '2020/12/26 22:32pm'),
(4, 2, 'nasi goreng pattaya', 12.9, 'nasi goreng dari jawa tengah', 'makcik kiah', 'nasi-goreng-pattaya.jpg', '2020/12/26 22:31pm'),
(6, 4, 'kuey tiew basah kungfu', 8.5, 'kuey tiew tiau kungfu hustle dari japang', 'damm', '2_mee-goreng2.jpg', '2020/12/26 22:46pm');

-- --------------------------------------------------------

--
-- Table structure for table `fds_inv`
--

CREATE TABLE `fds_inv` (
  `inv_id` int(11) NOT NULL,
  `inv_ordr_id` int(11) DEFAULT NULL,
  `inv_pay_stat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `inv_amt` double DEFAULT NULL,
  `inv_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `inv_dte` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fds_inv`
--

INSERT INTO `fds_inv` (`inv_id`, `inv_ordr_id`, `inv_pay_stat`, `inv_amt`, `inv_type`, `inv_dte`) VALUES
(7, 3, 'paid', 25.8, 'paypal', '2021/01/05 00:08am'),
(8, 4, 'paid', 29.8, 'paypal', '2021/01/05 00:08am'),
(9, 5, 'none', 25.8, 'cash', '2021/01/05 05:15am'),
(10, 6, 'none', 17, 'cash', '2021/01/05 05:15am'),
(11, 7, 'none', 12.9, 'cash', '2021/01/05 05:29am'),
(12, 8, 'none', 14.9, 'cash', '2021/01/05 05:29am');

-- --------------------------------------------------------

--
-- Table structure for table `fds_ordr`
--

CREATE TABLE `fds_ordr` (
  `ordr_id` int(11) NOT NULL,
  `ordr_usrdt_id` int(11) DEFAULT NULL,
  `ordr_ctlog_id` int(11) DEFAULT NULL,
  `ordr_qty` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordr_dte` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordr_stat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fds_ordr`
--

INSERT INTO `fds_ordr` (`ordr_id`, `ordr_usrdt_id`, `ordr_ctlog_id`, `ordr_qty`, `ordr_dte`, `ordr_stat`) VALUES
(3, 16, 1, '2', '2021/01/05 00:08am', 'Completed'),
(4, 16, 3, '2', '2021/01/05 00:08am', 'Completed'),
(5, 1, 1, '2', '2021/01/05 05:15am', 'Completed'),
(6, 1, 6, '2', '2021/01/05 05:15am', 'Completed'),
(7, 1, 1, '1', '2021/01/05 05:29am', 'Preparing'),
(8, 1, 3, '1', '2021/01/05 05:29am', 'Preparing');

-- --------------------------------------------------------

--
-- Table structure for table `fds_usrdt`
--

CREATE TABLE `fds_usrdt` (
  `usrdt_id` int(11) NOT NULL,
  `usrdt_nme` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_usr` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_pwd` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_adrs` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_stat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_log` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fds_usrdt`
--

INSERT INTO `fds_usrdt` (`usrdt_id`, `usrdt_nme`, `usrdt_usr`, `usrdt_pwd`, `usrdt_adrs`, `usrdt_stat`, `usrdt_log`) VALUES
(1, 'adam mikail', 'adam', '1d7c2923c1684726dc23d2901c4d8157', 'lingkaran 5 jalan batu sinar 11 bukit kepong', 'user', '2020/11/25 23:09pm'),
(2, 'makcik kiah', 'kiah', '0b79eec866e9be97a8fc9fe9955853fd', 'no 87 jalan lingkaran emas 6 bukit kepong', 'shop', '2020/11/26 00:36am'),
(4, 'damm', 'damm', '0cb0241e3244dd88a346f9d853d8836a', 'no 3 jalan perniagaan 2 bandar dato onn', 'shop', '2020/11/26 00:40am'),
(15, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '2020/12/26 22:33pm'),
(16, 'adam aiman', 'adamny', '3da5debc3095c0761563003ede880b8c', 'no 28 jalan perjiranan 2/12 bandar dato onn', 'user', '2020/12/26 23:02pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fds_ctlog`
--
ALTER TABLE `fds_ctlog`
  ADD PRIMARY KEY (`ctlog_id`),
  ADD KEY `ctlog_usrdt_id` (`ctlog_usrdt_id`);

--
-- Indexes for table `fds_inv`
--
ALTER TABLE `fds_inv`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `inv_ordr_id` (`inv_ordr_id`);

--
-- Indexes for table `fds_ordr`
--
ALTER TABLE `fds_ordr`
  ADD PRIMARY KEY (`ordr_id`),
  ADD KEY `ordr_usrdt_id` (`ordr_usrdt_id`),
  ADD KEY `ordr_ctlog_id` (`ordr_ctlog_id`);

--
-- Indexes for table `fds_usrdt`
--
ALTER TABLE `fds_usrdt`
  ADD PRIMARY KEY (`usrdt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fds_ctlog`
--
ALTER TABLE `fds_ctlog`
  MODIFY `ctlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fds_inv`
--
ALTER TABLE `fds_inv`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fds_ordr`
--
ALTER TABLE `fds_ordr`
  MODIFY `ordr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fds_usrdt`
--
ALTER TABLE `fds_usrdt`
  MODIFY `usrdt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fds_ctlog`
--
ALTER TABLE `fds_ctlog`
  ADD CONSTRAINT `fds_ctlog_ibfk_1` FOREIGN KEY (`ctlog_usrdt_id`) REFERENCES `fds_usrdt` (`usrdt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fds_inv`
--
ALTER TABLE `fds_inv`
  ADD CONSTRAINT `fds_inv_ibfk_1` FOREIGN KEY (`inv_ordr_id`) REFERENCES `fds_ordr` (`ordr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fds_ordr`
--
ALTER TABLE `fds_ordr`
  ADD CONSTRAINT `fds_ordr_ibfk_1` FOREIGN KEY (`ordr_ctlog_id`) REFERENCES `fds_ctlog` (`ctlog_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fds_ordr_ibfk_2` FOREIGN KEY (`ordr_usrdt_id`) REFERENCES `fds_usrdt` (`usrdt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
