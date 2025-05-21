
-- --------------------------------------------------------

--
-- Table structure for table `bin_spell_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_spell_common` (
  `spell_id` int(10) NOT NULL DEFAULT 0,
  `spell_category` enum('COMPANION_SPELL_BUFF(2)','SPELL_BUFF(1)','SPELL(0)') NOT NULL DEFAULT 'SPELL(0)',
  `on_icon_id` int(6) NOT NULL DEFAULT 0,
  `off_icon_id` int(6) NOT NULL DEFAULT 0,
  `duration` int(10) NOT NULL DEFAULT 0,
  `tooltip_str_id` int(6) NOT NULL DEFAULT 0,
  `tooltip_str_kr` varchar(200) DEFAULT NULL,
  `spell_bonus_list` text DEFAULT NULL,
  `companion_on_icon_id` int(6) NOT NULL DEFAULT 0,
  `companion_off_icon_id` int(6) NOT NULL DEFAULT 0,
  `companion_icon_priority` int(3) NOT NULL DEFAULT 0,
  `companion_tooltip_str_id` int(6) NOT NULL DEFAULT 0,
  `companion_new_str_id` int(6) NOT NULL DEFAULT 0,
  `companion_end_str_id` int(6) NOT NULL DEFAULT 0,
  `companion_is_good` int(3) NOT NULL DEFAULT 0,
  `companion_duration_show_type` int(3) NOT NULL DEFAULT 0,
  `delay_group_id` int(2) NOT NULL DEFAULT 0,
  `extract_item_name_id` int(6) NOT NULL DEFAULT 0,
  `extract_item_count` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_spell_common`:
--
