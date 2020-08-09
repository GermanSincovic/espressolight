CREATE DATABASE IF NOT EXISTS `espressolight`;

USE `espressolight`;

CREATE TABLE IF NOT EXISTS `accounts` (
    `account_id`    bigint(20) NOT NULL AUTO_INCREMENT,
    `owner_id`      bigint(20) NOT NULL,
    `account_name`  varchar(250) NOT NULL DEFAULT '',
    PRIMARY KEY (`account_id`)
);

CREATE TABLE IF NOT EXISTS `branches`
(
    `branch_id`      bigint(20)   NOT NULL AUTO_INCREMENT,
    `account_id`     bigint(20)   NOT NULL,
    `branch_name`    varchar(100) NOT NULL,
    `branch_address` varchar(100) NOT NULL,
    PRIMARY KEY (`branch_id`)
);

CREATE TABLE IF NOT EXISTS `contragents` (
    `contragent_id`         bigint(20) NOT NULL AUTO_INCREMENT,
    `account_id`            bigint(20) NOT NULL,
    `contragent_name`       varchar(100) NOT NULL,
    `contragent_comment`    text NOT NULL DEFAULT '',
    PRIMARY KEY (`contragent_id`)
);

CREATE TABLE IF NOT EXISTS `expenses` (
    `expense_id`        bigint(20) NOT NULL AUTO_INCREMENT,
    `nomenclature_id`   bigint(20) NOT NULL,
    `branch_id`         bigint(20) NOT NULL,
    `user_id`           bigint(20) NOT NULL,
    `expense_count`     int(11) NOT NULL,
    `expense_price`     float NOT NULL,
    `expense_datetime`  varchar(50) NOT NULL,
    PRIMARY KEY (`expense_id`)
);

CREATE TABLE IF NOT EXISTS `incoming` (
    `incoming_id`           bigint(20) NOT NULL AUTO_INCREMENT,
    `nomenclature_id`       bigint(20) NOT NULL,
    `branch_id`             bigint(20) NOT NULL,
    `user_id`               bigint(20) NOT NULL,
    `incoming_count`        int(11) NOT NULL,
    `incoming_price`        float NOT NULL,
    `incoming_datetime`     varchar(50) NOT NULL,
    PRIMARY KEY (`incoming_id`)
);

CREATE TABLE IF NOT EXISTS `nomenclature` (
    `nomenclature_id`           bigint(20) NOT NULL AUTO_INCREMENT,
    `account_id`                bigint(20) NOT NULL,
    `nomenclature_name`         varchar(100) NOT NULL,
    `nomenclature_measurement`  varchar(50) NOT NULL,
    `nomenclature_excise`       tinyint(4) NOT NULL,
    PRIMARY KEY (`nomenclature_id`)
);

CREATE TABLE IF NOT EXISTS `prices` (
    `price_id`              bigint(20) NOT NULL AUTO_INCREMENT,
    `account_id`            bigint(20) NOT NULL,
    `nomenclature_id`       bigint(20) NOT NULL,
    `price_amount`          float NOT NULL,
    PRIMARY KEY (`price_id`)
);

CREATE TABLE IF NOT EXISTS `recipes` (
    `recipe_id`             bigint(20) NOT NULL AUTO_INCREMENT,
    `account_id`            bigint(20) NOT NULL,
    `recipe_name`           varchar(100) NOT NULL,
    `recipe_ingredients`    text NOT NULL,
    PRIMARY KEY (`recipe_id`)
);

CREATE TABLE IF NOT EXISTS `roles` (
    `role_id`               bigint(20) NOT NULL AUTO_INCREMENT,
    `account_id`            bigint(20) NOT NULL,
    `role_name`             varchar(250) NOT NULL DEFAULT '',
    `role_access_users`     varchar(5) DEFAULT '--',
    `role_access_accounts`  varchar(5) DEFAULT '--',
    `role_access_branches`  varchar(5) DEFAULT '--',
    PRIMARY KEY (`role_id`)
);

CREATE TABLE IF NOT EXISTS `users` (
    `user_id`               bigint(20) NOT NULL AUTO_INCREMENT,
    `account_id`            bigint(20) NOT NULL,
    `role_id`               bigint(20) NOT NULL,
    `branch_id`             bigint(20) DEFAULT NULL,
    `user_login`            varchar(100) NOT NULL,
    `user_password`         varchar(250) NOT NULL,
    `user_first_name`       varchar(250) NOT NULL,
    `user_second_name`      varchar(250) NOT NULL,
    `user_full_name`        varchar(250) NOT NULL,
    `user_email`            varchar(250) NOT NULL,
    `user_phone`            varchar(250) NOT NULL,
    `user_comment`          text NOT NULL DEFAULT '',
    `user_active`           tinyint(4) NOT NULL DEFAULT 0,
    PRIMARY KEY (`user_id`)
);

CREATE TABLE IF NOT EXISTS `access_rules` (
    `access_rule_id`         bigint NOT NULL AUTO_INCREMENT,
    `access_rule_accounts`     varchar(50) NOT NULL DEFAULT '--',
    `access_rule_companies`    varchar(50) NOT NULL DEFAULT '--',
    `access_rule_contragents`  varchar(50) NOT NULL DEFAULT '--',
    `access_rule_expenses`     varchar(50) NOT NULL DEFAULT '--',
    `access_rule_incoming`     varchar(50) NOT NULL DEFAULT '--',
    `access_rule_nomenclature` varchar(50) NOT NULL DEFAULT '--',
    `access_rule_prices`       varchar(50) NOT NULL DEFAULT '--',
    `access_rule_recipes`      varchar(50) NOT NULL DEFAULT '--',
    `access_rule_roles`        varchar(50) NOT NULL DEFAULT '--',
    `access_rule_users`        varchar(50) NOT NULL DEFAULT '--',
    PRIMARY KEY (`access_rule_id`)
);

INSERT INTO `users` (`user_id`, `account_id`, `role_id`, `branch_id`, `user_login`, `user_password`, `user_first_name`, `user_second_name`, `user_full_name`, `user_email`, `user_phone`, `user_comment`, `user_active`) VALUES
    (1, 0, 0, NULL, 'admin', '7d21ce99db191e62f86c1b83da17127911145f2b', 'admin', 'admin', 'admin admin', 'admin@gmail.com', '+38(063)adm-in', '', 1);