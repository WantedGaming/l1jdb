
-- --------------------------------------------------------

--
-- Table structure for table `area`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `area` (
  `areaid` int(5) NOT NULL DEFAULT 0,
  `mapid` int(5) NOT NULL DEFAULT 0,
  `areaname` varchar(50) DEFAULT NULL,
  `x1` int(6) NOT NULL DEFAULT 0,
  `y1` int(6) NOT NULL DEFAULT 0,
  `x2` int(6) NOT NULL DEFAULT 0,
  `y2` int(6) NOT NULL DEFAULT 0,
  `flag` int(1) NOT NULL DEFAULT 0,
  `restart` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `area`:
--
