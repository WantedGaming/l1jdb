
-- --------------------------------------------------------

--
-- Table structure for table `notification`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `notification` (
  `notification_id` int(6) NOT NULL DEFAULT 0,
  `notification_type` enum('NORMAL(0)','CHANGE(1)') NOT NULL DEFAULT 'NORMAL(0)',
  `is_use` enum('true','false') NOT NULL DEFAULT 'true',
  `is_hyperlink` enum('true','false') NOT NULL DEFAULT 'false',
  `displaydesc` varchar(50) DEFAULT NULL,
  `displaydesc_kr` varchar(50) DEFAULT NULL,
  `displaydesc_en` varchar(50) NOT NULL,
  `date_type` enum('NONE(0)','CUSTOM(1)','BOSS(2)','DOMINATION_TOWER(3)','COLOSSEUM(4)','TREASURE(5)','FORGOTTEN(6)') NOT NULL DEFAULT 'NONE(0)',
  `date_boss_id` int(10) NOT NULL DEFAULT 0,
  `date_custom_start` datetime DEFAULT NULL,
  `date_custom_end` datetime DEFAULT NULL,
  `teleport_loc` text DEFAULT NULL,
  `rest_gauge_bonus` int(4) NOT NULL DEFAULT 0,
  `is_new` enum('true','false') NOT NULL DEFAULT 'false',
  `animation_type` enum('NO_ANIMATION(0)','ANT_QUEEN(1)','OMAN_MORPH(2)','AI_BATTLE(3)') NOT NULL DEFAULT 'NO_ANIMATION(0)'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `notification`:
--
