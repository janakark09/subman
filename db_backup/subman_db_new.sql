-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2026 at 09:43 AM
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
(1, 101, 5, 1, 2, 20000, 50, '2026-03-25', '2027-04-28', 30, 400, 350, 'Approved', '2026-03-21 15:31:10', 1001, 1001, '2026-03-21 15:40:09', NULL, NULL),
(2, 101, 2, 2, 3, 25000, 100, '2026-03-28', '2026-12-02', 14, 150, 120, 'Cancelled', '2026-03-21 15:39:40', 1001, NULL, NULL, 1001, '2026-03-21 15:42:05');

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
  `createdBy` int(32) NOT NULL,
  `modifiedBy` int(32) DEFAULT NULL,
  `modifiedDT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyerID`, `buyerCode`, `buyerName`, `address`, `tel`, `fax`, `brNo`, `vatNo`, `contactPerson`, `email`, `status`, `createdDT`, `createdBy`, `modifiedBy`, `modifiedDT`) VALUES
(1, 'B001', 'Test Buyer1', 'Bandaragama', '3243565', '326565', 'UP2322', '3232323-7000', 'Anton', 'testbuyer@outlook.com', 'Active', '2026-03-21 13:18:57', 1001, NULL, NULL),
(2, 'B002', 'Test Buyer2', 'piliyandala, sri lanka', '354534654', '323535435', 'df354365', '3232323-7000', 'Ann', 'test@buyer2.lk', 'Active', '2026-03-21 13:19:53', 1001, 1001, '2026-03-21 22:20:07');

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
(1, '1-260321', 1, 1, '2026-03-21', 101, 1, 'Approved', '2026-03-21 15:47:18', 1001, 1001, '2026-03-21 15:49:20'),
(2, '1-260321', 1, 1, '2026-03-22', 101, 1, 'Approved', '2026-03-21 15:48:40', 1001, 1001, '2026-03-21 15:51:43');

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
(1, 1, '1', 1, 1, 300),
(2, 1, '1', 2, 2, 350),
(3, 2, '2', 3, 3, 600),
(4, 2, '2', 2, 1, 350);

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
(1, '2026', 2, 1, 101, '2026-03-21', '23223', 289, 120, 34680, 11, 100, 0, 0, 0, '2026-03-21 16:30:13', 1001, 'Approved', 1001, '2026-03-21 16:35:38', NULL);

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
(3, 1, 35, 0, 0),
(4, 1, 167, 8, 0),
(5, 1, 87, 3, 0);

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
(1, 'Original Apparel - Unit1', 'Welmilla, Bandaragama', 'Active', 1001, '2026-03-21 12:16:29'),
(6, 'Original Apparel - Unit2', 'Welmilla, Bandaragama', 'Active', 1001, '2026-03-21 12:25:52'),
(7, 'Original Apparel - Hanguranketha', 'Hanguranketha, Kandy', 'Active', 1001, '2026-03-21 12:26:05'),
(8, 'Original Apparel - Weeravila', 'Weeravila Junction, weeravila', 'Active', 1001, '2026-03-21 12:26:17');

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
(1, 1001, 'Agreement No:  1 has been approved by System Admin.', 1001, '2026-03-21 15:40:09', 0),
(2, 1001, 'Agreement No:  2 has been cancelled by System Admin.', 1001, '2026-03-21 15:42:05', 0),
(3, 1001, 'Gatepass No:  1 has been approved by System Admin.', 1001, '2026-03-21 15:49:20', 0),
(4, 1001, 'Gatepass No:  2 has been approved by System Admin.', 1001, '2026-03-21 15:51:43', 0),
(5, 1002, 'Production Record No:  2 has been approved by Nihal Perera.', 1002, '2026-03-21 16:14:59', 0),
(6, 1002, 'Production Record No:  1 has been approved by Nihal Perera.', 1002, '2026-03-21 16:18:13', 0),
(7, 1001, 'GRN No:  1 has been approved by System Admin.', 1001, '2026-03-21 16:35:38', 0),
(8, 1001, 'Payment No:  1001 has been approved by System Admin.', 1001, '2026-03-21 16:40:21', 0);

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
(2, 3, 500, 102, '2025-03-18', '2026-07-31', 'Pending', 1001, '2026-03-21 15:18:46');

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
(1, 'WASHING'),
(2, 'PLEATING'),
(3, 'SMOCKING'),
(4, 'SEWING'),
(5, 'PRINTING'),
(6, 'EMBROIDERY'),
(7, 'HANDWORK');

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
(1, 'FDF02253', '0025632', 50000, 'Ladies', '', 'Ladies Upper Pink Color', '2026-08-22', 'Active', '2026-03-21 13:41:12', 1001),
(2, 'HGH00276', '2566656', 75000, 'Kids', 'BODY SUITE', 'Kids Blue color body suite', '2026-07-31', 'Active', '2026-03-21 13:43:48', 1001);

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
('FDF02253', 'test style1', 1, 1001, '2026-03-21 13:37:37', 'Active'),
('HGH00276', 'test style2', 2, 1001, '2026-03-21 13:37:54', 'Active');

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
(1, 'PINK', 1, 1),
(2, 'BLACK', 1, 1),
(3, 'BLUE', 1, 1),
(4, 'BLACK', 2, 1),
(5, 'PRINTED', 2, 1),
(6, 'RED', 2, 1);

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
(1, 'Large', 1, 1),
(2, 'small', 1, 1),
(3, 'Medium ', 1, 1),
(6, '10', 2, 1),
(7, '12', 2, 1),
(8, '16', 2, 1);

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
(1, 'TES0001', 1, '2026-04-10', 1, 101, 1, '', 'Approved', '2026-03-21 16:13:03', 1002, 1002, '2026-03-21 16:18:13'),
(2, 'TES0002', 1, '2026-04-17', 1, 101, 1, 'test remarks', 'Approved', '2026-03-21 16:14:24', 1002, 1002, '2026-03-21 16:14:59');

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
(1, 1, '1', 1, 2, 100, 3, 2, 1, 0, 0, 0),
(2, 1, '1', 3, 1, 127, 0, 0, 3, 0, 0, 0),
(3, 2, '2', 1, 1, 35, 0, 0, 0, 35, 0, 0),
(4, 2, '2', 3, 3, 167, 5, 3, 0, 167, 8, 0),
(5, 2, '2', 2, 2, 87, 3, 0, 0, 87, 3, 0);

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
(1002, 'nihalp', 'test@nihal.lk', 'Nihal', 'Perera', 'B.H. Nihal Perera', 'Subcontractor', 'caf1a3dfb505ffed0d024130f58c5cfa', 'Active'),
(1003, 'janakar', 'janakar@originalapparel.lk', 'Janaka', 'Kumara', 'Janaka Kumara', 'Employee', '0e7517141fb53f21ee439b355b5a1d0a', 'Active');

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
(1001, 'Bandaragama\r\n', '0778520129', '2026-03-21', 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(1002, '301/A, Owitiyagala, Horana.', '0123456789', '2026-03-21', 0, 101, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0),
(1003, '301/A, Owitiyagala, Horana.', '0778520129', '2026-03-21', 1, 0, 1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 0, 0);

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
(101, 'Test Subcontractor 1', 'Bandaragama, Sri lanka', '0123456789', '0123456789', 'PV0235', '3232323-7000', 18, 'Kamal', 300, 'test@sucontractor.com', 'Active', '2026-03-21 12:38:46', 1001),
(102, 'Test Subcontractor 2', 'Piliyandala, Sri lanka', '46565', '53643465', 'PV0023665', '555454-7000', 18, 'Nihal', 100, 'info@test1.lk', 'Active', '2026-03-21 12:40:06', 1001),
(103, 'Vendor 1', 'sdf sdf sdf sdf', '0123456789', '53643465', 'df354365', '35435-7000', 18, 'test', 150, 'test2@test2.lk', 'Active', '2026-03-21 12:40:55', 1001);

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
  ADD KEY `FK_createdUser` (`createdBy`),
  ADD KEY `FK_buyer_modify` (`modifiedBy`);

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
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyerID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gatepass`
--
ALTER TABLE `gatepass`
  MODIFY `gatepassID_1` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gatepass_details`
--
ALTER TABLE `gatepass_details`
  MODIFY `id` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grn_details`
--
ALTER TABLE `grn_details`
  MODIFY `grnCode1` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mast_location`
--
ALTER TABLE `mast_location`
  MODIFY `locationID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `methodID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `process_type`
--
ALTER TABLE `process_type`
  MODIFY `typeid` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `styleorder`
--
ALTER TABLE `styleorder`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `style_colors`
--
ALTER TABLE `style_colors`
  MODIFY `colorID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `style_sizes`
--
ALTER TABLE `style_sizes`
  MODIFY `sizeID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_production`
--
ALTER TABLE `sub_production`
  MODIFY `recordID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_pro_details`
--
ALTER TABLE `sub_pro_details`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

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
  ADD CONSTRAINT `FK_buyer_modify` FOREIGN KEY (`modifiedBy`) REFERENCES `users` (`User_ID`),
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
