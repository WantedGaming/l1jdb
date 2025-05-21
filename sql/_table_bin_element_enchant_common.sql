
-- --------------------------------------------------------

--
-- Table structure for table `bin_element_enchant_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_element_enchant_common` (
  `prob_index` int(3) NOT NULL DEFAULT 0,
  `type_index` int(3) NOT NULL DEFAULT 0,
  `level` int(3) NOT NULL DEFAULT 0,
  `increaseProb` int(3) NOT NULL DEFAULT 0,
  `decreaseProb` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_element_enchant_common`:
--
