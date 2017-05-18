-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2017 at 10:23 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sinmarlb_dbsinmar`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbrands`
--

CREATE TABLE `tblbrands` (
  `brandId` int(11) NOT NULL,
  `brandName` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategories`
--

CREATE TABLE `tblcategories` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblitemimages`
--

CREATE TABLE `tblitemimages` (
  `ImageId` int(11) NOT NULL,
  `imageName` varchar(250) NOT NULL,
  `itemName` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

CREATE TABLE `tblitems` (
  `itemId` int(11) NOT NULL,
  `itemType` enum('Hardware','Appliances') NOT NULL,
  `itemName` varchar(250) NOT NULL,
  `brandName` varchar(250) NOT NULL,
  `categoryName` varchar(250) CHARACTER SET latin1 NOT NULL,
  `model` varchar(250) DEFAULT NULL,
  `itemSize` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `description` text,
  `new` tinyint(1) DEFAULT NULL,
  `offer` tinyint(1) DEFAULT NULL,
  `offerPrice` int(11) DEFAULT NULL,
  `itemImage` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectdetails`
--

CREATE TABLE `tblprojectdetails` (
  `prdetailsId` int(11) NOT NULL,
  `prdetailsTitle` varchar(250) DEFAULT NULL,
  `prdetailsName` varchar(250) NOT NULL,
  `prdetailsType` varchar(250) NOT NULL,
  `prdetailsSubtype` varchar(250) DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  `projectDate` date NOT NULL,
  `description` text,
  `notes` text,
  `new` tinyint(1) NOT NULL,
  `projectImage` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectimages`
--

CREATE TABLE `tblprojectimages` (
  `projectImageId` int(11) NOT NULL,
  `projectTitle` varchar(250) NOT NULL,
  `imageBefore` varchar(250) NOT NULL,
  `imageAfter` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojects`
--

CREATE TABLE `tblprojects` (
  `projectId` int(11) NOT NULL,
  `projectName` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojecttype`
--

CREATE TABLE `tblprojecttype` (
  `projectTypeId` int(11) NOT NULL,
  `projectTypeName` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `userId` int(11) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userType` enum('Admin','User','Client') NOT NULL,
  `token` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`userId`, `userName`, `password`, `userType`, `token`) VALUES
(1, 'admin', 'Admin@123', 'Admin', NULL),
(2, 'saeid', 'Saeid@123', 'User', NULL),
(3, 'salam', 'Salam@123', 'User', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbrands`
--
ALTER TABLE `tblbrands`
  ADD PRIMARY KEY (`brandId`),
  ADD UNIQUE KEY `brandName` (`brandName`);

--
-- Indexes for table `tblcategories`
--
ALTER TABLE `tblcategories`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `categoryName` (`categoryName`);

--
-- Indexes for table `tblitemimages`
--
ALTER TABLE `tblitemimages`
  ADD PRIMARY KEY (`ImageId`),
  ADD UNIQUE KEY `imageName` (`imageName`);

--
-- Indexes for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD PRIMARY KEY (`itemId`),
  ADD UNIQUE KEY `itemName` (`itemName`),
  ADD UNIQUE KEY `itemName_2` (`itemName`),
  ADD KEY `brandName` (`brandName`,`categoryName`);

--
-- Indexes for table `tblprojectdetails`
--
ALTER TABLE `tblprojectdetails`
  ADD PRIMARY KEY (`prdetailsId`),
  ADD UNIQUE KEY `title` (`prdetailsTitle`),
  ADD KEY `prdetailsName` (`prdetailsName`),
  ADD KEY `prdetailsType` (`prdetailsType`);

--
-- Indexes for table `tblprojectimages`
--
ALTER TABLE `tblprojectimages`
  ADD PRIMARY KEY (`projectImageId`);

--
-- Indexes for table `tblprojects`
--
ALTER TABLE `tblprojects`
  ADD PRIMARY KEY (`projectId`),
  ADD UNIQUE KEY `projectName` (`projectName`);

--
-- Indexes for table `tblprojecttype`
--
ALTER TABLE `tblprojecttype`
  ADD PRIMARY KEY (`projectTypeId`),
  ADD UNIQUE KEY `projectTypeName` (`projectTypeName`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `username` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbrands`
--
ALTER TABLE `tblbrands`
  MODIFY `brandId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `tblcategories`
--
ALTER TABLE `tblcategories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tblitemimages`
--
ALTER TABLE `tblitemimages`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tblitems`
--
ALTER TABLE `tblitems`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `tblprojectdetails`
--
ALTER TABLE `tblprojectdetails`
  MODIFY `prdetailsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tblprojectimages`
--
ALTER TABLE `tblprojectimages`
  MODIFY `projectImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprojects`
--
ALTER TABLE `tblprojects`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tblprojecttype`
--
ALTER TABLE `tblprojecttype`
  MODIFY `projectTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
