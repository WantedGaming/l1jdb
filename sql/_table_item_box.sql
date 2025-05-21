
-- --------------------------------------------------------

--
-- Table structure for table `item_box`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_box` (
  `boxId` int(10) NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `classType` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') NOT NULL DEFAULT 'all',
  `itemId` int(10) NOT NULL DEFAULT 0,
  `count` int(10) NOT NULL DEFAULT 1,
  `enchant` int(2) NOT NULL DEFAULT 0,
  `bless` int(3) NOT NULL DEFAULT 1,
  `attr` int(2) NOT NULL DEFAULT 0,
  `identi` enum('true','false') NOT NULL DEFAULT 'false',
  `limitTime` int(10) NOT NULL DEFAULT 0,
  `limitMaps` varchar(200) DEFAULT NULL,
  `questBox` enum('true','false') NOT NULL DEFAULT 'false',
  `effectId` int(6) NOT NULL DEFAULT 0,
  `chance` int(3) NOT NULL DEFAULT 100,
  `validateItems` text DEFAULT NULL,
  `boxDelete` enum('false','true') NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_box`:
--
