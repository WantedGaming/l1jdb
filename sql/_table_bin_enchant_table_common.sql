
-- --------------------------------------------------------

--
-- Table structure for table `bin_enchant_table_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_enchant_table_common` (
  `item_index` int(10) NOT NULL DEFAULT 0,
  `bonusLevel_index` int(10) NOT NULL DEFAULT 0,
  `enchantSuccessProb` int(10) NOT NULL DEFAULT 0,
  `enchantTotalProb` int(10) NOT NULL DEFAULT 0,
  `bmEnchantSuccessProb` int(10) NOT NULL DEFAULT 0,
  `bmEnchantRemainProb` int(10) NOT NULL DEFAULT 0,
  `bmEnchantFailDownProb` int(10) NOT NULL DEFAULT 0,
  `bmEnchantTotalProb` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_enchant_table_common`:
--
