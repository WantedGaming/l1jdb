
-- --------------------------------------------------------

--
-- Table structure for table `beginner_quest_drop`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `beginner_quest_drop` (
  `classId` int(10) NOT NULL DEFAULT 0,
  `desc` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `mainQuestId` int(3) NOT NULL DEFAULT 0,
  `mainItemNameId` int(10) NOT NULL DEFAULT 0,
  `subQuestId` int(3) NOT NULL DEFAULT 0,
  `subItemNameId` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `beginner_quest_drop`:
--
