-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 27, 2020 at 01:35 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_token`
--

DROP TABLE IF EXISTS `access_token`;
CREATE TABLE IF NOT EXISTS `access_token` (
  `access_token_id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_code` varchar(255) DEFAULT NULL,
  `tokenCode` varchar(256) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valid_upto` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`access_token_id`),
  KEY `user_id` (`users_code`),
  KEY `userId` (`users_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='This table generates tokens and give access to user.';

--
-- Dumping data for table `access_token`
--

INSERT INTO `access_token` (`access_token_id`, `users_code`, `tokenCode`, `createdOn`, `valid_upto`, `isDeleted`) VALUES
(1, 'd77935e46160', '8f3f62d5623e42d25c2cca2d84a2b529', '2020-03-27 13:34:14', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `email` varchar(64) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'defaultUser.png',
  `users_type` int(11) NOT NULL COMMENT 'superadmin-1,admin-2',
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `activationCode` varchar(255) NOT NULL,
  `isVerified` int(11) NOT NULL DEFAULT '-1' COMMENT '1-verified,0-rejected',
  `users_code` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `inactive_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `user_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `address`, `mobile_no`, `city`, `state`, `date_of_birth`, `profile_pic`, `users_type`, `password`, `salt`, `activationCode`, `isVerified`, `users_code`, `status`, `inactive_date`, `createdOn`, `isDeleted`) VALUES
(1, 'Super Admin', 'super@admin.com', '', '3123123', '', '', '1990-10-10', '5c45b48d85c1d.png', 1, 'd77935e4616015b14f14998a9d817913215d77b5', 'yhRgEbS2', '', 1, 'd77935e46160', 1, '2018-12-07 13:31:24', '2017-12-14 05:15:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `resetpassword`
--

DROP TABLE IF EXISTS `resetpassword`;
CREATE TABLE IF NOT EXISTS `resetpassword` (
  `resetPasswordId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `resetcode` varchar(32) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`resetPasswordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
