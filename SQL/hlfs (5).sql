-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2023 at 10:56 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
,`qty_balance` decimal(32,0)
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
  `c_active` tinyint(1) NOT NULL DEFAULT 1,
  `c_inactive_by` varchar(100) DEFAULT NULL,
  `c_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category_item`
--

INSERT INTO `category_item` (`c_id`, `c_name`, `c_update_datetime`, `c_add_date_time`, `c_add_by`, `c_update_by`, `c_active`, `c_inactive_by`, `c_inactive_datetime`) VALUES
(1, 'coffe', '2023-06-23 13:03:12', '0000-00-00 00:00:00', '', 'sufiun', 1, NULL, NULL),
(2, 'Laptop', '2023-07-12 08:39:12', '2023-06-23 10:20:29', 'sufiun', 'sufiun', 1, NULL, NULL),
(3, 'mouse', '0000-00-00 00:00:00', '2023-07-08 08:21:11', 'sufiun', '', 1, NULL, NULL),
(4, 'mobile', '2023-07-14 10:21:35', '2023-07-11 08:17:33', 'sufiun', 'sufiun', 1, NULL, NULL);

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
  `d_active` tinyint(1) NOT NULL DEFAULT 1,
  `d_inactive_by` varchar(100) DEFAULT NULL,
  `d_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_id`, `d_name`, `d_full_name`, `d_add_date_time`, `d_add_by`, `d_update_date_time`, `d_update_by`, `d_active`, `d_inactive_by`, `d_inactive_datetime`) VALUES
(1, 'IT', 'Information Technology (L-10)', '0000-00-00 00:00:00', '', '2023-07-14 07:59:02', 'sufiun', 1, 'sufiun', '2023-07-14 05:49:12'),
(2, 'HR', 'Human Resorce', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 1, 'sufiun', '2023-07-12 10:13:57'),
(3, 'IPE', 'Industrial & Production Engineering', '0000-00-00 00:00:00', 'sufiun', '2023-06-21 10:25:37', '', 1, NULL, NULL),
(4, 'ABC', 'ABCDFG', '2023-07-08 08:21:11', 'sufiun', '0000-00-00 00:00:00', '', 1, NULL, NULL);

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
  `e_active` tinyint(1) NOT NULL DEFAULT 1,
  `e_inactive_by` varchar(100) DEFAULT NULL,
  `e_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`e_id`, `e_com_id`, `e_name`, `d_id`, `e_designation`, `e_add_date_time`, `e_add_by`, `e_update_date_time`, `e_update_by`, `e_active`, `e_inactive_by`, `e_inactive_datetime`) VALUES
(2, '#HM011290', 'Abu Sufiun', 1, 'Officer', '2023-06-20 13:18:28', 'sufiun', '2023-07-14 09:50:58', 'sufiun', 1, 'sufiun', '2023-07-14 09:50:54'),
(3, '123', 'shakhawat', 1, 'sr. officer', '2023-06-24 11:08:55', '', '2023-07-08 12:32:23', 'sufiun', 1, 'sufiun', '2023-07-08 12:32:20'),
(4, 'HM12345', 'Fahim', 1, 'Ass Manager', '2023-07-08 10:24:16', '', '2023-07-12 08:33:55', 'sufiun', 1, 'sufiun', '2023-07-12 08:06:34'),
(5, '0', 'Rubel', 1, 'Supervisor', '2023-07-14 09:46:42', '', '2023-07-15 10:48:20', 'sufiun', 1, 'sufiun', '2023-07-15 10:48:08');

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
  `i_active` tinyint(1) DEFAULT 1,
  `i_inactive_by` varchar(100) DEFAULT NULL,
  `i_inactive_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`i_id`, `i_name`, `i_manufactured_by`, `i_add_datetime`, `c_id`, `i_unit`, `i_size`, `i_price`, `stock_out_reminder_qty`, `i_update_datetime`, `i_update_by`, `i_add_by`, `i_active`, `i_inactive_by`, `i_inactive_datetime`) VALUES
