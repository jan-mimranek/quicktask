-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `quicktask`;
CREATE DATABASE `quicktask` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `quicktask`;

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_527EDB25BE94330B` (`task_group_id`),
  CONSTRAINT `FK_527EDB25BE94330B` FOREIGN KEY (`task_group_id`) REFERENCES `task_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `task` (`id`, `task_group_id`, `name`, `date`, `completed`) VALUES
(1,	1,	'Ukladat zmenu checkboxu, aby se oznacil ukol jako hotovy a zmena se ulozila do databaze',	'2015-07-23',	0),
(2,	1,	'Na checkboxy pouzit knihovnu iCheck (vyuzit bower)',	'2015-07-21',	0),
(3,	1,	'Pridavat nove tasky pomoci ajaxu, aby neprobehl refresh stranky',	'2015-07-21',	0),
(4,	1,	'Radit ukoly podle data, aby nejstarsi byly na konci',	'2015-07-22',	0),
(5,	1,	'Pridat moznost zaradit ukol do kategorie',	'2015-07-23',	0),
(6,	1,	'Filtrovani ukolu podle nazvu',	'2015-07-24',	0);

DROP TABLE IF EXISTS `task_group`;
CREATE TABLE `task_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `task_group` (`id`, `name`) VALUES
(1,	'Zadani');

-- 2015-09-08 11:56:21
