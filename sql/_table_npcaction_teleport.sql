
-- --------------------------------------------------------

--
-- Table structure for table `npcaction_teleport`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `npcaction_teleport` (
  `npcId` int(10) NOT NULL DEFAULT 0,
  `note` varchar(50) DEFAULT NULL,
  `actionName` varchar(50) NOT NULL,
  `needLevel` int(3) NOT NULL DEFAULT 0,
  `limitLevel` int(3) NOT NULL DEFAULT 0,
  `needTimerId` int(3) NOT NULL DEFAULT 0,
  `needItem` text DEFAULT NULL,
  `needBuff` text DEFAULT NULL,
  `needPcroomBuff` enum('true','false') NOT NULL DEFAULT 'false',
  `telX` int(5) NOT NULL DEFAULT 0,
  `telY` int(5) NOT NULL DEFAULT 0,
  `telMapId` int(5) NOT NULL DEFAULT 0,
  `telRange` int(3) NOT NULL DEFAULT 0,
  `telType` enum('random','inter','normal') NOT NULL DEFAULT 'normal',
  `randomMap` text DEFAULT NULL,
  `telTownId` int(11) NOT NULL DEFAULT 0,
  `failAlignment` enum('caotic','neutral','lawful','none') NOT NULL DEFAULT 'none',
  `successActionName` varchar(50) DEFAULT NULL,
  `failLevelActionName` varchar(50) DEFAULT NULL,
  `failItemActionName` varchar(50) DEFAULT NULL,
  `failBuffActionName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `npcaction_teleport`:
--
