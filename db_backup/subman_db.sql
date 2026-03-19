-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2026 at 10:56 AM
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
-- Database: `subman_db`
--
CREATE DATABASE IF NOT EXISTS `subman_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `subman_db`;

-- --------------------------------------------------------

--
-- Table structure for table `agreements`
--

CREATE TABLE `agreements` (
  `id` int(32) NOT NULL,
  `vendorID` int(32) NOT NULL,
  `process` int(32) NOT NULL,
  `styleOrderID` int(32) NOT NULL,
  `pcsPerSet` int(32) NOT NULL,
  `contractTotalQty` int(32) NOT NULL,
  `dailyQty` int(32) NOT NULL,
  `startedDate` date NOT NULL,
  `endDate` date NOT NULL,
  `creditPeriod` int(32) NOT NULL,
  `unitPriceFg` double NOT NULL,
  `unitPriceSample` double NOT NULL,
  `Status` varchar(20) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `approvedBy` int(32) DEFAULT NULL,
  `approvedDT` datetime DEFAULT NULL,
  `canceledBy` int(32) DEFAULT NULL,
  `canceledDT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agreements`
--

INSERT INTO `agreements` (`id`, `vendorID`, `process`, `styleOrderID`, `pcsPerSet`, `contractTotalQty`, `dailyQty`, `startedDate`, `endDate`, `creditPeriod`, `unitPriceFg`, `unitPriceSample`, `Status`, `createdDT`, `createdBy`, `approvedBy`, `approvedDT`, `canceledBy`, `canceledDT`) VALUES
(1, 101, 1, 1, 2, 5000, 100, '2026-02-13', '2026-05-23', 30, 30, 20, 'Cancelled', '2026-02-13 12:39:43', 1001, 1001, '2026-03-16 16:28:37', 1001, '2026-03-17 10:49:26'),
(2, 102, 1, 1, 2, 5000, 300, '2026-02-13', '2026-04-20', 0, 35, 35, 'Cancelled', '2026-02-13 12:41:39', 1001, NULL, NULL, 1001, '2026-03-17 10:56:13'),
(3, 102, 1, 1, 2, 3500, 300, '2026-02-13', '2026-04-20', 0, 35, 35, 'Approved', '2026-02-13 12:45:36', 1001, 1001, '2026-03-18 17:13:02', NULL, NULL),
(4, 101, 1, 1, 2, 10000, 30, '2026-03-08', '2028-06-18', 30, 150, 30, 'Approved', '2026-03-08 22:13:37', 1002, 1001, '2026-03-18 17:15:39', NULL, NULL),
(5, 101, 1, 1, 2, 2, 600, '2026-03-19', '2026-03-19', 30, 100, 75, 'Approved', '2026-03-19 10:55:58', 1001, 1001, '2026-03-19 10:56:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyerID` int(32) NOT NULL,
  `buyerCode` varchar(50) NOT NULL,
  `buyerName` varchar(100) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `brNo` varchar(50) DEFAULT NULL,
  `vatNo` varchar(50) DEFAULT NULL,
  `contactPerson` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyerID`, `buyerCode`, `buyerName`, `address`, `tel`, `fax`, `brNo`, `vatNo`, `contactPerson`, `email`, `status`, `createdDT`, `createdBy`) VALUES
(1, 'B001', 'dsfsdfdsfds', 'sdf sdf sdf sdf', '0778520129', '656565', 'sdf35356', '35321-7000', 'A.D. Janaka Ruwan Kumara', 'janakark09@gmail.com', 'Active', '2026-02-11 12:12:10', 1001),
(2, 'B002', 'dfg gdfg', '301/A, Owitiyagala, Horana.', '0778520129', '656565', 'sdf35356', '6546-7000', 'A.D. Janaka Ruwan Kumara', 'janakark09@gmail.com', 'Active', '2026-02-11 12:13:22', 1001),
(3, 'RA123', 'RASIKA', 'BANDARAGAMA', '0768244682', '123', '123', '123', 'Rasika Handunge', 'rasikah@originalapparel.lk', 'Active', '2026-03-19 14:08:57', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `gatepass`
--

CREATE TABLE `gatepass` (
  `gatepassID_1` int(32) NOT NULL,
  `gatepassID_2` varchar(100) NOT NULL,
  `locationID` int(32) NOT NULL,
  `orderNoID` int(32) NOT NULL,
  `gatepassDate` date NOT NULL,
  `vendorID` int(32) NOT NULL,
  `orderAgreement` int(32) NOT NULL,
  `status` varchar(20) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `approvedBy` int(32) DEFAULT NULL,
  `approvedDT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatepass`
--

INSERT INTO `gatepass` (`gatepassID_1`, `gatepassID_2`, `locationID`, `orderNoID`, `gatepassDate`, `vendorID`, `orderAgreement`, `status`, `createdDT`, `createdBy`, `approvedBy`, `approvedDT`) VALUES
(11, '1-260302', 1, 1, '2026-03-04', 102, 2, 'Approved', '2026-03-02 21:59:33', 1001, 1001, '2026-03-03 20:26:30'),
(12, '1-260303', 1, 1, '2026-02-27', 102, 3, 'Approved', '2026-03-03 15:50:50', 1001, 1001, '2026-03-03 17:46:41');

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_details`
--

