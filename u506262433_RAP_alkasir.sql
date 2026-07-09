-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 20, 2026 at 09:56 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u506262433_RAP_alkasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `ac_accounts`
--

CREATE TABLE `ac_accounts` (
  `id` int(11) NOT NULL,
  `count_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `account_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `account_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `balance` double(20,4) DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `delete_bit` int(11) DEFAULT 0,
  `account_selection_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `paymenttypes_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `expense_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ac_accounts`
--

INSERT INTO `ac_accounts` (`id`, `count_id`, `store_id`, `parent_id`, `sort_code`, `account_name`, `account_code`, `balance`, `note`, `created_by`, `created_date`, `created_time`, `system_ip`, `system_name`, `status`, `delete_bit`, `account_selection_name`, `paymenttypes_id`, `customer_id`, `supplier_id`, `expense_id`) VALUES
(1, 1, 2, 0, '1', 'Current Assets', 'AC/20/020001', 9842.8500, '', 'AL', '2024-03-18', '11:37:36 pm', '94.202.214.252', '94.202.214.252', 1, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ac_moneydeposits`
--

CREATE TABLE `ac_moneydeposits` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `deposit_date` date DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` varchar(50) DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ac_moneytransfer`
--

CREATE TABLE `ac_moneytransfer` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `transfer_code` varchar(50) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` varchar(50) DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ac_transactions`
--

CREATE TABLE `ac_transactions` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `debit_amt` double(20,4) DEFAULT NULL,
  `credit_amt` double(20,4) DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `ref_accounts_id` int(11) DEFAULT NULL COMMENT 'reference table',
  `ref_moneytransfer_id` int(11) DEFAULT NULL COMMENT 'reference table',
  `ref_moneydeposits_id` int(11) DEFAULT NULL COMMENT 'reference table',
  `ref_salespayments_id` int(11) DEFAULT NULL,
  `ref_salespaymentsreturn_id` int(11) DEFAULT NULL,
  `ref_purchasepayments_id` int(11) DEFAULT NULL,
  `ref_purchasepaymentsreturn_id` int(11) DEFAULT NULL,
  `ref_expense_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ac_transactions`
--

INSERT INTO `ac_transactions` (`id`, `store_id`, `payment_code`, `transaction_date`, `transaction_type`, `debit_account_id`, `credit_account_id`, `debit_amt`, `credit_amt`, `note`, `created_by`, `created_date`, `ref_accounts_id`, `ref_moneytransfer_id`, `ref_moneydeposits_id`, `ref_salespayments_id`, `ref_salespaymentsreturn_id`, `ref_purchasepayments_id`, `ref_purchasepaymentsreturn_id`, `ref_expense_id`, `customer_id`, `supplier_id`, `short_code`) VALUES
(1, 2, '', '2024-03-18', 'OPENING BALANCE', NULL, 1, NULL, 0.0000, '', 'AL', '2024-03-18', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bd_bncategory`
--

CREATE TABLE `bd_bncategory` (
  `bnid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `bnCode` varchar(20) DEFAULT NULL,
  `bnName` varchar(50) DEFAULT NULL,
  `bnDetaiils` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bd_clcategory`
--

CREATE TABLE `bd_clcategory` (
  `clid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `clCode` varchar(20) DEFAULT NULL,
  `clName` varchar(50) DEFAULT NULL,
  `clDetaiils` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bd_sbcategory`
--

CREATE TABLE `bd_sbcategory` (
  `bsid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `bnid` int(11) DEFAULT NULL,
  `bsCode` varchar(20) DEFAULT NULL,
  `bsName` varchar(50) DEFAULT NULL,
  `bsDetaiils` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bd_szcategory`
--

CREATE TABLE `bd_szcategory` (
  `isid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `isCode` varchar(30) DEFAULT NULL,
  `isName` varchar(50) DEFAULT NULL,
  `isDetails` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('40d02457cf45b4e1414be33f9249f71c204b156c', '2607:f8b0:400c:c31::21', 1781948611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738313934383631313b63757272656e63797c733a303a22223b63757272656e63795f706c6163656d656e747c733a303a22223b63757272656e63795f636f64657c733a303a22223b766965775f646174657c733a31303a2264642d6d6d2d79797979223b766965775f74696d657c733a323a223132223b646563696d616c737c733a313a2232223b7174795f646563696d616c737c733a313a2232223b73746f72655f6e616d657c733a31303a22534141532041444d494e223b);

-- --------------------------------------------------------

--
-- Table structure for table `db_bankdetails`
--

CREATE TABLE `db_bankdetails` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `holder_name` varchar(250) DEFAULT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `code` varchar(250) DEFAULT NULL COMMENT 'IFSC or Bank Code',
  `account_type` varchar(250) DEFAULT NULL,
  `account_number` varchar(250) DEFAULT NULL,
  `other_details` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_bankdetails`
--

INSERT INTO `db_bankdetails` (`id`, `store_id`, `country_id`, `holder_name`, `bank_name`, `branch_name`, `code`, `account_type`, `account_number`, `other_details`, `description`, `status`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_brands`
--

CREATE TABLE `db_brands` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `brand_code` varchar(50) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_brands`
--

INSERT INTO `db_brands` (`id`, `store_id`, `brand_code`, `brand_name`, `description`, `status`) VALUES
(392, 2, NULL, 'DELL', '', 1),
(393, 2, NULL, 'HP', '', 1),
(394, 2, NULL, 'SAMSUNG', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_category`
--

CREATE TABLE `db_category` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create category Code',
  `dptid` int(11) DEFAULT NULL,
  `category_code` varchar(50) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_category`
--

INSERT INTO `db_category` (`id`, `store_id`, `count_id`, `dptid`, `category_code`, `category_name`, `description`, `company_id`, `status`) VALUES
(162, 2, 1, 3, '020001', 'Laptop', '', NULL, 1),
(163, 2, 2, 3, '020002', 'Desktop', '', NULL, 1),
(164, 2, 3, 4, '020003', 'ACCESSORIES', '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_cobpayments`
--

CREATE TABLE `db_cobpayments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` mediumtext DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_company`
--

CREATE TABLE `db_company` (
  `id` double DEFAULT NULL,
  `company_code` varchar(150) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `company_website` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `company_logo` text DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL,
  `upi_id` varchar(50) DEFAULT NULL,
  `upi_code` text DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `vat_no` varchar(50) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `bank_details` mediumtext DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `category_init` varchar(5) DEFAULT NULL,
  `item_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `supplier_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_return_init` varchar(5) DEFAULT NULL,
  `customer_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_return_init` varchar(5) DEFAULT NULL,
  `expense_init` varchar(5) DEFAULT NULL,
  `invoice_view` int(11) DEFAULT NULL COMMENT '1=Standard,2=Indian GST',
  `status` int(11) DEFAULT NULL,
  `sms_status` int(11) DEFAULT NULL COMMENT '1=Enable 0=Disable',
  `sales_terms_and_conditions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_company`
--

INSERT INTO `db_company` (`id`, `company_code`, `company_name`, `company_website`, `mobile`, `phone`, `email`, `website`, `company_logo`, `logo`, `upi_id`, `upi_code`, `country`, `state`, `city`, `address`, `postcode`, `gst_no`, `vat_no`, `pan_no`, `bank_details`, `cid`, `category_init`, `item_init`, `supplier_init`, `purchase_init`, `purchase_return_init`, `customer_init`, `sales_init`, `sales_return_init`, `expense_init`, `invoice_view`, `status`, `sms_status`, `sales_terms_and_conditions`) VALUES
(1, '', 'Company Name', NULL, '9999999999', '', 'admin@example.com', '', 'company_logo.png', 'logo-0.png', NULL, NULL, 'India', 'Karnataka', 'Belgaum', 'Address Details', '', '', '', '', '', 1, 'CT', 'IT', 'SP', 'PU', 'PR', 'CU', 'SL', 'PR', 'EX', 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_country`
--

CREATE TABLE `db_country` (
  `id` int(11) NOT NULL,
  `country` varchar(4050) DEFAULT NULL,
  `added_on` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_country`
--

INSERT INTO `db_country` (`id`, `country`, `added_on`, `status`) VALUES
(195, 'United Arab Emirates', '2020-11-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_coupons`
--

CREATE TABLE `db_coupons` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(100) DEFAULT NULL,
  `system_name` varchar(250) DEFAULT NULL,
  `system_ip` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_currency`
--

CREATE TABLE `db_currency` (
  `id` int(11) NOT NULL,
  `currency_name` varchar(50) DEFAULT NULL,
  `currency_code` varchar(20) DEFAULT NULL,
  `currency` blob DEFAULT NULL,
  `symbol` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_currency`
--

INSERT INTO `db_currency` (`id`, `currency_name`, `currency_code`, `currency`, `symbol`, `status`) VALUES
(17, 'United Arab Emirates', 'AED', 0x414544, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_custadvance`
--

CREATE TABLE `db_custadvance` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `system_ip` varchar(250) DEFAULT NULL,
  `system_name` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_customers`
--

CREATE TABLE `db_customers` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Customer Code',
  `customer_code` varchar(20) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `tax_number` varchar(50) DEFAULT NULL,
  `vatin` varchar(100) DEFAULT NULL,
  `opening_balance` double(20,4) DEFAULT NULL,
  `sales_due` double(20,4) DEFAULT NULL,
  `sales_return_due` double(20,4) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `ship_country_id` int(11) DEFAULT NULL,
  `ship_state_id` int(11) DEFAULT NULL,
  `ship_city` varchar(100) DEFAULT NULL,
  `ship_postcode` varchar(10) DEFAULT NULL,
  `ship_address` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `location_link` text DEFAULT NULL,
  `attachment_1` text DEFAULT NULL,
  `price_level_type` varchar(50) DEFAULT 'Increase',
  `price_level` double(20,4) DEFAULT 0.0000,
  `delete_bit` int(11) DEFAULT 0,
  `tot_advance` double(20,4) DEFAULT NULL,
  `credit_limit` double(20,4) DEFAULT -1.0000,
  `shippingaddress_id` int(11) DEFAULT NULL,
  `is_supplier` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_customers`
--

INSERT INTO `db_customers` (`id`, `store_id`, `count_id`, `customer_code`, `customer_name`, `mobile`, `phone`, `email`, `gstin`, `tax_number`, `vatin`, `opening_balance`, `sales_due`, `sales_return_due`, `country_id`, `state_id`, `city`, `postcode`, `address`, `ship_country_id`, `ship_state_id`, `ship_city`, `ship_postcode`, `ship_address`, `system_ip`, `system_name`, `created_date`, `created_time`, `created_by`, `company_id`, `status`, `location_link`, `attachment_1`, `price_level_type`, `price_level`, `delete_bit`, `tot_advance`, `credit_limit`, `shippingaddress_id`, `is_supplier`) VALUES
(1, 1, NULL, 'CU0001', 'Walk-in customer', NULL, '', '', '', '', NULL, 0.0000, 0.0000, 0.0000, 1, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-01', '10:55:54 pm', 'admin', NULL, 1, NULL, NULL, 'Increase', 0.0000, 1, NULL, -1.0000, 1, 0),
(2, 2, 1, 'CU/02/0001', 'Walk-in customer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 248.1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', 'LAPTOP-I5OUIM4R', '2021-02-12', '05:53:37 pm', '', NULL, 1, NULL, NULL, 'Increase', 0.0000, 1, 0.0000, -1.0000, 2, 0),
(3, 2, 2, 'CU/2026/0002', 'RAPID ERP', '', '', '', '', '', NULL, 0.0000, 0.0000, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, '5.31.247.215', '5.31.247.215', '2026-05-19', '09:55:16 pm', 'NIJIM', NULL, 1, '', NULL, 'Increase', 0.0000, 0, 0.0000, -1.0000, 1097, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_customer_coupons`
--

CREATE TABLE `db_customer_coupons` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(100) DEFAULT NULL,
  `system_name` varchar(250) DEFAULT NULL,
  `system_ip` varchar(250) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_customer_payments`
--

CREATE TABLE `db_customer_payments` (
  `id` int(11) NOT NULL,
  `salespayment_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_date` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_department`
--

CREATE TABLE `db_department` (
  `dptid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `dptCode` varchar(20) DEFAULT NULL,
  `dptName` varchar(50) DEFAULT NULL,
  `dptDetails` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_department`
--

INSERT INTO `db_department` (`dptid`, `store_id`, `count_id`, `dptCode`, `dptName`, `dptDetails`, `status`) VALUES
(3, 2, 3, '020047', 'Computers', '', 1),
(4, 2, 4, '020048', 'Mobiles', '', 1),
(5, 2, 5, '020056', 'Watches', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_emailtemplates`
--

CREATE TABLE `db_emailtemplates` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `key` varchar(150) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `variables` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `undelete_bit` int(11) DEFAULT NULL,
  `admin_only` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_emailtemplates`
--

INSERT INTO `db_emailtemplates` (`id`, `store_id`, `key`, `template_name`, `content`, `variables`, `status`, `undelete_bit`, `admin_only`) VALUES
(1, 1, 'SAAS_FORGOT_PASSWORD_EMAIL', 'Site forgot password email template', 'Hi {{user_name}},\r\n\r\nyour OTP is {{email_otp}}\r\n\r\nThank you\r\n{{saas_name}}', '{{user_name}}<br>\r\n{{saas_name}}<br>\r\n{{email_otp}}<br>', 1, 1, 1),
(2, 1, 'SAAS_WELCOME_EMAIL', 'Site welcome email', 'Hi {{user_name}},\r\nYour email id {{email_id}},\r\nwelcome to our {{saas_name}},\r\n\r\nThank you', '{{user_name}}<br>\r\n{{email_id}}<br>\r\n{{saas_name}}<br>', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_expense`
--

CREATE TABLE `db_expense` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Expense Code',
  `expense_code` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `expense_for` varchar(100) DEFAULT NULL,
  `expense_amt` double(20,4) DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_expense_category`
--

CREATE TABLE `db_expense_category` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `category_code` varchar(50) DEFAULT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_fivemojo`
--

CREATE TABLE `db_fivemojo` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `token` text DEFAULT NULL,
  `instance_id` text DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_hold`
--

CREATE TABLE `db_hold` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL COMMENT 'Temprary',
  `reference_no` varchar(50) DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,2) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,2) DEFAULT NULL,
  `discount_to_all_input` double(20,2) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,2) DEFAULT NULL,
  `subtotal` double(20,2) DEFAULT NULL,
  `round_off` double(20,2) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `sales_note` text DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_holditems`
--

CREATE TABLE `db_holditems` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `hold_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sales_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_instamojo`
--

CREATE TABLE `db_instamojo` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sandbox` int(11) DEFAULT NULL,
  `api_key` text DEFAULT NULL,
  `api_token` text DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_instamojo`
--

INSERT INTO `db_instamojo` (`id`, `store_id`, `sandbox`, `api_key`, `api_token`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 1, '', '', '2021-02-22', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_instamojopayments`
--

CREATE TABLE `db_instamojopayments` (
  `id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `buyer_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `amount` decimal(16,2) NOT NULL,
  `purpose` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `expires_at` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `send_sms` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'false',
  `send_email` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'false',
  `sms_status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email_status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `shorturl` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `longurl` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `redirect_url` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `webhook` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `allow_repeated_payments` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'false',
  `customer_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `modified_at` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_items`
--

CREATE TABLE `db_items` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create ITEM Code',
  `item_code` varchar(50) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `dptid` int(11) DEFAULT NULL,
  `scatid` int(11) DEFAULT NULL,
  `clid` int(11) DEFAULT NULL,
  `szid` int(11) DEFAULT NULL,
  `rkid` int(11) DEFAULT NULL,
  `bnid` int(11) DEFAULT NULL,
  `bsid` int(11) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `hsn` varchar(50) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `alert_qty` int(11) DEFAULT NULL,
  `minimum_qty` int(11) NOT NULL DEFAULT 0,
  `maximum_qty` int(11) NOT NULL DEFAULT 0,
  `reorder_qty` int(11) NOT NULL DEFAULT 0,
  `brand_id` int(11) DEFAULT NULL,
  `lot_number` varchar(50) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `price` double(20,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `purchase_price` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `profit_margin` double(20,2) DEFAULT NULL,
  `sales_price` double(20,4) DEFAULT NULL,
  `opening_stock` double DEFAULT NULL,
  `stock` double(20,2) DEFAULT NULL,
  `item_image` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `discount_type` varchar(100) DEFAULT 'Percentage',
  `discount` double(20,2) DEFAULT 0.00,
  `service_bit` int(11) DEFAULT 0,
  `seller_points` double(20,2) DEFAULT 0.00,
  `custom_barcode` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `item_group` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `child_bit` int(11) DEFAULT 0,
  `mrp` double(20,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_items`
--

INSERT INTO `db_items` (`id`, `store_id`, `count_id`, `item_code`, `item_name`, `category_id`, `dptid`, `scatid`, `clid`, `szid`, `rkid`, `bnid`, `bsid`, `sku`, `hsn`, `unit_id`, `alert_qty`, `minimum_qty`, `maximum_qty`, `reorder_qty`, `brand_id`, `lot_number`, `expire_date`, `price`, `tax_id`, `purchase_price`, `tax_type`, `profit_margin`, `sales_price`, `opening_stock`, `stock`, `item_image`, `system_ip`, `system_name`, `created_date`, `created_time`, `created_by`, `company_id`, `status`, `discount_type`, `discount`, `service_bit`, `seller_points`, `custom_barcode`, `description`, `item_group`, `parent_id`, `variant_id`, `child_bit`, `mrp`) VALUES
(1, 2, 1, '100001', 'DELL LAPTOP CORE I7', 162, 3, 0, 0, 0, 0, 0, 0, '', '', 61, 0, 0, 0, 0, 392, NULL, NULL, 100.0000, 150, 100.0000, 'Inclusive', 20.00, 120.0000, 0, 0.00, NULL, '5.31.247.215', '5.31.247.215', '2026-05-19', '09:30:29 pm', 'NIJIM', NULL, 1, 'Percentage', 0.00, 0, 0.00, '', '', 'Single', NULL, NULL, 0, 110.0000),
(2, 2, 2, '100002', 'HP LAPTOP CORE I5', 162, 3, 0, 0, 0, 0, 0, 0, '', '', 61, 0, 0, 0, 0, 393, NULL, NULL, 5000.0000, 150, 5000.0000, 'Inclusive', 20.00, 6000.0000, 0, 6.00, NULL, '5.31.247.215', '5.31.247.215', '2026-05-19', '09:40:26 pm', 'NIJIM', NULL, 1, 'Percentage', 0.00, 0, 0.00, '', '', 'Single', NULL, NULL, 0, 5500.0000),
(3, 2, 3, '100003', 'BOROFONE HOME ADAPTER A60B 18W', 164, 4, 0, 0, 0, 0, 0, 0, '', '', 61, 0, 0, 0, 0, 0, NULL, NULL, 10.0000, 150, 10.0000, 'Inclusive', 200.00, 30.0000, 0, NULL, NULL, '109.177.145.172', '109.177.145.172', '2026-05-21', '10:26:39 pm', 'Sobuj', NULL, 1, 'Fixed', 10.00, 0, 0.00, '', '', 'Single', NULL, NULL, 0, 50.0000);

-- --------------------------------------------------------

--
-- Table structure for table `db_item_models`
--

CREATE TABLE `db_item_models` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `model_code` varchar(50) DEFAULT NULL,
  `model_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_item_models`
--

INSERT INTO `db_item_models` (`id`, `store_id`, `model_code`, `model_name`, `description`, `status`) VALUES
(1, 2, NULL, 'item model', 'model', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_languages`
--

CREATE TABLE `db_languages` (
  `id` int(11) NOT NULL,
  `language` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_languages`
--

INSERT INTO `db_languages` (`id`, `language`, `status`) VALUES
(1, 'English', 1),
(2, 'Russian', 0),
(3, 'Spanish', 0),
(4, 'Arabic', 1),
(5, 'Bangla', 1),
(6, 'French', 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_package`
--

CREATE TABLE `db_package` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `package_type` varchar(50) DEFAULT NULL,
  `package_code` varchar(20) DEFAULT NULL,
  `package_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `monthly_price` double(20,2) DEFAULT NULL,
  `annual_price` double(20,2) DEFAULT NULL,
  `trial_days` int(11) DEFAULT NULL,
  `max_users` int(11) DEFAULT NULL,
  `max_items` int(11) DEFAULT NULL,
  `max_invoices` int(11) DEFAULT NULL,
  `max_warehouses` int(11) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `plan_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_package`
--

INSERT INTO `db_package` (`id`, `store_id`, `package_type`, `package_code`, `package_name`, `description`, `monthly_price`, `annual_price`, `trial_days`, `max_users`, `max_items`, `max_invoices`, `max_warehouses`, `expire_date`, `system_ip`, `system_name`, `created_date`, `created_time`, `created_by`, `status`, `plan_type`) VALUES
(1, 1, 'Free', NULL, 'Free', 'Test description', 0.00, 0.00, 10, 2, 20, 20, 2, '2021-01-14', '127.0.0.1', 'LAPTOP-I5OUIM4R', '2021-01-13', '06:37:21 pm', 'admin', 1, NULL),
(2, 1, 'Paid', NULL, 'Regular', 'Test description', 250.00, 2000.00, 15, 20, 200, 200, 20, NULL, '127.0.0.1', 'LAPTOP-I5OUIM4R', '2021-01-13', '06:39:23 pm', 'admin', 1, NULL),
(3, 1, 'Paid', NULL, 'Ultimate', 'Description', 500.00, 5000.00, 15, -1, -1, -1, -1, NULL, '127.0.0.1', 'LAPTOP-I5OUIM4R', '2021-01-24', '12:35:30 pm', 'admin', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_paymenttypes`
--

CREATE TABLE `db_paymenttypes` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_paymenttypes`
--

INSERT INTO `db_paymenttypes` (`id`, `store_id`, `payment_type`, `status`) VALUES
(36, 2, 'CASH', 1),
(37, 2, 'CREDIT', 1),
(39, 2, 'CARD', 1),
(40, 2, 'CHEQUE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_paypal`
--

CREATE TABLE `db_paypal` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sandbox` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_paypal`
--

INSERT INTO `db_paypal` (`id`, `store_id`, `sandbox`, `email`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 1, '', '2021-02-22', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_paypalpaylog`
--

CREATE TABLE `db_paypalpaylog` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_gross` float(10,2) NOT NULL,
  `currency_code` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payer_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_permissions`
--

CREATE TABLE `db_permissions` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `permissions` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_permissions`
--

INSERT INTO `db_permissions` (`id`, `store_id`, `role_id`, `permissions`) VALUES
(4414, 1, 17, 'items_add'),
(4415, 1, 17, 'items_edit'),
(4416, 1, 17, 'items_delete'),
(4417, 1, 17, 'items_view'),
(4418, 1, 17, 'import_items'),
(4419, 1, 17, 'brand_add'),
(4420, 1, 17, 'brand_edit'),
(4421, 1, 17, 'brand_delete'),
(4422, 1, 17, 'brand_view'),
(4423, 1, 17, 'customers_add'),
(4424, 1, 17, 'customers_edit'),
(4425, 1, 17, 'customers_delete'),
(4426, 1, 17, 'customers_view'),
(4427, 1, 17, 'sales_add'),
(4428, 1, 17, 'sales_edit'),
(4429, 1, 17, 'sales_delete'),
(4430, 1, 17, 'sales_view'),
(4431, 1, 17, 'sales_payment_view'),
(4432, 1, 17, 'sales_payment_add'),
(4433, 1, 17, 'sales_payment_delete'),
(4434, 1, 17, 'sales_report'),
(4435, 1, 17, 'sales_payments_report'),
(4436, 1, 17, 'items_category_add'),
(4437, 1, 17, 'items_category_edit'),
(4438, 1, 17, 'items_category_delete'),
(4439, 1, 17, 'items_category_view'),
(4440, 1, 17, 'print_labels'),
(4441, 1, 17, 'dashboard_view'),
(4442, 1, 17, 'dashboard_info_box_1'),
(4443, 1, 17, 'dashboard_info_box_2'),
(4444, 1, 17, 'dashboard_pur_sal_chart'),
(4445, 1, 17, 'dashboard_recent_items'),
(4446, 1, 17, 'dashboard_stock_alert'),
(4447, 1, 17, 'dashboard_trending_items_chart'),
(4448, 1, 17, 'sales_return_add'),
(4449, 1, 17, 'sales_return_edit'),
(4450, 1, 17, 'sales_return_delete'),
(4451, 1, 17, 'sales_return_view'),
(4452, 1, 17, 'sales_return_report'),
(4453, 1, 17, 'sales_return_payment_view'),
(4454, 1, 17, 'sales_return_payment_add'),
(4455, 1, 17, 'sales_return_payment_delete'),
(4456, 1, 17, 'payment_types_add'),
(4457, 1, 17, 'payment_types_edit'),
(4458, 1, 17, 'payment_types_delete'),
(4459, 1, 17, 'payment_types_view'),
(4460, 1, 17, 'import_customers'),
(4461, 1, 17, 'stock_transfer_add'),
(4462, 1, 17, 'stock_transfer_edit'),
(4463, 1, 17, 'stock_transfer_delete'),
(4464, 1, 17, 'stock_transfer_view'),
(4465, 1, 17, 'seller_points_report'),
(4466, 1, 17, 'services_add'),
(4467, 1, 17, 'services_edit'),
(4468, 1, 17, 'services_delete'),
(4469, 1, 17, 'services_view'),
(4470, 1, 17, 'import_services'),
(4471, 1, 17, 'stock_adjustment_add'),
(4472, 1, 17, 'stock_adjustment_edit'),
(4473, 1, 17, 'stock_adjustment_delete'),
(4474, 1, 17, 'stock_adjustment_view'),
(4475, 1, 17, 'variant_add'),
(4476, 1, 17, 'variant_edit'),
(4477, 1, 17, 'variant_delete'),
(4478, 1, 17, 'variant_view'),
(4479, 1, 17, 'accounts_add'),
(4480, 1, 17, 'accounts_edit'),
(4481, 1, 17, 'accounts_delete'),
(4482, 1, 17, 'accounts_view'),
(4483, 1, 17, 'money_transfer_add'),
(4484, 1, 17, 'money_transfer_edit'),
(4485, 1, 17, 'money_transfer_delete'),
(4486, 1, 17, 'money_transfer_view'),
(4487, 1, 17, 'money_deposit_add'),
(4488, 1, 17, 'money_deposit_edit'),
(4489, 1, 17, 'money_deposit_delete'),
(4490, 1, 17, 'money_deposit_view'),
(4491, 1, 17, 'sales_tax_report'),
(4492, 1, 18, 'tax_add'),
(4493, 1, 18, 'tax_edit'),
(4494, 1, 18, 'tax_delete'),
(4495, 1, 18, 'tax_view'),
(4496, 1, 18, 'units_add'),
(4497, 1, 18, 'units_edit'),
(4498, 1, 18, 'units_delete'),
(4499, 1, 18, 'units_view'),
(4500, 1, 18, 'items_add'),
(4501, 1, 18, 'items_edit'),
(4502, 1, 18, 'items_delete'),
(4503, 1, 18, 'items_view'),
(4504, 1, 18, 'import_items'),
(4505, 1, 18, 'brand_add'),
(4506, 1, 18, 'brand_edit'),
(4507, 1, 18, 'brand_delete'),
(4508, 1, 18, 'brand_view'),
(4509, 1, 18, 'suppliers_add'),
(4510, 1, 18, 'suppliers_edit'),
(4511, 1, 18, 'suppliers_delete'),
(4512, 1, 18, 'suppliers_view'),
(4513, 1, 18, 'purchase_add'),
(4514, 1, 18, 'purchase_edit'),
(4515, 1, 18, 'purchase_delete'),
(4516, 1, 18, 'purchase_view'),
(4517, 1, 18, 'purchase_report'),
(4518, 1, 18, 'purchase_payments_report'),
(4519, 1, 18, 'items_category_add'),
(4520, 1, 18, 'items_category_edit'),
(4521, 1, 18, 'items_category_delete'),
(4522, 1, 18, 'items_category_view'),
(4523, 1, 18, 'print_labels'),
(4524, 1, 18, 'dashboard_view'),
(4525, 1, 18, 'dashboard_info_box_1'),
(4526, 1, 18, 'dashboard_info_box_2'),
(4527, 1, 18, 'dashboard_pur_sal_chart'),
(4528, 1, 18, 'dashboard_recent_items'),
(4529, 1, 18, 'dashboard_stock_alert'),
(4530, 1, 18, 'dashboard_trending_items_chart'),
(4531, 1, 18, 'purchase_return_add'),
(4532, 1, 18, 'purchase_return_edit'),
(4533, 1, 18, 'purchase_return_delete'),
(4534, 1, 18, 'purchase_return_view'),
(4535, 1, 18, 'purchase_return_report'),
(4536, 1, 18, 'purchase_return_payment_view'),
(4537, 1, 18, 'purchase_return_payment_add'),
(4538, 1, 18, 'purchase_return_payment_delete'),
(4539, 1, 18, 'purchase_payment_view'),
(4540, 1, 18, 'purchase_payment_add'),
(4541, 1, 18, 'purchase_payment_delete'),
(4542, 1, 18, 'payment_types_add'),
(4543, 1, 18, 'payment_types_edit'),
(4544, 1, 18, 'payment_types_delete'),
(4545, 1, 18, 'payment_types_view'),
(4546, 1, 18, 'import_suppliers'),
(4547, 1, 18, 'stock_transfer_add'),
(4548, 1, 18, 'stock_transfer_edit'),
(4549, 1, 18, 'stock_transfer_delete'),
(4550, 1, 18, 'stock_transfer_view'),
(4551, 1, 18, 'warehouse_add'),
(4552, 1, 18, 'warehouse_edit'),
(4553, 1, 18, 'warehouse_delete'),
(4554, 1, 18, 'warehouse_view'),
(4555, 1, 18, 'services_add'),
(4556, 1, 18, 'services_edit'),
(4557, 1, 18, 'services_delete'),
(4558, 1, 18, 'services_view'),
(4559, 1, 18, 'import_services'),
(4560, 1, 18, 'stock_adjustment_add'),
(4561, 1, 18, 'stock_adjustment_edit'),
(4562, 1, 18, 'stock_adjustment_delete'),
(4563, 1, 18, 'stock_adjustment_view'),
(4564, 1, 18, 'variant_add'),
(4565, 1, 18, 'variant_edit'),
(4566, 1, 18, 'variant_delete'),
(4567, 1, 18, 'variant_view'),
(4568, 1, 18, 'accounts_add'),
(4569, 1, 18, 'accounts_edit'),
(4570, 1, 18, 'accounts_delete'),
(4571, 1, 18, 'accounts_view'),
(4572, 1, 18, 'money_transfer_add'),
(4573, 1, 18, 'money_transfer_edit'),
(4574, 1, 18, 'money_transfer_delete'),
(4575, 1, 18, 'money_transfer_view'),
(4576, 1, 18, 'money_deposit_add'),
(4577, 1, 18, 'money_deposit_edit'),
(4578, 1, 18, 'money_deposit_delete'),
(4579, 1, 18, 'money_deposit_view'),
(4580, 1, 18, 'purchase_tax_report'),
(5818, 1, 2, 'users_add'),
(5819, 1, 2, 'users_edit'),
(5820, 1, 2, 'users_delete'),
(5821, 1, 2, 'users_view'),
(5822, 1, 2, 'tax_add'),
(5823, 1, 2, 'tax_edit'),
(5824, 1, 2, 'tax_delete'),
(5825, 1, 2, 'tax_view'),
(5826, 1, 2, 'store_edit'),
(5827, 1, 2, 'units_add'),
(5828, 1, 2, 'units_edit'),
(5829, 1, 2, 'units_delete'),
(5830, 1, 2, 'units_view'),
(5831, 1, 2, 'roles_add'),
(5832, 1, 2, 'roles_edit'),
(5833, 1, 2, 'roles_delete'),
(5834, 1, 2, 'roles_view'),
(5835, 1, 2, 'expense_add'),
(5836, 1, 2, 'expense_edit'),
(5837, 1, 2, 'expense_delete'),
(5838, 1, 2, 'expense_view'),
(5839, 1, 2, 'items_add'),
(5840, 1, 2, 'items_edit'),
(5841, 1, 2, 'items_delete'),
(5842, 1, 2, 'items_view'),
(5843, 1, 2, 'import_items'),
(5844, 1, 2, 'brand_add'),
(5845, 1, 2, 'brand_edit'),
(5846, 1, 2, 'brand_delete'),
(5847, 1, 2, 'brand_view'),
(5848, 1, 2, 'suppliers_add'),
(5849, 1, 2, 'suppliers_edit'),
(5850, 1, 2, 'suppliers_delete'),
(5851, 1, 2, 'suppliers_view'),
(5852, 1, 2, 'customers_add'),
(5853, 1, 2, 'customers_edit'),
(5854, 1, 2, 'customers_delete'),
(5855, 1, 2, 'customers_view'),
(5856, 1, 2, 'purchase_add'),
(5857, 1, 2, 'purchase_edit'),
(5858, 1, 2, 'purchase_delete'),
(5859, 1, 2, 'purchase_view'),
(5860, 1, 2, 'sales_add'),
(5861, 1, 2, 'sales_edit'),
(5862, 1, 2, 'sales_delete'),
(5863, 1, 2, 'sales_view'),
(5864, 1, 2, 'sales_payment_view'),
(5865, 1, 2, 'sales_payment_add'),
(5866, 1, 2, 'sales_payment_delete'),
(5867, 1, 2, 'sales_report'),
(5868, 1, 2, 'purchase_report'),
(5869, 1, 2, 'expense_report'),
(5870, 1, 2, 'profit_report'),
(5871, 1, 2, 'stock_report'),
(5872, 1, 2, 'item_sales_report'),
(5873, 1, 2, 'purchase_payments_report'),
(5874, 1, 2, 'sales_payments_report'),
(5875, 1, 2, 'items_category_add'),
(5876, 1, 2, 'items_category_edit'),
(5877, 1, 2, 'items_category_delete'),
(5878, 1, 2, 'items_category_view'),
(5879, 1, 2, 'print_labels'),
(5880, 1, 2, 'expense_category_add'),
(5881, 1, 2, 'expense_category_edit'),
(5882, 1, 2, 'expense_category_delete'),
(5883, 1, 2, 'expense_category_view'),
(5884, 1, 2, 'dashboard_view'),
(5885, 1, 2, 'dashboard_info_box_1'),
(5886, 1, 2, 'dashboard_info_box_2'),
(5887, 1, 2, 'dashboard_pur_sal_chart'),
(5888, 1, 2, 'dashboard_recent_items'),
(5889, 1, 2, 'dashboard_stock_alert'),
(5890, 1, 2, 'dashboard_trending_items_chart'),
(5891, 1, 2, 'send_sms'),
(5892, 1, 2, 'sms_template_edit'),
(5893, 1, 2, 'sms_template_view'),
(5894, 1, 2, 'sms_api_view'),
(5895, 1, 2, 'sms_api_edit'),
(5896, 1, 2, 'purchase_return_add'),
(5897, 1, 2, 'purchase_return_edit'),
(5898, 1, 2, 'purchase_return_delete'),
(5899, 1, 2, 'purchase_return_view'),
(5900, 1, 2, 'purchase_return_report'),
(5901, 1, 2, 'sales_return_add'),
(5902, 1, 2, 'sales_return_edit'),
(5903, 1, 2, 'sales_return_delete'),
(5904, 1, 2, 'sales_return_view'),
(5905, 1, 2, 'sales_return_report'),
(5906, 1, 2, 'sales_return_payment_view'),
(5907, 1, 2, 'sales_return_payment_add'),
(5908, 1, 2, 'sales_return_payment_delete'),
(5909, 1, 2, 'purchase_return_payment_view'),
(5910, 1, 2, 'purchase_return_payment_add'),
(5911, 1, 2, 'purchase_return_payment_delete'),
(5912, 1, 2, 'purchase_payment_view'),
(5913, 1, 2, 'purchase_payment_add'),
(5914, 1, 2, 'purchase_payment_delete'),
(5915, 1, 2, 'payment_types_add'),
(5916, 1, 2, 'payment_types_edit'),
(5917, 1, 2, 'payment_types_delete'),
(5918, 1, 2, 'payment_types_view'),
(5919, 1, 2, 'import_customers'),
(5920, 1, 2, 'import_suppliers'),
(5921, 1, 2, 'stock_transfer_add'),
(5922, 1, 2, 'stock_transfer_edit'),
(5923, 1, 2, 'stock_transfer_delete'),
(5924, 1, 2, 'stock_transfer_view'),
(5925, 1, 2, 'warehouse_add'),
(5926, 1, 2, 'warehouse_edit'),
(5927, 1, 2, 'warehouse_delete'),
(5928, 1, 2, 'warehouse_view'),
(5929, 1, 2, 'supplier_items_report'),
(5930, 1, 2, 'seller_points_report'),
(5931, 1, 2, 'services_add'),
(5932, 1, 2, 'services_edit'),
(5933, 1, 2, 'services_delete'),
(5934, 1, 2, 'services_view'),
(5935, 1, 2, 'quotation_add'),
(5936, 1, 2, 'quotation_edit'),
(5937, 1, 2, 'quotation_delete'),
(5938, 1, 2, 'quotation_view'),
(5939, 1, 2, 'import_services'),
(5940, 1, 2, 'stock_adjustment_add'),
(5941, 1, 2, 'stock_adjustment_edit'),
(5942, 1, 2, 'stock_adjustment_delete'),
(5943, 1, 2, 'stock_adjustment_view'),
(5944, 1, 2, 'variant_add'),
(5945, 1, 2, 'variant_edit'),
(5946, 1, 2, 'variant_delete'),
(5947, 1, 2, 'variant_view'),
(5948, 1, 2, 'accounts_add'),
(5949, 1, 2, 'accounts_edit'),
(5950, 1, 2, 'accounts_delete'),
(5951, 1, 2, 'accounts_view'),
(5952, 1, 2, 'money_transfer_add'),
(5953, 1, 2, 'money_transfer_edit'),
(5954, 1, 2, 'money_transfer_delete'),
(5955, 1, 2, 'money_transfer_view'),
(5956, 1, 2, 'money_deposit_add'),
(5957, 1, 2, 'money_deposit_edit'),
(5958, 1, 2, 'money_deposit_delete'),
(5959, 1, 2, 'money_deposit_view'),
(5960, 1, 2, 'sales_tax_report'),
(5961, 1, 2, 'purchase_tax_report'),
(5962, 1, 2, 'cash_transactions'),
(5963, 1, 2, 'show_all_users_sales_invoices'),
(5964, 1, 2, 'show_all_users_sales_return_invoices'),
(5965, 1, 2, 'show_all_users_purchase_invoices'),
(5966, 1, 2, 'show_all_users_purchase_return_invoices'),
(5967, 1, 2, 'show_all_users_expenses'),
(5968, 1, 2, 'show_all_users_quotations'),
(5969, 1, 2, 'subscription'),
(5970, 1, 2, 'smtp_settings'),
(5971, 1, 2, 'send_email'),
(5972, 1, 2, 'sms_settings'),
(5973, 1, 2, 'email_template_edit'),
(5974, 1, 2, 'email_template_view'),
(5975, 1, 2, 'cust_adv_payments_add'),
(5976, 1, 2, 'cust_adv_payments_edit'),
(5977, 1, 2, 'cust_adv_payments_delete'),
(5978, 1, 2, 'cust_adv_payments_view'),
(5999, 2, 28, 'cust_adv_payments_add'),
(6000, 2, 28, 'cust_adv_payments_edit'),
(6001, 2, 28, 'cust_adv_payments_delete'),
(6002, 2, 28, 'cust_adv_payments_view'),
(6011, 2, 29, 'users_add'),
(6012, 2, 29, 'users_edit'),
(6013, 2, 29, 'users_delete'),
(6014, 2, 29, 'users_view'),
(6015, 2, 29, 'tax_add'),
(6016, 2, 29, 'tax_edit'),
(6017, 2, 29, 'tax_delete'),
(6018, 2, 29, 'tax_view'),
(6019, 2, 29, 'store_edit'),
(6020, 2, 29, 'units_add'),
(6021, 2, 29, 'units_edit'),
(6022, 2, 29, 'units_delete'),
(6023, 2, 29, 'units_view'),
(6024, 2, 29, 'roles_add'),
(6025, 2, 29, 'roles_edit'),
(6026, 2, 29, 'roles_delete'),
(6027, 2, 29, 'roles_view'),
(6028, 2, 29, 'expense_add'),
(6029, 2, 29, 'expense_edit'),
(6030, 2, 29, 'expense_delete'),
(6031, 2, 29, 'expense_view'),
(6032, 2, 29, 'items_add'),
(6033, 2, 29, 'items_edit'),
(6034, 2, 29, 'items_delete'),
(6035, 2, 29, 'items_view'),
(6036, 2, 29, 'import_items'),
(6037, 2, 29, 'brand_add'),
(6038, 2, 29, 'brand_edit'),
(6039, 2, 29, 'brand_delete'),
(6040, 2, 29, 'brand_view'),
(6041, 2, 29, 'suppliers_add'),
(6042, 2, 29, 'suppliers_edit'),
(6043, 2, 29, 'suppliers_delete'),
(6044, 2, 29, 'suppliers_view'),
(6045, 2, 29, 'customers_add'),
(6046, 2, 29, 'customers_edit'),
(6047, 2, 29, 'customers_delete'),
(6048, 2, 29, 'customers_view'),
(6049, 2, 29, 'purchase_add'),
(6050, 2, 29, 'purchase_edit'),
(6051, 2, 29, 'purchase_delete'),
(6052, 2, 29, 'purchase_view'),
(6053, 2, 29, 'sales_add'),
(6054, 2, 29, 'sales_edit'),
(6055, 2, 29, 'sales_delete'),
(6056, 2, 29, 'sales_view'),
(6057, 2, 29, 'sales_payment_view'),
(6058, 2, 29, 'sales_payment_add'),
(6059, 2, 29, 'sales_payment_delete'),
(6060, 2, 29, 'sales_report'),
(6061, 2, 29, 'purchase_report'),
(6062, 2, 29, 'expense_report'),
(6063, 2, 29, 'profit_report'),
(6064, 2, 29, 'stock_report'),
(6065, 2, 29, 'item_sales_report'),
(6066, 2, 29, 'purchase_payments_report'),
(6067, 2, 29, 'sales_payments_report'),
(6068, 2, 29, 'items_category_add'),
(6069, 2, 29, 'items_category_edit'),
(6070, 2, 29, 'items_category_delete'),
(6071, 2, 29, 'items_category_view'),
(6072, 2, 29, 'print_labels'),
(6073, 2, 29, 'expense_category_add'),
(6074, 2, 29, 'expense_category_edit'),
(6075, 2, 29, 'expense_category_delete'),
(6076, 2, 29, 'expense_category_view'),
(6077, 2, 29, 'dashboard_view'),
(6078, 2, 29, 'dashboard_info_box_1'),
(6079, 2, 29, 'dashboard_info_box_2'),
(6080, 2, 29, 'dashboard_pur_sal_chart'),
(6081, 2, 29, 'dashboard_recent_items'),
(6082, 2, 29, 'dashboard_stock_alert'),
(6083, 2, 29, 'dashboard_trending_items_chart'),
(6084, 2, 29, 'send_sms'),
(6085, 2, 29, 'sms_template_edit'),
(6086, 2, 29, 'sms_template_view'),
(6087, 2, 29, 'sms_api_view'),
(6088, 2, 29, 'sms_api_edit'),
(6089, 2, 29, 'purchase_return_add'),
(6090, 2, 29, 'purchase_return_edit'),
(6091, 2, 29, 'purchase_return_delete'),
(6092, 2, 29, 'purchase_return_view'),
(6093, 2, 29, 'purchase_return_report'),
(6094, 2, 29, 'sales_return_add'),
(6095, 2, 29, 'sales_return_edit'),
(6096, 2, 29, 'sales_return_delete'),
(6097, 2, 29, 'sales_return_view'),
(6098, 2, 29, 'sales_return_report'),
(6099, 2, 29, 'sales_return_payment_view'),
(6100, 2, 29, 'sales_return_payment_add'),
(6101, 2, 29, 'sales_return_payment_delete'),
(6102, 2, 29, 'purchase_return_payment_view'),
(6103, 2, 29, 'purchase_return_payment_add'),
(6104, 2, 29, 'purchase_return_payment_delete'),
(6105, 2, 29, 'purchase_payment_view'),
(6106, 2, 29, 'purchase_payment_add'),
(6107, 2, 29, 'purchase_payment_delete'),
(6108, 2, 29, 'payment_types_add'),
(6109, 2, 29, 'payment_types_edit'),
(6110, 2, 29, 'payment_types_delete'),
(6111, 2, 29, 'payment_types_view'),
(6112, 2, 29, 'import_customers'),
(6113, 2, 29, 'import_suppliers'),
(6114, 2, 29, 'stock_transfer_add'),
(6115, 2, 29, 'stock_transfer_edit'),
(6116, 2, 29, 'stock_transfer_delete'),
(6117, 2, 29, 'stock_transfer_view'),
(6118, 2, 29, 'warehouse_add'),
(6119, 2, 29, 'warehouse_edit'),
(6120, 2, 29, 'warehouse_delete'),
(6121, 2, 29, 'warehouse_view'),
(6122, 2, 29, 'supplier_items_report'),
(6123, 2, 29, 'seller_points_report'),
(6124, 2, 29, 'services_add'),
(6125, 2, 29, 'services_edit'),
(6126, 2, 29, 'services_delete'),
(6127, 2, 29, 'services_view'),
(6128, 2, 29, 'quotation_add'),
(6129, 2, 29, 'quotation_edit'),
(6130, 2, 29, 'quotation_delete'),
(6131, 2, 29, 'quotation_view'),
(6132, 2, 29, 'import_services'),
(6133, 2, 29, 'stock_adjustment_add'),
(6134, 2, 29, 'stock_adjustment_edit'),
(6135, 2, 29, 'stock_adjustment_delete'),
(6136, 2, 29, 'stock_adjustment_view'),
(6137, 2, 29, 'variant_add'),
(6138, 2, 29, 'variant_edit'),
(6139, 2, 29, 'variant_delete'),
(6140, 2, 29, 'variant_view'),
(6141, 2, 29, 'accounts_add'),
(6142, 2, 29, 'accounts_edit'),
(6143, 2, 29, 'accounts_delete'),
(6144, 2, 29, 'accounts_view'),
(6145, 2, 29, 'money_transfer_add'),
(6146, 2, 29, 'money_transfer_edit'),
(6147, 2, 29, 'money_transfer_delete'),
(6148, 2, 29, 'money_transfer_view'),
(6149, 2, 29, 'money_deposit_add'),
(6150, 2, 29, 'money_deposit_edit'),
(6151, 2, 29, 'money_deposit_delete'),
(6152, 2, 29, 'money_deposit_view'),
(6153, 2, 29, 'sales_tax_report'),
(6154, 2, 29, 'purchase_tax_report'),
(6155, 2, 29, 'cash_transactions'),
(6156, 2, 29, 'show_all_users_sales_invoices'),
(6157, 2, 29, 'show_all_users_sales_return_invoices'),
(6158, 2, 29, 'show_all_users_purchase_invoices'),
(6159, 2, 29, 'show_all_users_purchase_return_invoices'),
(6160, 2, 29, 'show_all_users_expenses'),
(6161, 2, 29, 'show_all_users_quotations'),
(6162, 2, 29, 'smtp_settings'),
(6163, 2, 29, 'send_email'),
(6164, 2, 29, 'sms_settings'),
(6165, 2, 29, 'email_template_edit'),
(6166, 2, 29, 'email_template_view'),
(6167, 2, 29, 'cust_adv_payments_add'),
(6168, 2, 29, 'cust_adv_payments_edit'),
(6169, 2, 29, 'cust_adv_payments_delete'),
(6170, 2, 29, 'cust_adv_payments_view'),
(6179, 1, 2, 'gstr_1_report'),
(6180, 1, 2, 'gstr_2_report'),
(6181, 1, 2, 'delivery_sheet_report'),
(6182, 1, 2, 'load_sheet_report'),
(6183, 1, 2, 'show_purchase_price'),
(6184, 1, 2, 'customer_orders_report'),
(6185, 1, 2, 'discountCouponAdd'),
(6186, 1, 2, 'discountCouponEdit'),
(6187, 1, 2, 'discountCouponDelete'),
(6188, 1, 2, 'discountCouponView'),
(6189, 2, 2, 'sales_gst_report'),
(6190, 2, 2, 'purchase_gst_report'),
(6191, 2, 2, 'subscription'),
(6192, 1, 2, 'customerCouponAdd'),
(6193, 1, 2, 'customerCouponEdit'),
(6194, 1, 2, 'customerCouponDelete'),
(6195, 1, 2, 'customerCouponView'),
(6196, 1, 2, 'return_items_report'),
(6197, 1, 2, 'help_link'),
(6198, 2, 2, 'recent_sales_invoice_list'),
(6357, 2, 31, 'users_add'),
(6358, 2, 31, 'users_edit'),
(6359, 2, 31, 'users_delete'),
(6360, 2, 31, 'users_view'),
(6361, 2, 31, 'tax_add'),
(6362, 2, 31, 'tax_edit'),
(6363, 2, 31, 'tax_delete'),
(6364, 2, 31, 'tax_view'),
(6365, 2, 31, 'store_edit'),
(6366, 2, 31, 'units_add'),
(6367, 2, 31, 'units_edit'),
(6368, 2, 31, 'units_delete'),
(6369, 2, 31, 'units_view'),
(6370, 2, 31, 'roles_add'),
(6371, 2, 31, 'roles_edit'),
(6372, 2, 31, 'roles_delete'),
(6373, 2, 31, 'roles_view'),
(6374, 2, 31, 'expense_add'),
(6375, 2, 31, 'expense_edit'),
(6376, 2, 31, 'expense_delete'),
(6377, 2, 31, 'expense_view'),
(6378, 2, 31, 'items_add'),
(6379, 2, 31, 'items_edit'),
(6380, 2, 31, 'items_delete'),
(6381, 2, 31, 'items_view'),
(6382, 2, 31, 'import_items'),
(6383, 2, 31, 'brand_add'),
(6384, 2, 31, 'brand_edit'),
(6385, 2, 31, 'brand_delete'),
(6386, 2, 31, 'brand_view'),
(6387, 2, 31, 'suppliers_add'),
(6388, 2, 31, 'suppliers_edit'),
(6389, 2, 31, 'suppliers_delete'),
(6390, 2, 31, 'suppliers_view'),
(6391, 2, 31, 'customers_add'),
(6392, 2, 31, 'customers_edit'),
(6393, 2, 31, 'customers_delete'),
(6394, 2, 31, 'customers_view'),
(6395, 2, 31, 'purchase_add'),
(6396, 2, 31, 'purchase_edit'),
(6397, 2, 31, 'purchase_delete'),
(6398, 2, 31, 'purchase_view'),
(6399, 2, 31, 'sales_add'),
(6400, 2, 31, 'sales_edit'),
(6401, 2, 31, 'sales_delete'),
(6402, 2, 31, 'sales_view'),
(6403, 2, 31, 'sales_payment_view'),
(6404, 2, 31, 'sales_payment_add'),
(6405, 2, 31, 'sales_payment_delete'),
(6406, 2, 31, 'sales_report'),
(6407, 2, 31, 'purchase_report'),
(6408, 2, 31, 'expense_report'),
(6409, 2, 31, 'profit_report'),
(6410, 2, 31, 'stock_report'),
(6411, 2, 31, 'item_sales_report'),
(6412, 2, 31, 'purchase_payments_report'),
(6413, 2, 31, 'sales_payments_report'),
(6414, 2, 31, 'items_category_add'),
(6415, 2, 31, 'items_category_edit'),
(6416, 2, 31, 'items_category_delete'),
(6417, 2, 31, 'items_category_view'),
(6418, 2, 31, 'print_labels'),
(6419, 2, 31, 'expense_category_add'),
(6420, 2, 31, 'expense_category_edit'),
(6421, 2, 31, 'expense_category_delete'),
(6422, 2, 31, 'expense_category_view'),
(6423, 2, 31, 'dashboard_view'),
(6424, 2, 31, 'dashboard_info_box_1'),
(6425, 2, 31, 'dashboard_info_box_2'),
(6426, 2, 31, 'dashboard_pur_sal_chart'),
(6427, 2, 31, 'dashboard_recent_items'),
(6428, 2, 31, 'dashboard_stock_alert'),
(6429, 2, 31, 'dashboard_trending_items_chart'),
(6430, 2, 31, 'send_sms'),
(6431, 2, 31, 'sms_template_edit'),
(6432, 2, 31, 'sms_template_view'),
(6433, 2, 31, 'sms_api_view'),
(6434, 2, 31, 'sms_api_edit'),
(6435, 2, 31, 'purchase_return_add'),
(6436, 2, 31, 'purchase_return_edit'),
(6437, 2, 31, 'purchase_return_delete'),
(6438, 2, 31, 'purchase_return_view'),
(6439, 2, 31, 'purchase_return_report'),
(6440, 2, 31, 'sales_return_add'),
(6441, 2, 31, 'sales_return_edit'),
(6442, 2, 31, 'sales_return_delete'),
(6443, 2, 31, 'sales_return_view'),
(6444, 2, 31, 'sales_return_report'),
(6445, 2, 31, 'sales_return_payment_view'),
(6446, 2, 31, 'sales_return_payment_add'),
(6447, 2, 31, 'sales_return_payment_delete'),
(6448, 2, 31, 'purchase_return_payment_view'),
(6449, 2, 31, 'purchase_return_payment_add'),
(6450, 2, 31, 'purchase_return_payment_delete'),
(6451, 2, 31, 'purchase_payment_view'),
(6452, 2, 31, 'purchase_payment_add'),
(6453, 2, 31, 'purchase_payment_delete'),
(6454, 2, 31, 'payment_types_add'),
(6455, 2, 31, 'payment_types_edit'),
(6456, 2, 31, 'payment_types_delete'),
(6457, 2, 31, 'payment_types_view'),
(6458, 2, 31, 'import_customers'),
(6459, 2, 31, 'import_suppliers'),
(6460, 2, 31, 'stock_transfer_add'),
(6461, 2, 31, 'stock_transfer_edit'),
(6462, 2, 31, 'stock_transfer_delete'),
(6463, 2, 31, 'stock_transfer_view'),
(6464, 2, 31, 'warehouse_add'),
(6465, 2, 31, 'warehouse_edit'),
(6466, 2, 31, 'warehouse_delete'),
(6467, 2, 31, 'warehouse_view'),
(6468, 2, 31, 'supplier_items_report'),
(6469, 2, 31, 'seller_points_report'),
(6470, 2, 31, 'services_add'),
(6471, 2, 31, 'services_edit'),
(6472, 2, 31, 'services_delete'),
(6473, 2, 31, 'services_view'),
(6474, 2, 31, 'quotation_add'),
(6475, 2, 31, 'quotation_edit'),
(6476, 2, 31, 'quotation_delete'),
(6477, 2, 31, 'quotation_view'),
(6478, 2, 31, 'import_services'),
(6479, 2, 31, 'stock_adjustment_add'),
(6480, 2, 31, 'stock_adjustment_edit'),
(6481, 2, 31, 'stock_adjustment_delete'),
(6482, 2, 31, 'stock_adjustment_view'),
(6483, 2, 31, 'variant_add'),
(6484, 2, 31, 'variant_edit'),
(6485, 2, 31, 'variant_delete'),
(6486, 2, 31, 'variant_view'),
(6487, 2, 31, 'accounts_add'),
(6488, 2, 31, 'accounts_edit'),
(6489, 2, 31, 'accounts_delete'),
(6490, 2, 31, 'accounts_view'),
(6491, 2, 31, 'money_transfer_add'),
(6492, 2, 31, 'money_transfer_edit'),
(6493, 2, 31, 'money_transfer_delete'),
(6494, 2, 31, 'money_transfer_view'),
(6495, 2, 31, 'money_deposit_add'),
(6496, 2, 31, 'money_deposit_edit'),
(6497, 2, 31, 'money_deposit_delete'),
(6498, 2, 31, 'money_deposit_view'),
(6499, 2, 31, 'sales_tax_report'),
(6500, 2, 31, 'purchase_tax_report'),
(6501, 2, 31, 'cash_transactions'),
(6502, 2, 31, 'show_all_users_sales_invoices'),
(6503, 2, 31, 'show_all_users_sales_return_invoices'),
(6504, 2, 31, 'show_all_users_purchase_invoices'),
(6505, 2, 31, 'show_all_users_purchase_return_invoices'),
(6506, 2, 31, 'show_all_users_expenses'),
(6507, 2, 31, 'show_all_users_quotations'),
(6508, 2, 31, 'sms_settings'),
(6509, 2, 31, 'cust_adv_payments_add'),
(6510, 2, 31, 'cust_adv_payments_edit'),
(6511, 2, 31, 'cust_adv_payments_delete'),
(6512, 2, 31, 'cust_adv_payments_view'),
(6513, 2, 31, 'gstr_1_report'),
(6514, 2, 31, 'gstr_2_report'),
(6515, 2, 31, 'customer_orders_report'),
(6516, 2, 31, 'load_sheet_report'),
(6517, 2, 31, 'delivery_sheet_report'),
(6518, 2, 31, 'show_purchase_price'),
(6519, 2, 31, 'discountCouponAdd'),
(6520, 2, 31, 'discountCouponEdit'),
(6521, 2, 31, 'discountCouponDelete'),
(6522, 2, 31, 'discountCouponView'),
(6523, 2, 31, 'sales_gst_report'),
(6524, 2, 31, 'purchase_gst_report'),
(6525, 2, 31, 'customerCouponAdd'),
(6526, 2, 31, 'customerCouponEdit'),
(6527, 2, 31, 'customerCouponDelete'),
(6528, 2, 31, 'customerCouponView'),
(6529, 2, 31, 'return_items_report'),
(6530, 2, 31, 'help_link'),
(6531, 2, 31, 'recent_sales_invoice_list'),
(6707, 2, 32, 'units_add'),
(6708, 2, 32, 'units_edit'),
(6709, 2, 32, 'units_delete'),
(6710, 2, 32, 'units_view'),
(6711, 2, 32, 'items_add'),
(6712, 2, 32, 'items_edit'),
(6713, 2, 32, 'items_delete'),
(6714, 2, 32, 'items_view'),
(6715, 2, 32, 'import_items'),
(6716, 2, 32, 'brand_add'),
(6717, 2, 32, 'brand_edit'),
(6718, 2, 32, 'brand_delete'),
(6719, 2, 32, 'brand_view'),
(6720, 2, 32, 'suppliers_add'),
(6721, 2, 32, 'suppliers_edit'),
(6722, 2, 32, 'suppliers_delete'),
(6723, 2, 32, 'suppliers_view'),
(6724, 2, 32, 'customers_add'),
(6725, 2, 32, 'customers_edit'),
(6726, 2, 32, 'customers_delete'),
(6727, 2, 32, 'customers_view'),
(6728, 2, 32, 'purchase_add'),
(6729, 2, 32, 'purchase_edit'),
(6730, 2, 32, 'purchase_delete'),
(6731, 2, 32, 'purchase_view'),
(6732, 2, 32, 'sales_add'),
(6733, 2, 32, 'sales_edit'),
(6734, 2, 32, 'sales_delete'),
(6735, 2, 32, 'sales_view'),
(6736, 2, 32, 'sales_payment_view'),
(6737, 2, 32, 'sales_payment_add'),
(6738, 2, 32, 'sales_payment_delete'),
(6739, 2, 32, 'sales_report'),
(6740, 2, 32, 'purchase_report'),
(6741, 2, 32, 'expense_report'),
(6742, 2, 32, 'profit_report'),
(6743, 2, 32, 'stock_report'),
(6744, 2, 32, 'item_sales_report'),
(6745, 2, 32, 'purchase_payments_report'),
(6746, 2, 32, 'sales_payments_report'),
(6747, 2, 32, 'items_category_add'),
(6748, 2, 32, 'items_category_edit'),
(6749, 2, 32, 'items_category_delete'),
(6750, 2, 32, 'items_category_view'),
(6751, 2, 32, 'print_labels'),
(6752, 2, 32, 'dashboard_view'),
(6753, 2, 32, 'dashboard_info_box_1'),
(6754, 2, 32, 'dashboard_info_box_2'),
(6755, 2, 32, 'dashboard_pur_sal_chart'),
(6756, 2, 32, 'dashboard_recent_items'),
(6757, 2, 32, 'dashboard_stock_alert'),
(6758, 2, 32, 'dashboard_trending_items_chart'),
(6759, 2, 32, 'purchase_return_add'),
(6760, 2, 32, 'purchase_return_edit'),
(6761, 2, 32, 'purchase_return_delete'),
(6762, 2, 32, 'purchase_return_view'),
(6763, 2, 32, 'purchase_return_report'),
(6764, 2, 32, 'sales_return_add'),
(6765, 2, 32, 'sales_return_edit'),
(6766, 2, 32, 'sales_return_delete'),
(6767, 2, 32, 'sales_return_view'),
(6768, 2, 32, 'sales_return_report'),
(6769, 2, 32, 'sales_return_payment_view'),
(6770, 2, 32, 'sales_return_payment_add'),
(6771, 2, 32, 'sales_return_payment_delete'),
(6772, 2, 32, 'purchase_return_payment_view'),
(6773, 2, 32, 'purchase_return_payment_add'),
(6774, 2, 32, 'purchase_return_payment_delete'),
(6775, 2, 32, 'purchase_payment_view'),
(6776, 2, 32, 'purchase_payment_add'),
(6777, 2, 32, 'purchase_payment_delete'),
(6778, 2, 32, 'import_customers'),
(6779, 2, 32, 'import_suppliers'),
(6780, 2, 32, 'stock_transfer_add'),
(6781, 2, 32, 'stock_transfer_edit'),
(6782, 2, 32, 'stock_transfer_delete'),
(6783, 2, 32, 'stock_transfer_view'),
(6784, 2, 32, 'supplier_items_report'),
(6785, 2, 32, 'seller_points_report'),
(6786, 2, 32, 'services_add'),
(6787, 2, 32, 'services_edit'),
(6788, 2, 32, 'services_delete'),
(6789, 2, 32, 'services_view'),
(6790, 2, 32, 'quotation_add'),
(6791, 2, 32, 'quotation_edit'),
(6792, 2, 32, 'quotation_delete'),
(6793, 2, 32, 'quotation_view'),
(6794, 2, 32, 'import_services'),
(6795, 2, 32, 'variant_add'),
(6796, 2, 32, 'variant_edit'),
(6797, 2, 32, 'variant_delete'),
(6798, 2, 32, 'variant_view'),
(6799, 2, 32, 'sales_tax_report'),
(6800, 2, 32, 'purchase_tax_report'),
(6801, 2, 32, 'show_all_users_sales_invoices'),
(6802, 2, 32, 'show_all_users_sales_return_invoices'),
(6803, 2, 32, 'show_all_users_purchase_invoices'),
(6804, 2, 32, 'show_all_users_purchase_return_invoices'),
(6805, 2, 32, 'show_all_users_quotations'),
(6806, 2, 32, 'cust_adv_payments_add'),
(6807, 2, 32, 'cust_adv_payments_edit'),
(6808, 2, 32, 'cust_adv_payments_delete'),
(6809, 2, 32, 'cust_adv_payments_view'),
(6810, 2, 32, 'gstr_1_report'),
(6811, 2, 32, 'gstr_2_report'),
(6812, 2, 32, 'customer_orders_report'),
(6813, 2, 32, 'load_sheet_report'),
(6814, 2, 32, 'delivery_sheet_report'),
(6815, 2, 32, 'show_purchase_price'),
(6816, 2, 32, 'discountCouponAdd'),
(6817, 2, 32, 'discountCouponEdit'),
(6818, 2, 32, 'discountCouponDelete'),
(6819, 2, 32, 'discountCouponView'),
(6820, 2, 32, 'sales_gst_report'),
(6821, 2, 32, 'purchase_gst_report'),
(6822, 2, 32, 'customerCouponAdd'),
(6823, 2, 32, 'customerCouponEdit'),
(6824, 2, 32, 'customerCouponDelete'),
(6825, 2, 32, 'customerCouponView'),
(6826, 2, 32, 'return_items_report'),
(6827, 2, 32, 'help_link'),
(6828, 2, 32, 'recent_sales_invoice_list');

-- --------------------------------------------------------

--
-- Table structure for table `db_purchase`
--

CREATE TABLE `db_purchase` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Purchase Code',
  `purchase_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_status` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL COMMENT 'Purchased qty',
  `round_off` double(20,4) DEFAULT NULL COMMENT 'Pending Qty',
  `grand_total` double(20,4) DEFAULT NULL,
  `purchase_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'Purchase return raised'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_purchase`
--

INSERT INTO `db_purchase` (`id`, `store_id`, `warehouse_id`, `count_id`, `purchase_code`, `reference_no`, `purchase_date`, `purchase_status`, `supplier_id`, `other_charges_input`, `other_charges_tax_id`, `other_charges_amt`, `discount_to_all_input`, `discount_to_all_type`, `tot_discount_to_all_amt`, `subtotal`, `round_off`, `grand_total`, `purchase_note`, `payment_status`, `paid_amount`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `company_id`, `status`, `return_bit`) VALUES
(1, 2, 2, 1, 'PU/2026/0001', '', '2026-05-19', 'Received', 1, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 100.0000, NULL, 100.0000, '', 'Unpaid', 0.0000, '2026-05-19', '09:36:59 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_purchaseitems`
--

CREATE TABLE `db_purchaseitems` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `purchase_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `purchase_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `profit_margin_per` double(20,4) DEFAULT NULL,
  `unit_sales_price` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_purchaseitems`
--

INSERT INTO `db_purchaseitems` (`id`, `store_id`, `purchase_id`, `purchase_status`, `item_id`, `purchase_qty`, `price_per_unit`, `tax_type`, `tax_id`, `tax_amt`, `discount_type`, `discount_input`, `discount_amt`, `unit_total_cost`, `total_cost`, `profit_margin_per`, `unit_sales_price`, `status`, `description`) VALUES
(7148, 2, 1, 'Received', 1, 10.00, 10.0000, 'Inclusive', 150, 4.7600, 'Percentage', 0.0000, 0.0000, 10.0000, 100.0000, NULL, NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `db_purchaseitemsreturn`
--

CREATE TABLE `db_purchaseitemsreturn` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `return_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `profit_margin_per` double(20,4) DEFAULT NULL,
  `unit_sales_price` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_purchasepayments`
--

CREATE TABLE `db_purchasepayments` (
  `id` int(11) NOT NULL,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_purchasepaymentsreturn`
--

CREATE TABLE `db_purchasepaymentsreturn` (
  `id` int(11) NOT NULL,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_purchasereturn`
--

CREATE TABLE `db_purchasereturn` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Purchase Return Code',
  `warehouse_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL COMMENT 'Purchased qty',
  `round_off` double(20,4) DEFAULT NULL COMMENT 'Pending Qty',
  `grand_total` double(20,4) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_quotation`
--

CREATE TABLE `db_quotation` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create quotation Code',
  `quotation_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `quotation_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `quotation_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `round_off` double(20,4) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `quotation_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'quotation return raised',
  `customer_previous_due` double(20,4) DEFAULT NULL,
  `customer_total_due` double(20,4) DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_quotationitems`
--

CREATE TABLE `db_quotationitems` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `quotation_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quotation_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `seller_points` double(20,4) DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_rack`
--

CREATE TABLE `db_rack` (
  `rkid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `rkCode` varchar(20) DEFAULT NULL,
  `rkName` varchar(50) DEFAULT NULL,
  `rkDetails` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_roles`
--

CREATE TABLE `db_roles` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_roles`
--

INSERT INTO `db_roles` (`id`, `store_id`, `role_name`, `description`, `status`) VALUES
(1, 1, 'Admin', 'All Rights Permitted.', 1),
(2, 1, 'Store Admin', 'Note: Apply this role for New Store Admin. ', 1),
(31, 2, 'Manager', '', 1),
(32, 2, 'Salesman', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_sales`
--

CREATE TABLE `db_sales` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `init_code` varchar(100) DEFAULT NULL,
  `count_id` bigint(20) DEFAULT NULL,
  `sales_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,2) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,2) DEFAULT NULL,
  `discount_to_all_input` double(20,2) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,2) DEFAULT NULL,
  `subtotal` double(20,2) DEFAULT NULL,
  `round_off` double(20,2) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `sales_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'sales return raised',
  `customer_previous_due` double(20,2) DEFAULT NULL,
  `customer_total_due` double(20,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_amt` double(20,2) DEFAULT 0.00,
  `invoice_terms` text DEFAULT NULL,
  `sales_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_sales`
--

INSERT INTO `db_sales` (`id`, `store_id`, `warehouse_id`, `init_code`, `count_id`, `sales_code`, `reference_no`, `sales_date`, `due_date`, `sales_status`, `customer_id`, `other_charges_input`, `other_charges_tax_id`, `other_charges_amt`, `discount_to_all_input`, `discount_to_all_type`, `tot_discount_to_all_amt`, `subtotal`, `round_off`, `grand_total`, `sales_note`, `payment_status`, `paid_amount`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `company_id`, `pos`, `status`, `return_bit`, `customer_previous_due`, `customer_total_due`, `quotation_id`, `coupon_id`, `coupon_amt`, `invoice_terms`, `sales_type`) VALUES
(1, 2, 2, 'ARA-26-', 1, 'ARA-26-1', NULL, '2026-05-19', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 110.00, 0.00, 110.0000, '', 'Paid', 110.0000, '2026-05-19', '09:48:25 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(3, 2, 2, 'ARA-26-', 2, 'ARA-26-2', '', '2026-05-19', NULL, 'Final', 3, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 120.00, NULL, 120.0000, '', 'Paid', 120.0000, '2026-05-19', '09:56:24 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(4, 2, 2, 'ARA-26-', 3, 'ARA-26-3', '', '2026-05-20', NULL, 'Final', 2, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 120.00, NULL, 120.0000, '', 'Paid', 120.0000, '2026-05-20', '02:30:32 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(5, 2, 2, 'ARA-26-', 4, 'ARA-26-4', NULL, '2026-05-20', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 5610.00, 0.00, 5610.0000, '', 'Paid', 5610.0000, '2026-05-20', '10:37:31 pm', 'NIJIM', '109.177.10.225', '109.177.10.225', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(6, 2, 2, 'ARA-26-', 5, 'ARA-26-5', NULL, '2026-05-21', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 5610.00, 0.00, 5610.0000, '', 'Paid', 5610.0000, '2026-05-21', '12:08:28 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(7, 2, 2, 'ARA-26-', 6, 'ARA-26-6', NULL, '2026-05-21', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 5610.00, 0.00, 5610.0000, '', 'Paid', 5610.0000, '2026-05-21', '12:12:43 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(8, 2, 2, 'ARA-26-', 7, 'ARA-26-7', NULL, '2026-05-21', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 5610.00, 0.00, 5610.0000, '', 'Paid', 5610.0000, '2026-05-21', '12:37:29 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(9, 2, 2, 'ARA-26-', 8, 'ARA-26-8', NULL, '2026-05-21', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 16610.00, 0.00, 16610.0000, '', 'Paid', 16610.0000, '2026-05-21', '12:44:53 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(10, 2, 2, 'ARA-26-', 9, 'ARA-26-9', NULL, '2026-05-21', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 5610.00, 0.00, 5610.0000, '', 'Paid', 5610.0000, '2026-05-21', '05:38:58 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale'),
(11, 2, 2, 'ARA-26-', 10, 'ARA-26-10', NULL, '2026-05-21', NULL, 'Final', 2, NULL, NULL, NULL, 0.00, 'in_percentage', 0.00, 5610.00, 0.00, 5610.0000, '', 'Paid', 5610.0000, '2026-05-21', '06:03:41 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'wholesale');

-- --------------------------------------------------------

--
-- Table structure for table `db_salesitems`
--

CREATE TABLE `db_salesitems` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sales_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `seller_points` double(20,2) DEFAULT 0.00,
  `purchase_price` double(20,3) DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_salesitems`
--

INSERT INTO `db_salesitems` (`id`, `store_id`, `sales_id`, `sales_status`, `item_id`, `description`, `sales_qty`, `price_per_unit`, `tax_type`, `tax_id`, `tax_amt`, `discount_type`, `discount_input`, `discount_amt`, `unit_total_cost`, `total_cost`, `status`, `seller_points`, `purchase_price`) VALUES
(119699, 2, 1, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119701, 2, 3, 'Final', 1, '', 1.00, 120.0000, 'Inclusive', 150, 5.7100, 'Percentage', NULL, 0.0000, 120.0000, 120.0000, 1, 0.00, 100.000),
(119702, 2, 4, 'Final', 1, '', 1.00, 120.0000, 'Inclusive', 150, 5.7100, 'Percentage', NULL, 0.0000, 120.0000, 120.0000, 1, 0.00, 100.000),
(119703, 2, 5, 'Final', 2, '', 1.00, 5500.0000, 'Inclusive', 150, 261.9000, 'Percentage', 0.0000, 0.0000, 5500.0000, 5500.0000, 1, 0.00, 5000.000),
(119704, 2, 5, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119705, 2, 6, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119706, 2, 6, 'Final', 2, '', 1.00, 5500.0000, 'Inclusive', 150, 261.9000, 'Percentage', 0.0000, 0.0000, 5500.0000, 5500.0000, 1, 0.00, 5000.000),
(119707, 2, 7, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119708, 2, 7, 'Final', 2, '', 1.00, 5500.0000, 'Inclusive', 150, 261.9000, 'Percentage', 0.0000, 0.0000, 5500.0000, 5500.0000, 1, 0.00, 5000.000),
(119709, 2, 8, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119710, 2, 8, 'Final', 2, '', 1.00, 5500.0000, 'Inclusive', 150, 261.9000, 'Percentage', 0.0000, 0.0000, 5500.0000, 5500.0000, 1, 0.00, 5000.000),
(119711, 2, 9, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119712, 2, 9, 'Final', 2, '', 3.00, 5500.0000, 'Inclusive', 150, 785.7100, 'Percentage', 0.0000, 0.0000, 5500.0000, 16500.0000, 1, 0.00, 5000.000),
(119713, 2, 10, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119714, 2, 10, 'Final', 2, '', 1.00, 5500.0000, 'Inclusive', 150, 261.9000, 'Percentage', 0.0000, 0.0000, 5500.0000, 5500.0000, 1, 0.00, 5000.000),
(119715, 2, 11, 'Final', 1, '', 1.00, 110.0000, 'Inclusive', 150, 5.2400, 'Percentage', 0.0000, 0.0000, 110.0000, 110.0000, 1, 0.00, 100.000),
(119716, 2, 11, 'Final', 2, '', 1.00, 5500.0000, 'Inclusive', 150, 261.9000, 'Percentage', 0.0000, 0.0000, 5500.0000, 5500.0000, 1, 0.00, 5000.000);

-- --------------------------------------------------------

--
-- Table structure for table `db_salesitemsreturn`
--

CREATE TABLE `db_salesitemsreturn` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `return_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `purchase_price` double(20,3) DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_salespayments`
--

CREATE TABLE `db_salespayments` (
  `id` int(11) NOT NULL,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `change_return` double(20,4) DEFAULT NULL COMMENT 'Refunding the greater amount',
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  `advance_adjusted` double(20,4) DEFAULT NULL,
  `cheque_number` varchar(100) DEFAULT NULL,
  `cheque_period` int(11) DEFAULT NULL,
  `cheque_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_salespayments`
--

INSERT INTO `db_salespayments` (`id`, `count_id`, `payment_code`, `store_id`, `sales_id`, `payment_date`, `payment_type`, `payment`, `payment_note`, `change_return`, `system_ip`, `system_name`, `created_time`, `created_date`, `created_by`, `status`, `account_id`, `customer_id`, `short_code`, `advance_adjusted`, `cheque_number`, `cheque_period`, `cheque_status`) VALUES
(51379, 1, 'SP/26/0001', 2, 1, '2026-05-19', 'Cash', 110.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '09:48:25 pm', '2026-05-19', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51380, 2, 'SP/26/0002', 2, 3, '2026-05-19', 'CASH', 120.0000, '', NULL, '5.31.247.215', '5.31.247.215', '09:56:24 pm', '2026-05-19', 'NIJIM', 1, NULL, 3, NULL, 0.0000, '', 0, 'Pending'),
(51381, 3, 'SP/26/0003', 2, 4, '2026-05-20', 'CASH', 120.0000, '', NULL, '5.31.247.215', '5.31.247.215', '02:30:32 pm', '2026-05-20', 'NIJIM', 1, NULL, 2, NULL, 0.0000, '', 0, 'Pending'),
(51382, 4, 'SP/26/0004', 2, 5, '2026-05-20', 'Cash', 5610.0000, 'Paid By Cash', 0.0000, '109.177.10.225', '109.177.10.225', '10:37:31 pm', '2026-05-20', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51383, 5, 'SP/26/0005', 2, 6, '2026-05-21', 'Cash', 5610.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '12:08:28 pm', '2026-05-21', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51384, 6, 'SP/26/0006', 2, 7, '2026-05-21', 'Cash', 5610.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '12:12:43 pm', '2026-05-21', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51385, 7, 'SP/26/0007', 2, 8, '2026-05-21', 'Cash', 5610.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '12:37:29 pm', '2026-05-21', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51386, 8, 'SP/26/0008', 2, 9, '2026-05-21', 'Cash', 16610.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '12:44:53 pm', '2026-05-21', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51387, 9, 'SP/26/0009', 2, 10, '2026-05-21', 'Cash', 5610.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '05:38:58 pm', '2026-05-21', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL),
(51388, 10, 'SP/26/0010', 2, 11, '2026-05-21', 'Cash', 5610.0000, 'Paid By Cash', 0.0000, '5.31.247.215', '5.31.247.215', '06:03:41 pm', '2026-05-21', 'NIJIM', 1, NULL, 2, NULL, 0.0000, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_salespaymentsreturn`
--

CREATE TABLE `db_salespaymentsreturn` (
  `id` int(11) NOT NULL,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `change_return` double(20,4) DEFAULT NULL COMMENT 'Refunding the greater amount',
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_salesreturn`
--

CREATE TABLE `db_salesreturn` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Sales Return Code',
  `sales_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `return_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `round_off` double(20,4) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'Return raised or not 1 or null',
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_amt` double(20,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_sales_backup_sequential_fix`
--

CREATE TABLE `db_sales_backup_sequential_fix` (
  `id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `init_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_id` bigint(20) DEFAULT NULL,
  `sales_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `sales_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,2) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,2) DEFAULT NULL,
  `discount_to_all_input` double(20,2) DEFAULT NULL,
  `discount_to_all_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,2) DEFAULT NULL,
  `subtotal` double(20,2) DEFAULT NULL,
  `round_off` double(20,2) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `sales_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'sales return raised',
  `customer_previous_due` double(20,2) DEFAULT NULL,
  `customer_total_due` double(20,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_amt` double(20,2) DEFAULT 0.00,
  `invoice_terms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `db_sales_backup_sequential_fix`
--

INSERT INTO `db_sales_backup_sequential_fix` (`id`, `store_id`, `warehouse_id`, `init_code`, `count_id`, `sales_code`, `reference_no`, `sales_date`, `due_date`, `sales_status`, `customer_id`, `other_charges_input`, `other_charges_tax_id`, `other_charges_amt`, `discount_to_all_input`, `discount_to_all_type`, `tot_discount_to_all_amt`, `subtotal`, `round_off`, `grand_total`, `sales_note`, `payment_status`, `paid_amount`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `company_id`, `pos`, `status`, `return_bit`, `customer_previous_due`, `customer_total_due`, `quotation_id`, `coupon_id`, `coupon_amt`, `invoice_terms`, `sales_type`) VALUES
(44753, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-4468344191', 'SOHEL', '2025-12-31', NULL, 'Final', 251, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 246.75, NULL, 246.7500, '', 'Unpaid', 0.0000, '2025-12-31', '09:47:54 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44757, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 825, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 137.55, NULL, 137.5500, '', 'Unpaid', 0.0000, '2025-12-31', '09:51:33 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44758, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 388, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 243.60, NULL, 243.6000, '', 'Unpaid', 0.0000, '2025-12-31', '09:53:40 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44759, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 388, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 249.90, NULL, 249.9000, '', 'Paid', 249.9000, '2025-12-31', '09:58:37 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44760, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 746, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 84.00, NULL, 84.0000, '', 'Paid', 84.0000, '2025-12-31', '10:01:13 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44761, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 379, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 178.50, NULL, 178.5000, '', 'Unpaid', 0.0000, '2025-12-31', '10:02:26 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44762, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 860, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 280.50, NULL, 280.5000, '', 'Paid', 280.5000, '2025-12-31', '10:07:26 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44763, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 821, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 262.50, NULL, 262.5000, '', 'Unpaid', 0.0000, '2025-12-31', '10:12:06 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44764, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 471, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 493.50, NULL, 493.5000, '', 'Paid', 493.5000, '2025-12-31', '10:13:36 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44765, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 471, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 693.00, NULL, 693.0000, '', 'Paid', 693.0000, '2025-12-31', '10:19:08 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44766, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 38, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 115.50, NULL, 115.5000, '', 'Paid', 115.5000, '2025-12-31', '10:20:09 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44767, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 806, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 33.60, NULL, 33.6000, '', 'Unpaid', 0.0000, '2025-12-31', '10:21:39 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44768, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', '', '2025-12-31', NULL, 'Final', 1005, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 2919.58, NULL, 2919.5800, '', 'Unpaid', 0.0000, '2025-12-31', '10:23:19 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44769, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', '44190', '2025-12-31', NULL, 'Final', 995, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 1170.54, NULL, 1170.5400, '', 'Unpaid', 0.0000, '2025-12-31', '10:26:49 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44770, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483647', 'SOHEL', '2025-12-31', NULL, 'Final', 214, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 147.00, NULL, 147.0000, '', 'Unpaid', 0.0000, '2025-12-31', '11:16:52 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'retail'),
(44771, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 29, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 134.40, NULL, 134.4000, '', 'Unpaid', 0.0000, '2025-12-31', '11:24:39 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44772, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 214, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 44.10, NULL, 44.1000, '', 'Unpaid', 0.0000, '2025-12-31', '11:33:47 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44773, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 298, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 163.80, NULL, 163.8000, '', 'Unpaid', 0.0000, '2025-12-31', '12:25:59 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44774, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483647', 'HELAL', '2025-12-31', NULL, 'Final', 345, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 529.20, NULL, 529.2000, '', 'Paid', 529.2000, '2025-12-31', '01:42:40 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'retail'),
(44775, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 226, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 169.58, NULL, 169.5800, '', 'Unpaid', 0.0000, '2025-12-31', '04:45:22 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44776, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 1009, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 427.87, NULL, 427.8700, '', 'Unpaid', 0.0000, '2025-12-31', '04:54:16 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44777, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 15, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 294.00, NULL, 294.0000, '', 'Unpaid', 0.0000, '2025-12-31', '04:59:22 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44778, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 992, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 332.85, NULL, 332.8500, '', 'Paid', 332.8500, '2025-12-31', '05:05:28 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44779, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 551, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 132.30, NULL, 132.3000, '', 'Unpaid', 0.0000, '2025-12-31', '05:07:21 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44780, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 913, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 84.00, NULL, 84.0000, '', 'Paid', 84.0000, '2025-12-31', '05:08:56 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44781, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 778, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 117.60, NULL, 117.6000, '', 'Paid', 117.6000, '2025-12-31', '05:11:55 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44782, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2026-01-01', NULL, 'Final', 248, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 285.60, NULL, 285.6000, '', 'Unpaid', 0.0000, '2025-12-31', '05:16:13 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44783, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 663, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 142.80, NULL, 142.8000, '', 'Unpaid', 0.0000, '2025-12-31', '05:22:21 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44784, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'RASHED', '2025-12-31', NULL, 'Final', 663, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 78.75, NULL, 78.7500, '', 'Unpaid', 0.0000, '2025-12-31', '05:31:19 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44785, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483647', 'SOHEL', '2025-12-31', NULL, 'Final', 297, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 221.03, NULL, 221.0300, '', 'Unpaid', 0.0000, '2025-12-31', '06:44:45 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'retail'),
(44786, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 776, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 97.65, NULL, 97.6500, '', 'Unpaid', 0.0000, '2025-12-31', '06:52:05 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44787, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 237, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 149.63, NULL, 149.6300, '', 'Unpaid', 0.0000, '2025-12-31', '06:53:44 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44788, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 619, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 808.42, NULL, 808.4200, '', 'Unpaid', 0.0000, '2025-12-31', '08:58:58 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44789, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 171, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 170.10, NULL, 170.1000, '', 'Unpaid', 0.0000, '2025-12-31', '09:00:55 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44790, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 414, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 84.80, NULL, 84.8000, '', 'Unpaid', 0.0000, '2025-12-31', '09:04:45 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44791, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 414, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 84.80, NULL, 84.8000, '', 'Unpaid', 0.0000, '2025-12-31', '09:05:23 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44792, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 414, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 78.05, NULL, 78.0500, '', 'Unpaid', 0.0000, '2025-12-31', '09:06:55 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44793, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 414, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 84.80, NULL, 84.8000, '', 'Unpaid', 0.0000, '2025-12-31', '09:07:35 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44794, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2025-12-31', NULL, 'Final', 414, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 69.30, NULL, 69.3000, '', 'Unpaid', 0.0000, '2025-12-31', '09:07:46 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44795, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 821, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 1452.99, NULL, 1452.9900, '', 'Unpaid', 0.0000, '2025-12-31', '09:11:02 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44796, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2025-12-31', NULL, 'Final', 821, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 913.50, NULL, 913.5000, '', 'Unpaid', 0.0000, '2025-12-31', '09:12:21 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44797, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 469, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 87.15, NULL, 87.1500, '', 'Unpaid', 0.0000, '2026-01-01', '09:54:54 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44798, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 29, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 67.20, NULL, 67.2000, '', 'Unpaid', 0.0000, '2026-01-01', '09:56:37 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44799, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 214, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 33.60, NULL, 33.6000, '', 'Unpaid', 0.0000, '2026-01-01', '09:58:11 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44800, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2026-01-01', NULL, 'Final', 244, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 346.46, NULL, 346.4600, '', 'Unpaid', 0.0000, '2026-01-01', '10:01:40 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44801, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 29, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 128.63, NULL, 128.6300, '', 'Unpaid', 0.0000, '2026-01-01', '11:24:53 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44802, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 251, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 59.85, NULL, 59.8500, '', 'Unpaid', 0.0000, '2026-01-01', '11:29:07 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44803, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 634, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 138.60, NULL, 138.6000, '', 'Unpaid', 0.0000, '2026-01-01', '11:35:26 am', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44804, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHEL', '2026-01-01', NULL, 'Final', 29, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 92.40, NULL, 92.4000, '', 'Unpaid', 0.0000, '2026-01-01', '12:35:12 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44805, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483647', 'SOHEL', '2026-01-01', NULL, 'Final', 784, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 86.10, NULL, 86.1000, '', 'Unpaid', 0.0000, '2026-01-01', '12:40:47 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 'retail'),
(44806, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'HELAL', '2026-01-01', NULL, 'Final', 215, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 47.25, NULL, 47.2500, '', 'Unpaid', 0.0000, '2026-01-01', '12:46:36 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL),
(44807, 2, 2, 'ARA-25-', 2147483647, 'ARA-25-2147483648', 'SOHAG', '2026-01-01', NULL, 'Final', 215, NULL, NULL, NULL, NULL, 'in_percentage', NULL, 136.50, NULL, 136.5000, '', 'Unpaid', 0.0000, '2026-01-01', '01:45:20 pm', 'AL', '87.201.95.141', '87.201.95.141', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0.00, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_shippingaddress`
--

CREATE TABLE `db_shippingaddress` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `postcode` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `location_link` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_shippingaddress`
--

INSERT INTO `db_shippingaddress` (`id`, `store_id`, `country_id`, `state_id`, `city`, `postcode`, `address`, `status`, `customer_id`, `location_link`) VALUES
(1097, 2, 0, 0, '', '', '', 1, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `db_sitesettings`
--

CREATE TABLE `db_sitesettings` (
  `id` int(11) NOT NULL,
  `version` varchar(10) DEFAULT NULL,
  `site_name` varchar(100) DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL COMMENT 'path',
  `machine_id` text DEFAULT NULL,
  `domain` text DEFAULT NULL,
  `unique_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_sitesettings`
--

INSERT INTO `db_sitesettings` (`id`, `version`, `site_name`, `logo`, `machine_id`, `domain`, `unique_code`) VALUES
(1, '2.91', 'RAPID', '/uploads/site/alkasir2.jpg', '1', 'www.alahlyalafraah.com', '4dlsx2ka8qtehfyjzpm763orgiwn1b');

-- --------------------------------------------------------

--
-- Table structure for table `db_smsapi`
--

CREATE TABLE `db_smsapi` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `info` varchar(150) DEFAULT NULL,
  `key` varchar(600) DEFAULT NULL,
  `key_value` varchar(600) DEFAULT NULL,
  `delete_bit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_smsapi`
--

INSERT INTO `db_smsapi` (`id`, `store_id`, `info`, `key`, `key_value`, `delete_bit`) VALUES
(26, 2, 'url', 'weblink', 'http://example.com/sendmessage', NULL),
(27, 2, 'mobile', 'mobiles', '', NULL),
(28, 2, 'message', 'message', '', NULL),
(29, 1, 'url', 'weblink', 'https://www.example.com/api/mt/SendSMS?', NULL),
(30, 1, 'mobile', 'mobiles', '', NULL),
(31, 1, 'message', 'message', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_smstemplates`
--

CREATE TABLE `db_smstemplates` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `variables` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `undelete_bit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_smstemplates`
--

INSERT INTO `db_smstemplates` (`id`, `store_id`, `template_name`, `content`, `variables`, `status`, `undelete_bit`) VALUES
(1, 1, 'GREETING TO CUSTOMER ON SALES', 'Hi {{customer_name}},\r\nYour sales Id is {{sales_id}},\r\nSales Date {{sales_date}},\r\nTotal amount  {{sales_amount}},\r\nYou have paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again', '{{customer_name}}<br>                          \r\n{{sales_id}}<br>\r\n{{sales_date}}<br>\r\n{{sales_amount}}<br>\r\n{{paid_amt}}<br>\r\n{{due_amt}}<br>\r\n{{store_name}}<br>\r\n{{store_mobile}}<br>\r\n{{store_address}}<br>\r\n{{store_website}}<br>\r\n{{store_email}}<br>\r\n', 1, 1),
(2, 1, 'GREETING TO CUSTOMER ON SALES RETURN', 'Hi {{customer_name}},\r\nYour sales return Id is {{return_id}},\r\nReturn Date {{return_date}},\r\nTotal amount  {{return_amount}},\r\nWe paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again', '{{customer_name}}<br>                          \r\n{{return_id}}<br>\r\n{{return_date}}<br>\r\n{{return_amount}}<br>\r\n{{paid_amt}}<br>\r\n{{due_amt}}<br>\r\n{{company_name}}<br>\r\n{{company_mobile}}<br>\r\n{{company_address}}<br>\r\n{{company_website}}<br>\r\n{{company_email}}<br>', 1, 1),
(12, 2, 'GREETING TO CUSTOMER ON SALES', 'Hi {{customer_name}},\r\nYour sales Id is {{sales_id}},\r\nSales Date {{sales_date}},\r\nTotal amount  {{sales_amount}},\r\nYou have paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again', '{{customer_name}}                          \r\n{{sales_id}}\r\n{{sales_date}}\r\n{{sales_amount}}\r\n{{paid_amt}}\r\n{{due_amt}}\r\n{{store_name}}\r\n{{store_mobile}}\r\n{{store_address}}\r\n{{store_website}}\r\n{{store_email}}\r\n', 1, 1),
(13, 2, 'GREETING TO CUSTOMER ON SALES RETURN', 'Hi {{customer_name}},\r\nYour sales return Id is {{return_id}},\r\nReturn Date {{return_date}},\r\nTotal amount  {{return_amount}},\r\nWe paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again', '{{customer_name}}                          \r\n{{return_id}}\r\n{{return_date}}\r\n{{return_amount}}\r\n{{paid_amt}}\r\n{{due_amt}}\r\n{{company_name}}\r\n{{company_mobile}}\r\n{{company_address}}\r\n{{company_website}}\r\n{{company_email}}\r\n', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_sobpayments`
--

CREATE TABLE `db_sobpayments` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` mediumtext DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_states`
--

CREATE TABLE `db_states` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `state_code` varchar(10) DEFAULT NULL,
  `state` varchar(4050) DEFAULT NULL,
  `country_code` varchar(15) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `added_on` date DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_states`
--

INSERT INTO `db_states` (`id`, `store_id`, `state_code`, `state`, `country_code`, `country_id`, `country`, `added_on`, `company_id`, `status`) VALUES
(64, 2, NULL, 'Sharjah', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1),
(65, 2, NULL, 'ABU DHABI', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1),
(66, 2, NULL, 'Dubai', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1),
(67, 2, NULL, 'Ajman', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1),
(68, 2, NULL, 'Umm Al Quwain', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1),
(69, 2, NULL, 'Ras Al Khaimah', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1),
(70, 2, NULL, 'Fujairah', NULL, NULL, 'United Arab Emirates', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_stockadjustment`
--

CREATE TABLE `db_stockadjustment` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `adjustment_date` date DEFAULT NULL,
  `adjustment_note` mediumtext DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_stockadjustment`
--

INSERT INTO `db_stockadjustment` (`id`, `store_id`, `warehouse_id`, `reference_no`, `adjustment_date`, `adjustment_note`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `status`) VALUES
(1, 2, 2, '', '2026-05-19', '', '2026-05-19', '09:41:29 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_stockadjustmentitems`
--

CREATE TABLE `db_stockadjustmentitems` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `adjustment_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `adjustment_qty` double(20,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_stockadjustmentitems`
--

INSERT INTO `db_stockadjustmentitems` (`id`, `store_id`, `warehouse_id`, `adjustment_id`, `item_id`, `adjustment_qty`, `status`, `description`) VALUES
(3332, 2, 2, 1, 2, 15.00, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `db_stockentry`
--

CREATE TABLE `db_stockentry` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_stocktransfer`
--

CREATE TABLE `db_stocktransfer` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT 'from store',
  `to_store_id` int(11) DEFAULT NULL COMMENT 'to store transfer',
  `warehouse_from` int(11) DEFAULT NULL,
  `warehouse_to` int(11) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_stocktransferitems`
--

CREATE TABLE `db_stocktransferitems` (
  `id` int(11) NOT NULL,
  `stocktransfer_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT 'from store',
  `to_store_id` int(11) DEFAULT NULL COMMENT 'to store',
  `warehouse_from` int(11) DEFAULT NULL COMMENT 'warehouse ids',
  `warehouse_to` int(11) DEFAULT NULL COMMENT 'warehouse ids',
  `item_id` int(11) DEFAULT NULL,
  `transfer_qty` double(20,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_store`
--

CREATE TABLE `db_store` (
  `id` int(11) NOT NULL,
  `store_code` varchar(150) DEFAULT NULL,
  `store_name` varchar(150) DEFAULT NULL,
  `store_website` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `store_logo` text DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL,
  `upi_id` varchar(50) DEFAULT NULL,
  `upi_code` text DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `vat_no` varchar(50) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `bank_details` mediumtext DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `category_init` varchar(50) DEFAULT NULL,
  `item_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `supplier_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_return_init` varchar(50) DEFAULT NULL,
  `customer_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_return_init` varchar(50) DEFAULT NULL,
  `expense_init` varchar(50) DEFAULT NULL,
  `accounts_init` varchar(50) DEFAULT NULL,
  `journal_init` varchar(50) DEFAULT NULL,
  `cust_advance_init` varchar(50) DEFAULT NULL,
  `invoice_view` int(11) DEFAULT NULL COMMENT '1=Standard,2=Indian GST',
  `sms_status` int(11) DEFAULT NULL COMMENT '1=Enable 0=Disable',
  `status` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_placement` varchar(50) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `date_format` varchar(50) DEFAULT NULL,
  `time_format` int(11) DEFAULT NULL,
  `sales_discount` double(20,4) DEFAULT NULL,
  `currencysymbol_id` int(11) DEFAULT NULL,
  `regno_key` varchar(50) DEFAULT NULL,
  `fav_icon` text DEFAULT NULL,
  `purchase_code` text DEFAULT NULL,
  `change_return` int(11) DEFAULT NULL,
  `sales_invoice_format_id` int(11) DEFAULT NULL,
  `pos_invoice_format_id` int(11) DEFAULT NULL,
  `sales_invoice_footer_text` text DEFAULT NULL,
  `round_off` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `quotation_init` varchar(50) DEFAULT NULL,
  `decimals` int(11) DEFAULT 2,
  `money_transfer_init` varchar(50) DEFAULT NULL,
  `sales_payment_init` varchar(50) DEFAULT NULL,
  `sales_return_payment_init` varchar(50) DEFAULT NULL,
  `purchase_payment_init` varchar(50) DEFAULT NULL,
  `purchase_return_payment_init` varchar(50) DEFAULT NULL,
  `expense_payment_init` varchar(50) DEFAULT NULL,
  `current_subscriptionlist_id` int(11) DEFAULT 0,
  `smtp_host` varchar(250) DEFAULT NULL,
  `smtp_port` varchar(250) DEFAULT NULL,
  `smtp_user` varchar(250) DEFAULT NULL,
  `smtp_pass` varchar(250) DEFAULT NULL,
  `smtp_status` int(11) DEFAULT 0,
  `sms_url` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `mrp_column` int(11) DEFAULT 0,
  `qty_decimals` int(11) DEFAULT 2,
  `invoice_terms` text DEFAULT NULL,
  `previous_balance_bit` int(11) DEFAULT 1 COMMENT '1=Show, 0=Hide - Shows on sales invoice',
  `t_and_c_status` int(11) DEFAULT 1 COMMENT '1=Show, 0=Hide - Shows on sales invoice',
  `t_and_c_status_pos` int(11) DEFAULT 1,
  `number_to_words` varchar(250) DEFAULT 'Default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_store`
--

INSERT INTO `db_store` (`id`, `store_code`, `store_name`, `store_website`, `mobile`, `phone`, `email`, `website`, `store_logo`, `logo`, `upi_id`, `upi_code`, `country`, `state`, `city`, `address`, `postcode`, `gst_no`, `vat_no`, `pan_no`, `bank_details`, `cid`, `category_init`, `item_init`, `supplier_init`, `purchase_init`, `purchase_return_init`, `customer_init`, `sales_init`, `sales_return_init`, `expense_init`, `accounts_init`, `journal_init`, `cust_advance_init`, `invoice_view`, `sms_status`, `status`, `language_id`, `currency_id`, `currency_placement`, `timezone`, `date_format`, `time_format`, `sales_discount`, `currencysymbol_id`, `regno_key`, `fav_icon`, `purchase_code`, `change_return`, `sales_invoice_format_id`, `pos_invoice_format_id`, `sales_invoice_footer_text`, `round_off`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `quotation_init`, `decimals`, `money_transfer_init`, `sales_payment_init`, `sales_return_payment_init`, `purchase_payment_init`, `purchase_return_payment_init`, `expense_payment_init`, `current_subscriptionlist_id`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_status`, `sms_url`, `user_id`, `mrp_column`, `qty_decimals`, `invoice_terms`, `previous_balance_bit`, `t_and_c_status`, `t_and_c_status_pos`, `number_to_words`) VALUES
(1, 'ST0001', 'SAAS ADMIN', '', '+919999999999', '', 'admin@example.com', 'www', 'uploads/store/company_logo.png', NULL, NULL, NULL, 'India', 'Karnataka', 'Bengalore', 'Gandhi Road', '', '', '', '', '', NULL, 'CT/01/', 'IT01', 'SU/01/', 'PU/2020/01', 'PR/2020/01/', 'CU/01/', 'SL/2020/01/', 'SR/2020/01/', 'EX/2020/01/', 'AC/01/', 'JE', 'ADV', 1, 0, 1, 1, 35, 'Left', 'Asia/Kolkata\r\n', 'dd-mm-yyyy', 12, 0.0000, NULL, NULL, NULL, NULL, 1, 3, 1, 'Its Footer, You can change it from Store Settings.', 0, NULL, NULL, NULL, NULL, NULL, 'QT/2020/01/', 2, 'MT/01/', 'SP/2020/01/', 'SRP/2020/01/', 'PP/2020/01/', 'PRP/2020/01/', 'XP/2020/01/', 26, '', '', '', '', 1, '', 0, 0, 2, NULL, 1, 1, 1, 'Default'),
(2, 'ST0002', 'AL KASIR  MOBILE PHONE &amp; COMPUTER TR. LLC SP', '', '0556173300', '0564772300', 'alkasmobcmp.sp@gmail.com', NULL, 'uploads/store/alkasir_logo.jpg', NULL, NULL, NULL, 'United Arab Emirates', '', ' Al Majaz-2', 'Jamal Abdul Nasser Street, Sharjah, UAE', '', '', '100219031000003 ', '', '', NULL, '02', '10', 'SU/2026/', 'PU/2026/', 'PR/2026/', 'CU/2026/', 'SAL-26', 'SR/2026/', 'EX/2026/', 'AC/26/02', NULL, 'ADV', 1, 2, 1, 1, 17, 'Left', 'Asia/Dubai\r\n', 'dd-mm-yyyy', 12, 0.0000, NULL, NULL, NULL, NULL, 1, 4, 2, 'This is footer text. It is in Store Management.', 0, '2021-02-12', '05:53:37 pm', '', '127.0.0.1', 'LAPTOP-I5OUIM4R', 'QT/2026/', 2, 'MT/02/', 'SP/26/', 'SRP/6/', 'PP/26/', 'PRP/26/', 'XP/26/', 28, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 2, 'we hereby declare VAT calculated above is as per FTA, however any extra collected shall\r\n be refunded &amp; Vat for any service not collected shall be billed accordingly.\r\nWe declare that this invoice shows the actual price of the goods described and that all \r\nparticulars are true and correct.', 1, 1, 1, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `db_stripe`
--

CREATE TABLE `db_stripe` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sandbox` int(11) DEFAULT NULL,
  `publishable_key` text DEFAULT NULL,
  `api_secret` text DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_stripepayments`
--

CREATE TABLE `db_stripepayments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buyer_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `buyer_email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `paid_amount` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `paid_amount_currency` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `txn_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_status` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_subcategory`
--

CREATE TABLE `db_subcategory` (
  `scatid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `dptid` int(11) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `scatCode` varchar(20) DEFAULT NULL,
  `scatName` varchar(50) DEFAULT NULL,
  `scatDetails` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_subcategory1`
--

CREATE TABLE `db_subcategory1` (
  `scatid` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `dptid` int(11) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `scatCode` varchar(20) DEFAULT NULL,
  `scatName` varchar(50) DEFAULT NULL,
  `scatDetails` mediumtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_subcategory1`
--

INSERT INTO `db_subcategory1` (`scatid`, `store_id`, `count_id`, `dptid`, `catid`, `scatCode`, `scatName`, `scatDetails`, `status`) VALUES
(1, 2, 1, 1, 151, '020002', 'test', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_subscription`
--

CREATE TABLE `db_subscription` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `payment_id` varchar(250) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `package_type` varchar(50) DEFAULT NULL,
  `package_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subscription_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `trial_days` int(11) DEFAULT NULL,
  `max_users` int(11) DEFAULT NULL,
  `max_warehouses` int(11) DEFAULT NULL,
  `max_items` int(11) DEFAULT NULL,
  `max_invoices` int(11) DEFAULT NULL,
  `payment_by` varchar(50) DEFAULT NULL,
  `txn_id` varchar(250) DEFAULT NULL,
  `payment_gross` double(10,2) DEFAULT NULL,
  `currency_code` varchar(50) DEFAULT NULL,
  `payer_email` varchar(250) DEFAULT NULL,
  `payment_status` varchar(250) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(20) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `package_status` varchar(100) DEFAULT NULL,
  `payment_type` varchar(250) DEFAULT NULL COMMENT 'manual subscription only',
  `package_count` int(11) DEFAULT NULL COMMENT 'manual subscription only'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_subscription`
--

INSERT INTO `db_subscription` (`id`, `store_id`, `payment_id`, `package_id`, `package_type`, `package_name`, `description`, `subscription_date`, `expire_date`, `trial_days`, `max_users`, `max_warehouses`, `max_items`, `max_invoices`, `payment_by`, `txn_id`, `payment_gross`, `currency_code`, `payer_email`, `payment_status`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `package_status`, `payment_type`, `package_count`) VALUES
(13, 22, NULL, 2, NULL, 'Regular', 'Test description', '2021-01-25', NULL, 15, 20, 20, 200, 200, 'PayPal', '48R18927X78299709', 250.00, 'USD', 'sb-9fy504805522@business.example.com', 'Pending', '2021-01-25', '01:30:45 pm', 'Tester', '127.0.0.1', 'LAPTOP-I5OUIM4R', NULL, NULL, NULL),
(14, 22, NULL, 2, 'Paid', 'Regular', 'Test description', '2021-01-25', NULL, 15, 20, 20, 200, 200, 'PayPal', '9M838440FH9266015', 250.00, 'USD', 'sb-9fy504805522@business.example.com', 'Pending', '2021-01-25', '01:32:28 pm', 'Tester', '127.0.0.1', 'LAPTOP-I5OUIM4R', NULL, NULL, NULL),
(16, 22, NULL, 2, 'Paid', 'Regular', 'Test description', '2021-01-25', '2021-02-25', 15, 20, 20, 200, 200, 'PayPal', '2PT61144W90213341', 250.00, 'USD', 'sb-9fy504805522@business.example.com', 'Pending', '2021-01-25', '02:00:38 pm', 'Tester', '127.0.0.1', 'LAPTOP-I5OUIM4R', NULL, NULL, NULL),
(26, 1, NULL, 1, 'Free', 'Free', 'Test description', '2021-01-25', '2021-02-04', 10, 2, 2, 20, 20, 'Self', '', 0.00, '', '', '', '2021-01-25', '06:32:32 pm', 'admin', '127.0.0.1', 'LAPTOP-I5OUIM4R', NULL, NULL, NULL),
(27, 24, NULL, 1, 'Free', 'Free', 'Test description', '2021-02-11', '2021-02-21', 10, 2, 2, 20, 20, 'Self', '', 0.00, '', '', '', '2021-02-11', '03:09:47 pm', 'Tester', '127.0.0.1', 'LAPTOP-I5OUIM4R', NULL, NULL, NULL),
(28, 2, NULL, 1, 'Free', 'Free', 'Test description', '2021-02-12', '2021-02-22', 10, 2, 2, 20, 20, 'Self', '', 0.00, '', '', '', '2021-02-12', '06:57:18 pm', 'Tester', '127.0.0.1', 'LAPTOP-I5OUIM4R', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_suppliers`
--

CREATE TABLE `db_suppliers` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create supplier Code',
  `supplier_code` varchar(20) DEFAULT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `tax_number` varchar(50) DEFAULT NULL,
  `vatin` varchar(100) DEFAULT NULL,
  `opening_balance` double(20,4) DEFAULT NULL,
  `purchase_due` double(20,4) DEFAULT NULL,
  `purchase_return_due` double(20,4) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_customer` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_suppliers`
--

INSERT INTO `db_suppliers` (`id`, `store_id`, `count_id`, `supplier_code`, `supplier_name`, `mobile`, `phone`, `email`, `gstin`, `tax_number`, `vatin`, `opening_balance`, `purchase_due`, `purchase_return_due`, `country_id`, `state_id`, `city`, `postcode`, `address`, `system_ip`, `system_name`, `created_date`, `created_time`, `created_by`, `company_id`, `status`, `is_customer`) VALUES
(1, 2, 1, 'SU/2026/0001', 'RAPID', '', '', '', '', '', NULL, 0.0000, 100.0000, NULL, 195, 66, '', '', '', '5.31.247.215', '5.31.247.215', '2026-05-19', '09:35:25 pm', 'NIJIM', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_supplier_payments`
--

CREATE TABLE `db_supplier_payments` (
  `id` int(11) NOT NULL,
  `purchasepayment_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_date` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_tax`
--

CREATE TABLE `db_tax` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `tax_name` varchar(50) DEFAULT NULL,
  `tax` double(20,4) DEFAULT NULL,
  `group_bit` int(11) DEFAULT NULL COMMENT '1=Yes, 0=No',
  `subtax_ids` varchar(10) DEFAULT NULL COMMENT 'Tax groups IDs',
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_tax`
--

INSERT INTO `db_tax` (`id`, `store_id`, `tax_name`, `tax`, `group_bit`, `subtax_ids`, `status`) VALUES
(149, 2, 'N/A', 0.0000, NULL, NULL, 1),
(150, 2, 'VAT', 5.0000, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_timezone`
--

CREATE TABLE `db_timezone` (
  `id` int(11) NOT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_timezone`
--

INSERT INTO `db_timezone` (`id`, `timezone`, `status`) VALUES
(1, 'Africa/Abidjan\r', 1),
(2, 'Africa/Accra\r', 1),
(3, 'Africa/Addis_Ababa\r', 1),
(4, 'Africa/Algiers\r', 1),
(5, 'Africa/Asmara\r', 1),
(6, 'Africa/Asmera\r', 1),
(7, 'Africa/Bamako\r', 1),
(8, 'Africa/Bangui\r', 1),
(9, 'Africa/Banjul\r', 1),
(10, 'Africa/Bissau\r', 1),
(11, 'Africa/Blantyre\r', 1),
(12, 'Africa/Brazzaville\r', 1),
(13, 'Africa/Bujumbura\r', 1),
(14, 'Africa/Cairo\r', 1),
(15, 'Africa/Casablanca\r', 1),
(16, 'Africa/Ceuta\r', 1),
(17, 'Africa/Conakry\r', 1),
(18, 'Africa/Dakar\r', 1),
(19, 'Africa/Dar_es_Salaam\r', 1),
(20, 'Africa/Djibouti\r', 1),
(21, 'Africa/Douala\r', 1),
(22, 'Africa/El_Aaiun\r', 1),
(23, 'Africa/Freetown\r', 1),
(24, 'Africa/Gaborone\r', 1),
(25, 'Africa/Harare\r', 1),
(26, 'Africa/Johannesburg\r', 1),
(27, 'Africa/Juba\r', 1),
(28, 'Africa/Kampala\r', 1),
(29, 'Africa/Khartoum\r', 1),
(30, 'Africa/Kigali\r', 1),
(31, 'Africa/Kinshasa\r', 1),
(32, 'Africa/Lagos\r', 1),
(33, 'Africa/Libreville\r', 1),
(34, 'Africa/Lome\r', 1),
(35, 'Africa/Luanda\r', 1),
(36, 'Africa/Lubumbashi\r', 1),
(37, 'Africa/Lusaka\r', 1),
(38, 'Africa/Malabo\r', 1),
(39, 'Africa/Maputo\r', 1),
(40, 'Africa/Maseru\r', 1),
(41, 'Africa/Mbabane\r', 1),
(42, 'Africa/Mogadishu\r', 1),
(43, 'Africa/Monrovia\r', 1),
(44, 'Africa/Nairobi\r', 1),
(45, 'Africa/Ndjamena\r', 1),
(46, 'Africa/Niamey\r', 1),
(47, 'Africa/Nouakchott\r', 1),
(48, 'Africa/Ouagadougou\r', 1),
(49, 'Africa/Porto-Novo\r', 1),
(50, 'Africa/Sao_Tome\r', 1),
(51, 'Africa/Timbuktu\r', 1),
(52, 'Africa/Tripoli\r', 1),
(53, 'Africa/Tunis\r', 1),
(54, 'Africa/Windhoek\r', 1),
(55, 'AKST9AKDT\r', 1),
(56, 'America/Adak\r', 1),
(57, 'America/Anchorage\r', 1),
(58, 'America/Anguilla\r', 1),
(59, 'America/Antigua\r', 1),
(60, 'America/Araguaina\r', 1),
(61, 'America/Argentina/Buenos_Aires\r', 1),
(62, 'America/Argentina/Catamarca\r', 1),
(63, 'America/Argentina/ComodRivadavia\r', 1),
(64, 'America/Argentina/Cordoba\r', 1),
(65, 'America/Argentina/Jujuy\r', 1),
(66, 'America/Argentina/La_Rioja\r', 1),
(67, 'America/Argentina/Mendoza\r', 1),
(68, 'America/Argentina/Rio_Gallegos\r', 1),
(69, 'America/Argentina/Salta\r', 1),
(70, 'America/Argentina/San_Juan\r', 1),
(71, 'America/Argentina/San_Luis\r', 1),
(72, 'America/Argentina/Tucuman\r', 1),
(73, 'America/Argentina/Ushuaia\r', 1),
(74, 'America/Aruba\r', 1),
(75, 'America/Asuncion\r', 1),
(76, 'America/Atikokan\r', 1),
(77, 'America/Atka\r', 1),
(78, 'America/Bahia\r', 1),
(79, 'America/Bahia_Banderas\r', 1),
(80, 'America/Barbados\r', 1),
(81, 'America/Belem\r', 1),
(82, 'America/Belize\r', 1),
(83, 'America/Blanc-Sablon\r', 1),
(84, 'America/Boa_Vista\r', 1),
(85, 'America/Bogota\r', 1),
(86, 'America/Boise\r', 1),
(87, 'America/Buenos_Aires\r', 1),
(88, 'America/Cambridge_Bay\r', 1),
(89, 'America/Campo_Grande\r', 1),
(90, 'America/Cancun\r', 1),
(91, 'America/Caracas\r', 1),
(92, 'America/Catamarca\r', 1),
(93, 'America/Cayenne\r', 1),
(94, 'America/Cayman\r', 1),
(95, 'America/Chicago\r', 1),
(96, 'America/Chihuahua\r', 1),
(97, 'America/Coral_Harbour\r', 1),
(98, 'America/Cordoba\r', 1),
(99, 'America/Costa_Rica\r', 1),
(100, 'America/Creston\r', 1),
(101, 'America/Cuiaba\r', 1),
(102, 'America/Curacao\r', 1),
(103, 'America/Danmarkshavn\r', 1),
(104, 'America/Dawson\r', 1),
(105, 'America/Dawson_Creek\r', 1),
(106, 'America/Denver\r', 1),
(107, 'America/Detroit\r', 1),
(108, 'America/Dominica\r', 1),
(109, 'America/Edmonton\r', 1),
(110, 'America/Eirunepe\r', 1),
(111, 'America/El_Salvador\r', 1),
(112, 'America/Ensenada\r', 1),
(113, 'America/Fort_Wayne\r', 1),
(114, 'America/Fortaleza\r', 1),
(115, 'America/Glace_Bay\r', 1),
(116, 'America/Godthab\r', 1),
(117, 'America/Goose_Bay\r', 1),
(118, 'America/Grand_Turk\r', 1),
(119, 'America/Grenada\r', 1),
(120, 'America/Guadeloupe\r', 1),
(121, 'America/Guatemala\r', 1),
(122, 'America/Guayaquil\r', 1),
(123, 'America/Guyana\r', 1),
(124, 'America/Halifax\r', 1),
(125, 'America/Havana\r', 1),
(126, 'America/Hermosillo\r', 1),
(127, 'America/Indiana/Indianapolis\r', 1),
(128, 'America/Indiana/Knox\r', 1),
(129, 'America/Indiana/Marengo\r', 1),
(130, 'America/Indiana/Petersburg\r', 1),
(131, 'America/Indiana/Tell_City\r', 1),
(132, 'America/Indiana/Vevay\r', 1),
(133, 'America/Indiana/Vincennes\r', 1),
(134, 'America/Indiana/Winamac\r', 1),
(135, 'America/Indianapolis\r', 1),
(136, 'America/Inuvik\r', 1),
(137, 'America/Iqaluit\r', 1),
(138, 'America/Jamaica\r', 1),
(139, 'America/Jujuy\r', 1),
(140, 'America/Juneau\r', 1),
(141, 'America/Kentucky/Louisville\r', 1),
(142, 'America/Kentucky/Monticello\r', 1),
(143, 'America/Knox_IN\r', 1),
(144, 'America/Kralendijk\r', 1),
(145, 'America/La_Paz\r', 1),
(146, 'America/Lima\r', 1),
(147, 'America/Los_Angeles\r', 1),
(148, 'America/Louisville\r', 1),
(149, 'America/Lower_Princes\r', 1),
(150, 'America/Maceio\r', 1),
(151, 'America/Managua\r', 1),
(152, 'America/Manaus\r', 1),
(153, 'America/Marigot\r', 1),
(154, 'America/Martinique\r', 1),
(155, 'America/Matamoros\r', 1),
(156, 'America/Mazatlan\r', 1),
(157, 'America/Mendoza\r', 1),
(158, 'America/Menominee\r', 1),
(159, 'America/Merida\r', 1),
(160, 'America/Metlakatla\r', 1),
(161, 'America/Mexico_City\r', 1),
(162, 'America/Miquelon\r', 1),
(163, 'America/Moncton\r', 1),
(164, 'America/Monterrey\r', 1),
(165, 'America/Montevideo\r', 1),
(166, 'America/Montreal\r', 1),
(167, 'America/Montserrat\r', 1),
(168, 'America/Nassau\r', 1),
(169, 'America/New_York\r', 1),
(170, 'America/Nipigon\r', 1),
(171, 'America/Nome\r', 1),
(172, 'America/Noronha\r', 1),
(173, 'America/North_Dakota/Beulah\r', 1),
(174, 'America/North_Dakota/Center\r', 1),
(175, 'America/North_Dakota/New_Salem\r', 1),
(176, 'America/Ojinaga\r', 1),
(177, 'America/Panama\r', 1),
(178, 'America/Pangnirtung\r', 1),
(179, 'America/Paramaribo\r', 1),
(180, 'America/Phoenix\r', 1),
(181, 'America/Port_of_Spain\r', 1),
(182, 'America/Port-au-Prince\r', 1),
(183, 'America/Porto_Acre\r', 1),
(184, 'America/Porto_Velho\r', 1),
(185, 'America/Puerto_Rico\r', 1),
(186, 'America/Rainy_River\r', 1),
(187, 'America/Rankin_Inlet\r', 1),
(188, 'America/Recife\r', 1),
(189, 'America/Regina\r', 1),
(190, 'America/Resolute\r', 1),
(191, 'America/Rio_Branco\r', 1),
(192, 'America/Rosario\r', 1),
(193, 'America/Santa_Isabel\r', 1),
(194, 'America/Santarem\r', 1),
(195, 'America/Santiago\r', 1),
(196, 'America/Santo_Domingo\r', 1),
(197, 'America/Sao_Paulo\r', 1),
(198, 'America/Scoresbysund\r', 1),
(199, 'America/Shiprock\r', 1),
(200, 'America/Sitka\r', 1),
(201, 'America/St_Barthelemy\r', 1),
(202, 'America/St_Johns\r', 1),
(203, 'America/St_Kitts\r', 1),
(204, 'America/St_Lucia\r', 1),
(205, 'America/St_Thomas\r', 1),
(206, 'America/St_Vincent\r', 1),
(207, 'America/Swift_Current\r', 1),
(208, 'America/Tegucigalpa\r', 1),
(209, 'America/Thule\r', 1),
(210, 'America/Thunder_Bay\r', 1),
(211, 'America/Tijuana\r', 1),
(212, 'America/Toronto\r', 1),
(213, 'America/Tortola\r', 1),
(214, 'America/Vancouver\r', 1),
(215, 'America/Virgin\r', 1),
(216, 'America/Whitehorse\r', 1),
(217, 'America/Winnipeg\r', 1),
(218, 'America/Yakutat\r', 1),
(219, 'America/Yellowknife\r', 1),
(220, 'Antarctica/Casey\r', 1),
(221, 'Antarctica/Davis\r', 1),
(222, 'Antarctica/DumontDUrville\r', 1),
(223, 'Antarctica/Macquarie\r', 1),
(224, 'Antarctica/Mawson\r', 1),
(225, 'Antarctica/McMurdo\r', 1),
(226, 'Antarctica/Palmer\r', 1),
(227, 'Antarctica/Rothera\r', 1),
(228, 'Antarctica/South_Pole\r', 1),
(229, 'Antarctica/Syowa\r', 1),
(230, 'Antarctica/Vostok\r', 1),
(231, 'Arctic/Longyearbyen\r', 1),
(232, 'Asia/Aden\r', 1),
(233, 'Asia/Almaty\r', 1),
(234, 'Asia/Amman\r', 1),
(235, 'Asia/Anadyr\r', 1),
(236, 'Asia/Aqtau\r', 1),
(237, 'Asia/Aqtobe\r', 1),
(238, 'Asia/Ashgabat\r', 1),
(239, 'Asia/Ashkhabad\r', 1),
(240, 'Asia/Baghdad\r', 1),
(241, 'Asia/Bahrain\r', 1),
(242, 'Asia/Baku\r', 1),
(243, 'Asia/Bangkok\r', 1),
(244, 'Asia/Beirut\r', 1),
(245, 'Asia/Bishkek\r', 1),
(246, 'Asia/Brunei\r', 1),
(247, 'Asia/Calcutta\r', 1),
(248, 'Asia/Choibalsan\r', 1),
(249, 'Asia/Chongqing\r', 1),
(250, 'Asia/Chungking\r', 1),
(251, 'Asia/Colombo\r', 1),
(252, 'Asia/Dacca\r', 1),
(253, 'Asia/Damascus\r', 1),
(254, 'Asia/Dhaka\r', 1),
(255, 'Asia/Dili\r', 1),
(256, 'Asia/Dubai\r', 1),
(257, 'Asia/Dushanbe\r', 1),
(258, 'Asia/Gaza\r', 1),
(259, 'Asia/Harbin\r', 1),
(260, 'Asia/Hebron\r', 1),
(261, 'Asia/Ho_Chi_Minh\r', 1),
(262, 'Asia/Hong_Kong\r', 1),
(263, 'Asia/Hovd\r', 1),
(264, 'Asia/Irkutsk\r', 1),
(265, 'Asia/Istanbul\r', 1),
(266, 'Asia/Jakarta\r', 1),
(267, 'Asia/Jayapura\r', 1),
(268, 'Asia/Jerusalem\r', 1),
(269, 'Asia/Kabul\r', 1),
(270, 'Asia/Kamchatka\r', 1),
(271, 'Asia/Karachi\r', 1),
(272, 'Asia/Kashgar\r', 1),
(273, 'Asia/Kathmandu\r', 1),
(274, 'Asia/Katmandu\r', 1),
(275, 'Asia/Kolkata\r', 1),
(276, 'Asia/Krasnoyarsk\r', 1),
(277, 'Asia/Kuala_Lumpur\r', 1),
(278, 'Asia/Kuching\r', 1),
(279, 'Asia/Kuwait\r', 1),
(280, 'Asia/Macao\r', 1),
(281, 'Asia/Macau\r', 1),
(282, 'Asia/Magadan\r', 1),
(283, 'Asia/Makassar\r', 1),
(284, 'Asia/Manila\r', 1),
(285, 'Asia/Muscat\r', 1),
(286, 'Asia/Nicosia\r', 1),
(287, 'Asia/Novokuznetsk\r', 1),
(288, 'Asia/Novosibirsk\r', 1),
(289, 'Asia/Omsk\r', 1),
(290, 'Asia/Oral\r', 1),
(291, 'Asia/Phnom_Penh\r', 1),
(292, 'Asia/Pontianak\r', 1),
(293, 'Asia/Pyongyang\r', 1),
(294, 'Asia/Qatar\r', 1),
(295, 'Asia/Qyzylorda\r', 1),
(296, 'Asia/Rangoon\r', 1),
(297, 'Asia/Riyadh\r', 1),
(298, 'Asia/Saigon\r', 1),
(299, 'Asia/Sakhalin\r', 1),
(300, 'Asia/Samarkand\r', 1),
(301, 'Asia/Seoul\r', 1),
(302, 'Asia/Shanghai\r', 1),
(303, 'Asia/Singapore\r', 1),
(304, 'Asia/Taipei\r', 1),
(305, 'Asia/Tashkent\r', 1),
(306, 'Asia/Tbilisi\r', 1),
(307, 'Asia/Tehran\r', 1),
(308, 'Asia/Tel_Aviv\r', 1),
(309, 'Asia/Thimbu\r', 1),
(310, 'Asia/Thimphu\r', 1),
(311, 'Asia/Tokyo\r', 1),
(312, 'Asia/Ujung_Pandang\r', 1),
(313, 'Asia/Ulaanbaatar\r', 1),
(314, 'Asia/Ulan_Bator\r', 1),
(315, 'Asia/Urumqi\r', 1),
(316, 'Asia/Vientiane\r', 1),
(317, 'Asia/Vladivostok\r', 1),
(318, 'Asia/Yakutsk\r', 1),
(319, 'Asia/Yekaterinburg\r', 1),
(320, 'Asia/Yerevan\r', 1),
(321, 'Atlantic/Azores\r', 1),
(322, 'Atlantic/Bermuda\r', 1),
(323, 'Atlantic/Canary\r', 1),
(324, 'Atlantic/Cape_Verde\r', 1),
(325, 'Atlantic/Faeroe\r', 1),
(326, 'Atlantic/Faroe\r', 1),
(327, 'Atlantic/Jan_Mayen\r', 1),
(328, 'Atlantic/Madeira\r', 1),
(329, 'Atlantic/Reykjavik\r', 1),
(330, 'Atlantic/South_Georgia\r', 1),
(331, 'Atlantic/St_Helena\r', 1),
(332, 'Atlantic/Stanley\r', 1),
(333, 'Australia/ACT\r', 1),
(334, 'Australia/Adelaide\r', 1),
(335, 'Australia/Brisbane\r', 1),
(336, 'Australia/Broken_Hill\r', 1),
(337, 'Australia/Canberra\r', 1),
(338, 'Australia/Currie\r', 1),
(339, 'Australia/Darwin\r', 1),
(340, 'Australia/Eucla\r', 1),
(341, 'Australia/Hobart\r', 1),
(342, 'Australia/LHI\r', 1),
(343, 'Australia/Lindeman\r', 1),
(344, 'Australia/Lord_Howe\r', 1),
(345, 'Australia/Melbourne\r', 1),
(346, 'Australia/North\r', 1),
(347, 'Australia/NSW\r', 1),
(348, 'Australia/Perth\r', 1),
(349, 'Australia/Queensland\r', 1),
(350, 'Australia/South\r', 1),
(351, 'Australia/Sydney\r', 1),
(352, 'Australia/Tasmania\r', 1),
(353, 'Australia/Victoria\r', 1),
(354, 'Australia/West\r', 1),
(355, 'Australia/Yancowinna\r', 1),
(356, 'Brazil/Acre\r', 1),
(357, 'Brazil/DeNoronha\r', 1),
(358, 'Brazil/East\r', 1),
(359, 'Brazil/West\r', 1),
(360, 'Canada/Atlantic\r', 1),
(361, 'Canada/Central\r', 1),
(362, 'Canada/Eastern\r', 1),
(363, 'Canada/East-Saskatchewan\r', 1),
(364, 'Canada/Mountain\r', 1),
(365, 'Canada/Newfoundland\r', 1),
(366, 'Canada/Pacific\r', 1),
(367, 'Canada/Saskatchewan\r', 1),
(368, 'Canada/Yukon\r', 1),
(369, 'CET\r', 1),
(370, 'Chile/Continental\r', 1),
(371, 'Chile/EasterIsland\r', 1),
(372, 'CST6CDT\r', 1),
(373, 'Cuba\r', 1),
(374, 'EET\r', 1),
(375, 'Egypt\r', 1),
(376, 'Eire\r', 1),
(377, 'EST\r', 1),
(378, 'EST5EDT\r', 1),
(379, 'Etc./GMT\r', 1),
(380, 'Etc./GMT+0\r', 1),
(381, 'Etc./UCT\r', 1),
(382, 'Etc./Universal\r', 1),
(383, 'Etc./UTC\r', 1),
(384, 'Etc./Zulu\r', 1),
(385, 'Europe/Amsterdam\r', 1),
(386, 'Europe/Andorra\r', 1),
(387, 'Europe/Athens\r', 1),
(388, 'Europe/Belfast\r', 1),
(389, 'Europe/Belgrade\r', 1),
(390, 'Europe/Berlin\r', 1),
(391, 'Europe/Bratislava\r', 1),
(392, 'Europe/Brussels\r', 1),
(393, 'Europe/Bucharest\r', 1),
(394, 'Europe/Budapest\r', 1),
(395, 'Europe/Chisinau\r', 1),
(396, 'Europe/Copenhagen\r', 1),
(397, 'Europe/Dublin\r', 1),
(398, 'Europe/Gibraltar\r', 1),
(399, 'Europe/Guernsey\r', 1),
(400, 'Europe/Helsinki\r', 1),
(401, 'Europe/Isle_of_Man\r', 1),
(402, 'Europe/Istanbul\r', 1),
(403, 'Europe/Jersey\r', 1),
(404, 'Europe/Kaliningrad\r', 1),
(405, 'Europe/Kiev\r', 1),
(406, 'Europe/Lisbon\r', 1),
(407, 'Europe/Ljubljana\r', 1),
(408, 'Europe/London\r', 1),
(409, 'Europe/Luxembourg\r', 1),
(410, 'Europe/Madrid\r', 1),
(411, 'Europe/Malta\r', 1),
(412, 'Europe/Mariehamn\r', 1),
(413, 'Europe/Minsk\r', 1),
(414, 'Europe/Monaco\r', 1),
(415, 'Europe/Moscow\r', 1),
(416, 'Europe/Nicosia\r', 1),
(417, 'Europe/Oslo\r', 1),
(418, 'Europe/Paris\r', 1),
(419, 'Europe/Podgorica\r', 1),
(420, 'Europe/Prague\r', 1),
(421, 'Europe/Riga\r', 1),
(422, 'Europe/Rome\r', 1),
(423, 'Europe/Samara\r', 1),
(424, 'Europe/San_Marino\r', 1),
(425, 'Europe/Sarajevo\r', 1),
(426, 'Europe/Simferopol\r', 1),
(427, 'Europe/Skopje\r', 1),
(428, 'Europe/Sofia\r', 1),
(429, 'Europe/Stockholm\r', 1),
(430, 'Europe/Tallinn\r', 1),
(431, 'Europe/Tirane\r', 1),
(432, 'Europe/Tiraspol\r', 1),
(433, 'Europe/Uzhgorod\r', 1),
(434, 'Europe/Vaduz\r', 1),
(435, 'Europe/Vatican\r', 1),
(436, 'Europe/Vienna\r', 1),
(437, 'Europe/Vilnius\r', 1),
(438, 'Europe/Volgograd\r', 1),
(439, 'Europe/Warsaw\r', 1),
(440, 'Europe/Zagreb\r', 1),
(441, 'Europe/Zaporozhye\r', 1),
(442, 'Europe/Zurich\r', 1),
(443, 'GB\r', 1),
(444, 'GB-Eire\r', 1),
(445, 'GMT\r', 1),
(446, 'GMT+0\r', 1),
(447, 'GMT0\r', 1),
(448, 'GMT-0\r', 1),
(449, 'Greenwich\r', 1),
(450, 'Hong Kong\r', 1),
(451, 'HST\r', 1),
(452, 'Iceland\r', 1),
(453, 'Indian/Antananarivo\r', 1),
(454, 'Indian/Chagos\r', 1),
(455, 'Indian/Christmas\r', 1),
(456, 'Indian/Cocos\r', 1),
(457, 'Indian/Comoro\r', 1),
(458, 'Indian/Kerguelen\r', 1),
(459, 'Indian/Mahe\r', 1),
(460, 'Indian/Maldives\r', 1),
(461, 'Indian/Mauritius\r', 1),
(462, 'Indian/Mayotte\r', 1),
(463, 'Indian/Reunion\r', 1),
(464, 'Iran\r', 1),
(465, 'Israel\r', 1),
(466, 'Jamaica\r', 1),
(467, 'Japan\r', 1),
(468, 'JST-9\r', 1),
(469, 'Kwajalein\r', 1),
(470, 'Libya\r', 1),
(471, 'MET\r', 1),
(472, 'Mexico/BajaNorte\r', 1),
(473, 'Mexico/BajaSur\r', 1),
(474, 'Mexico/General\r', 1),
(475, 'MST\r', 1),
(476, 'MST7MDT\r', 1),
(477, 'Navajo\r', 1),
(478, 'NZ\r', 1),
(479, 'NZ-CHAT\r', 1),
(480, 'Pacific/Apia\r', 1),
(481, 'Pacific/Auckland\r', 1),
(482, 'Pacific/Chatham\r', 1),
(483, 'Pacific/Chuuk\r', 1),
(484, 'Pacific/Easter\r', 1),
(485, 'Pacific/Efate\r', 1),
(486, 'Pacific/Enderbury\r', 1),
(487, 'Pacific/Fakaofo\r', 1),
(488, 'Pacific/Fiji\r', 1),
(489, 'Pacific/Funafuti\r', 1),
(490, 'Pacific/Galapagos\r', 1),
(491, 'Pacific/Gambier\r', 1),
(492, 'Pacific/Guadalcanal\r', 1),
(493, 'Pacific/Guam\r', 1),
(494, 'Pacific/Honolulu\r', 1),
(495, 'Pacific/Johnston\r', 1),
(496, 'Pacific/Kiritimati\r', 1),
(497, 'Pacific/Kosrae\r', 1),
(498, 'Pacific/Kwajalein\r', 1),
(499, 'Pacific/Majuro\r', 1),
(500, 'Pacific/Marquesas\r', 1),
(501, 'Pacific/Midway\r', 1),
(502, 'Pacific/Nauru\r', 1),
(503, 'Pacific/Niue\r', 1),
(504, 'Pacific/Norfolk\r', 1),
(505, 'Pacific/Noumea\r', 1),
(506, 'Pacific/Pago_Pago\r', 1),
(507, 'Pacific/Palau\r', 1),
(508, 'Pacific/Pitcairn\r', 1),
(509, 'Pacific/Pohnpei\r', 1),
(510, 'Pacific/Ponape\r', 1),
(511, 'Pacific/Port_Moresby\r', 1),
(512, 'Pacific/Rarotonga\r', 1),
(513, 'Pacific/Saipan\r', 1),
(514, 'Pacific/Samoa\r', 1),
(515, 'Pacific/Tahiti\r', 1),
(516, 'Pacific/Tarawa\r', 1),
(517, 'Pacific/Tongatapu\r', 1),
(518, 'Pacific/Truk\r', 1),
(519, 'Pacific/Wake\r', 1),
(520, 'Pacific/Wallis\r', 1),
(521, 'Pacific/Yap\r', 1),
(522, 'Poland\r', 1),
(523, 'Portugal\r', 1),
(524, 'PRC\r', 1),
(525, 'PST8PDT\r', 1),
(526, 'ROC\r', 1),
(527, 'ROK\r', 1),
(528, 'Singapore\r', 1),
(529, 'Turkey\r', 1),
(530, 'UCT\r', 1),
(531, 'Universal\r', 1),
(532, 'US/Alaska\r', 1),
(533, 'US/Aleutian\r', 1),
(534, 'US/Arizona\r', 1),
(535, 'US/Central\r', 1),
(536, 'US/Eastern\r', 1),
(537, 'US/East-Indiana\r', 1),
(538, 'US/Hawaii\r', 1),
(539, 'US/Indiana-Starke\r', 1),
(540, 'US/Michigan\r', 1),
(541, 'US/Mountain\r', 1),
(542, 'US/Pacific\r', 1),
(543, 'US/Pacific-New\r', 1),
(544, 'US/Samoa\r', 1),
(545, 'UTC\r', 1),
(546, 'WET\r', 1),
(547, 'W-SU\r', 1),
(548, 'Zulu\r', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_twilio`
--

CREATE TABLE `db_twilio` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `account_sid` varchar(250) DEFAULT NULL,
  `auth_token` varchar(250) DEFAULT NULL,
  `twilio_phone` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_twilio`
--

INSERT INTO `db_twilio` (`id`, `store_id`, `account_sid`, `auth_token`, `twilio_phone`, `status`) VALUES
(1, 1, '', '', '', 0),
(3, 2, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_units`
--

CREATE TABLE `db_units` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `unit_name` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_units`
--

INSERT INTO `db_units` (`id`, `store_id`, `unit_name`, `description`, `company_id`, `status`) VALUES
(61, 2, 'PCS', '', NULL, 1),
(65, 2, 'BOX', '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_users`
--

CREATE TABLE `db_users` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `password` blob DEFAULT NULL,
  `member_of` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `photo` blob DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` blob DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `profile_picture` text DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `status` double DEFAULT NULL,
  `creater_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_users`
--

INSERT INTO `db_users` (`id`, `store_id`, `username`, `first_name`, `last_name`, `password`, `member_of`, `firstname`, `lastname`, `mobile`, `email`, `photo`, `gender`, `dob`, `country`, `state`, `city`, `address`, `postcode`, `role_name`, `role_id`, `profile_picture`, `created_date`, `created_time`, `created_by`, `system_ip`, `system_name`, `status`, `creater_id`, `updater_id`, `updated_at`) VALUES
(1, 1, 'Admin', 'Super', 'Power', 0x6531306164633339343962613539616262653536653035376632306638383365, '', NULL, NULL, '', 'princeapurbask@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'uploads/users/admin.png', '2018-11-27', '::1', NULL, NULL, NULL, 1, NULL, NULL, NULL),
(2, 2, 'NIJIM', NULL, 'UDDIN', 0x3031393230323361376262643733323530353136663036396466313862353030, NULL, NULL, NULL, '0556173300', 'admin@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'uploads/users/avatar1.png', '2021-02-12', '05:53:37 pm', '', '127.0.0.1', 'LAPTOP-I5OUIM4R', 1, NULL, NULL, NULL),
(3, 2, 'Mohammed', NULL, 'Jahangir Alam', 0x6531306164633339343962613539616262653536653035376632306638383365, NULL, NULL, NULL, '0555164774', 'rapidjahangir@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, NULL, '2026-05-21', '01:12:41 pm', 'NIJIM', '5.31.247.215', '5.31.247.215', 1, NULL, NULL, NULL),
(4, 2, 'Abdel', NULL, 'rahman', 0x6465323866386637393938663233616234313934623531613630323934313666, NULL, NULL, NULL, '0582437997', 'alkasirmobcmp.sp@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, NULL, '2026-05-21', '10:10:43 pm', 'NIJIM', '109.177.145.172', '109.177.145.172', 1, NULL, NULL, NULL),
(5, 2, 'Sobuj', NULL, 'Noni-gopal', 0x6465323866386637393938663233616234313934623531613630323934313666, NULL, NULL, NULL, '0564772300', 'alkasirmobcmp.sp24@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, NULL, '2026-05-21', '10:15:40 pm', 'NIJIM', '109.177.145.172', '109.177.145.172', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_userswarehouses`
--

CREATE TABLE `db_userswarehouses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_userswarehouses`
--

INSERT INTO `db_userswarehouses` (`id`, `user_id`, `warehouse_id`) VALUES
(2, 3, 2),
(3, 4, 2),
(4, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `db_variants`
--

CREATE TABLE `db_variants` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `variant_code` varchar(50) DEFAULT NULL,
  `variant_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_variants`
--

INSERT INTO `db_variants` (`id`, `store_id`, `variant_code`, `variant_name`, `description`, `status`) VALUES
(259, 2, NULL, 'PCS', '', 1),
(260, 2, NULL, 'BOX', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_warehouse`
--

CREATE TABLE `db_warehouse` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_type` varchar(50) DEFAULT NULL,
  `warehouse_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_warehouse`
--

INSERT INTO `db_warehouse` (`id`, `store_id`, `warehouse_type`, `warehouse_name`, `mobile`, `email`, `country`, `city`, `state`, `area`, `contact_person`, `mobile_number`, `phone_number`, `fax`, `status`, `created_date`) VALUES
(1, 1, 'System', 'Store One', '', 'warehouse_a@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(2, 2, 'System', 'Al Majaz-2 Sharjah UAE', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `db_warehouseitems`
--

CREATE TABLE `db_warehouseitems` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `available_qty` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `db_warehouseitems`
--

INSERT INTO `db_warehouseitems` (`id`, `store_id`, `warehouse_id`, `item_id`, `available_qty`) VALUES
(158555, 2, 2, 2, 6.00);

-- --------------------------------------------------------

--
-- Table structure for table `temp_holdinvoice`
--

CREATE TABLE `temp_holdinvoice` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_qty` int(11) DEFAULT NULL,
  `item_price` double(10,2) DEFAULT NULL,
  `tax` double(10,2) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ac_accounts`
--
ALTER TABLE `ac_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `paymenttypes_id` (`paymenttypes_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `expense_id` (`expense_id`);

--
-- Indexes for table `ac_moneydeposits`
--
ALTER TABLE `ac_moneydeposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_account_id` (`debit_account_id`),
  ADD KEY `to_account_id` (`credit_account_id`),
  ADD KEY `db_moneydeposits_ibfk_3` (`store_id`);

--
-- Indexes for table `ac_moneytransfer`
--
ALTER TABLE `ac_moneytransfer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_account_id` (`debit_account_id`),
  ADD KEY `to_account_id` (`credit_account_id`),
  ADD KEY `db_moneytransfer_ibfk_3` (`store_id`);

--
-- Indexes for table `ac_transactions`
--
ALTER TABLE `ac_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_id` (`transaction_type`),
  ADD KEY `account_id` (`debit_account_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `ac_accounts_id` (`ref_accounts_id`),
  ADD KEY `ac_moneytransfer_id` (`ref_moneytransfer_id`),
  ADD KEY `ac_moneydeposits_id` (`ref_moneydeposits_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `ref_salespayments_id` (`ref_salespayments_id`),
  ADD KEY `ref_purchasepayments_id` (`ref_purchasepayments_id`),
  ADD KEY `ref_purchasepaymentsreturn_id` (`ref_purchasepaymentsreturn_id`),
  ADD KEY `ac_transactions_ibfk_9` (`ref_salespaymentsreturn_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `ref_expense_id` (`ref_expense_id`);

--
-- Indexes for table `bd_bncategory`
--
ALTER TABLE `bd_bncategory`
  ADD PRIMARY KEY (`bnid`);

--
-- Indexes for table `bd_clcategory`
--
ALTER TABLE `bd_clcategory`
  ADD PRIMARY KEY (`clid`);

--
-- Indexes for table `bd_sbcategory`
--
ALTER TABLE `bd_sbcategory`
  ADD PRIMARY KEY (`bsid`);

--
-- Indexes for table `bd_szcategory`
--
ALTER TABLE `bd_szcategory`
  ADD PRIMARY KEY (`isid`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `db_bankdetails`
--
ALTER TABLE `db_bankdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_brands`
--
ALTER TABLE `db_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_category`
--
ALTER TABLE `db_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_cobpayments`
--
ALTER TABLE `db_cobpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_country`
--
ALTER TABLE `db_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_coupons`
--
ALTER TABLE `db_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_currency`
--
ALTER TABLE `db_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_custadvance`
--
ALTER TABLE `db_custadvance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_customers`
--
ALTER TABLE `db_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_customer_coupons`
--
ALTER TABLE `db_customer_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `db_customer_payments`
--
ALTER TABLE `db_customer_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `salespayment_id` (`salespayment_id`);

--
-- Indexes for table `db_department`
--
ALTER TABLE `db_department`
  ADD PRIMARY KEY (`dptid`);

--
-- Indexes for table `db_emailtemplates`
--
ALTER TABLE `db_emailtemplates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_expense`
--
ALTER TABLE `db_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `db_expense_category`
--
ALTER TABLE `db_expense_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_fivemojo`
--
ALTER TABLE `db_fivemojo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_hold`
--
ALTER TABLE `db_hold`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `db_holditems`
--
ALTER TABLE `db_holditems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `sales_id` (`hold_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `db_instamojo`
--
ALTER TABLE `db_instamojo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_instamojopayments`
--
ALTER TABLE `db_instamojopayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_items`
--
ALTER TABLE `db_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_item_models`
--
ALTER TABLE `db_item_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_languages`
--
ALTER TABLE `db_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_package`
--
ALTER TABLE `db_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_paymenttypes`
--
ALTER TABLE `db_paymenttypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_paypal`
--
ALTER TABLE `db_paypal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_paypalpaylog`
--
ALTER TABLE `db_paypalpaylog`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `db_permissions`
--
ALTER TABLE `db_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_purchase`
--
ALTER TABLE `db_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `db_purchaseitems`
--
ALTER TABLE `db_purchaseitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `db_purchaseitemsreturn`
--
ALTER TABLE `db_purchaseitemsreturn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `return_id` (`return_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `db_purchasepayments`
--
ALTER TABLE `db_purchasepayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `db_purchasepaymentsreturn`
--
ALTER TABLE `db_purchasepaymentsreturn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `return_id` (`return_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `db_purchasereturn`
--
ALTER TABLE `db_purchasereturn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `db_quotation`
--
ALTER TABLE `db_quotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `db_quotationitems`
--
ALTER TABLE `db_quotationitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `quotation_id` (`quotation_id`);

--
-- Indexes for table `db_rack`
--
ALTER TABLE `db_rack`
  ADD PRIMARY KEY (`rkid`);

--
-- Indexes for table `db_roles`
--
ALTER TABLE `db_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_sales`
--
ALTER TABLE `db_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `db_salesitems`
--
ALTER TABLE `db_salesitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `sales_id` (`sales_id`);

--
-- Indexes for table `db_salesitemsreturn`
--
ALTER TABLE `db_salesitemsreturn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `return_id` (`return_id`);

--
-- Indexes for table `db_salespayments`
--
ALTER TABLE `db_salespayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `db_salespaymentsreturn`
--
ALTER TABLE `db_salespaymentsreturn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `return_id` (`return_id`),
  ADD KEY `db_salespaymentsreturn_ibfk_3` (`customer_id`);

--
-- Indexes for table `db_salesreturn`
--
ALTER TABLE `db_salesreturn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `db_shippingaddress`
--
ALTER TABLE `db_shippingaddress`
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `db_sitesettings`
--
ALTER TABLE `db_sitesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_smsapi`
--
ALTER TABLE `db_smsapi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_smstemplates`
--
ALTER TABLE `db_smstemplates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_sobpayments`
--
ALTER TABLE `db_sobpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_states`
--
ALTER TABLE `db_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_stockadjustment`
--
ALTER TABLE `db_stockadjustment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_stockadjustmentitems`
--
ALTER TABLE `db_stockadjustmentitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`adjustment_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `db_stockentry`
--
ALTER TABLE `db_stockentry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_stocktransfer`
--
ALTER TABLE `db_stocktransfer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `warehouse_id` (`warehouse_from`),
  ADD KEY `warehouse_to` (`warehouse_to`),
  ADD KEY `db_stocktransfer_ibfk_4` (`to_store_id`);

--
-- Indexes for table `db_stocktransferitems`
--
ALTER TABLE `db_stocktransferitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `warehouse_from` (`warehouse_from`),
  ADD KEY `warehouse_to` (`warehouse_to`),
  ADD KEY `stocktranfer_id` (`stocktransfer_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `db_stocktransferitems_ibfk_6` (`to_store_id`);

--
-- Indexes for table `db_store`
--
ALTER TABLE `db_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_stripe`
--
ALTER TABLE `db_stripe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_stripepayments`
--
ALTER TABLE `db_stripepayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_subcategory`
--
ALTER TABLE `db_subcategory`
  ADD PRIMARY KEY (`scatid`);

--
-- Indexes for table `db_subcategory1`
--
ALTER TABLE `db_subcategory1`
  ADD PRIMARY KEY (`scatid`);

--
-- Indexes for table `db_subscription`
--
ALTER TABLE `db_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_suppliers`
--
ALTER TABLE `db_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_supplier_payments`
--
ALTER TABLE `db_supplier_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `purchasepayment_id` (`purchasepayment_id`);

--
-- Indexes for table `db_tax`
--
ALTER TABLE `db_tax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_timezone`
--
ALTER TABLE `db_timezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_twilio`
--
ALTER TABLE `db_twilio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_units`
--
ALTER TABLE `db_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_users`
--
ALTER TABLE `db_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_userswarehouses`
--
ALTER TABLE `db_userswarehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `db_variants`
--
ALTER TABLE `db_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_warehouse`
--
ALTER TABLE `db_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `db_warehouseitems`
--
ALTER TABLE `db_warehouseitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `temp_holdinvoice`
--
ALTER TABLE `temp_holdinvoice`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ac_accounts`
--
ALTER TABLE `ac_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ac_moneydeposits`
--
ALTER TABLE `ac_moneydeposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ac_moneytransfer`
--
ALTER TABLE `ac_moneytransfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ac_transactions`
--
ALTER TABLE `ac_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bd_bncategory`
--
ALTER TABLE `bd_bncategory`
  MODIFY `bnid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bd_clcategory`
--
ALTER TABLE `bd_clcategory`
  MODIFY `clid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bd_sbcategory`
--
ALTER TABLE `bd_sbcategory`
  MODIFY `bsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bd_szcategory`
--
ALTER TABLE `bd_szcategory`
  MODIFY `isid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_bankdetails`
--
ALTER TABLE `db_bankdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_brands`
--
ALTER TABLE `db_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;

--
-- AUTO_INCREMENT for table `db_category`
--
ALTER TABLE `db_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `db_cobpayments`
--
ALTER TABLE `db_cobpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_country`
--
ALTER TABLE `db_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `db_coupons`
--
ALTER TABLE `db_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_currency`
--
ALTER TABLE `db_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `db_custadvance`
--
ALTER TABLE `db_custadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_customers`
--
ALTER TABLE `db_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_customer_coupons`
--
ALTER TABLE `db_customer_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_customer_payments`
--
ALTER TABLE `db_customer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_department`
--
ALTER TABLE `db_department`
  MODIFY `dptid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `db_emailtemplates`
--
ALTER TABLE `db_emailtemplates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `db_expense`
--
ALTER TABLE `db_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=979;

--
-- AUTO_INCREMENT for table `db_expense_category`
--
ALTER TABLE `db_expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `db_fivemojo`
--
ALTER TABLE `db_fivemojo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_hold`
--
ALTER TABLE `db_hold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `db_holditems`
--
ALTER TABLE `db_holditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `db_instamojo`
--
ALTER TABLE `db_instamojo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_instamojopayments`
--
ALTER TABLE `db_instamojopayments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_items`
--
ALTER TABLE `db_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_item_models`
--
ALTER TABLE `db_item_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_languages`
--
ALTER TABLE `db_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `db_package`
--
ALTER TABLE `db_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_paymenttypes`
--
ALTER TABLE `db_paymenttypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `db_paypal`
--
ALTER TABLE `db_paypal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_paypalpaylog`
--
ALTER TABLE `db_paypalpaylog`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_permissions`
--
ALTER TABLE `db_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6829;

--
-- AUTO_INCREMENT for table `db_purchase`
--
ALTER TABLE `db_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_purchaseitems`
--
ALTER TABLE `db_purchaseitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7149;

--
-- AUTO_INCREMENT for table `db_purchaseitemsreturn`
--
ALTER TABLE `db_purchaseitemsreturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `db_purchasepayments`
--
ALTER TABLE `db_purchasepayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3217;

--
-- AUTO_INCREMENT for table `db_purchasepaymentsreturn`
--
ALTER TABLE `db_purchasepaymentsreturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `db_purchasereturn`
--
ALTER TABLE `db_purchasereturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `db_quotation`
--
ALTER TABLE `db_quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `db_quotationitems`
--
ALTER TABLE `db_quotationitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2052;

--
-- AUTO_INCREMENT for table `db_rack`
--
ALTER TABLE `db_rack`
  MODIFY `rkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `db_roles`
--
ALTER TABLE `db_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `db_sales`
--
ALTER TABLE `db_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `db_salesitems`
--
ALTER TABLE `db_salesitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119717;

--
-- AUTO_INCREMENT for table `db_salesitemsreturn`
--
ALTER TABLE `db_salesitemsreturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT for table `db_salespayments`
--
ALTER TABLE `db_salespayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51389;

--
-- AUTO_INCREMENT for table `db_salespaymentsreturn`
--
ALTER TABLE `db_salespaymentsreturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `db_salesreturn`
--
ALTER TABLE `db_salesreturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `db_shippingaddress`
--
ALTER TABLE `db_shippingaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1098;

--
-- AUTO_INCREMENT for table `db_sitesettings`
--
ALTER TABLE `db_sitesettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_smsapi`
--
ALTER TABLE `db_smsapi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `db_smstemplates`
--
ALTER TABLE `db_smstemplates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `db_sobpayments`
--
ALTER TABLE `db_sobpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_states`
--
ALTER TABLE `db_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `db_stockadjustment`
--
ALTER TABLE `db_stockadjustment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_stockadjustmentitems`
--
ALTER TABLE `db_stockadjustmentitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3333;

--
-- AUTO_INCREMENT for table `db_stockentry`
--
ALTER TABLE `db_stockentry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_stocktransfer`
--
ALTER TABLE `db_stocktransfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_stocktransferitems`
--
ALTER TABLE `db_stocktransferitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_store`
--
ALTER TABLE `db_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `db_stripe`
--
ALTER TABLE `db_stripe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_stripepayments`
--
ALTER TABLE `db_stripepayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_subcategory`
--
ALTER TABLE `db_subcategory`
  MODIFY `scatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_subcategory1`
--
ALTER TABLE `db_subcategory1`
  MODIFY `scatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_subscription`
--
ALTER TABLE `db_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `db_suppliers`
--
ALTER TABLE `db_suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_supplier_payments`
--
ALTER TABLE `db_supplier_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_tax`
--
ALTER TABLE `db_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `db_timezone`
--
ALTER TABLE `db_timezone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=549;

--
-- AUTO_INCREMENT for table `db_twilio`
--
ALTER TABLE `db_twilio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_units`
--
ALTER TABLE `db_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `db_users`
--
ALTER TABLE `db_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `db_userswarehouses`
--
ALTER TABLE `db_userswarehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `db_variants`
--
ALTER TABLE `db_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `db_warehouse`
--
ALTER TABLE `db_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_warehouseitems`
--
ALTER TABLE `db_warehouseitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158556;

--
-- AUTO_INCREMENT for table `temp_holdinvoice`
--
ALTER TABLE `temp_holdinvoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ac_accounts`
--
ALTER TABLE `ac_accounts`
  ADD CONSTRAINT `ac_accounts_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_accounts_ibfk_2` FOREIGN KEY (`paymenttypes_id`) REFERENCES `db_paymenttypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_accounts_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_accounts_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_accounts_ibfk_5` FOREIGN KEY (`expense_id`) REFERENCES `db_expense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ac_moneydeposits`
--
ALTER TABLE `ac_moneydeposits`
  ADD CONSTRAINT `ac_moneydeposits_ibfk_1` FOREIGN KEY (`debit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_moneydeposits_ibfk_2` FOREIGN KEY (`credit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_moneydeposits_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ac_moneytransfer`
--
ALTER TABLE `ac_moneytransfer`
  ADD CONSTRAINT `ac_moneytransfer_ibfk_1` FOREIGN KEY (`debit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_moneytransfer_ibfk_2` FOREIGN KEY (`credit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_moneytransfer_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ac_transactions`
--
ALTER TABLE `ac_transactions`
  ADD CONSTRAINT `ac_transactions_ibfk_10` FOREIGN KEY (`ref_purchasepayments_id`) REFERENCES `db_purchasepayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_11` FOREIGN KEY (`ref_purchasepaymentsreturn_id`) REFERENCES `db_purchasepaymentsreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_12` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_13` FOREIGN KEY (`ref_expense_id`) REFERENCES `db_expense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_4` FOREIGN KEY (`ref_accounts_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_5` FOREIGN KEY (`ref_moneytransfer_id`) REFERENCES `ac_moneytransfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_6` FOREIGN KEY (`ref_moneydeposits_id`) REFERENCES `ac_moneydeposits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_7` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_8` FOREIGN KEY (`ref_salespayments_id`) REFERENCES `db_salespayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ac_transactions_ibfk_9` FOREIGN KEY (`ref_salespaymentsreturn_id`) REFERENCES `db_salespaymentsreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_bankdetails`
--
ALTER TABLE `db_bankdetails`
  ADD CONSTRAINT `db_bankdetails_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `db_brands`
--
ALTER TABLE `db_brands`
  ADD CONSTRAINT `db_brands_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_brands_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_item_models_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_item_models_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_category`
--
ALTER TABLE `db_category`
  ADD CONSTRAINT `db_category_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_coupons`
--
ALTER TABLE `db_coupons`
  ADD CONSTRAINT `db_coupons_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_coupons_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_custadvance`
--
ALTER TABLE `db_custadvance`
  ADD CONSTRAINT `db_custadvance_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_custadvance_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_customers`
--
ALTER TABLE `db_customers`
  ADD CONSTRAINT `db_customers_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_customer_coupons`
--
ALTER TABLE `db_customer_coupons`
  ADD CONSTRAINT `db_customer_coupons_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_customer_coupons_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_customer_coupons_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_customer_coupons_ibfk_4` FOREIGN KEY (`coupon_id`) REFERENCES `db_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_customer_payments`
--
ALTER TABLE `db_customer_payments`
  ADD CONSTRAINT `db_customer_payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_customer_payments_ibfk_2` FOREIGN KEY (`salespayment_id`) REFERENCES `db_salespayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_emailtemplates`
--
ALTER TABLE `db_emailtemplates`
  ADD CONSTRAINT `db_emailtemplates_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_expense`
--
ALTER TABLE `db_expense`
  ADD CONSTRAINT `db_expense_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_expense_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_expense_category`
--
ALTER TABLE `db_expense_category`
  ADD CONSTRAINT `db_expense_category_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_fivemojo`
--
ALTER TABLE `db_fivemojo`
  ADD CONSTRAINT `db_fivemojo_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_hold`
--
ALTER TABLE `db_hold`
  ADD CONSTRAINT `db_hold_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_hold_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_hold_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_holditems`
--
ALTER TABLE `db_holditems`
  ADD CONSTRAINT `db_holditems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_holditems_ibfk_2` FOREIGN KEY (`hold_id`) REFERENCES `db_hold` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_holditems_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_instamojo`
--
ALTER TABLE `db_instamojo`
  ADD CONSTRAINT `db_instamojo_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_items`
--
ALTER TABLE `db_items`
  ADD CONSTRAINT `db_items_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_package`
--
ALTER TABLE `db_package`
  ADD CONSTRAINT `db_package_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_paymenttypes`
--
ALTER TABLE `db_paymenttypes`
  ADD CONSTRAINT `db_paymenttypes_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_paypal`
--
ALTER TABLE `db_paypal`
  ADD CONSTRAINT `db_paypal_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_permissions`
--
ALTER TABLE `db_permissions`
  ADD CONSTRAINT `db_permissions_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_purchase`
--
ALTER TABLE `db_purchase`
  ADD CONSTRAINT `db_purchase_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchase_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_purchaseitems`
--
ALTER TABLE `db_purchaseitems`
  ADD CONSTRAINT `db_purchaseitems_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `db_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_purchaseitemsreturn`
--
ALTER TABLE `db_purchaseitemsreturn`
  ADD CONSTRAINT `db_purchaseitemsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchaseitemsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_purchasereturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_purchasepayments`
--
ALTER TABLE `db_purchasepayments`
  ADD CONSTRAINT `db_purchasepayments_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchasepayments_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `db_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchasepayments_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_purchasepaymentsreturn`
--
ALTER TABLE `db_purchasepaymentsreturn`
  ADD CONSTRAINT `db_purchasepaymentsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchasepaymentsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_purchasereturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchasepaymentsreturn_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_purchasereturn`
--
ALTER TABLE `db_purchasereturn`
  ADD CONSTRAINT `db_purchasereturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_purchasereturn_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `db_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_quotation`
--
ALTER TABLE `db_quotation`
  ADD CONSTRAINT `db_quotation_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_quotation_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_quotation_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_quotationitems`
--
ALTER TABLE `db_quotationitems`
  ADD CONSTRAINT `db_quotationitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_quotationitems_ibfk_2` FOREIGN KEY (`quotation_id`) REFERENCES `db_quotation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_roles`
--
ALTER TABLE `db_roles`
  ADD CONSTRAINT `db_roles_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_sales`
--
ALTER TABLE `db_sales`
  ADD CONSTRAINT `db_sales_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_sales_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_sales_ibfk_4` FOREIGN KEY (`coupon_id`) REFERENCES `db_customer_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_salesitems`
--
ALTER TABLE `db_salesitems`
  ADD CONSTRAINT `db_salesitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salesitems_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `db_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_salesitemsreturn`
--
ALTER TABLE `db_salesitemsreturn`
  ADD CONSTRAINT `db_salesitemsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salesitemsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_salesreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_salespayments`
--
ALTER TABLE `db_salespayments`
  ADD CONSTRAINT `db_salespayments_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salespayments_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `db_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salespayments_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_salespaymentsreturn`
--
ALTER TABLE `db_salespaymentsreturn`
  ADD CONSTRAINT `db_salespaymentsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salespaymentsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_salesreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salespaymentsreturn_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_salesreturn`
--
ALTER TABLE `db_salesreturn`
  ADD CONSTRAINT `db_salesreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salesreturn_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `db_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_salesreturn_ibfk_3` FOREIGN KEY (`coupon_id`) REFERENCES `db_customer_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_shippingaddress`
--
ALTER TABLE `db_shippingaddress`
  ADD CONSTRAINT `db_shippingaddress_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_shippingaddress_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_smsapi`
--
ALTER TABLE `db_smsapi`
  ADD CONSTRAINT `db_smsapi_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_smstemplates`
--
ALTER TABLE `db_smstemplates`
  ADD CONSTRAINT `db_smstemplates_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_states`
--
ALTER TABLE `db_states`
  ADD CONSTRAINT `db_states_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_stockadjustment`
--
ALTER TABLE `db_stockadjustment`
  ADD CONSTRAINT `db_stockadjustment_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_stockadjustmentitems`
--
ALTER TABLE `db_stockadjustmentitems`
  ADD CONSTRAINT `db_stockadjustmentitems_ibfk_1` FOREIGN KEY (`adjustment_id`) REFERENCES `db_stockadjustment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stockadjustmentitems_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stockadjustmentitems_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stockadjustmentitems_ibfk_4` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_stocktransfer`
--
ALTER TABLE `db_stocktransfer`
  ADD CONSTRAINT `db_stocktransfer_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransfer_ibfk_2` FOREIGN KEY (`warehouse_from`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransfer_ibfk_3` FOREIGN KEY (`warehouse_to`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransfer_ibfk_4` FOREIGN KEY (`to_store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_stocktransferitems`
--
ALTER TABLE `db_stocktransferitems`
  ADD CONSTRAINT `db_stocktransferitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransferitems_ibfk_2` FOREIGN KEY (`warehouse_from`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransferitems_ibfk_3` FOREIGN KEY (`warehouse_to`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransferitems_ibfk_4` FOREIGN KEY (`stocktransfer_id`) REFERENCES `db_stocktransfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransferitems_ibfk_5` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_stocktransferitems_ibfk_6` FOREIGN KEY (`to_store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_stripe`
--
ALTER TABLE `db_stripe`
  ADD CONSTRAINT `db_stripe_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_suppliers`
--
ALTER TABLE `db_suppliers`
  ADD CONSTRAINT `db_suppliers_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_supplier_payments`
--
ALTER TABLE `db_supplier_payments`
  ADD CONSTRAINT `db_supplier_payments_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_supplier_payments_ibfk_2` FOREIGN KEY (`purchasepayment_id`) REFERENCES `db_purchasepayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_tax`
--
ALTER TABLE `db_tax`
  ADD CONSTRAINT `db_tax_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_twilio`
--
ALTER TABLE `db_twilio`
  ADD CONSTRAINT `db_twilio_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_units`
--
ALTER TABLE `db_units`
  ADD CONSTRAINT `db_units_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_users`
--
ALTER TABLE `db_users`
  ADD CONSTRAINT `db_users_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_userswarehouses`
--
ALTER TABLE `db_userswarehouses`
  ADD CONSTRAINT `db_userswarehouses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `db_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_userswarehouses_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_variants`
--
ALTER TABLE `db_variants`
  ADD CONSTRAINT `db_variants_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_variants_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_warehouse`
--
ALTER TABLE `db_warehouse`
  ADD CONSTRAINT `db_warehouse_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `db_warehouseitems`
--
ALTER TABLE `db_warehouseitems`
  ADD CONSTRAINT `db_warehouseitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_warehouseitems_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_warehouseitems_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
