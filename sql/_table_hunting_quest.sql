
-- --------------------------------------------------------

--
-- Table structure for table `hunting_quest`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `hunting_quest` (
  `area_name` varchar(50) NOT NULL DEFAULT '',
  `map_number` int(6) NOT NULL DEFAULT 0,
  `location_desc` int(6) DEFAULT NULL,
  `quest_id` int(6) NOT NULL DEFAULT 0,
  `is_use` enum('true','false') NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `hunting_quest`:
--
