
-- --------------------------------------------------------

--
-- Table structure for table `bin_einpoint_stat_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_einpoint_stat_common` (
  `index_id` int(3) NOT NULL DEFAULT 0,
  `stat_type` enum('BLESS(0)','LUCKY(1)','VITAL(2)','ITEM_SPELL_PROB(3)','ABSOLUTE_REGEN(4)','POTION(5)','ATTACK_SPELL(6)','PVP_REDUCTION(7)','PVE_REDUCTION(8)','_MAX_(9)') NOT NULL DEFAULT '_MAX_(9)',
  `value` int(3) NOT NULL DEFAULT 0,
  `Ability1_minIncValue` int(3) NOT NULL DEFAULT 0,
  `Ability1_maxIncValue` int(3) NOT NULL DEFAULT 0,
  `Ability2_minIncValue` int(3) NOT NULL DEFAULT 0,
  `Ability2_maxIncValue` int(3) NOT NULL DEFAULT 0,
  `StatMaxInfo_level` int(3) NOT NULL DEFAULT 0,
  `StatMaxInfo_statMax` int(3) NOT NULL DEFAULT 0,
  `eachStatMax` int(3) NOT NULL DEFAULT 0,
  `totalStatMax` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_einpoint_stat_common`:
--
