
-- --------------------------------------------------------

--
-- Table structure for table `serverinfo`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `serverinfo` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `adenmake` bigint(30) DEFAULT 0,
  `adenconsume` bigint(30) DEFAULT 0,
  `adentax` int(10) DEFAULT 0,
  `bugdividend` float(10,0) DEFAULT 0,
  `accountcount` int(10) DEFAULT 0,
  `charcount` int(10) DEFAULT 0,
  `pvpcount` int(10) DEFAULT 0,
  `penaltycount` int(10) DEFAULT 0,
  `clanmaker` int(10) DEFAULT 0,
  `maxuser` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `serverinfo`:
--
