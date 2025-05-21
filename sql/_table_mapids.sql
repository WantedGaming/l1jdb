
-- --------------------------------------------------------

--
-- Table structure for table `mapids`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
-- Last check: May 21, 2025 at 07:09 AM
--

CREATE TABLE `mapids` (
  `mapid` int(10) NOT NULL DEFAULT 0,
  `locationname` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `startX` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `endX` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `startY` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `endY` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `monster_amount` float UNSIGNED NOT NULL DEFAULT 0,
  `drop_rate` float UNSIGNED NOT NULL DEFAULT 0,
  `underwater` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `markable` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `teleportable` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `escapable` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `resurrection` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `painwand` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `penalty` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `take_pets` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `recall_pets` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `usable_item` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `usable_skill` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `dungeon` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `dmgModiPc2Npc` int(3) NOT NULL DEFAULT 0,
  `dmgModiNpc2Pc` int(3) NOT NULL DEFAULT 0,
  `decreaseHp` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `dominationTeleport` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `beginZone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `redKnightZone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `ruunCastleZone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `interWarZone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `geradBuffZone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `growBuffZone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `interKind` int(3) NOT NULL DEFAULT 0,
  `script` varchar(50) DEFAULT NULL,
  `cloneStart` int(6) NOT NULL DEFAULT 0,
  `cloneEnd` int(6) NOT NULL DEFAULT 0,
  `pngId` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `mapids`:
--
