
-- --------------------------------------------------------

--
-- Table structure for table `skills_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `skills_info` (
  `skillId` int(10) NOT NULL DEFAULT -1,
  `skillname` varchar(20) NOT NULL,
  `desc_en` varchar(100) NOT NULL,
  `desc_kr` varchar(100) NOT NULL,
  `useSkillId` int(10) NOT NULL DEFAULT 0,
  `durationShowType` enum('NONE(0)','PERCENT(1)','MINUTE(2)','PERCENT_ORC_SERVER(3)','EINHASAD_COOLTIME_MINUTE(4)','LEGACY_TIME(5)','VARIABLE_VALUE(6)','DAY_HOUR_MIN(7)','AUTO_DAY_HOUR_MIN_SEC(8)','NSERVICE_TOPPING(9)','UNLIMIT(10)','CUSTOM(11)','COUNT(12)','RATE(13)','EINHASAD_FAVOR(14)','HIDDEN(15)') NOT NULL DEFAULT 'AUTO_DAY_HOUR_MIN_SEC(8)',
  `icon` int(5) NOT NULL DEFAULT 0,
  `onIconId` int(5) NOT NULL DEFAULT 0,
  `offIconId` int(5) NOT NULL DEFAULT 0,
  `simplePck` enum('false','true') NOT NULL DEFAULT 'false',
  `iconPriority` int(3) NOT NULL DEFAULT 3,
  `tooltipStrId` int(5) NOT NULL DEFAULT 0,
  `newStrId` int(5) NOT NULL DEFAULT 0,
  `endStrId` int(5) NOT NULL DEFAULT 0,
  `isGood` enum('true','false') NOT NULL DEFAULT 'true',
  `overlapBuffIcon` int(3) NOT NULL DEFAULT 0,
  `mainTooltipStrId` int(3) NOT NULL DEFAULT 0,
  `buffIconPriority` int(3) NOT NULL DEFAULT 0,
  `buffGroupId` int(3) NOT NULL DEFAULT 0,
  `buffGroupPriority` int(3) NOT NULL DEFAULT 0,
  `expireDuration` int(6) NOT NULL DEFAULT 0,
  `boostType` enum('BOOST_NONE(0)','HP_UI_CHANGE(1)') NOT NULL DEFAULT 'BOOST_NONE(0)',
  `isPassiveSpell` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `skills_info`:
--
