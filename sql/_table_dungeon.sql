
-- --------------------------------------------------------

--
-- Table structure for table `dungeon`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `dungeon` (
  `src_x` int(10) NOT NULL DEFAULT 0,
  `src_y` int(10) NOT NULL DEFAULT 0,
  `src_mapid` int(10) NOT NULL DEFAULT 0,
  `new_x` int(10) NOT NULL DEFAULT 0,
  `new_y` int(10) NOT NULL DEFAULT 0,
  `new_mapid` int(10) NOT NULL DEFAULT 0,
  `new_heading` int(10) NOT NULL DEFAULT 1,
  `min_level` int(3) NOT NULL DEFAULT 0,
  `max_level` int(3) NOT NULL DEFAULT 0,
  `note` varchar(75) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `dungeon`:
--
