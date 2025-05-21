
-- --------------------------------------------------------

--
-- Table structure for table `attendance_item_random`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `attendance_item_random` (
  `groupType` int(1) NOT NULL DEFAULT 0,
  `index` int(3) NOT NULL DEFAULT 0,
  `itemId` int(10) NOT NULL DEFAULT 0,
  `itemName` varchar(45) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '',
  `desc_kr` varchar(45) NOT NULL,
  `count` int(10) NOT NULL DEFAULT 1,
  `broadcast` enum('false','true') CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT 'false',
  `level` enum('1','2','3','4','5') CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `attendance_item_random`:
--
