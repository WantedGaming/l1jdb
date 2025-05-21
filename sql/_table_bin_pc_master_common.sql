
-- --------------------------------------------------------

--
-- Table structure for table `bin_pc_master_common`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_pc_master_common` (
  `utilities` text DEFAULT NULL,
  `pc_bonus_map_infos` text DEFAULT NULL,
  `notification` text DEFAULT NULL,
  `buff_group` text DEFAULT NULL,
  `buff_bonus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_pc_master_common`:
--
