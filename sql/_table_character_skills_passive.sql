
-- --------------------------------------------------------

--
-- Table structure for table `character_skills_passive`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_skills_passive` (
  `char_obj_id` int(10) NOT NULL DEFAULT 0,
  `passive_id` int(10) NOT NULL DEFAULT 0,
  `passive_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_skills_passive`:
--
