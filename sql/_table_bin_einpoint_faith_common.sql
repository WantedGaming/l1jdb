
-- --------------------------------------------------------

--
-- Table structure for table `bin_einpoint_faith_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_einpoint_faith_common` (
  `GroupId` int(3) NOT NULL DEFAULT 0,
  `spellId` int(10) NOT NULL DEFAULT 0,
  `Index_indexId` int(3) NOT NULL DEFAULT 0,
  `Index_spellId` int(10) NOT NULL DEFAULT 0,
  `Index_cost` int(10) NOT NULL DEFAULT 0,
  `Index_duration` int(10) NOT NULL DEFAULT 0,
  `Index_additional_desc` int(6) NOT NULL DEFAULT 0,
  `Index_additional_desc_kr` varchar(100) DEFAULT NULL,
  `additional_desc` int(6) NOT NULL DEFAULT 0,
  `additional_desc_kr` varchar(100) DEFAULT NULL,
  `BuffInfo_tooltipStrId` int(6) NOT NULL DEFAULT 0,
  `BuffInfo_tooltipStrId_kr` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_einpoint_faith_common`:
--
