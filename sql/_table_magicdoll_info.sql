
-- --------------------------------------------------------

--
-- Table structure for table `magicdoll_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `magicdoll_info` (
  `itemId` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `dollNpcId` int(11) NOT NULL DEFAULT 0,
  `blessItemId` int(11) DEFAULT 0,
  `grade` int(2) NOT NULL DEFAULT 0,
  `bonusItemId` int(11) NOT NULL DEFAULT 0,
  `bonusCount` int(11) NOT NULL DEFAULT 0,
  `bonusInterval` int(11) NOT NULL DEFAULT 0,
  `damageChance` int(3) NOT NULL DEFAULT 0,
  `attackSkillEffectId` int(5) NOT NULL DEFAULT 0,
  `haste` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `magicdoll_info`:
--
