
-- --------------------------------------------------------

--
-- Table structure for table `probability_by_spell`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `probability_by_spell` (
  `skill_id` int(10) NOT NULL,
  `description` varchar(64) DEFAULT NULL,
  `desc_kr` varchar(64) DEFAULT NULL,
  `skill_type` enum('MAGICHIT','ABILITY','SPIRIT','DRAGONSPELL','FEAR') NOT NULL DEFAULT 'MAGICHIT',
  `pierce_lv_weight` varchar(16) DEFAULT '0.0',
  `resis_lv_weight` varchar(16) DEFAULT '0.0',
  `int_weight` varchar(16) DEFAULT '0.0',
  `mr_weight` varchar(16) DEFAULT '0.0',
  `pierce_weight` varchar(16) DEFAULT '0.0',
  `resis_weight` varchar(16) DEFAULT '0.0',
  `default_probability` int(10) DEFAULT 5,
  `min_probability` int(10) DEFAULT 5,
  `max_probability` int(10) DEFAULT 80,
  `is_loggin` enum('false','true') DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `probability_by_spell`:
--
