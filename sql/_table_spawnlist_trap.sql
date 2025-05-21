
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_trap`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_trap` (
  `id` int(8) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `trapId` int(8) NOT NULL,
  `mapId` int(4) NOT NULL,
  `locX` int(4) NOT NULL,
  `locY` int(4) NOT NULL,
  `locRndX` int(4) NOT NULL DEFAULT 0,
  `locRndY` int(4) NOT NULL DEFAULT 0,
  `count` int(4) NOT NULL DEFAULT 1,
  `span` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_trap`:
--
