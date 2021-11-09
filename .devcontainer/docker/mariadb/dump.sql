-- Adminer 4.8.1 MySQL 5.5.5-10.6.4-MariaDB-1:10.6.4+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `docker` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci */;
USE `docker`;

DROP TABLE IF EXISTS `reset_codes`;
CREATE TABLE `reset_codes` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `email` varchar(64) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `random_code` (`code`),
  KEY `reset_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` bigint(10) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `first_name` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `middle_name` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_name` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_account_type` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='user data';

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `first_name`, `middle_name`, `last_name`, `user_account_type`, `created`, `modified`) VALUES
(1,	'adminako',	'$2y$10$uosWG2tEWwZIqNyTMtH1COBKY9ZvoslIv7qnutp8FtaM/LLai9f9W',	'johncyrillcorsanes@gmail.com',	'JOHN CYRILL',	'CUMPIO',	'CORSANES',	'admin',	'2021-11-09 05:17:21',	'2021-11-09 05:17:21');

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `type_desc` varchar(300) NOT NULL COMMENT 'Full information about this user type',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `user_types` (`id`, `user_type`, `type_desc`) VALUES
(0,	'admin',	'Administrators'),
(1,	'user',	'Users');

-- 2021-11-09 05:47:24