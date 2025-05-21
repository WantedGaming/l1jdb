
-- --------------------------------------------------------

--
-- Table structure for table `beginner_quest`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `beginner_quest` (
  `quest_id` int(10) NOT NULL,
  `note` varchar(45) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '',
  `desc_kr` varchar(45) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL,
  `use` enum('true','false') CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT 'true',
  `auto_complete` enum('false','true') CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT 'false',
  `fastLevel` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `beginner_quest`:
--
