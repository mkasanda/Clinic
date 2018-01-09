-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2013 at 10:13 AM
-- Server version: 5.1.36-community-log
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `unza_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_level`
--

CREATE TABLE IF NOT EXISTS `access_level` (
  `name` varchar(20) NOT NULL,
  `description` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_level`
--

INSERT INTO `access_level` (`name`, `description`) VALUES
('Admin', 'Adminstrator'),
('Medical_Officer', 'Medical_Offocer');

-- --------------------------------------------------------

--
-- Table structure for table `admitted_patient`
--

CREATE TABLE IF NOT EXISTS `admitted_patient` (
  `Ward_Id` varchar(10) NOT NULL,
  `Patient_Id` varchar(10) NOT NULL,
  `Bed_No` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Ward_Id`,`Patient_Id`),
  KEY `Patient_Id_idx` (`Patient_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `Department_Id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Telephone_Number` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Department_Id`),
  UNIQUE KEY `Department_Id_UNIQUE` (`Department_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Department_Id`, `Name`, `Telephone_Number`) VALUES
(1, 'Pharmacy', '224356');

-- --------------------------------------------------------

--
-- Table structure for table `dispensary`
--

CREATE TABLE IF NOT EXISTS `dispensary` (
  `Drug_No` varchar(10) NOT NULL,
  `Quantity_In_Stock` varchar(45) DEFAULT NULL,
  `Requisition_Level` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Drug_No`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dispensary`
--

INSERT INTO `dispensary` (`Drug_No`, `Quantity_In_Stock`, `Requisition_Level`, `description`) VALUES
('1', '243', '50', 'tablets'),
('2', '215', '50', 'tablets'),
('3', '261', '50', 'bottles'),
('4', '285', '50', 'bottles');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE IF NOT EXISTS `fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `description` varchar(35) NOT NULL,
  `amount` varchar(35) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `description` (`description`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`id`, `name`, `description`, `amount`) VALUES
(1, 'Consultation Fee', 'Consultation Fee', '50'),
(2, 'Medical Fee', 'Medical Fee', '50');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `Patient_Id` varchar(10) CHARACTER SET latin1 NOT NULL,
  `f_name` varchar(45) DEFAULT NULL,
  `l_name` varchar(45) DEFAULT NULL,
  `o_name` varchar(45) DEFAULT NULL,
  `Department` varchar(45) DEFAULT NULL,
  `School` varchar(45) DEFAULT NULL,
  `Sex` varchar(1) DEFAULT NULL,
  `DOB` varchar(10) NOT NULL,
  `Type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Patient_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`Patient_Id`, `f_name`, `l_name`, `o_name`, `Department`, `School`, `Sex`, `DOB`, `Type`) VALUES
