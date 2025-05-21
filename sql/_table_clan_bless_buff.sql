
-- --------------------------------------------------------

--
-- Table structure for table `clan_bless_buff`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_bless_buff` (
  `number` int(10) UNSIGNED NOT NULL,
  `buff_id` int(10) NOT NULL DEFAULT -1,
  `map_name` varchar(45) NOT NULL DEFAULT '',
  `teleport_map_id` int(6) UNSIGNED DEFAULT 0,
  `teleport_x` int(6) UNSIGNED DEFAULT 0,
  `teleport_y` int(6) UNSIGNED DEFAULT 0,
  `buff_map_list` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_bless_buff`:
--
