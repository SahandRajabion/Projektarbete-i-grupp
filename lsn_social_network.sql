-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 08 maj 2015 kl 00:32
-- Serverversion: 5.6.15-log
-- PHP-version: 5.5.8

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=352 ;

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
(242, '2015-04-27 17:41:34', '127.0.0.1', 1, 'ssss'),
(243, '2015-04-27 18:13:07', '127.0.0.1', 1, 'ssss'),
(244, '2015-04-27 18:28:16', '127.0.0.1', 1, 'ssss'),
(245, '2015-04-27 18:34:41', '127.0.0.1', 1, 'ssss'),
(246, '2015-04-27 18:38:40', '127.0.0.1', 1, 'ssss'),
(247, '2015-04-27 20:07:16', '127.0.0.1', 0, 'tommy'),
(248, '2015-04-27 20:08:18', '127.0.0.1', 0, 'tommy'),
(249, '2015-04-27 20:08:26', '127.0.0.1', 0, 'tommy'),
(250, '2015-04-27 20:09:04', '127.0.0.1', 1, 'ssss'),
(251, '2015-04-27 20:14:48', '127.0.0.1', 1, 'ssss'),
(252, '2015-04-27 20:45:48', '127.0.0.1', 1, 'ssss'),
(253, '2015-04-28 13:17:04', '127.0.0.1', 1, 'ssss'),
(254, '2015-04-28 13:17:22', '127.0.0.1', 1, 'ssss'),
(255, '2015-04-28 13:26:00', '127.0.0.1', 1, 'ssss'),
(256, '2015-04-28 13:33:19', '127.0.0.1', 1, 'ssss'),
(257, '2015-04-28 16:35:43', '127.0.0.1', 1, 'ssss'),
(258, '2015-04-28 17:12:41', '127.0.0.1', 1, 'ssss'),
(259, '2015-04-28 17:17:43', '127.0.0.1', 1, 'ssss'),
(260, '2015-04-28 17:23:39', '127.0.0.1', 1, 'ssss'),
(261, '2015-04-28 17:23:52', '127.0.0.1', 1, 'ssss'),
(262, '2015-04-28 17:25:22', '127.0.0.1', 1, 'ssss'),
(263, '2015-04-29 22:59:53', '127.0.0.1', 1, 'Tommy'),
(264, '2015-04-30 05:28:53', '85.226.121.140', 1, 'Tommy'),
(265, '2015-04-30 07:23:28', '194.47.173.94', 1, 'sss'),
(266, '2015-04-30 07:24:57', '194.47.173.94', 1, 'Tommy'),
(267, '2015-04-30 07:25:54', '194.47.173.94', 1, 'Tommy'),
(268, '2015-04-30 07:26:23', '194.47.173.94', 0, 'hejhejhej'),
(269, '2015-04-30 07:26:31', '194.47.173.94', 1, 'Sahib'),
(270, '2015-04-30 07:28:30', '194.47.173.94', 1, 'Tommy'),
(271, '2015-04-30 08:04:47', '127.0.0.1', 1, 'Tommy'),
(272, '2015-04-30 12:25:20', '127.0.0.1', 1, 'Tommy'),
(273, '2015-04-30 12:33:47', '127.0.0.1', 1, 'Tommy'),
(274, '2015-04-30 12:36:57', '127.0.0.1', 1, 'Tommy'),
(275, '2015-04-30 12:39:15', '127.0.0.1', 1, 'Tommy'),
(276, '2015-04-30 13:57:05', '127.0.0.1', 1, 'Tommy'),
(277, '2015-04-30 14:01:55', '127.0.0.1', 1, 'Tommy'),
(278, '2015-04-30 14:07:14', '127.0.0.1', 1, 'Tommy'),
(279, '2015-04-30 14:10:14', '127.0.0.1', 1, 'Tommy'),
(280, '2015-04-30 15:36:01', '127.0.0.1', 1, 'Tommy'),
(281, '2015-04-30 15:41:13', '127.0.0.1', 1, 'Tommy'),
(282, '2015-04-30 15:43:42', '127.0.0.1', 1, 'Tommy'),
(283, '2015-04-30 15:46:41', '127.0.0.1', 1, 'Tommy'),
(284, '2015-04-30 16:24:51', '127.0.0.1', 1, 'Tommy'),
(285, '2015-04-30 16:37:32', '127.0.0.1', 1, 'Tommy'),
(286, '2015-04-30 16:41:06', '127.0.0.1', 1, 'Tommy'),
(287, '2015-04-30 16:45:54', '127.0.0.1', 1, 'Tommy'),
(288, '2015-04-30 16:50:57', '127.0.0.1', 1, 'Tommy'),
(289, '2015-04-30 16:52:32', '127.0.0.1', 1, 'Tommy'),
(290, '2015-04-30 16:53:45', '127.0.0.1', 1, 'Tommy'),
(291, '2015-04-30 16:54:31', '127.0.0.1', 1, 'Tommy'),
(292, '2015-04-30 16:56:53', '127.0.0.1', 1, 'Tommy'),
(293, '2015-04-30 16:59:20', '127.0.0.1', 1, 'Tommy'),
(294, '2015-04-30 17:33:00', '127.0.0.1', 1, 'Tommy'),
(295, '2015-04-30 17:45:41', '127.0.0.1', 1, 'Tommy'),
(296, '2015-05-05 22:29:22', '127.0.0.1', 1, 'Tommy'),
(297, '2015-05-05 23:53:00', '127.0.0.1', 1, 'Sahib'),
(298, '2015-05-06 00:32:36', '127.0.0.1', 1, 'Sahib'),
(299, '2015-05-06 00:33:10', '127.0.0.1', 1, 'Tommy'),
(300, '2015-05-06 00:33:36', '127.0.0.1', 1, 'Sahib'),
(301, '2015-05-06 00:38:50', '127.0.0.1', 1, 'Tommy'),
(302, '2015-05-06 00:43:07', '127.0.0.1', 0, 'Tommy'),
(303, '2015-05-06 00:43:11', '127.0.0.1', 0, 'Tommy'),
(304, '2015-05-06 00:43:18', '127.0.0.1', 1, 'Tommy'),
(305, '2015-05-06 00:44:05', '127.0.0.1', 1, 'Sahib'),
(306, '2015-05-06 01:57:25', '127.0.0.1', 1, 'Tommy'),
(307, '2015-05-06 02:07:47', '127.0.0.1', 1, 'Sahib'),
(308, '2015-05-06 02:10:48', '127.0.0.1', 1, 'Tommy'),
(309, '2015-05-06 02:11:21', '127.0.0.1', 1, 'Sahib'),
(310, '2015-05-06 02:13:05', '127.0.0.1', 1, 'Tommy'),
(311, '2015-05-06 02:13:38', '127.0.0.1', 1, 'Sahib'),
(312, '2015-05-06 02:25:38', '127.0.0.1', 1, 'Sahib'),
(313, '2015-05-06 02:25:58', '127.0.0.1', 1, 'Tommy'),
(314, '2015-05-06 02:27:11', '127.0.0.1', 1, 'Sahib'),
(315, '2015-05-06 02:29:13', '127.0.0.1', 1, 'Tommy'),
(316, '2015-05-06 02:35:50', '127.0.0.1', 1, 'Sahib'),
(317, '2015-05-06 02:46:27', '127.0.0.1', 1, 'Tommy'),
(318, '2015-05-06 02:49:10', '127.0.0.1', 1, 'Sahib'),
(319, '2015-05-06 02:53:36', '127.0.0.1', 1, 'Tommy'),
(320, '2015-05-06 03:05:44', '127.0.0.1', 1, 'Tommy'),
(321, '2015-05-06 03:05:59', '127.0.0.1', 1, 'Sahib'),
(322, '2015-05-06 03:09:10', '127.0.0.1', 1, 'Sahib'),
(323, '2015-05-06 03:09:34', '127.0.0.1', 1, 'Tommy'),
(324, '2015-05-06 03:10:25', '127.0.0.1', 1, 'Sahib'),
(325, '2015-05-06 20:31:46', '127.0.0.1', 1, 'Sahib'),
(326, '2015-05-06 20:33:08', '127.0.0.1', 1, 'Tommy'),
(327, '2015-05-06 20:34:27', '127.0.0.1', 1, 'Sahib'),
(328, '2015-05-06 20:37:31', '127.0.0.1', 1, 'Tommy'),
(329, '2015-05-06 20:38:55', '127.0.0.1', 1, 'Sahib'),
(330, '2015-05-06 20:43:32', '127.0.0.1', 0, 'Tommy'),
(331, '2015-05-06 20:43:38', '127.0.0.1', 1, 'Tommy'),
(332, '2015-05-06 21:18:58', '127.0.0.1', 1, 'Sahib'),
(333, '2015-05-06 21:28:51', '127.0.0.1', 1, 'Tommy'),
(334, '2015-05-06 21:31:48', '127.0.0.1', 1, 'Sahib'),
(335, '2015-05-06 21:38:56', '127.0.0.1', 0, 'Tommy'),
(336, '2015-05-06 21:39:03', '127.0.0.1', 1, 'Tommy'),
(337, '2015-05-07 10:21:11', '127.0.0.1', 1, 'Sahib'),
(338, '2015-05-07 10:27:47', '127.0.0.1', 0, 'Tommy'),
(339, '2015-05-07 10:27:52', '127.0.0.1', 1, 'Tommy'),
(340, '2015-05-07 12:37:26', '127.0.0.1', 1, 'Sahib'),
(341, '2015-05-07 12:58:37', '127.0.0.1', 1, 'Asoglu'),
(342, '2015-05-07 13:19:55', '127.0.0.1', 1, 'Sahib'),
(343, '2015-05-07 13:57:03', '127.0.0.1', 1, 'Sahib'),
(344, '2015-05-07 13:57:25', '127.0.0.1', 1, 'Tommy'),
(345, '2015-05-07 14:09:42', '127.0.0.1', 1, 'Sahib'),
(346, '2015-05-07 14:16:46', '127.0.0.1', 1, 'Tommy'),
(347, '2015-05-07 15:44:36', '127.0.0.1', 1, 'Sahib'),
(348, '2015-05-07 20:52:07', '127.0.0.1', 1, 'Sahib'),
(349, '2015-05-07 20:56:30', '127.0.0.1', 1, 'Sahib'),
(350, '2015-05-07 21:00:43', '127.0.0.1', 1, 'Sahib'),
(351, '2015-05-07 21:06:18', '127.0.0.1', 1, 'Sahib');

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
  `CourseId` int(11) DEFAULT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `PostId` (`id`),
  KEY `id` (`id`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`CommentId`, `body`, `date`, `id`, `UserId`, `CourseId`) VALUES