('101', 'John', 'Daka', '', 'elect', 'beng', 'M', '2013-08-09', 'Student'),
('123', 'Malama', 'Kasanda', NULL, 'Computer studies', 'NS', 'M', '2013-05-14', 'Student'),
('1234/09', 'Changa', 'Chalwe', '', '', 'HSS', 'M', '2013-08-06', 'Student'),
('202', 'Mulako', 'Mufalo', '', 'cs', 'nx', 'M', '2013-08-14', 'Student'),
('245', 'Mwango', 'Chileka', '', 'Geology', 'Mines', 'M', '1995-08-17', 'Student'),
('321', 'Mulomba ', 'Choongo', 'Willson', 'Chemistry', 'NS', 'M', '0000-00-00', 'Student'),
('567', 'Dama', 'Theo', 'Malama', 'Physics', 'NS', 'M', '06/02/2013', 'Student'),
('789', 'Malama', 'Kasa', '', 'CS', 'NS', 'M', '03/06/1986', 'Student'),
('7898', 'William', 'Simukoko', '', 'SD', 'CICT', 'M', '06/09/2013', 'Staff'),
('879', 'Bwlaya', 'Mumba', '', 'chemisty', 'NS', 'M', '2008-08-20', 'Student'),
('908766', 'papapapa', 'ppppdpd', 'pdddd', 'CS', 'NS', 'M', '2013-07-02', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `patient_diagnosis`
--

CREATE TABLE IF NOT EXISTS `patient_diagnosis` (
  `patient_diagnosis_id` int(10) NOT NULL AUTO_INCREMENT,
  `bp` varchar(45) DEFAULT NULL,
  `temp` varchar(45) DEFAULT NULL,
  `weight` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `patient_id` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `diagnosis` text,
  PRIMARY KEY (`patient_diagnosis_id`),
  KEY `Patient_Id_idx` (`patient_id`),
  KEY `Patient_Id` (`patient_id`),
  KEY `Patient_Id_2` (`patient_id`),
  KEY `patient_id_3` (`patient_id`),
  KEY `patient_id_4` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `patient_diagnosis`
--

INSERT INTO `patient_diagnosis` (`patient_diagnosis_id`, `bp`, `temp`, `weight`, `date`, `patient_id`, `diagnosis`) VALUES
(3, '89Hg/mm', '37.8', '89', '11/90/2001', '123', 'Diarehoe\r\noverdoesed neck\r\nrash'),
(4, '76Hg/mm', '40', '78', '05/06/2013', '123', 'Headache\r\nMalaria\r\nConstipation'),
(8, '33', '38.0', '67', '15-07-2013', '123', 'Malaria\nTB'),
(9, '45', '33.8', '77', '09-07-2013', '789', 'Diarrheo\nakaswende'),
(10, '44', '33', '55', '04-07-2013', '321', '77jn\nnne\nnfd'),
(11, 'ghchdhg', 'hfjuf', 'hyvjkg', '09-07-2013', '123', 'cxhjf\nkvkj\njkjl'),
(12, 'sfgs', 'sgfsf', 'sgfs', '01-08-2013', '202', 'sgfsgs'),
(13, '32', '23', '55', '08-08-2013', '101', 'dira'),
(14, '110/80', '36.5', '46', '08-08-2013', '1234/09', 'Malaria');

-- --------------------------------------------------------

--
-- Table structure for table `patient_queue`
--

CREATE TABLE IF NOT EXISTS `patient_queue` (
  `patient_queue` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(10) NOT NULL,
  `time_in` varchar(20) NOT NULL,
  `time_out` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `status` varchar(5) NOT NULL,
  `man_no` varchar(20) NOT NULL,
  PRIMARY KEY (`patient_queue`),
  KEY `man_no` (`man_no`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `patient_queue`
--

INSERT INTO `patient_queue` (`patient_queue`, `patient_id`, `time_in`, `time_out`, `date`, `status`, `man_no`) VALUES
(12, '123', '11:12', '22:37', '07/04/13', '1', ''),
(13, '789', '12:05', '22:39', '07/04/13', '1', ''),
(23, '321', '23:49', '23:53', '07-15-13', '1', ''),
(25, '123', '06:04', '09:51', '07-16-13', '1', ''),
(26, '123', '11:59', '', '07-19-13', '0', ''),
(27, '202', '00:51', '08:50', '08-07-13', '1', ''),
(28, '202', '09:38', '09:51', '08-08-13', '1', ''),
(29, '101', '09:51', '09:54', '08-08-13', '1', ''),
(30, '1234/09', '10:29', '10:49', '08-08-13', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `fee` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` varchar(35) NOT NULL,
  `date` varchar(35) NOT NULL,
  `recieved_by` varchar(35) NOT NULL,
  `reciept_num` varchar(35) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recieved_by` (`recieved_by`),
  KEY `patient_id` (`patient_id`),
  KEY `fee` (`fee`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`fee`, `id`, `amount`, `date`, `recieved_by`, `reciept_num`, `patient_id`) VALUES
(1, 13, '5444', 'jj/jjj/kkk', 'M101', 'ffffff', '123'),
(1, 14, '5444', 'jj/jjj/kkk', 'M101', '888', '123'),
(1, 16, '', '08-08-2013', 'M101', '', '123'),
(2, 17, '50', '08-08-2013', 'M101', '5432', '321');

-- --------------------------------------------------------

--
-- Table structure for table `payment_description`
--

CREATE TABLE IF NOT EXISTS `payment_description` (
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_description`
--

INSERT INTO `payment_description` (`name`) VALUES
('Consultation Fee'),
('Medical Fee');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_stock`
--

CREATE TABLE IF NOT EXISTS `pharmacy_stock` (
  `Item_Id` varchar(10) NOT NULL,
  `Item_Name` varchar(45) DEFAULT NULL,
  `Type` varchar(45) DEFAULT NULL,
  `Max_Stock_Level` varchar(45) DEFAULT NULL,
  `Re_Order_Level` varchar(45) DEFAULT NULL,
  `Quantity_In_Stock` varchar(45) DEFAULT NULL,
  `charge_per_unit` double NOT NULL,
  PRIMARY KEY (`Item_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_stock`
--

INSERT INTO `pharmacy_stock` (`Item_Id`, `Item_Name`, `Type`, `Max_Stock_Level`, `Re_Order_Level`, `Quantity_In_Stock`, `charge_per_unit`) VALUES
('1', 'Panadol', 'Drugs', '1000', '50', '993777', 0.5),
('2', 'Septrin', 'Drugs', '3000', '100', '2889', 0.7),
('3', 'benzoate', 'Drugs', '400', '20', '289', 3),
('4', 'cough syrup', 'Drugs', '3000', '300', '2889', 5),
('5', 'Syringe', 'Surgicals', '1000', '500', '1000', 0.2);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_stock_information`
--

CREATE TABLE IF NOT EXISTS `pharmacy_stock_information` (
  `Item_Id` varchar(10) DEFAULT NULL,
  `Batch_No` varchar(10) NOT NULL,
  `Source` varchar(45) DEFAULT NULL,
  `Quantity_Recieved` varchar(45) DEFAULT NULL,
  `Date_Received` date NOT NULL,
  `Item_Received_By` varchar(10) DEFAULT NULL,
  `Good_Received_Note_No` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Batch_No`,`Date_Received`),
  KEY `Item_Id_idx` (`Item_Id`),
  KEY `Item_Recevied_By_idx` (`Item_Received_By`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_stock_information`
--

INSERT INTO `pharmacy_stock_information` (`Item_Id`, `Batch_No`, `Source`, `Quantity_Recieved`, `Date_Received`, `Item_Received_By`, `Good_Received_Note_No`) VALUES
('1', '121212', 'J.P Phamaceuticals', '1000', '2013-04-01', '111', '121'),
('1', '1212121', 'fdaf', '3000', '2013-08-02', '111', '122'),
('2', '131313', 'Shimabwe Enterprise', '3000', '2013-04-01', '111', '121'),
('3', '141414', 'M. Kasa Phamaceuticals', '400', '2013-04-01', '111', '121'),
('4', '151514', 'Phamazoa Phamaceuticals', '3000', '2013-04-01', '111', '121'),
('1', '6666666', 'ghhkj', '989898', '2013-09-09', '111', '787878'),
('1', 'qreq', 'qwreq', 'qreq', '0000-00-00', '111', 'qre');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `prescription_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `prescriber's_id` varchar(10) DEFAULT NULL,
  `handled` int(11) DEFAULT '0',
  `child_no` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`prescription_id`),
  KEY `chid_idx` (`child_no`),
  KEY `stid_idx` (`prescriber's_id`),
  KEY `paid_idx` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescription_id`, `patient_id`, `date`, `prescriber's_id`, `handled`, `child_no`) VALUES
(32, '202', '2013-08-07', 'M101', 1, NULL),
(33, '202', '2013-08-07', 'M101', 1, NULL),
(34, '202', '2013-08-08', 'M101', 1, NULL),
(35, '0', '2013-08-08', 'M101', 0, NULL),
(36, '101', '2013-08-08', 'M101', 1, NULL),
(37, '101', '2013-08-08', 'M101', 1, NULL),
(38, '1234/09', '2013-08-08', 'M101', 1, NULL),
(39, '1234/09', '2013-08-08', 'M101', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prescription_items`
--

CREATE TABLE IF NOT EXISTS `prescription_items` (
  `prescription_id` int(11) NOT NULL,
  `drug_no` varchar(10) NOT NULL,
  `dosage` varchar(45) DEFAULT NULL,
  `frequency` varchar(45) DEFAULT NULL,
  `formulation` varchar(45) DEFAULT NULL,
  `cost` varchar(45) DEFAULT NULL,
  `given` varchar(10) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`prescription_id`,`drug_no`),
  KEY `pcid_idx` (`prescription_id`),
  KEY `drid_idx` (`drug_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prescription_items`
--

INSERT INTO `prescription_items` (`prescription_id`, `drug_no`, `dosage`, `frequency`, `formulation`, `cost`, `given`, `quantity`) VALUES
(32, '1', '700mg', 'rey', 'efew', '0.5', 'yes', 1),
(32, '2', 'uiio', '457', '324', '0.7', 'yes', 1),
(32, '3', 'truy', 'rey', 'ret', '3', 'yes', 1),
(33, '1', '700mg', 'rey', 'efew', NULL, 'no', 0),
(33, '2', 'uiio', '457', '324', NULL, 'no', 0),
(33, '3', 'truy', 'rey', 'ret', NULL, 'no', 0),
(33, 'default', 'uo', 'ui', 'eryte', NULL, NULL, 0),
(34, '1', 'rt', 're', 'we', NULL, 'no', 0),
(35, '2', '4', '6', 'tab', NULL, NULL, 0),
(35, '3', '5', '6', 'lotion', NULL, NULL, 0),
(35, '4', 'wer', 'wer', 'wer', NULL, NULL, 0),
(37, '2', 'werew', 'wer', 'wer', NULL, NULL, 0),
(37, '3', 'wer', 'wer', 'wrew', NULL, NULL, 0),
(37, '4', 'wer', 'wer', 'wer', NULL, NULL, 0),
(38, '1', '500mg', 'Twice daily', 'Tab', '15', 'yes', 30),
(39, '1', '500mg', 'Twice daily', 'Tab', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requisition`
--

CREATE TABLE IF NOT EXISTS `requisition` (
  `Requistion_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Requisitioned_By` varchar(10) DEFAULT NULL,
  `Stores_Issued_By` varchar(10) DEFAULT NULL,
  `Stores_Received_By` varchar(10) DEFAULT NULL,
  `Date_Requisitioned` date DEFAULT NULL,
  `Date_Stores_Issued` date DEFAULT NULL,
  `Date_Stores_Received` date DEFAULT NULL,
  `Department_Id` varchar(10) DEFAULT NULL,
  `handled` int(1) DEFAULT '0',
  PRIMARY KEY (`Requistion_Id`),
  KEY `Requisitioned_By_idx` (`Requisitioned_By`),
  KEY `Stores_Issued_By_idx` (`Stores_Issued_By`),
  KEY `Stores_Received_By_idx` (`Stores_Received_By`),
  KEY `Department_Id_idx` (`Department_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `requisition`
--

INSERT INTO `requisition` (`Requistion_Id`, `Requisitioned_By`, `Stores_Issued_By`, `Stores_Received_By`, `Date_Requisitioned`, `Date_Stores_Issued`, `Date_Stores_Received`, `Department_Id`, `handled`) VALUES
(3, 'M101', NULL, NULL, '2013-08-07', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requistion_items`
--

CREATE TABLE IF NOT EXISTS `requistion_items` (
  `Item_No` varchar(10) NOT NULL,
  `Quantity_Required` varchar(45) DEFAULT NULL,
  `Quantity_Issued` varchar(45) DEFAULT NULL,
  `requistion_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Item_No`,`requistion_id`),
  KEY `reqid_idx` (`requistion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requistion_items`
--

INSERT INTO `requistion_items` (`Item_No`, `Quantity_Required`, `Quantity_Issued`, `requistion_id`, `status`) VALUES
('1', '888', '111', 3, 1),
('2', '111', '111', 3, 1),
('3', '111', '111', 3, 1),
('4', '111', '111', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `man_no` varchar(10) NOT NULL,
  `f_name` varchar(45) NOT NULL,
  `l_name` varchar(45) NOT NULL,
  `role` varchar(20) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `status` varchar(3) NOT NULL,
  PRIMARY KEY (`man_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`man_no`, `f_name`, `l_name`, `role`, `username`, `password`, `status`) VALUES
('20102', 'Clerk', 'Mumba', 'Clerk', 'user1', '25d55ad283aa400af464c76d713c07ad', '0'),
('9582', 'Clementina', 'Lwatula', 'MO', 'lwatulachalwe', '21232f297a57a5a743894a0e4a801fc3', ''),
('M101', 'Malama', 'Kasanda', 'Admin', 'admin', '098f6bcd4621d373cade4e832627b4f6', '1'),
('M102', 'Mulako', 'Mufalo', 'Clerk', 'mmufalo', '71772b4cddd970e01cedbb773119c16c', '0'),
('M103', 'Mwansa', 'Kasanda', 'Clerk', 'mkasanda', '1282e1d6cd2b2e53218b4ad31c50eed1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE IF NOT EXISTS `ward` (
  `Ward_Id` varchar(10) NOT NULL,
  `Type` varchar(45) DEFAULT NULL,
  `No_Of_Beds` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Ward_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dispensary`
--
ALTER TABLE `dispensary`
  ADD CONSTRAINT `DSPNSRYDrug_No` FOREIGN KEY (`Drug_No`) REFERENCES `pharmacy_stock` (`Item_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fee`
--
ALTER TABLE `fee`
  ADD CONSTRAINT `fee_ibfk_1` FOREIGN KEY (`description`) REFERENCES `payment_description` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_diagnosis`
--
ALTER TABLE `patient_diagnosis`
  ADD CONSTRAINT `Patient_Diagnosis_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`Patient_Id`);

--
-- Constraints for table `patient_queue`
--
ALTER TABLE `patient_queue`
  ADD CONSTRAINT `patient_queue_ibfk_3` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`Patient_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`recieved_by`) REFERENCES `users` (`man_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_4` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`Patient_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_6` FOREIGN KEY (`fee`) REFERENCES `fee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
