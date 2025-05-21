
-- --------------------------------------------------------

--
-- Table structure for table `bin_companion_stat_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_companion_stat_common` (
  `id` int(3) NOT NULL DEFAULT 0,
  `statType` enum('INT(2)','CON(1)','STR(0)') NOT NULL DEFAULT 'STR(0)',
  `value` int(3) NOT NULL DEFAULT 0,
  `meleeDmg` int(3) NOT NULL DEFAULT 0,
  `meleeHit` int(3) NOT NULL DEFAULT 0,
  `regenHP` int(3) NOT NULL DEFAULT 0,
  `ac` int(3) NOT NULL DEFAULT 0,
  `spellDmg` int(3) NOT NULL DEFAULT 0,
  `spellHit` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_companion_stat_common`:
--
