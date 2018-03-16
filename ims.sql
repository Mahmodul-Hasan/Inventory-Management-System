-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2017 at 07:14 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addresss_id` int(10) NOT NULL,
  `street` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addresss_id`, `street`, `city`, `state`) VALUES
(201, '10, Mirpur', 'Dhaka', 'Dhaka'),
(202, '14, Mirpur', 'Dhaka', 'Dhaka'),
(203, '27, Dhanmondi', 'Dhaka', 'Dhaka'),
(456, 'noas', 'd', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(20) NOT NULL,
  `admin_contact_no` varchar(20) NOT NULL,
  `admin_email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_contact_no`, `admin_email`) VALUES
(101, 'Shawan', '45646546', 'shawan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(303, 'cat3'),
(307, 'cloth'),
(308, 'Apparel'),
(309, 'Sports'),
(311, 'Cat2'),
(313, 'Cat4'),
(314, 'newname2'),
(317, 'newname49'),
(318, 'newname4');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(20) NOT NULL,
  `customer_contact_no` varchar(20) NOT NULL,
  `customer_email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_contact_no`, `customer_email`) VALUES
(10001, 'Abdul Hamid', '01711447788', 'hamid@gmail.com'),
(10002, 'Kamal khan', '01912447788', 'kamal@yahoo.com'),
(10003, 'Jamshed Jamil ', '01674125896', 'jamil@gmail.com'),
(10004, 'Jalal Khan', '01722558899', 'khh@gmail.com'),
(10005, 'Kamal Khan', '01841225588', 'kamal@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(10) NOT NULL,
  `item_name` varchar(20) NOT NULL,
  `category_id` int(10) NOT NULL,
  `item_price` double NOT NULL,
  `item_stock` int(10) NOT NULL,
  `production_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `category_id`, `item_price`, `item_stock`, `production_date`) VALUES
(100001, 'Soap', 303, 11, 21, '2017-08-03'),
(100002, 'Car', 303, 11, 26, '2017-08-05'),
(100003, 'Item3', 307, 11, 26, '2017-08-02'),
(100004, 'updatedName', 313, 11, 26, '0000-00-00'),
(100005, 'updatedName', 308, 11, 26, '2017-08-16'),
(100006, 'item6', 313, 11, 26, '2017-08-16'),
(100007, 'Pen', 314, 4, 149, '2017-08-16'),
(100008, 'SomeName2', 308, 23, 131, '2017-08-16'),
(100009, 'Book', 311, 20, 81, '2017-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` int(10) NOT NULL,
  `manager_name` varchar(20) NOT NULL,
  `hire_date` date NOT NULL,
  `manager_salary` int(20) NOT NULL,
  `manager_email` varchar(20) NOT NULL,
  `manager_contact_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`manager_id`, `manager_name`, `hire_date`, `manager_salary`, `manager_email`, `manager_contact_no`) VALUES
(201, 'Kuddus', '2017-08-02', 6688, 'kuddus@gmail.com', '121212'),
(202, 'Rahman Ahmed', '2017-08-01', 30000, 'ahm@gmail.com', '6565464'),
(203, 'Kamal Haque', '2017-08-01', 5600, 'hoque@yahoo.com', '6565656'),
(204, 'Rahim Sheikh', '2017-08-09', 4700, 'rahim@gmail.com', '5588799'),
(205, 'Manager1', '2017-08-12', 9988, 'mgr@gmail.com', '68679'),
(206, 'Somename', '2017-08-08', 6466, 'somemail@gmail.com', '99897'),
(207, 'Shawan', '2017-08-15', 3000, 'shawan@gmail.com', '45679'),
(208, 'Shuvashish', '2017-08-15', 66666, 'mail2@gmail.com', '444444'),
(209, 'Amit goru', '2017-08-15', 700, 'amit@hotmail.com', '1212544'),
(210, 'Abul kalam', '2017-08-15', 2500, 'something@gmail.com', '017745878'),
(211, 'Shihab Mollah', '2017-08-17', 1000, 'shihab@gmail.com', '01774552244'),
(212, 'Tanvir ', '2017-08-18', 20000, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_expense`
--

CREATE TABLE `monthly_expense` (
  `bill_id` int(10) NOT NULL,
  `manager_id` int(10) NOT NULL,
  `house_rent` int(10) NOT NULL,
  `electricity_bill` int(10) NOT NULL,
  `others` int(10) NOT NULL,
  `bill_date` date NOT NULL,
  `month` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monthly_expense`
--

INSERT INTO `monthly_expense` (`bill_id`, `manager_id`, `house_rent`, `electricity_bill`, `others`, `bill_date`, `month`) VALUES
(8001, 201, 50000, 6000, 2654, '2017-08-02', 'August'),
(8002, 202, 5000, 2000, 6000, '2017-08-05', 'September'),
(8003, 202, 5600, 69877, 4500, '2017-08-16', 'July'),
(8004, 201, 2000, 3000, 2000, '2017-08-16', 'December'),
(8005, 203, 3000, 1200, 6988, '2017-08-16', 'June');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `manager_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `order_quantity` int(10) NOT NULL,
  `order_date` date NOT NULL,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `item_id`, `manager_id`, `customer_id`, `order_quantity`, `order_date`, `total_price`) VALUES
(10000000, 100001, 201, 10001, 30, '2017-08-01', 0),
(10000001, 100002, 202, 10002, 40, '2017-08-03', 0),
(10000003, 100003, 203, 10001, 4, '2017-08-02', 0),
(10000004, 100003, 201, 10001, 10, '2017-08-17', 110),
(10000005, 100001, 201, 10006, 5, '2017-08-17', 55),
(10000006, 100007, 201, 10010, 2, '2017-08-17', 8);

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `material_id` int(10) NOT NULL,
  `manager_id` int(10) NOT NULL,
  `vendor_id` int(10) NOT NULL,
  `material_name` varchar(20) NOT NULL,
  `available_stock` int(10) NOT NULL,
  `material_unit_price` double NOT NULL,
  `production_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`material_id`, `manager_id`, `vendor_id`, `material_name`, `available_stock`, `material_unit_price`, `production_date`) VALUES
(700001, 201, 601, 'Materail1', 90, 50, '0000-00-00'),
(700002, 202, 602, 'mat2', 40, 50, '0000-00-00'),
(700003, 202, 607, 'mat3', 50, 45, '0000-00-00'),
(700004, 201, 601, 'mat4', 10, 20, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role`, `password`, `status`) VALUES
(101, 'admin', 'pass', 'active'),
(201, 'mgr', 'pass', 'active'),
(202, 'mgr', 'pass', 'inactive'),
(203, 'mgr', 'passs', 'active'),
(204, 'mgr', 'ppp', 'active'),
(209, 'mgr', 'ppp', 'active'),
(210, 'mgr', 'pass', 'active'),
(211, 'mgr', 'pass', 'active'),
(212, 'mgr', 'pass', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(10) NOT NULL,
  `vendor_name` varchar(20) NOT NULL,
  `vendor_contact_no` varchar(20) NOT NULL,
  `vendor_email` varchar(20) NOT NULL,
  `vendor_address` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`, `vendor_contact_no`, `vendor_email`, `vendor_address`) VALUES
(601, 'Local-1', '456789', 'local1@gmail.com', 'Savar, Dhaka'),
(602, 'Tamim Group', '885546', 'tg@gmail.com', 'Shirajganj'),
(603, 'King Brand', '45598749', 'kb@yahoo.com', 'Ashuganj'),
(604, 'acb Brand', '587965', 'acbc@gmail.com', 'add1'),
(605, 'Big Brand', '225648', 'bb@gmail.com', 'Gazipur, Dhaka'),
(606, 'Small Brand', '4849864', 'sb@gmail.com', 'Maymenshing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addresss_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `monthly_expense`
--
ALTER TABLE `monthly_expense`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addresss_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=457;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10006;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100010;
--
-- AUTO_INCREMENT for table `monthly_expense`
--
ALTER TABLE `monthly_expense`
  MODIFY `bill_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8006;
--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `material_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=700005;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=607;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
