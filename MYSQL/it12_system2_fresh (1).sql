-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 06:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it12_system2_fresh`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`log_id`, `user_id`, `action`, `module`, `description`, `details`, `reference_id`, `reference_no`, `ip_address`, `created_at`) VALUES
(1, 2, 'Create', 'Renters', 'Created renter \'Matcha Fix Davao\'.', '{\"renter_id\":1,\"renter_first_name\":\"Aiko\",\"renter_last_name\":\"Tan\",\"renter_company_name\":\"Matcha Fix Davao\",\"contact_person\":\"Aiko Tan\",\"contact_number\":\"09171234561\",\"email\":\"matchafixdavao@gmail.com\",\"contract_start\":\"2026-03-21\",\"contract_end\":\"2026-12-31\",\"status\":\"active\"}', 1, 'RNT-1', '127.0.0.1', '2026-03-20 08:05:32'),
(2, 2, 'Create', 'Renters', 'Created renter \'Perfols Matcha\'.', '{\"renter_id\":2,\"renter_first_name\":\"Lianne\",\"renter_last_name\":\"Cruz\",\"renter_company_name\":\"Perfols Matcha\",\"contact_person\":\"Lianne Cruz\",\"contact_number\":\"09171234562\",\"email\":\"perfolsmatcha@gmail.com\",\"contract_start\":\"2026-03-21\",\"contract_end\":\"2026-12-21\",\"status\":\"active\"}', 2, 'RNT-2', '127.0.0.1', '2026-03-20 08:07:33'),
(3, 2, 'Create', 'Renters', 'Created renter \'Delta Leather Goods\'.', '{\"renter_id\":3,\"renter_first_name\":\"Marco\",\"renter_last_name\":\"Reyes\",\"renter_company_name\":\"Delta Leather Goods\",\"contact_person\":\"Marco Reyes\",\"contact_number\":\"09171234563\",\"email\":\"deltaleathergoods@gmail.com\",\"contract_start\":\"2026-03-21\",\"contract_end\":\"2026-08-21\",\"status\":\"active\"}', 3, 'RNT-3', '127.0.0.1', '2026-03-20 08:08:53'),
(4, 2, 'Create', 'Renters', 'Created renter \'Whatever. Delta\'.', '{\"renter_id\":4,\"renter_first_name\":\"Sophia\",\"renter_last_name\":\"Lim\",\"renter_company_name\":\"Whatever. Delta\",\"contact_person\":\"Sophia Lim\",\"contact_number\":\"09171234564\",\"email\":\"whateverdelta@gmail.com\",\"contract_start\":\"2026-03-21\",\"contract_end\":\"2026-07-21\",\"status\":\"active\"}', 4, 'RNT-4', '127.0.0.1', '2026-03-20 08:10:18'),
(5, 2, 'Create', 'Renters', 'Created renter \'AfterMarket Sneakers Davao\'.', '{\"renter_id\":5,\"renter_first_name\":\"Joshua\",\"renter_last_name\":\"Dy\",\"renter_company_name\":\"AfterMarket Sneakers Davao\",\"contact_person\":\"Joshua Dy\",\"contact_number\":\"09171234565\",\"email\":\"aftermarketsneakersdvo@gmail.com\",\"contract_start\":\"2026-03-21\",\"contract_end\":\"2026-10-21\",\"status\":\"active\"}', 5, 'RNT-5', '127.0.0.1', '2026-03-20 08:11:42'),
(6, 2, 'Create', 'Renters', 'Created renter \'Point Plaza Essentials\'.', '{\"renter_id\":6,\"renter_first_name\":\"Carla\",\"renter_last_name\":\"Mendoza\",\"renter_company_name\":\"Point Plaza Essentials\",\"contact_person\":\"Carla Mendoza\",\"contact_number\":\"09171234566\",\"email\":\"pointplazaessentials@gmail.com\",\"contract_start\":\"2026-03-01\",\"contract_end\":\"2026-12-31\",\"status\":\"active\"}', 6, 'RNT-6', '127.0.0.1', '2026-03-20 08:13:12'),
(7, 2, 'Create', 'Renters', 'Created renter \'Glow & Lash Corner\'.', '{\"renter_id\":7,\"renter_first_name\":\"Angela\",\"renter_last_name\":\"Flores\",\"renter_company_name\":\"Glow & Lash Corner\",\"contact_person\":\"Angela Flores\",\"contact_number\":\"09171234567\",\"email\":\"glowandlashcorner@gmail.com\",\"contract_start\":\"2026-03-01\",\"contract_end\":\"2026-12-31\",\"status\":\"active\"}', 7, 'RNT-7', '127.0.0.1', '2026-03-20 08:14:27'),
(8, 2, 'Create', 'Renters', 'Created renter \'Daily Oil & Wellness Hub\'.', '{\"renter_id\":8,\"renter_first_name\":\"Daniel\",\"renter_last_name\":\"Torres\",\"renter_company_name\":\"Daily Oil & Wellness Hub\",\"contact_person\":\"Daniel Torres\",\"contact_number\":\"09171234568\",\"email\":\"dailyoilandwellness@gmail.com\",\"contract_start\":\"2026-03-01\",\"contract_end\":\"2026-12-31\",\"status\":\"active\"}', 8, 'RNT-8', '127.0.0.1', '2026-03-20 08:15:41'),
(9, 2, 'Create', 'Renters', 'Created renter \'Sweet Cravings Corner\'.', '{\"renter_id\":9,\"renter_first_name\":\"Mika\",\"renter_last_name\":\"Villanueva\",\"renter_company_name\":\"Sweet Cravings Corner\",\"contact_person\":\"Mika Villanueva\",\"contact_number\":\"09171234569\",\"email\":\"sweetcravingscorner@gmail.com\",\"contract_start\":\"2026-03-01\",\"contract_end\":\"2026-12-31\",\"status\":\"active\"}', 9, 'RNT-9', '127.0.0.1', '2026-03-20 08:16:58'),
(10, 2, 'Create', 'Shelves', 'Created Shelf 1.', '{\"shelf_id\":1,\"shelf_number\":\"1\",\"monthly_rent\":\"3500\",\"renter_id\":null,\"renter_name\":null,\"start_date\":null,\"end_date\":null,\"shelf_status\":\"Available\"}', 1, 'SHF-1', '127.0.0.1', '2026-03-20 08:17:03'),
(11, 2, 'Create', 'Shelves', 'Created Shelf 2.', '{\"shelf_id\":2,\"shelf_number\":\"2\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 2, 'SHF-2', '127.0.0.1', '2026-03-20 08:18:00'),
(12, 2, 'Create', 'Shelves', 'Created Shelf 3.', '{\"shelf_id\":3,\"shelf_number\":\"3\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 3, 'SHF-3', '127.0.0.1', '2026-03-20 08:19:00'),
(13, 2, 'Create', 'Shelves', 'Created Shelf 4.', '{\"shelf_id\":4,\"shelf_number\":\"4\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 4, 'SHF-4', '127.0.0.1', '2026-03-20 08:20:00'),
(14, 2, 'Create', 'Shelves', 'Created Shelf 5.', '{\"shelf_id\":5,\"shelf_number\":\"5\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 5, 'SHF-5', '127.0.0.1', '2026-03-20 08:21:00'),
(15, 2, 'Create', 'Shelves', 'Created Shelf 6.', '{\"shelf_id\":6,\"shelf_number\":\"6\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 6, 'SHF-6', '127.0.0.1', '2026-03-20 08:22:00'),
(16, 2, 'Create', 'Shelves', 'Created Shelf 7.', '{\"shelf_id\":7,\"shelf_number\":\"7\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 7, 'SHF-7', '127.0.0.1', '2026-03-20 08:23:00'),
(17, 2, 'Create', 'Shelves', 'Created Shelf 8.', '{\"shelf_id\":8,\"shelf_number\":\"8\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 8, 'SHF-8', '127.0.0.1', '2026-03-20 08:24:00'),
(18, 2, 'Create', 'Shelves', 'Created Shelf 9.', '{\"shelf_id\":9,\"shelf_number\":\"9\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 9, 'SHF-9', '127.0.0.1', '2026-03-20 08:25:00'),
(19, 2, 'Create', 'Shelves', 'Created Shelf 10.', '{\"shelf_id\":10,\"shelf_number\":\"10\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"shelf_status\":\"Available\"}', 10, 'SHF-10', '127.0.0.1', '2026-03-20 08:26:00'),
(20, 2, 'Assign', 'Shelves', 'Assigned Shelf 1 to \'AfterMarket Sneakers Davao\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-10-21\"}}', 1, 'SHF-1', '127.0.0.1', '2026-03-20 08:19:39'),
(21, 2, 'Assign', 'Shelves', 'Assigned Shelf 10 to \'Daily Oil & Wellness Hub\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-01\",\"end_date\":\"2026-12-31\"}}', 10, 'SHF-10', '127.0.0.1', '2026-03-20 08:19:46'),
(22, 2, 'Assign', 'Shelves', 'Assigned Shelf 2 to \'Delta Leather Goods\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-08-21\"}}', 2, 'SHF-2', '127.0.0.1', '2026-03-20 08:19:55'),
(23, 2, 'Assign', 'Shelves', 'Assigned Shelf 3 to \'Glow & Lash Corner\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-01\",\"end_date\":\"2026-12-31\"}}', 3, 'SHF-3', '127.0.0.1', '2026-03-20 08:20:00'),
(24, 2, 'Assign', 'Shelves', 'Assigned Shelf 4 to \'Matcha Fix Davao\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-12-31\"}}', 4, 'SHF-4', '127.0.0.1', '2026-03-20 08:20:04'),
(25, 2, 'Assign', 'Shelves', 'Assigned Shelf 5 to \'Perfols Matcha\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-12-21\"}}', 5, 'SHF-5', '127.0.0.1', '2026-03-20 08:20:09'),
(26, 2, 'Assign', 'Shelves', 'Assigned Shelf 6 to \'Point Plaza Essentials\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-01\",\"end_date\":\"2026-12-31\"}}', 6, 'SHF-6', '127.0.0.1', '2026-03-20 08:20:30'),
(27, 2, 'Assign', 'Shelves', 'Assigned Shelf 7 to \'Sweet Cravings Corner\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-01\",\"end_date\":\"2026-12-31\"}}', 7, 'SHF-7', '127.0.0.1', '2026-03-20 08:20:36'),
(28, 2, 'Assign', 'Shelves', 'Assigned Shelf 8 to \'Whatever. Delta\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-07-21\"}}', 8, 'SHF-8', '127.0.0.1', '2026-03-20 08:20:43'),
(29, 2, 'Assign', 'Shelves', 'Assigned Shelf 9 to \'Whatever. Delta\'.', '{\"action_type\":\"assignment\",\"before\":{\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":null,\"renter_name\":null,\"shelf_status\":\"Available\",\"start_date\":null,\"end_date\":null},\"after\":{\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\",\"shelf_status\":\"Occupied\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-07-21\"}}', 9, 'SHF-9', '127.0.0.1', '2026-03-20 08:20:58'),
(30, 2, 'Update', 'Shelves', 'Updated Shelf 8.', '{\"before\":{\"shelf_id\":8,\"shelf_number\":\"8\",\"monthly_rent\":\"3500.00\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\",\"start_date\":\"2026-03-21\",\"end_date\":\"2026-07-21\",\"shelf_status\":\"Occupied\"},\"after\":{\"shelf_id\":8,\"shelf_number\":\"8\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"renter_name\":null,\"start_date\":\"2026-03-21\",\"end_date\":\"2026-07-21\",\"shelf_status\":\"Available\"}}', 8, 'SHF-8', '127.0.0.1', '2026-03-20 08:21:09'),
(31, 2, 'Update', 'Shelves', 'Updated Shelf 8.', '{\"before\":{\"shelf_id\":8,\"shelf_number\":\"8\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"renter_name\":null,\"start_date\":\"2026-03-21\",\"end_date\":\"2026-07-21\",\"shelf_status\":\"Available\"},\"after\":{\"shelf_id\":8,\"shelf_number\":\"8\",\"monthly_rent\":\"3500.00\",\"renter_id\":null,\"renter_name\":null,\"start_date\":\"2026-03-21\",\"end_date\":null,\"shelf_status\":\"Available\"}}', 8, 'SHF-8', '127.0.0.1', '2026-03-20 08:21:29'),
(32, 2, 'Create', 'Products', 'Created product \'Sneakers\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":1,\"product_name\":\"Sneakers\",\"description\":\"Class A Shoes\",\"category\":\"Apparel\",\"price\":\"500\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 1, 'PRD-1', '127.0.0.1', '2026-03-20 08:22:17'),
(33, 2, 'Create', 'Products', 'Created product \'Running Shoes\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":2,\"product_name\":\"Running Shoes\",\"description\":\"Lightweight running shoes\",\"category\":\"Apparel\",\"price\":\"650.00\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 2, 'PRD-2', '127.0.0.1', '2026-03-20 08:22:40'),
(34, 2, 'Create', 'Products', 'Created product \'Slip-On Shoes\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":3,\"product_name\":\"Slip-On Shoes\",\"description\":\"Casual slip-on shoes\",\"category\":\"Apparel\",\"price\":\"450.00\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 3, 'PRD-3', '127.0.0.1', '2026-03-20 08:22:55'),
(35, 2, 'Create', 'Products', 'Created product \'High Cut Sneakers\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":4,\"product_name\":\"High Cut Sneakers\",\"description\":\"High cut streetwear sneakers\",\"category\":\"Apparel\",\"price\":\"780.00\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 4, 'PRD-4', '127.0.0.1', '2026-03-20 08:23:10'),
(36, 2, 'Create', 'Products', 'Created product \'Rubber Shoes\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":5,\"product_name\":\"Rubber Shoes\",\"description\":\"Everyday rubber shoes\",\"category\":\"Apparel\",\"price\":\"550.00\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 5, 'PRD-5', '127.0.0.1', '2026-03-20 08:23:25'),
(37, 2, 'Create', 'Products', 'Created product \'Shoe Cleaner\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":6,\"product_name\":\"Shoe Cleaner\",\"description\":\"Foam cleaner for sneakers\",\"category\":\"Footwear Care\",\"price\":\"180.00\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 6, 'PRD-6', '127.0.0.1', '2026-03-20 08:23:40'),
(38, 2, 'Create', 'Products', 'Created product \'Shoelaces\' on Shelf 1 (AfterMarket Sneakers Davao).', '{\"product_id\":7,\"product_name\":\"Shoelaces\",\"description\":\"Replacement shoelaces pair\",\"category\":\"Footwear Care\",\"price\":\"80.00\",\"status\":\"Approved\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\"}', 7, 'PRD-7', '127.0.0.1', '2026-03-20 08:23:55'),
(39, 2, 'Create', 'Products', 'Created product \'Leather Keychain\' on Shelf 2 (Delta Leather Goods).', '{\"product_id\":8,\"product_name\":\"Leather Keychain\",\"description\":\"Handmade leather keychain\",\"category\":\"Accessories\",\"price\":\"120.00\",\"status\":\"Approved\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\"}', 8, 'PRD-8', '127.0.0.1', '2026-03-20 08:24:10'),
(40, 2, 'Create', 'Products', 'Created product \'Card Holder\' on Shelf 2 (Delta Leather Goods).', '{\"product_id\":9,\"product_name\":\"Card Holder\",\"description\":\"Minimalist leather card holder\",\"category\":\"Accessories\",\"price\":\"250.00\",\"status\":\"Approved\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\"}', 9, 'PRD-9', '127.0.0.1', '2026-03-20 08:24:25'),
(41, 2, 'Create', 'Products', 'Created product \'Coin Purse\' on Shelf 2 (Delta Leather Goods).', '{\"product_id\":10,\"product_name\":\"Coin Purse\",\"description\":\"Compact leather coin purse\",\"category\":\"Accessories\",\"price\":\"180.00\",\"status\":\"Approved\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\"}', 10, 'PRD-10', '127.0.0.1', '2026-03-20 08:24:40'),
(42, 2, 'Create', 'Products', 'Created product \'Mini Wallet\' on Shelf 2 (Delta Leather Goods).', '{\"product_id\":11,\"product_name\":\"Mini Wallet\",\"description\":\"Small foldable wallet\",\"category\":\"Accessories\",\"price\":\"320.00\",\"status\":\"Approved\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\"}', 11, 'PRD-11', '127.0.0.1', '2026-03-20 08:24:55'),
(43, 2, 'Create', 'Products', 'Created product \'ID Lace\' on Shelf 2 (Delta Leather Goods).', '{\"product_id\":12,\"product_name\":\"ID Lace\",\"description\":\"Leather style ID lace\",\"category\":\"Accessories\",\"price\":\"95.00\",\"status\":\"Approved\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\"}', 12, 'PRD-12', '127.0.0.1', '2026-03-20 08:25:10'),
(44, 2, 'Create', 'Products', 'Created product \'Leather Wrist Strap\' on Shelf 2 (Delta Leather Goods).', '{\"product_id\":13,\"product_name\":\"Leather Wrist Strap\",\"description\":\"Premium leather wrist strap\",\"category\":\"Accessories\",\"price\":\"140.00\",\"status\":\"Approved\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\"}', 13, 'PRD-13', '127.0.0.1', '2026-03-20 08:25:25'),
(45, 2, 'Create', 'Products', 'Created product \'Lash Glue\' on Shelf 3 (Glow & Lash Corner).', '{\"product_id\":14,\"product_name\":\"Lash Glue\",\"description\":\"Strong hold lash adhesive\",\"category\":\"Beauty\",\"price\":\"180.00\",\"status\":\"Approved\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\"}', 14, 'PRD-14', '127.0.0.1', '2026-03-20 08:25:40'),
(46, 2, 'Create', 'Products', 'Created product \'False Eyelashes\' on Shelf 3 (Glow & Lash Corner).', '{\"product_id\":15,\"product_name\":\"False Eyelashes\",\"description\":\"Natural volume false lashes\",\"category\":\"Beauty\",\"price\":\"120.00\",\"status\":\"Approved\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\"}', 15, 'PRD-15', '127.0.0.1', '2026-03-20 08:25:55'),
(47, 2, 'Create', 'Products', 'Created product \'Brow Kit\' on Shelf 3 (Glow & Lash Corner).', '{\"product_id\":16,\"product_name\":\"Brow Kit\",\"description\":\"Basic brow shaping kit\",\"category\":\"Beauty\",\"price\":\"210.00\",\"status\":\"Approved\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\"}', 16, 'PRD-16', '127.0.0.1', '2026-03-20 08:26:10'),
(48, 2, 'Create', 'Products', 'Created product \'Eyelash Curler\' on Shelf 3 (Glow & Lash Corner).', '{\"product_id\":17,\"product_name\":\"Eyelash Curler\",\"description\":\"Metal eyelash curler\",\"category\":\"Beauty Tools\",\"price\":\"160.00\",\"status\":\"Approved\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\"}', 17, 'PRD-17', '127.0.0.1', '2026-03-20 08:26:25'),
(49, 2, 'Create', 'Products', 'Created product \'Lash Adhesive Remover\' on Shelf 3 (Glow & Lash Corner).', '{\"product_id\":18,\"product_name\":\"Lash Adhesive Remover\",\"description\":\"Gentle remover for lash glue\",\"category\":\"Beauty\",\"price\":\"170.00\",\"status\":\"Approved\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\"}', 18, 'PRD-18', '127.0.0.1', '2026-03-20 08:26:40'),
(50, 2, 'Create', 'Products', 'Created product \'Mascara\' on Shelf 3 (Glow & Lash Corner).', '{\"product_id\":19,\"product_name\":\"Mascara\",\"description\":\"Lengthening black mascara\",\"category\":\"Beauty\",\"price\":\"220.00\",\"status\":\"Approved\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\"}', 19, 'PRD-19', '127.0.0.1', '2026-03-20 08:26:55'),
(51, 2, 'Create', 'Products', 'Created product \'Matcha Powder\' on Shelf 4 (Matcha Fix Davao).', '{\"product_id\":20,\"product_name\":\"Matcha Powder\",\"description\":\"Premium ceremonial matcha powder\",\"category\":\"Beverages\",\"price\":\"299.00\",\"status\":\"Approved\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\"}', 20, 'PRD-20', '127.0.0.1', '2026-03-20 08:27:10'),
(52, 2, 'Create', 'Products', 'Created product \'Matcha Latte Mix\' on Shelf 4 (Matcha Fix Davao).', '{\"product_id\":21,\"product_name\":\"Matcha Latte Mix\",\"description\":\"Sweetened matcha latte powder mix\",\"category\":\"Beverages\",\"price\":\"189.00\",\"status\":\"Approved\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\"}', 21, 'PRD-21', '127.0.0.1', '2026-03-20 08:27:25'),
(53, 2, 'Create', 'Products', 'Created product \'Ceremonial Matcha\' on Shelf 4 (Matcha Fix Davao).', '{\"product_id\":22,\"product_name\":\"Ceremonial Matcha\",\"description\":\"Fine ceremonial grade matcha\",\"category\":\"Beverages\",\"price\":\"420.00\",\"status\":\"Approved\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\"}', 22, 'PRD-22', '127.0.0.1', '2026-03-20 08:27:40'),
(54, 2, 'Create', 'Products', 'Created product \'Matcha Sachets\' on Shelf 4 (Matcha Fix Davao).', '{\"product_id\":23,\"product_name\":\"Matcha Sachets\",\"description\":\"Single-serve matcha sachets\",\"category\":\"Beverages\",\"price\":\"150.00\",\"status\":\"Approved\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\"}', 23, 'PRD-23', '127.0.0.1', '2026-03-20 08:27:55'),
(55, 2, 'Create', 'Products', 'Created product \'Matcha Cookies\' on Shelf 4 (Matcha Fix Davao).', '{\"product_id\":24,\"product_name\":\"Matcha Cookies\",\"description\":\"Matcha flavored cookies\",\"category\":\"Snacks\",\"price\":\"130.00\",\"status\":\"Approved\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\"}', 24, 'PRD-24', '127.0.0.1', '2026-03-20 08:28:10'),
(56, 2, 'Create', 'Products', 'Created product \'Matcha Chocolate Bar\' on Shelf 4 (Matcha Fix Davao).', '{\"product_id\":25,\"product_name\":\"Matcha Chocolate Bar\",\"description\":\"Chocolate bar with matcha filling\",\"category\":\"Snacks\",\"price\":\"145.00\",\"status\":\"Approved\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\"}', 25, 'PRD-25', '127.0.0.1', '2026-03-20 08:28:25'),
(57, 2, 'Create', 'Products', 'Created product \'Sweet Matcha Blend\' on Shelf 5 (Perfols Matcha).', '{\"product_id\":26,\"product_name\":\"Sweet Matcha Blend\",\"description\":\"Sweetened matcha powder for drinks\",\"category\":\"Beverages\",\"price\":\"220.00\",\"status\":\"Approved\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\"}', 26, 'PRD-26', '127.0.0.1', '2026-03-20 08:28:40'),
(58, 2, 'Create', 'Products', 'Created product \'Premium Matcha Powder\' on Shelf 5 (Perfols Matcha).', '{\"product_id\":27,\"product_name\":\"Premium Matcha Powder\",\"description\":\"Premium blended matcha powder\",\"category\":\"Beverages\",\"price\":\"310.00\",\"status\":\"Approved\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\"}', 27, 'PRD-27', '127.0.0.1', '2026-03-20 08:28:55'),
(59, 2, 'Create', 'Products', 'Created product \'Iced Matcha Mix\' on Shelf 5 (Perfols Matcha).', '{\"product_id\":28,\"product_name\":\"Iced Matcha Mix\",\"description\":\"Cold mix matcha powder\",\"category\":\"Beverages\",\"price\":\"205.00\",\"status\":\"Approved\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\"}', 28, 'PRD-28', '127.0.0.1', '2026-03-20 08:29:10'),
(60, 2, 'Create', 'Products', 'Created product \'Matcha Sticks\' on Shelf 5 (Perfols Matcha).', '{\"product_id\":29,\"product_name\":\"Matcha Sticks\",\"description\":\"Portable matcha drink sticks\",\"category\":\"Beverages\",\"price\":\"170.00\",\"status\":\"Approved\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\"}', 29, 'PRD-29', '127.0.0.1', '2026-03-20 08:29:25'),
(61, 2, 'Create', 'Products', 'Created product \'Matcha Biscuit\' on Shelf 5 (Perfols Matcha).', '{\"product_id\":30,\"product_name\":\"Matcha Biscuit\",\"description\":\"Crispy matcha flavored biscuit\",\"category\":\"Snacks\",\"price\":\"110.00\",\"status\":\"Approved\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\"}', 30, 'PRD-30', '127.0.0.1', '2026-03-20 08:29:40'),
(62, 2, 'Create', 'Products', 'Created product \'Matcha Candy\' on Shelf 5 (Perfols Matcha).', '{\"product_id\":31,\"product_name\":\"Matcha Candy\",\"description\":\"Hard candy with matcha flavor\",\"category\":\"Snacks\",\"price\":\"95.00\",\"status\":\"Approved\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\"}', 31, 'PRD-31', '127.0.0.1', '2026-03-20 08:29:55'),
(63, 2, 'Create', 'Products', 'Created product \'Chocolate Bar\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":32,\"product_name\":\"Chocolate Bar\",\"description\":\"Imported milk chocolate bar\",\"category\":\"Snacks\",\"price\":\"85.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 32, 'PRD-32', '127.0.0.1', '2026-03-20 08:30:10'),
(64, 2, 'Create', 'Products', 'Created product \'Imported Cookies\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":33,\"product_name\":\"Imported Cookies\",\"description\":\"Assorted butter cookies\",\"category\":\"Snacks\",\"price\":\"150.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 33, 'PRD-33', '127.0.0.1', '2026-03-20 08:30:25'),
(65, 2, 'Create', 'Products', 'Created product \'Mini Keychain\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":34,\"product_name\":\"Mini Keychain\",\"description\":\"Small novelty keychain\",\"category\":\"Accessories\",\"price\":\"75.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 34, 'PRD-34', '127.0.0.1', '2026-03-20 08:30:40'),
(66, 2, 'Create', 'Products', 'Created product \'Matcha Powder Pack\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":35,\"product_name\":\"Matcha Powder Pack\",\"description\":\"Small retail matcha powder pack\",\"category\":\"Beverages\",\"price\":\"135.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 35, 'PRD-35', '127.0.0.1', '2026-03-20 08:30:55'),
(67, 2, 'Create', 'Products', 'Created product \'Denim Shorts\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":36,\"product_name\":\"Denim Shorts\",\"description\":\"Casual denim shorts\",\"category\":\"Apparel\",\"price\":\"280.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 36, 'PRD-36', '127.0.0.1', '2026-03-20 08:31:10'),
(68, 2, 'Create', 'Products', 'Created product \'Candy Pack\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":37,\"product_name\":\"Candy Pack\",\"description\":\"Mixed fruit candy pack\",\"category\":\"Snacks\",\"price\":\"60.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 37, 'PRD-37', '127.0.0.1', '2026-03-20 08:31:25'),
(69, 2, 'Create', 'Products', 'Created product \'Tote Bag\' on Shelf 6 (Point Plaza Essentials).', '{\"product_id\":38,\"product_name\":\"Tote Bag\",\"description\":\"Canvas everyday tote bag\",\"category\":\"Accessories\",\"price\":\"190.00\",\"status\":\"Approved\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\"}', 38, 'PRD-38', '127.0.0.1', '2026-03-20 08:31:40'),
(70, 2, 'Create', 'Products', 'Created product \'Chocolate Wafer\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":39,\"product_name\":\"Chocolate Wafer\",\"description\":\"Crunchy chocolate wafer snack\",\"category\":\"Snacks\",\"price\":\"65.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 39, 'PRD-39', '127.0.0.1', '2026-03-20 08:31:55'),
(71, 2, 'Create', 'Products', 'Created product \'Milk Chocolate Box\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":40,\"product_name\":\"Milk Chocolate Box\",\"description\":\"Boxed assorted milk chocolates\",\"category\":\"Snacks\",\"price\":\"210.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 40, 'PRD-40', '127.0.0.1', '2026-03-20 08:32:10'),
(72, 2, 'Create', 'Products', 'Created product \'Cookies Pack\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":41,\"product_name\":\"Cookies Pack\",\"description\":\"Packed chocolate chip cookies\",\"category\":\"Snacks\",\"price\":\"95.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 41, 'PRD-41', '127.0.0.1', '2026-03-20 08:32:25'),
(73, 2, 'Create', 'Products', 'Created product \'Biscuit Sticks\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":42,\"product_name\":\"Biscuit Sticks\",\"description\":\"Chocolate coated biscuit sticks\",\"category\":\"Snacks\",\"price\":\"70.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 42, 'PRD-42', '127.0.0.1', '2026-03-20 08:32:40'),
(74, 2, 'Create', 'Products', 'Created product \'Chocolate Coins\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":43,\"product_name\":\"Chocolate Coins\",\"description\":\"Foil wrapped chocolate coins\",\"category\":\"Snacks\",\"price\":\"55.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 43, 'PRD-43', '127.0.0.1', '2026-03-20 08:32:55'),
(75, 2, 'Create', 'Products', 'Created product \'Strawberry Candy\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":44,\"product_name\":\"Strawberry Candy\",\"description\":\"Sweet strawberry hard candy\",\"category\":\"Snacks\",\"price\":\"45.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 44, 'PRD-44', '127.0.0.1', '2026-03-20 08:33:10'),
(76, 2, 'Create', 'Products', 'Created product \'Marshmallow Pack\' on Shelf 7 (Sweet Cravings Corner).', '{\"product_id\":45,\"product_name\":\"Marshmallow Pack\",\"description\":\"Soft marshmallow snack pack\",\"category\":\"Snacks\",\"price\":\"80.00\",\"status\":\"Approved\",\"shelf_id\":7,\"shelf_number\":\"7\",\"renter_id\":9,\"renter_name\":\"Sweet Cravings Corner\"}', 45, 'PRD-45', '127.0.0.1', '2026-03-20 08:33:25'),
(77, 2, 'Create', 'Products', 'Created product \'Acrylic Keychain\' on Shelf 8 (Whatever. Delta).', '{\"product_id\":46,\"product_name\":\"Acrylic Keychain\",\"description\":\"Cute acrylic collectible keychain\",\"category\":\"Collectibles\",\"price\":\"99.00\",\"status\":\"Approved\",\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 46, 'PRD-46', '127.0.0.1', '2026-03-20 08:33:40'),
(78, 2, 'Create', 'Products', 'Created product \'Blind Box Figure\' on Shelf 8 (Whatever. Delta).', '{\"product_id\":47,\"product_name\":\"Blind Box Figure\",\"description\":\"Random collectible blind box toy\",\"category\":\"Collectibles\",\"price\":\"350.00\",\"status\":\"Approved\",\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 47, 'PRD-47', '127.0.0.1', '2026-03-20 08:33:55'),
(79, 2, 'Create', 'Products', 'Created product \'Character Sticker Pack\' on Shelf 8 (Whatever. Delta).', '{\"product_id\":48,\"product_name\":\"Character Sticker Pack\",\"description\":\"Random character sticker set\",\"category\":\"Collectibles\",\"price\":\"85.00\",\"status\":\"Approved\",\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 48, 'PRD-48', '127.0.0.1', '2026-03-20 08:34:10'),
(80, 2, 'Create', 'Products', 'Created product \'Mini Plush Charm\' on Shelf 8 (Whatever. Delta).', '{\"product_id\":49,\"product_name\":\"Mini Plush Charm\",\"description\":\"Soft mini plush bag charm\",\"category\":\"Collectibles\",\"price\":\"190.00\",\"status\":\"Approved\",\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 49, 'PRD-49', '127.0.0.1', '2026-03-20 08:34:25'),
(81, 2, 'Create', 'Products', 'Created product \'Photo Card Holder\' on Shelf 8 (Whatever. Delta).', '{\"product_id\":50,\"product_name\":\"Photo Card Holder\",\"description\":\"K-pop style photocard holder\",\"category\":\"Collectibles\",\"price\":\"145.00\",\"status\":\"Approved\",\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 50, 'PRD-50', '127.0.0.1', '2026-03-20 08:34:40'),
(82, 2, 'Create', 'Products', 'Created product \'Collectible Badge\' on Shelf 8 (Whatever. Delta).', '{\"product_id\":51,\"product_name\":\"Collectible Badge\",\"description\":\"Printed pin badge collectible\",\"category\":\"Collectibles\",\"price\":\"70.00\",\"status\":\"Approved\",\"shelf_id\":8,\"shelf_number\":\"8\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 51, 'PRD-51', '127.0.0.1', '2026-03-20 08:34:55'),
(83, 2, 'Create', 'Products', 'Created product \'Anime Keychain\' on Shelf 9 (Whatever. Delta).', '{\"product_id\":52,\"product_name\":\"Anime Keychain\",\"description\":\"Anime themed keychain\",\"category\":\"Collectibles\",\"price\":\"110.00\",\"status\":\"Approved\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 52, 'PRD-52', '127.0.0.1', '2026-03-20 08:35:10'),
(84, 2, 'Create', 'Products', 'Created product \'Mystery Toy Box\' on Shelf 9 (Whatever. Delta).', '{\"product_id\":53,\"product_name\":\"Mystery Toy Box\",\"description\":\"Surprise collectible toy box\",\"category\":\"Collectibles\",\"price\":\"399.00\",\"status\":\"Approved\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 53, 'PRD-53', '127.0.0.1', '2026-03-20 08:35:25'),
(85, 2, 'Create', 'Products', 'Created product \'Desk Figure\' on Shelf 9 (Whatever. Delta).', '{\"product_id\":54,\"product_name\":\"Desk Figure\",\"description\":\"Small display desk figure\",\"category\":\"Collectibles\",\"price\":\"260.00\",\"status\":\"Approved\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 54, 'PRD-54', '127.0.0.1', '2026-03-20 08:35:40'),
(86, 2, 'Create', 'Products', 'Created product \'Vinyl Sticker Set\' on Shelf 9 (Whatever. Delta).', '{\"product_id\":55,\"product_name\":\"Vinyl Sticker Set\",\"description\":\"Durable vinyl sticker set\",\"category\":\"Collectibles\",\"price\":\"90.00\",\"status\":\"Approved\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 55, 'PRD-55', '127.0.0.1', '2026-03-20 08:35:55'),
(87, 2, 'Create', 'Products', 'Created product \'Mini Notebook\' on Shelf 9 (Whatever. Delta).', '{\"product_id\":56,\"product_name\":\"Mini Notebook\",\"description\":\"Character themed mini notebook\",\"category\":\"Stationery\",\"price\":\"65.00\",\"status\":\"Approved\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 56, 'PRD-56', '127.0.0.1', '2026-03-20 08:36:10'),
(88, 2, 'Create', 'Products', 'Created product \'Lanyard\' on Shelf 9 (Whatever. Delta).', '{\"product_id\":57,\"product_name\":\"Lanyard\",\"description\":\"Printed collectible lanyard\",\"category\":\"Collectibles\",\"price\":\"120.00\",\"status\":\"Approved\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\"}', 57, 'PRD-57', '127.0.0.1', '2026-03-20 08:36:25'),
(89, 2, 'Create', 'Products', 'Created product \'Lavender Oil\' on Shelf 10 (Daily Oil & Wellness Hub).', '{\"product_id\":58,\"product_name\":\"Lavender Oil\",\"description\":\"Relaxing lavender essential oil\",\"category\":\"Wellness\",\"price\":\"199.00\",\"status\":\"Approved\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\"}', 58, 'PRD-58', '127.0.0.1', '2026-03-20 08:36:40'),
(90, 2, 'Create', 'Products', 'Created product \'Peppermint Roll-On\' on Shelf 10 (Daily Oil & Wellness Hub).', '{\"product_id\":59,\"product_name\":\"Peppermint Roll-On\",\"description\":\"Cooling peppermint oil roll-on\",\"category\":\"Wellness\",\"price\":\"149.00\",\"status\":\"Approved\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\"}', 59, 'PRD-59', '127.0.0.1', '2026-03-20 08:36:55'),
(91, 2, 'Create', 'Products', 'Created product \'Eucalyptus Oil\' on Shelf 10 (Daily Oil & Wellness Hub).', '{\"product_id\":60,\"product_name\":\"Eucalyptus Oil\",\"description\":\"Refreshing eucalyptus essential oil\",\"category\":\"Wellness\",\"price\":\"210.00\",\"status\":\"Approved\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\"}', 60, 'PRD-60', '127.0.0.1', '2026-03-20 08:37:10'),
(92, 2, 'Create', 'Products', 'Created product \'Stress Relief Balm\' on Shelf 10 (Daily Oil & Wellness Hub).', '{\"product_id\":61,\"product_name\":\"Stress Relief Balm\",\"description\":\"Herbal balm for relaxation\",\"category\":\"Wellness\",\"price\":\"130.00\",\"status\":\"Approved\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\"}', 61, 'PRD-61', '127.0.0.1', '2026-03-20 08:37:25'),
(93, 2, 'Create', 'Products', 'Created product \'Aroma Inhaler\' on Shelf 10 (Daily Oil & Wellness Hub).', '{\"product_id\":62,\"product_name\":\"Aroma Inhaler\",\"description\":\"Portable aromatic inhaler\",\"category\":\"Wellness\",\"price\":\"95.00\",\"status\":\"Approved\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\"}', 62, 'PRD-62', '127.0.0.1', '2026-03-20 08:37:40'),
(94, 2, 'Create', 'Products', 'Created product \'Tea Tree Oil\' on Shelf 10 (Daily Oil & Wellness Hub).', '{\"product_id\":63,\"product_name\":\"Tea Tree Oil\",\"description\":\"Tea tree essential oil for skin care\",\"category\":\"Wellness\",\"price\":\"175.00\",\"status\":\"Approved\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\"}', 63, 'PRD-63', '127.0.0.1', '2026-03-20 08:37:55'),
(95, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-WWMXAX for Shelf 1 (AfterMarket Sneakers Davao) with 1 item(s), total 10 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\",\"remarks\":null,\"total_items\":1,\"total_units\":10,\"items\":[{\"product_id\":2,\"product_name\":\"Running Shoes\",\"quantity\":10,\"lot_number\":\"LOT-BFWHWC\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"650\"}]}', 1, 'IN-20260320-WWMXAX', '127.0.0.1', '2026-03-20 08:43:19'),
(96, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-Z1JSSY for Shelf 1 (AfterMarket Sneakers Davao) with 7 item(s), total 67 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":1,\"shelf_number\":\"1\",\"renter_id\":5,\"renter_name\":\"AfterMarket Sneakers Davao\",\"remarks\":null,\"total_items\":7,\"total_units\":67,\"items\":[{\"product_id\":4,\"product_name\":\"High Cut Sneakers\",\"quantity\":10,\"lot_number\":\"LOT-ZBNDHT\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"},{\"product_id\":5,\"product_name\":\"Rubber Shoes\",\"quantity\":10,\"lot_number\":\"LOT-SFMR2G\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"},{\"product_id\":2,\"product_name\":\"Running Shoes\",\"quantity\":9,\"lot_number\":\"LOT-1XZY1H\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"},{\"product_id\":6,\"product_name\":\"Shoe Cleaner\",\"quantity\":9,\"lot_number\":\"LOT-LQ1AP6\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"},{\"product_id\":7,\"product_name\":\"Shoelaces\",\"quantity\":9,\"lot_number\":\"LOT-YXM3LO\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"},{\"product_id\":3,\"product_name\":\"Slip-On Shoes\",\"quantity\":10,\"lot_number\":\"LOT-IYS6IX\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"},{\"product_id\":1,\"product_name\":\"Sneakers\",\"quantity\":10,\"lot_number\":\"LOT-HYH7DC\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"500\"}]}', 2, 'IN-20260320-Z1JSSY', '127.0.0.1', '2026-03-20 08:45:07'),
(97, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-IWKZCE for Shelf 10 (Daily Oil & Wellness Hub) with 6 item(s), total 60 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\",\"remarks\":null,\"total_items\":6,\"total_units\":60,\"items\":[{\"product_id\":62,\"product_name\":\"Aroma Inhaler\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2027-03-21\",\"unit_cost\":\"10\"},{\"product_id\":60,\"product_name\":\"Eucalyptus Oil\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2027-10-14\",\"unit_cost\":\"10\"},{\"product_id\":60,\"product_name\":\"Eucalyptus Oil\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-07-21\",\"unit_cost\":\"10\"},{\"product_id\":59,\"product_name\":\"Peppermint Roll-On\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-06-17\",\"unit_cost\":\"10\"},{\"product_id\":61,\"product_name\":\"Stress Relief Balm\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-06-23\",\"unit_cost\":\"10\"},{\"product_id\":63,\"product_name\":\"Tea Tree Oil\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-05-27\",\"unit_cost\":\"10\"}]}', 3, 'IN-20260320-IWKZCE', '127.0.0.1', '2026-03-20 08:47:43'),
(98, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-HYTUEP for Shelf 10 (Daily Oil & Wellness Hub) with 1 item(s), total 3 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":10,\"shelf_number\":\"10\",\"renter_id\":8,\"renter_name\":\"Daily Oil & Wellness Hub\",\"remarks\":null,\"total_items\":1,\"total_units\":3,\"items\":[{\"product_id\":58,\"product_name\":\"Lavender Oil\",\"quantity\":3,\"lot_number\":\"LOT-03\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-22\",\"unit_cost\":\"10\"}]}', 4, 'IN-20260320-HYTUEP', '127.0.0.1', '2026-03-20 08:48:26'),
(99, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-CK3H8Z for Shelf 2 (Delta Leather Goods) with 6 item(s), total 60 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":2,\"shelf_number\":\"2\",\"renter_id\":3,\"renter_name\":\"Delta Leather Goods\",\"remarks\":null,\"total_items\":6,\"total_units\":60,\"items\":[{\"product_id\":9,\"product_name\":\"Card Holder\",\"quantity\":10,\"lot_number\":\"LOT-LB20SP\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null},{\"product_id\":10,\"product_name\":\"Coin Purse\",\"quantity\":10,\"lot_number\":\"LOT-AUPRQQ\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null},{\"product_id\":12,\"product_name\":\"ID Lace\",\"quantity\":10,\"lot_number\":\"LOT-OTEBI7\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null},{\"product_id\":8,\"product_name\":\"Leather Keychain\",\"quantity\":10,\"lot_number\":\"LOT-XJQMHQ\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null},{\"product_id\":13,\"product_name\":\"Leather Wrist Strap\",\"quantity\":10,\"lot_number\":\"LOT-9YERD1\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null},{\"product_id\":11,\"product_name\":\"Mini Wallet\",\"quantity\":10,\"lot_number\":\"LOT-SS6KKE\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null}]}', 5, 'IN-20260320-CK3H8Z', '127.0.0.1', '2026-03-20 08:49:42'),
(100, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-T8GIWQ for Shelf 3 (Glow & Lash Corner) with 6 item(s), total 60 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":3,\"shelf_number\":\"3\",\"renter_id\":7,\"renter_name\":\"Glow & Lash Corner\",\"remarks\":null,\"total_items\":6,\"total_units\":60,\"items\":[{\"product_id\":16,\"product_name\":\"Brow Kit\",\"quantity\":10,\"lot_number\":\"LOT-POI36O\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":17,\"product_name\":\"Eyelash Curler\",\"quantity\":10,\"lot_number\":\"LOT-XVOMAO\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":15,\"product_name\":\"False Eyelashes\",\"quantity\":10,\"lot_number\":\"LOT-6L9MSL\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":18,\"product_name\":\"Lash Adhesive Remover\",\"quantity\":10,\"lot_number\":\"LOT-I4RZ44\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":14,\"product_name\":\"Lash Glue\",\"quantity\":10,\"lot_number\":\"LOT-VWUQUC\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":19,\"product_name\":\"Mascara\",\"quantity\":10,\"lot_number\":\"LOT-GDHYUY\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"}]}', 6, 'IN-20260320-T8GIWQ', '127.0.0.1', '2026-03-20 08:50:14'),
(101, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-FPEIN5 for Shelf 4 (Matcha Fix Davao) with 6 item(s), total 60 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":4,\"shelf_number\":\"4\",\"renter_id\":1,\"renter_name\":\"Matcha Fix Davao\",\"remarks\":null,\"total_items\":6,\"total_units\":60,\"items\":[{\"product_id\":22,\"product_name\":\"Ceremonial Matcha\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-24\",\"unit_cost\":\"10\"},{\"product_id\":25,\"product_name\":\"Matcha Chocolate Bar\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-24\",\"unit_cost\":\"10\"},{\"product_id\":24,\"product_name\":\"Matcha Cookies\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-24\",\"unit_cost\":\"10\"},{\"product_id\":21,\"product_name\":\"Matcha Latte Mix\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-24\",\"unit_cost\":\"10\"},{\"product_id\":20,\"product_name\":\"Matcha Powder\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-24\",\"unit_cost\":\"10\"},{\"product_id\":23,\"product_name\":\"Matcha Sachets\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-24\",\"unit_cost\":\"10\"}]}', 7, 'IN-20260320-FPEIN5', '127.0.0.1', '2026-03-20 08:51:35');
INSERT INTO `audit_logs` (`log_id`, `user_id`, `action`, `module`, `description`, `details`, `reference_id`, `reference_no`, `ip_address`, `created_at`) VALUES
(102, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-33K1BF for Shelf 6 (Point Plaza Essentials) with 7 item(s), total 70 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":6,\"shelf_number\":\"6\",\"renter_id\":6,\"renter_name\":\"Point Plaza Essentials\",\"remarks\":null,\"total_items\":7,\"total_units\":70,\"items\":[{\"product_id\":37,\"product_name\":\"Candy Pack\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-06-21\",\"unit_cost\":\"10\"},{\"product_id\":32,\"product_name\":\"Chocolate Bar\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-26\",\"unit_cost\":\"10\"},{\"product_id\":36,\"product_name\":\"Denim Shorts\",\"quantity\":10,\"lot_number\":\"LOT-QXKRZ8\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":33,\"product_name\":\"Imported Cookies\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-26\",\"unit_cost\":\"10\"},{\"product_id\":35,\"product_name\":\"Matcha Powder Pack\",\"quantity\":10,\"lot_number\":\"LOT-01\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2026-03-31\",\"unit_cost\":\"10\"},{\"product_id\":34,\"product_name\":\"Mini Keychain\",\"quantity\":10,\"lot_number\":\"LOT-X71TOB\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"},{\"product_id\":38,\"product_name\":\"Tote Bag\",\"quantity\":10,\"lot_number\":\"LOT-CJRAAF\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"10\"}]}', 8, 'IN-20260320-33K1BF', '127.0.0.1', '2026-03-20 08:53:00'),
(103, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-8VCKLR for Shelf 9 (Whatever. Delta) with 6 item(s), total 65 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":9,\"shelf_number\":\"9\",\"renter_id\":4,\"renter_name\":\"Whatever. Delta\",\"remarks\":null,\"total_items\":6,\"total_units\":65,\"items\":[{\"product_id\":52,\"product_name\":\"Anime Keychain\",\"quantity\":10,\"lot_number\":\"LOT-HMOV6W\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"11\"},{\"product_id\":54,\"product_name\":\"Desk Figure\",\"quantity\":11,\"lot_number\":\"LOT-NXEPOE\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"11\"},{\"product_id\":57,\"product_name\":\"Lanyard\",\"quantity\":11,\"lot_number\":\"LOT-IGOZMV\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"11\"},{\"product_id\":56,\"product_name\":\"Mini Notebook\",\"quantity\":11,\"lot_number\":\"LOT-DAC5MT\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"11\"},{\"product_id\":53,\"product_name\":\"Mystery Toy Box\",\"quantity\":11,\"lot_number\":\"LOT-BOLIWP\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":\"11\"},{\"product_id\":55,\"product_name\":\"Vinyl Sticker Set\",\"quantity\":11,\"lot_number\":\"LOT-YGMHRX\",\"manufacturing_date\":null,\"expiration_date\":\"2076-03-20\",\"unit_cost\":null}]}', 9, 'IN-20260320-8VCKLR', '127.0.0.1', '2026-03-20 08:54:30'),
(104, 2, 'Stock In', 'Inventory', 'Stock In IN-20260320-BVAO2E for Shelf 5 (Perfols Matcha) with 2 item(s), total 80 unit(s).', '{\"transaction_type\":\"IN\",\"transaction_date\":\"2026-03-20\",\"shelf_id\":5,\"shelf_number\":\"5\",\"renter_id\":2,\"renter_name\":\"Perfols Matcha\",\"remarks\":null,\"total_items\":2,\"total_units\":80,\"items\":[{\"product_id\":28,\"product_name\":\"Iced Matcha Mix\",\"quantity\":40,\"lot_number\":\"LOT-03\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2027-10-12\",\"unit_cost\":\"40\"},{\"product_id\":30,\"product_name\":\"Matcha Biscuit\",\"quantity\":40,\"lot_number\":\"LOT-03\",\"manufacturing_date\":\"2026-03-21\",\"expiration_date\":\"2027-07-21\",\"unit_cost\":\"40\"}]}', 10, 'IN-20260320-BVAO2E', '127.0.0.1', '2026-03-20 08:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expiration_alerts`
--

