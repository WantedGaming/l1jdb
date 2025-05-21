
-- --------------------------------------------------------

--
-- Table structure for table `app_item_search`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_item_search` (
  `seq` int(11) NOT NULL,
  `item_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_keyword` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_item_search`:
--
