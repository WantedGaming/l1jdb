
-- --------------------------------------------------------

--
-- Table structure for table `dungeon_timer`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `dungeon_timer` (
  `timerId` int(3) NOT NULL DEFAULT 0,
  `desc` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `descId` varchar(50) DEFAULT NULL,
  `useType` enum('ACCOUNT','CHARACTER') NOT NULL DEFAULT 'ACCOUNT',
  `mapIds` text DEFAULT NULL,
  `timerValue` int(9) NOT NULL DEFAULT 0,
  `bonusLevel` int(3) NOT NULL DEFAULT 0,
  `bonusValue` int(9) NOT NULL DEFAULT 0,
  `pccafeBonusValue` int(9) NOT NULL DEFAULT 0,
  `resetType` enum('DAY','WEEK','NONE') NOT NULL DEFAULT 'DAY',
  `minLimitLevel` int(3) NOT NULL DEFAULT 0,
  `maxLimitLevel` int(3) NOT NULL DEFAULT 0,
  `serialId` int(6) NOT NULL DEFAULT 0,
  `serialDescId` varchar(50) DEFAULT NULL,
  `maxChargeCount` int(3) NOT NULL DEFAULT 0,
  `group` enum('NONE','HIDDEN_FIELD','SILVER_KNIGHT_DUNGEON','HIDDEN_FIELD_BOOST') NOT NULL DEFAULT 'NONE'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `dungeon_timer`:
--
