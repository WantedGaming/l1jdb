
-- --------------------------------------------------------

--
-- Table structure for table `bin_entermaps_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_entermaps_common` (
  `id` int(6) NOT NULL DEFAULT 0,
  `action_name` varchar(50) NOT NULL DEFAULT '',
  `number_id` int(6) NOT NULL DEFAULT 0,
  `loc_x` int(6) NOT NULL DEFAULT 0,
  `loc_y` int(6) NOT NULL DEFAULT 0,
  `loc_range` int(3) NOT NULL DEFAULT 0,
  `priority_id` int(2) NOT NULL DEFAULT 0,
  `maxUser` int(3) NOT NULL DEFAULT 0,
  `conditions` text DEFAULT NULL,
  `destinations` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_entermaps_common`:
--
