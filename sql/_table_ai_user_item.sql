
-- --------------------------------------------------------

--
-- Table structure for table `ai_user_item`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ai_user_item` (
  `class` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') NOT NULL DEFAULT 'all',
  `itemId` int(10) NOT NULL DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `count` int(10) NOT NULL DEFAULT 1,
  `enchantLevel` int(2) NOT NULL DEFAULT 0,
  `attrLevel` int(2) NOT NULL DEFAULT 0,
  `equip` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `ai_user_item`:
--
