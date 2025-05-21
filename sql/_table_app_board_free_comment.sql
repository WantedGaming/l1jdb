
-- --------------------------------------------------------

--
-- Table structure for table `app_board_free_comment`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_board_free_comment` (
  `id` int(10) NOT NULL DEFAULT 0,
  `boardId` int(10) NOT NULL DEFAULT 0,
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `chaType` int(2) NOT NULL DEFAULT 0,
  `chaSex` int(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  `content` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `likenames` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_board_free_comment`:
--
