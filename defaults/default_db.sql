-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.13-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for espressolight
CREATE DATABASE IF NOT EXISTS `espressolight` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `espressolight`;

-- Dumping structure for table espressolight.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
                                          `account_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                          `owner_id` bigint(20) NOT NULL,
                                          `account_name` varchar(250) NOT NULL DEFAULT '',
                                          PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.accounts: ~0 rows (approximately)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- Dumping structure for table espressolight.companies
CREATE TABLE IF NOT EXISTS `companies` (
                                           `company_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                           PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.companies: ~0 rows (approximately)
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;

-- Dumping structure for table espressolight.contragents
CREATE TABLE IF NOT EXISTS `contragents` (
                                             `contragent_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                             PRIMARY KEY (`contragent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.contragents: ~0 rows (approximately)
/*!40000 ALTER TABLE `contragents` DISABLE KEYS */;
/*!40000 ALTER TABLE `contragents` ENABLE KEYS */;

-- Dumping structure for table espressolight.expenses
CREATE TABLE IF NOT EXISTS `expenses` (
                                          `expense_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                          PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.expenses: ~0 rows (approximately)
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;

-- Dumping structure for table espressolight.incoming
CREATE TABLE IF NOT EXISTS `incoming` (
                                          `incoming_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                          PRIMARY KEY (`incoming_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.incoming: ~0 rows (approximately)
/*!40000 ALTER TABLE `incoming` DISABLE KEYS */;
/*!40000 ALTER TABLE `incoming` ENABLE KEYS */;

-- Dumping structure for table espressolight.nomenclature
CREATE TABLE IF NOT EXISTS `nomenclature` (
                                              `nomenclature_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                              PRIMARY KEY (`nomenclature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.nomenclature: ~0 rows (approximately)
/*!40000 ALTER TABLE `nomenclature` DISABLE KEYS */;
/*!40000 ALTER TABLE `nomenclature` ENABLE KEYS */;

-- Dumping structure for table espressolight.prices
CREATE TABLE IF NOT EXISTS `prices` (
                                        `price_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                        PRIMARY KEY (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.prices: ~0 rows (approximately)
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;

-- Dumping structure for table espressolight.recipes
CREATE TABLE IF NOT EXISTS `recipes` (
                                         `recipe_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                         PRIMARY KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.recipes: ~0 rows (approximately)
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;

-- Dumping structure for table espressolight.roles
CREATE TABLE IF NOT EXISTS `roles` (
                                       `role_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                       `role_name` varchar(250) NOT NULL DEFAULT '',
                                       PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.roles: ~0 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table espressolight.users
CREATE TABLE IF NOT EXISTS `users` (
                                       `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
                                       `account_id` bigint(20) NOT NULL,
                                       `role_id` bigint(20) NOT NULL,
                                       `user_login` varchar(100) NOT NULL,
                                       `user_password` varchar(250) NOT NULL,
                                       `user_first_name` varchar(250) NOT NULL DEFAULT '',
                                       `user_second_name` varchar(250) NOT NULL DEFAULT '',
                                       `user_full_name` varchar(250) NOT NULL DEFAULT '',
                                       `user_email` varchar(250) NOT NULL DEFAULT '',
                                       `user_phone` varchar(250) NOT NULL DEFAULT '',
                                       `user_comment` varchar(250) NOT NULL DEFAULT '',
                                       `user_active` tinyint(4) NOT NULL DEFAULT 0,
                                       `user_create_date` timestamp NOT NULL DEFAULT current_timestamp(),
                                       PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table espressolight.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `account_id`, `role_id`, `user_login`, `user_password`, `user_first_name`, `user_second_name`, `user_full_name`, `user_email`, `user_phone`, `user_comment`, `user_active`, `user_create_date`) VALUES
(1, 0, 0, 'admin', '7d21ce99db191e62f86c1b83da17127911145f2b', 'admin', 'admin', 'admin admin', 'admin@gmail.com', '+38(063)adm-in', '', 1, '2020-03-28 00:07:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
