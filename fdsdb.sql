-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2020 at 07:42 PM
-- Server version: 8.0.22
-- PHP Version: 7.3.22-(to be removed in future macOS)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `ctlog_id` int NOT NULL,
  `ctlog_nme` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_prc` double DEFAULT NULL,
  `ctlog_desc` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_shp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_log` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fds_ctlog`
--

INSERT INTO `fds_ctlog` (`ctlog_id`, `ctlog_nme`, `ctlog_prc`, `ctlog_desc`, `ctlog_shp`, `ctlog_img`, `ctlog_log`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, '2020/11/26 00:52am');

-- --------------------------------------------------------

--
-- Table structure for table `fds_ordr`
--

CREATE TABLE `fds_ordr` (
  `ordr_id` int NOT NULL,
  `ordr_usrdt_id` int DEFAULT NULL,
  `ordr_ctlog_id` int DEFAULT NULL,
  `ordr_qty` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordr_stat` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fds_usrdt`
--

CREATE TABLE `fds_usrdt` (
  `usrdt_id` int NOT NULL,
  `usrdt_nme` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_usr` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_pwd` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_adrs` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_stat` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_log` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fds_usrdt`
--

INSERT INTO `fds_usrdt` (`usrdt_id`, `usrdt_nme`, `usrdt_usr`, `usrdt_pwd`, `usrdt_adrs`, `usrdt_stat`, `usrdt_log`) VALUES
(1, 'adamny', 'adam', '1d7c2923c1684726dc23d2901c4d8157', 'testing', 'user', '2020/11/25 23:09pm'),
(2, 'tasha', 'tasha', '4496551efcedff7ac1d8e06cc25e915e', 'KK3 CAFE', 'shop', '2020/11/26 00:36am'),
(4, 'damm', 'damm', '0cb0241e3244dd88a346f9d853d8836a', 'KK3 CAFE', 'admin', '2020/11/26 00:40am'),
(5, 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', 'user', '2020/11/26 01:23am'),
(6, 'testt', 'testt', '147538da338b770b61e592afc92b1ee6', 'testt', 'user', '2020/11/26 01:24am'),
(7, 'long', 'long', '0f5264038205edfb1ac05fbb0e8c5e94', 'long', 'user', '2020/11/26 01:32am'),
(8, 'longo', 'longo', 'b8ac74c7539fd534e23cc59b1d478d2d', 'longo', 'user', '2020/11/26 01:37am'),
(9, 'adam', 'adamn', '1d7c2923c1684726dc23d2901c4d8157', 'adam', 'user', '2020/11/26 03:35am'),
(10, 'adam', 'adamn', '1d7c2923c1684726dc23d2901c4d8157', 'adam', 'user', '2020/11/26 03:35am'),
(11, 'adam', 'adamn', '1d7c2923c1684726dc23d2901c4d8157', 'adam', 'user', '2020/11/26 03:35am'),
(12, 'adam', 'adamn', '1d7c2923c1684726dc23d2901c4d8157', 'adam', 'user', '2020/11/26 03:35am'),
(13, 'adam', 'adamn', '1d7c2923c1684726dc23d2901c4d8157', 'adam', 'user', '2020/11/26 03:35am'),
(14, 'adamn', 'adama', '4896be9d0f9da6266f1d6b84401ee701', 'adama', 'user', '2020/11/26 03:39am');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fds_ctlog`
--
ALTER TABLE `fds_ctlog`
  ADD PRIMARY KEY (`ctlog_id`);

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
  MODIFY `ctlog_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fds_ordr`
--
ALTER TABLE `fds_ordr`
  MODIFY `ordr_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fds_usrdt`
--
ALTER TABLE `fds_usrdt`
  MODIFY `usrdt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

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
