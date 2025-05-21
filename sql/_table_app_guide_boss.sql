
-- --------------------------------------------------------

--
-- Table structure for table `app_guide_boss`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_guide_boss` (
  `id` int(2) NOT NULL DEFAULT 0,
  `loc` int(2) NOT NULL DEFAULT 0,
  `locName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` int(2) NOT NULL DEFAULT 0,
  `bossName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bossImg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `spawnLoc` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `spawnTime` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dropName` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_guide_boss`:
--
