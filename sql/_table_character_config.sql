
-- --------------------------------------------------------

--
-- Table structure for table `character_config`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_config` (
  `object_id` int(10) NOT NULL DEFAULT 0,
  `length` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_config`:
--
