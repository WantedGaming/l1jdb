
-- --------------------------------------------------------

--
-- Table structure for table `mobskill`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `mobskill` (
  `mobid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `actNo` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `mobname` varchar(45) NOT NULL DEFAULT '',
  `desc_en` varchar(100) NOT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `type` enum('NONE','ATTACK','SPELL','SUMMON','POLY','LINE_ATTACK','KIRTAS_METEOR','KIRTAS_BARRIER','TITANGOLEM_BARRIER','VALLACAS_FLY','VALLACAS_BRESS') NOT NULL DEFAULT 'NONE',
  `prob` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `enableHp` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `enableCompanionHp` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `range` int(3) NOT NULL DEFAULT 0,
  `limitCount` int(3) NOT NULL DEFAULT 0,
  `ChangeTarget` enum('NO','COMPANION','ME','RANDOM') NOT NULL DEFAULT 'NO',
  `AreaWidth` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `AreaHeight` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `Leverage` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `SkillId` int(10) NOT NULL DEFAULT -1,
  `Gfxid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ActId` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `SummonId` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `SummonMin` int(3) NOT NULL DEFAULT 0,
  `SummonMax` int(3) NOT NULL DEFAULT 0,
  `PolyId` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Msg` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `mobskill`:
--
