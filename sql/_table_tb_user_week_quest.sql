
-- --------------------------------------------------------

--
-- Table structure for table `tb_user_week_quest`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_user_week_quest` (
  `char_id` int(10) NOT NULL,
  `bookId` int(10) DEFAULT NULL,
  `difficulty` int(3) NOT NULL,
  `section` int(3) NOT NULL DEFAULT 0,
  `step` int(10) DEFAULT 0,
  `stamp` datetime DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_user_week_quest`:
--
