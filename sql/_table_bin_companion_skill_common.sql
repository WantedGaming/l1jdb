
-- --------------------------------------------------------

--
-- Table structure for table `bin_companion_skill_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_companion_skill_common` (
  `id` int(3) NOT NULL DEFAULT 0,
  `descNum` int(6) NOT NULL DEFAULT 0,
  `descKr` varchar(100) DEFAULT NULL,
  `enchantBonus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_companion_skill_common`:
--
