
-- --------------------------------------------------------

--
-- Table structure for table `bin_indun_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_indun_common` (
  `mapKind` int(3) NOT NULL DEFAULT 0,
  `keyItemId` int(5) NOT NULL DEFAULT 0,
  `minPlayer` int(2) NOT NULL DEFAULT 0,
  `maxPlayer` int(2) NOT NULL DEFAULT 0,
  `minAdena` int(6) NOT NULL DEFAULT 0,
  `maxAdena` int(6) NOT NULL DEFAULT 0,
  `minLevel` varchar(100) DEFAULT NULL,
  `bmkeyItemId` int(5) NOT NULL DEFAULT 0,
  `eventKeyItemId` int(5) NOT NULL DEFAULT 0,
  `dungeon_type` enum('UNDEFINED(0)','DEFENCE_TYPE(1)','DUNGEON_TYPE(2)') NOT NULL DEFAULT 'UNDEFINED(0)',
  `enable_boost_mode` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_indun_common`:
--
