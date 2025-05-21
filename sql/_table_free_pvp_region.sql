
-- --------------------------------------------------------

--
-- Table structure for table `free_pvp_region`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `free_pvp_region` (
  `worldNumber` int(6) NOT NULL DEFAULT 0,
  `desc` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `isFreePvpZone` enum('true','false') NOT NULL DEFAULT 'true',
  `box_index` int(3) NOT NULL DEFAULT 0,
  `box_sx` int(5) NOT NULL DEFAULT 0,
  `box_sy` int(5) NOT NULL DEFAULT 0,
  `box_ex` int(5) NOT NULL DEFAULT 0,
  `box_ey` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `free_pvp_region`:
--
