-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 24 apr 2015 kl 22:51
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=229 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=294 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

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
  `institute` varchar(50) NOT NULL,
  PRIMARY KEY (`userDetailid`),
  KEY `UserId` (`UserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
