-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `task` (`id`, `task_group_id`, `name`, `date`, `completed`) VALUES
(1,	1,	'Ukladat zmenu checkboxu, aby se oznacil ukol jako hotovy a zmena se ulozila do databaze',	'2015-07-23',	1),
(2,	1,	'Na checkboxy pouzit knihovnu iCheck (vyuzit bower)',	'2015-07-21',	1),
(3,	1,	'Pridavat nove tasky pomoci ajaxu, aby neprobehl refresh stranky',	'2015-07-21',	1),
(4,	1,	'Radit ukoly podle data, aby nejstarsi byly na konci',	'2015-07-22',	1),
(5,	1,	'Pridat moznost zaradit ukol do kategorie',	'2015-07-23',	1),
(6,	1,	'Filtrovani ukolu podle nazvu',	'2015-07-24',	1);

-- 2015-11-12 23:53:24
