
-- --------------------------------------------------------

--
-- Table structure for table `app_board_notice`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_board_notice` (
  `id` int(10) NOT NULL,
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'NULL',
  `date` datetime DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'NULL',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `readcount` int(10) DEFAULT 0,
  `type` int(1) DEFAULT 0,
  `top` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `mainImg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_board_notice`:
--
