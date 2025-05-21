
-- --------------------------------------------------------

--
-- Table structure for table `skills`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `skills` (
  `skill_id` int(10) NOT NULL DEFAULT -1,
  `name` varchar(45) NOT NULL DEFAULT '',
  `desc_kr` varchar(45) NOT NULL,
  `desc_en` varchar(100) NOT NULL,
  `skill_level` int(10) NOT NULL DEFAULT 0,
  `mpConsume` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hpConsume` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `itemConsumeId` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `itemConsumeCount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reuseDelay` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `delayGroupId` int(2) NOT NULL DEFAULT 0,
  `fixDelay` enum('true','false') NOT NULL DEFAULT 'false',
  `buffDuration` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `buffDuration_txt` varchar(30) NOT NULL,
  `target` enum('NONE','ATTACK','BUFF') NOT NULL DEFAULT 'NONE',
  `target_to` enum('ME','PC','NPC','ALL','PLEDGE','PARTY','COMPANIION','PLACE') NOT NULL DEFAULT 'ALL',
  `target_to_txt` varchar(75) NOT NULL,
  `effect_txt` varchar(260) NOT NULL,
  `damage_value` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `damage_dice` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `damage_dice_count` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `probability_value` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `probability_dice` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `attr` enum('NONE','EARTH','FIRE','WATER','WIND','RAY') NOT NULL DEFAULT 'NONE',
  `type` enum('NONE','PROB','CHANGE','CURSE','DEATH','HEAL','RESTORE','ATTACK','OTHER') NOT NULL DEFAULT 'NONE',
  `alignment` int(10) NOT NULL DEFAULT 0,
  `ranged` int(3) NOT NULL DEFAULT 0,
  `area` int(3) NOT NULL DEFAULT 0,
  `is_through` enum('true','false') NOT NULL DEFAULT 'false',
  `action_id` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `action_id2` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `action_id3` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `castgfx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `castgfx2` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `castgfx3` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sysmsgID_happen` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sysmsgID_stop` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sysmsgID_fail` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `classType` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','normal','none') NOT NULL DEFAULT 'none',
  `grade` enum('ONLY','MYTH','LEGEND','RARE','NORMAL') NOT NULL DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `skills`:
--
