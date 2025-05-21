
-- --------------------------------------------------------

--
-- Table structure for table `inter_race_region`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `inter_race_region` (
  `id` int(10) NOT NULL,
  `loc_x` int(10) DEFAULT NULL,
  `loc_y` int(10) DEFAULT NULL,
  `loc_mapid` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `inter_race_region`:
--