CREATE TABLE `expiration_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_on_hand` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL DEFAULT 5,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `quantity_on_hand`, `reorder_level`, `last_updated`) VALUES
(1, 2, 19, 5, '2026-03-20 08:45:07'),
(2, 4, 10, 5, '2026-03-20 08:45:07'),
(3, 5, 10, 5, '2026-03-20 08:45:07'),
(4, 6, 9, 5, '2026-03-20 08:45:07'),
(5, 7, 9, 5, '2026-03-20 08:45:07'),
(6, 3, 10, 5, '2026-03-20 08:45:07'),
(7, 1, 10, 5, '2026-03-20 08:45:07'),
(8, 62, 10, 5, '2026-03-20 08:47:43'),
(9, 60, 20, 5, '2026-03-20 08:47:43'),
(10, 59, 10, 5, '2026-03-20 08:47:43'),
(11, 61, 10, 5, '2026-03-20 08:47:43'),
(12, 63, 10, 5, '2026-03-20 08:47:43'),
(13, 58, 3, 5, '2026-03-20 08:48:26'),
(14, 9, 10, 5, '2026-03-20 08:49:42'),
(15, 10, 10, 5, '2026-03-20 08:49:42'),
(16, 12, 10, 5, '2026-03-20 08:49:42'),
(17, 8, 10, 5, '2026-03-20 08:49:42'),
(18, 13, 10, 5, '2026-03-20 08:49:42'),
(19, 11, 10, 5, '2026-03-20 08:49:42'),
(20, 16, 10, 5, '2026-03-20 08:50:14'),
(21, 17, 10, 5, '2026-03-20 08:50:14'),
(22, 15, 10, 5, '2026-03-20 08:50:14'),
(23, 18, 10, 5, '2026-03-20 08:50:14'),
(24, 14, 10, 5, '2026-03-20 08:50:14'),
(25, 19, 10, 5, '2026-03-20 08:50:14'),
(26, 22, 10, 5, '2026-03-20 08:51:35'),
(27, 25, 10, 5, '2026-03-20 08:51:35'),
(28, 24, 10, 5, '2026-03-20 08:51:35'),
(29, 21, 10, 5, '2026-03-20 08:51:35'),
(30, 20, 10, 5, '2026-03-20 08:51:35'),
(31, 23, 10, 5, '2026-03-20 08:51:35'),
(32, 37, 10, 5, '2026-03-20 08:53:00'),
(33, 32, 10, 5, '2026-03-20 08:53:00'),
(34, 36, 10, 5, '2026-03-20 08:53:00'),
(35, 33, 10, 5, '2026-03-20 08:53:00'),
(36, 35, 10, 5, '2026-03-20 08:53:00'),
(37, 34, 10, 5, '2026-03-20 08:53:00'),
(38, 38, 10, 5, '2026-03-20 08:53:00'),
(39, 52, 10, 5, '2026-03-20 08:54:30'),
(40, 54, 11, 5, '2026-03-20 08:54:30'),
(41, 57, 11, 5, '2026-03-20 08:54:30'),
(42, 56, 11, 5, '2026-03-20 08:54:30'),
(43, 53, 11, 5, '2026-03-20 08:54:30'),
(44, 55, 11, 5, '2026-03-20 08:54:30'),
(45, 28, 40, 5, '2026-03-20 08:55:43'),
(46, 30, 40, 5, '2026-03-20 08:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction`
--

CREATE TABLE `inventory_transaction` (
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('IN','OUT','ADJUSTMENT','RETURN') NOT NULL,
  `renter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shelf_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reference_no` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Approved',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `review_remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transaction`
--

INSERT INTO `inventory_transaction` (`transaction_id`, `transaction_type`, `renter_id`, `shelf_id`, `transaction_date`, `reference_no`, `remarks`, `status`, `created_by`, `approved_by`, `approved_at`, `review_remarks`, `created_at`) VALUES
(1, 'IN', 5, 1, '2026-03-19 16:00:00', 'IN-20260320-WWMXAX', NULL, 'Approved', 2, 2, '2026-03-20 08:43:19', NULL, '2026-03-20 08:43:19'),
(2, 'IN', 5, 1, '2026-03-19 16:00:00', 'IN-20260320-Z1JSSY', NULL, 'Approved', 2, 2, '2026-03-20 08:45:07', NULL, '2026-03-20 08:45:07'),
(3, 'IN', 8, 10, '2026-03-19 16:00:00', 'IN-20260320-IWKZCE', NULL, 'Approved', 2, 2, '2026-03-20 08:47:43', NULL, '2026-03-20 08:47:43'),
(4, 'IN', 8, 10, '2026-03-19 16:00:00', 'IN-20260320-HYTUEP', NULL, 'Approved', 2, 2, '2026-03-20 08:48:26', NULL, '2026-03-20 08:48:26'),
(5, 'IN', 3, 2, '2026-03-19 16:00:00', 'IN-20260320-CK3H8Z', NULL, 'Approved', 2, 2, '2026-03-20 08:49:42', NULL, '2026-03-20 08:49:42'),
(6, 'IN', 7, 3, '2026-03-19 16:00:00', 'IN-20260320-T8GIWQ', NULL, 'Approved', 2, 2, '2026-03-20 08:50:14', NULL, '2026-03-20 08:50:14'),
(7, 'IN', 1, 4, '2026-03-19 16:00:00', 'IN-20260320-FPEIN5', NULL, 'Approved', 2, 2, '2026-03-20 08:51:35', NULL, '2026-03-20 08:51:35'),
(8, 'IN', 6, 6, '2026-03-19 16:00:00', 'IN-20260320-33K1BF', NULL, 'Approved', 2, 2, '2026-03-20 08:53:00', NULL, '2026-03-20 08:53:00'),
(9, 'IN', 4, 9, '2026-03-19 16:00:00', 'IN-20260320-8VCKLR', NULL, 'Approved', 2, 2, '2026-03-20 08:54:30', NULL, '2026-03-20 08:54:30'),
(10, 'IN', 2, 5, '2026-03-19 16:00:00', 'IN-20260320-BVAO2E', NULL, 'Approved', 2, 2, '2026-03-20 08:55:43', NULL, '2026-03-20 08:55:43'),
(11, 'IN', 4, 9, '2026-03-19 16:00:00', 'PIN-20260320-8FPMGX', NULL, 'Pending', 4, NULL, NULL, NULL, '2026-03-20 08:58:29'),
(12, 'IN', 3, 2, '2026-03-19 16:00:00', 'PIN-20260320-PKF44U', NULL, 'Pending', 4, NULL, NULL, NULL, '2026-03-20 08:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction_items`
--

CREATE TABLE `inventory_transaction_items` (
  `transaction_item_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lot_number` varchar(50) DEFAULT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `adjustment_mode` varchar(20) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transaction_items`
--

INSERT INTO `inventory_transaction_items` (`transaction_item_id`, `transaction_id`, `product_id`, `batch_id`, `lot_number`, `manufacturing_date`, `expiration_date`, `quantity`, `adjustment_mode`, `unit_cost`) VALUES
(1, 1, 2, 1, 'LOT-BFWHWC', NULL, NULL, 10, NULL, 650.00),
(2, 2, 4, 2, 'LOT-ZBNDHT', NULL, NULL, 10, NULL, 500.00),
(3, 2, 5, 3, 'LOT-SFMR2G', NULL, NULL, 10, NULL, 500.00),
(4, 2, 2, 4, 'LOT-1XZY1H', NULL, NULL, 9, NULL, 500.00),
(5, 2, 6, 5, 'LOT-LQ1AP6', NULL, NULL, 9, NULL, 500.00),
(6, 2, 7, 6, 'LOT-YXM3LO', NULL, NULL, 9, NULL, 500.00),
(7, 2, 3, 7, 'LOT-IYS6IX', NULL, NULL, 10, NULL, 500.00),
(8, 2, 1, 8, 'LOT-HYH7DC', NULL, NULL, 10, NULL, 500.00),
(9, 3, 62, 9, 'LOT-01', '2026-03-21', '2027-03-21', 10, NULL, 10.00),
(10, 3, 60, 10, 'LOT-01', '2026-03-21', '2027-10-14', 10, NULL, 10.00),
(11, 3, 60, 11, 'LOT-01', '2026-03-21', '2026-07-21', 10, NULL, 10.00),
(12, 3, 59, 12, 'LOT-01', '2026-03-21', '2026-06-17', 10, NULL, 10.00),
(13, 3, 61, 13, 'LOT-01', '2026-03-21', '2026-06-23', 10, NULL, 10.00),
(14, 3, 63, 14, 'LOT-01', '2026-03-21', '2026-05-27', 10, NULL, 10.00),
(15, 4, 58, 15, 'LOT-03', '2026-03-21', '2026-03-22', 3, NULL, 10.00),
(16, 5, 9, 16, 'LOT-LB20SP', NULL, NULL, 10, NULL, NULL),
(17, 5, 10, 17, 'LOT-AUPRQQ', NULL, NULL, 10, NULL, NULL),
(18, 5, 12, 18, 'LOT-OTEBI7', NULL, NULL, 10, NULL, NULL),
(19, 5, 8, 19, 'LOT-XJQMHQ', NULL, NULL, 10, NULL, NULL),
(20, 5, 13, 20, 'LOT-9YERD1', NULL, NULL, 10, NULL, NULL),
(21, 5, 11, 21, 'LOT-SS6KKE', NULL, NULL, 10, NULL, NULL),
(22, 6, 16, 22, 'LOT-POI36O', NULL, NULL, 10, NULL, 10.00),
(23, 6, 17, 23, 'LOT-XVOMAO', NULL, NULL, 10, NULL, 10.00),
(24, 6, 15, 24, 'LOT-6L9MSL', NULL, NULL, 10, NULL, 10.00),
(25, 6, 18, 25, 'LOT-I4RZ44', NULL, NULL, 10, NULL, 10.00),
(26, 6, 14, 26, 'LOT-VWUQUC', NULL, NULL, 10, NULL, 10.00),
(27, 6, 19, 27, 'LOT-GDHYUY', NULL, NULL, 10, NULL, 10.00),
(28, 7, 22, 28, 'LOT-01', '2026-03-21', '2026-03-24', 10, NULL, 10.00),
(29, 7, 25, 29, 'LOT-01', '2026-03-21', '2026-03-24', 10, NULL, 10.00),
(30, 7, 24, 30, 'LOT-01', '2026-03-21', '2026-03-24', 10, NULL, 10.00),
(31, 7, 21, 31, 'LOT-01', '2026-03-21', '2026-03-24', 10, NULL, 10.00),
(32, 7, 20, 32, 'LOT-01', '2026-03-21', '2026-03-24', 10, NULL, 10.00),
(33, 7, 23, 33, 'LOT-01', '2026-03-21', '2026-03-24', 10, NULL, 10.00),
(34, 8, 37, 34, 'LOT-01', '2026-03-21', '2026-06-21', 10, NULL, 10.00),
(35, 8, 32, 35, 'LOT-01', '2026-03-21', '2026-03-26', 10, NULL, 10.00),
(36, 8, 36, 36, 'LOT-QXKRZ8', NULL, NULL, 10, NULL, 10.00),
(37, 8, 33, 37, 'LOT-01', '2026-03-21', '2026-03-26', 10, NULL, 10.00),
(38, 8, 35, 38, 'LOT-01', '2026-03-21', '2026-03-31', 10, NULL, 10.00),
(39, 8, 34, 39, 'LOT-X71TOB', NULL, NULL, 10, NULL, 10.00),
(40, 8, 38, 40, 'LOT-CJRAAF', NULL, NULL, 10, NULL, 10.00),
(41, 9, 52, 41, 'LOT-HMOV6W', NULL, NULL, 10, NULL, 11.00),
(42, 9, 54, 42, 'LOT-NXEPOE', NULL, NULL, 11, NULL, 11.00),
(43, 9, 57, 43, 'LOT-IGOZMV', NULL, NULL, 11, NULL, 11.00),
(44, 9, 56, 44, 'LOT-DAC5MT', NULL, NULL, 11, NULL, 11.00),
(45, 9, 53, 45, 'LOT-BOLIWP', NULL, NULL, 11, NULL, 11.00),
(46, 9, 55, 46, 'LOT-YGMHRX', NULL, NULL, 11, NULL, NULL),
(47, 10, 28, 47, 'LOT-03', '2026-03-21', '2027-10-12', 40, NULL, 40.00),
(48, 10, 30, 48, 'LOT-03', '2026-03-21', '2027-07-21', 40, NULL, 40.00),
(49, 11, 52, NULL, NULL, NULL, NULL, 30, NULL, 30.00),
(50, 11, 54, NULL, NULL, NULL, NULL, 30, NULL, 30.00),
(51, 11, 57, NULL, NULL, NULL, NULL, 30, NULL, 30.00),
(52, 11, 56, NULL, NULL, NULL, NULL, 30, NULL, 30.00),
(53, 12, 9, NULL, NULL, NULL, NULL, 30, NULL, NULL),
(54, 12, 8, NULL, NULL, NULL, NULL, 30, NULL, NULL),
(55, 12, 13, NULL, NULL, NULL, NULL, 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_26_065419_create_renters_table', 1),
(5, '2026_02_26_065420_create_shelves_table', 1),
(6, '2026_02_26_065421_create_products_table', 1),
(7, '2026_02_26_065422_create_expiration_alerts_table', 1),
(8, '2026_02_26_065422_create_product_batch_table', 1),
(9, '2026_02_26_065422_create_rental_payments_table', 1),
(10, '2026_02_26_065422_create_stock_alerts_table', 1),
(11, '2026_02_26_065423_create_inventory_table', 1),
(12, '2026_02_26_065423_create_inventory_transaction_table', 1),
(13, '2026_02_26_065423_create_renter_payouts_table', 1),
(14, '2026_02_26_065424_create_inventory_transaction_items_table', 1),
(15, '2026_02_26_065424_create_sales_table', 1),
(16, '2026_02_26_065425_create_sales_items_table', 1),
(17, '2026_02_26_074900_add_role_to_users_table', 1),
(18, '2026_02_26_075723_add_role_to_users_table', 1),
(19, '2026_02_27_011613_add_renter_company_name_to_renters_table', 1),
(20, '2026_02_28_024928_make_shelf_dates_nullable', 2),
(21, '2026_03_07_045849_alter_inventory_transaction_add_status_fields', 3),
(22, '2026_03_07_045939_alter_inventory_transaction_items_for_pending_requests', 4),
(23, '2026_03_07_051601_add_status_to_inventory_transaction_table', 1),
(24, '2026_03_11_163249_create_audit_logs_table', 5),
(25, '2026_03_19_062647_add_details_to_audit_logs_table', 6),
(26, '2026_03_19_082451_add_adjustment_mode_to_inventory_transaction_items_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('neorylet@gmail.com', '$2y$12$65yNfxoDklLjITOPz6Wche2Z9Hp4h62s0k8qIKN/T/lg5hWrutET.', '2026-03-19 22:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shelf_id` bigint(20) UNSIGNED DEFAULT NULL,
  `renter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `category`, `price`, `shelf_id`, `renter_id`, `status`, `created_by`, `approved_by`, `created_at`) VALUES
(1, 'Sneakers', 'Class A Shoes', 'Apparel', 500.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:22:17'),
(2, 'Running Shoes', 'Lightweight running shoes', 'Apparel', 650.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:22:40'),
(3, 'Slip-On Shoes', 'Casual slip-on shoes', 'Apparel', 450.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:22:55'),
(4, 'High Cut Sneakers', 'High cut streetwear sneakers', 'Apparel', 780.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:23:10'),
(5, 'Rubber Shoes', 'Everyday rubber shoes', 'Apparel', 550.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:23:25'),
(6, 'Shoe Cleaner', 'Foam cleaner for sneakers', 'Footwear Care', 180.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:23:40'),
(7, 'Shoelaces', 'Replacement shoelaces pair', 'Footwear Care', 80.00, 1, 5, 'Approved', 2, 2, '2026-03-20 08:23:55'),
(8, 'Leather Keychain', 'Handmade leather keychain', 'Accessories', 120.00, 2, 3, 'Approved', 2, 2, '2026-03-20 08:24:10'),
(9, 'Card Holder', 'Minimalist leather card holder', 'Accessories', 250.00, 2, 3, 'Approved', 2, 2, '2026-03-20 08:24:25'),
(10, 'Coin Purse', 'Compact leather coin purse', 'Accessories', 180.00, 2, 3, 'Approved', 2, 2, '2026-03-20 08:24:40'),
(11, 'Mini Wallet', 'Small foldable wallet', 'Accessories', 320.00, 2, 3, 'Approved', 2, 2, '2026-03-20 08:24:55'),
(12, 'ID Lace', 'Leather style ID lace', 'Accessories', 95.00, 2, 3, 'Approved', 2, 2, '2026-03-20 08:25:10'),
(13, 'Leather Wrist Strap', 'Premium leather wrist strap', 'Accessories', 140.00, 2, 3, 'Approved', 2, 2, '2026-03-20 08:25:25'),
(14, 'Lash Glue', 'Strong hold lash adhesive', 'Beauty', 180.00, 3, 7, 'Approved', 2, 2, '2026-03-20 08:25:40'),
(15, 'False Eyelashes', 'Natural volume false lashes', 'Beauty', 120.00, 3, 7, 'Approved', 2, 2, '2026-03-20 08:25:55'),
(16, 'Brow Kit', 'Basic brow shaping kit', 'Beauty', 210.00, 3, 7, 'Approved', 2, 2, '2026-03-20 08:26:10'),
(17, 'Eyelash Curler', 'Metal eyelash curler', 'Beauty Tools', 160.00, 3, 7, 'Approved', 2, 2, '2026-03-20 08:26:25'),
(18, 'Lash Adhesive Remover', 'Gentle remover for lash glue', 'Beauty', 170.00, 3, 7, 'Approved', 2, 2, '2026-03-20 08:26:40'),
(19, 'Mascara', 'Lengthening black mascara', 'Beauty', 220.00, 3, 7, 'Approved', 2, 2, '2026-03-20 08:26:55'),
(20, 'Matcha Powder', 'Premium ceremonial matcha powder', 'Beverages', 299.00, 4, 1, 'Approved', 2, 2, '2026-03-20 08:27:10'),
(21, 'Matcha Latte Mix', 'Sweetened matcha latte powder mix', 'Beverages', 189.00, 4, 1, 'Approved', 2, 2, '2026-03-20 08:27:25'),
(22, 'Ceremonial Matcha', 'Fine ceremonial grade matcha', 'Beverages', 420.00, 4, 1, 'Approved', 2, 2, '2026-03-20 08:27:40'),
(23, 'Matcha Sachets', 'Single-serve matcha sachets', 'Beverages', 150.00, 4, 1, 'Approved', 2, 2, '2026-03-20 08:27:55'),
(24, 'Matcha Cookies', 'Matcha flavored cookies', 'Snacks', 130.00, 4, 1, 'Approved', 2, 2, '2026-03-20 08:28:10'),
(25, 'Matcha Chocolate Bar', 'Chocolate bar with matcha filling', 'Snacks', 145.00, 4, 1, 'Approved', 2, 2, '2026-03-20 08:28:25'),
(26, 'Sweet Matcha Blend', 'Sweetened matcha powder for drinks', 'Beverages', 220.00, 5, 2, 'Approved', 2, 2, '2026-03-20 08:28:40'),
(27, 'Premium Matcha Powder', 'Premium blended matcha powder', 'Beverages', 310.00, 5, 2, 'Approved', 2, 2, '2026-03-20 08:28:55'),
(28, 'Iced Matcha Mix', 'Cold mix matcha powder', 'Beverages', 205.00, 5, 2, 'Approved', 2, 2, '2026-03-20 08:29:10'),
(29, 'Matcha Sticks', 'Portable matcha drink sticks', 'Beverages', 170.00, 5, 2, 'Approved', 2, 2, '2026-03-20 08:29:25'),
(30, 'Matcha Biscuit', 'Crispy matcha flavored biscuit', 'Snacks', 110.00, 5, 2, 'Approved', 2, 2, '2026-03-20 08:29:40'),
(31, 'Matcha Candy', 'Hard candy with matcha flavor', 'Snacks', 95.00, 5, 2, 'Approved', 2, 2, '2026-03-20 08:29:55'),
(32, 'Chocolate Bar', 'Imported milk chocolate bar', 'Snacks', 85.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:30:10'),
(33, 'Imported Cookies', 'Assorted butter cookies', 'Snacks', 150.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:30:25'),
(34, 'Mini Keychain', 'Small novelty keychain', 'Accessories', 75.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:30:40'),
(35, 'Matcha Powder Pack', 'Small retail matcha powder pack', 'Beverages', 135.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:30:55'),
(36, 'Denim Shorts', 'Casual denim shorts', 'Apparel', 280.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:31:10'),
(37, 'Candy Pack', 'Mixed fruit candy pack', 'Snacks', 60.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:31:25'),
(38, 'Tote Bag', 'Canvas everyday tote bag', 'Accessories', 190.00, 6, 6, 'Approved', 2, 2, '2026-03-20 08:31:40'),
(39, 'Chocolate Wafer', 'Crunchy chocolate wafer snack', 'Snacks', 65.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:31:55'),
(40, 'Milk Chocolate Box', 'Boxed assorted milk chocolates', 'Snacks', 210.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:32:10'),
(41, 'Cookies Pack', 'Packed chocolate chip cookies', 'Snacks', 95.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:32:25'),
(42, 'Biscuit Sticks', 'Chocolate coated biscuit sticks', 'Snacks', 70.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:32:40'),
(43, 'Chocolate Coins', 'Foil wrapped chocolate coins', 'Snacks', 55.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:32:55'),
(44, 'Strawberry Candy', 'Sweet strawberry hard candy', 'Snacks', 45.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:33:10'),
(45, 'Marshmallow Pack', 'Soft marshmallow snack pack', 'Snacks', 80.00, 7, 9, 'Approved', 2, 2, '2026-03-20 08:33:25'),
(46, 'Acrylic Keychain', 'Cute acrylic collectible keychain', 'Collectibles', 99.00, NULL, NULL, 'Approved', 2, 2, '2026-03-20 08:33:40'),
(47, 'Blind Box Figure', 'Random collectible blind box toy', 'Collectibles', 350.00, NULL, NULL, 'Approved', 2, 2, '2026-03-20 08:33:55'),
(48, 'Character Sticker Pack', 'Random character sticker set', 'Collectibles', 85.00, NULL, NULL, 'Approved', 2, 2, '2026-03-20 08:34:10'),
(49, 'Mini Plush Charm', 'Soft mini plush bag charm', 'Collectibles', 190.00, NULL, NULL, 'Approved', 2, 2, '2026-03-20 08:34:25'),
(50, 'Photo Card Holder', 'K-pop style photocard holder', 'Collectibles', 145.00, NULL, NULL, 'Approved', 2, 2, '2026-03-20 08:34:40'),
(51, 'Collectible Badge', 'Printed pin badge collectible', 'Collectibles', 70.00, NULL, NULL, 'Approved', 2, 2, '2026-03-20 08:34:55'),
(52, 'Anime Keychain', 'Anime themed keychain', 'Collectibles', 110.00, 9, 4, 'Approved', 2, 2, '2026-03-20 08:35:10'),
(53, 'Mystery Toy Box', 'Surprise collectible toy box', 'Collectibles', 399.00, 9, 4, 'Approved', 2, 2, '2026-03-20 08:35:25'),
(54, 'Desk Figure', 'Small display desk figure', 'Collectibles', 260.00, 9, 4, 'Approved', 2, 2, '2026-03-20 08:35:40'),
(55, 'Vinyl Sticker Set', 'Durable vinyl sticker set', 'Collectibles', 90.00, 9, 4, 'Approved', 2, 2, '2026-03-20 08:35:55'),
(56, 'Mini Notebook', 'Character themed mini notebook', 'Stationery', 65.00, 9, 4, 'Approved', 2, 2, '2026-03-20 08:36:10'),
(57, 'Lanyard', 'Printed collectible lanyard', 'Collectibles', 120.00, 9, 4, 'Approved', 2, 2, '2026-03-20 08:36:25'),
(58, 'Lavender Oil', 'Relaxing lavender essential oil', 'Wellness', 199.00, 10, 8, 'Approved', 2, 2, '2026-03-20 08:36:40'),
(59, 'Peppermint Roll-On', 'Cooling peppermint oil roll-on', 'Wellness', 149.00, 10, 8, 'Approved', 2, 2, '2026-03-20 08:36:55'),
(60, 'Eucalyptus Oil', 'Refreshing eucalyptus essential oil', 'Wellness', 210.00, 10, 8, 'Approved', 2, 2, '2026-03-20 08:37:10'),
(61, 'Stress Relief Balm', 'Herbal balm for relaxation', 'Wellness', 130.00, 10, 8, 'Approved', 2, 2, '2026-03-20 08:37:25'),
(62, 'Aroma Inhaler', 'Portable aromatic inhaler', 'Wellness', 95.00, 10, 8, 'Approved', 2, 2, '2026-03-20 08:37:40'),
(63, 'Tea Tree Oil', 'Tea tree essential oil for skin care', 'Wellness', 175.00, 10, 8, 'Approved', 2, 2, '2026-03-20 08:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_batch`
--

CREATE TABLE `product_batch` (
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `lot_number` varchar(50) NOT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiration_date` date NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `quantity_remaining` int(11) NOT NULL,
  `date_received` date NOT NULL,
  `status` enum('Active','Expired','Depleted') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_batch`
--

INSERT INTO `product_batch` (`batch_id`, `product_id`, `lot_number`, `manufacturing_date`, `expiration_date`, `quantity_received`, `quantity_remaining`, `date_received`, `status`) VALUES
(1, 2, 'LOT-BFWHWC', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(2, 4, 'LOT-ZBNDHT', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(3, 5, 'LOT-SFMR2G', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(4, 2, 'LOT-1XZY1H', NULL, '2076-03-20', 9, 9, '2026-03-20', 'Active'),
(5, 6, 'LOT-LQ1AP6', NULL, '2076-03-20', 9, 9, '2026-03-20', 'Active'),
(6, 7, 'LOT-YXM3LO', NULL, '2076-03-20', 9, 9, '2026-03-20', 'Active'),
(7, 3, 'LOT-IYS6IX', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(8, 1, 'LOT-HYH7DC', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(9, 62, 'LOT-01', '2026-03-21', '2027-03-21', 10, 10, '2026-03-20', 'Active'),
(10, 60, 'LOT-01', '2026-03-21', '2027-10-14', 10, 10, '2026-03-20', 'Active'),
(11, 60, 'LOT-01', '2026-03-21', '2026-07-21', 10, 10, '2026-03-20', 'Active'),
(12, 59, 'LOT-01', '2026-03-21', '2026-06-17', 10, 10, '2026-03-20', 'Active'),
(13, 61, 'LOT-01', '2026-03-21', '2026-06-23', 10, 10, '2026-03-20', 'Active'),
(14, 63, 'LOT-01', '2026-03-21', '2026-05-27', 10, 10, '2026-03-20', 'Active'),
(15, 58, 'LOT-03', '2026-03-21', '2026-03-22', 3, 3, '2026-03-20', 'Active'),
(16, 9, 'LOT-LB20SP', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(17, 10, 'LOT-AUPRQQ', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(18, 12, 'LOT-OTEBI7', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(19, 8, 'LOT-XJQMHQ', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(20, 13, 'LOT-9YERD1', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(21, 11, 'LOT-SS6KKE', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(22, 16, 'LOT-POI36O', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(23, 17, 'LOT-XVOMAO', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(24, 15, 'LOT-6L9MSL', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(25, 18, 'LOT-I4RZ44', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(26, 14, 'LOT-VWUQUC', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(27, 19, 'LOT-GDHYUY', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(28, 22, 'LOT-01', '2026-03-21', '2026-03-24', 10, 10, '2026-03-20', 'Active'),
(29, 25, 'LOT-01', '2026-03-21', '2026-03-24', 10, 10, '2026-03-20', 'Active'),
(30, 24, 'LOT-01', '2026-03-21', '2026-03-24', 10, 10, '2026-03-20', 'Active'),
(31, 21, 'LOT-01', '2026-03-21', '2026-03-24', 10, 10, '2026-03-20', 'Active'),
(32, 20, 'LOT-01', '2026-03-21', '2026-03-24', 10, 10, '2026-03-20', 'Active'),
(33, 23, 'LOT-01', '2026-03-21', '2026-03-24', 10, 10, '2026-03-20', 'Active'),
(34, 37, 'LOT-01', '2026-03-21', '2026-06-21', 10, 10, '2026-03-20', 'Active'),
(35, 32, 'LOT-01', '2026-03-21', '2026-03-26', 10, 10, '2026-03-20', 'Active'),
(36, 36, 'LOT-QXKRZ8', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(37, 33, 'LOT-01', '2026-03-21', '2026-03-26', 10, 10, '2026-03-20', 'Active'),
(38, 35, 'LOT-01', '2026-03-21', '2026-03-31', 10, 10, '2026-03-20', 'Active'),
(39, 34, 'LOT-X71TOB', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(40, 38, 'LOT-CJRAAF', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(41, 52, 'LOT-HMOV6W', NULL, '2076-03-20', 10, 10, '2026-03-20', 'Active'),
(42, 54, 'LOT-NXEPOE', NULL, '2076-03-20', 11, 11, '2026-03-20', 'Active'),
(43, 57, 'LOT-IGOZMV', NULL, '2076-03-20', 11, 11, '2026-03-20', 'Active'),
(44, 56, 'LOT-DAC5MT', NULL, '2076-03-20', 11, 11, '2026-03-20', 'Active'),
(45, 53, 'LOT-BOLIWP', NULL, '2076-03-20', 11, 11, '2026-03-20', 'Active'),
(46, 55, 'LOT-YGMHRX', NULL, '2076-03-20', 11, 11, '2026-03-20', 'Active'),
(47, 28, 'LOT-03', '2026-03-21', '2027-10-12', 40, 40, '2026-03-20', 'Active'),
(48, 30, 'LOT-03', '2026-03-21', '2027-07-21', 40, 40, '2026-03-20', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rental_payments`
--

CREATE TABLE `rental_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `renters`
--

CREATE TABLE `renters` (
  `renter_id` bigint(20) UNSIGNED NOT NULL,
  `renter_first_name` varchar(255) NOT NULL,
  `renter_last_name` varchar(255) NOT NULL,
  `renter_company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contract_start` date NOT NULL,
  `contract_end` date NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `renters`
--

INSERT INTO `renters` (`renter_id`, `renter_first_name`, `renter_last_name`, `renter_company_name`, `contact_person`, `contact_number`, `email`, `contract_start`, `contract_end`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Aiko', 'Tan', 'Matcha Fix Davao', 'Aiko Tan', '09171234561', 'matchafixdavao@gmail.com', '2026-03-21', '2026-12-31', 'active', '2026-03-20 08:05:32', '2026-03-20 08:05:32'),
(2, 'Lianne', 'Cruz', 'Perfols Matcha', 'Lianne Cruz', '09171234562', 'perfolsmatcha@gmail.com', '2026-03-21', '2026-12-21', 'active', '2026-03-20 08:07:33', '2026-03-20 08:07:33'),
(3, 'Marco', 'Reyes', 'Delta Leather Goods', 'Marco Reyes', '09171234563', 'deltaleathergoods@gmail.com', '2026-03-21', '2026-08-21', 'active', '2026-03-20 08:08:53', '2026-03-20 08:08:53'),
(4, 'Sophia', 'Lim', 'Whatever. Delta', 'Sophia Lim', '09171234564', 'whateverdelta@gmail.com', '2026-03-21', '2026-07-21', 'active', '2026-03-20 08:10:18', '2026-03-20 08:10:18'),
(5, 'Joshua', 'Dy', 'AfterMarket Sneakers Davao', 'Joshua Dy', '09171234565', 'aftermarketsneakersdvo@gmail.com', '2026-03-21', '2026-10-21', 'active', '2026-03-20 08:11:42', '2026-03-20 08:11:42'),
(6, 'Carla', 'Mendoza', 'Point Plaza Essentials', 'Carla Mendoza', '09171234566', 'pointplazaessentials@gmail.com', '2026-03-01', '2026-12-31', 'active', '2026-03-20 08:13:12', '2026-03-20 08:13:12'),
(7, 'Angela', 'Flores', 'Glow & Lash Corner', 'Angela Flores', '09171234567', 'glowandlashcorner@gmail.com', '2026-03-01', '2026-12-31', 'active', '2026-03-20 08:14:27', '2026-03-20 08:14:27'),
(8, 'Daniel', 'Torres', 'Daily Oil & Wellness Hub', 'Daniel Torres', '09171234568', 'dailyoilandwellness@gmail.com', '2026-03-01', '2026-12-31', 'active', '2026-03-20 08:15:41', '2026-03-20 08:15:41'),
(9, 'Mika', 'Villanueva', 'Sweet Cravings Corner', 'Mika Villanueva', '09171234569', 'sweetcravingscorner@gmail.com', '2026-03-01', '2026-12-31', 'active', '2026-03-20 08:16:58', '2026-03-20 08:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `renter_payouts`
--

CREATE TABLE `renter_payouts` (
  `payout_id` bigint(20) UNSIGNED NOT NULL,
  `renter_id` bigint(20) UNSIGNED NOT NULL,
  `week_start` date NOT NULL,
  `week_end` date NOT NULL,
  `total_sales` decimal(10,2) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `payout_date` date DEFAULT NULL,
  `status` enum('Pending','Released') NOT NULL DEFAULT 'Pending',
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method` enum('Cash','GCash','Card') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `sale_item_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RBodSTLjEd2x0go0JQLvsO31P3DJniRkZIzbl86Z', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaUl2M3dsVlNNSlR3VGxsTTNyN3FSb1h1U2tzb1pWVWFlb0ZTVENyTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9pbnZlbnRvcnkvcGVuZGluZyI7czo1OiJyb3V0ZSI7czoyMzoiYWRtaW4uaW52ZW50b3J5LnBlbmRpbmciO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1774027968);

-- --------------------------------------------------------

--
-- Table structure for table `shelves`
--

CREATE TABLE `shelves` (
  `shelf_id` bigint(20) UNSIGNED NOT NULL,
  `shelf_number` varchar(20) NOT NULL,
  `renter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `monthly_rent` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `shelf_status` enum('Available','Occupied') NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shelves`
--

INSERT INTO `shelves` (`shelf_id`, `shelf_number`, `renter_id`, `monthly_rent`, `start_date`, `end_date`, `shelf_status`) VALUES
(1, '1', 5, 3500.00, '2026-03-21', '2026-10-21', 'Occupied'),
(2, '2', 3, 3500.00, '2026-03-21', '2026-08-21', 'Occupied'),
(3, '3', 7, 3500.00, '2026-03-01', '2026-12-31', 'Occupied'),
(4, '4', 1, 3500.00, '2026-03-21', '2026-12-31', 'Occupied'),
(5, '5', 2, 3500.00, '2026-03-21', '2026-12-21', 'Occupied'),
(6, '6', 6, 3500.00, '2026-03-01', '2026-12-31', 'Occupied'),
(7, '7', 9, 3500.00, '2026-03-01', '2026-12-31', 'Occupied'),
(8, '8', NULL, 3500.00, '2026-03-21', NULL, 'Available'),
(9, '9', 4, 3500.00, '2026-03-21', '2026-07-21', 'Occupied'),
(10, '10', 8, 3500.00, '2026-03-01', '2026-12-31', 'Occupied');

-- --------------------------------------------------------

--
-- Table structure for table `stock_alerts`
--

CREATE TABLE `stock_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Staff') NOT NULL DEFAULT 'Admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Neo Ryle Tubera', 'neorylet@gmail.com', NULL, '$2y$12$9hNm8CxV5CR3a/9hjvcjpO/10l03Z0tkhUaR8eMfuumeNmBqLQho.', 'Admin', NULL, '2026-02-27 17:32:24', '2026-02-27 17:32:24'),
(4, 'staff', 'staff1@gmail.com', NULL, '$2y$12$78NBd7Bk7zluehWtYY0Aje94XckNfGuJfsKWsPK9blHysmSVPlYxC', 'Staff', NULL, '2026-03-01 07:56:18', '2026-03-01 07:56:18'),
(5, 'Neo New', 'neoryletubera@gmail.com', NULL, '$2y$12$FQBmZ3iFxhWp241Zgc.qQu96q3n4FINVjHnTfPtTMMGSOuPU29Psi', 'Admin', NULL, '2026-03-19 22:21:48', '2026-03-19 22:21:48'),
(6, 'Sophia Janelaaa', 'iya@gmail.com', NULL, '$2y$12$w84DvW9Lt5UVEfaz5/VdoeRCS0ijDW28PnaOAfFvUkY5P.OTBRnrC', 'Staff', NULL, '2026-03-19 22:32:14', '2026-03-19 22:32:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `expiration_alerts`
--
ALTER TABLE `expiration_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD UNIQUE KEY `inventory_product_id_unique` (`product_id`);

--
-- Indexes for table `inventory_transaction`
--
ALTER TABLE `inventory_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `inventory_transaction_renter_id_foreign` (`renter_id`),
  ADD KEY `inventory_transaction_shelf_id_foreign` (`shelf_id`),
  ADD KEY `inventory_transaction_created_by_foreign` (`created_by`),
  ADD KEY `inventory_transaction_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `inventory_transaction_items`
--
ALTER TABLE `inventory_transaction_items`
  ADD PRIMARY KEY (`transaction_item_id`),
  ADD KEY `inventory_transaction_items_transaction_id_foreign` (`transaction_id`),
  ADD KEY `inventory_transaction_items_batch_id_foreign` (`batch_id`),
  ADD KEY `inventory_transaction_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_shelf_id_foreign` (`shelf_id`),
  ADD KEY `products_renter_id_foreign` (`renter_id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `product_batch`
--
ALTER TABLE `product_batch`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `product_batch_product_id_foreign` (`product_id`);

--
-- Indexes for table `rental_payments`
--
ALTER TABLE `rental_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renters`
--
ALTER TABLE `renters`
  ADD PRIMARY KEY (`renter_id`),
  ADD UNIQUE KEY `renters_email_unique` (`email`);

--
-- Indexes for table `renter_payouts`
--
ALTER TABLE `renter_payouts`
  ADD PRIMARY KEY (`payout_id`),
  ADD KEY `renter_payouts_renter_id_foreign` (`renter_id`),
  ADD KEY `renter_payouts_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `sales_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `sales_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sales_items_product_id_foreign` (`product_id`),
  ADD KEY `sales_items_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shelves`
--
ALTER TABLE `shelves`
  ADD PRIMARY KEY (`shelf_id`),
  ADD UNIQUE KEY `shelves_shelf_number_unique` (`shelf_number`),
  ADD KEY `shelves_renter_id_foreign` (`renter_id`);

--
-- Indexes for table `stock_alerts`
--
ALTER TABLE `stock_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `expiration_alerts`
--
ALTER TABLE `expiration_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `inventory_transaction`
--
ALTER TABLE `inventory_transaction`
  MODIFY `transaction_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inventory_transaction_items`
--
ALTER TABLE `inventory_transaction_items`
  MODIFY `transaction_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `product_batch`
--
ALTER TABLE `product_batch`
  MODIFY `batch_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `rental_payments`
--
ALTER TABLE `rental_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `renters`
--
ALTER TABLE `renters`
  MODIFY `renter_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `renter_payouts`
--
ALTER TABLE `renter_payouts`
  MODIFY `payout_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `sale_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shelves`
--
ALTER TABLE `shelves`
  MODIFY `shelf_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock_alerts`
--
ALTER TABLE `stock_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_transaction`
--
ALTER TABLE `inventory_transaction`
  ADD CONSTRAINT `inventory_transaction_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_renter_id_foreign` FOREIGN KEY (`renter_id`) REFERENCES `renters` (`renter_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_shelf_id_foreign` FOREIGN KEY (`shelf_id`) REFERENCES `shelves` (`shelf_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inventory_transaction_items`
--
ALTER TABLE `inventory_transaction_items`
  ADD CONSTRAINT `inventory_transaction_items_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `product_batch` (`batch_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `inventory_transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_renter_id_foreign` FOREIGN KEY (`renter_id`) REFERENCES `renters` (`renter_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_shelf_id_foreign` FOREIGN KEY (`shelf_id`) REFERENCES `shelves` (`shelf_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_batch`
--
ALTER TABLE `product_batch`
  ADD CONSTRAINT `product_batch_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `renter_payouts`
--
ALTER TABLE `renter_payouts`
  ADD CONSTRAINT `renter_payouts_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `renter_payouts_renter_id_foreign` FOREIGN KEY (`renter_id`) REFERENCES `renters` (`renter_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD CONSTRAINT `sales_items_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `product_batch` (`batch_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shelves`
--
ALTER TABLE `shelves`
  ADD CONSTRAINT `shelves_renter_id_foreign` FOREIGN KEY (`renter_id`) REFERENCES `renters` (`renter_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
