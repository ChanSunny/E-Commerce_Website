-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bestbuy_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `brandid` bigint(20) NOT NULL,
  `brandname` varchar(50) NOT NULL,
  PRIMARY KEY (`brandid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brandid`, `brandname`) VALUES
(1232165867, 'Hewlett-Packard'),
(1232168904, 'Lenovo'),
(1232225096, 'Dell');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(50) NOT NULL,
  `last` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`userid`, `first`, `last`, `email`) VALUES
(1, 'John', 'Smith', 'johnsmith@example.com'),
(2, 'Mary', 'Smith', 'marysmith@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE IF NOT EXISTS `customer_address` (
  `userid` int(11) NOT NULL,
  `building` int(11) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zipcode` char(5) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`userid`, `building`, `street`, `city`, `zipcode`) VALUES
(1, 370, 'Jay St', 'Brooklyn', '11201'),
(2, 6, 'metrotech', 'Brooklyn', '11201');

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

DROP TABLE IF EXISTS `customer_login`;
CREATE TABLE IF NOT EXISTS `customer_login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_login`
--

INSERT INTO `customer_login` (`email`, `password`) VALUES
('johnsmith@example.com', '$2y$10$Z5.LXeSzLQbXOuVAar4/eO9a5d.EPJP/t4ItpnJOUTFt27cbCNn3C'),
('marysmith@example.com', '$2y$10$ujSsw7bPhnnwb9bs0Fim3ONw2AWCfPNzaY4f1DRMR0g3nFKldQFb.');

-- --------------------------------------------------------

--
-- Table structure for table `customer_phone`
--

DROP TABLE IF EXISTS `customer_phone`;
CREATE TABLE IF NOT EXISTS `customer_phone` (
  `userid` int(11) NOT NULL,
  `phone` char(10) NOT NULL,
  PRIMARY KEY (`userid`,`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_phone`
--

INSERT INTO `customer_phone` (`userid`, `phone`) VALUES
(1, '1234567890'),
(2, '1237894567');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT,
  `storeid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `orderdate` date NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`orderid`),
  KEY `storeid` (`storeid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `storeid`, `userid`, `orderdate`, `status`) VALUES
(1, 2518, 2, '2020-12-04', 'pending'),
(2, 2518, 2, '2020-12-04', 'pending'),
(3, 1886, 2, '2020-12-04', 'pending'),
(4, 1886, 1, '2020-12-04', 'pending'),
(5, 2518, 1, '2020-12-04', 'pending'),
(6, 2518, 1, '2020-12-04', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `orderid` int(11) NOT NULL,
  `productid` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`orderid`,`productid`),
  KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`orderid`, `productid`, `amount`) VALUES
(1, 193638002093, 1),
(2, 884116363972, 1),
(3, 884116363972, 1),
(4, 194721588241, 1),
(5, 884116363972, 1),
(6, 193638002093, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `productid` bigint(20) NOT NULL,
  `brandid` bigint(20) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  PRIMARY KEY (`productid`),
  KEY `brandid` (`brandid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `brandid`, `productname`, `price`) VALUES
(193638002093, 1232168904, 'Lenovo - Q24i-10 24\" IPS LED FHD FreeSync Monitor (HDMI, VGA) - Black', '183.99'),
(193638312758, 1232168904, 'Lenovo - Yoga C740 2-in-1 15.6\" Touch-Screen Laptop - Intel Core i7 - 12GB Memory - 512GB Solid State Drive - Mica', '949.99'),
(194721588241, 1232165867, 'HP - Pavilion x360 2-in-1 14\" Touch-Screen Laptop - Intel Core i3 - 8GB Memory - 128GB SSD - Natural Silver', '349.99'),
(884116363972, 1232225096, 'Dell - Inspiron 7000 2-in-1 - 17\" QHD+ Touch Laptop - 11th Gen Intel Core i7 -NVIDIA - 16GB RAM - 512GB SSD+32GB Optane - Silver', '1299.99');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `storeid` int(11) NOT NULL,
  `productid` bigint(20) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`storeid`,`productid`),
  KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`storeid`, `productid`, `amount`) VALUES
(1520, 193638312758, 4),
(1886, 194721588241, 26),
(1886, 884116363972, 4),
(2518, 193638002093, 17),
(2518, 193638312758, 21),
(2518, 194721588241, 12),
(2518, 884116363972, 13);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
CREATE TABLE IF NOT EXISTS `store` (
  `storeid` int(11) NOT NULL,
  `storename` varchar(50) NOT NULL,
  `phone` char(10) DEFAULT NULL,
  PRIMARY KEY (`storeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`storeid`, `storename`, `phone`) VALUES
(1520, 'Best Buy Kings Plaza', '7186778839'),
(1886, 'Best Buy Gateway Brooklyn', '7183482739'),
(2518, 'Best Buy Atlantic Center', '7182307480');

-- --------------------------------------------------------

--
-- Table structure for table `store_address`
--

DROP TABLE IF EXISTS `store_address`;
CREATE TABLE IF NOT EXISTS `store_address` (
  `storeid` int(11) NOT NULL,
  `building` int(11) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zipcode` char(5) DEFAULT NULL,
  PRIMARY KEY (`storeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_address`
--

INSERT INTO `store_address` (`storeid`, `building`, `street`, `city`, `zipcode`) VALUES
(1520, 5102, 'Avenue U', 'Brooklyn', '11234'),
(1886, 369, 'Gateway Dr', 'Brooklyn', '11239'),
(2518, 625, 'Atlantic Ave', 'Brooklyn', '11217');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `customer_address_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `customer` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD CONSTRAINT `customer_login_ibfk_1` FOREIGN KEY (`email`) REFERENCES `customer` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_phone`
--
ALTER TABLE `customer_phone`
  ADD CONSTRAINT `customer_phone_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `customer` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`storeid`) REFERENCES `store` (`storeid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `customer` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brandid`) REFERENCES `brand` (`brandid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`storeid`) REFERENCES `store` (`storeid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `store_address`
--
ALTER TABLE `store_address`
  ADD CONSTRAINT `store_address_ibfk_1` FOREIGN KEY (`storeid`) REFERENCES `store` (`storeid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
