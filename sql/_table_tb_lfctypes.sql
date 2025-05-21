
-- --------------------------------------------------------

--
-- Table structure for table `tb_lfctypes`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_lfctypes` (
  `ID` int(2) NOT NULL,
  `TYPE` int(2) DEFAULT 0,
  `NAME` varchar(50) DEFAULT NULL,
  `DESC_KR` varchar(50) NOT NULL,
  `USE` int(2) DEFAULT 0,
  `BUFF_SPAWN_TIME` int(10) DEFAULT 0,
  `POSSIBLE_LEVEL` int(10) DEFAULT 0,
  `MIN_PARTY` int(10) DEFAULT 0,
  `MAX_PARTY` int(10) DEFAULT 0,
  `NEED_ITEMID` int(10) DEFAULT 0,
  `NEED_ITEMCOUNT` int(10) DEFAULT 0,
  `PLAY_INST` varchar(50) DEFAULT NULL,
  `MAPRT_LEFT` int(10) DEFAULT 0,
  `MAPRT_TOP` int(10) DEFAULT 0,
  `MAPRT_RIGHT` int(10) DEFAULT 0,
  `MAPRT_BOTTOM` int(10) DEFAULT 0,
  `MAPID` int(10) DEFAULT 0,
  `STARTPOS_REDX` int(10) DEFAULT 0,
  `STARTPOS_REDY` int(10) DEFAULT 0,
  `STARTPOS_BLUEX` int(10) DEFAULT 0,
  `STARTPOS_BLUEY` int(10) DEFAULT 0,
  `PLAYTIME` int(10) DEFAULT 0,
  `READYTIME` int(10) DEFAULT 0,
  `RAND_WINNER_RATIO` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_lfctypes`:
--