CREATE TABLE `gatepass_details` (
  `id` bigint(32) NOT NULL,
  `gpID` int(32) NOT NULL,
  `cutNo` varchar(50) NOT NULL,
  `colorID` int(11) NOT NULL,
  `sizeID` int(11) NOT NULL,
  `matQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatepass_details`
--

INSERT INTO `gatepass_details` (`id`, `gpID`, `cutNo`, `colorID`, `sizeID`, `matQty`) VALUES
(11, 11, '3', 1, 2, 100),
(16, 11, '3', 1, 2, 100),
(17, 11, '3', 1, 2, 100),
(18, 11, '3', 1, 2, 100),
(19, 12, '4', 4, 2, 20),
(20, 12, '4', 4, 2, 20),
(21, 12, '4', 2, 2, 10),
(22, 12, '4', 4, 2, 20),
(23, 12, '4', 4, 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `grn_details`
--

CREATE TABLE `grn_details` (
  `grnCode1` int(32) NOT NULL,
  `grnCode2` varchar(10) NOT NULL,
  `proRecNo` int(32) NOT NULL,
  `locationID` int(32) NOT NULL,
  `VendorID` int(32) NOT NULL,
  `invoiceDate` date NOT NULL,
  `invoiceNo` varchar(50) NOT NULL,
  `recFnishedQty` double DEFAULT NULL,
  `fgUnitPrice` double DEFAULT NULL,
  `fgValue` double DEFAULT NULL,
  `recDamQty` double DEFAULT NULL,
  `sampleUnitPrice` double NOT NULL,
  `sampleValue` double NOT NULL,
  `recSampleQty` double NOT NULL,
  `vat` double NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `status` varchar(50) NOT NULL,
  `approvedBy` int(32) DEFAULT NULL,
  `approvedDT` datetime DEFAULT NULL,
  `receiptID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grn_details`
--

INSERT INTO `grn_details` (`grnCode1`, `grnCode2`, `proRecNo`, `locationID`, `VendorID`, `invoiceDate`, `invoiceNo`, `recFnishedQty`, `fgUnitPrice`, `fgValue`, `recDamQty`, `sampleUnitPrice`, `sampleValue`, `recSampleQty`, `vat`, `createdDT`, `createdBy`, `status`, `approvedBy`, `approvedDT`, `receiptID`) VALUES
(22, '2026', 2, 1, 102, '2026-03-11', '121212', 150, 125, 18750, 8, 100, 400, 4, 0, '2026-03-07 14:46:44', 1002, 'Approved', 1002, '2026-03-07 15:39:33', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `grn_details1`
--

CREATE TABLE `grn_details1` (
  `prodetailsID` int(32) NOT NULL,
  `grnNo` int(32) NOT NULL,
  `recFinQty` double DEFAULT NULL,
  `recDamQty` double DEFAULT NULL,
  `SampleQty` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grn_details1`
--

INSERT INTO `grn_details1` (`prodetailsID`, `grnNo`, `recFinQty`, `recDamQty`, `SampleQty`) VALUES
(2, 22, 70, 5, 1),
(3, 22, 30, 3, 3),
(4, 22, 50, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mast_location`
--

CREATE TABLE `mast_location` (
  `locationID` int(32) NOT NULL,
  `location` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `status` text NOT NULL,
  `createdBy` int(32) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mast_location`
--

INSERT INTO `mast_location` (`locationID`, `location`, `address`, `status`, `createdBy`, `createdDT`) VALUES
(1, 'Original Apparel - Unit1', 'Welmilla, Bandaragama', 'Active', 1001, '2026-02-03 13:25:36'),
(2, 'Original Apparel - Unit2', 'Welmilla, Bandaragama', 'Active', 1001, '2026-02-03 13:31:44'),
(3, 'Original Apparel - Weeravila', 'Weeravila Junction, weeravila', 'Active', 1001, '2026-02-03 13:33:12'),
(4, 'Original Apparel - Hanguranketha', 'Hanguranketha', 'Active', 1001, '2026-02-03 13:35:09'),
(5, 'Other1', 'sdfds', 'Active', 1001, '2026-02-03 14:13:16'),
(6, 'other2', 'sdfds', 'Active', 1001, '2026-02-03 14:15:11'),
(7, 'other3', 'sdfsf', 'Active', 1001, '2026-02-03 17:42:38'),
(8, 'other4', 'sghgh', 'Active', 1001, '2026-02-03 17:45:47'),
(9, 'other5', 'lkl', 'Active', 1001, '2026-02-03 17:47:07'),
(10, 'other6', 'jhg', 'Active', 1001, '2026-02-03 17:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(32) NOT NULL,
  `user` int(32) NOT NULL,
  `description` varchar(500) NOT NULL,
  `attUser` int(32) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `NotifyStatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user`, `description`, `attUser`, `createdDT`, `NotifyStatus`) VALUES
(1, 1001, 'Logged', 1001, '2026-03-18 11:43:23', 0),
(2, 1002, 'logout', 1001, '2026-03-18 12:12:57', 1),
(3, 1001, 'Agreement No:  4 has been approved by System Admin.', 1002, '2026-03-18 17:15:39', 1),
(4, 1001, 'Agreement No:  5 has been approved by System Admin.', 1001, '2026-03-19 10:56:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_plan`
--

CREATE TABLE `order_plan` (
  `orderID` int(32) NOT NULL,
  `setPieces` int(32) NOT NULL,
  `subDuration` int(32) NOT NULL,
  `vendor` int(32) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `planStatus` varchar(20) NOT NULL,
  `plannedBy` int(32) NOT NULL,
  `plannedDT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_plan`
--

INSERT INTO `order_plan` (`orderID`, `setPieces`, `subDuration`, `vendor`, `startDate`, `endDate`, `planStatus`, `plannedBy`, `plannedDT`) VALUES
(1, 2, 100, 101, '2026-02-19', '2026-02-19', 'Confirmed', 1001, '2026-02-19 20:25:58'),
(3, 2, 500, 102, '2025-04-07', '2026-08-20', 'Confirmed', 1001, '2026-03-19 11:53:59'),
(4, 2, 200, 101, '2025-09-12', '2026-03-31', 'Pending', 1001, '2026-03-19 14:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `receiptID` int(32) NOT NULL,
  `date` datetime NOT NULL,
  `VendorID` int(32) NOT NULL,
  `payMenthod` int(32) NOT NULL,
  `accountdetails` varchar(50) DEFAULT NULL,
  `refNo` varchar(50) DEFAULT NULL,
  `grossValue` double DEFAULT NULL,
  `vat` double NOT NULL,
  `vatValue` double NOT NULL,
  `netValue` double NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `approvedBy` int(32) DEFAULT NULL,
  `approvedDT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`receiptID`, `date`, `VendorID`, `payMenthod`, `accountdetails`, `refNo`, `grossValue`, `vat`, `vatValue`, `netValue`, `createdDT`, `createdBy`, `Status`, `approvedBy`, `approvedDT`) VALUES
(1001, '2026-03-09 00:00:00', 102, 1, 'sad', '365665', 19150, 18, 3447, 22597, '2026-03-08 08:59:59', 1002, 'Approved', 1002, '2026-03-08 09:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `methodID` int(32) NOT NULL,
  `paymethod` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`methodID`, `paymethod`, `status`) VALUES
(1, 'Cheque', 1),
(2, 'At site', 1),
(3, 'Bank Deposit', 1),
(4, 'Bank Transfer', 1),
(5, 'COD', 1),
(6, 'FOC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `process_type`
--

CREATE TABLE `process_type` (
  `typeid` int(32) NOT NULL,
  `processType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `process_type`
--

INSERT INTO `process_type` (`typeid`, `processType`) VALUES
(1, 'WASHING');

-- --------------------------------------------------------

--
-- Table structure for table `styleorder`
--

CREATE TABLE `styleorder` (
  `id` int(32) NOT NULL,
  `styleNo` varchar(50) NOT NULL,
  `orderNo` varchar(100) NOT NULL,
  `orderQty` int(32) NOT NULL,
  `division` varchar(50) NOT NULL,
  `proCategory` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `deliveryDate` date NOT NULL,
  `Status` varchar(20) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `styleorder`
--

INSERT INTO `styleorder` (`id`, `styleNo`, `orderNo`, `orderQty`, `division`, `proCategory`, `description`, `deliveryDate`, `Status`, `createdDT`, `createdBy`) VALUES
(1, 'GBHD0235', '0025632', 50000, '', '', 'sdfsdf sd f', '2026-05-21', 'Active', '2026-02-11 18:15:29', 1001),
(2, 'HGH00235', '100035', 65000, '', '', 'sdf dsf sdf sd', '2026-06-19', 'Active', '2026-02-19 21:15:34', 1001),
(3, 'GBHD0235', '2566656', 60000, 'Ladies', '', ' sdasd a dasdasd asdasd', '2026-08-20', 'Active', '2026-03-19 11:26:41', 1001),
(4, '123', 'OA123', 1000, 'Ladies', '', 'BLOUSE', '2026-03-31', 'Active', '2026-03-19 14:10:33', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

CREATE TABLE `styles` (
  `styleNo` varchar(50) NOT NULL,
  `styleName` varchar(50) NOT NULL,
  `buyerID` int(32) NOT NULL,
  `createdBy` int(32) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`styleNo`, `styleName`, `buyerID`, `createdBy`, `createdDT`, `status`) VALUES
('123', '123RA', 3, 1001, '2026-03-19 14:09:36', 'Active'),
('FDF02253', 'dsfsd sdf s', 1, 1001, '2026-03-19 10:58:14', 'Active'),
('GBHD0235', 'dsf sdfsdfhfg fghfgh', 2, 1001, '2026-02-11 17:11:48', 'Active'),
('HGH00235', 'sadas as asd sad', 1, 1001, '2026-02-19 21:07:56', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `style_colors`
--

CREATE TABLE `style_colors` (
  `colorID` int(32) NOT NULL,
  `color` varchar(100) NOT NULL,
  `orderNoID` int(32) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `style_colors`
--

INSERT INTO `style_colors` (`colorID`, `color`, `orderNoID`, `active`) VALUES
(1, 'BLUE', 1, 1),
(2, 'RED', 1, 1),
(3, 'BLACK', 1, 0),
(4, 'PINK', 1, 1),
(5, 'BROWN', 1, 1),
(9, 'PRINT', 1, 0),
(10, 'RED', 4, 1),
(11, 'BLUE', 4, 1),
(12, 'BLACK', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `style_sizes`
--

CREATE TABLE `style_sizes` (
  `sizeID` int(32) NOT NULL,
  `size` varchar(50) NOT NULL,
  `orderNoID` int(32) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `style_sizes`
--

INSERT INTO `style_sizes` (`sizeID`, `size`, `orderNoID`, `active`) VALUES
(1, '30', 1, 1),
(2, '25', 1, 1),
(3, '10', 1, 1),
(4, 'S', 4, 1),
(5, 'L', 4, 1),
(6, 'XL', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_production`
--

CREATE TABLE `sub_production` (
  `recordID` int(32) NOT NULL,
  `gatepassRefID` varchar(100) NOT NULL,
  `orderNoID` int(32) NOT NULL,
  `gatepassDate` date NOT NULL,
  `locationID` int(32) NOT NULL,
  `vendorID` int(32) NOT NULL,
  `orderAgreement` int(32) NOT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `cratedDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `approvedBy` int(32) DEFAULT NULL,
  `approvedDT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_production`
--

INSERT INTO `sub_production` (`recordID`, `gatepassRefID`, `orderNoID`, `gatepassDate`, `locationID`, `vendorID`, `orderAgreement`, `comments`, `status`, `cratedDT`, `createdBy`, `approvedBy`, `approvedDT`) VALUES
(2, '365665', 1, '2026-03-12', 2, 102, 2, 'fdgfd fd gfd gfdgfdgtrtf  hgf hfg', 'Approved', '2026-03-03 22:54:27', 1002, 1001, '2026-03-18 17:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `sub_pro_details`
--

CREATE TABLE `sub_pro_details` (
  `id` int(32) NOT NULL,
  `recID` int(32) NOT NULL,
  `cutNo` varchar(50) NOT NULL,
  `colorID` int(32) NOT NULL,
  `sizeID` int(32) NOT NULL,
  `finishedQty` double DEFAULT NULL,
  `fabDamQty` double DEFAULT NULL,
  `processDamQty` double DEFAULT NULL,
  `sampleQty` double DEFAULT NULL,
  `recFnishedQty` double DEFAULT NULL,
  `recDamQty` double DEFAULT NULL,
  `recSampleQty` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_pro_details`
--

INSERT INTO `sub_pro_details` (`id`, `recID`, `cutNo`, `colorID`, `sizeID`, `finishedQty`, `fabDamQty`, `processDamQty`, `sampleQty`, `recFnishedQty`, `recDamQty`, `recSampleQty`) VALUES
(1, 2, '3', 1, 1, 100, 10, 3, 3, 100, 13, 3),
(2, 2, '3', 1, 1, 100, 10, 3, 3, NULL, 13, 2),
(3, 2, '3', 1, 1, 100, 10, 3, 3, 100, NULL, NULL),
(4, 2, '3', 1, 1, 100, 10, 3, 3, 80, 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(32) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) DEFAULT NULL,
  `fullName` varchar(50) NOT NULL,
  `User_Type` varchar(30) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Member_Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Name`, `Email`, `Fname`, `Lname`, `fullName`, `User_Type`, `Password`, `Member_Status`) VALUES
(1001, 'admin', 'it@originalapparel.lk', 'System', 'Admin', 'System Admin', 'administrator', '202cb962ac59075b964b07152d234b70', 'Active'),
(1002, 'janakar', 'janakark09@gmail.com', 'A.D.', 'Kumara', 'A.D. Janaka Ruwan Kumara', 'Subcontractor', '202cb962ac59075b964b07152d234b70', 'Active'),
(1003, 'testuser', 'test@originalapparel.lk', 'Test', 'User', 'Test User', 'Employee', '202cb962ac59075b964b07152d234b70', 'Active'),
(1004, 'nimals', 'sdfsdfs@dsfsdf.lk', 'Nimal', 'Shantha', 'Numal Shantha', 'Subcontractor', '202cb962ac59075b964b07152d234b70', 'Active'),
(1005, 'user6', 'sdfsdf@dsfsdf.lk', 'user6', 'user6', ' sdfsd', 'administrator', '202cb962ac59075b964b07152d234b70', 'Active'),
(1006, 'fghfgh', 'fghfg@fdgdrf.lk', 'fthfg', 'fgh', 'fghfg', 'administrator', '202cb962ac59075b964b07152d234b70', 'Active'),
(1007, 'user7', 'fghfg@fdgdfgxx.lk', 'user7xxx', 'user7xxxx', 'fhg fgh fgh xxx', 'Employee', 'caf1a3dfb505ffed0d024130f58c5cfa', 'Active'),
(1008, 'subcon1', 'sadd@dsfsd.lk', 'subcon1', 'sda', 'asd', 'Subcontractor', '202cb962ac59075b964b07152d234b70', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `User_ID` int(32) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `TelNumber` varchar(10) NOT NULL,
  `Joined_Date` date NOT NULL DEFAULT current_timestamp(),
  `locationID` int(32) DEFAULT NULL,
  `venderID` int(32) DEFAULT NULL,
  `acc1` tinyint(1) DEFAULT NULL COMMENT 'Dashboard',
  `acc2` tinyint(1) DEFAULT NULL COMMENT 'Merchandising',
  `acc3` tinyint(1) DEFAULT NULL COMMENT 'Buyers Management',
  `acc4` tinyint(1) DEFAULT NULL COMMENT 'Style Order Management',
  `acc5` tinyint(1) DEFAULT NULL COMMENT 'Merchandising Approvals',
  `acc6` tinyint(1) DEFAULT NULL COMMENT 'Planning',
  `acc7` tinyint(1) DEFAULT NULL COMMENT 'Confirm Planning',
  `acc8` tinyint(1) DEFAULT NULL COMMENT 'Subcontractor Management',
  `acc9` tinyint(1) DEFAULT NULL COMMENT 'Agreements',
  `acc10` tinyint(1) DEFAULT NULL COMMENT 'Approve Agreements',
  `acc11` tinyint(1) DEFAULT NULL COMMENT 'Gate Passes',
  `acc12` tinyint(1) DEFAULT NULL COMMENT 'GatePass List',
  `acc13` tinyint(1) DEFAULT NULL COMMENT 'GatePass Approval',
  `acc14` tinyint(1) DEFAULT NULL COMMENT 'Pro Rec',
  `acc15` tinyint(1) DEFAULT NULL COMMENT 'Pro Rec List',
  `acc16` tinyint(1) DEFAULT NULL COMMENT 'Pro Rec Approve',
  `acc17` tinyint(1) DEFAULT NULL COMMENT 'GRN',
  `acc18` tinyint(1) DEFAULT NULL COMMENT 'GRN Listing',
  `acc19` tinyint(1) DEFAULT NULL COMMENT 'GRN Approval',
  `acc20` tinyint(1) DEFAULT NULL COMMENT 'Payment Receipt',
  `acc21` tinyint(1) DEFAULT NULL COMMENT 'Payment list',
  `acc22` tinyint(1) DEFAULT NULL COMMENT 'Payment Approve',
  `acc23` tinyint(1) DEFAULT NULL COMMENT 'Reports',
  `acc24` tinyint(1) DEFAULT NULL COMMENT 'User',
  `acc25` tinyint(1) DEFAULT NULL COMMENT 'Location'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`User_ID`, `Address`, `TelNumber`, `Joined_Date`, `locationID`, `venderID`, `acc1`, `acc2`, `acc3`, `acc4`, `acc5`, `acc6`, `acc7`, `acc8`, `acc9`, `acc10`, `acc11`, `acc12`, `acc13`, `acc14`, `acc15`, `acc16`, `acc17`, `acc18`, `acc19`, `acc20`, `acc21`, `acc22`, `acc23`, `acc24`, `acc25`) VALUES
(1001, 'Bandaragama', '0778520129', '2026-02-02', 1, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(1002, '301/A, Owitiyagala, Horana.', '0778520129', '2026-02-05', 1, 102, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1003, 'Bandaragama', '0778520129', '2026-02-09', 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1004, 'dsf dsf sdf sdf', '354356356', '2026-03-03', 0, 101, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1005, ' sdf sdf sdfsdf', '35435465', '2026-03-08', 2, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1006, 'fghfgh', 'fhgjfg', '2026-03-08', 9, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1007, 'f gh fgh xxxx', '546565xx', '2026-03-08', 3, 0, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 1, 1, 1, 1, 0, 0),
(1008, 'asdsa', '2546546', '2026-03-08', 0, 102, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `userType` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`userType`, `status`) VALUES
('administrator', 1),
('Employee', 1),
('Subcontractor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendorID` int(32) NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `brNo` varchar(50) DEFAULT NULL,
  `vatNo` varchar(50) DEFAULT NULL,
  `vatPercentage` double NOT NULL,
  `contactPerson` varchar(50) DEFAULT NULL,
  `dailyCapacity` int(32) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendorID`, `vendor`, `address`, `tel`, `fax`, `brNo`, `vatNo`, `vatPercentage`, `contactPerson`, `dailyCapacity`, `email`, `status`, `createdDT`, `createdBy`) VALUES
(101, 'vendor1', 'Bandaragama', '0778520129', '0778520129', 'df354365', '254325-7000', 18, 'Janakaruwan Kumara', 700, 'janakark09@gmail.com', 'Active', '2026-02-10 20:42:20', 1001),
(102, 'Vendor 2', '301/A, Owitiyagala, Horana.', '0778520129', '656565', 'sdf35356', '6546-7000', 18, 'A.D. Janaka Ruwan Kumara', 100, 'janakark09@gmail.com', 'Active', '2026-02-12 17:44:51', 1001),
(103, 'Vendor 3', 'Bandaragama', '0778520129', '0778520129', 'df354365', '254325-7000', 18, 'Janaka Kumara', 100, 'sdfs@sdfsdf.lk', 'Active', '2026-03-19 08:19:04', 1001);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agreements`
--
ALTER TABLE `agreements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Agree_vendor` (`vendorID`),
  ADD KEY `FK_Agree_order` (`styleOrderID`),
  ADD KEY `FK_Agree_Create` (`createdBy`),
  ADD KEY `FK_Agree_type` (`process`),
  ADD KEY `FK_Agree_Apred` (`approvedBy`),
  ADD KEY `FK_Agree_Cancel` (`canceledBy`);

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyerID`),
  ADD KEY `FK_createdUser` (`createdBy`);

--
-- Indexes for table `gatepass`
--
ALTER TABLE `gatepass`
  ADD PRIMARY KEY (`gatepassID_1`),
  ADD KEY `FK_Gatepass_LocID` (`locationID`),
  ADD KEY `FK_Gatepass_Style` (`orderNoID`),
  ADD KEY `FK_Gatepass_Vendor` (`vendorID`),
  ADD KEY `FK_Gatepass_Created` (`createdBy`),
  ADD KEY `FK_Gatepass_Agreement` (`orderAgreement`),
  ADD KEY `FK_Gatepass_Approv` (`approvedBy`);

--
-- Indexes for table `gatepass_details`
--
ALTER TABLE `gatepass_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Gatepass_Color` (`colorID`),
  ADD KEY `FK_Gatepass_Size` (`sizeID`),
  ADD KEY `FK_Gatepass_gp` (`gpID`);

--
-- Indexes for table `grn_details`
--
ALTER TABLE `grn_details`
  ADD PRIMARY KEY (`grnCode1`),
  ADD KEY `FK_Grn_Uid` (`createdBy`),
  ADD KEY `FK_Grn_pro` (`proRecNo`),
  ADD KEY `FK_Grn_loc` (`locationID`),
  ADD KEY `FK_Grn_Appby` (`approvedBy`),
  ADD KEY `FK_Grn_Recept` (`receiptID`);

--
-- Indexes for table `grn_details1`
--
ALTER TABLE `grn_details1`
  ADD KEY `FK_GRN1_Prodetails` (`prodetailsID`),
  ADD KEY `FK_GRN1_grnid` (`grnNo`);

--
-- Indexes for table `mast_location`
--
ALTER TABLE `mast_location`
  ADD PRIMARY KEY (`locationID`),
  ADD KEY `FK_Loc_Uid` (`createdBy`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Notify_user` (`user`),
  ADD KEY `FK_Notify_att` (`attUser`);

--
-- Indexes for table `order_plan`
--
ALTER TABLE `order_plan`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FK_plan_vendor` (`vendor`),
  ADD KEY `FK_plan_user` (`plannedBy`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`receiptID`),
  ADD KEY `FK_Payment_mothod` (`payMenthod`),
  ADD KEY `FK_Payment_user` (`createdBy`),
  ADD KEY `FK_Payment_vendor` (`VendorID`),
  ADD KEY `FK_Payment_appr` (`approvedBy`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`methodID`);

--
-- Indexes for table `process_type`
--
ALTER TABLE `process_type`
  ADD PRIMARY KEY (`typeid`);

--
-- Indexes for table `styleorder`
--
ALTER TABLE `styleorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Style_Create` (`createdBy`),
  ADD KEY `FK_StyleOrder_StyleNo` (`styleNo`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`styleNo`),
  ADD KEY `FK_Style_Buyer` (`buyerID`);

--
-- Indexes for table `style_colors`
--
ALTER TABLE `style_colors`
  ADD PRIMARY KEY (`colorID`),
  ADD KEY `FK_color_orderNo` (`orderNoID`);

--
-- Indexes for table `style_sizes`
--
ALTER TABLE `style_sizes`
  ADD PRIMARY KEY (`sizeID`),
  ADD KEY `FK_size_order` (`orderNoID`);

--
-- Indexes for table `sub_production`
--
ALTER TABLE `sub_production`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `FK_Pro_OrderNo` (`orderNoID`),
  ADD KEY `FK_Pro_Loc` (`locationID`),
  ADD KEY `FK_Pro_Vendor` (`vendorID`),
  ADD KEY `FK_Pro_Agree` (`orderAgreement`),
  ADD KEY `FK_Pro_Create` (`createdBy`),
  ADD KEY `FK_Pro_Approve` (`approvedBy`);

--
-- Indexes for table `sub_pro_details`
--
ALTER TABLE `sub_pro_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Prodtl_Prorec` (`recID`),
  ADD KEY `FK_Prodtl_color` (`colorID`),
  ADD KEY `FK_Prodtl_size` (`sizeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `FK_UserType` (`User_Type`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `FK_UserDetail_LocID` (`locationID`),
  ADD KEY `FK_UserDetail_Ven` (`venderID`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`userType`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendorID`),
  ADD KEY `FK_vendor_created` (`createdBy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agreements`
--
ALTER TABLE `agreements`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyerID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gatepass`
--
ALTER TABLE `gatepass`
  MODIFY `gatepassID_1` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gatepass_details`
--
ALTER TABLE `gatepass_details`
  MODIFY `id` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `grn_details`
--
ALTER TABLE `grn_details`
  MODIFY `grnCode1` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `mast_location`
--
ALTER TABLE `mast_location`
  MODIFY `locationID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `methodID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `process_type`
--
ALTER TABLE `process_type`
  MODIFY `typeid` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `styleorder`
--
ALTER TABLE `styleorder`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `style_colors`
--
ALTER TABLE `style_colors`
  MODIFY `colorID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `style_sizes`
--
ALTER TABLE `style_sizes`
  MODIFY `sizeID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sub_production`
--
ALTER TABLE `sub_production`
  MODIFY `recordID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_pro_details`
--
ALTER TABLE `sub_pro_details`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendorID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agreements`
--
ALTER TABLE `agreements`
  ADD CONSTRAINT `FK_Agree_Apred` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Agree_Cancel` FOREIGN KEY (`canceledBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Agree_Create` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Agree_order` FOREIGN KEY (`styleOrderID`) REFERENCES `styleorder` (`id`),
  ADD CONSTRAINT `FK_Agree_type` FOREIGN KEY (`process`) REFERENCES `process_type` (`typeid`),
  ADD CONSTRAINT `FK_Agree_vendor` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `FK_createdUser` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `gatepass`
--
ALTER TABLE `gatepass`
  ADD CONSTRAINT `FK_Gatepass_Agreement` FOREIGN KEY (`orderAgreement`) REFERENCES `agreements` (`id`),
  ADD CONSTRAINT `FK_Gatepass_Approv` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Gatepass_Created` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Gatepass_LocID` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`),
  ADD CONSTRAINT `FK_Gatepass_Style` FOREIGN KEY (`orderNoID`) REFERENCES `styleorder` (`id`),
  ADD CONSTRAINT `FK_Gatepass_Vendor` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `gatepass_details`
--
ALTER TABLE `gatepass_details`
  ADD CONSTRAINT `FK_Gatepass_Color` FOREIGN KEY (`colorID`) REFERENCES `style_colors` (`colorID`),
  ADD CONSTRAINT `FK_Gatepass_Size` FOREIGN KEY (`sizeID`) REFERENCES `style_sizes` (`sizeID`),
  ADD CONSTRAINT `FK_Gatepass_gp` FOREIGN KEY (`gpID`) REFERENCES `gatepass` (`gatepassID_1`);

--
-- Constraints for table `grn_details`
--
ALTER TABLE `grn_details`
  ADD CONSTRAINT `FK_Grn_Appby` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Grn_Recept` FOREIGN KEY (`receiptID`) REFERENCES `payments` (`receiptID`),
  ADD CONSTRAINT `FK_Grn_Uid` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Grn_loc` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`),
  ADD CONSTRAINT `FK_Grn_pro` FOREIGN KEY (`proRecNo`) REFERENCES `sub_production` (`recordID`);

--
-- Constraints for table `grn_details1`
--
ALTER TABLE `grn_details1`
  ADD CONSTRAINT `FK_GRN1_Prodetails` FOREIGN KEY (`prodetailsID`) REFERENCES `sub_pro_details` (`id`),
  ADD CONSTRAINT `FK_GRN1_grnid` FOREIGN KEY (`grnNo`) REFERENCES `grn_details` (`grnCode1`);

--
-- Constraints for table `mast_location`
--
ALTER TABLE `mast_location`
  ADD CONSTRAINT `FK_Loc_Uid` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_Notify_att` FOREIGN KEY (`attUser`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Notify_user` FOREIGN KEY (`user`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `order_plan`
--
ALTER TABLE `order_plan`
  ADD CONSTRAINT `FK_plan_orderNo` FOREIGN KEY (`orderID`) REFERENCES `styleorder` (`id`),
  ADD CONSTRAINT `FK_plan_user` FOREIGN KEY (`plannedBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_plan_vendor` FOREIGN KEY (`vendor`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `FK_Payment_appr` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Payment_mothod` FOREIGN KEY (`payMenthod`) REFERENCES `payment_methods` (`methodID`),
  ADD CONSTRAINT `FK_Payment_user` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Payment_vendor` FOREIGN KEY (`VendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `styleorder`
--
ALTER TABLE `styleorder`
  ADD CONSTRAINT `FK_StyleOrder_Create` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_StyleOrder_StyleNo` FOREIGN KEY (`styleNo`) REFERENCES `styles` (`styleNo`);

--
-- Constraints for table `styles`
--
ALTER TABLE `styles`
  ADD CONSTRAINT `FK_Style_Buyer` FOREIGN KEY (`buyerID`) REFERENCES `buyer` (`buyerID`);

--
-- Constraints for table `style_colors`
--
ALTER TABLE `style_colors`
  ADD CONSTRAINT `FK_color_orderNo` FOREIGN KEY (`orderNoID`) REFERENCES `styleorder` (`id`);

--
-- Constraints for table `style_sizes`
--
ALTER TABLE `style_sizes`
  ADD CONSTRAINT `FK_size_order` FOREIGN KEY (`orderNoID`) REFERENCES `styleorder` (`id`);

--
-- Constraints for table `sub_production`
--
ALTER TABLE `sub_production`
  ADD CONSTRAINT `FK_Pro_Agree` FOREIGN KEY (`orderAgreement`) REFERENCES `agreements` (`id`),
  ADD CONSTRAINT `FK_Pro_Approve` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Pro_Create` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Pro_Loc` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`),
  ADD CONSTRAINT `FK_Pro_OrderNo` FOREIGN KEY (`orderNoID`) REFERENCES `styleorder` (`id`),
  ADD CONSTRAINT `FK_Pro_Vendor` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `sub_pro_details`
--
ALTER TABLE `sub_pro_details`
  ADD CONSTRAINT `FK_Prodtl_Prorec` FOREIGN KEY (`recID`) REFERENCES `sub_production` (`recordID`),
  ADD CONSTRAINT `FK_Prodtl_color` FOREIGN KEY (`colorID`) REFERENCES `style_colors` (`colorID`),
  ADD CONSTRAINT `FK_Prodtl_size` FOREIGN KEY (`sizeID`) REFERENCES `style_sizes` (`sizeID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_UserType` FOREIGN KEY (`User_Type`) REFERENCES `user_type` (`userType`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `FK_UserDetail_UID` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `FK_vendor_created` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
