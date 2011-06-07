DROP DATABASE IF EXISTS `meza`;
CREATE DATABASE `meza`;
use `meza`
DROP TABLE IF EXISTS `tree`;
CREATE TABLE `tree` (
	`name` varchar(200) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
	`lft` int(10) DEFAULT NULL,
	`rht` int(10) DEFAULT NULL,
	PRIMARY KEY (`name`),
	KEY `lft` (`lft`),
	KEY `rht` (`rht`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
CREATE USER 'meza_demo'@'%' IDENTIFIED BY 'meza_demo_pass';
GRANT ALL PRIVILEGES ON `meza`.* TO 'meza_demo'@'%';
FLUSH PRIVILEGES;
INSERT INTO `tree` (`name`, `lft`, `rht`) VALUES('Root', 1, 2);