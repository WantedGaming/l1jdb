
-- --------------------------------------------------------

--
-- Table structure for table `robot_location`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `robot_location` (
  `uid` int(10) UNSIGNED NOT NULL,
  `istown` enum('true','false') NOT NULL DEFAULT 'false',
  `x` int(10) NOT NULL,
  `y` int(10) NOT NULL,
  `map` int(10) NOT NULL,
  `etc` text NOT NULL,
  `count` int(10) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `robot_location`:
--
