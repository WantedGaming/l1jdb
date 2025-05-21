
-- --------------------------------------------------------

--
-- Table structure for table `map_balance`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `map_balance` (
  `mapId` mediumint(5) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `damageType` enum('both','attack','magic') NOT NULL DEFAULT 'both',
  `damageValue` float NOT NULL DEFAULT 1,
  `reductionType` enum('both','attack','magic') NOT NULL DEFAULT 'both',
  `reductionValue` float NOT NULL DEFAULT 1,
  `expValue` float NOT NULL DEFAULT 1,
  `dropValue` float NOT NULL DEFAULT 1,
  `adenaValue` float NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `map_balance`:
--
