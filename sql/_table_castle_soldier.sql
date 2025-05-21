
-- --------------------------------------------------------

--
-- Table structure for table `castle_soldier`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `castle_soldier` (
  `castle_id` int(2) NOT NULL,
  `soldier1` int(2) NOT NULL DEFAULT 0,
  `soldier1_npcid` int(6) NOT NULL DEFAULT 0,
  `soldier1_name` varchar(10) NOT NULL,
  `soldier2` int(2) NOT NULL DEFAULT 0,
  `soldier2_npcid` int(6) NOT NULL DEFAULT 0,
  `soldier2_name` varchar(10) NOT NULL,
  `soldier3` int(2) NOT NULL DEFAULT 0,
  `soldier3_npcid` int(6) NOT NULL DEFAULT 0,
  `soldier3_name` varchar(10) NOT NULL,
  `soldier4` int(2) NOT NULL DEFAULT 0,
  `soldier4_npcid` int(6) NOT NULL DEFAULT 0,
  `soldier4_name` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `castle_soldier`:
--
