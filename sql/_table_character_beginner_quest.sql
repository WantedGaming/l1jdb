
-- --------------------------------------------------------

--
-- Table structure for table `character_beginner_quest`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_beginner_quest` (
  `charId` int(10) NOT NULL DEFAULT 0,
  `info` text CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `character_beginner_quest`:
--
