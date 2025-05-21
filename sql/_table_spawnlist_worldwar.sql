
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_worldwar`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_worldwar` (
  `id` int(3) UNSIGNED NOT NULL,
  `type` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `npc_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locx` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `locy` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `mapid` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `heading` int(2) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_worldwar`:
--
