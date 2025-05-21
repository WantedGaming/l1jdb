
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_boss_sign`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_boss_sign` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `desc_kr` varchar(100) NOT NULL,
  `bossId` int(10) NOT NULL DEFAULT 0,
  `npcId` int(10) NOT NULL DEFAULT 0,
  `locX` int(6) NOT NULL DEFAULT 0,
  `locY` int(6) NOT NULL DEFAULT 0,
  `locMapId` int(6) NOT NULL DEFAULT 0,
  `rndRange` int(3) NOT NULL DEFAULT 0,
  `aliveSecond` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_boss_sign`:
--
