-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2023 at 07:25 AM
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
`c_id` int(10)
,`c_name` varchar(500)
,`i_id` int(10)
,`i_name` varchar(500)
,`total_item_purchase` decimal(32,0)
,`total_item_issue` decimal(32,0)
,`total_item_purchase_price` double
,`total_item_issue_price` double
,`qty_balance` decimal(33,0)
,`item_issue_avg_price` double
);

-- --------------------------------------------------------

--
-- Table structure for table `category_item`
--

CREATE TABLE `category_item` (
  `c_id` int(10) NOT NULL,
  `c_name` varchar(500) NOT NULL,
  `c_update_datetime` datetime NOT NULL,
  `c_add_date_time` datetime NOT NULL,
  `c_add_by` varchar(100) NOT NULL,
  `c_update_by` varchar(100) NOT NULL,
  `c_active` tinyint(1) NOT NULL DEFAULT '1',
  `c_inactive_by` varchar(100) DEFAULT NULL,
  `c_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_item`
--

INSERT INTO `category_item` (`c_id`, `c_name`, `c_update_datetime`, `c_add_date_time`, `c_add_by`, `c_update_by`, `c_active`, `c_inactive_by`, `c_inactive_datetime`) VALUES
(1, 'coffe', '2023-06-23 13:03:12', '0000-00-00 00:00:00', '', 'sufiun', 1, NULL, NULL),
(2, 'Laptop', '2023-06-23 15:39:51', '2023-06-23 10:20:29', 'sufiun', 'sufiun', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `d_id` int(5) NOT NULL,
  `d_name` varchar(500) NOT NULL,
  `d_full_name` varchar(500) NOT NULL,
  `d_add_date_time` datetime NOT NULL,
  `d_add_by` varchar(100) NOT NULL,
  `d_update_date_time` datetime NOT NULL,
  `d_update_by` varchar(100) NOT NULL,
  `d_active` tinyint(1) NOT NULL DEFAULT '1',
  `d_inactive_by` varchar(100) DEFAULT NULL,
  `d_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_id`, `d_name`, `d_full_name`, `d_add_date_time`, `d_add_by`, `d_update_date_time`, `d_update_by`, `d_active`, `d_inactive_by`, `d_inactive_datetime`) VALUES
(1, 'IT', 'Information Technology', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 1, 'sufiun', '2023-06-23 14:41:08'),
(2, 'HR', 'Human Resorce', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 1, NULL, NULL),
(3, 'IPE', 'Industrial & Production Engineering', '0000-00-00 00:00:00', 'sufiun', '2023-06-21 10:25:37', '', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `e_id` int(5) NOT NULL,
  `e_com_id` varchar(50) NOT NULL,
  `e_name` varchar(500) NOT NULL,
  `d_id` int(5) NOT NULL,
  `e_designation` varchar(500) NOT NULL,
  `e_add_date_time` datetime NOT NULL,
  `e_add_by` varchar(100) NOT NULL,
  `e_update_date_time` datetime NOT NULL,
  `e_update_by` varchar(100) NOT NULL,
  `e_active` tinyint(1) NOT NULL DEFAULT '1',
  `e_inactive_by` varchar(100) DEFAULT NULL,
  `e_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`e_id`, `e_com_id`, `e_name`, `d_id`, `e_designation`, `e_add_date_time`, `e_add_by`, `e_update_date_time`, `e_update_by`, `e_active`, `e_inactive_by`, `e_inactive_datetime`) VALUES
(2, '#HM011290', 'Abu Sufiun', 1, 'Officer', '2023-06-20 13:18:28', 'sufiun', '2023-06-24 09:55:13', 'sufiun', 1, 'sufiun', '2023-06-24 09:55:12'),
(3, '123', 'shakhawat', 1, 'sr. officer', '2023-06-24 11:08:55', '', '0000-00-00 00:00:00', 'sufiun', 1, NULL, NULL);

--
-- Triggers `employee`
--
DELIMITER $$
CREATE TRIGGER `employee_delete_trigger` BEFORE DELETE ON `employee` FOR EACH ROW BEGIN
    DECLARE cnt INT;
    SELECT COUNT(*) INTO cnt
    FROM item_issue
    WHERE e_id = OLD.e_id;
    
    IF cnt > 0 THEN
        SIGNAL SQLSTATE '45000'         SET MESSAGE_TEXT = 'Cannot delete employee. References exist in item_issue table.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `employee_update_trigger` AFTER UPDATE ON `employee` FOR EACH ROW BEGIN
    UPDATE item_issue
    SET e_id = NEW.e_id
    WHERE e_id = OLD.e_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `i_id` int(10) NOT NULL,
  `i_name` varchar(500) NOT NULL,
  `i_manufactured_by` varchar(500) NOT NULL,
  `i_add_datetime` datetime NOT NULL,
  `c_id` int(10) NOT NULL,
  `i_unit` varchar(500) NOT NULL,
  `i_size` varchar(500) NOT NULL,
  `i_price` float NOT NULL,
  `stock_out_reminder_qty` int(10) NOT NULL,
  `i_update_datetime` datetime DEFAULT NULL,
  `i_update_by` varchar(100) NOT NULL,
  `i_add_by` varchar(100) NOT NULL,
  `i_active` tinyint(1) DEFAULT '1',
  `i_inactive_by` varchar(100) DEFAULT NULL,
  `i_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`i_id`, `i_name`, `i_manufactured_by`, `i_add_datetime`, `c_id`, `i_unit`, `i_size`, `i_price`, `stock_out_reminder_qty`, `i_update_datetime`, `i_update_by`, `i_add_by`, `i_active`, `i_inactive_by`, `i_inactive_datetime`) VALUES
(1, 'coffe', 'nescafe', '2023-06-22 16:05:00', 1, 'kg', 'large', 500, 10, '2023-06-23 09:12:07', 'sufiun', '', 1, 'sufiun', '2023-06-23 09:11:45'),
(4, 'notebook', 'lenovo', '2023-06-23 08:32:44', 2, 'pic', '15inc', 1500, 2, '2023-06-24 10:42:45', 'sufiun', 'sufiun', 1, 'sufiun', '2023-06-24 08:56:31'),
(6, 'gaming laptop', 'Asus', '2023-06-23 08:32:44', 2, 'pic', '15inc', 1500, 2, '2023-06-23 15:40:28', 'sufiun', 'sufiun', 1, 'sufiun', '2023-06-23 15:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `item_issue`
--

CREATE TABLE `item_issue` (
  `is_id` int(10) NOT NULL,
  `is_datetime` datetime NOT NULL,
  `i_id` int(10) NOT NULL,
  `is_qty` int(10) NOT NULL,
  `i_price` float NOT NULL,
  `e_id` int(5) NOT NULL,
  `emp_dep` varchar(100) NOT NULL,
  `is_item_issue_by` varchar(500) NOT NULL,
  `is_avg_price` float NOT NULL,
  `is_profit` float NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_inactive_datetime` datetime NOT NULL,
  `is_inactive_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_issue`
--

INSERT INTO `item_issue` (`is_id`, `is_datetime`, `i_id`, `is_qty`, `i_price`, `e_id`, `emp_dep`, `is_item_issue_by`, `is_avg_price`, `is_profit`, `is_active`, `is_inactive_datetime`, `is_inactive_by`) VALUES
(1, '2023-06-24 11:05:39', 4, 1, 1500, 2, 'IT', 'sufiun', 500, 0, 1, '0000-00-00 00:00:00', ''),
(2, '2023-06-24 11:35:31', 4, 2, 1500, 3, 'IT', 'sufiun', 500, 2000, 1, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase`
--

CREATE TABLE `item_purchase` (
  `p_id` int(10) NOT NULL,
  `i_id` int(10) NOT NULL,
  `s_id` int(10) NOT NULL,
  `p_qty` int(5) NOT NULL,
  `p_unit_price` float NOT NULL,
  `p_add_datetime` datetime NOT NULL,
  `p_expaired_datetime` datetime NOT NULL,
  `p_purchase_by` varchar(500) NOT NULL,
  `p_profit` float NOT NULL,
  `p_request` tinyint(1) NOT NULL DEFAULT '0',
  `p_request_accept_by` varchar(100) NOT NULL,
  `p_request_unaccept_by` varchar(100) NOT NULL,
  `p_recive` tinyint(1) NOT NULL DEFAULT '0',
  `p_recive_by` varchar(100) NOT NULL,
  `p_request_accept_datetime` datetime DEFAULT NULL,
  `p_request_unaccept_datetime` datetime NOT NULL,
  `p_recive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_purchase`
--

INSERT INTO `item_purchase` (`p_id`, `i_id`, `s_id`, `p_qty`, `p_unit_price`, `p_add_datetime`, `p_expaired_datetime`, `p_purchase_by`, `p_profit`, `p_request`, `p_request_accept_by`, `p_request_unaccept_by`, `p_recive`, `p_recive_by`, `p_request_accept_datetime`, `p_request_unaccept_datetime`, `p_recive_datetime`) VALUES
(1, 4, 1, 10, 500, '2023-06-23 15:45:32', '2023-06-30 15:48:00', 'sufiun', 10000, 1, 'sufiun', '', 1, '', '2023-06-23 15:53:30', '0000-00-00 00:00:00', '2023-06-23 15:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `s_id` int(10) NOT NULL,
  `s_name` varchar(500) NOT NULL,
  `s_address` varchar(500) NOT NULL,
  `s_phone` int(15) NOT NULL,
  `s_email` varchar(500) NOT NULL,
  `s_add_datetime` datetime NOT NULL,
  `s_add_by` varchar(100) NOT NULL,
  `s_update_date_time` datetime NOT NULL,
  `s_update_by` varchar(100) NOT NULL,
  `s_active` tinyint(1) NOT NULL DEFAULT '1',
  `s_inactive_by` varchar(100) NOT NULL,
  `s_inactive_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`s_id`, `s_name`, `s_address`, `s_phone`, `s_email`, `s_add_datetime`, `s_add_by`, `s_update_date_time`, `s_update_by`, `s_active`, `s_inactive_by`, `s_inactive_datetime`) VALUES
(1, 's1', '', 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 1, '', '0000-00-00 00:00:00'),
(2, 's2', '', 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 1, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_item_issue`
-- (See below for the actual view)
--
CREATE TABLE `view_item_issue` (
`i_id` int(10)
,`total_item_issue` decimal(32,0)
,`total_item_issue_price` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_item_purchase`
-- (See below for the actual view)
--
CREATE TABLE `view_item_purchase` (
`i_id` int(10)
,`total_item_purchase` decimal(32,0)
,`total_item_purchase_price` double
);

-- --------------------------------------------------------

--
-- Structure for view `balance`
--
DROP TABLE IF EXISTS `balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `balance`  AS  select `i`.`c_id` AS `c_id`,`c`.`c_name` AS `c_name`,`i`.`i_id` AS `i_id`,`i`.`i_name` AS `i_name`,coalesce(`ip`.`total_item_purchase`,0) AS `total_item_purchase`,coalesce(`iss`.`total_item_issue`,0) AS `total_item_issue`,coalesce(`ip`.`total_item_purchase_price`,0) AS `total_item_purchase_price`,coalesce(`iss`.`total_item_issue_price`,0) AS `total_item_issue_price`,(coalesce(`ip`.`total_item_purchase`,0) - coalesce(`iss`.`total_item_issue`,0)) AS `qty_balance`,coalesce(((coalesce(`ip`.`total_item_purchase_price`,0) - coalesce(`iss`.`total_item_issue_price`,0)) / nullif((coalesce(`ip`.`total_item_purchase`,0) - coalesce(`iss`.`total_item_issue`,0)),0)),0) AS `item_issue_avg_price` from (((`item` `i` left join `view_item_purchase` `ip` on((`i`.`i_id` = `ip`.`i_id`))) left join `view_item_issue` `iss` on((`i`.`i_id` = `iss`.`i_id`))) join `category_item` `c` on((`i`.`c_id` = `c`.`c_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_item_issue`
--
DROP TABLE IF EXISTS `view_item_issue`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_item_issue`  AS  select `item_issue`.`i_id` AS `i_id`,sum(coalesce(`item_issue`.`is_qty`,0)) AS `total_item_issue`,sum(coalesce((`item_issue`.`is_qty` * `item_issue`.`is_avg_price`),0)) AS `total_item_issue_price` from `item_issue` where (`item_issue`.`is_active` = 1) group by `item_issue`.`i_id` ;

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
  ADD KEY `fk_d_id_DEPARTMENT` (`d_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `fk_c_id_CATEGORY_ITEM` (`c_id`);

--
-- Indexes for table `item_issue`
--
ALTER TABLE `item_issue`
  ADD PRIMARY KEY (`is_id`),
  ADD KEY `fk_e_id_EMPLOYEE` (`e_id`),
  ADD KEY `fk_i_id_ITEM` (`i_id`);

--
-- Indexes for table `item_purchase`
--
ALTER TABLE `item_purchase`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `fk_s_id_SUPPLIER` (`s_id`),
  ADD KEY `fk_i_id_ITEM_ip` (`i_id`);

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
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `d_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `e_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `i_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `item_issue`
--
ALTER TABLE `item_issue`
  MODIFY `is_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item_purchase`
--
ALTER TABLE `item_purchase`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  ADD CONSTRAINT `fk_d_id_DEPARTMENT` FOREIGN KEY (`d_id`) REFERENCES `department` (`d_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_c_id_CATEGORY_ITEM` FOREIGN KEY (`c_id`) REFERENCES `category_item` (`c_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item_issue`
--
ALTER TABLE `item_issue`
  ADD CONSTRAINT `fk_e_id_EMPLOYEE` FOREIGN KEY (`e_id`) REFERENCES `employee` (`e_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_i_id_ITEM` FOREIGN KEY (`i_id`) REFERENCES `item` (`i_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item_purchase`
--
ALTER TABLE `item_purchase`
  ADD CONSTRAINT `fk_i_id_ITEM_ip` FOREIGN KEY (`i_id`) REFERENCES `item` (`i_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_s_id_SUPPLIER` FOREIGN KEY (`s_id`) REFERENCES `supplier` (`s_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
