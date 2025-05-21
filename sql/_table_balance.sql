
-- --------------------------------------------------------

--
-- Table structure for table `balance`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `balance` (
  `attackerType` enum('npc','lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') NOT NULL DEFAULT 'crown',
  `targetType` enum('npc','lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') NOT NULL DEFAULT 'crown',
  `physicalDmg` int(3) NOT NULL DEFAULT 0,
  `physicalHit` int(3) NOT NULL DEFAULT 0,
  `physicalReduction` int(3) NOT NULL DEFAULT 0,
  `magicDmg` int(3) NOT NULL DEFAULT 0,
  `magicHit` int(3) NOT NULL DEFAULT 0,
  `magicReduction` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `balance`:
--
