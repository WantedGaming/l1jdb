
-- --------------------------------------------------------

--
-- Table structure for table `playsupport`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `playsupport` (
  `mapid` int(6) NOT NULL,
  `mapname` varchar(50) DEFAULT NULL,
  `whole` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `surround` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `sub` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `playsupport`:
--
