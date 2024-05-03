-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 07:41 AM
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
-- Database: `hlfs`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `balance`
-- (See below for the actual view)
--
CREATE TABLE `balance` (
`c_name` varchar(500)
,`i_id` int(10)
,`i_name` varchar(500)
,`total_item_purchase` decimal(32,0)
,`total_item_issue` decimal(32,0)
,`total_item_purchase_price` decimal(42,0)
,`total_item_issue_price` decimal(42,0)
,`qty_balance` decimal(33,0)
,`item_issue_avg_price` decimal(47,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `category_item`
--

CREATE TABLE `category_item` (
  `c_id` int(255) NOT NULL,
  `c_name` varchar(500) NOT NULL,
  `c_datetime` datetime NOT NULL,
  `c_update_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_item`
--

INSERT INTO `category_item` (`c_id`, `c_name`, `c_datetime`, `c_update_datetime`) VALUES
(12, 'laptop', '2023-06-05 13:15:50', '0000-00-00 00:00:00'),
(13, 'mobile', '2023-06-05 13:15:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `d_id` int(3) NOT NULL,
  `d_name` varchar(500) NOT NULL,
  `d_full_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_id`, `d_name`, `d_full_name`) VALUES
(2, 'IT', '\r\nInformation Technology'),
(3, 'HR', 'Human Resource'),
(4, 'bba', 'asdfg hcvhio mgf'),
(5, 'ie', 'dsfsdf dfgdfg');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `e_id` int(5) NOT NULL,
  `e_com_id` varchar(50) NOT NULL,
  `e_name` varchar(500) NOT NULL,
  `d_name` varchar(500) NOT NULL,
  `e_designation` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`e_id`, `e_com_id`, `e_name`, `d_name`, `e_designation`) VALUES
(18, '#HM011290', 'Abu Sufiun', 'IT', 'Officer'),
(19, '23456', 'Fahim', 'HR', 'sr. Officer');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `i_id` int(10) NOT NULL,
  `i_name` varchar(500) NOT NULL,
  `i_manufactured_by` varchar(500) NOT NULL,
  `i_add_datetime` datetime NOT NULL,
  `c_name` varchar(500) NOT NULL,
  `i_unit` varchar(500) NOT NULL,
  `i_size` varchar(500) NOT NULL,
  `i_price` int(10) NOT NULL,
  `i_price_update_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`i_id`, `i_name`, `i_manufactured_by`, `i_add_datetime`, `c_name`, `i_unit`, `i_size`, `i_price`, `i_price_update_datetime`) VALUES
(5, 'notebook', 'hp', '2023-06-05 13:17:00', 'laptop', 'pic', '15inc', 50000, NULL),
(6, 'think pad', 'lenavo', '2023-06-05 13:18:00', 'laptop', 'pic', '13inc', 60000, NULL),
(7, 'pixel 6', 'google', '2023-06-08 11:54:00', 'mobile', 'pic', '5.5inc', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_issue`
--

CREATE TABLE `item_issue` (
  `is_id` int(10) NOT NULL,
  `is_datetime` datetime NOT NULL,
  `i_id` int(10) NOT NULL,
  `is_qty` int(10) NOT NULL,
  `i_price` int(10) NOT NULL,
  `e_id` int(10) NOT NULL,
  `is_item_issue_by` varchar(500) NOT NULL,
  `is_avg_price` int(10) NOT NULL,
  `is_profit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_issue`
--

INSERT INTO `item_issue` (`is_id`, `is_datetime`, `i_id`, `is_qty`, `i_price`, `e_id`, `is_item_issue_by`, `is_avg_price`, `is_profit`) VALUES
(1, '2023-06-09 11:26:07', 7, 5, 5, 18, 'sufiun', 5, 0),
(2, '2023-06-09 11:30:34', 7, 2, 5, 19, 'sufiun', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase`
--

CREATE TABLE `item_purchase` (
  `p_id` int(10) NOT NULL,
  `i_id` int(10) NOT NULL,
  `s_id` int(10) NOT NULL,
  `p_qty` int(5) NOT NULL,
  `p_unit_price` int(10) NOT NULL,
  `p_add_datetime` datetime NOT NULL,
  `p_expaired_datetime` datetime NOT NULL,
  `p_purchase_by` varchar(500) NOT NULL,
  `p_profit` int(10) NOT NULL,
  `p_request` tinyint(1) NOT NULL DEFAULT '0',
  `p_recive` tinyint(1) NOT NULL DEFAULT '0',
  `p_request_accept_datetime` datetime DEFAULT NULL,
  `p_recive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_purchase`
--

INSERT INTO `item_purchase` (`p_id`, `i_id`, `s_id`, `p_qty`, `p_unit_price`, `p_add_datetime`, `p_expaired_datetime`, `p_purchase_by`, `p_profit`, `p_request`, `p_recive`, `p_request_accept_datetime`, `p_recive_datetime`) VALUES
(11, 7, 1, 10, 5, '2023-06-08 15:49:47', '2023-06-30 15:50:00', 'sufiun', 0, 1, 1, NULL, NULL),
(12, 5, 2, 5, 500, '2023-06-09 11:33:22', '2023-06-30 11:33:00', 'sufiun', 247500, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `s_id` int(10) NOT NULL,
  `s_name` varchar(500) NOT NULL,
  `s_address` varchar(500) NOT NULL,
  `s_phone` int(11) NOT NULL,
  `s_email` varchar(500) NOT NULL,
  `s_add_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`s_id`, `s_name`, `s_address`, `s_phone`, `s_email`, `s_add_datetime`) VALUES
(1, 's1', 'sadasdf', 1546658, 'aaf@fdf.com', '2023-05-31 09:24:17'),
(2, 's2', 'asdas', 654654, 'asd@dsf.com', '2023-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_item_issue`
-- (See below for the actual view)
--
CREATE TABLE `view_item_issue` (
`i_id` int(10)
,`total_item_issue` decimal(32,0)
,`total_item_issue_price` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_item_purchase`
-- (See below for the actual view)
--
CREATE TABLE `view_item_purchase` (
`i_id` int(10)
,`total_item_purchase` decimal(32,0)
,`total_item_purchase_price` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Structure for view `balance`
--
DROP TABLE IF EXISTS `balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `balance`  AS  select `i`.`c_name` AS `c_name`,`i`.`i_id` AS `i_id`,`i`.`i_name` AS `i_name`,coalesce(`ip`.`total_item_purchase`,0) AS `total_item_purchase`,coalesce(`iss`.`total_item_issue`,0) AS `total_item_issue`,coalesce(`ip`.`total_item_purchase_price`,0) AS `total_item_purchase_price`,coalesce(`iss`.`total_item_issue_price`,0) AS `total_item_issue_price`,(coalesce(`ip`.`total_item_purchase`,0) - coalesce(`iss`.`total_item_issue`,0)) AS `qty_balance`,coalesce(((coalesce(`ip`.`total_item_purchase_price`,0) - coalesce(`iss`.`total_item_issue_price`,0)) / nullif((coalesce(`ip`.`total_item_purchase`,0) - coalesce(`iss`.`total_item_issue`,0)),0)),0) AS `item_issue_avg_price` from ((`item` `i` left join `view_item_purchase` `ip` on((`i`.`i_id` = `ip`.`i_id`))) left join `view_item_issue` `iss` on((`i`.`i_id` = `iss`.`i_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_item_issue`
--
DROP TABLE IF EXISTS `view_item_issue`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_item_issue`  AS  select `item_issue`.`i_id` AS `i_id`,sum(coalesce(`item_issue`.`is_qty`,0)) AS `total_item_issue`,sum(coalesce((`item_issue`.`is_qty` * `item_issue`.`is_avg_price`),0)) AS `total_item_issue_price` from `item_issue` group by `item_issue`.`i_id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_item_purchase`
--
DROP TABLE IF EXISTS `view_item_purchase`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_item_purchase`  AS  select `item_purchase`.`i_id` AS `i_id`,sum(coalesce(`item_purchase`.`p_qty`,0)) AS `total_item_purchase`,sum(coalesce((`item_purchase`.`p_qty` * `item_purchase`.`p_unit_price`),0)) AS `total_item_purchase_price` from `item_purchase` where (`item_purchase`.`p_recive` = 1) group by `item_purchase`.`i_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_item`
--
ALTER TABLE `category_item`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_name` (`c_name`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`d_id`),
  ADD UNIQUE KEY `d_name` (`d_name`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`e_id`),
  ADD UNIQUE KEY `e_com_id` (`e_com_id`),
  ADD UNIQUE KEY `e_id` (`e_id`),
  ADD KEY `dep_name_fk` (`d_name`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`i_id`),
  ADD UNIQUE KEY `i_name` (`i_name`),
  ADD KEY `catagory_item_c_name_fk` (`c_name`);

--
-- Indexes for table `item_issue`
--
ALTER TABLE `item_issue`
  ADD PRIMARY KEY (`is_id`);

--
-- Indexes for table `item_purchase`
--
ALTER TABLE `item_purchase`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `s_id_purchase_supplier` (`s_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_item`
--
ALTER TABLE `category_item`
  MODIFY `c_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `d_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `e_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `i_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `item_issue`
--
ALTER TABLE `item_issue`
  MODIFY `is_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item_purchase`
--
ALTER TABLE `item_purchase`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `s_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `dep_name_fk` FOREIGN KEY (`d_name`) REFERENCES `department` (`d_name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `catagory_item_c_name_fk` FOREIGN KEY (`c_name`) REFERENCES `category_item` (`c_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_purchase`
--
ALTER TABLE `item_purchase`
  ADD CONSTRAINT `s_id_purchase_supplier` FOREIGN KEY (`s_id`) REFERENCES `supplier` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
