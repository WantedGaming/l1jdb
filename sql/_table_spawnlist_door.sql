
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_door`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_door` (
  `id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(60) NOT NULL DEFAULT '',
  `gfxid` int(11) NOT NULL DEFAULT 0,
  `locx` int(11) NOT NULL DEFAULT 0,
  `locy` int(11) NOT NULL DEFAULT 0,
  `mapid` int(11) NOT NULL DEFAULT 0,
  `direction` int(11) NOT NULL DEFAULT 0,
  `left_edge_location` int(11) NOT NULL DEFAULT 0,
  `right_edge_location` int(11) NOT NULL DEFAULT 0,
  `hp` int(11) NOT NULL DEFAULT 0,
  `keeper` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_door`:
--
