
-- --------------------------------------------------------

--
-- Table structure for table `droplist`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `droplist` (
  `mobId` int(6) NOT NULL DEFAULT 0,
  `mobname_kr` varchar(100) NOT NULL,
  `mobname_en` varchar(100) NOT NULL,
  `moblevel` int(10) NOT NULL DEFAULT 0,
  `itemId` int(6) NOT NULL DEFAULT 0,
  `itemname_kr` varchar(50) NOT NULL,
  `itemname_en` varchar(100) NOT NULL,
  `min` int(4) NOT NULL DEFAULT 0,
  `max` int(4) NOT NULL DEFAULT 0,
  `chance` int(8) NOT NULL DEFAULT 0,
  `Enchant` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `droplist`:
--
