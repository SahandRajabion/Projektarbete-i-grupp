-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 14 apr 2015 kl 15:53
-- Serverversion: 5.6.15-log
-- PHP-version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `scroll_paging`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

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
(166, '2015-04-13 21:25:58', '127.0.0.1', 1, 'Sahand');

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `CommentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(10) NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `PostId` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`CommentId`, `body`, `date`, `id`) VALUES
(1, 'https://www.youtube.com/watch?v=1XR0Gt_5AA8<br />', '2015-04-12 13:36:56', 86);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `imgName` (`imgName`,`code`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Dumpning av Data i tabell `feed`
--

INSERT INTO `feed` (`id`, `imgName`, `Title`, `Post`, `code`, `Date`) VALUES
(56, NULL, NULL, 'Detta Ã¤r ett vanligt InlÃ¤gg!', NULL, '2015-04-09 20:35:07'),
(57, NULL, NULL, NULL, 'Ia8b9B_EEGk', '2015-04-09 20:35:57'),
(59, 'Penguins.jpg', 'Detta Ã¤r en bild titel !', NULL, NULL, '2015-04-09 20:48:10'),
(60, NULL, NULL, NULL, 'LaeWO9RoKDA', '2015-04-10 14:05:56'),
(61, NULL, NULL, 'sd', NULL, '2015-04-10 19:49:10'),
(62, NULL, NULL, 'sad', NULL, '2015-04-10 19:49:48'),
(63, NULL, NULL, 'asd', NULL, '2015-04-10 19:57:01'),
(64, NULL, NULL, 'asd', NULL, '2015-04-10 19:57:02'),
(65, NULL, NULL, 'ddd', NULL, '2015-04-10 19:57:41'),
(66, NULL, NULL, 'ddd', NULL, '2015-04-10 19:57:41'),
(67, NULL, NULL, 'qq', NULL, '2015-04-10 19:57:46'),
(68, NULL, NULL, 'eeerre', NULL, '2015-04-10 20:03:08'),
(69, NULL, NULL, 'qw', NULL, '2015-04-10 20:03:33'),
(70, NULL, NULL, 'qw', NULL, '2015-04-10 20:03:34'),
(71, NULL, NULL, 'qqq', NULL, '2015-04-10 20:04:00'),
(72, NULL, NULL, 'q', NULL, '2015-04-10 20:06:22'),
(73, NULL, NULL, 'ccc', NULL, '2015-04-10 20:06:52'),
(74, NULL, NULL, 'zzz', NULL, '2015-04-10 20:07:11'),
(75, NULL, NULL, 'aaa', NULL, '2015-04-10 20:07:46'),
(76, NULL, NULL, 'ddd', NULL, '2015-04-10 20:08:15'),
(77, NULL, NULL, 'asd', NULL, '2015-04-10 20:08:55'),
(78, NULL, NULL, 'asdasd', NULL, '2015-04-10 20:09:58'),
(79, '1375166633.jpg', '', NULL, NULL, '2015-04-10 20:10:10'),
(80, NULL, NULL, 'asd', NULL, '2015-04-10 20:11:01'),
(81, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5AA5', NULL, '2015-04-12 13:27:05'),
(82, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5AA5', NULL, '2015-04-12 13:27:06'),
(83, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5BB4', NULL, '2015-04-12 13:27:25'),
(84, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5BB4', NULL, '2015-04-12 13:27:28'),
(85, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5AA8q', NULL, '2015-04-12 13:27:44'),
(86, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5AA8<br />', NULL, '2015-04-12 13:36:30'),
(87, NULL, NULL, 'https://www.youtube.com/watch?v=1XR0Gt_5AA8<br />', NULL, '2015-04-12 13:37:06'),
(88, NULL, NULL, 'https://www.youtube.com<br />/watch?v=1XR0Gt_5AA8<br />', NULL, '2015-04-12 13:38:00'),
(89, NULL, NULL, NULL, '4OfU7CGY5DQ', '2015-04-12 13:38:13'),
(90, NULL, NULL, NULL, 'AKcUdDWIHOI', '2015-04-12 13:44:38'),
(91, NULL, NULL, NULL, 'AKcUdDWIHOI', '2015-04-12 13:44:38'),
(92, NULL, NULL, NULL, 'AKcUdDWIHOI', '2015-04-12 13:46:07'),
(93, NULL, NULL, NULL, 'AKcUdDWIHOI', '2015-04-12 13:46:30'),
(94, NULL, NULL, NULL, 'AKcUdDWIHOI', '2015-04-12 13:47:29');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) NOT NULL,
  `Hash` varchar(255) NOT NULL,
  `Role` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Name` (`Username`),
  KEY `Id` (`UserId`),
  KEY `Id_2` (`UserId`),
  KEY `Id_3` (`UserId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`UserId`, `Username`, `Hash`, `Role`) VALUES
(34, 'Sahib', '$2a$10$rZfoaH.bGfyB7fUMlny1hel7ysgZcKpGpbXdVd0JiVfThQOSgPeBm', 1),
(35, 'Tommy', '$2a$10$ijmvQY7SSF.j7CLZ4vT80.YeduxEvJ5T20M13ZeTX/BEVcQf8xopW', 1),
(36, 'Sahand', '$2a$10$iqEVr9iEOIADVtNfAwvNXeS29MPwIma06ASrwoEG9KXROnIOSWK1u', 1);

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
