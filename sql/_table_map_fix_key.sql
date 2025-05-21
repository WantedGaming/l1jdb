
-- --------------------------------------------------------

--
-- Table structure for table `map_fix_key`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `map_fix_key` (
  `locX` smallint(6) UNSIGNED NOT NULL,
  `locY` smallint(6) UNSIGNED NOT NULL,
  `mapId` smallint(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `map_fix_key`:
--
