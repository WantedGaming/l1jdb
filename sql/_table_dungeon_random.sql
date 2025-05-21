
-- --------------------------------------------------------

--
-- Table structure for table `dungeon_random`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `dungeon_random` (
  `src_x` int(10) NOT NULL DEFAULT 0,
  `src_y` int(10) NOT NULL DEFAULT 0,
  `src_mapid` int(10) NOT NULL DEFAULT 0,
  `new_x1` int(10) NOT NULL DEFAULT 0,
  `new_y1` int(10) NOT NULL DEFAULT 0,
  `new_mapid1` int(10) NOT NULL DEFAULT 0,
  `new_x2` int(10) NOT NULL DEFAULT 0,
  `new_y2` int(10) NOT NULL DEFAULT 0,
  `new_mapid2` int(10) NOT NULL DEFAULT 0,
  `new_x3` int(10) NOT NULL DEFAULT 0,
  `new_y3` int(10) NOT NULL DEFAULT 0,
  `new_mapid3` int(10) NOT NULL DEFAULT 0,
  `new_x4` int(10) NOT NULL DEFAULT 0,
  `new_y4` int(10) NOT NULL DEFAULT 0,
  `new_mapid4` int(10) NOT NULL DEFAULT 0,
  `new_x5` int(10) NOT NULL DEFAULT 0,
  `new_y5` int(10) NOT NULL DEFAULT 0,
  `new_mapid5` int(10) NOT NULL DEFAULT 0,
  `new_heading` int(10) NOT NULL DEFAULT 1,
  `note` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `dungeon_random`:
--
