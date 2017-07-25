-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2017 at 01:33 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblbrands`
--

INSERT INTO `tblbrands` (`brandId`, `brandName`) VALUES
(58, 'ali'),
(49, 'bdbdb'),
(50, 'ddd'),
(54, 'ddddaa'),
(48, 'f'),
(55, 'Ogkgf'),
(59, 'qqqqqqqqqqaaaaaaaaaaaa'),
(56, 'tyy');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategories`
--

CREATE TABLE `tblcategories` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcategories`
--

INSERT INTO `tblcategories` (`categoryId`, `categoryName`) VALUES
(9, 'cateforiii'),
(12, 'dbdbdg'),
(10, 'fdghdghgd'),
(11, 'gdhgdhghghghgh'),
(13, 'mohamadCat'),
(14, 'vfv');

-- --------------------------------------------------------

--
-- Table structure for table `tblitemimages`
--

CREATE TABLE `tblitemimages` (
  `ImageId` int(11) NOT NULL,
  `imageName` varchar(250) NOT NULL,
  `itemName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblitemimages`
--

INSERT INTO `tblitemimages` (`ImageId`, `imageName`, `itemName`) VALUES
(1, '592f1e0a5b072@img.jpg', 'ZXC'),
(2, '592f1e0cf2f12@screen.png', 'ZXC');

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

CREATE TABLE `tblitems` (
  `itemId` int(11) NOT NULL,
  `itemType` enum('Hardware','Appliances') NOT NULL,
  `itemName` varchar(250) NOT NULL,
  `brandName` varchar(250) NOT NULL,
  `categoryName` varchar(250) NOT NULL,
  `model` varchar(250) DEFAULT NULL,
  `itemSize` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `description` text,
  `new` tinyint(1) DEFAULT NULL,
  `offer` tinyint(1) DEFAULT NULL,
  `offerPrice` int(11) DEFAULT NULL,
  `itemImage` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblitems`
--

INSERT INTO `tblitems` (`itemId`, `itemType`, `itemName`, `brandName`, `categoryName`, `model`, `itemSize`, `color`, `price`, `description`, `new`, `offer`, `offerPrice`, `itemImage`) VALUES
(1, 'Hardware', 'ZXC', 'qqqqqqqqqqaaaaaaaaaaaa', 'vfv', 'ZXC', 'ZXC', 'ZXC', 2, 'ZXC', 1, 0, 0, '592f1e08146d1@img.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprojectdetails`
--

INSERT INTO `tblprojectdetails` (`prdetailsId`, `prdetailsTitle`, `prdetailsName`, `prdetailsType`, `prdetailsSubtype`, `location`, `projectDate`, `description`, `notes`, `new`, `projectImage`) VALUES
(14, 'dghgdghg', 'Test Project', 'qqq', 'gh', '', '2017-05-17', 'ghg', 'ghg', 1, '591ffbba742c9@blacklogo.png'),
(15, 'dhdthdth', 'Test Project', 'Test Project Type', '', '', '2017-05-20', '', '', 1, '591ffbf30bfd4@blacklogo.png'),
(17, 'jjhjhf', 'Test Project', 'qqq', '', '', '2017-05-26', '', '', 1, '591ffc20c771c@img.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblprojectimages`
--

CREATE TABLE `tblprojectimages` (
  `projectImageId` int(11) NOT NULL,
  `projectTitle` varchar(250) NOT NULL,
  `imageBefore` varchar(250) NOT NULL,
  `imageAfter` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprojectimages`
--

INSERT INTO `tblprojectimages` (`projectImageId`, `projectTitle`, `imageBefore`, `imageAfter`) VALUES
(3, 'dghgdghg', '59206cf6bedef@screen.png', '59206cf6bee07@img.jpg'),
(4, 'jjhjhf', '59206d0e83e62@img.jpg', '59206d0e83e9d@screen.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblprojects`
--

CREATE TABLE `tblprojects` (
  `projectId` int(11) NOT NULL,
  `projectName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprojects`
--

INSERT INTO `tblprojects` (`projectId`, `projectName`) VALUES
(18, 'fbfdfdb'),
(19, 'fffbfbfbfb'),
(17, 'Test Project');

-- --------------------------------------------------------

--
-- Table structure for table `tblprojecttype`
--

CREATE TABLE `tblprojecttype` (
  `projectTypeId` int(11) NOT NULL,
  `projectTypeName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprojecttype`
--

INSERT INTO `tblprojecttype` (`projectTypeId`, `projectTypeName`) VALUES
(15, 'qqq'),
(13, 'Test Project Type');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD UNIQUE KEY `imageName` (`imageName`),
  ADD KEY `itemName` (`itemName`);

--
-- Indexes for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD PRIMARY KEY (`itemId`),
  ADD UNIQUE KEY `itemName` (`itemName`),
  ADD UNIQUE KEY `itemName_2` (`itemName`),
  ADD KEY `brandName` (`brandName`,`categoryName`),
  ADD KEY `brandName_2` (`brandName`,`categoryName`),
  ADD KEY `categoryName` (`categoryName`);

--
-- Indexes for table `tblprojectdetails`
--
ALTER TABLE `tblprojectdetails`
  ADD PRIMARY KEY (`prdetailsId`),
  ADD UNIQUE KEY `title` (`prdetailsTitle`),
  ADD KEY `prdetailsName` (`prdetailsName`),
  ADD KEY `prdetailsType` (`prdetailsType`),
  ADD KEY `prdetailsName_2` (`prdetailsName`),
  ADD KEY `prdetailsType_2` (`prdetailsType`);

--
-- Indexes for table `tblprojectimages`
--
ALTER TABLE `tblprojectimages`
  ADD PRIMARY KEY (`projectImageId`),
  ADD KEY `projectTitle` (`projectTitle`);

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
  MODIFY `brandId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `tblcategories`
--
ALTER TABLE `tblcategories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tblitemimages`
--
ALTER TABLE `tblitemimages`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblitems`
--
ALTER TABLE `tblitems`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblprojectdetails`
--
ALTER TABLE `tblprojectdetails`
  MODIFY `prdetailsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tblprojectimages`
--
ALTER TABLE `tblprojectimages`
  MODIFY `projectImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblprojects`
--
ALTER TABLE `tblprojects`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tblprojecttype`
--
ALTER TABLE `tblprojecttype`
  MODIFY `projectTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblitemimages`
--
ALTER TABLE `tblitemimages`
  ADD CONSTRAINT `itemnamesforimages` FOREIGN KEY (`itemName`) REFERENCES `tblitems` (`itemName`);

--
-- Constraints for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD CONSTRAINT `brandnames` FOREIGN KEY (`brandName`) REFERENCES `tblbrands` (`brandName`),
  ADD CONSTRAINT `categorynames` FOREIGN KEY (`categoryName`) REFERENCES `tblcategories` (`categoryName`);

--
-- Constraints for table `tblprojectdetails`
--
ALTER TABLE `tblprojectdetails`
  ADD CONSTRAINT `projectsnames` FOREIGN KEY (`prdetailsName`) REFERENCES `tblprojects` (`projectName`),
  ADD CONSTRAINT `projecttypes` FOREIGN KEY (`prdetailsType`) REFERENCES `tblprojecttype` (`projectTypeName`);

--
-- Constraints for table `tblprojectimages`
--
ALTER TABLE `tblprojectimages`
  ADD CONSTRAINT `projectstitels` FOREIGN KEY (`projectTitle`) REFERENCES `tblprojectdetails` (`prdetailsTitle`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
