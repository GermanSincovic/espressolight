CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(250) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'no',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `contragents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `incoming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `caid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `amount` varchar(50) NOT NULL DEFAULT '',
  `price` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `nomenclature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `measurement` varchar(15) NOT NULL DEFAULT '',
  `excise` varchar(5) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `price` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `nid` (`nid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `components` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `surname` varchar(50) NOT NULL DEFAULT '',
  `role` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(10) NOT NULL DEFAULT '',
  `login` varchar(50) NOT NULL DEFAULT '',
  `token` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `users` SET `name`='admin', `surname`='admin', `role`='master', `company`='', `login`='admin', `token`='fe613c9795fc44c247558d276a557b486c85d25b';