
-- --------------------------------------------------------

--
-- Table structure for table `character_soldier`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_soldier` (
  `char_id` int(12) NOT NULL,
  `npc_id` int(12) NOT NULL DEFAULT 0,
  `count` int(4) NOT NULL DEFAULT 0,
  `castle_id` int(4) NOT NULL DEFAULT 0,
  `time` int(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_soldier`:
--
