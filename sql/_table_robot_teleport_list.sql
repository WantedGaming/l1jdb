
-- --------------------------------------------------------

--
-- Table structure for table `robot_teleport_list`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `robot_teleport_list` (
  `id` int(10) NOT NULL,
  `x` int(10) DEFAULT NULL,
  `y` int(10) DEFAULT NULL,
  `mapid` int(10) DEFAULT NULL,
  `heading` int(1) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `isuse` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `robot_teleport_list`:
--