(1, 'coffe', 'nescafe', '2023-06-22 16:05:00', 1, 'kg', 'large', 500, 10, '2023-06-23 09:12:07', 'sufiun', '', 1, 'sufiun', '2023-06-23 09:11:45'),
(4, 'notebook', 'lenovo', '2023-06-23 08:32:44', 2, 'pic', '15inc', 1500, 2, '2023-06-24 10:42:45', 'sufiun', 'sufiun', 1, 'sufiun', '2023-06-24 08:56:31'),
(6, 'gaming laptop', 'Asus', '2023-06-23 08:32:44', 2, 'pic', '15inc', 1500, 2, '2023-06-23 15:40:28', 'sufiun', 'sufiun', 1, 'sufiun', '2023-06-23 15:40:06'),
(7, 'gold', 'nescafe', '2023-07-08 08:21:11', 1, '500gm', 'L', 500, 5, NULL, '', 'sufiun', 1, NULL, NULL),
(8, 'blootuth', 'hp', '2023-07-08 08:21:11', 3, 'pic', 's', 100, 5, '2023-07-12 08:02:30', 'sufiun', 'sufiun', 1, NULL, NULL),
(9, 'pixel 6', 'google', '2023-07-11 08:17:33', 4, 'pic', '5.5inc', 100, 2, '2023-07-12 10:16:04', 'sufiun', 'sufiun', 1, 'sufiun', '2023-07-12 10:16:02'),
(10, 'pixel 7', 'google', '2023-07-14 07:59:02', 4, 'pic', '6inc', 100, 5, '2023-07-14 10:06:45', 'sufiun', 'sufiun', 1, 'sufiun', '2023-07-14 10:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `item_issue`
--

CREATE TABLE `item_issue` (
  `is_id` int(10) NOT NULL,
  `is_po_no` varchar(50) NOT NULL,
  `is_datetime` datetime NOT NULL,
  `i_id` int(10) NOT NULL,
  `is_qty` int(10) NOT NULL,
  `i_price` float NOT NULL,
  `e_id` int(5) NOT NULL,
  `emp_dep` varchar(100) NOT NULL,
  `is_item_issue_by` varchar(500) NOT NULL,
  `is_avg_price` float NOT NULL,
  `is_profit` float NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_inactive_datetime` datetime NOT NULL,
  `is_inactive_by` varchar(100) NOT NULL,
  `is_inactive_reason` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_issue`
--

INSERT INTO `item_issue` (`is_id`, `is_po_no`, `is_datetime`, `i_id`, `is_qty`, `i_price`, `e_id`, `emp_dep`, `is_item_issue_by`, `is_avg_price`, `is_profit`, `is_active`, `is_inactive_datetime`, `is_inactive_by`, `is_inactive_reason`) VALUES
(37, 'g2', '2023-07-19 14:04:49', 6, 2, 1500, 2, 'IT', 'sufiun', 1500, 0, 1, '0000-00-00 00:00:00', '', ''),
(38, 'g2', '2023-07-19 14:08:06', 6, 2, 1500, 2, 'IT', 'sufiun', 1500, 0, 1, '0000-00-00 00:00:00', '', ''),
(39, 'g3', '2023-07-19 14:08:57', 6, 3, 1500, 2, 'IT', 'sufiun', 1500, 0, 1, '0000-00-00 00:00:00', '', ''),
(40, 'c-3', '2023-07-19 14:18:29', 7, 3, 500, 2, 'IT', 'sufiun', 500, 0, 1, '0000-00-00 00:00:00', '', ''),
(41, 'c3', '2023-07-19 14:18:55', 7, 3, 500, 2, 'IT', 'sufiun', 500, 0, 1, '0000-00-00 00:00:00', '', ''),
(42, 'c4', '2023-07-19 14:19:47', 7, 4, 500, 2, 'IT', 'sufiun', 500, 0, 1, '0000-00-00 00:00:00', '', ''),
(43, 'b10', '2023-07-19 16:45:36', 8, 10, 100, 2, 'IT', 'sufiun', 100, 0, 1, '0000-00-00 00:00:00', '', ''),
(44, 'coffe-6', '2023-07-20 11:01:59', 1, 6, 500, 2, 'IT', 'sufiun', 600, -600, 1, '0000-00-00 00:00:00', '', ''),
(45, 'dsgsfg', '2023-07-20 11:50:42', 8, 5, 100, 2, 'IT', 'sufiun', 100, 0, 1, '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `item_issue_trac`
--

CREATE TABLE `item_issue_trac` (
  `ist_id` int(10) NOT NULL,
  `is_id` int(10) NOT NULL,
  `r_id` int(10) NOT NULL,
  `ist_qty` int(5) NOT NULL,
  `ist_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_issue_trac`
--

INSERT INTO `item_issue_trac` (`ist_id`, `is_id`, `r_id`, `ist_qty`, `ist_price`) VALUES
(41, 37, 67, 2, 1500),
(42, 39, 67, 1, 1500),
(43, 39, 68, 2, 1500),
(44, 40, 69, 2, 500),
(45, 40, 70, 1, 500),
(46, 41, 70, 1, 500),
(47, 41, 71, 2, 500),
(48, 42, 71, 1, 500),
(49, 42, 72, 2, 500),
(50, 42, 73, 1, 500),
(51, 43, 74, 2, 100),
(52, 43, 75, 4, 100),
(53, 43, 76, 4, 100),
(54, 44, 78, 3, 500),
(55, 44, 77, 3, 700),
(56, 45, 79, 3, 100),
(57, 45, 80, 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase`
--

CREATE TABLE `item_purchase` (
  `p_id` int(10) NOT NULL,
  `p_po_no` varchar(20) NOT NULL,
  `i_id` int(10) NOT NULL,
  `s_id` int(10) NOT NULL,
  `p_req_qty` int(5) NOT NULL,
  `p_unit_price` float NOT NULL,
  `p_request_datetime` datetime NOT NULL,
  `p_purchase_by` varchar(500) NOT NULL,
  `p_profit` float NOT NULL,
  `p_request` tinyint(1) NOT NULL DEFAULT 0,
  `p_request_accept_by` varchar(100) NOT NULL,
  `p_request_unaccept_by` varchar(100) NOT NULL,
  `p_recive` tinyint(1) NOT NULL DEFAULT 0,
  `p_request_accept_datetime` datetime DEFAULT NULL,
  `p_request_unaccept_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_purchase`
--

INSERT INTO `item_purchase` (`p_id`, `p_po_no`, `i_id`, `s_id`, `p_req_qty`, `p_unit_price`, `p_request_datetime`, `p_purchase_by`, `p_profit`, `p_request`, `p_request_accept_by`, `p_request_unaccept_by`, `p_recive`, `p_request_accept_datetime`, `p_request_unaccept_datetime`) VALUES
(33, 'g5', 6, 1, 5, 1500, '2023-07-19 14:04:01', 'sufiun', 0, 1, 'sufiun', '', 1, '2023-07-19 14:04:19', '0000-00-00 00:00:00'),
(34, 'c10', 7, 2, 10, 500, '2023-07-19 14:17:04', 'sufiun', 0, 1, 'sufiun', '', 1, '2023-07-19 14:17:36', '0000-00-00 00:00:00'),
(35, 'b2', 8, 1, 2, 100, '2023-07-19 16:44:04', 'sufiun', 0, 1, 'sufiun', '', 1, '2023-07-19 16:44:24', '0000-00-00 00:00:00'),
(36, 'b8', 8, 1, 8, 100, '2023-07-19 16:44:35', 'sufiun', 0, 1, 'sufiun', '', 1, '2023-07-19 16:45:15', '0000-00-00 00:00:00'),
(37, 'coffe1', 1, 1, 3, 500, '2023-07-20 11:00:31', 'sufiun', 0, 1, 'sufiun', '', 1, '2023-07-20 11:01:42', '0000-00-00 00:00:00'),
(38, 'vip-coffe', 1, 4, 3, 700, '2023-07-20 11:00:57', 'sufiun', -600, 1, 'sufiun', '', 1, '2023-07-20 11:01:31', '0000-00-00 00:00:00'),
(39, 'mouse-66', 8, 1, 6, 100, '2023-07-20 11:49:47', 'sufiun', 0, 1, 'sufiun', '', 1, '2023-07-20 11:50:14', '0000-00-00 00:00:00');

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
  `s_active` tinyint(1) NOT NULL DEFAULT 1,
  `s_inactive_by` varchar(100) NOT NULL,
  `s_inactive_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`s_id`, `s_name`, `s_address`, `s_phone`, `s_email`, `s_add_datetime`, `s_add_by`, `s_update_date_time`, `s_update_by`, `s_active`, `s_inactive_by`, `s_inactive_datetime`) VALUES
(1, 'Ranays', 'IDB Dhaka', 178565659, 'storeuser@gmail.com', '0000-00-00 00:00:00', '', '2023-07-08 10:22:27', 'sufiun', 1, 'sufiun', '2023-07-08 10:21:59'),
(2, 's2', 'IDB Dhaka', 1245698700, 'admin@example.com', '0000-00-00 00:00:00', '', '2023-07-15 08:38:00', 'sufiun', 1, '', '0000-00-00 00:00:00'),
(3, 'samsung', 'dhaka', 1723456789, 'abusufiun721998@gmailcom', '2023-07-07 12:41:22', 'sufiun', '2023-07-08 08:21:11', 'sufiun', 1, 'sufiun', '2023-07-07 16:15:19'),
(4, 'samsun mobile', 'asadsd', 12345, 'admin1@example.com', '2023-07-07 12:41:22', 'sufiun', '0000-00-00 00:00:00', '', 1, '', '0000-00-00 00:00:00'),
(9, 'xiomi', 'Gazipur', 14589635, 'xiomi@gmail.com', '2023-07-08 08:21:11', 'sufiun', '2023-07-14 11:00:48', 'sufiun', 1, 'sufiun', '2023-07-14 11:00:44'),
(10, 'xiomi', 'Tongi asd', 1456589236, 'xiomi@gmail.com', '2023-07-15 08:38:00', 'sufiun', '0000-00-00 00:00:00', '', 1, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tem_purchase_recive`
--

CREATE TABLE `tem_purchase_recive` (
  `r_id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `p_recive_by` varchar(50) NOT NULL,
  `p_recive_datetime` datetime NOT NULL,
  `p_expaired_datetime` datetime NOT NULL,
  `p_recive_qty` int(5) NOT NULL,
  `p_stock` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tem_purchase_recive`
--

INSERT INTO `tem_purchase_recive` (`r_id`, `p_id`, `p_recive_by`, `p_recive_datetime`, `p_expaired_datetime`, `p_recive_qty`, `p_stock`) VALUES
(67, 33, 'sufiun', '2023-07-19 14:04:34', '2023-07-31 14:04:00', 3, 0),
(68, 33, 'sufiun', '2023-07-19 14:04:40', '2023-07-31 14:04:00', 2, 0),
(69, 34, 'sufiun', '2023-07-19 14:17:45', '2023-07-30 14:17:00', 2, 0),
(70, 34, 'sufiun', '2023-07-19 14:17:54', '2023-07-31 14:17:00', 2, 0),
(71, 34, 'sufiun', '2023-07-19 14:18:03', '2023-07-31 14:17:00', 3, 0),
(72, 34, 'sufiun', '2023-07-19 14:18:10', '2023-07-31 14:18:00', 2, 0),
(73, 34, 'sufiun', '2023-07-19 14:18:17', '2023-07-31 14:18:00', 1, 0),
(74, 35, 'sufiun', '2023-07-19 16:44:29', '0000-00-00 00:00:00', 2, 0),
(75, 36, 'sufiun', '2023-07-19 16:45:21', '2023-07-26 16:45:00', 4, 0),
(76, 36, 'sufiun', '2023-07-19 16:45:27', '2023-07-31 16:45:00', 4, 0),
(77, 38, 'sufiun', '2023-07-20 11:01:37', '0000-00-00 00:00:00', 3, 0),
(78, 37, 'sufiun', '2023-07-20 11:01:50', '0000-00-00 00:00:00', 3, 0),
(79, 39, 'sufiun', '2023-07-20 11:50:22', '2023-07-21 11:50:00', 3, 0),
(80, 39, 'sufiun', '2023-07-20 11:50:29', '2023-07-22 11:50:00', 2, 0),
(81, 39, 'sufiun', '2023-07-20 11:50:35', '2023-07-29 11:50:00', 1, 1);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `balance`  AS SELECT `i`.`c_id` AS `c_id`, `c`.`c_name` AS `c_name`, `i`.`i_id` AS `i_id`, `i`.`i_name` AS `i_name`, coalesce(`ip`.`total_item_purchase`,0) AS `total_item_purchase`, coalesce(`isss`.`total_item_issue`,0) AS `total_item_issue`, coalesce(`ip`.`total_item_purchase_price`,0) AS `total_item_purchase_price`, coalesce(`isss`.`total_item_issue_price`,0) AS `total_item_issue_price`, coalesce(`ip`.`qty_balance`,0) AS `qty_balance`, coalesce((coalesce(`ip`.`total_item_purchase_price`,0) - coalesce(`isss`.`total_item_issue_price`,0)) / nullif(coalesce(`ip`.`total_item_purchase`,0) - coalesce(`isss`.`total_item_issue`,0),0),0) AS `item_issue_avg_price` FROM (((`item` `i` join `category_item` `c` on(`i`.`c_id` = `c`.`c_id`)) left join (select `ip`.`i_id` AS `i_id`,sum(`r`.`p_recive_qty`) AS `total_item_purchase`,sum(`r`.`p_recive_qty` * `ip`.`p_unit_price`) AS `total_item_purchase_price`,sum(`r`.`p_stock`) AS `qty_balance` from (`tem_purchase_recive` `r` join `item_purchase` `ip` on(`ip`.`p_id` = `r`.`p_id`)) group by `ip`.`i_id`) `ip` on(`i`.`i_id` = `ip`.`i_id`)) left join (select `iss`.`i_id` AS `i_id`,sum(`ist`.`ist_qty`) AS `total_item_issue`,sum(`ist`.`ist_qty` * `ist`.`ist_price`) AS `total_item_issue_price` from (`item_issue_trac` `ist` join `item_issue` `iss` on(`ist`.`is_id` = `iss`.`is_id`)) group by `iss`.`i_id`) `isss` on(`i`.`i_id` = `isss`.`i_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_item_issue`
--
DROP TABLE IF EXISTS `view_item_issue`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_item_issue`  AS SELECT `item_issue`.`i_id` AS `i_id`, sum(coalesce(`item_issue`.`is_qty`,0)) AS `total_item_issue`, sum(coalesce(`item_issue`.`is_qty` * `item_issue`.`is_avg_price`,0)) AS `total_item_issue_price` FROM `item_issue` WHERE `item_issue`.`is_active` = 1 GROUP BY `item_issue`.`i_id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_item_purchase`
--
DROP TABLE IF EXISTS `view_item_purchase`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_item_purchase`  AS SELECT `ip`.`i_id` AS `i_id`, sum(coalesce(`r`.`p_recive_qty`,0)) AS `total_item_purchase`, sum(coalesce(`r`.`p_recive_qty` * `ip`.`p_unit_price`,0)) AS `total_item_purchase_price` FROM (`tem_purchase_recive` `r` join (select `item_purchase`.`p_id` AS `p_id`,`item_purchase`.`i_id` AS `i_id`,`item_purchase`.`p_unit_price` AS `p_unit_price` from `item_purchase`) `ip` on(`ip`.`p_id` = `r`.`p_id`)) GROUP BY `ip`.`i_id` ;

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
-- Indexes for table `item_issue_trac`
--
ALTER TABLE `item_issue_trac`
  ADD PRIMARY KEY (`ist_id`),
  ADD KEY `item_issue_id` (`is_id`),
  ADD KEY `item_purchase_recive_id` (`r_id`);

--
-- Indexes for table `item_purchase`
--
ALTER TABLE `item_purchase`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `p_po_no` (`p_po_no`),
  ADD KEY `fk_s_id_SUPPLIER` (`s_id`),
  ADD KEY `fk_i_id_ITEM_ip` (`i_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tem_purchase_recive`
--
ALTER TABLE `tem_purchase_recive`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `p_id_fk` (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_item`
--
ALTER TABLE `category_item`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `d_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `e_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `i_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_issue`
--
ALTER TABLE `item_issue`
  MODIFY `is_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `item_issue_trac`
--
ALTER TABLE `item_issue_trac`
  MODIFY `ist_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `item_purchase`
--
ALTER TABLE `item_purchase`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `s_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tem_purchase_recive`
--
ALTER TABLE `tem_purchase_recive`
  MODIFY `r_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

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
-- Constraints for table `item_issue_trac`
--
ALTER TABLE `item_issue_trac`
  ADD CONSTRAINT `item_issue_id` FOREIGN KEY (`is_id`) REFERENCES `item_issue` (`is_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `item_purchase_recive_id` FOREIGN KEY (`r_id`) REFERENCES `tem_purchase_recive` (`r_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item_purchase`
--
ALTER TABLE `item_purchase`
  ADD CONSTRAINT `fk_i_id_ITEM_ip` FOREIGN KEY (`i_id`) REFERENCES `item` (`i_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_s_id_SUPPLIER` FOREIGN KEY (`s_id`) REFERENCES `supplier` (`s_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tem_purchase_recive`
--
ALTER TABLE `tem_purchase_recive`
  ADD CONSTRAINT `p_id_fk` FOREIGN KEY (`p_id`) REFERENCES `item_purchase` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
