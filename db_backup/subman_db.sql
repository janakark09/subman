-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 01:21 PM
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
  `process` varchar(50) NOT NULL,
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
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `cutNo` varchar(50) NOT NULL,
  `color` int(32) NOT NULL,
  `size` int(32) NOT NULL,
  `matQty` double NOT NULL,
  `status` varchar(20) NOT NULL,
  `cratedDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grn_details`
--

CREATE TABLE `grn_details` (
  `grnCode1` int(32) NOT NULL,
  `grnCode2` varchar(10) NOT NULL,
  `locationID` int(32) NOT NULL,
  `venorID` int(32) NOT NULL,
  `invoiceDate` date NOT NULL,
  `invoiceNo` varchar(50) NOT NULL,
  `fgUnitPrice` double NOT NULL,
  `fgGrnQty` double NOT NULL,
  `fgValue` double NOT NULL,
  `sampleUnitPrice` double NOT NULL,
  `fgSampleQty` double NOT NULL,
  `sampleValue` double NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `status` varchar(50) NOT NULL,
  `receiptID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `receiptID` int(32) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `refNo` varchar(50) NOT NULL,
  `unitPriceFg` double NOT NULL,
  `unitPriceSample` double NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `styleorder`
--

CREATE TABLE `styleorder` (
  `id` int(32) NOT NULL,
  `styleNo` varchar(100) NOT NULL,
  `orderNo` varchar(100) NOT NULL,
  `buyerID` int(32) NOT NULL,
  `orderQty` int(32) NOT NULL,
  `division` varchar(50) NOT NULL,
  `proCategory` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `deliveryDate` date NOT NULL,
  `Status` varchar(20) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `cutNo` varchar(50) NOT NULL,
  `color` int(32) NOT NULL,
  `size` int(32) NOT NULL,
  `finishedQty` double NOT NULL,
  `fabDamQty` double DEFAULT NULL,
  `emdDamQty` double NOT NULL,
  `sampleQty` double NOT NULL,
  `comments` varchar(250) NOT NULL,
  `status` varchar(20) NOT NULL,
  `cratedDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL,
  `recFnishedQty` double NOT NULL,
  `recDamQty` double NOT NULL,
  `recSampleQty` double NOT NULL,
  `grnCode1` int(32) NOT NULL,
  `grnCode2` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1001, 'Admin', 'it@originalapparel.lk', 'System', 'Admin', 'System Admin', 'administrator', '123', 'Active');

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
  `acc1` tinyint(1) DEFAULT NULL,
  `acc2` tinyint(1) DEFAULT NULL,
  `acc3` tinyint(1) DEFAULT NULL,
  `acc4` tinyint(1) DEFAULT NULL,
  `acc5` tinyint(1) DEFAULT NULL,
  `acc6` tinyint(1) DEFAULT NULL,
  `acc7` tinyint(1) DEFAULT NULL,
  `acc8` tinyint(1) DEFAULT NULL,
  `acc9` tinyint(1) DEFAULT NULL,
  `acc10` tinyint(1) DEFAULT NULL,
  `acc11` tinyint(1) DEFAULT NULL,
  `acc12` tinyint(1) DEFAULT NULL,
  `acc13` tinyint(1) DEFAULT NULL,
  `acc14` tinyint(1) DEFAULT NULL,
  `acc15` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`User_ID`, `Address`, `TelNumber`, `Joined_Date`, `locationID`, `venderID`, `acc1`, `acc2`, `acc3`, `acc4`, `acc5`, `acc6`, `acc7`, `acc8`, `acc9`, `acc10`, `acc11`, `acc12`, `acc13`, `acc14`, `acc15`) VALUES
