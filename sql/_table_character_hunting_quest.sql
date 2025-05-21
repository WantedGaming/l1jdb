
-- --------------------------------------------------------

--
-- Table structure for table `character_hunting_quest`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_hunting_quest` (
  `id` int(10) NOT NULL DEFAULT 0,
  `objID` int(10) NOT NULL DEFAULT 0,
  `map_number` int(6) DEFAULT 0,
  `location_desc` int(3) DEFAULT 0,
  `quest_id` int(3) DEFAULT NULL,
  `kill_count` int(3) DEFAULT NULL,
  `complete` enum('true','false') DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_hunting_quest`:
--
