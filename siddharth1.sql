-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2020 at 11:42 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siddharth1`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `CityId` int(255) NOT NULL,
  `CCountryId` int(255) NOT NULL,
  `CStateId` int(255) NOT NULL,
  `CName` text NOT NULL,
  `CStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`CityId`, `CCountryId`, `CStateId`, `CName`, `CStatus`) VALUES
(1, 1, 1, 'Ahmedabad', 1),
(2, 1, 1, 'Rajkot', 1),
(3, 1, 2, 'New Delhi', 1),
(4, 1, 3, 'Mumbai', 1),
(5, 1, 3, 'Pune', 1),
(6, 1, 4, 'Lucknow', 1),
(7, 1, 4, 'Prayagraj', 1),
(8, 1, 4, 'Agra', 1);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `CId` int(255) NOT NULL,
  `CName` varchar(100) NOT NULL,
  `CStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`CId`, `CName`, `CStatus`) VALUES
(1, 'India1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustId` int(255) NOT NULL,
  `UserId` int(11) NOT NULL,
  `GSTIN` int(11) NOT NULL,
  `VatNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustId`, `UserId`, `GSTIN`, `VatNumber`) VALUES
(1, 56, 878787, '878787'),
(2, 57, 878787, '878787'),
(3, 58, 878787, '878787'),
(4, 59, 878787, '878787'),
(5, 60, 878787, '12345678'),
(6, 61, 878787, '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InventoryId` int(255) NOT NULL,
  `IProductId` int(255) NOT NULL,
  `Stock_Qty` int(11) NOT NULL,
  `Created_At` datetime NOT NULL,
  `Updated_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InventoryId`, `IProductId`, `Stock_Qty`, `Created_At`, `Updated_At`) VALUES
