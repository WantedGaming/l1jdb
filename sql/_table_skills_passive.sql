
-- --------------------------------------------------------

--
-- Table structure for table `skills_passive`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `skills_passive` (
  `passive_id` int(3) NOT NULL DEFAULT -1,
  `name` varchar(100) DEFAULT NULL,
  `desc_kr` varchar(100) NOT NULL,
  `desc_en` varchar(100) NOT NULL,
  `duration` int(6) NOT NULL DEFAULT 0,
  `on_icon_id` int(6) NOT NULL DEFAULT 0,
  `tooltip_str_id` int(6) NOT NULL DEFAULT 0,
  `is_good` enum('false','true') NOT NULL DEFAULT 'true',
  `class_type` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','normal','none') NOT NULL DEFAULT 'none',
  `back_active_skill_id` int(10) NOT NULL DEFAULT -1,
  `back_passive_id` int(3) NOT NULL DEFAULT -1,
  `grade` enum('ONLY','MYTH','LEGEND','RARE','NORMAL') NOT NULL DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `skills_passive`:
--
