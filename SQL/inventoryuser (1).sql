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
-- Database: `inventoryuser`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbinfo`
--

CREATE TABLE `dbinfo` (
  `db_id` int(5) NOT NULL,
  `location` varchar(500) NOT NULL,
  `db_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbinfo`
--

INSERT INTO `dbinfo` (`db_id`, `location`, `db_name`) VALUES
(1, 'st tower fashion', 'hlfs');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `r_id` int(5) NOT NULL,
  `role` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`r_id`, `role`, `description`) VALUES
(1, 'admin', 'administration'),
(2, 'user', 'store keeper'),
(3, 'super_admin', 'super admin can access all ');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `username`, `password`, `role`, `location`) VALUES
(4, 'sufiun', '25d55ad283aa400af464c76d713c07ad', 'admin', 'hlfs'),
(5, 'hiron', '25d55ad283aa400af464c76d713c07ad', 'user', 'hlfs'),
(7, 'super', '25d55ad283aa400af464c76d713c07ad', 'super_admin', 'hlfs'),
(8, 'root', '$2y$10$GwZSxnLw6vROJL6rYisTdeHkOwQAFR5BEMHV9iBgBn5g62s9Wrjwe', 'super_admin', 'hlfs'),
(9, 'asda', '$2y$10$0JtbsooVdUJbqsTfNZEiD.tdSBkwpranK9bhvncZF.wkHJMSs4LZi', 'admin', 'hlfs'),
(10, 'asda', '$2y$10$7vrmSOvsUKf/OFqQRJLPxeNKO8mJiJovKtzjg6gFomQPIfq2Jtp02', 'admin', 'hlfs'),
(11, 'asda', '$2y$10$1sPX/job/JSxWIu3UFtkruqvOuHwtB/QdbJCMnfcWLdQ5D7JVeD.a', 'admin', 'hlfs'),
(12, 'asda', '$2y$10$AG7Sc.f56KxCliHPYzygy./4OFI0PFCBn5T98UkXRP6ColaDbWOJm', 'admin', 'hlfs'),
(13, 'asda', '$2y$10$mb1RtPrE9FCeuJZAXiOlhO8u4WIs/O.9jePuImVXB2vJBTCRJsJmq', 'admin', 'hlfs'),
(14, 'dim', '$2y$10$tPCMpV7k1lL1trCtMYTFIO9N.B/G5pObN/MOx3LDe2uRP3ANkhynq', 'admin', 'hlfs'),
(15, 'dim', '$2y$10$z7CWRN1mQozVaUF2H6j7..4h0NIz58Wd54B/FvSs1Pj/kkLuxIpGS', 'admin', 'hlfs'),
(16, 'mim', '$2y$10$eScVPJYNrlWYw7JQgrR2seFzOf1TdZa1P0M8Lh.M0rfvKRFI2YVjS', 'admin', 'hlfs');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `t_id` int(5) NOT NULL,
  `u_id` int(11) NOT NULL,
  `csrf` varchar(100) NOT NULL DEFAULT 'NULL',
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`t_id`, `u_id`, `csrf`, `active`) VALUES
(1, 4, '07f95a69ab4361e2dffa72b9952b28903fb4e88f5c587290f0f30968ad3e7a15', 1),
(2, 5, 'fc6e8d46c3efab7d0b29dcecd547e2b9e47b1254f63918f7c468bb21024b4170', 1),
(3, 7, '611fefc81fb2bba1ac75d3388fe74f6b2c1b7aeec0be315a0baf8f1ca6bfba2c', 1),
(4, 14, 'NULL', 0),
(5, 15, 'NULL', 0),
(6, 16, 'NULL', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbinfo`
--
ALTER TABLE `dbinfo`
  ADD PRIMARY KEY (`db_id`),
  ADD UNIQUE KEY `db_name` (`db_name`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`r_id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `bd_name` (`location`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`t_id`),
  ADD UNIQUE KEY `u_id` (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbinfo`
--
ALTER TABLE `dbinfo`
  MODIFY `db_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `r_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `t_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `bd_name` FOREIGN KEY (`location`) REFERENCES `dbinfo` (`db_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role` FOREIGN KEY (`role`) REFERENCES `role` (`role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `u_id` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
