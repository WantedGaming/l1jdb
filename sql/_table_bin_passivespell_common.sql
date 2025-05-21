
-- --------------------------------------------------------

--
-- Table structure for table `bin_passivespell_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_passivespell_common` (
  `passive_id` int(10) NOT NULL DEFAULT 0,
  `duration` int(10) NOT NULL DEFAULT 0,
  `spell_bonus_list` text DEFAULT NULL,
  `delay_group_id` int(2) NOT NULL DEFAULT 0,
  `extract_item_name_id` int(6) NOT NULL DEFAULT 0,
  `extract_item_count` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_passivespell_common`:
--
