
-- --------------------------------------------------------

--
-- Table structure for table `clan_contribution_buff`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_contribution_buff` (
  `clan_id` int(10) UNSIGNED NOT NULL,
  `clan_name` varchar(45) NOT NULL DEFAULT '',
  `exp_buff_type` int(1) UNSIGNED DEFAULT 0,
  `exp_buff_time` datetime DEFAULT NULL,
  `battle_buff_type` int(1) UNSIGNED DEFAULT 0,
  `battle_buff_time` datetime DEFAULT NULL,
  `defens_buff_type` int(1) UNSIGNED DEFAULT 0,
  `defens_buff_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_contribution_buff`:
--
