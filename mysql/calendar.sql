-- phpMyAdmin SQL Dump
-- version 3.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2012 at 06:37 PM
-- Server version: 5.5.28
-- PHP Version: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `calendar`
--

#DROP TABLE `categories`, `category_taxonomy`, `dates`, `date_taxonomy`, `default_taxonomy`, `tags`, `tag_taxonomy`, `transactions`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created`) VALUES
(1, 'Debit', '2012-11-26 14:56:45'),
(2, 'Loan', '2012-11-28 15:17:18'),
(3, 'Over Expense', '2012-11-28 15:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `category_taxonomy`
--

CREATE TABLE IF NOT EXISTS `category_taxonomy` (
  `ctax_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ctax_id`),
  KEY `transaction_id` (`transaction_id`,`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category_taxonomy`
--

INSERT INTO `category_taxonomy` (`ctax_id`, `transaction_id`, `category_id`, `created`) VALUES
(1, 1, 1, '2012-11-28 11:42:03'),
(2, 2, 1, '2012-11-28 15:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE IF NOT EXISTS `dates` (
  `date_id` int(255) NOT NULL AUTO_INCREMENT,
  `date_key` varchar(8) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`date_id`),
  KEY `date_key` (`date_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `date_taxonomy`
--

CREATE TABLE IF NOT EXISTS `date_taxonomy` (
  `dtax_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `date_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dtax_id`),
  KEY `transaction_id` (`transaction_id`,`date_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `default_taxonomy`
--

CREATE TABLE IF NOT EXISTS `default_taxonomy` (
  `dtax_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `frequency_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`dtax_id`),
  KEY `transaction_id` (`transaction_id`,`frequency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `default_taxonomy`
--

INSERT INTO `default_taxonomy` (`dtax_id`, `transaction_id`, `frequency_id`, `created`, `active`) VALUES
(1, 1, 1, '2012-11-26 17:54:41', 1),
(2, 2, 1, '2012-11-28 15:15:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`, `created`) VALUES
(1, 'House', '2012-11-28 15:18:31'),
(2, 'Jennie', '2012-11-28 15:18:44'),
(3, 'Luxary', '2012-11-28 15:19:26'),
(4, 'Petrol', '2012-11-28 15:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `tag_taxonomy`
--

CREATE TABLE IF NOT EXISTS `tag_taxonomy` (
  `ttax_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ttax_id`),
  KEY `transaction_id` (`transaction_id`,`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tag_taxonomy`
--

INSERT INTO `tag_taxonomy` (`ttax_id`, `transaction_id`, `tag_id`, `created`) VALUES
(1, 1, 1, '2012-11-28 17:32:29'),
(2, 1, 2, '2012-11-28 17:32:29'),
(3, 2, 3, '2012-11-28 17:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `name`, `amount`, `active`, `created`) VALUES
(1, 'A default Transaction', 12.43, 1, '2012-11-28 15:16:03'),
(2, 'A transaction marked Default', 64.99, 1, '2012-11-28 15:16:30');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
