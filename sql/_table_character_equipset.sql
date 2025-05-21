
-- --------------------------------------------------------

--
-- Table structure for table `character_equipset`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_equipset` (
  `charId` int(10) NOT NULL DEFAULT 0,
  `current_set` int(1) NOT NULL DEFAULT 0,
  `slot1_item` text CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL,
  `slot2_item` text CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL,
  `slot3_item` text CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL,
  `slot4_item` text CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL,
  `slot1_name` varchar(100) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '',
  `slot2_name` varchar(100) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '',
  `slot3_name` varchar(100) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '',
  `slot4_name` varchar(100) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '',
  `slot1_color` int(2) NOT NULL DEFAULT 0,
  `slot2_color` int(2) NOT NULL DEFAULT 0,
  `slot3_color` int(2) NOT NULL DEFAULT 0,
  `slot4_color` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `character_equipset`:
--
