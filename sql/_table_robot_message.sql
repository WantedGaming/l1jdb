
-- --------------------------------------------------------

--
-- Table structure for table `robot_message`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `robot_message` (
  `uid` int(10) UNSIGNED NOT NULL,
  `type` enum('pvp','die') NOT NULL,
  `ment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `robot_message`:
--
