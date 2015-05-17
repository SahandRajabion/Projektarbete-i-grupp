-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 17 maj 2015 kl 22:30
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=467 ;

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
(351, '2015-05-07 21:06:18', '127.0.0.1', 1, 'Sahib'),
(352, '2015-05-07 21:21:32', '127.0.0.1', 1, 'Sahib'),
(353, '2015-05-07 21:30:27', '127.0.0.1', 1, 'Tommy'),
(354, '2015-05-08 09:28:37', '127.0.0.1', 1, 'Sahib'),
(355, '2015-05-08 10:19:16', '127.0.0.1', 1, 'Sahib'),
(356, '2015-05-08 10:19:36', '127.0.0.1', 1, 'Tommy'),
(357, '2015-05-08 10:21:44', '127.0.0.1', 1, 'Sahib'),
(358, '2015-05-08 10:22:26', '127.0.0.1', 1, 'Tommy'),
(359, '2015-05-08 10:59:21', '127.0.0.1', 1, 'Sahib'),
(360, '2015-05-08 11:00:08', '127.0.0.1', 0, 'Tommy'),
(361, '2015-05-08 11:00:12', '127.0.0.1', 1, 'Tommy'),
(362, '2015-05-12 01:18:51', '127.0.0.1', 1, 'Sahib'),
(363, '2015-05-12 01:19:54', '127.0.0.1', 1, 'Tommy'),
(364, '2015-05-12 02:34:39', '127.0.0.1', 1, 'Sahib'),
(365, '2015-05-12 02:37:12', '127.0.0.1', 1, 'Tommy'),
(366, '2015-05-12 10:50:07', '127.0.0.1', 1, 'Sahib'),
(367, '2015-05-12 11:47:07', '127.0.0.1', 0, 'CoursePressDefault'),
(368, '2015-05-12 11:47:14', '127.0.0.1', 1, 'CoursePressDefault'),
(369, '2015-05-12 11:48:20', '127.0.0.1', 1, 'Sahib'),
(370, '2015-05-12 12:07:55', '127.0.0.1', 1, 'CoursePressDefault'),
(371, '2015-05-12 13:04:35', '127.0.0.1', 1, 'Sahib'),
(372, '2015-05-12 16:11:34', '127.0.0.1', 0, 'CoursePressDefault'),
(373, '2015-05-12 16:11:40', '127.0.0.1', 1, 'CoursePressDefault'),
(374, '2015-05-12 17:11:57', '127.0.0.1', 1, 'Sahib'),
(375, '2015-05-13 14:11:14', '127.0.0.1', 1, 'Sahib'),
(376, '2015-05-13 15:34:28', '127.0.0.1', 1, 'Sahib'),
(377, '2015-05-13 19:10:12', '127.0.0.1', 1, 'Sahib'),
(378, '2015-05-13 21:15:52', '127.0.0.1', 1, 'Sahib'),
(379, '2015-05-13 21:48:13', '127.0.0.1', 1, 'Sahib'),
(380, '2015-05-13 21:48:34', '127.0.0.1', 1, 'Sahib'),
(381, '2015-05-13 21:50:54', '127.0.0.1', 1, 'Sahib'),
(382, '2015-05-13 21:58:09', '127.0.0.1', 0, 'Sahib'),
(383, '2015-05-13 21:58:14', '127.0.0.1', 0, 'Sahib'),
(384, '2015-05-13 21:58:19', '127.0.0.1', 1, 'Sahib'),
(385, '2015-05-13 21:58:30', '127.0.0.1', 0, 'Sahib'),
(386, '2015-05-13 21:58:35', '127.0.0.1', 1, 'Sahib'),
(387, '2015-05-13 21:58:57', '127.0.0.1', 1, 'Sahib'),
(388, '2015-05-13 21:59:58', '127.0.0.1', 1, 'ahmed'),
(389, '2015-05-13 22:09:05', '127.0.0.1', 0, 'yousif'),
(390, '2015-05-13 22:09:09', '127.0.0.1', 1, 'yousif'),
(391, '2015-05-13 22:09:24', '127.0.0.1', 0, 'Sahib'),
(392, '2015-05-13 22:09:29', '127.0.0.1', 1, 'Sahib'),
(393, '2015-05-13 22:19:50', '127.0.0.1', 0, 'Sahib'),
(394, '2015-05-13 22:19:55', '127.0.0.1', 1, 'Sahib'),
(395, '2015-05-13 22:37:27', '127.0.0.1', 0, 'Sahib'),
(396, '2015-05-13 22:37:32', '127.0.0.1', 1, 'Sahib'),
(397, '2015-05-13 22:40:24', '127.0.0.1', 1, 'Sahib'),
(398, '2015-05-13 23:15:30', '127.0.0.1', 1, 'Sahib'),
(399, '2015-05-13 23:57:11', '127.0.0.1', 0, 'Sahib'),
(400, '2015-05-13 23:57:16', '127.0.0.1', 0, 'Sahib'),
(401, '2015-05-13 23:57:24', '127.0.0.1', 1, 'Sahib'),
(402, '2015-05-14 00:26:02', '127.0.0.1', 0, 'Sahib'),
(403, '2015-05-14 00:26:07', '127.0.0.1', 1, 'Sahib'),
(404, '2015-05-14 01:00:44', '127.0.0.1', 1, 'Sahib'),
(405, '2015-05-14 01:19:03', '127.0.0.1', 1, 'Tommy'),
(406, '2015-05-14 01:19:42', '127.0.0.1', 1, 'Sahib'),
(407, '2015-05-14 16:31:35', '127.0.0.1', 0, 'Sahib'),
(408, '2015-05-14 16:31:39', '127.0.0.1', 1, 'Sahib'),
(409, '2015-05-14 19:14:00', '127.0.0.1', 1, 'Sahib'),
(410, '2015-05-14 21:43:07', '127.0.0.1', 0, 'Sahib'),
(411, '2015-05-14 21:43:10', '127.0.0.1', 0, 'Sahib'),
(412, '2015-05-14 21:43:13', '127.0.0.1', 1, 'Sahib'),
(413, '2015-05-14 21:48:55', '127.0.0.1', 1, 'Sahib'),
(414, '2015-05-14 22:19:02', '127.0.0.1', 1, 'Sahib'),
(415, '2015-05-14 22:21:38', '127.0.0.1', 1, 'Sahib'),
(416, '2015-05-14 22:47:18', '127.0.0.1', 1, 'Sahib'),
(417, '2015-05-14 23:09:00', '127.0.0.1', 1, 'Sahib'),
(418, '2015-05-14 23:10:00', '127.0.0.1', 1, 'test4'),
(419, '2015-05-14 23:10:42', '127.0.0.1', 1, 'Sahib'),
(420, '2015-05-15 10:28:45', '127.0.0.1', 1, 'Sahib'),
(421, '2015-05-15 11:11:33', '127.0.0.1', 1, 'Sahib'),
(422, '2015-05-15 20:18:20', '127.0.0.1', 1, 'Sahib'),
(423, '2015-05-15 20:32:41', '127.0.0.1', 1, 'Sahib'),
(424, '2015-05-15 21:28:16', '127.0.0.1', 1, 'Sahib'),
(425, '2015-05-15 21:49:10', '127.0.0.1', 1, 'Sahib'),
(426, '2015-05-15 21:50:54', '127.0.0.1', 1, 'Sahib'),
(427, '2015-05-15 21:58:13', '127.0.0.1', 1, 'Sahib'),
(428, '2015-05-15 22:25:39', '127.0.0.1', 1, 'Sahib'),
(429, '2015-05-15 22:27:35', '127.0.0.1', 1, 'Sahib'),
(430, '2015-05-15 22:28:26', '127.0.0.1', 1, 'Sahib'),
(431, '2015-05-15 23:13:23', '127.0.0.1', 1, 'Sahib'),
(432, '2015-05-16 17:07:43', '127.0.0.1', 1, 'Sahib'),
(433, '2015-05-16 21:31:17', '127.0.0.1', 1, 'Sahib'),
(434, '2015-05-16 21:55:34', '127.0.0.1', 1, 'yousif'),
(435, '2015-05-16 22:22:44', '127.0.0.1', 1, 'Sahib'),
(436, '2015-05-16 22:36:31', '127.0.0.1', 1, 'Sahib'),
(437, '2015-05-17 00:29:29', '127.0.0.1', 1, 'Sahib'),
(438, '2015-05-17 00:35:32', '127.0.0.1', 1, 'Sahib'),
(439, '2015-05-17 00:38:49', '127.0.0.1', 1, 'Sahib'),
(440, '2015-05-17 00:57:45', '127.0.0.1', 1, 'Sahib'),
(441, '2015-05-17 00:59:00', '127.0.0.1', 1, 'Sahib'),
(442, '2015-05-17 01:21:17', '127.0.0.1', 1, 'Sahib'),
(443, '2015-05-17 01:28:03', '127.0.0.1', 1, 'Sahib'),
(444, '2015-05-17 13:23:55', '127.0.0.1', 1, 'Sahib'),
(445, '2015-05-17 13:24:22', '127.0.0.1', 1, 'Tommy'),
(446, '2015-05-17 13:48:08', '127.0.0.1', 1, 'Sahib'),
(447, '2015-05-17 13:49:22', '127.0.0.1', 1, 'Tommy'),
(448, '2015-05-17 13:51:54', '127.0.0.1', 1, 'Sahib'),
(449, '2015-05-17 14:04:13', '127.0.0.1', 1, 'yousif'),
(450, '2015-05-17 14:05:24', '127.0.0.1', 1, 'Sahib'),
(451, '2015-05-17 14:06:41', '127.0.0.1', 1, 'Sahib'),
(452, '2015-05-17 14:21:34', '127.0.0.1', 1, 'Tommy'),
(453, '2015-05-17 14:34:34', '127.0.0.1', 1, 'Sahib'),
(454, '2015-05-17 14:38:45', '127.0.0.1', 1, 'Tommy'),
(455, '2015-05-17 14:47:14', '127.0.0.1', 1, 'Tommy'),
(456, '2015-05-17 14:50:03', '127.0.0.1', 1, 'Tommy'),
(457, '2015-05-17 14:54:21', '127.0.0.1', 1, 'Sahib'),
(458, '2015-05-17 17:44:48', '127.0.0.1', 1, 'Tommy'),
(459, '2015-05-17 18:04:35', '127.0.0.1', 1, 'Sahib'),
(460, '2015-05-17 18:16:41', '127.0.0.1', 1, 'yousif'),
(461, '2015-05-17 18:36:58', '127.0.0.1', 1, 'Sahib'),
(462, '2015-05-17 18:47:37', '127.0.0.1', 1, 'Sahib'),
(463, '2015-05-17 18:56:28', '127.0.0.1', 1, 'Sahib'),
(464, '2015-05-17 20:27:37', '127.0.0.1', 1, 'yousif'),
(465, '2015-05-17 20:27:50', '127.0.0.1', 0, 'Sahib'),
(466, '2015-05-17 20:27:57', '127.0.0.1', 1, 'Sahib');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=83 ;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`CommentId`, `body`, `date`, `id`, `UserId`, `CourseId`) VALUES
(1, 'ss', '2015-05-14 16:05:42', 746, 40, 1),
(2, 'asdaa', '2015-05-14 16:05:52', 746, 40, 1),
(3, '1', '2015-05-16 17:08:11', 768, 40, 23),
(4, '2', '2015-05-16 17:08:17', 768, 40, 23),
(5, 'w', '2015-05-16 17:08:28', 768, 40, 23),
(6, 'dq', '2015-05-16 21:31:40', 769, 40, 23),
(7, 'fewfwe', '2015-05-16 21:31:43', 769, 40, 23),
(8, 'dsaa', '2015-05-16 21:32:58', 769, 40, 23),
(9, 'sadas', '2015-05-16 21:33:02', 769, 40, 23),
(13, 'dsaa', '2015-05-16 21:56:51', 770, 43, 24),
(14, 'qwdfq', '2015-05-16 21:56:54', 770, 43, 24),
(15, 'fdfs', '2015-05-16 21:56:56', 770, 43, 24),
(16, 'ds', '2015-05-16 22:09:58', 770, 43, 24),
(17, '123', '2015-05-16 22:10:08', 770, 43, 24),
(18, '1', '2015-05-16 22:41:42', 770, 40, 24),
(19, 'sa', '2015-05-16 22:44:37', 770, 40, 24),
(20, 'm', '2015-05-17 00:58:17', 770, 40, 24),
(32, 'sasa', '2015-05-17 14:09:23', 776, 40, 23),
(33, 'sasa', '2015-05-17 14:09:26', 776, 40, 23),
(34, 'ertr', '2015-05-17 14:13:53', 776, 40, 23),
(35, 'jhykjh', '2015-05-17 14:19:41', 776, 40, 23),
(53, 'ewr', '2015-05-17 14:40:07', 776, 37, 23),
(54, 'sadsadsa', '2015-05-17 14:41:23', 793, 37, 23),
(55, 'ertert', '2015-05-17 14:43:36', 794, 37, 23),
(58, 'zvzvxcvxvxc', '2015-05-17 14:56:51', 795, 40, 23),
(61, '2121', '2015-05-17 14:58:47', 796, 40, 27),
(62, '2121', '2015-05-17 14:58:50', 796, 40, 27),
(63, '123', '2015-05-17 15:04:19', 795, 40, 23),
(64, 'wq', '2015-05-17 15:04:33', 797, 40, 23),
(65, 'dassad', '2015-05-17 15:21:18', 792, 40, 24),
(66, 'ØªØ§ØªØ§Ø§', '2015-05-17 15:51:25', 798, 40, 23),
(67, 'Ø³Ø´Ø³Ø´Ø´', '2015-05-17 15:51:44', 798, 40, 23),
(68, 'Ø³Ø´Ø³Ø´', '2015-05-17 15:52:03', 803, 40, 23),
(69, 'Ø³Ø´Ø³', '2015-05-17 15:52:19', 753, 40, 23),
(72, 'Ø³Ø´Ø³Ø´Ø³Ø´', '2015-05-17 16:07:31', 804, 40, 23),
(73, 'Ã¤Ã¥Ã¶', '2015-05-17 16:09:27', 749, 40, 1),
(74, 'sa', '2015-05-17 16:15:05', 809, 40, 1),
(75, 'we', '2015-05-17 17:36:09', 807, 40, 23),
(76, 'ew', '2015-05-17 17:36:26', 807, 40, 23),
(78, 'as', '2015-05-17 17:36:58', 807, 40, 23),
(79, '123', '2015-05-17 17:37:09', 805, 40, 23),
(81, 'hello there<br /><br />:D', '2015-05-17 18:15:15', 811, 40, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `CourseId` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `RssUrl` varchar(255) NOT NULL,
  `Schedule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CourseId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumpning av Data i tabell `course`
--

INSERT INTO `course` (`CourseId`, `CourseName`, `CourseCode`, `RssUrl`, `Schedule`) VALUES
(1, 'Public', '', '', ''),
(23, 'TestarMashup', '456', 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/feed', ''),
(24, 'hello ', '123', '', 'http://se.timeedit.net/web/lnu/db1/schema1/ri1Y1X4QQ9wZ76Qv49050755yYYQ5Z5784Y55X5.html'),
(25, 'safd', 'dsfdsf', '', 'http://se.timeedit.net/web/lnu/db1/schema1/ri1Y1X4QQ9wZ76Qv49050755yYYQ5Z5784Y55X5.html'),
(27, 'sahand', '123', '', '');

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
  `UserId` int(11) DEFAULT NULL,
  `CourseId` int(11) DEFAULT NULL,
  `RssLink` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `imgName` (`imgName`,`code`),
  KEY `id_2` (`id`),
  KEY `UserId` (`UserId`),
  KEY `CourseId` (`CourseId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=823 ;

--
-- Dumpning av Data i tabell `feed`
--

INSERT INTO `feed` (`id`, `imgName`, `Title`, `Post`, `code`, `Date`, `UserId`, `CourseId`, `RssLink`) VALUES
(745, NULL, NULL, 'dsdw', NULL, '2015-05-14 13:30:14', 40, 1, NULL),
(746, NULL, NULL, 'fsgaaa', NULL, '2015-05-14 13:32:15', 40, 1, NULL),
(749, NULL, '', 'Ø³Ø´Ø³Ø´Ø´', NULL, '2015-05-14 16:27:38', 40, 1, NULL),
(751, NULL, NULL, NULL, NULL, '2015-05-14 16:28:57', 0, 23, 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/2014/01/14/forbattrad-json-kod/'),
(752, NULL, NULL, NULL, NULL, '2015-05-14 16:28:57', 0, 23, 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/2013/12/30/iteration-3-2/'),
(753, NULL, NULL, NULL, NULL, '2015-05-14 16:28:57', 0, 23, 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/2013/12/16/iteration-3/'),
(754, NULL, NULL, NULL, NULL, '2015-05-14 16:28:57', 0, 23, 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/2013/12/13/version-2-av-udp-apiet/'),
(755, NULL, NULL, NULL, NULL, '2015-05-14 16:28:57', 0, 23, 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/2013/12/03/iteration-1/'),
(756, NULL, NULL, NULL, NULL, '2015-05-14 16:28:57', 0, 23, 'http://coursepress.lnu.se/kurs/anvanda-komponenter-och-apier/2013/11/12/upp-and-running/'),
(768, NULL, NULL, 'ds', NULL, '2015-05-16 17:08:07', 40, 23, NULL),
(769, NULL, NULL, 'ssa', NULL, '2015-05-16 21:31:33', 40, 23, NULL),
(770, NULL, NULL, 'dsdfs', NULL, '2015-05-16 21:56:49', 43, 24, NULL),
(774, NULL, NULL, 'dzcfd', NULL, '2015-05-17 14:03:06', 40, 23, NULL),
(775, NULL, NULL, 'fdasfsdfsdf', NULL, '2015-05-17 14:04:33', 43, 23, NULL),
(776, NULL, NULL, '123', NULL, '2015-05-17 14:04:39', 43, 23, NULL),
(792, NULL, NULL, 'dfgdfgfdg', NULL, '2015-05-17 14:39:03', 37, 24, NULL),
(793, NULL, NULL, 'ewrewr', NULL, '2015-05-17 14:41:15', 37, 23, NULL),
(794, NULL, NULL, 'erterter', NULL, '2015-05-17 14:43:31', 37, 23, NULL),
(795, NULL, '', 'uppdatera ', NULL, '2015-05-17 14:44:52', 37, 23, NULL),
(796, NULL, NULL, '1', NULL, '2015-05-17 14:58:43', 40, 27, NULL),
(797, NULL, NULL, '12345432', NULL, '2015-05-17 15:04:28', 40, 23, NULL),
(798, NULL, NULL, '13241', NULL, '2015-05-17 15:06:55', 40, 23, NULL),
(802, NULL, 'ÙŠÙ…Ø©', '', 'k-PkIKZ_5nY', '2015-05-17 15:46:49', 40, 24, NULL),
(803, NULL, NULL, 'Ù„ÙŠØ¨Ù„Ø¨ÙŠÙ„ÙŠØ¨', NULL, '2015-05-17 15:51:49', 40, 23, NULL),
(804, '489615607.jpg', 'Ø³Ø´Ø³Ø´Ø´', '', NULL, '2015-05-17 16:06:42', 40, 23, NULL),
(805, '977811165.jpg', 'Ø³Ø´Ø³Ø´', '', NULL, '2015-05-17 16:08:41', 40, 23, NULL),
(806, '78705127.jpg', 'sasasa', '', NULL, '2015-05-17 16:09:39', 40, 1, NULL),
(807, '10757945.jpg', 'bata', '', NULL, '2015-05-17 16:10:16', 40, 23, NULL),
(808, '91141312.jpg', 'blommorsss', '', NULL, '2015-05-17 16:10:56', 40, 1, NULL),
(809, NULL, 'youtube', '', '6bvylq6_-ss', '2015-05-17 16:14:47', 40, 1, NULL),
(811, NULL, NULL, NULL, 'gca1M2yx4KE', '2015-05-17 17:56:38', 37, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumpning av Data i tabell `messages`
--

INSERT INTO `messages` (`MsgId`, `FromName`, `Subject`, `Date`, `Time`, `Messages`, `Open`, `UserId`, `NEWMSGID`) VALUES
(16, 'Sahib', 'dfgggdf', 'May/08/2015', 1431082785, 'gfddfgdgdgdgdf', 1, 37, 0),
(18, 'Tommy', 'Tommy Replied to you', 'May/08/2015', 1431083035, 'sasa', 1, 40, 16),
(19, 'Sahib', 'dd', 'May/13/2015', 1431527212, 'ss', 0, 0, 0),
(20, 'Sahib', 'k', 'May/14/2015', 1431561351, 'l', 0, 42, 0),
(21, 'Sahib', 'Sahib Replied to you', 'May/14/2015', 1431561381, 'l', 0, 37, 18),
(22, 'Tommy', 'Tommy Replied to you', 'May/14/2015', 1431566368, 'sd', 1, 40, 16),
(23, 'Tommy', 'Tommy Replied to you', 'May/14/2015', 1431566373, 'sds', 1, 40, 16),
(24, 'Sahib', 'Sahib Replied to you', 'May/14/2015', 1431610598, 'dsa', 0, 37, 17),
(25, 'Sahib', 'Sahib Replied to you', 'May/15/2015', 1431641735, 'dsds', 0, 37, 23);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumpning av Data i tabell `programcourse`
--

INSERT INTO `programcourse` (`ProgramCourseId`, `ProgramId`, `CourseId`) VALUES
(25, 2, 23),
(26, 2, 24),
(27, 1, 25),
(29, 1, 27);

-- --------------------------------------------------------

--
-- Tabellstruktur `sentmsg`
--

CREATE TABLE IF NOT EXISTS `sentmsg` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumpning av Data i tabell `sentmsg`
--

INSERT INTO `sentmsg` (`MsgId`, `FromName`, `Subject`, `Date`, `Time`, `Messages`, `Open`, `UserId`, `NEWMSGID`) VALUES
(9, 'Tommy', 'Tommy Replied to you', 'May/08/2015', 1431082818, 'das', 0, 40, 16),
(10, 'Tommy', 'Tommy Replied to you', 'May/08/2015', 1431083035, 'sasa', 0, 40, 16),
(14, 'Tommy', 'Tommy Replied to you', 'May/14/2015', 1431566368, 'sd', 0, 40, 16),
(15, 'Tommy', 'Tommy Replied to you', 'May/14/2015', 1431566373, 'sds', 0, 40, 16);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumpning av Data i tabell `spcmsg`
--

INSERT INTO `spcmsg` (`SPCMSGID`, `MSGID`, `MESSAGE`, `Name`, `TIME`, `DATE`, `NEWMSGID`) VALUES
(5, 16, 'das', 'Tommy', 1431082818, 'May/08/2015', 16),
(6, 16, 'sasa', 'Tommy', 1431083035, 'May/08/2015', 16),
(7, 18, 'l', 'Sahib', 1431561381, 'May/14/2015', 18),
(8, 16, 'sd', 'Tommy', 1431566368, 'May/14/2015', 16),
(9, 16, 'sds', 'Tommy', 1431566373, 'May/14/2015', 16),
(11, 23, 'dsds', 'Sahib', 1431641735, 'May/15/2015', 23);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`UserId`, `Username`, `email`, `Hash`, `Role`, `passreset`, `imgName`, `date`) VALUES
(0, 'CoursePressDefault', 'sahand___@hotmail.com', '$2a$10$LwMTCO2KkwZeuhwYCS.hgetHKKgY6XlGv/p/HPhpTnr/lQwVV.VYO', 3, 0, NULL, '2015-05-12 11:46:57'),
(37, 'Tommy', 'tn222eb@student.lnu.se', '$2a$10$yAWlJc1O1Afw.OzqHRvege3No/vPsPQiAGD6QXctK9ThN02S.EaEq', 3, 713847, 'NULL', '2015-04-30 00:41:35'),
(40, 'Sahib', 'sahib@hotmail.se', '$2a$10$ekSlL9xP5CaWuRkIuJgHM.i0kRk7CBwfefbpe3vaLSsU1UdtLT8N2', 1, 566754, 'img/default.jpg', '2015-05-14 23:10:30'),
(43, 'yousif', 'sad@gmail.com', '$2a$10$Nu9NhIFVrYYVyj/fgwRSGerur4WZevi8cB0k2ep/C9dvZAeNeSJuK', 3, 0, NULL, '2015-05-13 22:08:59');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumpning av Data i tabell `userdetails`
--

INSERT INTO `userdetails` (`userDetailid`, `UserId`, `firstname`, `lastname`, `sex`, `birthday`, `schoolForm`, `ProgramId`) VALUES
(34, 37, 'Tommy', 'Nguyen', 'Man', '1994-06-13', 'Campus', 2),
(37, 40, 'Sahib', 'Sahib', 'Man', '1990-08-05', 'Campus', 2),
(39, 0, 'CoursePress', 'RSS', 'Man', '1992-05-12', 'Campus', 2),
(42, 43, 'yousif', 'sd', 'Kvinna', '2000-07-25', 'Distans', 1);

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
