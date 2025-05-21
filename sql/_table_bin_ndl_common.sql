
-- --------------------------------------------------------

--
-- Table structure for table `bin_ndl_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_ndl_common` (
  `map_number` int(6) NOT NULL DEFAULT 0,
  `npc_classId` int(6) NOT NULL DEFAULT 0,
  `npc_desc_kr` varchar(100) DEFAULT NULL,
  `territory_startXY` int(10) NOT NULL DEFAULT 0,
  `territory_endXY` int(10) NOT NULL DEFAULT 0,
  `territory_location_desc` int(6) NOT NULL DEFAULT 0,
  `territory_average_npc_value` int(10) NOT NULL DEFAULT 0,
  `territory_average_ac` int(10) NOT NULL DEFAULT 0,
  `territory_average_level` int(10) NOT NULL DEFAULT 0,
  `territory_average_wis` int(10) NOT NULL DEFAULT 0,
  `territory_average_mr` int(10) NOT NULL DEFAULT 0,
  `territory_average_magic_barrier` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_ndl_common`:
--
