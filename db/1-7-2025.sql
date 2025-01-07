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

-- Dumping data for table liquidation.accounting_liquidations: ~5 rows (approximately)
INSERT INTO `accounting_liquidations` (`id`, `agent_name`, `liquidation_no`, `vessel`, `voyage`) VALUES
	(1, 'Alice Johnson', 'LQD00123', 'MV Oceanic Explorer', 'V001'),
	(2, 'Robert Smith', 'LQD00456', 'SS Atlantic Breeze', 'V002'),
	(3, 'Emma Williams', 'LQD07890', 'MV Horizon Star', 'V003'),
	(4, 'Michael Davis', 'LQD11234', 'SS Pacific Pioneer', 'V004'),
	(5, 'Sophia Brown', 'LQD23456', 'MV Ocean Wave', 'V005');

-- Dumping structure for table liquidation.agent_liquidations
CREATE TABLE IF NOT EXISTS `agent_liquidations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vessel` varchar(255) DEFAULT NULL,
  `voyage` varchar(10) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `eta` date DEFAULT NULL,
  `etd` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.agent_liquidations: ~5 rows (approximately)
INSERT INTO `agent_liquidations` (`id`, `vessel`, `voyage`, `port`, `eta`, `etd`) VALUES
	(1, 'MV Oceanic Explorer', 'V001', 'Port of Los Angeles', '2025-01-10', '2025-01-12'),
	(2, 'SS Atlantic Breeze', 'V002', 'Port of Rotterdam', '2025-02-05', '2025-02-07'),
	(3, 'MV Horizon Star', 'V003', 'Port of Singapore', '2025-01-15', '2025-01-17'),
	(4, 'SS Pacific Pioneer', 'V004', 'Port of Hong Kong', '2025-01-20', '2025-01-22'),
	(5, 'MV Ocean Wave', 'V005', 'Port of Dubai', '2025-03-01', '2025-03-03');

-- Dumping structure for table liquidation.user_account
CREATE TABLE IF NOT EXISTS `user_account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table liquidation.user_account: ~3 rows (approximately)
INSERT INTO `user_account` (`id`, `username`, `password`, `user_type`) VALUES
	(1, 'admin', 'pass', 1),
	(2, 'accounting', 'pass', 3),
	(3, 'agent', 'pass', 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
