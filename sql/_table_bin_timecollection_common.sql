
-- --------------------------------------------------------

--
-- Table structure for table `bin_timecollection_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_timecollection_common` (
  `buffSelect` text DEFAULT NULL,
  `rewardList` text DEFAULT NULL,
  `enchantSection` text DEFAULT NULL,
  `group_id` int(3) NOT NULL DEFAULT 0,
  `group_desc` int(6) NOT NULL DEFAULT 0,
  `group_desc_kr` varchar(100) DEFAULT NULL,
  `group_level_min` int(3) NOT NULL DEFAULT 0,
  `group_level_max` int(3) NOT NULL DEFAULT 0,
  `group_period_StartDate` varchar(100) DEFAULT NULL,
  `group_period_EndDate` varchar(100) DEFAULT NULL,
  `group_set_id` int(3) NOT NULL DEFAULT 0,
  `group_set_desc` int(6) NOT NULL DEFAULT 0,
  `group_set_desc_kr` varchar(100) DEFAULT NULL,
  `group_set_defaultTime` varchar(100) DEFAULT NULL,
  `group_set_recycle` int(3) NOT NULL DEFAULT 0,
  `group_set_itemSlot` text DEFAULT NULL,
  `group_set_BuffType` text DEFAULT NULL,
  `group_set_endBonus` enum('true','false') NOT NULL DEFAULT 'false',
  `group_set_ExtraTimeId` int(10) NOT NULL DEFAULT 0,
  `group_set_SetType` enum('NONE(-1)','TC_INFINITY(0)','TC_LIMITED(1)','TC_BONUS_INFINITY(2)','TC_BONUS_LIMITED(3)','TC_ADENA_REFILL(4)','TC_ADENA_REFILL_ERROR(5)','TC_BONUS_ADENA_REFILL(6)','TC_BONUS_ADENA_REFILL_ERROR(7)') NOT NULL DEFAULT 'NONE(-1)',
  `ExtraTimeSection` text DEFAULT NULL,
  `NPCDialogInfo` text DEFAULT NULL,
  `AlarmSetting` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_timecollection_common`:
--
