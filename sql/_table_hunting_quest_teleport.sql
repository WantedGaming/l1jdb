
-- --------------------------------------------------------

--
-- Table structure for table `hunting_quest_teleport`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `hunting_quest_teleport` (
  `action_string` varchar(50) NOT NULL DEFAULT '',
  `tel_mapid` int(6) NOT NULL DEFAULT 0,
  `tel_x` int(4) DEFAULT NULL,
  `tel_y` int(4) DEFAULT NULL,
  `tel_itemid` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `hunting_quest_teleport`:
--
