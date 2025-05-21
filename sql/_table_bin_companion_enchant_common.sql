
-- --------------------------------------------------------

--
-- Table structure for table `bin_companion_enchant_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_companion_enchant_common` (
  `tier` int(3) NOT NULL,
  `enchantCost` text DEFAULT NULL,
  `openCost` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_companion_enchant_common`:
--
