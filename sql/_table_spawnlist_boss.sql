
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_boss`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_boss` (
  `id` int(10) UNSIGNED NOT NULL,
  `spawn_group_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT '',
  `desc_kr` varchar(45) CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT '',
  `npcid` int(10) NOT NULL DEFAULT 0,
  `spawnDay` varchar(100) CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL,
  `spawnTime` text CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL,
  `spawnX` int(5) NOT NULL DEFAULT 0,
  `spawnY` int(5) NOT NULL DEFAULT 0,
  `spawnMapId` int(5) NOT NULL DEFAULT 0,
  `rndMinut` int(6) NOT NULL DEFAULT 0,
  `rndRange` int(10) NOT NULL DEFAULT 0,
  `heading` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `groupid` int(10) NOT NULL DEFAULT 0,
  `movementDistance` int(3) NOT NULL DEFAULT 0,
  `isYN` enum('true','false') CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT 'false',
  `mentType` enum('NONE','WORLD','MAP','SCREEN') NOT NULL,
  `ment` varchar(100) CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT '',
  `percent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `aliveSecond` int(10) NOT NULL DEFAULT 0,
  `spawnType` enum('NORMAL','DOMINATION_TOWER','DRAGON_RAID','POISON_FEILD') CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_boss`:
--