(1, 1, 20, '2020-05-28 05:44:29', '2020-05-28 05:44:29'),
(2, 1, 20, '2020-05-28 05:45:49', '2020-05-28 05:45:49'),
(3, 1, 20, '2020-05-29 02:52:00', '2020-05-29 02:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `manufacture`
--

CREATE TABLE `manufacture` (
  `MenuId` int(255) NOT NULL,
  `UserId` int(11) NOT NULL,
  `GSTIN` int(11) NOT NULL,
  `VatNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manufacture`
--

INSERT INTO `manufacture` (`MenuId`, `UserId`, `GSTIN`, `VatNumber`) VALUES
(1, 56, 878787, '878787'),
(2, 63, 20000, '111100'),
(3, 64, 20000, '111100'),
(4, 65, 2929, '92929'),
(5, 66, 12200111, '012001');

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE `navigations` (
  `NavigationId` int(11) NOT NULL,
  `NavName` varchar(100) NOT NULL,
  `NavOrder` int(11) NOT NULL,
  `ActionPath` varchar(100) NOT NULL,
  `ParentNavId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`NavigationId`, `NavName`, `NavOrder`, `ActionPath`, `ParentNavId`) VALUES
(1, 'User', 2, 'Users', 4),
(2, 'Role', 4, 'Roles', 4),
(3, 'Navigation', 2, 'Navigations', 4),
(4, 'Authorize', 1, 'Authorize', NULL),
(5, 'Navigation View Right', 3, 'NavigViewRight', 4);

-- --------------------------------------------------------

--
-- Table structure for table `navigviewright`
--

CREATE TABLE `navigviewright` (
  `NavgViewId` int(11) NOT NULL,
  `Navigations` int(11) NOT NULL,
  `Roles` int(11) DEFAULT NULL,
  `Users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `navigviewright`
--

INSERT INTO `navigviewright` (`NavgViewId`, `Navigations`, `Roles`, `Users`) VALUES
(1, 1, 1, NULL),
(2, 4, 1, NULL),
(3, 5, 1, NULL),
(4, 3, 1, NULL),
(5, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OId` int(255) NOT NULL,
  `JsonDetails` text NOT NULL,
  `OUserId` int(11) NOT NULL,
  `OAddress` varchar(255) NOT NULL,
  `OTotal` int(11) NOT NULL,
  `OStatus` int(11) NOT NULL,
  `Created_At` datetime NOT NULL,
  `Updated_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OId`, `JsonDetails`, `OUserId`, `OAddress`, `OTotal`, `OStatus`, `Created_At`, `Updated_At`) VALUES
(1, '[{\"MarchantId\":\"66\",\"ProductId\":\"1\",\"Qty\":\"5\",\"Price\":\"300\"},{\"MarchantId\":\"66\",\"ProductId\":\"2\",\"Qty\":\"2\",\"Price\":\"200\"}]', 56, 'Near Bus stop, Raj Nagar Chowk Rajkot', 250, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductId` int(255) NOT NULL,
  `PManuId` int(11) NOT NULL,
  `PName` text NOT NULL,
  `PImage` text NOT NULL,
  `PMinDeliveryDays` int(11) NOT NULL,
  `PPrice` double NOT NULL,
  `PDescription` text NOT NULL,
  `PAdditionalInfo` text NOT NULL,
  `PStatus` int(11) NOT NULL,
  `Created_At` datetime NOT NULL,
  `Updated_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductId`, `PManuId`, `PName`, `PImage`, `PMinDeliveryDays`, `PPrice`, `PDescription`, `PAdditionalInfo`, `PStatus`, `Created_At`, `Updated_At`) VALUES
(1, 66, 'First Product', 'product_5ecaccb5503b3.png', 12, 140, 'First Product Detail Update', '', 1, '0000-00-00 00:00:00', '2020-05-25 01:07:39'),
(2, 66, 'First Product', 'product_5ec8646aaac53.png', 10, 100, 'First Product Detail New Data', '', 0, '2020-05-23 05:16:50', '2020-05-23 05:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `pump`
--

CREATE TABLE `pump` (
  `PumpId` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pump`
--

INSERT INTO `pump` (`PumpId`, `Name`, `Status`) VALUES
(3, 'OPENWELL PUMP', '1'),
(4, 'SUBMERSIBLE PUMP', '1'),
(5, 'SELF PRIMING PUMP', '1'),
(6, 'OPENWELL + SUBMERSIBLE', '1'),
(7, 'UNKNOWN', '1'),
(8, 'SUB + SUB', '1'),
(9, 'OPENWELL + OPENWELL', '1');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleId` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `NavigationId` int(11) NOT NULL,
  `IsRead` tinyint(1) NOT NULL,
  `IsInsert` tinyint(1) NOT NULL,
  `IsUpdate` tinyint(1) NOT NULL,
  `IsDelete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleId`, `RoleName`, `NavigationId`, `IsRead`, `IsInsert`, `IsUpdate`, `IsDelete`) VALUES
(1, 'Super Admin', 1, 1, 1, 1, 1),
(2, 'Customer', 2, 1, 1, 1, 1),
(3, 'Manufacture', 2, 1, 1, 1, 1),
(4, 'Transporter', 2, 1, 1, 1, 1),
(5, 'Vehicle', 2, 1, 1, 1, 1),
(6, 'Driver', 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `StateId` int(255) NOT NULL,
  `SCountryId` int(255) NOT NULL,
  `SName` varchar(100) NOT NULL,
  `SStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`StateId`, `SCountryId`, `SName`, `SStatus`) VALUES
(1, 1, 'Gujarat', 1),
(2, 1, 'Delhi', 1),
(3, 1, 'Maharashtra', 1),
(4, 1, 'Uttar Pradesh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transporter`
--

CREATE TABLE `transporter` (
  `TransId` int(255) NOT NULL,
  `UserId` int(11) NOT NULL,
  `GSTIN` int(11) NOT NULL,
  `VatNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transporter`
--

INSERT INTO `transporter` (`TransId`, `UserId`, `GSTIN`, `VatNumber`) VALUES
(1, 56, 878787, '878787');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `CountryId` int(11) NOT NULL,
  `StateId` int(11) NOT NULL,
  `CityId` int(11) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Landmark` varchar(255) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Image` text NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `IsEmailVerify` int(11) NOT NULL DEFAULT 0,
  `IsMobileNumberVerify` int(11) NOT NULL DEFAULT 0,
  `Role` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `NavigationId` int(11) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `CountryId`, `StateId`, `CityId`, `CompanyName`, `FirstName`, `LastName`, `Address`, `Landmark`, `MobileNumber`, `Image`, `Email`, `Password`, `IsEmailVerify`, `IsMobileNumberVerify`, `Role`, `Type`, `NavigationId`, `Status`) VALUES
(1, 0, 0, 0, '', 'Admin', '', 'e', '', 'img_5c4259704e5', '', 'admin@admin.com', 'admin', 0, 0, 1, '', NULL, 1),
(55, 0, 0, 0, '', 'Shardbhai', 'Mehta', '', '', '', '', 'shard@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 0, 'Normal', NULL, 1),
(56, 0, 0, 0, '', 'Vimal', 'Mital', '', '', '8899002258', '', 'vimal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 2, 'Normal', NULL, 1),
(57, 0, 0, 0, '', 'Vimal', 'Mital', '', '', '8811002258', '', 'vimal123@gmail.com', '14e1b600b1fd579f47433b88e8d85291', 1, 1, 2, 'Facebook', NULL, 1),
(58, 0, 0, 0, '', 'Vimal', 'Mital', 'Near Bus Stop', '', '8211002258', '', 'vimal124@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 2, 'Normal', NULL, 1),
(59, 0, 0, 0, 'White Space', 'Shivil', 'Mehta', 'Near Bus Stop', '', '81111002258', '', 'shivil@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 2, 'Normal', NULL, 1),
(60, 1, 1, 1, 'White Space', 'Shivil', 'Mehta', 'Near Bus Stop', 'Opp Hostpial', '82111002258', 'img_5ec66de2c2b45.jpeg', 'shivil1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 2, 'Normal', NULL, 1),
(61, 1, 1, 1, 'White Space', 'Shivil', 'Mehta', 'Near Bus Stop', 'Main Road', '82111002251', 'img_5ec6d18ccba4b.jpeg', 'shivil2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 2, '', NULL, 1),
(62, 1, 1, 1, 'New Company', '', '', 'Near bus stop', 'main Road rajkot', '7878787878', 'img_5ec7bff7d4905.jpeg', 'test@gmail.com', '123456', 1, 1, 3, 'Normal', NULL, 1),
(63, 1, 1, 1, 'New Company', '', '', 'Near bus stop', 'main Road rajkot', '7878787878', 'img_5ec7c02b9e310.jpeg', 'test@gmail.com', '123456', 1, 1, 3, 'Normal', NULL, 1),
(64, 1, 1, 1, 'New Company', '', '', 'Near bus stop', 'main Road rajkot', '7878787878', 'img_5ec7c038e92e3.jpeg', 'test@gmail.com', '123456', 1, 1, 3, 'Normal', NULL, 0),
(65, 1, 1, 1, 'Fruist', '', '', 'Nea rbus stop', 'wewekfwkjefkjwefkj', '7878787871', 'img_5ec7c41fc979a.jpeg', 'test2@gmail.com', '123456', 1, 1, 3, 'Normal', NULL, 1),
(66, 1, 2, 3, 'wei new', '', '', 'Near Bus stop', 'jwefkkwefk', '3382929', 'img_5ec7c48e1bd9e.jpeg', 'wejk@gmail.com', '12356', 1, 1, 3, 'Normal', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`CityId`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`CId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryId`);

--
-- Indexes for table `manufacture`
--
ALTER TABLE `manufacture`
  ADD PRIMARY KEY (`MenuId`);

--
-- Indexes for table `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`NavigationId`);

--
-- Indexes for table `navigviewright`
--
ALTER TABLE `navigviewright`
  ADD PRIMARY KEY (`NavgViewId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `pump`
--
ALTER TABLE `pump`
  ADD PRIMARY KEY (`PumpId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleId`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`StateId`);

--
-- Indexes for table `transporter`
--
ALTER TABLE `transporter`
  ADD PRIMARY KEY (`TransId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `CityId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `CId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InventoryId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manufacture`
--
ALTER TABLE `manufacture`
  MODIFY `MenuId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `navigations`
--
ALTER TABLE `navigations`
  MODIFY `NavigationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `navigviewright`
--
ALTER TABLE `navigviewright`
  MODIFY `NavgViewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pump`
--
ALTER TABLE `pump`
  MODIFY `PumpId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `StateId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transporter`
--
ALTER TABLE `transporter`
  MODIFY `TransId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
