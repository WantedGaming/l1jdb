
-- --------------------------------------------------------

--
-- Table structure for table `trap`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `trap` (
  `id` int(8) NOT NULL,
  `note` varchar(64) DEFAULT NULL,
  `type` varchar(64) NOT NULL,
  `gfxId` int(4) NOT NULL,
  `isDetectionable` tinyint(1) NOT NULL,
  `base` int(4) NOT NULL,
  `dice` int(4) NOT NULL,
  `diceCount` int(4) NOT NULL,
  `poisonType` char(1) NOT NULL DEFAULT 'n',
  `poisonDelay` int(4) NOT NULL DEFAULT 0,
  `poisonTime` int(4) NOT NULL DEFAULT 0,
  `poisonDamage` int(4) NOT NULL DEFAULT 0,
  `monsterNpcId` int(4) NOT NULL DEFAULT 0,
  `monsterCount` int(4) NOT NULL DEFAULT 0,
  `teleportX` int(4) NOT NULL DEFAULT 0,
  `teleportY` int(4) NOT NULL DEFAULT 0,
  `teleportMapId` int(4) NOT NULL DEFAULT 0,
  `skillId` int(4) NOT NULL DEFAULT -1,
  `skillTimeSeconds` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `trap`:
--
