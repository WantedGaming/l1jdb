
-- --------------------------------------------------------

--
-- Table structure for table `character_companion_buff`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
-- Last check: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_companion_buff` (
  `objid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `buff_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `duration` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_companion_buff`:
--
