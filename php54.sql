-- phpMyAdmin SQL Dump
-- version 4.0.10.2
-- http://www.phpmyadmin.net
--
-- Host: 127.6.113.130:3306
-- Generation Time: Oct 08, 2014 at 05:08 AM
-- Server version: 5.5.37
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php54`
--

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
  `entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` bigint(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(80) NOT NULL,
  `image` varchar(80) DEFAULT NULL,
  `rating_ease` int(11) NOT NULL,
  `rating_safety` int(11) NOT NULL,
  `rating_reseal` int(11) NOT NULL,
  `rating_overall` double NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`entry_id`, `user_id`, `product_id`, `timestamp`, `name`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`) VALUES
(1, 1, 8801062636358, '2014-10-02 09:49:44', 'Aplus Product', '', 5, 5, 5, 5, 'This is Group Aplus wishing you good luck.');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` bigint(20) NOT NULL,
  `name` varchar(80) NOT NULL,
  `manufacturer` varchar(80) NOT NULL,
  `packaging_type` varchar(80) NOT NULL,
  `image` varchar(80) NOT NULL,
  `no_of_raters` int(11) NOT NULL,
  `avg_rating` double NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `avg_rating` (`avg_rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `manufacturer`, `packaging_type`, `image`, `no_of_raters`, `avg_rating`) VALUES
(8801062636358, 'Aplus Product', 'Kraft', 'Bag', '', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `age` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `name`, `gender`, `age`) VALUES
(1, 'user@example.com', 'password', 'Aplus', 0, 20);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
