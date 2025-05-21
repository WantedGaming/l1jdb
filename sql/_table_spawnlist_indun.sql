
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_indun`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_indun` (
  `id` int(3) UNSIGNED NOT NULL,
  `type` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `npc_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locx` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `locy` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `heading` int(2) NOT NULL DEFAULT 0,
  `randomRange` int(11) NOT NULL DEFAULT 5,
  `mapId` int(11) NOT NULL,
  `location` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_indun`:
--
