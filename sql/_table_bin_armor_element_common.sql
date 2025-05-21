
-- --------------------------------------------------------

--
-- Table structure for table `bin_armor_element_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_armor_element_common` (
  `type` int(2) NOT NULL DEFAULT 0,
  `enchant` int(2) NOT NULL DEFAULT 0,
  `fr` int(2) NOT NULL DEFAULT 0,
  `wr` int(2) NOT NULL DEFAULT 0,
  `ar` int(2) NOT NULL DEFAULT 0,
  `er` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_armor_element_common`:
--
