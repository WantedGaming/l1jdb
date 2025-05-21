
-- --------------------------------------------------------

--
-- Table structure for table `monster_book`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `monster_book` (
  `monsternumber` int(10) UNSIGNED NOT NULL,
  `monstername` varchar(255) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL,
  `desc_kr` varchar(256) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL,
  `monster_id` int(10) DEFAULT NULL,
  `locx` int(10) UNSIGNED DEFAULT 0,
  `locy` int(10) UNSIGNED DEFAULT 0,
  `mapid` int(10) UNSIGNED DEFAULT 0,
  `type` int(10) DEFAULT NULL,
  `marterial` int(10) DEFAULT NULL,
  `book_step_first` int(10) DEFAULT NULL,
  `book_step_second` int(10) DEFAULT NULL,
  `book_step_third` int(10) DEFAULT NULL,
  `note` varchar(255) CHARACTER SET euckr COLLATE euckr_korean_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `monster_book`:
--
