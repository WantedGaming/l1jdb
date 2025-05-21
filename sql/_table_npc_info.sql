
-- --------------------------------------------------------

--
-- Table structure for table `npc_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `npc_info` (
  `npcId` int(10) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `recall` enum('false','true') NOT NULL DEFAULT 'false',
  `spawnActionId` int(2) NOT NULL DEFAULT 0,
  `reward` enum('false','true') NOT NULL DEFAULT 'false',
  `rewardRange` enum('screen','map','self') NOT NULL DEFAULT 'screen',
  `rewardItemId` int(10) NOT NULL DEFAULT 0,
  `rewardItemCount` int(10) NOT NULL DEFAULT 0,
  `rewardEinhasad` int(4) NOT NULL DEFAULT 0,
  `rewardNcoin` int(10) NOT NULL DEFAULT 0,
  `rewardGfx` int(5) NOT NULL DEFAULT 0,
  `msgRange` enum('screen','map','self') NOT NULL DEFAULT 'screen',
  `spawnMsg` text DEFAULT NULL,
  `dieMsg` text DEFAULT NULL,
  `dieMsgPcList` enum('false','true') NOT NULL DEFAULT 'false',
  `autoLoot` enum('false','true') NOT NULL DEFAULT 'false',
  `transformChance` int(3) NOT NULL DEFAULT 0,
  `transformId` int(9) NOT NULL DEFAULT 0,
  `transformGfxId` int(6) NOT NULL DEFAULT 0,
  `scriptType` enum('text','number','none') NOT NULL DEFAULT 'none',
  `scriptContent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `npc_info`:
--
