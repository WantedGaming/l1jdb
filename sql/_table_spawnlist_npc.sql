
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_npc`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_npc` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `npc_templateid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locx` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `locy` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `randomx` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `randomy` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `heading` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `respawn_delay` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mapid` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `movement_distance` int(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_npc`:
--