(18, 'dssd', '2015-04-30 15:07:50', 314, 37, 1),
(20, 'dssd', '2015-04-30 15:12:39', 316, 37, 1),
(21, 'dsds', '2015-04-30 15:12:45', 314, 37, 1),
(37, 'Kommentar 1', '2015-04-30 15:32:07', 333, 37, 22),
(38, 'Kommentar 2', '2015-04-30 15:32:12', 333, 37, 22),
(39, 'Kommentar 3', '2015-04-30 15:32:20', 337, 37, 22),
(40, 'Kommentar 4', '2015-04-30 15:32:34', 333, 37, 22),
(43, 'Kommentar 10', '2015-04-30 15:46:55', 337, 37, 22),
(44, 'Kommentar 11', '2015-04-30 15:46:59', 337, 37, 22),
(45, 'Kommentar 12', '2015-04-30 15:47:05', 337, 37, 22),
(48, 'Tja', '2015-04-30 16:46:52', 334, 37, 22),
(49, 'Fuaa', '2015-04-30 16:47:04', 334, 37, 22),
(55, 'hej', '2015-04-30 17:11:51', 334, 37, 22),
(62, 'fuaa', '2015-04-30 17:25:34', 338, 37, 22),
(63, 'hej', '2015-04-30 17:26:58', 333, 37, 22),
(64, 'hejsan', '2015-04-30 17:35:39', 338, 37, 22);

