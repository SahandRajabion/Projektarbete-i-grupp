-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Värd: 10.209.1.136
-- Skapad: 16 apr 2015 kl 16:27
-- Serverversion: 5.5.32
-- PHP-version: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `198884-scrollpaging`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `attempts`
--

CREATE TABLE IF NOT EXISTS `attempts` (
  `AttemptID` int(11) NOT NULL AUTO_INCREMENT,
  `AttemptTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IpAddress` varchar(150) NOT NULL,
  `Result` tinyint(1) NOT NULL,
  `Username` varchar(20) NOT NULL,
  PRIMARY KEY (`AttemptID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=183 ;

--
-- Dumpning av Data i tabell `attempts`
--

INSERT INTO `attempts` (`AttemptID`, `AttemptTime`, `IpAddress`, `Result`, `Username`) VALUES
(106, '2015-04-02 08:45:56', '194.47.114.92', 0, 'Admin '),
(107, '2015-04-02 08:46:01', '194.47.114.92', 0, 'Admin '),
(108, '2015-04-02 08:52:45', '194.47.114.92', 1, 'Tommy'),
(109, '2015-04-02 08:55:32', '194.47.114.92', 0, 'Sahib'),
(110, '2015-04-02 08:55:36', '194.47.114.92', 1, 'Sahib'),
(111, '2015-04-02 08:58:25', '194.47.114.92', 1, 'Sahand'),
(112, '2015-04-02 09:02:03', '194.47.114.92', 1, 'Erik'),
(113, '2015-04-02 09:06:58', '194.47.114.92', 1, 'Erik'),
(114, '2015-04-02 09:11:16', '194.47.114.92', 1, 'Erik'),
(115, '2015-04-02 09:12:01', '194.47.114.92', 0, 'Erik'),
(116, '2015-04-02 09:12:07', '194.47.114.92', 1, 'Erik'),
(117, '2015-04-02 09:12:56', '194.47.114.92', 0, 'erik'),
(118, '2015-04-02 09:13:02', '194.47.114.92', 1, 'Erik'),
(119, '2015-04-02 09:14:13', '194.47.114.92', 1, 'Erik'),
(120, '2015-04-02 09:15:15', '194.47.114.92', 1, 'Erik'),
(121, '2015-04-02 09:19:03', '194.47.114.92', 0, 'sahand'),
(122, '2015-04-02 09:19:09', '194.47.114.92', 1, 'Sahand'),
(123, '2015-04-02 09:20:12', '194.47.114.92', 1, 'Tommy'),
(124, '2015-04-02 09:22:37', '194.47.114.92', 1, 'Sahib'),
(125, '2015-04-02 09:25:04', '194.47.114.92', 0, 'Admin'),
(126, '2015-04-02 09:25:15', '194.47.114.92', 1, 'Admin'),
(127, '2015-04-02 09:26:25', '194.47.114.92', 1, 'Admin'),
(128, '2015-04-02 09:28:38', '194.47.114.92', 1, 'Admin'),
(129, '2015-04-02 09:35:13', '194.47.114.92', 1, 'Admin'),
(130, '2015-04-02 09:38:18', '194.47.114.92', 1, 'Admin'),
(131, '2015-04-02 09:38:54', '194.47.114.92', 1, 'Sahib'),
(132, '2015-04-02 09:41:16', '194.47.114.92', 1, 'Sahib'),
(133, '2015-04-02 09:41:32', '194.47.114.92', 1, 'Admin'),
(134, '2015-04-02 09:43:21', '194.47.114.92', 1, 'tss'),
(135, '2015-04-02 09:44:10', '194.47.114.92', 0, 'tss'),
(136, '2015-04-02 09:44:29', '194.47.114.92', 0, 'tss'),
(137, '2015-04-02 09:44:41', '194.47.114.92', 1, 'tss'),
(138, '2015-04-02 09:51:47', '194.47.114.92', 1, 'Admin'),
(139, '2015-04-02 10:09:08', '194.47.115.233', 1, 'Admin'),
(140, '2015-04-02 10:10:58', '194.47.115.233', 1, 'Tommy'),
(141, '2015-04-02 11:35:56', '194.47.114.92', 1, 'Admin'),
(142, '2015-04-02 18:35:42', '85.230.155.27', 1, 'Admin'),
(143, '2015-04-03 14:00:41', '141.0.8.143', 0, 'Sahib ali'),
(144, '2015-04-03 14:00:43', '141.0.8.143', 0, 'Sahib ali'),
(145, '2015-04-03 14:00:46', '141.0.8.143', 0, 'Sahib ali'),
(146, '2015-04-03 20:02:29', '85.224.76.210', 1, 'Admin'),
(147, '2015-04-05 10:54:07', '194.47.104.246', 1, 'Admin'),
(148, '2015-04-08 08:58:36', '85.224.78.213', 1, 'Admin'),
(149, '2015-04-08 15:10:48', '85.224.76.210', 1, 'Admin'),
(150, '2015-04-09 08:36:59', '194.47.114.107', 1, 'Admin'),
(151, '2015-04-09 08:38:00', '194.47.114.209', 1, 'Admin'),
(152, '2015-04-09 12:51:00', '194.47.114.209', 1, 'Admin'),
(153, '2015-04-09 16:27:25', '85.224.78.213', 1, 'Admin'),
(154, '2015-04-10 18:08:50', '85.224.76.210', 1, 'Admin'),
(155, '2015-04-12 15:07:42', '194.47.107.215', 1, 'Admin'),
(156, '2015-04-12 21:42:30', '90.227.169.64', 1, 'Admin'),
(157, '2015-04-13 20:12:43', '127.0.0.1', 0, 'Admin'),
(158, '2015-04-13 20:13:11', '127.0.0.1', 0, 'qqqq'),
(159, '2015-04-13 20:14:19', '127.0.0.1', 1, 'aaaa'),
(160, '2015-04-13 20:19:01', '127.0.0.1', 1, 'aaaa'),
(161, '2015-04-13 20:27:27', '127.0.0.1', 1, 'aaaa'),
(162, '2015-04-13 20:41:38', '127.0.0.1', 1, 'aaaa'),
(163, '2015-04-13 20:52:39', '127.0.0.1', 1, 'Sahib'),
(164, '2015-04-13 21:08:28', '127.0.0.1', 1, 'Sahand'),
(165, '2015-04-13 21:22:37', '127.0.0.1', 1, 'Sahand'),
(166, '2015-04-13 21:25:58', '127.0.0.1', 1, 'Sahand'),
(167, '2015-04-14 16:17:01', '127.0.0.1', 0, 'sahib'),
(168, '2015-04-14 16:17:19', '127.0.0.1', 0, 'sahib'),
(169, '2015-04-14 16:17:44', '127.0.0.1', 0, 'Sahib'),
(170, '2015-04-14 16:18:05', '127.0.0.1', 1, 'Sahib'),
(171, '2015-04-14 16:41:35', '127.0.0.1', 0, 'Sahib'),
(172, '2015-04-14 16:41:54', '127.0.0.1', 1, 'Sahib'),
(173, '2015-04-16 13:59:17', '194.47.114.38', 0, '(Inget anvÃ¤ndarnamn'),
(174, '2015-04-16 13:59:29', '194.47.114.38', 1, 'Sahib'),
(175, '2015-04-16 14:01:09', '194.47.179.159', 0, 'Sahand'),
(176, '2015-04-16 14:01:12', '194.47.179.159', 0, 'Sahand'),
(177, '2015-04-16 14:01:15', '194.47.179.159', 0, 'Sahand'),
(178, '2015-04-16 14:01:19', '194.47.179.159', 0, 'Sahand'),
(179, '2015-04-16 14:01:38', '194.47.179.159', 0, 'hejhej'),
(180, '2015-04-16 14:15:21', '194.47.114.38', 1, 'Sahib'),
(181, '2015-04-16 14:15:49', '194.47.114.194', 1, 'Tommy'),
(182, '2015-04-16 14:22:32', '194.47.114.38', 1, 'Sahib');

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `CommentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(10) NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `PostId` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imgName` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Post` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `imgName` (`imgName`,`code`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=300 ;

--
-- Dumpning av Data i tabell `feed`
--

INSERT INTO `feed` (`id`, `imgName`, `Title`, `Post`, `code`, `Date`, `UserId`) VALUES
(299, NULL, NULL, 'ddssd', NULL, '2015-04-16 14:22:32', 35);

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `Hash` varchar(255) NOT NULL,
  `Role` int(11) NOT NULL DEFAULT '3',
  `passreset` int(11) NOT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Name` (`Username`),
  UNIQUE KEY `email` (`email`),
  KEY `Id` (`UserId`),
  KEY `Id_2` (`UserId`),
  KEY `Id_3` (`UserId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`UserId`, `Username`, `email`, `Hash`, `Role`, `passreset`) VALUES
(34, 'Sahib', 'sahib@hotmail.se', '$2a$10$s.hDkdo8BR0wdvp1JcAXquzJ9hFn9WerpE.HszFjgQD7.eRPp9Tbi', 1, 13916),
(35, 'Tommy', 'tn222eb@student.lnu.se', '$2a$10$ijmvQY7SSF.j7CLZ4vT80.YeduxEvJ5T20M13ZeTX/BEVcQf8xopW', 1, 0),
(36, 'Sahand', 'sr222hn@student.lnu.se', '$2a$10$iqEVr9iEOIADVtNfAwvNXeS29MPwIma06ASrwoEG9KXROnIOSWK1u', 1, 0);

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `dsdsaads` FOREIGN KEY (`id`) REFERENCES `feed` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
