-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2021 at 12:41 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `android_batch_34`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersid` int(11) NOT NULL COMMENT 'foreign key of users table',
  `billdate` date NOT NULL,
  `fullname` varchar(128) NOT NULL,
  `address1` varchar(128) NOT NULL,
  `address2` varchar(128) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `paymentmode` int(1) NOT NULL COMMENT '1=COD 2 = ONLINE',
  `paymentstatus` int(1) NOT NULL DEFAULT 2 COMMENT '1=PAID, 2 = UNPAID',
  `orderstatus` int(1) NOT NULL DEFAULT 1 COMMENT '1=CONFIRMED, 2 = DISPATCHED, 3= DELIVERED, 4 = CANCEL, 5 = RETURN',
  `amount` int(11) NOT NULL,
  `remarks` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `usersid`, `billdate`, `fullname`, `address1`, `address2`, `mobile`, `city`, `pincode`, `paymentmode`, `paymentstatus`, `orderstatus`, `amount`, `remarks`) VALUES
(11, 1, '2021-05-01', 'ankit_patel', 'hilldrive', 'waghawadi_road', '987654321', 'bhavnagar', '212121', 1, 2, 1, 800, 'abc'),
(12, 1, '2021-05-03', 'ankit patel', 'Waghawadi Rd', 'asd', '9662512857', 'Bhavnagar', '364002', 1, 2, 1, 300, 'igif');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `usersid` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `billid` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ind_productid_usersid_billid` (`productid`,`usersid`,`billid`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `productid`, `usersid`, `price`, `billid`, `quantity`) VALUES
(170, 2, 1, 200, 11, 3),
(171, 1, 1, 100, 11, 2),
(175, 1, 1, 100, 12, 1),
(176, 2, 1, 200, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `islive` int(1) DEFAULT 1,
  `isdeleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `photo`, `islive`, `isdeleted`) VALUES
(1, 'laptop', 'laptop.jpg', 1, 0),
(2, 'mobile', 'mobile.jpg', 1, 0),
(3, 'book', 'books.jpg', 1, 0),
(4, 'Cookies & waffers', 'Cookies.jpg', 1, 0),
(5, 'Washing Powders', 'washing_powders.jpg', 1, 0),
(6, 'shampoo', 'shampoo.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `error`
--

DROP TABLE IF EXISTS `error`;
CREATE TABLE IF NOT EXISTS `error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `error` varchar(2048) NOT NULL,
  `query` varchar(2048) NOT NULL,
  `datetime` varchar(32) NOT NULL,
  `line` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `error`
--

INSERT INTO `error` (`id`, `filename`, `error`, `query`, `datetime`, `line`) VALUES
(1, 'category.php', 'Unknown column \'photo2\' in \'field list\'', 'select id,title,photo2 from category', 'Wed 20-10-2021 08:07:21 PM', 11),
(2, 'category.php', 'Unknown column \'photo2\' in \'field list\'', 'select id,title,photo2 from category', 'Wed 20-10-2021 08:07:45 PM', 11),
(3, 'product.php', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 1', 'select id,title,price,photo from product where categoryid=', 'Thu 21-10-2021 07:58:53 PM', 11),
(4, 'product.php', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 1', 'select id,title,price,photo from product where categoryid=', 'Thu 21-10-2021 07:59:11 PM', 11),
(5, 'product_detail.php', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'and islive=1 and isdeleted=0\' at line 1', 'select * from product where id= and islive=1 and isdeleted=0', 'Fri 22-10-2021 07:40:24 PM', 12),
(6, 'product_detail.php', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'and islive=1 and isdeleted=0\' at line 1', 'select * from product where id= and islive=1 and isdeleted=0', 'Fri 22-10-2021 07:43:11 PM', 16);

-- --------------------------------------------------------

--
-- Table structure for table `gallary`
--

DROP TABLE IF EXISTS `gallary`;
CREATE TABLE IF NOT EXISTS `gallary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallary`
--

INSERT INTO `gallary` (`id`, `productid`, `photo`) VALUES
(1, 1, 'acer1.jpg'),
(2, 1, 'acer2.jpg'),
(3, 1, 'acer3.jpg'),
(4, 2, 'dell1.jpg'),
(5, 2, 'dell2.jpg'),
(6, 3, 'dell3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `size` varchar(64) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `detail` varchar(2048) NOT NULL,
  `islive` int(1) NOT NULL DEFAULT 1,
  `isdeleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `categoryid`, `title`, `price`, `stock`, `weight`, `size`, `photo`, `detail`, `islive`, `isdeleted`) VALUES
(1, 1, 'Acer Laptop', 100, 100, 3000, '15 inch', 'acer.jpg', 'WINDOWS 10 4 GB DDR3 RAM 128 gb ssd hard disk', 1, 0),
(2, 1, 'dell laptop', 200, 100, 3500, '15 inch', 'dell.jpg', 'WINDOWS 10 8 GB DDR3 RAM 512 gb ssd hard disk', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `register_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `mobile`, `register_at`) VALUES
(1, 'ankit3385@gmail.com', '$2y$12$5WgPIBzKXN92wEZj6UhaTuOJf2s5eprpHDzt2wZBcQLoe3kk/v9Dy', '1234567890', '2021-10-23 19:51:05'),
(2, 'theeasylearn@gmail.com', '$2y$12$1S1SjrUqvImqAg40kR5S5u6l.VfJtCsLnMBVQuWd2VxrVZgEvEjqO', '1234567891', '2021-10-23 19:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_usersid_productid` (`usersid`,`productid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `usersid`, `productid`) VALUES
(2, 2, 1),
(3, 2, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
