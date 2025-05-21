
-- --------------------------------------------------------

--
-- Table structure for table `bin_einpoint_meta_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_einpoint_meta_common` (
  `index_id` int(3) NOT NULL DEFAULT 0,
  `stat_type` enum('BLESS(0)','LUCKY(1)','VITAL(2)','ITEM_SPELL_PROB(3)','ABSOLUTE_REGEN(4)','POTION(5)','ATTACK_SPELL(6)','PVP_REDUCTION(7)','PVE_REDUCTION(8)','_MAX_(9)') NOT NULL DEFAULT '_MAX_(9)',
  `AbilityMetaData1_token` varchar(100) DEFAULT NULL,
  `AbilityMetaData1_x100` enum('true','false') NOT NULL DEFAULT 'false',
  `AbilityMetaData1_unit` enum('None(1)','Percent(2)') NOT NULL DEFAULT 'None(1)',
  `AbilityMetaData2_token` varchar(100) DEFAULT NULL,
  `AbilityMetaData2_x100` enum('true','false') NOT NULL DEFAULT 'false',
  `AbilityMetaData2_unit` enum('None(1)','Percent(2)') NOT NULL DEFAULT 'None(1)'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_einpoint_meta_common`:
--
