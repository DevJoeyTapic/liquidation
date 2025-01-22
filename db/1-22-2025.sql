-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.40 - MySQL Community Server - GPL
-- Server OS:                    Linux
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for liquidation
CREATE DATABASE IF NOT EXISTS `liquidation` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `liquidation`;

-- Dumping structure for table liquidation.accounting_liquidations
CREATE TABLE IF NOT EXISTS `accounting_liquidations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(255) NOT NULL,
  `liquidation_no` varchar(50) NOT NULL,
  `vessel` varchar(255) NOT NULL,
  `voyage` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.accounting_liquidations: ~0 rows (approximately)

-- Dumping structure for table liquidation.agent_liquidations
CREATE TABLE IF NOT EXISTS `agent_liquidations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vessel` varchar(255) DEFAULT NULL,
  `voyage` varchar(10) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `eta` date DEFAULT NULL,
  `etd` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.agent_liquidations: ~5 rows (approximately)
INSERT INTO `agent_liquidations` (`id`, `user_id`, `vessel`, `voyage`, `port`, `eta`, `etd`) VALUES
	(1, 2, 'MSC Laila', 'MSCL123', 'Port of Los Angeles', '2025-02-01', '2025-02-01'),
	(2, 2, 'Maersk Emilia', 'MAE456', 'Port of Rotterdam', '2025-02-05', '2025-02-05'),
	(3, 2, 'CMA CGM Marco Polo', 'CMA789', 'Port of Singapore', '2025-02-10', '2025-02-10'),
	(4, 2, 'Ever Given', 'EGV112', 'Port of Shanghai', '2025-02-15', '2025-02-15'),
	(5, 505, 'Hapag-Lloyd Express', 'HLX202', 'Port of Hamburg', '2025-02-20', '2025-02-20');

-- Dumping structure for table liquidation.liquidation_master
CREATE TABLE IF NOT EXISTS `liquidation_master` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rfp_no` int unsigned NOT NULL DEFAULT '0',
  `rfp_amount` decimal(20,2) unsigned NOT NULL DEFAULT (0),
  `actual_amount` decimal(20,2) unsigned NOT NULL DEFAULT (0),
  `variance` decimal(20,2) unsigned NOT NULL DEFAULT (0),
  `remarks` varchar(255) DEFAULT '0',
  `docref` int DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `liq_ref` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.liquidation_master: ~18 rows (approximately)
INSERT INTO `liquidation_master` (`id`, `item`, `description`, `rfp_no`, `rfp_amount`, `actual_amount`, `variance`, `remarks`, `docref`, `status`, `user_id`, `liq_ref`) VALUES
	(6, 'Berthing Fee', '', 7402, 19306.00, 0.00, 0.00, '0', 0, 'Pending', 3, '1'),
	(7, 'Harbour Fee', '', 7401, 40097.00, 0.00, 0.00, '0', 0, 'Liquidated', 3, '1'),
	(8, 'Clearance To Port Authorities', '', 7400, 10000.00, 0.00, 0.00, '0', 0, 'Liquidated', 3, '1'),
	(9, 'Mooring/Unmooring', '', 7400, 10000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '1'),
	(10, 'Immigration Inspector And Guards', '', 7400, 20000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '1'),
	(11, 'Immigration Boarding Officer', '', 7400, 6000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '1'),
	(12, 'Customs Collector', '', 7400, 5000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '1'),
	(13, 'Customs Inspector And Guard', '', 7400, 20000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '1'),
	(14, 'Customs Entrance And Clearance Officer', '', 7400, 6500.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(15, 'Customs Boarding Officer', '', 7400, 7000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(16, 'Fisheries Quarantine', '', 7400, 4500.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(17, 'Plant Quarantine', '', 7400, 4500.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(18, 'Animal Quarantine', '', 7400, 4500.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(19, 'Medical Quarantine', '', 7400, 10000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(20, 'Agency Representative Expenses', '', 7400, 21000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(21, 'Philippine Coast Guard / Port State Control', '', 7400, 10000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(22, 'Customs Intelligence And Narcotic Police', '', 7400, 5000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2'),
	(23, 'Visa Fee', '', 7400, 14000.00, 0.00, 0.00, '0', 0, 'Pending', 3, '2');

-- Dumping structure for table liquidation.notes_master
CREATE TABLE IF NOT EXISTS `notes_master` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT (now()),
  `epda_ref` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.notes_master: ~5 rows (approximately)
INSERT INTO `notes_master` (`id`, `sender`, `notes`, `timestamp`, `epda_ref`) VALUES
	(1, 'agent', 'Payment received for invoice #123', '2025-01-20 08:45:00', 'TNK-100001616-01'),
	(2, 'accounting', 'Shipping order confirmed for product XYZ', '2025-01-20 09:00:00', 'TNK-100001616-01'),
	(3, 'agent', 'Product returned due to defect', '2025-01-19 14:30:00', 'TNK-100001616-01'),
	(4, 'accounting', 'Customer inquiry about product availability', '2025-01-18 11:15:00', 'TNK-100001616-01'),
	(5, 'agent', 'Scheduled maintenance for equipment', '2025-01-17 16:45:00', 'TNK-100001616-01');

-- Dumping structure for table liquidation.user_account
CREATE TABLE IF NOT EXISTS `user_account` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` int NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.user_account: ~3 rows (approximately)
INSERT INTO `user_account` (`user_id`, `username`, `password`, `user_type`) VALUES
	(1, 'admin', 'pass', 1),
	(2, 'accounting', 'pass', 3),
	(3, 'agent', 'pass', 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
