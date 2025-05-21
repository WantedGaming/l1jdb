
-- --------------------------------------------------------

--
-- Table structure for table `bin_huntingquest_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_huntingquest_common` (
  `maxQuestCount` int(3) NOT NULL DEFAULT 0,
  `goalKillCount` int(3) NOT NULL DEFAULT 0,
  `reset_HourOfDay` int(2) NOT NULL DEFAULT -1,
  `reward_normal_ConditionalRewards` text DEFAULT NULL,
  `reward_normal_UsedItemID` int(6) NOT NULL,
  `reward_normal_UsedAmount` int(6) NOT NULL DEFAULT 0,
  `reward_dragon_ConditionalRewards` text DEFAULT NULL,
  `reward_dragon_UsedItemID` int(6) NOT NULL DEFAULT 0,
  `reward_dragon_UsedAmount` int(6) NOT NULL DEFAULT 0,
  `reward_hightdragon_ConditionalRewards` text DEFAULT NULL,
  `reward_hightdragon_UsedItemID` int(6) NOT NULL DEFAULT 0,
  `reward_hightdragon_UsedAmount` int(6) NOT NULL DEFAULT 0,
  `requiredCondition_MinLevel` int(3) NOT NULL DEFAULT 0,
  `requiredCondition_MaxLevel` int(3) NOT NULL DEFAULT 0,
  `requiredCondition_Map` int(6) NOT NULL DEFAULT 0,
  `requiredCondition_LocationDesc` int(6) NOT NULL DEFAULT 0,
  `enterMapID` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_huntingquest_common`:
--
