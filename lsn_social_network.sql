-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 29 apr 2015 kl 22:01
-- Serverversion: 5.6.15-log
-- PHP-version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `lsn_social_network`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=254 ;

--
-- Dumpning av Data i tabell `attempts`
--

INSERT INTO `attempts` (`AttemptID`, `AttemptTime`, `IpAddress`, `Result`, `Username`) VALUES
(229, '2015-04-24 20:56:35', '127.0.0.1', 1, 'Tommy'),
(230, '2015-04-26 11:15:52', '127.0.0.1', 0, 'Tommy'),
(231, '2015-04-26 11:15:59', '127.0.0.1', 1, 'Tommy'),
(232, '2015-04-26 11:19:13', '127.0.0.1', 1, 'Tommy'),
(233, '2015-04-26 11:22:13', '127.0.0.1', 1, 'Tommy'),
(234, '2015-04-27 11:37:33', '127.0.0.1', 1, 'Tommy'),
(235, '2015-04-27 11:39:55', '127.0.0.1', 1, 'Asoglu'),
(236, '2015-04-27 11:52:22', '127.0.0.1', 0, 'Tommy'),
(237, '2015-04-27 11:52:25', '127.0.0.1', 1, 'Tommy'),
(238, '2015-04-27 11:52:39', '127.0.0.1', 1, 'Asoglu'),
(239, '2015-04-27 11:54:14', '127.0.0.1', 1, 'Tommy'),
(240, '2015-04-27 11:56:20', '127.0.0.1', 1, 'Asoglu'),
(241, '2015-04-27 16:46:47', '127.0.0.1', 1, 'Tommy'),
(242, '2015-04-27 17:40:49', '127.0.0.1', 1, 'Tommy'),
(243, '2015-04-27 17:44:46', '127.0.0.1', 1, 'Asoglu'),
(244, '2015-04-27 17:44:52', '127.0.0.1', 1, 'Tommy'),
(245, '2015-04-27 19:00:03', '127.0.0.1', 1, 'Tommy'),
(246, '2015-04-27 19:23:19', '127.0.0.1', 0, 'Admin'),
(247, '2015-04-27 19:23:31', '127.0.0.1', 0, 'Admin'),
(248, '2015-04-27 19:23:42', '127.0.0.1', 0, 'Sahib'),
(249, '2015-04-27 19:24:51', '127.0.0.1', 1, 'Sahib'),
(250, '2015-04-27 19:25:18', '127.0.0.1', 1, 'Sahib'),
(251, '2015-04-28 20:58:47', '127.0.0.1', 1, 'Sahib'),
(252, '2015-04-29 16:53:36', '127.0.0.1', 1, 'Sahib'),
(253, '2015-04-29 18:47:23', '127.0.0.1', 1, 'Sahib');

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
  KEY `id` (`id`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `commentscourse`
--

CREATE TABLE IF NOT EXISTS `commentscourse` (
  `CommentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(10) NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `PostId` (`id`),
  KEY `id` (`id`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `CourseId` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  PRIMARY KEY (`CourseId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumpning av Data i tabell `course`
--

INSERT INTO `course` (`CourseId`, `CourseName`, `CourseCode`) VALUES
(3, 'Inledande programmering med C#', '1DV402'),
(4, 'Webbteknik II', '1DV499'),
(5, 'JOJO', '12DVA2'),
(6, 'SS', 'SDAD23');

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
  KEY `id_2` (`id`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=297 ;

--
-- Dumpning av Data i tabell `feed`
--

INSERT INTO `feed` (`id`, `imgName`, `Title`, `Post`, `code`, `Date`, `UserId`) VALUES
(295, NULL, NULL, 'dsds', NULL, '2015-04-27 11:56:13', 37);

-- --------------------------------------------------------

--
-- Tabellstruktur `feedcourse`
--

CREATE TABLE IF NOT EXISTS `feedcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imgName` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Post` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` int(11) NOT NULL,
  `CourseId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `imgName` (`imgName`,`code`),
  KEY `id_2` (`id`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=346 ;

--
-- Dumpning av Data i tabell `feedcourse`
--

INSERT INTO `feedcourse` (`id`, `imgName`, `Title`, `Post`, `code`, `Date`, `UserId`, `CourseId`) VALUES
(343, NULL, NULL, 'a', NULL, '2015-04-29 19:57:06', 39, NULL),
(344, NULL, NULL, 'nu dÃ¥', NULL, '2015-04-29 19:58:10', 39, NULL),
(345, NULL, NULL, 'nu fan', NULL, '2015-04-29 19:58:40', 39, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `img`
--

CREATE TABLE IF NOT EXISTS `img` (
  `imgId` int(11) NOT NULL AUTO_INCREMENT,
  `imgName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`imgId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `imgcourse`
--

CREATE TABLE IF NOT EXISTS `imgcourse` (
  `imgId` int(11) NOT NULL AUTO_INCREMENT,
  `imgName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`imgId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `ProgramId` int(11) NOT NULL AUTO_INCREMENT,
  `ProgramName` varchar(100) NOT NULL,
  PRIMARY KEY (`ProgramId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `program`
--

INSERT INTO `program` (`ProgramId`, `ProgramName`) VALUES
(1, 'Webbprogrammerare'),
(2, 'Utvecklare av digitala tjänster'),
(3, 'Interaktionsdesigner');

-- --------------------------------------------------------

--
-- Tabellstruktur `programcourse`
--

CREATE TABLE IF NOT EXISTS `programcourse` (
  `ProgramCourseId` int(11) NOT NULL AUTO_INCREMENT,
  `ProgramId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  PRIMARY KEY (`ProgramCourseId`),
  KEY `CourseId` (`CourseId`),
  KEY `ProgramId` (`ProgramId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `programcourse`
--

INSERT INTO `programcourse` (`ProgramCourseId`, `ProgramId`, `CourseId`) VALUES
(1, 1, 3),
(2, 2, 3),
(3, 1, 4),
(4, 2, 5),
(5, 1, 6);

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
  `imgName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Name` (`Username`),
  UNIQUE KEY `email` (`email`),
  KEY `Id` (`UserId`),
  KEY `Id_2` (`UserId`),
  KEY `Id_3` (`UserId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`UserId`, `Username`, `email`, `Hash`, `Role`, `passreset`, `imgName`) VALUES
(37, 'Tommy', 'tn222eb@student.lnu.se', '$2a$10$yAWlJc1O1Afw.OzqHRvege3No/vPsPQiAGD6QXctK9ThN02S.EaEq', 1, 0, '20150408_101646.jpg'),
(38, 'Asoglu', 'asoglu@hotmail.com', '$2a$10$d/FkM6YjVwh9bLaapb90zuOSh9qnfJRk.rPdqti6akCwF3R5TBueS', 3, 0, NULL),
(39, 'Sahib', 'sahib@hotmail.se', '$2a$10$sGGdcsAVtsQGnN5f410ZYe4sB9AEHFGQdO9wrWb9OfNGwLeBtLAwq', 1, 0, 'img/default.jpg');

-- --------------------------------------------------------

--
-- Tabellstruktur `userdetails`
--

CREATE TABLE IF NOT EXISTS `userdetails` (
  `userDetailid` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `birthday` date DEFAULT NULL,
  `schoolForm` varchar(50) NOT NULL,
  `ProgramId` int(11) NOT NULL,
  PRIMARY KEY (`userDetailid`),
  KEY `UserId` (`UserId`),
  KEY `ProgramId` (`ProgramId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumpning av Data i tabell `userdetails`
--

INSERT INTO `userdetails` (`userDetailid`, `UserId`, `firstname`, `lastname`, `sex`, `birthday`, `schoolForm`, `ProgramId`) VALUES
(34, 37, 'Tom', 'Nguyen', 'Man', '1994-06-13', 'Campus', 2),
(35, 38, 'Asoglu', 'Abdi', 'Man', '0000-00-00', 'Campus', 2),
(36, 39, 'Sahib', 'Sahib', 'Man', '1990-08-05', 'Campus', 2);

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dsdsaads` FOREIGN KEY (`id`) REFERENCES `feed` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `feed_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `programcourse`
--
ALTER TABLE `programcourse`
  ADD CONSTRAINT `programcourse_ibfk_1` FOREIGN KEY (`ProgramId`) REFERENCES `program` (`ProgramId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `programcourse_ibfk_2` FOREIGN KEY (`CourseId`) REFERENCES `course` (`CourseId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restriktioner för tabell `userdetails`
--
ALTER TABLE `userdetails`
  ADD CONSTRAINT `userdetails_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userdetails_ibfk_2` FOREIGN KEY (`ProgramId`) REFERENCES `program` (`ProgramId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
