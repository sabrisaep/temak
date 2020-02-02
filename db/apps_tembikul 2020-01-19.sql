-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2020 at 07:18 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apps_tembikul`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajar`
--

CREATE TABLE `ajar` (
  `idajar` int(11) NOT NULL,
  `pensyarah` int(11) NOT NULL,
  `kursus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bilik`
--

CREATE TABLE `bilik` (
  `idbilik` int(11) NOT NULL,
  `jabatan` int(11) NOT NULL,
  `kodbilik` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bukanguru`
--

CREATE TABLE `bukanguru` (
  `pensyarah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `jabatan`
-- (See below for the actual view)
--
CREATE TABLE `jabatan` (
`idjabatan` int(11)
,`kodjabatan` varchar(20)
,`namajabatan` varchar(100)
,`kata` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `jadual`
--

CREATE TABLE `jadual` (
  `idjadual` int(11) NOT NULL,
  `ajar` int(11) NOT NULL,
  `bilik` int(11) NOT NULL,
  `hari` int(11) NOT NULL,
  `masamula` int(11) NOT NULL,
  `tempoh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadualsiap`
--

CREATE TABLE `jadualsiap` (
  `pensyarah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kekosongan`
--

CREATE TABLE `kekosongan` (
  `idkekosongan` int(11) NOT NULL,
  `jadual` int(11) NOT NULL,
  `mk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `idkursus` int(11) NOT NULL,
  `jabatan` int(11) NOT NULL,
  `kodkursus` varchar(10) NOT NULL,
  `namakursus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `pensyarah`
-- (See below for the actual view)
--
CREATE TABLE `pensyarah` (
`idpensyarah` int(11)
,`jabatan` int(11)
,`nokp` varchar(12)
,`namapensyarah` varchar(50)
,`skim` varchar(5)
,`kata` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `tarikh`
--

CREATE TABLE `tarikh` (
  `idtarikh` int(11) NOT NULL,
  `jabatan` int(11) NOT NULL,
  `mk` int(11) NOT NULL,
  `tarikh` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tempah`
--

CREATE TABLE `tempah` (
  `idtempah` int(11) NOT NULL,
  `ajar` int(11) NOT NULL,
  `bilik` int(11) NOT NULL,
  `tarikh` date NOT NULL,
  `masamula` int(11) NOT NULL,
  `tempoh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `jabatan`
--
DROP TABLE IF EXISTS `jabatan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jabatan`  AS  select `ptss_politeknik`.`bahagian`.`idbahagian` AS `idjabatan`,`ptss_politeknik`.`bahagian`.`kodbahagian` AS `kodjabatan`,`ptss_politeknik`.`bahagian`.`namabahagian` AS `namajabatan`,`ptss_politeknik`.`bahagian`.`kata` AS `kata` from `ptss_politeknik`.`bahagian` where (`ptss_politeknik`.`bahagian`.`kategori` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `pensyarah`
--
DROP TABLE IF EXISTS `pensyarah`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pensyarah`  AS  select `ptss_staf`.`senarai`.`idsenarai` AS `idpensyarah`,`ptss_staf`.`senarai`.`bahagian` AS `jabatan`,`ptss_staf`.`senarai`.`nokpstaf` AS `nokp`,`ptss_staf`.`senarai`.`namastaf` AS `namapensyarah`,`ptss_staf`.`senarai`.`gred` AS `skim`,`ptss_staf`.`senarai`.`kata` AS `kata` from `ptss_staf`.`senarai` where `ptss_staf`.`senarai`.`bahagian` in (select `jabatan`.`idjabatan` from `jabatan`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajar`
--
ALTER TABLE `ajar`
  ADD PRIMARY KEY (`idajar`);

--
-- Indexes for table `bilik`
--
ALTER TABLE `bilik`
  ADD PRIMARY KEY (`idbilik`),
  ADD UNIQUE KEY `kodbilik` (`kodbilik`);

--
-- Indexes for table `bukanguru`
--
ALTER TABLE `bukanguru`
  ADD PRIMARY KEY (`pensyarah`);

--
-- Indexes for table `jadual`
--
ALTER TABLE `jadual`
  ADD PRIMARY KEY (`idjadual`);

--
-- Indexes for table `jadualsiap`
--
ALTER TABLE `jadualsiap`
  ADD PRIMARY KEY (`pensyarah`);

--
-- Indexes for table `kekosongan`
--
ALTER TABLE `kekosongan`
  ADD PRIMARY KEY (`idkekosongan`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`idkursus`),
  ADD UNIQUE KEY `kodkursus` (`kodkursus`),
  ADD UNIQUE KEY `namakursus` (`namakursus`);

--
-- Indexes for table `tarikh`
--
ALTER TABLE `tarikh`
  ADD PRIMARY KEY (`idtarikh`);

--
-- Indexes for table `tempah`
--
ALTER TABLE `tempah`
  ADD PRIMARY KEY (`idtempah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajar`
--
ALTER TABLE `ajar`
  MODIFY `idajar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bilik`
--
ALTER TABLE `bilik`
  MODIFY `idbilik` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadual`
--
ALTER TABLE `jadual`
  MODIFY `idjadual` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kekosongan`
--
ALTER TABLE `kekosongan`
  MODIFY `idkekosongan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `idkursus` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarikh`
--
ALTER TABLE `tarikh`
  MODIFY `idtarikh` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tempah`
--
ALTER TABLE `tempah`
  MODIFY `idtempah` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
