
-- --------------------------------------------------------

--
-- Table structure for table `spell_melt`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spell_melt` (
  `skillId` int(5) NOT NULL DEFAULT -1,
  `skillName` varchar(50) DEFAULT NULL,
  `passiveId` int(3) NOT NULL DEFAULT 0,
  `classType` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') NOT NULL DEFAULT 'crown',
  `skillItemId` int(9) NOT NULL DEFAULT 0,
  `meltItemId` int(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spell_melt`:
--
