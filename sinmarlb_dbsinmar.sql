-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 10, 2017 at 04:50 AM
-- Server version: 5.6.35-log
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sinmarlb_dbsinmar`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbrands`
--

CREATE TABLE IF NOT EXISTS `tblbrands` (
  `brandId` int(11) NOT NULL AUTO_INCREMENT,
  `brandName` varchar(250) NOT NULL,
  PRIMARY KEY (`brandId`),
  UNIQUE KEY `brandName` (`brandName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategories`
--

CREATE TABLE IF NOT EXISTS `tblcategories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(250) NOT NULL,
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `categoryName` (`categoryName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblitemimages`
--

CREATE TABLE IF NOT EXISTS `tblitemimages` (
  `ImageId` int(11) NOT NULL AUTO_INCREMENT,
  `imageName` varchar(250) NOT NULL,
  `itemName` varchar(250) NOT NULL,
  PRIMARY KEY (`ImageId`),
  UNIQUE KEY `imageName` (`imageName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

CREATE TABLE IF NOT EXISTS `tblitems` (
  `itemId` int(11) NOT NULL AUTO_INCREMENT,
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
  `itemImage` varchar(250) NOT NULL,
  PRIMARY KEY (`itemId`),
  UNIQUE KEY `itemName` (`itemName`),
  UNIQUE KEY `itemName_2` (`itemName`),
  KEY `brandName` (`brandName`,`categoryName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectdetails`
--

CREATE TABLE IF NOT EXISTS `tblprojectdetails` (
  `prdetailsId` int(11) NOT NULL AUTO_INCREMENT,
  `prdetailsTitle` varchar(250) DEFAULT NULL,
  `prdetailsName` varchar(250) NOT NULL,
  `prdetailsType` varchar(250) NOT NULL,
  `prdetailsSubtype` varchar(250) DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  `projectDate` date NOT NULL,
  `description` text,
  `notes` text,
  `new` tinyint(1) NOT NULL,
  `projectImage` varchar(250) NOT NULL,
  PRIMARY KEY (`prdetailsId`),
  UNIQUE KEY `title` (`prdetailsTitle`),
  KEY `prdetailsName` (`prdetailsName`),
  KEY `prdetailsType` (`prdetailsType`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectimages`
--

CREATE TABLE IF NOT EXISTS `tblprojectimages` (
  `projectImageId` int(11) NOT NULL AUTO_INCREMENT,
  `imageType` enum('After','Before') NOT NULL,
  `projectTitle` varchar(250) NOT NULL,
  `imageSort` varchar(250) NOT NULL,
  `imageName` varchar(250) NOT NULL,
  PRIMARY KEY (`projectImageId`),
  UNIQUE KEY `imagename` (`imageName`),
  KEY `projecttitle` (`projectTitle`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojects`
--

CREATE TABLE IF NOT EXISTS `tblprojects` (
  `projectId` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` varchar(250) NOT NULL,
  PRIMARY KEY (`projectId`),
  UNIQUE KEY `projectName` (`projectName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblprojecttype`
--

CREATE TABLE IF NOT EXISTS `tblprojecttype` (
  `projectTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `projectTypeName` varchar(250) NOT NULL,
  PRIMARY KEY (`projectTypeId`),
  UNIQUE KEY `projectTypeName` (`projectTypeName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE IF NOT EXISTS `tblusers` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userType` enum('Admin','User','Client') NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`userName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`userId`, `userName`, `password`, `userType`) VALUES
(1, 'admin', 'Admin@123', 'Admin'),
(2, 'saeid', 'Saeid@123', 'User'),
(3, 'salam', 'Salam@123', 'User');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
