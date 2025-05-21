
-- --------------------------------------------------------

--
-- Table structure for table `tb_monster_book`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_monster_book` (
  `npc_id` int(10) DEFAULT NULL,
  `npc_name` varchar(50) DEFAULT NULL,
  `book_id` int(10) NOT NULL DEFAULT 0,
  `book_step_first` int(10) DEFAULT NULL,
  `book_step_second` int(10) DEFAULT NULL,
  `book_step_third` int(10) DEFAULT NULL,
  `book_clear_num` int(3) DEFAULT NULL,
  `week_difficulty` int(3) DEFAULT NULL,
  `week_success_count` int(10) DEFAULT NULL,
  `tel_x` int(3) DEFAULT NULL,
  `tel_y` int(3) DEFAULT NULL,
  `tel_mapId` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_monster_book`:
--
