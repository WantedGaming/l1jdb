
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_other`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_other` (
  `id` int(5) UNSIGNED NOT NULL,
  `type` int(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'with type 999: manually created not linked with this table.',
  `name` varchar(45) NOT NULL DEFAULT '',
  `npc_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locx` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `locy` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `heading` int(2) NOT NULL DEFAULT 0,
  `randomRange` int(3) NOT NULL DEFAULT 0,
  `timeMillisToDelete` int(6) NOT NULL DEFAULT 0,
  `gfxId` int(6) NOT NULL DEFAULT 0,
  `actionStatus` int(3) NOT NULL DEFAULT 4,
  `leftEdge` int(6) NOT NULL DEFAULT 0,
  `rightEdge` int(6) NOT NULL DEFAULT 0,
  `direction` int(3) NOT NULL DEFAULT 0,
  `targetPlayer` tinyint(1) NOT NULL DEFAULT 0,
  `paralysisTime` int(3) NOT NULL DEFAULT 0,
  `count` int(3) NOT NULL DEFAULT 1,
  `mapId` int(10) NOT NULL,
  `location` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_other`:
--
