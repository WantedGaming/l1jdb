
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_ruun`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_ruun` (
  `id` int(3) UNSIGNED NOT NULL,
  `stage` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `npcId` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locX` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `locY` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `mapId` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `range` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `count` int(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_ruun`:
--
