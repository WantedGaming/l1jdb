
-- --------------------------------------------------------

--
-- Table structure for table `bin_potential_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_potential_common` (
  `id` int(4) NOT NULL DEFAULT 0,
  `grade` int(2) NOT NULL DEFAULT 0,
  `desc_id` int(6) NOT NULL DEFAULT 0,
  `desc_kr` varchar(100) DEFAULT NULL,
  `material_list` text DEFAULT NULL,
  `event_config` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_potential_common`:
--
