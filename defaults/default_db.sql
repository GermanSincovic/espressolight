CREATE DATABASE IF NOT EXISTS `espressolight`;

USE `espressolight`;

CREATE TABLE IF NOT EXISTS `accounts` (`account_id` bigint(20) NOT NULL AUTO_INCREMENT,`owner_id` bigint(20) NOT NULL,`account_name` varchar(250) NOT NULL DEFAULT '',PRIMARY KEY (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `companies` (`company_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`company_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `contragents` (`contragent_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`contragent_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `expenses` (`expense_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`expense_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `incoming` (`incoming_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`incoming_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `nomenclature` (`nomenclature_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`nomenclature_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `prices` (`price_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`price_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `recipes` (`recipe_id` bigint(20) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`recipe_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `roles` (`role_id` bigint(20) NOT NULL AUTO_INCREMENT,`role_name` varchar(250) NOT NULL DEFAULT '',PRIMARY KEY (`role_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (`user_id` bigint(20) NOT NULL AUTO_INCREMENT,`account_id` bigint(20) NOT NULL,`role_id` bigint(20) NOT NULL,`user_first_name` varchar(250) NOT NULL DEFAULT '',`user_second_name` varchar(250) NOT NULL DEFAULT '',`user_full_name` varchar(250) NOT NULL DEFAULT '',`user_email` varchar(250) NOT NULL DEFAULT '',`user_phone` varchar(250) NOT NULL DEFAULT '',`user_comment` varchar(250) NOT NULL DEFAULT '',`user_active` tinyint(4) NOT NULL DEFAULT 0,`user_create_date` timestamp NOT NULL DEFAULT current_timestamp(),PRIMARY KEY (`user_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
