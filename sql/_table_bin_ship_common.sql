
-- --------------------------------------------------------

--
-- Table structure for table `bin_ship_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_ship_common` (
  `id` int(2) NOT NULL DEFAULT 0,
  `dockWorld` int(6) NOT NULL DEFAULT 0,
  `shipWorld` int(6) NOT NULL DEFAULT 0,
  `ticket` int(6) NOT NULL DEFAULT 0,
  `levelLimit` int(3) NOT NULL DEFAULT 0,
  `dock_startX` int(5) NOT NULL DEFAULT 0,
  `dock_startY` int(5) NOT NULL DEFAULT 0,
  `dock_endX` int(5) NOT NULL DEFAULT 0,
  `dock_endY` int(5) NOT NULL DEFAULT 0,
  `shipLoc_x` int(5) NOT NULL DEFAULT 0,
  `shipLoc_y` int(5) NOT NULL DEFAULT 0,
  `destWorld` int(6) NOT NULL DEFAULT 0,
  `destLoc_x` int(5) NOT NULL DEFAULT 0,
  `destLoc_y` int(5) NOT NULL DEFAULT 0,
  `destLoc_range` int(3) NOT NULL DEFAULT 0,
  `schedule_day` varchar(100) DEFAULT NULL,
  `schedule_time` blob DEFAULT NULL,
  `schedule_duration` int(2) NOT NULL DEFAULT 0,
  `schedule_ship_operating_duration` int(2) NOT NULL DEFAULT 0,
  `returnWorld` int(6) NOT NULL DEFAULT 0,
  `returnLoc_x` int(5) NOT NULL DEFAULT 0,
  `returnLoc_y` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_ship_common`:
--