-- --------------------------------------------------------

--
-- Tabellstruktur `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `CourseId` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `RssUrl` varchar(255) NOT NULL,
  PRIMARY KEY (`CourseId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumpning av Data i tabell `course`
--

INSERT INTO `course` (`CourseId`, `CourseName`, `CourseCode`, `RssUrl`) VALUES
(1, 'Allmänt', '', ''),
(22, 'fsdfl', 'fsdfld', ''),
(23, 'sasda', 'sadsad', 'http://coursepress.lnu.se/kurs/objektorienterad-programmering-med-cplusplus/feed');

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
  `CourseId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `imgName` (`imgName`,`code`),
  KEY `id_2` (`id`),
  KEY `UserId` (`UserId`),
  KEY `CourseId` (`CourseId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=343 ;

--
-- Dumpning av Data i tabell `feed`
--

INSERT INTO `feed` (`id`, `imgName`, `Title`, `Post`, `code`, `Date`, `UserId`, `CourseId`) VALUES
(314, NULL, NULL, 'dsds', NULL, '2015-04-30 14:29:37', 37, 1),
(316, NULL, NULL, 'dssdÃ¤Ã¤', NULL, '2015-04-30 15:10:07', 37, 1),
(333, NULL, NULL, 'Test 1', NULL, '2015-04-30 15:30:07', 37, 22),
(334, NULL, NULL, 'Test 2', NULL, '2015-04-30 15:30:10', 37, 22),
(335, NULL, NULL, 'Test 3<br />', NULL, '2015-04-30 15:30:14', 37, 22),
(336, NULL, NULL, 'Test 4', NULL, '2015-04-30 15:30:16', 37, 22),
(337, NULL, NULL, 'Test 5', NULL, '2015-04-30 15:30:21', 37, 22),
(338, NULL, NULL, 'dssd', NULL, '2015-04-30 17:01:02', 37, 22),
(342, NULL, NULL, 'hej ', NULL, '2015-05-06 00:32:59', 40, 22);

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
-- Tabellstruktur `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `MsgId` int(11) NOT NULL AUTO_INCREMENT,
  `FromName` varchar(32) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Date` varchar(32) NOT NULL,
  `Time` int(11) NOT NULL,
  `Messages` text NOT NULL,
  `Open` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `NEWMSGID` int(11) DEFAULT NULL,
  PRIMARY KEY (`MsgId`),
  KEY `MsgId` (`MsgId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `ProgramId` int(11) NOT NULL AUTO_INCREMENT,
  `ProgramName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumpning av Data i tabell `programcourse`
--

INSERT INTO `programcourse` (`ProgramCourseId`, `ProgramId`, `CourseId`) VALUES
(24, 2, 22),
(25, 2, 23);

-- --------------------------------------------------------

--
-- Tabellstruktur `spcmsg`
--

CREATE TABLE IF NOT EXISTS `spcmsg` (
  `SPCMSGID` int(11) NOT NULL AUTO_INCREMENT,
  `MSGID` int(11) NOT NULL,
  `MESSAGE` text NOT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `TIME` int(11) DEFAULT NULL,
  `DATE` varchar(32) DEFAULT NULL,
  `NEWMSGID` int(11) DEFAULT NULL,
  PRIMARY KEY (`SPCMSGID`),
  KEY `MSGID` (`MSGID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Name` (`Username`),
  UNIQUE KEY `email` (`email`),
  KEY `Id` (`UserId`),
  KEY `Id_2` (`UserId`),
  KEY `Id_3` (`UserId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`UserId`, `Username`, `email`, `Hash`, `Role`, `passreset`, `imgName`, `date`) VALUES
(37, 'Tommy', 'tn222eb@student.lnu.se', '$2a$10$yAWlJc1O1Afw.OzqHRvege3No/vPsPQiAGD6QXctK9ThN02S.EaEq', 1, 713847, '20150408_101646.jpg', '2015-04-30 00:41:35'),
(38, 'Asoglu', 'asoglu@hotmail.com', '$2a$10$d/FkM6YjVwh9bLaapb90zuOSh9qnfJRk.rPdqti6akCwF3R5TBueS', 3, 0, NULL, NULL),
(39, 'ssss', 'sahandsdsdd@hotmail.com', '$2a$10$19pBtKlQu2TVLEMmISkpDexYqbYQqWW0CITrx1dHAhV4mPa0wLhxS', 1, 0, NULL, NULL),
(40, 'Sahib', 'sahib@hotmail.se', '$2a$10$4/BfdHHdF3tT9X364LT9.Os2I5wtNtcRp39g5n6FR2nSDJNJviaYO', 1, 962622, NULL, '2015-04-30 00:17:47'),
(41, 'sss', 'saj@hotmail.com', '$2a$10$kpS3ODI0btKFcQQjhHJqOuN8t6qm60g/ZE.AGerJGUQzw74scF1xW', 3, 0, NULL, '2015-04-30 07:23:25');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumpning av Data i tabell `userdetails`
--

INSERT INTO `userdetails` (`userDetailid`, `UserId`, `firstname`, `lastname`, `sex`, `birthday`, `schoolForm`, `ProgramId`) VALUES
(34, 37, 'Tommy', 'Nguyen', 'Man', '1994-06-13', 'Campus', 2),
(35, 38, 'Asoglu', 'Abdi', 'Man', '0000-00-00', 'Campus', 2),
(36, 39, 'ssss', 'ssss', 'Man', '1992-05-12', 'Campus', 2),
(37, 40, 'Sahib', 'Sahib', 'Man', '1990-08-05', 'Campus', 2),
(38, 41, 'sds', 'dfsfd', 'Man', '1992-12-02', 'Campus', 2);

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
  ADD CONSTRAINT `feed_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feed_ibfk_2` FOREIGN KEY (`CourseId`) REFERENCES `course` (`CourseId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `programcourse`
--
ALTER TABLE `programcourse`
  ADD CONSTRAINT `programcourse_ibfk_1` FOREIGN KEY (`ProgramId`) REFERENCES `program` (`ProgramId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `programcourse_ibfk_2` FOREIGN KEY (`CourseId`) REFERENCES `course` (`CourseId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `spcmsg`
--
ALTER TABLE `spcmsg`
  ADD CONSTRAINT `spcmsg_ibfk_1` FOREIGN KEY (`MSGID`) REFERENCES `messages` (`MsgId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restriktioner för tabell `userdetails`
--
ALTER TABLE `userdetails`
  ADD CONSTRAINT `userdetails_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userdetails_ibfk_2` FOREIGN KEY (`ProgramId`) REFERENCES `program` (`ProgramId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