(1001, 'Bandaragama', '0778520129', '2026-02-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `userType` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`userType`, `status`) VALUES
('administrator', 'Active');

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
  `email` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `createdDT` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `FK_Agree_Create` (`createdBy`);

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
  ADD KEY `FK_Gatepass_Color` (`color`),
  ADD KEY `FK_Gatepass_Size` (`size`),
  ADD KEY `FK_Gatepass_Created` (`createdBy`),
  ADD KEY `FK_Gatepass_Agreement` (`orderAgreement`);

--
-- Indexes for table `grn_details`
--
ALTER TABLE `grn_details`
  ADD PRIMARY KEY (`grnCode1`),
  ADD KEY `FK_Grn_Uid` (`createdBy`),
  ADD KEY `FK_Grn_location` (`locationID`),
  ADD KEY `FK_Grn_VandorID` (`venorID`);

--
-- Indexes for table `mast_location`
--
ALTER TABLE `mast_location`
  ADD PRIMARY KEY (`locationID`),
  ADD KEY `FK_Loc_Uid` (`createdBy`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`receiptID`);

--
-- Indexes for table `styleorder`
--
ALTER TABLE `styleorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Style_Buyer` (`buyerID`),
  ADD KEY `FK_Style_Create` (`createdBy`);

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
  ADD KEY `FK_Pro_Color` (`color`),
  ADD KEY `FK_Pro_Size` (`size`),
  ADD KEY `FK_Pro_Create` (`createdBy`),
  ADD KEY `FK_Pro_Grn` (`grnCode1`);

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
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyerID` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gatepass`
--
ALTER TABLE `gatepass`
  MODIFY `gatepassID_1` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grn_details`
--
ALTER TABLE `grn_details`
  MODIFY `grnCode1` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mast_location`
--
ALTER TABLE `mast_location`
  MODIFY `locationID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `receiptID` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `styleorder`
--
ALTER TABLE `styleorder`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `style_colors`
--
ALTER TABLE `style_colors`
  MODIFY `colorID` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `style_sizes`
--
ALTER TABLE `style_sizes`
  MODIFY `sizeID` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_production`
--
ALTER TABLE `sub_production`
  MODIFY `recordID` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendorID` int(32) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agreements`
--
ALTER TABLE `agreements`
  ADD CONSTRAINT `FK_Agree_Create` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Agree_order` FOREIGN KEY (`styleOrderID`) REFERENCES `styleorder` (`id`),
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
  ADD CONSTRAINT `FK_Gatepass_Color` FOREIGN KEY (`color`) REFERENCES `style_colors` (`colorID`),
  ADD CONSTRAINT `FK_Gatepass_Created` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Gatepass_LocID` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`),
  ADD CONSTRAINT `FK_Gatepass_Size` FOREIGN KEY (`size`) REFERENCES `style_sizes` (`sizeID`),
  ADD CONSTRAINT `FK_Gatepass_Style` FOREIGN KEY (`orderNoID`) REFERENCES `styleorder` (`id`),
  ADD CONSTRAINT `FK_Gatepass_Vendor` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `grn_details`
--
ALTER TABLE `grn_details`
  ADD CONSTRAINT `FK_Grn_Uid` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Grn_VandorID` FOREIGN KEY (`venorID`) REFERENCES `vendors` (`vendorID`),
  ADD CONSTRAINT `FK_Grn_location` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`);

--
-- Constraints for table `mast_location`
--
ALTER TABLE `mast_location`
  ADD CONSTRAINT `FK_Loc_Uid` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `styleorder`
--
ALTER TABLE `styleorder`
  ADD CONSTRAINT `FK_Style_Buyer` FOREIGN KEY (`buyerID`) REFERENCES `buyer` (`buyerID`),
  ADD CONSTRAINT `FK_Style_Create` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`);

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
  ADD CONSTRAINT `FK_Pro_Color` FOREIGN KEY (`color`) REFERENCES `style_colors` (`colorID`),
  ADD CONSTRAINT `FK_Pro_Create` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_Pro_Grn` FOREIGN KEY (`grnCode1`) REFERENCES `grn_details` (`grnCode1`),
  ADD CONSTRAINT `FK_Pro_Loc` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`),
  ADD CONSTRAINT `FK_Pro_OrderNo` FOREIGN KEY (`orderNoID`) REFERENCES `styleorder` (`id`),
  ADD CONSTRAINT `FK_Pro_Size` FOREIGN KEY (`size`) REFERENCES `style_sizes` (`sizeID`),
  ADD CONSTRAINT `FK_Pro_Vendor` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_UserType` FOREIGN KEY (`User_Type`) REFERENCES `user_type` (`userType`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `FK_UserDetail_LocID` FOREIGN KEY (`locationID`) REFERENCES `mast_location` (`locationID`),
  ADD CONSTRAINT `FK_UserDetail_UID` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `FK_UserDetail_Ven` FOREIGN KEY (`venderID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `FK_vendor_created` FOREIGN KEY (`createdBy`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
