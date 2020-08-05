-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2019 at 06:59 AM
-- Server version: 5.5.60-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE IF NOT EXISTS `Customer` (
  `ID` int(10) unsigned NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(15) NOT NULL,
  `Address1` varchar(255) NOT NULL,
  `Address2` varchar(255) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Tel1` varchar(12) NOT NULL,
  `Tel2` varchar(12) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`ID`, `FirstName`, `LastName`, `Address1`, `Address2`, `CP`, `City`, `Tel1`, `Tel2`, `Email`) VALUES
(10, 'Vincent', 'Delannoy', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Invoice`
--

CREATE TABLE IF NOT EXISTS `Invoice` (
  `ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Proposal`
--

CREATE TABLE IF NOT EXISTS `Proposal` (
  `ID` int(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Customer` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `ProposalItem`
--

CREATE TABLE IF NOT EXISTS `ProposalItem` (
  `ID` int(10) unsigned NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Worker`
--

CREATE TABLE IF NOT EXISTS `Worker` (
  `ID` int(10) unsigned NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(15) NOT NULL,
  `CompanyName` varchar(255) NOT NULL,
  `SocialName` varchar(10) NOT NULL,
  `RCSNumber` varchar(50) NOT NULL,
  `LegalAddress1` varchar(250) NOT NULL,
  `LegalAddress2` varchar(250) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Tel1` varchar(12) NOT NULL,
  `Tel2` varchar(12) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(12) NOT NULL,
  `Valid` tinyint(1) NOT NULL DEFAULT '0',
  `CryptoKey` varchar(20) NOT NULL,
  `Payment` tinyint(1) NOT NULL DEFAULT '0',
  `CreationDate` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Worker`
--


-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Proposal`
--
ALTER TABLE `Proposal`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `ProposalItem`
--
ALTER TABLE `ProposalItem`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Worker`
--
ALTER TABLE `Worker`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Invoice`
--
ALTER TABLE `Invoice`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Proposal`
--
ALTER TABLE `Proposal`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `ProposalItem`
--
ALTER TABLE `ProposalItem`
  MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Worker`
--
ALTER TABLE `Worker`
  MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
