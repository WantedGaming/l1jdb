
-- --------------------------------------------------------

--
-- Table structure for table `character_exclude`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_exclude` (
  `id` int(10) UNSIGNED NOT NULL,
  `char_id` int(10) NOT NULL DEFAULT 0,
  `type` int(2) NOT NULL DEFAULT 0,
  `exclude_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `exclude_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci COMMENT='MyISAM free: 10240 kB; MyISAM free: 10240 kB';

--
-- RELATIONSHIPS FOR TABLE `character_exclude`:
--
